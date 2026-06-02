<?php

namespace Database\Factories;

use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'report_type' => fake()->randomElement(['daily_sales', 'monthly_revenue', 'fuel_stock', 'transactions']),
            'generated_by' => \App\Models\User::factory()->manager(),
            'generated_at' => now(),
        ];
    }
}
