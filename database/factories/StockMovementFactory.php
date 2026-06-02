<?php

namespace Database\Factories;

use App\Models\StockMovement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StockMovement>
 */
class StockMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fuel_id' => \App\Models\FuelType::factory(),
            'movement_type' => fake()->randomElement(['IN', 'OUT']),
            'quantity' => fake()->randomFloat(3, 1, 500),
            'reason' => fake()->sentence(),
        ];
    }
}
