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

                $deliveryDetails = Delivery_details::create([
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



                $payment = Payment::create([
                    'status' => 'Pending',
                    'date' => now(),
                ]);

                $order = Order::create([
                    'status' => 'Pending',
                    'date' => now(),
                    'user_id' => $user->id,
                    'delivery_details_id' => $deliveryDetails->id,
                    'payment_id' => $payment->id,
                ]);

                $cartItems = session('cart');

                foreach ($cartItems as $productId => $item) {
                    if ($productId === 'total' || $productId === 'tax') {
                        continue;
                    } else {
                        Product_quantity::create([
                            'quantity' => (int)$item['quantity'],
                            'order_id' => $order->id,
                            'product_id' => $productId,
                        ]);
                    }
                }
                session([
                    'order_id' => $order->id,
                    'payment_id' => $payment->id,
                    'delivery_details_id' => $deliveryDetails->id
                ]);
                return redirect()->route('payment-details')->with('success','');


      

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
}
