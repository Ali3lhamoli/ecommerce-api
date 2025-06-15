<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_order()
    {
        $user = User::factory()->create();

        $product = Product::factory()->create([
            'stock' => 10,
            'price' => 100,
        ]);

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/orders', [
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                ],
            ],
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'Order created successfully',
                 ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
        ]);
    }
}
