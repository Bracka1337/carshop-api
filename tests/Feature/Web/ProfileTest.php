<?php

namespace Tests\Feature\Web;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_requires_login(): void
    {
        $this->get('/profile')->assertRedirect(route('login'));
    }

    public function test_profile_lists_the_users_orders_with_totals(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct(['price' => 100]);
        $order = $this->createOrderFor($user, [$product->id => 3]);

        $this->actingAs($user)
            ->get('/profile')
            ->assertOk()
            // 300 + 10% shipping (below 1000)
            ->assertViewHas('orders', fn ($orders) => $orders->sole()->is($order))
            ->assertSee('Total: €330.00');
    }

    public function test_a_user_can_view_their_own_order(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct(['price' => 600]);
        $order = $this->createOrderFor($user, [$product->id => 2]);

        $this->actingAs($user)
            ->get("/profile/orderdetails/{$order->id}")
            ->assertOk()
            // 1200 is above the free-shipping threshold
            ->assertViewHas('cost', ['subtotal' => 991.74, 'total' => 1200.0, 'tax' => 208.26, 'shipping' => 0.0])
            ->assertSeeInOrder(['€208.26', '€0.00', '€1,200.00']);
    }

    public function test_a_user_cannot_view_someone_elses_order(): void
    {
        $product = $this->createProduct();
        $order = $this->createOrderFor(User::factory()->create(), [$product->id => 1]);

        $this->actingAs(User::factory()->create())
            ->get("/profile/orderdetails/{$order->id}")
            ->assertNotFound();
    }

    public function test_unknown_order_is_a_404(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/profile/orderdetails/999')
            ->assertNotFound();
    }

    public function test_profile_and_order_pages_render_with_several_orders_and_lines(): void
    {
        $user = User::factory()->create();
        $first = $this->createProduct(['price' => 100]);
        $second = $this->createProduct(['price' => 200], $this->createBrand('OZ'));
        $order = $this->createOrderFor($user, [$first->id => 1, $second->id => 2]);
        $this->createOrderFor($user, [$second->id => 1, $first->id => 3]);

        $this->actingAs($user);

        $this->get('/profile')->assertOk()->assertSee('Order #'.$order->id);
        $this->get("/profile/orderdetails/{$order->id}")->assertOk()->assertSee('OZ');
    }
}
