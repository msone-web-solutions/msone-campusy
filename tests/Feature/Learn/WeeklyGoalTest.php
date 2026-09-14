<?php

use App\Enums\ProgressStatus;
use App\Enums\UserRole;
use App\Models\ScheduleSetting;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\TopicArea;
use App\Models\TopicProgress;
use App\Models\User;
use App\Notifications\BacklogAlert;
use App\Schedule\Curriculum;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Notification;

beforeEach(function () {
    $this->parent = User::factory()->create(['role' => UserRole::Parent]);
    $this->child = User::factory()->create(['parent_id' => $this->parent->id, 'created_at' => '2026-09-01']);
    $area = TopicArea::factory()->for(Subject::factory()->create(['slug' => 'mathematik', 'sort' => 1]))->create();
    foreach (range(1, 10) as $i) {
        Topic::factory()->for($area)->create(['sort' => $i, 'estimated_minutes' => 40]);
    }
});

it('counts this week\'s passed topics against the weekly goal in blocks', function () {
    ScheduleSetting::factory()->for($this->child)->create(['start_date' => '2026-09-01', 'weekly_goal_blocks' => 4]); // 80-min capacity
    $topics = Topic::query()->orderBy('sort')->get();

    foreach ($topics->take(3) as $t) {
        TopicProgress::query()->create(['user_id' => $this->child->id, 'topic_id' => $t->id, 'status' => ProgressStatus::Passed, 'passed_at' => '2026-09-15 09:00']);
    }
    TopicProgress::query()->create(['user_id' => $this->child->id, 'topic_id' => $topics[5]->id, 'status' => ProgressStatus::Passed, 'passed_at' => '2026-09-11 09:00']); // Vorwoche

    $week = Curriculum::for($this->child)->weekProgress(CarbonImmutable::parse('2026-09-16'));

    expect($week['done_minutes'])->toBe(120)->and($week['done_blocks'])->toBe(1.5)->and($week['percent'])->toBe(38)->and($week['reached'])->toBeFalse()->and($week['topics'])->toBe(3);
});

it('alerts the parent once per day when the backlog reaches the threshold', function () {
    Notification::fake();
    $this->travelTo('2026-09-16 17:00');
    ScheduleSetting::factory()->for($this->child)->create(['start_date' => '2026-09-01', 'backlog_alert_blocks' => 3]);

    $this->artisan('campusy:backlog-alerts')->assertSuccessful();
    Notification::assertSentTo($this->parent, BacklogAlert::class, fn (BacklogAlert $n) => $n->child->is($this->child) && $n->pace['backlog_blocks'] >= 3);
    expect($this->child->fresh()->scheduleSetting->backlog_alerted_at)->not->toBeNull();

    $this->artisan('campusy:backlog-alerts')->assertSuccessful();
    Notification::assertSentToTimes($this->parent, BacklogAlert::class, 1);
});

it('does not alert below the threshold or when alerts are off', function () {
    Notification::fake();
    ScheduleSetting::factory()->for($this->child)->create(['start_date' => now()->toDateString(), 'backlog_alert_blocks' => 3]);
    $this->artisan('campusy:backlog-alerts')->assertSuccessful();
    Notification::assertNothingSent();

    $this->child->scheduleSetting->update(['start_date' => '2026-09-01', 'backlog_alert_blocks' => 0]);
    $this->artisan('campusy:backlog-alerts')->assertSuccessful();
    Notification::assertNothingSent();
});
