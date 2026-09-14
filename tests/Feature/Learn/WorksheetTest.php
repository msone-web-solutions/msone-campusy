<?php

use App\Models\Question;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\TopicArea;
use App\Models\User;

it('downloads a worksheet pdf for a topic', function () {
    $user = User::factory()->create();
    $subject = Subject::factory()->create(['slug' => 'mathematik']);
    $area = TopicArea::factory()->for($subject)->create(['slug' => 'rationale-zahlen', 'sort' => 1]);
    $topic = Topic::factory()->for($area)->create(['slug' => 'negative-zahlen', 'sort' => 1, 'title' => 'Negative Zahlen']);
    Question::factory()->for($topic)->create(['key' => 'q1', 'prompt' => 'Was ist −3 + 5?']);
    Question::factory()->for($topic)->numeric('-1/2')->create(['key' => 'q2', 'prompt' => 'Berechne: −3/4 + 1/4', 'options' => ['unit' => '°C']]);
    Question::factory()->for($topic)->trueFalse(true)->create(['key' => 'q3', 'prompt' => '−9 < −2']);

    $response = $this->actingAs($user)->get(route('learn.topic.worksheet', [$subject, $area, $topic]));

    $response->assertOk()
        ->assertHeader('content-type', 'application/pdf')
        ->assertDownload('probearbeit-1-1-negative-zahlen.pdf');

    expect($response->getContent())->toStartWith('%PDF');
});

it('requires login for the worksheet', function () {
    $subject = Subject::factory()->create(['slug' => 'mathematik']);
    $area = TopicArea::factory()->for($subject)->create();
    $topic = Topic::factory()->for($area)->create();

    $this->get(route('learn.topic.worksheet', [$subject, $area, $topic]))->assertRedirect(route('login'));
});
