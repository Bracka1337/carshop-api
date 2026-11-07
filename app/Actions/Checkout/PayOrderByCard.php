<?php

namespace App\Actions\Checkout;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

/**
 * Charges an order's card against the mock payment endpoint and records the
 * outcome on the payment and the order.
 */
class PayOrderByCard
{
    private const ENDPOINT = 'https://run.mocky.io/v3/192c87e3-e951-4c7d-af1c-b70dea4de70b';

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
        try {
            $response = Http::post(self::ENDPOINT, [
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
