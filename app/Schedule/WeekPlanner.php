<?php

namespace App\Schedule;

use App\Models\Subject;
use App\Models\Topic;
use App\Models\User;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

/**
 * Wochenübersicht: vergangene Tage zeigen, was tatsächlich bestanden wurde,
 * heute und die Zukunft zeigen die Hochrechnung aus dem Lernstand.
 *
 * @phpstan-import-type PackedBlock from Curriculum
 * @phpstan-import-type Pace from Curriculum
 *
 * @phpstan-type Day array{
 *     date: CarbonInterface, is_school_day: bool, is_today: bool, is_past: bool,
 *     planned: list<PackedBlock>, passed: Collection<int, Topic>, target_blocks: int
 * }
 */
class WeekPlanner
{
    /**
     * @return array{week_start: CarbonInterface, days: list<Day>, pace: Pace, outlook: Collection<int, array{subject: Subject, total: int, passed: int, open: int, minutes_open: int, finish_date: ?CarbonImmutable}>, finish_date: ?CarbonInterface, week_progress: array{goal: int, done_blocks: float, done_minutes: int, percent: int, reached: bool, topics: int}}
     */
    public function weekFor(User $user, CarbonInterface $today, int $weekOffset = 0): array
    {
        $curriculum = Curriculum::for($user);
        $settings = $curriculum->settings();
        $today = CarbonImmutable::instance($today)->startOfDay();
        $weekStart = $today->startOfWeek()->addWeeks($weekOffset);
        $layout = $curriculum->layoutFrom($today);

        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $weekStart->addDays($i);
            $isSchoolDay = $settings->isSchoolDay($date);
            $isPast = $date->lt($today);

            $days[] = [
                'date' => $date,
                'is_school_day' => $isSchoolDay,
                'is_today' => $date->isSameDay($today),
                'is_past' => $isPast,
                'planned' => $isPast ? [] : ($layout->get($date->toDateString()) ?? []),
                'passed' => $curriculum->passedOn($date),
                'target_blocks' => $isSchoolDay && $date->gte($settings->start_date) ? $settings->blocks_per_day : 0,
            ];
        }

        $pace = $curriculum->pace($today);

        return [
            'week_start' => $weekStart,
            'days' => $days,
            'pace' => $pace,
            'outlook' => $curriculum->subjectOutlook($today),
            'finish_date' => $pace['finish_date'],
            'week_progress' => $curriculum->weekProgress($today),
        ];
    }
}
