<?php

use App\Enums\ProgressStatus;
use App\Enums\UserRole;
use App\Models\ScheduleSetting;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\TopicArea;
use App\Models\TopicProgress;
use App\Models\User;
use App\Schedule\Curriculum;
use App\Schedule\DayPlanner;
use App\Schedule\ExerciseLibrary;
use App\Schedule\WeekPlanner;
use Carbon\CarbonImmutable;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create(['created_at' => '2026-09-07']);

    foreach ([['mathematik', 'Mathematik', 1], ['chemie', 'Chemie', 2], ['informatik', 'Informatik', 3]] as [$slug, $name, $sort]) {
        $subject = Subject::factory()->create(['slug' => $slug, 'name' => $name, 'sort' => $sort]);
        $area = TopicArea::factory()->for($subject)->create(['sort' => 1]);
        foreach ([1, 2, 3, 4] as $i) {
            Topic::factory()->for($area)->create(['sort' => $i, 'title' => $name.' Thema '.$i, 'estimated_minutes' => 30]);
        }
    }
});

function passTopic(User $user, Topic $topic, string $at): void
{
    TopicProgress::query()->create([
        'user_id' => $user->id, 'topic_id' => $topic->id, 'status' => ProgressStatus::Passed,
        'passed_at' => $at, 'notebook_confirmed_at' => $at,
    ]);
}

it('builds the day from settings: lessons, breaks and times', function () {
    ScheduleSetting::factory()->for($this->user)->create(['start_date' => '2026-09-07', 'day_start' => 9 * 60, 'blocks_per_day' => 2, 'lesson_minutes' => 60, 'break_minutes' => 10]);

    $plan = app(DayPlanner::class)->planFor($this->user, CarbonImmutable::parse('2026-09-14'));

    expect(array_column($plan['blocks'], 'type'))->toBe(['warmup', 'lesson', 'break', 'lesson', 'cooldown'])
        ->and($plan['blocks'][0]['start'])->toBe(9 * 60)
        ->and($plan['blocks'][1]['start'])->toBe(9 * 60 + 15)
        ->and($plan['blocks'][1]['end'])->toBe(9 * 60 + 75)
        ->and($plan['blocks'][2]['end'] - $plan['blocks'][2]['start'])->toBe(10)
        ->and($plan['day_end'])->toBe(9 * 60 + 15 + 60 + 10 + 60);

    foreach (array_slice($plan['blocks'], 1) as $i => $block) {
        expect($block['start'])->toBe($plan['blocks'][$i]['end']);
    }
});

it('packs short topics of one subject into a shared block and splits long ones', function () {
    $curriculum = Curriculum::for($this->user);
    $blocks = $curriculum->packBlocks();

    // 30-min topics, 80-min capacity → two per block, never mixed subjects
    expect($blocks[0]['units'])->toHaveCount(2)
        ->and($blocks[0]['units'][0]['topic']->title)->toBe('Mathematik Thema 1')
        ->and($blocks[0]['units'][1]['topic']->title)->toBe('Mathematik Thema 2')
        ->and(collect($blocks)->every(fn ($b) => collect($b['units'])->pluck('topic.topicArea.subject.id')->unique()->count() === 1))->toBeTrue();

    Topic::query()->where('title', 'Chemie Thema 1')->update(['estimated_minutes' => 150]);
    $units = collect(Curriculum::for($this->user)->remainingUnits())->filter(fn ($u) => $u['topic']->title === 'Chemie Thema 1')->values();
    expect($units)->toHaveCount(2)->and($units[0]['parts'])->toBe(2)->and($units[1]['part'])->toBe(2);
});

it('interleaves subjects by weight', function () {
    ScheduleSetting::factory()->for($this->user)->create(['start_date' => '2026-09-07', 'subject_weights' => ['mathematik' => 2]]);

    $order = Curriculum::for($this->user)->remainingTopics()->take(6)->pluck('title')->all();

    expect($order)->toBe(['Mathematik Thema 1', 'Mathematik Thema 2', 'Chemie Thema 1', 'Informatik Thema 1', 'Mathematik Thema 3', 'Mathematik Thema 4']);
});

it('measures backlog against the expected pace and projects the finish date', function () {
    ScheduleSetting::factory()->for($this->user)->create(['start_date' => '2026-09-07', 'blocks_per_day' => 2, 'lesson_minutes' => 65]); // 60-min capacity, 120 min/day
    $today = CarbonImmutable::parse('2026-09-10'); // Do: Mo–Mi = 3 Schultage → Soll 360 min

    $pace = Curriculum::for($this->user)->pace($today);
    expect($pace['expected_minutes'])->toBe(360)->and($pace['done_minutes'])->toBe(0)->and($pace['backlog_blocks'])->toBe(6)->and($pace['backlog_days'])->toBe(3.0);

    foreach (Topic::query()->orderBy('id')->take(12)->get() as $topic) {
        passTopic($this->user, $topic, '2026-09-09 10:00');
    }
    $pace = Curriculum::for($this->user)->pace($today);
    expect($pace['done_minutes'])->toBe(360)->and($pace['backlog_blocks'])->toBe(0)->and($pace['finish_date'])->toBeNull()->and($pace['remaining_blocks'])->toBe(0);
});

