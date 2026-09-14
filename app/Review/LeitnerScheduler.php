<?php

namespace App\Review;

use App\Models\ReviewItem;
use Carbon\CarbonInterface;

/**
 * Spacing schedule: a correct answer promotes the item one box up and pushes
 * the next review further out; a wrong answer drops it to box 0 and brings it
 * back tomorrow. Intervals follow the usual expanding pattern
 * (1, 3, 7, 14, 30 days) that distributed-practice research recommends.
 */
class LeitnerScheduler
{
    public const MAX_BOX = 5;

    /** @var array<int, int> box → days until next review */
    public const INTERVAL_DAYS = [0 => 1, 1 => 1, 2 => 3, 3 => 7, 4 => 14, 5 => 30];

    /** Items at or above this box count as "sicher" for mastery. */
    public const MASTERY_BOX = 3;

    public function apply(ReviewItem $item, bool $correct, ?CarbonInterface $now = null): ReviewItem
    {
        $now ??= now();

        if ($correct) {
            $item->box = min($item->box + 1, self::MAX_BOX);
            $item->correct_streak++;
        } else {
            $item->box = 0;
            $item->correct_streak = 0;
            $item->lapses++;
        }

        $item->last_reviewed_at = $now;
        $item->due_at = $now->copy()->startOfDay()->addDays(self::INTERVAL_DAYS[$item->box]);

        return $item;
    }

    /**
     * First appearance in the queue: passed-test questions start in box 1 (tomorrow),
     * questions the student got wrong start in box 0 (also tomorrow, but flagged).
     */
    public function initialDue(int $box, ?CarbonInterface $now = null): CarbonInterface
    {
        return ($now ?? now())->copy()->startOfDay()->addDays(self::INTERVAL_DAYS[$box]);
    }
}
