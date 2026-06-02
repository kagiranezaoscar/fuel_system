<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('fuel_sales')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('transaction_type')->default('fuel_sale')->index();
            $table->decimal('amount', 12, 2);
            $table->string('payment_method')->index();
            $table->string('status')->default('completed')->index();
            $table->dateTime('transaction_date')->index();
            $table->timestamps();

            $table->index(['customer_id', 'transaction_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
