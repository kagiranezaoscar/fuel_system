<?php

namespace Database\Seeders;

use App\Models\FuelStock;
use App\Models\FuelType;
use App\Models\StockMovement;
use App\Models\User;
use App\Services\FuelSaleService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'System Administrator',
                'username' => 'admin',
                'role' => 'admin',
                'phone' => '+250780000001',
                'address' => 'Gasabo District Fuel Station',
                'email_verified_at' => now(),
                'password' => Hash::make('12345'),
            ],
        );

        $customers = collect([
            ['name' => 'Aline Uwase', 'email' => 'aline@example.com', 'username' => 'aline_uwase', 'phone' => '+250780000101'],
            ['name' => 'Eric Mugisha', 'email' => 'eric@example.com', 'username' => 'eric_mugisha', 'phone' => '+250780000102'],
            ['name' => 'Grace Ineza', 'email' => 'grace@example.com', 'username' => 'grace_ineza', 'phone' => '+250780000103'],
        ])->map(fn (array $customer) => User::updateOrCreate(
            ['email' => $customer['email']],
            [
                ...$customer,
                'role' => 'customer',
                'address' => 'Gasabo District',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ],
        ));

        $fuels = collect([
            ['fuel_name' => 'Petrol Premium', 'price_per_liter' => 1650, 'available_quantity' => 9000, 'description' => 'High-performance petrol for private vehicles.'],
            ['fuel_name' => 'Diesel', 'price_per_liter' => 1580, 'available_quantity' => 12000, 'description' => 'Diesel for trucks, generators, and commercial fleets.'],
            ['fuel_name' => 'Kerosene', 'price_per_liter' => 1250, 'available_quantity' => 4200, 'description' => 'Household and utility kerosene.'],
            ['fuel_name' => 'LPG Refill', 'price_per_liter' => 1900, 'available_quantity' => 450, 'description' => 'Low-stock alert demo item.'],
        ])->map(function (array $fuel) {
            $model = FuelType::updateOrCreate(
                ['fuel_name' => $fuel['fuel_name']],
                $fuel,
            );

            FuelStock::updateOrCreate(
                ['fuel_type_id' => $model->id],
                [
                    'quantity' => $model->available_quantity,
                    'reorder_level' => 500,
                    'last_restocked_at' => now()->subDays(rand(2, 12)),
                ],
            );

            StockMovement::firstOrCreate(
                ['fuel_id' => $model->id, 'movement_type' => 'IN', 'reason' => 'Opening seeded stock'],
                ['quantity' => $model->available_quantity],
            );

            return $model;
        });

        if (\App\Models\FuelSale::count() === 0) {
            $service = app(FuelSaleService::class);
            $paymentMethods = ['cash', 'card', 'mobile_money', 'bank_transfer'];

            foreach (range(0, 13) as $day) {
                $customer = $customers->random();
                $fuel = $fuels->random();
                $liters = fake()->randomFloat(3, 8, 45);

                $service->createSale([
                    'customer_id' => $customer->id,
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'status' => 'completed',
                    'sale_date' => now()->subDays($day)->setTime(rand(7, 19), rand(0, 59)),
                    'items' => [
                        ['fuel_id' => $fuel->id, 'liters' => $liters],
                    ],
                ]);
            }

            FuelType::all()->each(function (FuelType $fuel) {
                $fuel->fuelStock()->updateOrCreate(
                    ['fuel_type_id' => $fuel->id],
                    ['quantity' => $fuel->available_quantity],
                );
            });
        }
    }
}
