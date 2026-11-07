<?php

namespace Tests\Feature\Web;

use App\Enums\DeliveryMethod;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
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
            'delivery_method' => 'dhl',
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
            $this->post("/cart/add/{$product->id}");
        }
    }

    public function test_checkout_requires_login(): void
    {
        $this->get('/checkout')->assertRedirect(route('login'));
        $this->post('/payment')->assertRedirect(route('login'));
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

        $this->post('/payment', $this->deliveryDetails())
            ->assertRedirect(route('main'))
            ->assertSessionMissing('cart');

        $order = Order::where('user_id', $user->id)->sole();
        $this->assertSame(OrderStatus::Processing, $order->status);
        $this->assertSame(PaymentStatus::Processing, $order->payment->status);
        $this->assertSame('Riga', str($order->deliveryDetails->addr_line_1)->afterLast(', ')->toString());
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

        $this->post('/payment', $this->deliveryDetails(['payment_method' => 'credit-card']))
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
            ->post('/payment', $this->deliveryDetails(['f_name' => 'J4ne', 'phone' => '123']))
            ->assertRedirect('/checkout')
            ->assertSessionHasErrors(['f_name', 'phone']);

        $this->assertSame(0, Order::count());
    }

    public function test_card_details_are_validated_before_charging(): void
    {
        $this->actingAs(User::factory()->create());

        $this->from('/payment-details')
            ->post('/process-payment', [
                'full_name' => 'Jane Doe',
                'card_number' => '1234',
                'expiry_date' => '01/20',
                'cvv' => '12',
            ])
            ->assertRedirect('/payment-details')
            ->assertSessionHasErrors(['card_number', 'expiry_date', 'cvv']);
    }

    public function test_placing_an_order_over_get_is_rejected(): void
    {
        $product = $this->createProduct();
        $this->actingAs(User::factory()->create());
        $this->cartWith($product);

        $this->get('/payment?'.http_build_query($this->deliveryDetails()))
            ->assertMethodNotAllowed();

        $this->assertSame(0, Order::count());
        $this->assertNotEmpty(session('cart'));
    }

    public function test_processing_a_payment_over_get_is_rejected(): void
    {
        $product = $this->createProduct();
        $this->actingAs(User::factory()->create());
        $this->cartWith($product);
        $this->post('/payment', $this->deliveryDetails(['payment_method' => 'credit-card']));

        $this->get('/process-payment?'.http_build_query([
            'full_name' => 'Jane Doe',
            'card_number' => '4242424242424242',
            'expiry_date' => '12/40',
            'cvv' => '123',
        ]))->assertMethodNotAllowed();

        $order = Order::sole();
        $this->assertSame(OrderStatus::Processing, $order->status);
        $this->assertSame(PaymentStatus::Processing, $order->payment->status);
    }

    public function test_checkout_forms_post_with_a_csrf_token(): void
    {
        $product = $this->createProduct();
        $this->actingAs(User::factory()->create());
        $this->cartWith($product);

        $this->get('/checkout')
            ->assertSee('action="'.route('proceedToPayment').'" method="POST"', false)
            ->assertSee('name="_token"', false);

        $this->post('/payment', $this->deliveryDetails(['payment_method' => 'credit-card']));

        $this->get('/payment-details')
            ->assertSee('action="'.route('processPayment').'" method="POST"', false)
            ->assertSee('name="_token"', false);
    }

    public function test_a_cart_with_products_no_longer_sold_is_rejected_without_a_partial_order(): void
    {
        $kept = $this->createProduct();
        $gone = $this->createProduct();
        $this->actingAs(User::factory()->create());
        $this->cartWith($kept);
        $this->cartWith($gone);
        $gone->delete();

        // Used to be a 500 ("Undefined array key") after the order rows were written.
        $this->from('/checkout')
            ->post('/payment', $this->deliveryDetails())
            ->assertRedirect('/checkout')
            ->assertSessionHasErrors('cart');

        $this->assertSame(0, Order::count());
        $this->assertDatabaseCount('payments', 0);
        $this->assertDatabaseCount('delivery_details', 0);
        $this->assertDatabaseCount('product_quantities', 0);
    }

    public function test_optional_delivery_fields_may_be_left_out(): void
    {
        $product = $this->createProduct();
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->cartWith($product);

        // Used to be a 500 ("Undefined array key m_name") when a client omitted the optional fields.
        $details = array_diff_key($this->deliveryDetails(), array_flip(['m_name', 'addr_line_2', 'company_email', 'company_name', 'vat_number']));

        $this->post('/payment', $details)->assertRedirect(route('main'));

        $this->assertNull(Order::where('user_id', $user->id)->sole()->deliveryDetails->m_name);
    }

    public function test_array_values_in_delivery_details_are_validation_errors(): void
    {
        $product = $this->createProduct();
        $this->actingAs(User::factory()->create());
        $this->cartWith($product);

        // Used to be a 500 (preg_match() on an array) in the AlphaOnly and PhoneNumber rules.
        $this->from('/checkout')
            ->post('/payment', $this->deliveryDetails(['f_name' => ['Jane'], 'l_name' => ['Doe'], 'phone' => ['+37120000000']]))
            ->assertRedirect('/checkout')
            ->assertSessionHasErrors(['f_name', 'l_name', 'phone']);

        $this->assertSame(0, Order::count());
    }

    public function test_an_empty_cart_does_not_create_an_order(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post('/payment', $this->deliveryDetails())->assertSessionHasErrors('cart');

        $this->assertSame(0, Order::count());
    }

    public function test_unknown_payment_and_delivery_methods_are_rejected(): void
    {
        $product = $this->createProduct();
        $this->actingAs(User::factory()->create());
        $this->cartWith($product);

        // Any string used to be accepted, and anything but "pay-on-delivery" went down the card path.
        $this->from('/checkout')
            ->post('/payment', $this->deliveryDetails(['payment_method' => 'bitcoin', 'delivery_method' => 'drone']))
            ->assertRedirect('/checkout')
            ->assertSessionHasErrors(['payment_method', 'delivery_method']);

        $this->assertSame(0, Order::count());
    }

    public function test_the_checkout_summary_formats_shipping_and_names_the_stored_delivery_options(): void
    {
        $product = $this->createProduct(['price' => 582]);
        $this->actingAs(User::factory()->create());
        $this->cartWith($product);

        $this->get('/checkout')
            ->assertOk()
            ->assertSee('$58.20')
            ->assertDontSee('$58.2<', false)
            ->assertSeeInOrder(['value="dhl"', DeliveryMethod::Dhl->getLabel(), 'value="express"', DeliveryMethod::Express->getLabel()], false)
            ->assertDontSee('require an account');
    }
}
