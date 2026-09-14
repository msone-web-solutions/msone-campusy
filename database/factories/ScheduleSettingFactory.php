<?php

namespace Database\Factories;

use App\Models\ScheduleSetting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ScheduleSetting>
 */
class ScheduleSettingFactory extends Factory
{
    protected $model = ScheduleSetting::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'start_date' => now()->startOfDay(),
            'day_start' => 8 * 60,
            'blocks_per_day' => 3,
            'lesson_minutes' => 85,
            'break_minutes' => 20,
            'school_days' => [1, 2, 3, 4, 5],
            'subject_weights' => [],
        ];
    }
}
