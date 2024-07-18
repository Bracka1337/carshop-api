<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProcedeToPayment;
use App\Models\Order;
use App\Models\Delivery_details;
use App\Models\Product_quantity;
use App\Models\Payment;

class CheckoutController extends Controller
{
    public function proceedToPayment(ProcedeToPayment $request)
    {
        $validated = $request->validated();

        if ($validated) {
            try {
                $user = auth()->user();

                $deliveryDetails = new Delivery_details([
                    'f_name' => $validated['f_name'],
                    'm_name' => $validated['m_name'],
                    'l_name' => $validated['l_name'],
                    'addr_line_1' => $validated['addr_line_1'] . ', ' . $validated['city'],
                    'addr_line_2' => $validated['addr_line_2'],
                    'country' => $validated['country'],
                    'company_email' => $validated['company_email'],
                    'company_name' => $validated['company_name'],
                    'company_reg_nr' => $validated['vat_number'],
                    'payment_method' => $validated['payment_method'],
                    'delivery_method' => $validated['delivery_method'],
                ]);

                $payment = new Payment([
                    'status' => 'Processing',
                    'date' => now(),
                ]);

                $order = new Order([
                    'status' => 'Processing',
                    'date' => now(),
                    'user_id' => $user->id,
                ]);

                $cartItems = session('cart');

                $productQuantities = collect($cartItems)
                    ->except(['total', 'tax'])
                    ->map(function ($item, $productId) {
                        return new Product_quantity([
                            'quantity' => (int)$item['quantity'],
                            'product_id' => $productId,
                        ]);
                    })->all();

                $deliveryDetails->save();
                $payment->save();

                $order->delivery_details_id = $deliveryDetails->id;
                $order->payment_id = $payment->id;
                $order->save();

                foreach ($productQuantities as $productQuantity) {
                    $productQuantity->order_id = $order->id;
                    $productQuantity->save();
                }

                session([
                    'order_id' => $order->id,
                    'payment_id' => $payment->id,
                    'delivery_details_id' => $deliveryDetails->id,
                ]);

                return redirect()->route('payment-details')->with('success', 'Order placed successfully!');
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to place order: ' . $e->getMessage(),
                ], 500);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment details validation failed',
            ], 400);
        }
    }

    public function finalise()
    {
        if (session('payment_id') && session('payment_confirmed')) {
            session()->forget(['cart', 'order_id', 'payment_id', 'delivery_details_id', 'payment_confirmed']);
            return view('paymentSuccess');
        }

        return redirect()->route('main');
    }
}
