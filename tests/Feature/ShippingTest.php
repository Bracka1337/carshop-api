<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShippingTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_and_the_saved_order_charge_the_same_shipping(): void
    {
        foreach ([300 => 30.0, 1000 => 0.0] as $price => $shipping) {
            $product = $this->createProduct(['price' => $price]);
            $user = User::factory()->create();
            $this->actingAs($user);
            session()->forget('cart');
            $this->post("/cart/add/{$product->id}");

            $this->get('/checkout')->assertViewHas('cart', fn ($cart) => (float) $cart['shipping'] === $shipping);

            $this->post('/payment', [
                'f_name' => 'Jane', 'l_name' => 'Doe', 'your_email' => 'jane@example.com',
                'country' => 'LV', 'city' => 'Riga', 'addr_line_1' => 'Brivibas iela 1',
                'phone' => '+37120000000', 'payment_method' => 'pay-on-delivery', 'delivery_method' => 'dhl',
                'm_name' => '', 'addr_line_2' => '', 'company_email' => '', 'company_name' => '', 'vat_number' => '',
            ]);

            $order = Order::where('user_id', $user->id)->sole();
            $this->assertSame($shipping, $order->costBreakdown()['shipping'], "subtotal {$price}");
        }
    }

    public function test_rate_and_threshold_come_from_config(): void
    {
        config(['shop.shipping.rate' => 0.05, 'shop.shipping.free_from' => 500]);

        $product = $this->createProduct(['price' => 400]);
        $order = $this->createOrderFor(User::factory()->create(), [$product->id => 1]);
        $this->assertSame(20.0, $order->costBreakdown()['shipping']);

        $order = $this->createOrderFor(User::factory()->create(), [$product->id => 2]);
        $this->assertSame(0.0, $order->costBreakdown()['shipping']);
    }
}
