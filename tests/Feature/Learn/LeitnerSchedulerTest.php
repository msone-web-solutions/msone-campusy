<?php

use App\Models\ReviewItem;
use App\Review\LeitnerScheduler;
use Carbon\CarbonImmutable;

it('promotes on correct answers with expanding intervals', function () {
    $scheduler = new LeitnerScheduler;
    $now = CarbonImmutable::parse('2026-09-14 10:00');
    $item = new ReviewItem(['box' => 1, 'correct_streak' => 0, 'lapses' => 0]);

    $scheduler->apply($item, true, $now);
    expect($item->box)->toBe(2)->and($item->due_at->toDateString())->toBe('2026-09-17');

    $scheduler->apply($item, true, $now);
    expect($item->box)->toBe(3)->and($item->due_at->toDateString())->toBe('2026-09-21')->and($item->correct_streak)->toBe(2);
});

it('drops to box 0 on a wrong answer and comes back tomorrow', function () {
    $scheduler = new LeitnerScheduler;
    $now = CarbonImmutable::parse('2026-09-14 10:00');
    $item = new ReviewItem(['box' => 4, 'correct_streak' => 3, 'lapses' => 0]);

    $scheduler->apply($item, false, $now);

    expect($item->box)->toBe(0)
        ->and($item->correct_streak)->toBe(0)
        ->and($item->lapses)->toBe(1)
        ->and($item->due_at->toDateString())->toBe('2026-09-15');
});

it('never exceeds the top box', function () {
    $item = new ReviewItem(['box' => LeitnerScheduler::MAX_BOX, 'correct_streak' => 9, 'lapses' => 0]);
    (new LeitnerScheduler)->apply($item, true);

    expect($item->box)->toBe(LeitnerScheduler::MAX_BOX);
});
