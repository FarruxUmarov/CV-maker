<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'last_name' => $this->faker->lastName(),
            'first_name' => $this->faker->firstName(),
            'nt_id' => $this->faker->numberBetween(10000,99999),
            'image' => null,
            'phone' => $this->faker->regexify('\+9989[0-9]{7}'),
            'profession' => $this->faker->jobTitle(),
            'biography' => null,

        ];
    }
}