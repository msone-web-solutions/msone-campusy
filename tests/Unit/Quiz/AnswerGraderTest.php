<?php

use App\Enums\QuestionType;
use App\Models\Question;
use App\Quiz\AnswerGrader;

function question(QuestionType $type, array $answer, ?array $options = null, string $prompt = 'Frage'): Question
{
    return new Question([
        'type' => $type,
        'prompt' => $prompt,
        'options' => $options,
        'answer' => $answer,
    ]);
}

$grader = new AnswerGrader;

it('grades single choice by index', function () use ($grader) {
    $q = question(QuestionType::SingleChoice, ['index' => 1], ['a', 'b', 'c']);

    expect($grader->isCorrect($q, 1))->toBeTrue()
        ->and($grader->isCorrect($q, '1'))->toBeTrue()
        ->and($grader->isCorrect($q, 0))->toBeFalse()
        ->and($grader->isCorrect($q, null))->toBeFalse();
});

it('grades multiple choice regardless of order', function () use ($grader) {
    $q = question(QuestionType::MultipleChoice, ['indexes' => [0, 2]], ['a', 'b', 'c']);

    expect($grader->isCorrect($q, ['2', '0']))->toBeTrue()
        ->and($grader->isCorrect($q, [0]))->toBeFalse()
        ->and($grader->isCorrect($q, [0, 1, 2]))->toBeFalse();
});

it('grades true/false from strings', function () use ($grader) {
    $q = question(QuestionType::TrueFalse, ['value' => false]);

    expect($grader->isCorrect($q, 'false'))->toBeTrue()
        ->and($grader->isCorrect($q, 'true'))->toBeFalse()
        ->and($grader->isCorrect($q, null))->toBeFalse();
});

it('grades numeric answers with fractions, commas and tolerance', function () use ($grader) {
    $q = question(QuestionType::Numeric, ['value' => '-1/2']);

    expect($grader->isCorrect($q, '-0,5'))->toBeTrue()
        ->and($grader->isCorrect($q, '-1/2'))->toBeTrue()
        ->and($grader->isCorrect($q, '−0.5'))->toBeTrue()
        ->and($grader->isCorrect($q, '0,5'))->toBeFalse()
        ->and($grader->isCorrect($q, 'x'))->toBeFalse();
});

it('grades gap text case-insensitively and numerically', function () use ($grader) {
    $q = question(QuestionType::GapText, ['gaps' => [['positive', 'positiv'], ['-2']]], null, 'a ___ b ___');

    expect($grader->isCorrect($q, ['Positive', '−2']))->toBeTrue()
        ->and($grader->isCorrect($q, ['positiv', '-2,0']))->toBeTrue()
        ->and($grader->isCorrect($q, ['negativ', '-2']))->toBeFalse()
        ->and($grader->isCorrect($q, ['positiv']))->toBeFalse();
});
