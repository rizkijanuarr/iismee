<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use function PHPSTORM_META\map;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
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
            'registration_number' => $this->faker->randomNumber(5, true),
            'name' => $this->faker->name(),
            'email' => $this->faker->freeEmail(),
            'class' => $this->faker->randomElement(['A', 'B']),
            'company_id' => $this->faker->randomDigitNotNull(),
            'division' => $this->faker->jobTitle(),
            'internship_type' => $this->faker->randomElement(['Reguler', 'MSIB']),
            'date_start' => $this->faker->date(),
            'date_end' => $this->faker->date(),
        ];
    }
}
