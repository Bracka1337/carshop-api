<?php

namespace Tests\Feature\Web;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CardPaymentTest extends TestCase
{
    use RefreshDatabase;

    private const CARD = [
        'full_name' => 'Jane Doe',
        'card_number' => '4242 4242 4242 4242',
        'expiry_date' => '12/40',
        'cvv' => '123',
    ];

    private function orderAwaitingCardPayment(User $user): Order
    {
        $product = $this->createProduct(['price' => 300]);
        $this->actingAs($user);
        $this->post("/cart/add/{$product->id}");

        $this->post('/payment', [
            'f_name' => 'Jane', 'l_name' => 'Doe', 'your_email' => 'jane@example.com',
            'country' => 'LV', 'city' => 'Riga', 'addr_line_1' => 'Brivibas iela 1',
            'phone' => '+37120000000', 'payment_method' => 'credit-card', 'delivery_method' => 'dhl',
            'm_name' => '', 'addr_line_2' => '', 'company_email' => '', 'company_name' => '', 'vat_number' => '',
        ])->assertRedirect(route('payment-details'));

        return Order::where('user_id', $user->id)->sole();
    }

    public function test_a_successful_card_payment_pays_the_order(): void
    {
        Http::fake(['run.mocky.io/*' => Http::response(['status' => 'success'])]);
        $order = $this->orderAwaitingCardPayment(User::factory()->create());

        $this->post('/process-payment', self::CARD)->assertRedirect(route('paymentSuccess'));

        $order->refresh();
        $this->assertSame(OrderStatus::Delivering, $order->status);
        $this->assertSame(PaymentStatus::Success, $order->payment->status);
        Http::assertSent(fn ($request) => $request['card_number'] === self::CARD['card_number']
            && $request['cvv'] === self::CARD['cvv']);

        $this->get('/paymentSuccess')->assertOk();
        $this->assertNull(session('cart'));
        $this->assertNull(session('payment_id'));
    }

    public function test_a_declined_card_payment_can_be_retried(): void
    {
        Http::fake(['run.mocky.io/*' => Http::sequence()
            ->push(['status' => 'declined'])
            ->push(['status' => 'success'])]);
        $order = $this->orderAwaitingCardPayment(User::factory()->create());

        // Used to be a JSON 500 that left the customer unable to retry.
        $this->from('/payment-details')
            ->post('/process-payment', self::CARD)
            ->assertRedirect('/payment-details')
            ->assertSessionHasErrors('card_number');

        $order->refresh();
        $this->assertSame(OrderStatus::Pending, $order->status);
        $this->assertSame(PaymentStatus::Failed, $order->payment->status);

        $this->get('/payment-details')->assertOk();
        $this->post('/process-payment', self::CARD)->assertRedirect(route('paymentSuccess'));
        $this->assertSame(PaymentStatus::Success, $order->fresh()->payment->status);
    }

    public function test_malformed_card_details_are_validation_errors(): void
    {
        $this->orderAwaitingCardPayment(User::factory()->create());

        // Used to be 500s: preg_match() on an array in CardNumber, and
        // explode()/list destructuring in ExpiryDate.
        $this->from('/payment-details')
            ->post('/process-payment', [...self::CARD, 'card_number' => ['4242'], 'expiry_date' => '1240'])
            ->assertRedirect('/payment-details')
            ->assertSessionHasErrors(['card_number', 'expiry_date']);

        $this->from('/payment-details')
            ->post('/process-payment', [...self::CARD, 'expiry_date' => ['12/40']])
            ->assertSessionHasErrors('expiry_date');
    }

    public function test_an_unreachable_gateway_marks_the_payment_failed(): void
    {
        Http::fake(['run.mocky.io/*' => Http::response('', 503)]);
        $order = $this->orderAwaitingCardPayment(User::factory()->create());

        $this->post('/process-payment', self::CARD)->assertSessionHasErrors('card_number');

        $this->assertSame(PaymentStatus::Failed, $order->fresh()->payment->status);
    }

    public function test_the_success_page_needs_a_confirmed_payment(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/paymentSuccess')
            ->assertRedirect(route('main'));
    }

    public function test_a_card_payment_cannot_target_another_users_order(): void
    {
        Http::fake(['run.mocky.io/*' => Http::response(['status' => 'success'])]);
        $victim = $this->createOrderFor(User::factory()->create(), [$this->createProduct()->id => 1]);

        $this->actingAs(User::factory()->create())
            ->withSession(['order_id' => $victim->id, 'payment_id' => $victim->payment_id])
            ->post('/process-payment', self::CARD)
            ->assertNotFound();

        $this->assertSame(OrderStatus::Processing, $victim->fresh()->status);
        $this->assertSame(PaymentStatus::Processing, $victim->fresh()->payment->status);
        Http::assertNothingSent();
    }

    public function test_a_paid_order_cannot_be_charged_again(): void
    {
        Http::fake(['run.mocky.io/*' => Http::response(['status' => 'success'])]);
        $user = User::factory()->create();
        $order = $this->createOrderFor($user, [$this->createProduct()->id => 1], PaymentStatus::Success);

        $this->actingAs($user)
            ->withSession(['order_id' => $order->id, 'payment_id' => $order->payment_id])
            ->post('/process-payment', self::CARD)
            ->assertForbidden();

        Http::assertNothingSent();
    }
}
