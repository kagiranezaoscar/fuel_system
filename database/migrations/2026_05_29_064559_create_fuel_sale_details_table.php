<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fuel_sale_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('fuel_sales')->cascadeOnDelete();
            $table->foreignId('fuel_id')->constrained('fuel_types')->restrictOnDelete();
            $table->decimal('liters', 12, 3);
            $table->decimal('price_per_liter', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();

            $table->index(['sale_id', 'fuel_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_sale_details');
    }
};
