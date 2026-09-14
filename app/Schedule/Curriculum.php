<?php

namespace App\Schedule;

use App\Models\ScheduleSetting;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\TopicProgress;
use App\Models\User;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

/**
 * Lernstand-Modell hinter Stundenplan und Wochenplan.
 *
 * Soll: ab dem Startdatum an jedem Schultag `blocks_per_day` Doppelstunden Lernzeit.
 * Ist:  Lernminuten der bestandenen Themen. Die Differenz ist der Rückstand.
 * Die offenen Themen werden – nach Fächer-Gewichtung verzahnt – in Blöcke gepackt:
 * kurze Themen teilen sich eine Doppelstunde, lange werden auf mehrere verteilt.
 *
 * @phpstan-type Unit array{topic: Topic, part: int, parts: int, minutes: int, passed: bool, notebook: bool}
 * @phpstan-type PackedBlock array{subject: Subject, units: list<Unit>, minutes: int, done: bool}
 * @phpstan-type Pace array{
 *     total_minutes: int, done_minutes: int, expected_minutes: int, backlog_minutes: int,
 *     backlog_blocks: int, backlog_days: float, percent_done: int, percent_expected: int,
 *     finish_date: ?CarbonInterface, school_days_left: int, remaining_blocks: int
 * }
 */
class Curriculum
{
    private ScheduleSetting $settings;

    /** @var Collection<int, Topic> */
    private Collection $topics;

    /** @var Collection<int, TopicProgress> */
    private Collection $progress;

    public function __construct(private User $user)
    {
        $this->settings = ScheduleSetting::for($user);
        $this->topics = Topic::query()
            ->join('topic_areas', 'topic_areas.id', '=', 'topics.topic_area_id')
            ->join('subjects', 'subjects.id', '=', 'topic_areas.subject_id')
            ->orderBy('subjects.sort')->orderBy('topic_areas.sort')->orderBy('topics.sort')
            ->select('topics.*')
            ->with('topicArea.subject')
            ->get();
        $this->progress = TopicProgress::query()->where('user_id', $user->id)->get()->keyBy('topic_id');
    }

    public static function for(User $user): self
    {
        return new self($user);
    }

    public function settings(): ScheduleSetting
    {
        return $this->settings;
    }

    public function isPassed(Topic $topic): bool
    {
        return $this->progress->get($topic->id)?->status->isPassed() ?? false;
    }

    public function progressFor(Topic $topic): ?TopicProgress
    {
        return $this->progress->get($topic->id);
    }

    /**
     * Alle Themen in Lehrplan-Reihenfolge.
     *
     * @return Collection<int, Topic>
     */
    public function topics(): Collection
    {
        return $this->topics;
    }

    /**
     * Offene Themen, nach Fächer-Gewichtung verzahnt: Position im Fach geteilt durch
     * Gewicht – ein Fach mit Gewicht 2 taucht doppelt so oft auf.
     *
     * @return Collection<int, Topic>
     */
    public function remainingTopics(): Collection
    {
        $position = [];

        return $this->topics
            ->reject(fn (Topic $t) => $this->isPassed($t))
            ->map(function (Topic $t) use (&$position) {
                $subject = $t->topicArea->subject;
                $position[$subject->id] = ($position[$subject->id] ?? 0) + 1;

                return ['topic' => $t, 'key' => $position[$subject->id] / $this->settings->weightFor($subject), 'sort' => $subject->sort];
            })
            ->sortBy([['key', 'asc'], ['sort', 'asc']])
            ->pluck('topic')
            ->values();
    }

    /**
     * Offene Themen als Lerneinheiten; Themen, die länger als eine Doppelstunde
     * dauern, werden in Teile zerlegt.
     *
     * @return list<Unit>
     */
    public function remainingUnits(): array
    {
        $capacity = $this->settings->capacity();
        $units = [];

        foreach ($this->remainingTopics() as $topic) {
            $minutes = max(10, (int) $topic->estimated_minutes);
            $parts = max(1, (int) ceil($minutes / $capacity));
            $progress = $this->progressFor($topic);

            for ($part = 1; $part <= $parts; $part++) {
                $units[] = [
                    'topic' => $topic,
                    'part' => $part,
                    'parts' => $parts,
                    'minutes' => (int) round($minutes / $parts),
                    'passed' => false,
                    'notebook' => $progress?->notebook_confirmed_at !== null,
                ];
            }
        }

        return $units;
    }

