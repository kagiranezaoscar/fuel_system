<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_register_for_api_token(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Customer One',
            'email' => 'customer@example.com',
            'username' => 'customer_one',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertCreated()->assertJsonStructure(['user', 'token']);
        $this->assertDatabaseHas('users', ['email' => 'customer@example.com', 'role' => 'customer']);
    }

    public function test_customer_can_login_and_logout(): void
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $token = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertOk()->json('token');

        $this->withToken($token)->postJson('/api/logout')->assertOk();
    }
}
