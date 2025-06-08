<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lecturer>
 */
class LecturerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lecturer_id_number' => $this->faker->randomNumber(5, true),
            'name' => $this->faker->name(),
            'email' => $this->faker->freeEmail(),
            'phone_number' => $this->faker->phoneNumber()
        ];
    }
}
