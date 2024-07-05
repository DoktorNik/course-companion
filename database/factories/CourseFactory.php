<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'user_id' => 1,
            'courseCode' => Str::random(6),
            'elective' => 0,
            'courseDuration' => 'D0',
            'coursePrereqCredits' => 0,
            'courseName' => Str::random(25),
        ];
    }
}
