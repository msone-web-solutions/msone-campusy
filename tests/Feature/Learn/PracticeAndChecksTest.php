<?php

use App\Enums\QuestionRole;
use App\Enums\UserRole;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\ReviewItem;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\TopicArea;
use App\Models\User;
use Livewire\Livewire;

it('runs a practice session and reschedules items', function () {
    $user = User::factory()->create();
    $topic = Topic::factory()->create();
    $q1 = Question::factory()->for($topic)->create(['key' => 'q1']);
    $q2 = Question::factory()->for($topic)->numeric(5)->create(['key' => 'q2']);
    ReviewItem::create(['user_id' => $user->id, 'question_id' => $q1->id, 'box' => 1, 'due_at' => now()->subDay()]);
    ReviewItem::create(['user_id' => $user->id, 'question_id' => $q2->id, 'box' => 1, 'due_at' => now()->subDay()]);

    $this->actingAs($user)->get(route('practice'))->assertOk()->assertSee('Aufgaben fällig');

    $component = Livewire::actingAs($user)->test('pages::practice')->call('start')->assertSet('phase', 'question');
    for ($i = 0; $i < 2; $i++) {
        $item = ReviewItem::find($component->get('itemIds')[$i]);
        $component->set('given', $item->question_id === $q1->id ? 1 : '4')->call('check')->call('next');
    }
    $component->assertSet('phase', 'result');

    expect(ReviewItem::where('question_id', $q1->id)->first()->box)->toBe(2)
        ->and(ReviewItem::where('question_id', $q2->id)->first()->box)->toBe(0);
});

it('shows the empty state when nothing is due', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('practice'))->assertOk()->assertSee('Heute ist nichts fällig');
});

it('gates explanation segments behind inline checks', function () {
    $user = User::factory()->create();
    $subject = Subject::factory()->create();
    $area = TopicArea::factory()->for($subject)->create();
    $topic = Topic::factory()->for($area)->create([
        'explanation' => "Teil eins.\n\n<!-- check:1 -->\n\nTeil zwei, geheim.",
    ]);
    $check = Question::factory()->for($topic)->create(['key' => 'c1', 'role' => QuestionRole::Check, 'segment' => 1]);

    $page = Livewire::actingAs($user)->test('pages::learn.topic', ['subject' => $subject, 'topicArea' => $area, 'topic' => $topic])
        ->assertSee('Teil eins.')
        ->assertDontSee('Teil zwei, geheim.')
        ->assertSee('Beantworte die Aufgabe oben');

    Livewire::actingAs($user)->test('inline-check', ['question' => $check])
        ->set('given', 1)->call('check')
        ->assertSet('wasCorrect', true)
        ->assertDispatched('check-answered');

    $page->dispatch('check-answered', questionId: $check->id, correct: true)
        ->assertSee('Teil zwei, geheim.');
});

it('stores confidence and self explanation on the attempt', function () {
    $user = User::factory()->create();
    $topic = Topic::factory()->create(['pass_percent' => 50]);
    Question::factory()->for($topic)->create(['key' => 'q1']);

    Livewire::actingAs($user)->test('quiz-runner', ['topic' => $topic])
        ->call('start', 3)
        ->set('given', 1)->call('check')->call('next')
        ->assertSet('phase', 'result')
        ->assertSee('Selbsteinschätzung')
        ->set('selfExplanation', 'zu kurz')->call('saveExplanation')->assertHasErrors('selfExplanation')
        ->set('selfExplanation', 'Ich habe gelernt, dass zwei plus drei fünf ergibt, weil man die Beträge addiert.')->call('saveExplanation')
        ->assertSet('explanationSaved', true);

    $attempt = QuizAttempt::first();
    expect($attempt->confidence)->toBe(3)->and($attempt->self_explanation)->toContain('fünf ergibt');
});

it('lets a student link a parent and shows the parent dashboard', function () {
    $parent = User::factory()->create(['role' => UserRole::Parent]);
    $student = User::factory()->create();

    Livewire::actingAs($student)->test('pages::settings.family')
        ->set('parentEmail', 'nobody@example.com')->call('link')->assertHasErrors('parentEmail')
        ->set('parentEmail', $parent->email)->call('link')->assertHasNoErrors();

    expect($student->fresh()->parent_id)->toBe($parent->id);

    $this->actingAs($parent)->get(route('parent.dashboard'))->assertOk()->assertSee($student->name);
    $this->actingAs($student)->get(route('parent.dashboard'))->assertForbidden();
});