it('keeps passed topics done regardless of the clock and lets open ones slide forward', function () {
    ScheduleSetting::factory()->for($this->user)->create(['start_date' => '2026-09-07']);
    $today = CarbonImmutable::parse('2026-09-14');
    passTopic($this->user, Topic::query()->where('title', 'Mathematik Thema 1')->first(), '2026-09-14 08:30');
    passTopic($this->user, Topic::query()->where('title', 'Mathematik Thema 2')->first(), '2026-09-14 09:10');

    $plan = app(DayPlanner::class)->planFor($this->user, $today);
    $lessons = array_values(array_filter($plan['blocks'], fn ($b) => $b['type'] === 'lesson'));

    expect($plan['lessons_done'])->toBe(1)
        ->and($lessons[0]['done'])->toBeTrue()
        ->and($lessons[1]['done'])->toBeFalse()
        ->and($lessons[1]['units'][0]['topic']->title)->toBe('Mathematik Thema 3')
        ->and($plan['first_open'])->toBe(array_search($lessons[1], $plan['blocks'], true));
});

it('shows the next school day when today is free', function () {
    ScheduleSetting::factory()->for($this->user)->create(['start_date' => '2026-09-07', 'school_days' => [1, 3, 5]]);

    $plan = app(DayPlanner::class)->planFor($this->user, CarbonImmutable::parse('2026-09-15')); // Di

    expect($plan['is_school_day'])->toBeFalse()->and($plan['date']->isWednesday())->toBeTrue();
});

it('builds a week with actuals for past days and projections ahead', function () {
    ScheduleSetting::factory()->for($this->user)->create(['start_date' => '2026-09-07', 'blocks_per_day' => 1]);
    passTopic($this->user, Topic::query()->where('title', 'Mathematik Thema 1')->first(), '2026-09-14 09:00');

    $week = app(WeekPlanner::class)->weekFor($this->user, CarbonImmutable::parse('2026-09-16'), 0);

    expect($week['days'][0]['is_past'])->toBeTrue()
        ->and($week['days'][0]['passed']->pluck('title')->all())->toBe(['Mathematik Thema 1'])
        ->and($week['days'][1]['passed'])->toBeEmpty()
        ->and($week['days'][2]['is_today'])->toBeTrue()
        ->and($week['days'][2]['planned'])->toHaveCount(1)
        ->and($week['days'][5]['is_school_day'])->toBeFalse()
        ->and($week['outlook']->firstWhere('subject.slug', 'mathematik')['open'])->toBe(3)
        ->and($week['finish_date'])->not->toBeNull();
});

it('picks exercises deterministically per day and mixes categories in movement breaks', function () {
    $library = new ExerciseLibrary;
    $date = CarbonImmutable::parse('2026-09-14');

    $a = $library->movementBreak($date, 1)->pluck('key')->all();
    expect($a)->toBe($library->movementBreak($date, 1)->pluck('key')->all())->toHaveCount(5)
        ->and($a)->not->toBe($library->movementBreak($date, 2)->pluck('key')->all())
        ->and($library->movementBreak($date, 1)->pluck('category')->countBy()->all())
        ->toBe([ExerciseLibrary::CARDIO => 2, ExerciseLibrary::STRENGTH => 2, ExerciseLibrary::STRETCH => 1]);
});

it('renders school day and week plan for students only', function () {
    $this->actingAs($this->user)->get(route('school-day'))->assertOk()->assertSee('Dein Schultag')->assertSee('Lernstand');
    $this->actingAs($this->user)->get(route('week-plan'))->assertOk()->assertSee('Wochenplan')->assertSee('Wann bist du fertig?');

    $parent = User::factory()->create(['role' => UserRole::Parent]);
    $this->actingAs($parent)->get(route('school-day'))->assertRedirect(route('parent.dashboard'));
    $this->actingAs($parent)->get(route('week-plan'))->assertRedirect(route('parent.dashboard'));
});

it('lets a parent configure the schedule of their own child only', function () {
    $parent = User::factory()->create(['role' => UserRole::Parent]);
    $this->user->update(['parent_id' => $parent->id]);
    $stranger = User::factory()->create();

    $this->actingAs($parent)->get(route('parent.schedule', $this->user))->assertOk()->assertSee('Stundenplan für');
    $this->actingAs($parent)->get(route('parent.schedule', $stranger))->assertNotFound();
    $this->actingAs($this->user)->get(route('parent.schedule', $this->user))->assertRedirect(route('dashboard'));

    Livewire::actingAs($parent)
        ->test('pages::parent-schedule', ['child' => $this->user])
        ->set('day_start', '09:30')
        ->set('blocks_per_day', 2)
        ->set('school_days', [1, 2, 3])
        ->set('subject_weights.mathematik', 2)
        ->call('save')
        ->assertHasNoErrors();

    $settings = $this->user->fresh()->scheduleSetting;
    expect($settings->day_start)->toBe(9 * 60 + 30)
        ->and($settings->blocks_per_day)->toBe(2)
        ->and($settings->school_days)->toBe([1, 2, 3])
        ->and($settings->subject_weights['mathematik'])->toBe(2);
});
