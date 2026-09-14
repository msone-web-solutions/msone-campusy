<?php

use App\Enums\ProgressStatus;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\Topic;
use App\Models\TopicProgress;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->topic = Topic::factory()->create(['pass_percent' => 70]);
    Question::factory()->for($this->topic)->create(['key' => 'q1', 'sort' => 1]); // single choice, index 1
    Question::factory()->for($this->topic)->numeric('-1/2')->create(['key' => 'q2', 'sort' => 2]);
    Question::factory()->for($this->topic)->trueFalse(false)->create(['key' => 'q3', 'sort' => 3]);
    $this->actingAs($this->user);
});


it('passes the topic when the threshold is reached', function () {
    Livewire::test('quiz-runner', ['topic' => $this->topic])
        ->call('start')
        ->set('given', 1)->call('check')->call('next')
        ->set('given', '-1/2')->call('check')->call('next')
        ->set('given', 'false')->call('check')->call('next')
        ->assertSet('phase', 'result')
        ->assertDispatched('quiz-finished')
        ->assertSee('Bestanden');

    $attempt = QuizAttempt::firstOrFail();
    $progress = TopicProgress::where('user_id', $this->user->id)->where('topic_id', $this->topic->id)->firstOrFail();

    expect($attempt->score)->toBe(3)
        ->and($attempt->passed)->toBeTrue()
        ->and($attempt->answers)->toHaveCount(3)
        ->and($progress->status)->toBe(ProgressStatus::Passed)
        ->and($progress->best_percent)->toBe(100);
});

it('does not pass the topic below the threshold but keeps the best score', function () {
    Livewire::test('quiz-runner', ['topic' => $this->topic])
        ->call('start')
        ->set('given', 1)->call('check')->call('next')
        ->set('given', '0,5')->call('check')->assertSet('wasCorrect', false)->call('next')
        ->set('given', 'true')->call('check')->call('next')
        ->assertSet('phase', 'result')
        ->assertSee('Noch nicht bestanden');

    $progress = TopicProgress::where('user_id', $this->user->id)->where('topic_id', $this->topic->id)->firstOrFail();

    expect(QuizAttempt::firstOrFail()->passed)->toBeFalse()
        ->and($progress->status)->toBe(ProgressStatus::Started)
        ->and($progress->best_percent)->toBe(33);
});

it('ignores next before the answer was checked', function () {
    Livewire::test('quiz-runner', ['topic' => $this->topic])
        ->call('start')
        ->call('next')
        ->assertSet('index', 0);
});
