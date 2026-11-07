<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Rules\CardNumber;
use App\Rules\ExpiryDate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FakePaymentController extends Controller
{
    public function processPayment(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'card_number' => ['required', new CardNumber],
            'expiry_date' => ['required', 'regex:/^(0[1-9]|1[0-2])\/([0-9]{2})$/', new ExpiryDate],
            'cvv' => 'required|digits:3',
        ]);

        $payment = Payment::whereKey(session('payment_id'))->first();
        $order = Order::whereKey(session('order_id'))->first();

        if (! $payment || ! $order) {
            return redirect()->route('main');
        }

        $mockyUrl = 'https://run.mocky.io/v3/192c87e3-e951-4c7d-af1c-b70dea4de70b';
        try {
            $response = Http::post($mockyUrl, [
                'card_number' => $request->input('card_number'),
                'expiry_date' => $request->input('expiry_date'),
                'cvv' => $request->input('cvv'),
            ]);

            if ($response->status() === 200 && $response->json('status') === 'success') {
                $payment->status = 'Success';
                $order->status = 'Delivering';
                $payment->save();
                $order->save();

                session(['payment_confirmed' => true]);

                return redirect()->route('paymentSuccess')->with('success', 'Payment successful. Your order is being processed.');
            }
        } catch (\Exception $e) {
            // Treated as a failed payment below.
        }

        $payment->status = 'Failed';
        $order->status = 'Pending';
        $payment->save();
        $order->save();

        return response()->json([
            'status' => 'error',
            'message' => 'Payment failed. Please try again.',
        ], 500);
    }
}
