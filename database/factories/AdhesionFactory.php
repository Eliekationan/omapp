<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Adhesion>
 */
class AdhesionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'second_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'telephone' => fake()->phoneNumber(),
            'nature_piece' => fake()->word,
            'numero_piece' => fake()->numberBetween(10000000, 999999999),
            'fonction' => fake()->word,
            'grade' => fake()->word,
        ];
    }
}
