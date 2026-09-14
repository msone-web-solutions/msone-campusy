<?php

namespace Database\Factories;

use App\Enums\QuestionType;
use App\Models\Question;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'topic_id' => Topic::factory(),
            'key' => fake()->unique()->lexify('q????'),
            'type' => QuestionType::SingleChoice,
            'prompt' => 'Was ist 2 + 3?',
            'options' => ['4', '5', '6'],
            'answer' => ['index' => 1],
            'explanation' => '2 + 3 = 5',
            'points' => 1,
            'difficulty' => 1,
            'sort' => fake()->numberBetween(1, 20),
        ];
    }

    public function numeric(string|float|int $value, float $tolerance = 0.001): static
    {
        return $this->state(fn () => [
            'type' => QuestionType::Numeric,
            'prompt' => 'Berechne.',
            'options' => null,
            'answer' => ['value' => $value, 'tolerance' => $tolerance],
        ]);
    }

    public function trueFalse(bool $value): static
    {
        return $this->state(fn () => [
            'type' => QuestionType::TrueFalse,
            'options' => null,
            'answer' => ['value' => $value],
        ]);
    }

    /**
     * @param  array<int>  $indexes
     */
    public function multipleChoice(array $indexes): static
    {
        return $this->state(fn () => [
            'type' => QuestionType::MultipleChoice,
            'options' => ['A', 'B', 'C', 'D'],
            'answer' => ['indexes' => $indexes],
        ]);
    }
}
