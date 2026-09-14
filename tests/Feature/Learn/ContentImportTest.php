<?php

use App\Content\ContentImporter;
use App\Enums\QuestionType;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\User;
use App\Quiz\AnswerGrader;

it('imports the bundled curriculum content idempotently', function () {
    $importer = ContentImporter::default();

    $first = $importer->import();
    $second = $importer->import();

    expect($first['topics'])->toBeGreaterThanOrEqual(6)
        ->and($second)->toBe($first)
        ->and(Subject::count())->toBe($first['subjects'])
        ->and(Topic::count())->toBe($first['topics'])
        ->and(Question::count())->toBe($first['questions']);

    $topic = Topic::where('slug', 'negative-zahlen')->firstOrFail();

    expect($topic->sort)->toBe(1)
        ->and($topic->explanation)->toContain('Zahlengerade')
        ->and($topic->notebook_entry)->toStartWith('**Negative Zahlen')
        ->and($topic->testQuestions)->toHaveCount(10)
        ->and($topic->checks)->toHaveCount(3)
        ->and($topic->explanation)->toContain('<!-- check:1 -->')
        ->and($topic->reflect_prompt)->not->toBeNull();
});

it('renders every imported topic in all three steps', function () {
    ContentImporter::default()->import();
    $user = User::factory()->create();

    Topic::with('topicArea.subject')->get()->each(function (Topic $topic) use ($user) {
        foreach (['explain', 'notebook', 'quiz'] as $step) {
            $this->actingAs($user)
                ->get(route('learn.topic', [$topic->topicArea->subject, $topic->topicArea, $topic]).'?schritt='.$step)
                ->assertOk()
                ->assertSee($topic->title);
        }
    });
});

it('has a valid grading setup for every imported question', function () {
    ContentImporter::default()->import();
    $grader = new AnswerGrader;

    Question::all()->each(function (Question $question) use ($grader) {
        $correct = match ($question->type) {
            QuestionType::SingleChoice => $question->answer['index'],
            QuestionType::MultipleChoice => $question->answer['indexes'],
            QuestionType::TrueFalse => $question->answer['value'] ? 'true' : 'false',
            QuestionType::Numeric => (string) ($question->answer['value'] ?? $question->answer['values'][0]),
            QuestionType::GapText => array_map(fn (array $gap) => (string) $gap[0], $question->answer['gaps']),
        };

        expect($grader->isCorrect($question, $correct))
            ->toBeTrue("Frage {$question->topic->slug}#{$question->key} akzeptiert ihre eigene Musterlösung nicht");
    });
});
