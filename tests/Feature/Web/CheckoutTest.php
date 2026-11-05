<?php

namespace Tests\Feature\Web;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    private function deliveryDetails(array $overrides = []): array
    {
        return [
            'f_name' => 'Jane',
            'l_name' => 'Doe',
            'your_email' => 'jane@example.com',
            'country' => 'LV',
            'city' => 'Riga',
            'addr_line_1' => 'Brivibas iela 1',
            'phone' => '+37120000000',
            'payment_method' => 'pay-on-delivery',
            'delivery_method' => 'DPD',
            // Optional inputs: the checkout form always submits them, empty.
            'm_name' => '',
            'addr_line_2' => '',
            'company_email' => '',
            'company_name' => '',
            'vat_number' => '',
            ...$overrides,
        ];
    }

    private function cartWith(Product $product, int $times = 1): void
    {
        for ($i = 0; $i < $times; $i++) {
            $this->get("/products/{$product->id}");
        }
    }

    public function test_checkout_requires_login(): void
    {
        $this->get('/checkout')->assertRedirect(route('login'));
        $this->get('/payment')->assertRedirect(route('login'));
    }

    public function test_checkout_with_an_empty_cart_redirects_to_the_shop(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/checkout')
            ->assertRedirect(route('main'));
    }

    public function test_checkout_page_shows_the_cart(): void
    {
        $product = $this->createProduct(['price' => 300]);
        $this->actingAs(User::factory()->create());
        $this->cartWith($product);

        $this->get('/checkout')
            ->assertOk()
            ->assertViewHas('cart', fn ($cart) => $cart[$product->id]['quantity'] === 1);
    }

    public function test_pay_on_delivery_creates_the_order_and_clears_the_cart(): void
    {
        $product = $this->createProduct(['price' => 300]);
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->cartWith($product, 2);

        $this->get('/payment?'.http_build_query($this->deliveryDetails()))
            ->assertRedirect(route('main'))
            ->assertSessionMissing('cart');

        $order = Order::where('user_id', $user->id)->sole();
        $this->assertSame('Processing', $order->status);
        $this->assertSame('Processing', $order->payment->status);
        $this->assertSame('Riga', str($order->delivery_details->addr_line_1)->afterLast(', ')->toString());
        $this->assertDatabaseHas('product_quantities', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    public function test_card_payment_creates_the_order_and_continues_to_payment(): void
    {
        $product = $this->createProduct(['price' => 300]);
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->cartWith($product);

        $this->get('/payment?'.http_build_query($this->deliveryDetails(['payment_method' => 'card'])))
            ->assertRedirect(route('payment-details'));

        $order = Order::where('user_id', $user->id)->sole();
        $this->assertSame($order->id, session('order_id'));
        $this->assertSame($order->payment_id, session('payment_id'));

        $this->get('/payment-details')->assertOk();
    }

    public function test_delivery_details_are_validated(): void
    {
        $product = $this->createProduct();
        $this->actingAs(User::factory()->create());
        $this->cartWith($product);

        $this->from('/checkout')
            ->get('/payment?'.http_build_query($this->deliveryDetails(['f_name' => 'J4ne', 'phone' => '123'])))
            ->assertRedirect('/checkout')
            ->assertSessionHasErrors(['f_name', 'phone']);

        $this->assertSame(0, Order::count());
    }

    public function test_card_details_are_validated_before_charging(): void
    {
        $this->actingAs(User::factory()->create());

        $this->from('/payment-details')
            ->get('/process-payment?'.http_build_query([
                'full_name' => 'Jane Doe',
                'card_number' => '1234',
                'expiry_date' => '01/20',
                'cvv' => '12',
            ]))
            ->assertRedirect('/payment-details')
            ->assertSessionHasErrors(['card_number', 'expiry_date', 'cvv']);
    }
}
