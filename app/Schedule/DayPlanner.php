<?php

namespace App\Schedule;

use App\Models\ScheduleSetting;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\User;
use App\Review\ReviewPlanner;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

/**
 * Baut den Stundenplan eines Schultags aus dem Lernstand: die offenen Themen
 * werden in Doppelstunden gepackt, Rückstand rutscht automatisch nach vorn.
 * Zeitraster, Blockanzahl und Pausen kommen aus den ScheduleSettings.
 *
 * @phpstan-import-type Exercise from ExerciseLibrary
 * @phpstan-import-type Unit from Curriculum
 * @phpstan-import-type Pace from Curriculum
 *
 * @phpstan-type Block array{
 *     type: string,
 *     start: int,
 *     end: int,
 *     title: string,
 *     subtitle: string,
 *     icon: string,
 *     subject: ?Subject,
 *     topic: ?Topic,
 *     href: ?string,
 *     lessons: list<array{start: int, end: int, label: string}>,
 *     exercises: array<int, Exercise>,
 *     units: list<Unit>,
 *     done: bool
 * }
 */
class DayPlanner
{
    public const int WARMUP_MINUTES = 15;

    public const int COOLDOWN_MINUTES = 10;

    public function __construct(
        private ExerciseLibrary $exercises = new ExerciseLibrary,
        private ?ReviewPlanner $reviews = null,
    ) {
        $this->reviews ??= app(ReviewPlanner::class);
    }

    /**
     * @return array{
     *     date: CarbonInterface, is_school_day: bool, blocks: list<Block>, due: int,
     *     settings: ScheduleSetting, pace: Pace, week: array{goal: int, done_blocks: float, done_minutes: int, percent: int, reached: bool, topics: int},
     *     lessons_total: int, lessons_done: int, first_open: ?int, day_end: int
     * }
     */
    public function planFor(User $user, CarbonInterface $date): array
    {
        $curriculum = Curriculum::for($user);
        $settings = $curriculum->settings();
        $today = CarbonImmutable::instance($date)->startOfDay();
        $isSchoolDay = $settings->isSchoolDay($today);
        $planDate = $isSchoolDay ? $today : $this->nextSchoolDay($settings, $today);

        // Heute erledigte Blöcke bleiben sichtbar: bestandene Themen von heute zuerst,
        // dann die offenen Einheiten in Planreihenfolge.
        $doneUnits = $curriculum->passedOn($today)->map(fn (Topic $t) => [
            'topic' => $t, 'part' => 1, 'parts' => 1, 'minutes' => max(10, (int) $t->estimated_minutes), 'passed' => true, 'notebook' => true,
        ])->values()->all();
        $doneBlocks = array_map(fn (array $b) => ['done' => true] + $b, $curriculum->packBlocks($doneUnits));

        $perDay = max(1, $settings->blocks_per_day);
        $openBlocks = array_slice($curriculum->packBlocks(), 0, max(0, $perDay - count($doneBlocks)));
        $packed = array_slice(array_merge($doneBlocks, $openBlocks), 0, $perDay);

        $blocks = [];
        $t = $settings->day_start;
        $blocks[] = $this->block('warmup', $t, $t + self::WARMUP_MINUTES, 'Ankommen & Aufwärmen', 'Wasser trinken, Fenster auf, kurz dehnen – dann die tägliche Übung.', 'bx bx-sun', href: route('practice'), exercises: $this->exercises->warmup($planDate)->all());
        $t += self::WARMUP_MINUTES;

        $lessonsDone = 0;
        $firstOpen = null;
        for ($i = 0; $i < $perDay; $i++) {
            if ($i > 0) {
                $blocks[] = $this->block('break', $t, $t + $settings->break_minutes, 'Bewegungspause', $i === 1 ? 'Raus aus dem Stuhl: fünf Übungen, dann Snack und Wasser.' : 'Noch einmal Kreislauf anwerfen – der nächste Block wird leichter.', 'bx bx-run', exercises: $this->exercises->movementBreak($planDate, $i)->all());
                $t += $settings->break_minutes;
            }

            $lesson = $this->lesson($i + 1, $t, $t + $settings->lesson_minutes, $packed[$i] ?? null);
            if ($lesson['done']) {
                $lessonsDone++;
            } elseif ($firstOpen === null && $lesson['subject'] !== null) {
                $firstOpen = count($blocks);
            }
            $blocks[] = $lesson;
            $t += $settings->lesson_minutes;
        }

        $dayEnd = $t;
        $blocks[] = $this->block('cooldown', $t, $t + self::COOLDOWN_MINUTES, 'Feierabend', 'Dehnen, durchatmen, kurz zurückblicken: Was hast du heute gelernt?', 'bx bx-party', href: route('dashboard'), exercises: $this->exercises->cooldown($planDate)->all());

        return [
            'date' => $planDate,
            'is_school_day' => $isSchoolDay,
            'blocks' => $blocks,
            'due' => $this->reviews->dueCountFor($user),
            'settings' => $settings,
            'pace' => $curriculum->pace($today),
            'week' => $curriculum->weekProgress($today),
            'lessons_total' => $perDay,
            'lessons_done' => $lessonsDone,
            'first_open' => $firstOpen,
            'day_end' => $dayEnd,
        ];
    }

