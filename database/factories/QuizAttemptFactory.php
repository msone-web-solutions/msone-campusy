<?php

namespace Database\Factories;

use App\Models\QuizAttempt;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuizAttempt>
 */
class QuizAttemptFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'topic_id' => Topic::factory(),
            'score' => 7,
            'max_score' => 10,
            'passed' => true,
            'started_at' => now()->subMinutes(5),
            'finished_at' => now(),
        ];
    }
}
