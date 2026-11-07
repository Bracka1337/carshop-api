<?php

namespace App\Actions\Checkout;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

/**
 * Charges an order's card and records the outcome on the payment and the order.
 *
 * No real payment provider is integrated. By default the charge is simulated:
 * every valid card is approved except the test card 4000 0000 0000 0002,
 * which is declined. When services.payment.endpoint is set, the card is sent
 * to that HTTP endpoint instead, which answers {"status": "success"} to approve.
 */
class PayOrderByCard
{
    public const DECLINED_TEST_CARD = '4000000000000002';

    /**
     * @param  array<string, mixed>  $card  validated by CardPaymentRequest
     */
    public function handle(Order $order, array $card): bool
    {
        $paid = $this->charge($card);

        $payment = $order->payment()->firstOrFail();
        $payment->update(['status' => $paid ? PaymentStatus::Success : PaymentStatus::Failed]);
        $order->update(['status' => $paid ? OrderStatus::Delivering : OrderStatus::Pending]);

        return $paid;
    }

    /**
     * @param  array<string, mixed>  $card
     */
    private function charge(array $card): bool
    {
        $endpoint = config('services.payment.endpoint');

        if (! is_string($endpoint) || $endpoint === '') {
            return str_replace(' ', '', (string) $card['card_number']) !== self::DECLINED_TEST_CARD;
        }

        try {
            $response = Http::timeout(10)->post($endpoint, [
                'card_number' => $card['card_number'],
                'expiry_date' => $card['expiry_date'],
                'cvv' => $card['cvv'],
            ]);
        } catch (ConnectionException) {
            return false;
        }

        return $response->status() === 200 && $response->json('status') === 'success';
    }
}
