<?php

use App\Enums\ProgressStatus;
use App\Enums\UserRole;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\TopicArea;
use App\Models\TopicProgress;
use App\Models\User;
use App\Schedule\DayPlanner;
use App\Schedule\ExerciseLibrary;
use Carbon\CarbonImmutable;

beforeEach(function () {
    $this->user = User::factory()->create();

    foreach ([['mathematik', 'Mathematik', 1], ['chemie', 'Chemie', 2], ['informatik', 'Informatik', 3]] as [$slug, $name, $sort]) {
        $subject = Subject::factory()->create(['slug' => $slug, 'name' => $name, 'sort' => $sort]);
        $area = TopicArea::factory()->for($subject)->create(['sort' => 1]);
        Topic::factory()->for($area)->create(['sort' => 1, 'title' => $name.' Thema 1']);
        Topic::factory()->for($area)->create(['sort' => 2, 'title' => $name.' Thema 2']);
    }
});

it('builds three double lessons between 8 and 13 with breaks in between', function () {
    $plan = app(DayPlanner::class)->planFor($this->user, CarbonImmutable::parse('2026-09-14')); // Montag

    $types = array_column($plan['blocks'], 'type');
    expect($types)->toBe(['warmup', 'lesson', 'break', 'lesson', 'break', 'lesson', 'cooldown'])
        ->and($plan['is_school_day'])->toBeTrue()
        ->and($plan['blocks'][0]['start'])->toBe(8 * 60)
        ->and($plan['blocks'][5]['end'])->toBe(13 * 60);

    // Blöcke lückenlos aneinander
    foreach (array_slice($plan['blocks'], 1) as $i => $block) {
        expect($block['start'])->toBe($plan['blocks'][$i]['end']);
    }

    $lesson = $plan['blocks'][1];
    expect($lesson['lessons'])->toHaveCount(3)
        ->and($lesson['lessons'][1]['label'])->toBe('Mikropause')
        ->and($lesson['lessons'][1]['end'] - $lesson['lessons'][1]['start'])->toBe(5);
});

it('rotates the subject order per weekday', function () {
    $planner = app(DayPlanner::class);

    $monday = $planner->subjectsFor(CarbonImmutable::parse('2026-09-14'))->pluck('slug')->all();
    $tuesday = $planner->subjectsFor(CarbonImmutable::parse('2026-09-15'))->pluck('slug')->all();

    expect($monday)->toBe(['mathematik', 'chemie', 'informatik'])
        ->and($tuesday)->toBe(['chemie', 'informatik', 'mathematik']);
});

it('links each lesson to the next open topic of its subject', function () {
    $mathe = Subject::where('slug', 'mathematik')->first();
    $first = $mathe->topics()->orderBy('sort')->first();
    TopicProgress::query()->create(['user_id' => $this->user->id, 'topic_id' => $first->id, 'status' => ProgressStatus::Passed]);

    $plan = app(DayPlanner::class)->planFor($this->user, CarbonImmutable::parse('2026-09-14'));

    expect($plan['blocks'][1]['topic']->title)->toBe('Mathematik Thema 2')
        ->and($plan['blocks'][1]['href'])->toContain('/lernen/mathematik/');
});

it('shows the monday plan on weekends', function () {
    $plan = app(DayPlanner::class)->planFor($this->user, CarbonImmutable::parse('2026-09-13')); // Sonntag

    expect($plan['is_school_day'])->toBeFalse()
        ->and($plan['date']->isMonday())->toBeTrue();
});

it('picks exercises deterministically per day and mixes categories in movement breaks', function () {
    $library = new ExerciseLibrary;
    $date = CarbonImmutable::parse('2026-09-14');

    $a = $library->movementBreak($date, 1)->pluck('key')->all();
    $b = $library->movementBreak($date, 1)->pluck('key')->all();
    $other = $library->movementBreak($date, 2)->pluck('key')->all();

    expect($a)->toBe($b)->toHaveCount(5)
        ->and($a)->not->toBe($other)
        ->and($library->movementBreak($date, 1)->pluck('category')->countBy()->all())
        ->toBe([ExerciseLibrary::CARDIO => 2, ExerciseLibrary::STRENGTH => 2, ExerciseLibrary::STRETCH => 1]);
});

it('renders the school day page for students only', function () {
    $this->actingAs($this->user)
        ->get(route('school-day'))
        ->assertOk()
        ->assertSee('Dein Schultag')
        ->assertSee('Doppelstunde')
        ->assertSee('Bewegungspause');

    $parent = User::factory()->create(['role' => UserRole::Parent]);
    $this->actingAs($parent)->get(route('school-day'))->assertRedirect(route('parent.dashboard'));
});
