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
            'sale' => $this->faker->boolean(),
            'location' => $this->faker->boolean(),
            'sale_value' => $this->faker->numberBetween($min = 1500, $max = 6000),
            'slug' => $this->faker->slug(3),
            'category' => 'Imóvel Residencial',
            'type' => 'Casa',
            'description' => $this->faker->paragraph(10),
            'dormitories' => $this->faker->numberBetween($min=0, $max=10),
            'status' => $this->faker->boolean(),
            'views' => $this->faker->randomNumber(3),
            'zipcode' => $this->faker->randomNumber(8),
            'city' => $this->faker->city(),
            'state' => $this->faker->regionAbbr(),
            'geladeira' => $this->faker->boolean(),
            'internet' => $this->faker->boolean(),
            'quintal' => $this->faker->boolean(),
            'ventilador_teto' => $this->faker->boolean(),
        ];
    }
}
