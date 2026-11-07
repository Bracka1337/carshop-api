<?php

namespace App\Http\Controllers\Web;

use App\Actions\Checkout\PayOrderByCard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\CardPaymentRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class CardPaymentController extends Controller
{
    public function processPayment(CardPaymentRequest $request, PayOrderByCard $payOrder): RedirectResponse|JsonResponse
    {
        $order = Order::with('payment')->whereKey(session('order_id'))->first();

        if (! $order) {
            return redirect()->route('main');
        }

        Gate::authorize('pay', $order);

        if ($payOrder->handle($order, $request->validated())) {
            session(['payment_confirmed' => true]);

            return redirect()->route('paymentSuccess')->with('success', 'Payment successful. Your order is being processed.');
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Payment failed. Please try again.',
        ], 500);
    }
}
