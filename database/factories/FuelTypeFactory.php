<?php

namespace Database\Factories;

use App\Models\FuelType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FuelType>
 */
class FuelTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fuel_name' => fake()->unique()->word().' fuel',
            'price_per_liter' => fake()->randomFloat(2, 1000, 2500),
            'available_quantity' => fake()->randomFloat(3, 500, 10000),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
