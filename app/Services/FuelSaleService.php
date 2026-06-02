<?php

namespace App\Services;

use App\Models\FuelSale;
use App\Models\FuelType;
use App\Models\StockMovement;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FuelSaleService
{
    public function createSale(array $data, ?User $customer = null): FuelSale
    {
        return DB::transaction(function () use ($data, $customer) {
            $items = collect($data['items']);
            $sale = FuelSale::create([
                'customer_id' => $data['customer_id'] ?? $customer?->id,
                'payment_method' => $data['payment_method'] ?? 'cash',
                'status' => $data['status'] ?? 'completed',
                'sale_date' => $data['sale_date'] ?? now(),
                'total_amount' => 0,
            ]);

            $total = 0;

            foreach ($items as $item) {
                $fuel = FuelType::query()->lockForUpdate()->findOrFail($item['fuel_id']);
                $liters = (float) $item['liters'];

                if ((float) $fuel->available_quantity < $liters) {
                    throw ValidationException::withMessages([
                        'items' => "Only {$fuel->available_quantity} liters of {$fuel->fuel_name} are available.",
                    ]);
                }

                $price = (float) $fuel->price_per_liter;
                $subtotal = round($liters * $price, 2);
                $total += $subtotal;

                $sale->details()->create([
                    'fuel_id' => $fuel->id,
                    'liters' => $liters,
                    'price_per_liter' => $price,
                    'subtotal' => $subtotal,
                ]);

                $fuel->decrement('available_quantity', $liters);

                StockMovement::create([
                    'fuel_id' => $fuel->id,
                    'movement_type' => 'OUT',
                    'quantity' => $liters,
                    'reason' => 'Fuel sale #'.$sale->id,
                ]);
            }

            $sale->update(['total_amount' => $total]);

            Transaction::create([
                'sale_id' => $sale->id,
                'customer_id' => $sale->customer_id,
                'transaction_type' => 'fuel_sale',
                'amount' => $total,
                'payment_method' => $sale->payment_method,
                'status' => $sale->status,
                'transaction_date' => $sale->sale_date,
            ]);

            return $sale->load(['customer', 'details.fuel']);
        });
    }
}