    /**
     * Packt Lerneinheiten in Doppelstunden. Ein Block gehört zu einem Fach; um ihn zu
     * füllen, werden die nächsten Einheiten desselben Fachs vorgezogen, solange sie in
     * die Kapazität passen. Die Verzahnung der Fächer bleibt so auf Block-Ebene erhalten.
     *
     * @param  array<int, Unit>|null  $units
     * @return list<PackedBlock>
     */
    public function packBlocks(?array $units = null): array
    {
        $units = array_values($units ?? $this->remainingUnits());
        $capacity = $this->settings->capacity();
        $blocks = [];

        while ($units !== []) {
            $first = array_shift($units);
            $subject = $first['topic']->topicArea->subject;
            $block = ['subject' => $subject, 'units' => [$first], 'minutes' => $first['minutes'], 'done' => false];

            // Teil 2 eines geteilten Themas gehört in den nächsten Block, nicht in denselben.
            $lastTopic = $first['topic']->id;

            foreach ($units as $i => $unit) {
                if ($unit['topic']->topicArea->subject->id !== $subject->id || $unit['topic']->id === $lastTopic) {
                    continue;
                }
                if ($capacity < $block['minutes'] + $unit['minutes']) {
                    break;
                }
                $block['units'][] = $unit;
                $block['minutes'] += $unit['minutes'];
                unset($units[$i]);
            }

            $units = array_values($units);
            $blocks[] = $block;
        }

        return $blocks;
    }

    /**
     * Verteilt die gepackten Blöcke ab `$from` auf die Schultage.
     *
     * @return Collection<string, list<PackedBlock>> Datum (Y-m-d) → Blöcke
     */
    public function layoutFrom(CarbonInterface $from, ?int $maxDays = null): Collection
    {
        $blocks = $this->packBlocks();
        $perDay = max(1, $this->settings->blocks_per_day);
        $days = collect();
        $date = CarbonImmutable::instance($from)->startOfDay();
        $guard = 0;

        while ($blocks !== [] && $guard++ < 2000 && ($maxDays === null || $days->count() < $maxDays)) {
            if ($this->settings->isSchoolDay($date)) {
                $days[$date->toDateString()] = array_splice($blocks, 0, $perDay);
            }
            $date = $date->addDay();
        }

        return $days;
    }

