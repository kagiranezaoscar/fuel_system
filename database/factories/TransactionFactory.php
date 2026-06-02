<?php

namespace Database\Factories;

use App\Models\FuelSale;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'sale_id' => FuelSale::factory(),
            'customer_id' => User::factory(),
            'transaction_type' => 'fuel_sale',
            'amount' => fake()->randomFloat(2, 1000, 50000),
            'payment_method' => fake()->randomElement(['cash', 'card', 'mobile_money', 'bank_transfer']),
            'status' => 'completed',
            'transaction_date' => now(),
        ];
    }
}
