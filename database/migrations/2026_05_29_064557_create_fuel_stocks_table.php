<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fuel_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fuel_type_id')->unique()->constrained('fuel_types')->cascadeOnDelete();
            $table->decimal('quantity', 12, 3)->default(0);
            $table->decimal('reorder_level', 12, 3)->default(500);
            $table->dateTime('last_restocked_at')->nullable();
            $table->timestamps();

            $table->index(['quantity', 'reorder_level']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fuel_stocks');
    }
};
