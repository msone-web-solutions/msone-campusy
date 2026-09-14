<?php

namespace Database\Factories;

use App\Models\Topic;
use App\Models\TopicArea;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Topic>
 */
class TopicFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(3);

        return [
            'topic_area_id' => TopicArea::factory(),
            'slug' => str($title)->slug()->toString(),
            'title' => ucfirst($title),
            'intro' => fake()->sentence(),
            'explanation' => "## Erklärung\n\n".fake()->paragraph(),
            'notebook_entry' => '**Merke:** '.fake()->sentence(),
            'estimated_minutes' => 20,
            'pass_percent' => 70,
            'sort' => fake()->numberBetween(1, 20),
        ];
    }
}
