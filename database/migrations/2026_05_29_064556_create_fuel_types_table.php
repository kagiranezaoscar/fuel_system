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
        Schema::create('fuel_types', function (Blueprint $table) {
            $table->id();
            $table->string('fuel_name')->unique();
            $table->decimal('price_per_liter', 12, 2);
            $table->decimal('available_quantity', 12, 3)->default(0);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['fuel_name', 'available_quantity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_types');
    }
};
