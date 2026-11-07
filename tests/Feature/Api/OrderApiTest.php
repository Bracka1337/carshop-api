<?php

namespace Tests\Feature\Api;

use App\Enums\PaymentStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OrderApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_only_see_their_own_orders(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct(['price' => 100]);
        $mine = $this->createOrderFor($user, [$product->id => 3]);
        $this->createOrderFor(User::factory()->create(), [$product->id => 1]);

        Sanctum::actingAs($user);

        $this->getJson('/api/orders')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $mine->id)
            ->assertJsonPath('data.0.payment_status', 'Processing')
            ->assertJsonPath('data.0.items.0.product_id', $product->id)
            ->assertJsonPath('data.0.items.0.quantity', 3)
            ->assertJsonPath('data.0.items.0.line_total', 300)
            // 300 + 10% shipping (below 1000)
            ->assertJsonPath('data.0.totals', [
                'subtotal' => 300,
                'tax' => 63,
                'shipping' => 30,
                'total' => 330,
            ]);
    }

    public function test_a_single_order_can_be_fetched(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct(['price' => 600]);
        $order = $this->createOrderFor($user, [$product->id => 2], PaymentStatus::Success);

        Sanctum::actingAs($user);

        $this->getJson("/api/orders/{$order->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $order->id)
            ->assertJsonPath('data.payment_status', 'Success')
            ->assertJsonPath('data.totals.shipping', 0)
            ->assertJsonPath('data.totals.total', 1200)
            ->assertJsonStructure(['data' => ['delivery' => ['method', 'payment_method', 'country']]]);
    }

    public function test_other_users_orders_are_not_found(): void
    {
        $product = $this->createProduct();
        $order = $this->createOrderFor(User::factory()->create(), [$product->id => 1]);

        Sanctum::actingAs(User::factory()->create());

        $this->getJson("/api/orders/{$order->id}")->assertNotFound();
        $this->getJson('/api/orders/999')->assertNotFound();
    }
}
