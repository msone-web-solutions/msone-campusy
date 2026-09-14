<?php

namespace App\Quiz;

use App\Enums\QuestionType;
use App\Models\Question;

/**
 * Human-readable model answer for feedback screens and answer keys.
 */
class CorrectAnswerFormatter
{
    public function format(Question $question): string
    {
        $answer = $question->answer;

        return match ($question->type) {
            QuestionType::SingleChoice => (string) ($question->options[$answer['index']] ?? ''),
            QuestionType::MultipleChoice => implode(', ', array_map(fn (int $i) => (string) ($question->options[$i] ?? ''), $answer['indexes'] ?? [])),
            QuestionType::TrueFalse => ($answer['value'] ?? false) ? 'Wahr' : 'Falsch',
            QuestionType::Numeric => $this->number((string) ($answer['value'] ?? implode(' oder ', $answer['values'] ?? [])))
                .(isset($question->options['unit']) ? ' '.$question->options['unit'] : ''),
            QuestionType::GapText => implode(' · ', array_map(fn (array $gap) => (string) $gap[0], $answer['gaps'] ?? [])),
        };
    }

    /** "-1/2" → "−1/2", "0.75" → "0,75" */
    public function number(string $value): string
    {
        return str_replace(['.', '-'], [',', '−'], $value);
    }
}
