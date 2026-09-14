<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\TopicArea;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TopicArea>
 */
class TopicAreaFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->sentence(2);

        return [
            'subject_id' => Subject::factory(),
            'slug' => str($name)->slug()->toString(),
            'name' => ucfirst($name),
            'description' => fake()->sentence(),
            'sort' => fake()->numberBetween(1, 20),
        ];
    }
}
