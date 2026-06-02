<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FuelSaleDetail extends Model
{
    /** @use HasFactory<\Database\Factories\FuelSaleDetailFactory> */
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'fuel_id',
        'liters',
        'price_per_liter',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'liters' => 'decimal:3',
            'price_per_liter' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(FuelSale::class, 'sale_id');
    }

    public function fuel(): BelongsTo
    {
        return $this->belongsTo(FuelType::class, 'fuel_id');
    }
}
