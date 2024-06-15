<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'owner' => User::factory(),
            'slug' => $this->faker->slug(3),
            'category' => 'Casa',
            'description' => $this->faker->paragraph(10),
            'dormitories' => $this->faker->numberBetween($min=0, $max=10),
            'status' => $this->faker->boolean(),
        ];
    }
}
