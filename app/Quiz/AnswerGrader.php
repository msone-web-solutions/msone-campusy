<?php

namespace App\Quiz;

use App\Enums\QuestionType;
use App\Models\Question;

class AnswerGrader
{
    public function __construct(private NumericAnswerParser $numbers = new NumericAnswerParser) {}

    /**
     * Decide whether the given answer is correct for the question.
     */
    public function isCorrect(Question $question, mixed $given): bool
    {
        return match ($question->type) {
            QuestionType::SingleChoice => $this->gradeSingleChoice($question, $given),
            QuestionType::MultipleChoice => $this->gradeMultipleChoice($question, $given),
            QuestionType::TrueFalse => $this->gradeTrueFalse($question, $given),
            QuestionType::Numeric => $this->gradeNumeric($question, $given),
            QuestionType::GapText => $this->gradeGapText($question, $given),
        };
    }

    private function gradeSingleChoice(Question $question, mixed $given): bool
    {
        if ($given === null || $given === '') {
            return false;
        }

        return (int) $given === (int) ($question->answer['index'] ?? -1);
    }

    private function gradeMultipleChoice(Question $question, mixed $given): bool
    {
        if (! is_array($given)) {
            return false;
        }

        $expected = array_map(intval(...), $question->answer['indexes'] ?? []);
        $actual = array_map(intval(...), array_values($given));
        sort($expected);
        sort($actual);

        return $expected === $actual;
    }

    private function gradeTrueFalse(Question $question, mixed $given): bool
    {
        if ($given === null || $given === '') {
            return false;
        }

        $givenBool = filter_var($given, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        return $givenBool !== null && $givenBool === (bool) ($question->answer['value'] ?? false);
    }

    private function gradeNumeric(Question $question, mixed $given): bool
    {
        $value = $this->numbers->parse($given);

        if ($value === null) {
            return false;
        }

        $tolerance = (float) ($question->answer['tolerance'] ?? 0.001);
        $accepted = $question->answer['values'] ?? [$question->answer['value'] ?? null];

        foreach ($accepted as $candidate) {
            $expected = $this->numbers->parse($candidate);

            if ($expected !== null && abs($expected - $value) <= $tolerance) {
                return true;
            }
        }

        return false;
    }

    private function gradeGapText(Question $question, mixed $given): bool
    {
        if (! is_array($given)) {
            return false;
        }

        $gaps = $question->answer['gaps'] ?? [];

        foreach ($gaps as $index => $accepted) {
            $typed = $this->normalizeText($given[$index] ?? '');

            if ($typed === '') {
                return false;
            }

            $matches = collect((array) $accepted)
                ->map(fn (mixed $option) => $this->normalizeText((string) $option))
                ->contains($typed);

            if (! $matches) {
                // A numeric gap may also be matched by value ("0,5" vs "1/2").
                $typedNumber = $this->numbers->parse($typed);
                $numericMatch = $typedNumber !== null && collect((array) $accepted)
                    ->map(fn (mixed $option) => $this->numbers->parse((string) $option))
                    ->contains(fn (?float $expected) => $expected !== null && abs($expected - $typedNumber) <= 0.001);

                if (! $numericMatch) {
                    return false;
                }
            }
        }

        return true;
    }

    private function normalizeText(string $value): string
    {
        $value = mb_strtolower(trim($value));
        $value = str_replace(['−', '–'], '-', $value);

        return preg_replace('/\s+/', ' ', $value) ?? $value;
    }
}
