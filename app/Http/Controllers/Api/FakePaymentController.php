<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Rules\CardNumber;
use App\Rules\ExpiryDate;
use App\Models\Payment;
use App\Models\Order;

class FakePaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'card_number' => ['required', new CardNumber],
            'expiry_date' => ['required', 'regex:/^(0[1-9]|1[0-2])\/([0-9]{2})$/', new ExpiryDate],
            'cvv' => 'required|digits:3',
        ]);

        $mockyUrl = 'https://run.mocky.io/v3/192c87e3-e951-4c7d-af1c-b70dea4de70b';
        $client = new Client();

        try {
            $response = $client->post($mockyUrl, [
                'json' => [
                    'card_number' => $request->input('card_number'),
                    'expiry_date' => $request->input('expiry_date'),
                    'cvv' => $request->input('cvv'),
                ]
            ]);

            $responseBody = json_decode($response->getBody(), true);

            if ($response->getStatusCode() == 200 && $responseBody['status'] === 'success') {
                $payment = Payment::find(session('payment_id'));
                $payment->status = 'Success';

                $order = Order::find(session('order_id'));
                $order->status = 'Delivering';

                $payment->save();
                $order->save();

                session(['payment_confirmed' => true]);

                return redirect()->route('paymentSuccess')->with('success', 'Payment successful. Your order is being processed.');
            } else {
                $payment = Payment::find(session('payment_id'));
                $payment->status = 'Failed';

                $order = Order::find(session('order_id'));
                $order->status = 'Pending';
                $payment->save();
                $order->save();

                return response()->json([
                    'status' => 'error',
                    'message' => 'Payment failed. Please try again.',
                ], 500);
            }
        } catch (\Exception $e) {

            $payment = Payment::find(session('payment_id'));
            $payment->status = 'Failed';

            $order = Order::find(session('order_id'));
            $order->status = 'Pending';
            $payment->save();
            $order->save();

            return response()->json([
                'status' => 'error',
                'message' => 'Payment failed. Please try again.',
            ], 500);
        }
    }
}
