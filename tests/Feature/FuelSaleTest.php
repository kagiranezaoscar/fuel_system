<?php

namespace Tests\Feature;

use App\Models\FuelType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FuelSaleTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_sale_reduces_stock_and_records_total(): void
    {
        $manager = User::factory()->manager()->create();
        $fuel = FuelType::factory()->create(['price_per_liter' => 1500, 'available_quantity' => 100]);

        $this->actingAs($manager)->post(route('manager.sales.store'), [
            'payment_method' => 'cash',
            'status' => 'completed',
            'items' => [['fuel_id' => $fuel->id, 'liters' => 10]],
        ])->assertRedirect();

        $this->assertDatabaseHas('fuel_sales', ['total_amount' => 15000]);
        $this->assertEquals('90.000', $fuel->fresh()->available_quantity);
        $this->assertDatabaseHas('stock_movements', ['fuel_id' => $fuel->id, 'movement_type' => 'OUT', 'quantity' => 10]);
    }

    public function test_sale_cannot_exceed_available_stock(): void
    {
        $manager = User::factory()->manager()->create();
        $fuel = FuelType::factory()->create(['available_quantity' => 5]);

        $this->actingAs($manager)->post(route('manager.sales.store'), [
            'payment_method' => 'cash',
            'status' => 'completed',
            'items' => [['fuel_id' => $fuel->id, 'liters' => 10]],
        ])->assertSessionHasErrors();

        $this->assertEquals('5.000', $fuel->fresh()->available_quantity);
    }
}