    private function nextSchoolDay(ScheduleSetting $settings, CarbonImmutable $from): CarbonImmutable
    {
        $d = $from;
        for ($i = 0; $i < 14; $i++) {
            $d = $d->addDay();
            if ($settings->isSchoolDay($d)) {
                return $d;
            }
        }

        return $from->next(CarbonInterface::MONDAY);
    }

    /**
     * @param  array{subject: Subject, units: list<Unit>, minutes: int, done: bool}|null  $packed
     * @return Block
     */
    private function lesson(int $nr, int $start, int $end, ?array $packed): array
    {
        $subject = $packed['subject'] ?? null;
        $units = $packed['units'] ?? [];
        $done = $packed['done'] ?? false;
        $open = collect($units)->first(fn (array $u) => ! $u['passed']);
        $topic = $open['topic'] ?? ($units[0]['topic'] ?? null);
        $half = intdiv($end - $start - ScheduleSetting::MICRO_BREAK, 2);

        $subtitle = match (true) {
            $subject === null => 'Alles erledigt – freie Lernzeit oder wiederholen.',
            $done => 'Geschafft: '.collect($units)->map(fn (array $u) => $u['topic']->title)->implode(' · '),
            count($units) === 1 && $units[0]['parts'] > 1 => $units[0]['topic']->title.' (Teil '.$units[0]['part'].' von '.$units[0]['parts'].')',
            count($units) === 1 => $units[0]['topic']->title,
            default => count($units).' Themen: '.collect($units)->map(fn (array $u) => $u['topic']->title)->implode(' · '),
        };

        return $this->block(
            'lesson',
            $start,
            $end,
            $nr.'. Doppelstunde'.($subject ? ' · '.$subject->name : ''),
            $subtitle,
            $subject ? $this->subjectIcon($subject) : 'bx bx-book-open',
            $subject,
            $topic,
            $topic ? route('learn.topic', [$topic->topicArea->subject, $topic->topicArea, $topic]) : route('practice'),
            [
                ['start' => $start, 'end' => $start + $half, 'label' => 'Erklärung & Hefteintrag'],
                ['start' => $start + $half, 'end' => $start + $half + ScheduleSetting::MICRO_BREAK, 'label' => 'Mikropause'],
                ['start' => $start + $half + ScheduleSetting::MICRO_BREAK, 'end' => $end, 'label' => 'Üben & Test'],
            ],
            $this->exercises->microBreak()->all(),
            $units,
            $done,
        );
    }

    /**
     * @param  list<array{start: int, end: int, label: string}>  $lessons
     * @param  array<int, Exercise>  $exercises
     * @param  list<Unit>  $units
     * @return Block
     */
    private function block(string $type, int $start, int $end, string $title, string $subtitle, string $icon, ?Subject $subject = null, ?Topic $topic = null, ?string $href = null, array $lessons = [], array $exercises = [], array $units = [], bool $done = false): array
    {
        return compact('type', 'start', 'end', 'title', 'subtitle', 'icon', 'subject', 'topic', 'href', 'lessons', 'exercises', 'units', 'done');
    }

    public static function subjectIcon(Subject $subject): string
    {
        return match ($subject->slug) {
            'mathematik' => 'bx bx-math',
            'chemie' => 'bx bx-test-tube',
            'informatik' => 'bx bx-code-alt',
            default => 'bx bx-book-open',
        };
    }
}
