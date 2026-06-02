<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FuelType extends Model
{
    /** @use HasFactory<\Database\Factories\FuelTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'fuel_name',
        'price_per_liter',
        'available_quantity',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'price_per_liter' => 'decimal:2',
            'available_quantity' => 'decimal:3',
        ];
    }

    public function saleDetails(): HasMany
    {
        return $this->hasMany(FuelSaleDetail::class, 'fuel_id');
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class, 'fuel_id');
    }

    public function fuelStock(): HasOne
    {
        return $this->hasOne(FuelStock::class);
    }
}
