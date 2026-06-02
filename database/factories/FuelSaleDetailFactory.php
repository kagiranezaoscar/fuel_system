<?php

namespace Database\Factories;

use App\Models\FuelSaleDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FuelSaleDetail>
 */
class FuelSaleDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $liters = fake()->randomFloat(3, 1, 100);
        $price = fake()->randomFloat(2, 1000, 2500);

        return [
            'sale_id' => \App\Models\FuelSale::factory(),
            'fuel_id' => \App\Models\FuelType::factory(),
            'liters' => $liters,
            'price_per_liter' => $price,
            'subtotal' => round($liters * $price, 2),
        ];
    }
}
