<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role_name' => $this->faker->unique()->word,
            'role_uuid' => $this->faker->unique()->uuid(),
            'description' => $this->faker->paragraph(),
            // 'active' => $this->faker->boolean(),
            "created_at" => $this->faker->date(),
            "updated_at" => $this->faker->date()
        ];
    }
}
