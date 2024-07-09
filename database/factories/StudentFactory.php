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
            'name' => $this->faker->name(),
            'number' => $this->faker->unique()->randomNumber(7),
            'major' => "COSC",
            'creditsCompleted' => 0,
            'creditsCompletedMajor' => 0,
        ];
    }
}
