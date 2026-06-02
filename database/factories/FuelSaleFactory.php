<?php

namespace Database\Factories;

use App\Models\FuelSale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FuelSale>
 */
class FuelSaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => \App\Models\User::factory(),
            'total_amount' => fake()->randomFloat(2, 1000, 50000),
            'payment_method' => fake()->randomElement(['cash', 'card', 'mobile_money', 'bank_transfer']),
            'status' => 'completed',
            'sale_date' => now(),
        ];
    }
}