    /**
     * Anzahl Schultage von `$from` bis `$to` (beide inklusive).
     */
    public function schoolDaysBetween(CarbonInterface $from, CarbonInterface $to): int
    {
        $from = CarbonImmutable::instance($from)->startOfDay();
        $to = CarbonImmutable::instance($to)->startOfDay();

        if ($to->lt($from)) {
            return 0;
        }

        $count = 0;
        for ($d = $from; $d->lte($to); $d = $d->addDay()) {
            if ($this->settings->isSchoolDay($d)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Soll-Ist-Vergleich zum Stichtag: „Soll“ zählt alle Schultage vor dem Stichtag
     * (der Stichtag selbst läuft noch), gedeckelt auf den Gesamtumfang.
     *
     * @return Pace
     */
    public function pace(CarbonInterface $today): array
    {
        $today = CarbonImmutable::instance($today)->startOfDay();
        $capacity = $this->settings->capacity();
        $perDay = $this->settings->minutesPerDay();

        $total = (int) $this->topics->sum(fn (Topic $t) => max(10, (int) $t->estimated_minutes));
        $done = (int) $this->topics->filter(fn (Topic $t) => $this->isPassed($t))->sum(fn (Topic $t) => max(10, (int) $t->estimated_minutes));
        $daysElapsed = $this->schoolDaysBetween($this->settings->start_date, $today->subDay());
        $expected = min($total, $daysElapsed * $perDay);
        $backlog = $expected - $done;

        $remaining = $total - $done;
        $remainingBlocks = count($this->packBlocks());
        $layout = $this->layoutFrom($today);
        $finish = $layout->isEmpty() ? null : CarbonImmutable::parse((string) $layout->keys()->last());

        return [
            'total_minutes' => $total,
            'done_minutes' => $done,
            'expected_minutes' => $expected,
            'backlog_minutes' => $backlog,
            'backlog_blocks' => $backlog > 0 ? (int) ceil($backlog / $capacity) : -(int) floor(abs($backlog) / $capacity),
            'backlog_days' => round($backlog / $perDay, 1),
            'percent_done' => $this->topics->isEmpty() ? 0 : (int) round($done * 100 / $total),
            'percent_expected' => $this->topics->isEmpty() ? 0 : (int) round($expected * 100 / $total),
            'finish_date' => $finish,
            'school_days_left' => $layout->count(),
            'remaining_blocks' => $remainingBlocks,
        ];
    }

    /**
     * Je Fach: offene Themen und voraussichtliches Abschlussdatum aus der Verteilung.
     *
     * @return Collection<int, array{subject: Subject, total: int, passed: int, open: int, minutes_open: int, finish_date: ?CarbonImmutable}>
     */
    public function subjectOutlook(CarbonInterface $today): Collection
    {
        $layout = $this->layoutFrom($today);
        $finishBySubject = [];

        foreach ($layout as $date => $blocks) {
            foreach ($blocks as $block) {
                $finishBySubject[$block['subject']->id] = $date;
            }
        }

        return $this->topics
            ->groupBy(fn (Topic $t) => $t->topicArea->subject->id)
            ->map(function (Collection $topics, int $subjectId) use ($finishBySubject) {
                /** @var Topic $firstTopic */
                $firstTopic = $topics->first();
                $subject = $firstTopic->topicArea->subject ?? throw new \LogicException('Themenfeld ohne Fach.');
                $passed = $topics->filter(fn (Topic $t) => $this->isPassed($t));

                return [
                    'subject' => $subject,
                    'total' => $topics->count(),
                    'passed' => $passed->count(),
                    'open' => $topics->count() - $passed->count(),
                    'minutes_open' => (int) $topics->reject(fn (Topic $t) => $this->isPassed($t))->sum('estimated_minutes'),
                    'finish_date' => isset($finishBySubject[$subjectId]) ? CarbonImmutable::parse($finishBySubject[$subjectId]) : null,
                ];
            })
            ->sortBy(fn (array $row) => $row['subject']->sort)
            ->values();
    }

    /**
     * Wochenziel: Lernminuten der in dieser Woche bestandenen Themen, umgerechnet in Blöcke.
     *
     * @return array{goal: int, done_blocks: float, done_minutes: int, percent: int, reached: bool, topics: int}
     */
    public function weekProgress(CarbonInterface $today): array
    {
        $weekStart = CarbonImmutable::instance($today)->startOfWeek();
        $passed = $this->progress->filter(fn (TopicProgress $p) => $p->passed_at !== null && $p->passed_at->gte($weekStart));
        $minutes = (int) $this->topics->whereIn('id', $passed->pluck('topic_id'))->sum(fn (Topic $t) => max(10, (int) $t->estimated_minutes));
        $blocks = round($minutes / $this->settings->capacity(), 1);
        $goal = $this->settings->weekly_goal_blocks;

        return [
            'goal' => $goal,
            'done_blocks' => $blocks,
            'done_minutes' => $minutes,
            'percent' => $goal > 0 ? min(100, (int) round($blocks * 100 / $goal)) : 100,
            'reached' => $goal > 0 && $blocks >= $goal,
            'topics' => $passed->count(),
        ];
    }

    /**
     * Themen, die an einem vergangenen Tag bestanden wurden.
     *
     * @return Collection<int, Topic>
     */
    public function passedOn(CarbonInterface $date): Collection
    {
        $ids = $this->progress
            ->filter(fn (TopicProgress $p) => $p->passed_at !== null && $p->passed_at->isSameDay($date))
            ->pluck('topic_id');

        return $this->topics->whereIn('id', $ids)->values();
    }
}
