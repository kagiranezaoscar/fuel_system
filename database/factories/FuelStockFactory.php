<?php

namespace Database\Factories;

use App\Models\FuelStock;
use App\Models\FuelType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FuelStock>
 */
class FuelStockFactory extends Factory
{
    public function definition(): array
    {
        return [
            'fuel_type_id' => FuelType::factory(),
            'quantity' => fake()->randomFloat(3, 500, 10000),
            'reorder_level' => fake()->randomFloat(3, 300, 1000),
            'last_restocked_at' => now()->subDays(fake()->numberBetween(1, 20)),
        ];
    }
}
