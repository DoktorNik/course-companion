<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\student>
 */
class StudentFactory extends Factory
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
            'studentName' => $this->faker->name(),
            'studentNumber' => $this->faker->unique()->randomNumber([7]),
            'coursesCompleted' => str::random(10),
            'eligibleCourses' => str::random(10),
        ];
    }
}
