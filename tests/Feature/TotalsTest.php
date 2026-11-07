<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TotalsTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_and_the_saved_order_show_the_same_breakdown(): void
    {
        $product = $this->createProduct(['price' => 300]);
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get("/products/{$product->id}");

        $cart = $this->get('/checkout')->viewData('cart');

        $this->post('/payment', [
            'f_name' => 'Jane', 'l_name' => 'Doe', 'your_email' => 'jane@example.com',
            'country' => 'LV', 'city' => 'Riga', 'addr_line_1' => 'Brivibas iela 1',
            'phone' => '+37120000000', 'payment_method' => 'pay-on-delivery', 'delivery_method' => 'dhl',
        ]);
        $saved = Order::where('user_id', $user->id)->sole()->costBreakdown();

        // Prices include 21% VAT: 300 holds 52.07 VAT, not 21% of 300 (63.00).
        $this->assertSame('52.07', $cart['tax']);
        $this->assertSame('247.93', $cart['subtotal']);
        $this->assertSame((float) $cart['tax'], $saved['tax']);
        $this->assertSame((float) $cart['subtotal'], $saved['subtotal']);
        $this->assertSame((float) $cart['total'], $saved['total']);
    }

    public function test_the_order_page_lists_lines_without_vat(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrderFor($user, [$this->createProduct(['price' => 121])->id => 1]);

        $this->actingAs($user)
            ->get("/profile/orderdetails/{$order->id}")
            ->assertSee('$100.00')
            ->assertSee('$21.00');
    }
}
