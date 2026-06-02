<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FuelStock extends Model
{
    /** @use HasFactory<\Database\Factories\FuelStockFactory> */
    use HasFactory;

    protected $fillable = [
        'fuel_type_id',
        'quantity',
        'reorder_level',
        'last_restocked_at',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:3',
            'reorder_level' => 'decimal:3',
            'last_restocked_at' => 'datetime',
        ];
    }

    public function fuelType(): BelongsTo
    {
        return $this->belongsTo(FuelType::class);
    }
}
