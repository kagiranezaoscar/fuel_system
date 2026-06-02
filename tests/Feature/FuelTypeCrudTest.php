<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FuelTypeCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_create_fuel_type(): void
    {
        $manager = User::factory()->manager()->create();

        $this->actingAs($manager)->post(route('manager.fuel-types.store'), [
            'fuel_name' => 'Petrol',
            'price_per_liter' => 1650,
            'available_quantity' => 1000,
            'description' => 'Premium fuel',
        ])->assertRedirect(route('manager.fuel-types.index'));

        $this->assertDatabaseHas('fuel_types', ['fuel_name' => 'Petrol']);
    }

    public function test_customer_cannot_manage_fuel_type(): void
    {
        $customer = User::factory()->create();

        $this->actingAs($customer)->get(route('manager.fuel-types.index'))->assertForbidden();
    }
}
