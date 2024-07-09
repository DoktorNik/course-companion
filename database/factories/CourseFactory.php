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
            'code' => Str::random(9),
            'name' => Str::random(10),
            'duration' => 'D0',
            'prereqCreditCount' => 0,
            'prereqCreditCountMajor' => 0,
        ];
    }
}
