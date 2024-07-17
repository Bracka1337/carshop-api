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

                $deliveryDetails = new Delivery_details();
                $deliveryDetails->f_name = $validated['f_name'];
                $deliveryDetails->m_name = $validated['m_name'];
                $deliveryDetails->l_name = $validated['l_name'];
                $deliveryDetails->addr_line_1 = $validated['addr_line_1'] . ', ' . $validated['city'];
                $deliveryDetails->addr_line_2 = $validated['addr_line_2'];
                $deliveryDetails->country = $validated['country'];
                $deliveryDetails->company_email = $validated['company_email'];
                $deliveryDetails->company_name = $validated['company_name'];
                $deliveryDetails->company_reg_nr = $validated['vat_number'];
                $deliveryDetails->payment_method = $validated['payment_method'];
                $deliveryDetails->delivery_method = $validated['delivery_method'];

                $payment = new Payment();
                $payment->status = 'Processing';
                $payment->date = now();

                $order = new Order();
                $order->status = 'Processing';
                $order->date = now();
                $order->user_id = $user->id;

                $cartItems = session('cart');

                $productQuantities = [];
                foreach ($cartItems as $productId => $item) {
                    if ($productId === 'total' || $productId === 'tax') {
                        continue;
                    } else {
                        $productQuantities[] = new Product_quantity([
                            'quantity' => (int)$item['quantity'],
                            'product_id' => $productId,
                        ]);
                    }
                }

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
                    'delivery_details_id' => $deliveryDetails->id
                ]);

                return redirect()->route('payment-details')->with('success', '');
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
