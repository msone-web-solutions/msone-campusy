<?php

use App\Enums\ProgressStatus;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\TopicArea;
use App\Models\TopicProgress;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->subject = Subject::factory()->create(['slug' => 'mathematik', 'name' => 'Mathematik']);
    $this->area = TopicArea::factory()->for($this->subject)->create(['slug' => 'rationale-zahlen', 'sort' => 1]);
    $this->topic = Topic::factory()->for($this->area)->create(['slug' => 'negative-zahlen', 'sort' => 1]);
});

it('requires login for the learning pages', function () {
    $this->get(route('learn.index'))->assertRedirect(route('login'));
});

it('lists subjects and topics', function () {
    $this->actingAs($this->user)
        ->get(route('learn.index'))
        ->assertOk()
        ->assertSee('Mathematik');

    $this->actingAs($this->user)
        ->get(route('learn.subject', $this->subject))
        ->assertOk()
        ->assertSee($this->topic->title);
});

it('rejects a topic that does not belong to the area', function () {
    $otherArea = TopicArea::factory()->for($this->subject)->create();

    $this->actingAs($this->user)
        ->get(route('learn.topic', [$this->subject, $otherArea, $this->topic]))
        ->assertNotFound();
});

it('creates progress when a topic is opened and records the notebook confirmation', function () {
    $this->actingAs($this->user);

    Livewire::test('pages::learn.topic', [
        'subject' => $this->subject,
        'topicArea' => $this->area,
        'topic' => $this->topic,
    ])
        ->assertSet('step', 'explain')
        ->call('goTo', 'notebook')
        ->assertSee('Ich habe alles abgeschrieben')
        ->call('confirmNotebook')
        ->assertSet('step', 'quiz');

    $progress = TopicProgress::where('user_id', $this->user->id)->where('topic_id', $this->topic->id)->firstOrFail();

    expect($progress->status)->toBe(ProgressStatus::NotebookDone)
        ->and($progress->notebook_confirmed_at)->not->toBeNull();
});

it('shows an audio player only when a narration file exists', function () {
    $this->actingAs($this->user);
    $path = public_path('audio/mathematik/rationale-zahlen/negative-zahlen.mp3');

    $response = $this->get(route('learn.topic', [$this->subject, $this->area, $this->topic]));

    file_exists($path)
        ? $response->assertSee('Erklärung anhören')
        : $response->assertDontSee('Erklärung anhören');

    $other = Topic::factory()->for($this->area)->create(['slug' => 'ohne-audio', 'sort' => 2]);
    $this->get(route('learn.topic', [$this->subject, $this->area, $other]))->assertDontSee('Erklärung anhören');
});

it('searches topics by title, notebook entry, area and subject', function () {
    $this->topic->update(['title' => 'Negative Zahlen', 'notebook_entry' => '**Zahlengerade** links von der Null']);
    Topic::factory()->for($this->area)->create(['slug' => 'brueche', 'title' => 'Brüche', 'notebook_entry' => 'Zähler und Nenner']);

    Livewire::actingAs($this->user)->test('pages::learn.index', ['q' => 'zahlengerade'])
        ->assertSee('Negative Zahlen')
        ->assertDontSee('Brüche')
        ->assertSee('1 Treffer');

    Livewire::actingAs($this->user)->test('pages::learn.index', ['q' => 'mathematik nenner'])
        ->assertSee('Brüche')
        ->assertDontSee('Negative Zahlen');

    Livewire::actingAs($this->user)->test('pages::learn.index', ['q' => 'gibtesnicht'])
        ->assertSee('Nichts gefunden')
        ->call('clear')
        ->assertSet('q', '')
        ->assertSee('Mathematik – Klasse');

    $this->area->update(['name' => 'Rationale Zahlen']);
    $this->actingAs($this->user)->get(route('learn.index', ['q' => 'Rationale']))
        ->assertOk()
        ->assertSee('Negative Zahlen');
});
