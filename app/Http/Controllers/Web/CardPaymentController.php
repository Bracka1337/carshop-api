<?php

namespace App\Http\Controllers\Web;

use App\Actions\Checkout\PayOrderByCard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\CardPaymentRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class CardPaymentController extends Controller
{
    public function processPayment(CardPaymentRequest $request, PayOrderByCard $payOrder): RedirectResponse
    {
        $order = Order::with('payment')->whereKey(session('order_id'))->first();

        if (! $order) {
            return redirect()->route('main');
        }

        Gate::authorize('pay', $order);

        if (! $payOrder->handle($order, $request->validated())) {
            throw ValidationException::withMessages([
                'card_number' => 'The payment was declined. Please try again or use another card.',
            ]);
        }

        session(['payment_confirmed' => true]);

        return redirect()->route('paymentSuccess')->with('success', 'Payment successful. Your order is being processed.');
    }
}
