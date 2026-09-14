<?php

namespace App\Schedule;

use App\Enums\ProgressStatus;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\User;
use App\Review\ReviewPlanner;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

/**
 * Baut den Stundenplan eines Schultags: drei Doppelstunden von 8 bis 13 Uhr,
 * dazwischen Bewegungspausen mit Sport- und Dehnübungen für zu Hause.
 *
 * @phpstan-import-type Exercise from ExerciseLibrary
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
 *     exercises: array<int, Exercise>
 * }
 */
class DayPlanner
{
    public const int DAY_START = 8 * 60;

    public const int DAY_END = 13 * 60;

    public function __construct(
        private ExerciseLibrary $exercises = new ExerciseLibrary,
        private ?ReviewPlanner $reviews = null,
    ) {
        $this->reviews ??= app(ReviewPlanner::class);
    }

    /**
     * @return array{date: CarbonInterface, is_school_day: bool, blocks: list<Block>, due: int}
     */
    public function planFor(User $user, CarbonInterface $date): array
    {
        $isSchoolDay = $date->isWeekday();
        $planDate = $isSchoolDay ? $date : $date->next(CarbonInterface::MONDAY);
        $subjects = $this->subjectsFor($planDate);

        $blocks = [];
        $blocks[] = $this->block('warmup', 8 * 60, 8 * 60 + 15, 'Ankommen & Aufwärmen', 'Wasser trinken, Fenster auf, kurz dehnen – dann die tägliche Übung.', 'bx bx-sun', href: route('practice'), exercises: $this->exercises->warmup($planDate)->all());
        $blocks[] = $this->lesson(1, 8 * 60 + 15, 9 * 60 + 40, $subjects->get(0), $user);
        $blocks[] = $this->block('break', 9 * 60 + 40, 10 * 60, 'Bewegungspause', 'Raus aus dem Stuhl: fünf Übungen, dann Snack und Wasser.', 'bx bx-run', exercises: $this->exercises->movementBreak($planDate, 1)->all());
        $blocks[] = $this->lesson(2, 10 * 60, 11 * 60 + 25, $subjects->get(1), $user);
        $blocks[] = $this->block('break', 11 * 60 + 25, 11 * 60 + 45, 'Bewegungspause', 'Noch einmal Kreislauf anwerfen – der letzte Block wird leichter.', 'bx bx-run', exercises: $this->exercises->movementBreak($planDate, 2)->all());
        $blocks[] = $this->lesson(3, 11 * 60 + 45, 13 * 60, $subjects->get(2), $user);
        $blocks[] = $this->block('cooldown', 13 * 60, 13 * 60 + 10, 'Feierabend', 'Dehnen, durchatmen, kurz zurückblicken: Was hast du heute gelernt?', 'bx bx-party', href: route('dashboard'), exercises: $this->exercises->cooldown($planDate)->all());

        return [
            'date' => $planDate,
            'is_school_day' => $isSchoolDay,
            'blocks' => $blocks,
            'due' => $this->reviews->dueCountFor($user),
        ];
    }

    /**
     * Fächer-Rotation: jeder Wochentag beginnt mit einem anderen Fach, damit
     * kein Fach immer in der müden dritten Doppelstunde landet (Interleaving).
     *
     * @return Collection<int, Subject>
     */
    public function subjectsFor(CarbonInterface $date): Collection
    {
        $subjects = Subject::query()->orderBy('sort')->get();

        if ($subjects->isEmpty()) {
            return $subjects;
        }

        $offset = ($date->dayOfWeekIso - 1) % $subjects->count();

        return collect(range(0, 2))->map(fn (int $i) => $subjects->get(($i + $offset) % $subjects->count()));
    }

    /**
     * Nächstes noch nicht bestandenes Thema des Fachs in Lehrplan-Reihenfolge.
     */
    public function nextTopicFor(User $user, Subject $subject): ?Topic
    {
        return Topic::query()
            ->whereHas('topicArea', fn ($q) => $q->where('subject_id', $subject->id))
            ->whereDoesntHave('progress', fn ($q) => $q->where('user_id', $user->id)->whereIn('status', [ProgressStatus::Passed, ProgressStatus::Mastered]))
            ->join('topic_areas', 'topic_areas.id', '=', 'topics.topic_area_id')
            ->orderBy('topic_areas.sort')
            ->orderBy('topics.sort')
            ->select('topics.*')
            ->with('topicArea.subject')
            ->first();
    }

    /**
     * @return Block
     */
    private function lesson(int $nr, int $start, int $end, ?Subject $subject, User $user): array
    {
        $topic = $subject ? $this->nextTopicFor($user, $subject) : null;
        $half = intdiv($end - $start - 5, 2);

        return $this->block(
            'lesson',
            $start,
            $end,
            $nr.'. Doppelstunde'.($subject ? ' · '.$subject->name : ''),
            $topic ? $topic->title : ($subject ? 'Alles bestanden – heute wiederholen und festigen.' : 'Freie Lernzeit'),
            $subject ? $this->subjectIcon($subject) : 'bx bx-book-open',
            $subject,
            $topic,
            $topic ? route('learn.topic', [$topic->topicArea->subject, $topic->topicArea, $topic]) : ($subject ? route('learn.subject', $subject) : route('learn.index')),
            [
                ['start' => $start, 'end' => $start + $half, 'label' => 'Erklärung & Hefteintrag'],
                ['start' => $start + $half, 'end' => $start + $half + 5, 'label' => 'Mikropause'],
                ['start' => $start + $half + 5, 'end' => $end, 'label' => 'Üben & Test'],
            ],
            $this->exercises->microBreak()->all(),
        );
    }

    /**
     * @param  list<array{start: int, end: int, label: string}>  $lessons
     * @param  array<int, Exercise>  $exercises
     * @return Block
     */
    private function block(string $type, int $start, int $end, string $title, string $subtitle, string $icon, ?Subject $subject = null, ?Topic $topic = null, ?string $href = null, array $lessons = [], array $exercises = []): array
    {
        return compact('type', 'start', 'end', 'title', 'subtitle', 'icon', 'subject', 'topic', 'href', 'lessons', 'exercises');
    }

    private function subjectIcon(Subject $subject): string
    {
        return match ($subject->slug) {
            'mathematik' => 'bx bx-math',
            'chemie' => 'bx bx-test-tube',
            'informatik' => 'bx bx-code-alt',
            default => 'bx bx-book-open',
        };
    }
}
