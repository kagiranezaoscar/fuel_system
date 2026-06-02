<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FuelSale extends Model
{
    /** @use HasFactory<\Database\Factories\FuelSaleFactory> */
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total_amount',
        'payment_method',
        'status',
        'sale_date',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'sale_date' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(FuelSaleDetail::class, 'sale_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'sale_id');
    }
}
