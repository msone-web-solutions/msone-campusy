<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement(['Mathematik', 'Deutsch', 'Englisch', 'Physik', 'Biologie', 'Geschichte']);

        return [
            'slug' => str($name)->slug()->toString(),
            'name' => $name,
            'description' => fake()->sentence(),
            'icon' => 'academic-cap',
            'color' => 'blue',
            'grade' => 7,
            'sort' => fake()->numberBetween(1, 20),
        ];
    }
}
