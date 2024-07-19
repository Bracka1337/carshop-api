<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcedeToPayment;
use App\Models\Order;
use App\Models\Delivery_details;
use App\Models\Product_quantity;
use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;
use App\Services\CartService;
 
class CheckoutController extends Controller
{

    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public function proceedToPayment(ProcedeToPayment $request)
    {
        $validated = $request->validated();

        if ($validated) {
            $user = auth()->user();

            try {
                $deliveryDetails = $this->createDeliveryDetails($validated);
                $payment = $this->createPayment();
                $order = $this->createOrder($user->id, $deliveryDetails->id, $payment->id);
                $productQuantities = $this->getProductQuantities(session('cart'));

                $this->saveOrderDetails($order, $productQuantities);

                if ($validated['payment_method'] === 'pay-on-delivery') {
                    session()->forget(['cart', 'order_id', 'payment_id', 'delivery_details', 'payment_confirmed']);
                    return redirect()->route('main')->with('success', 'Order created successfully!');
                } else {
                    session([
                        'order_id' => $order->id,
                        'payment_id' => $payment->id,
                        'delivery_details' => $deliveryDetails->id,
                    ]);
                    return redirect()->route('payment-details')->with('success', 'Order created successfully!');
                }
            } catch (Exception $e) {
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
            session()->forget(['cart', 'order_id', 'payment_id', 'delivery_details', 'payment_confirmed']);
            return view('paymentSuccess');
        }

        return redirect()->route('main');
    }

    private function createDeliveryDetails($validated)
    {
        return Delivery_details::create([
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
    }

    private function createPayment()
    {
        return Payment::create([
            'status' => 'Processing',
            'date' => now(),
        ]);
    }

    private function createOrder($userId, $deliveryDetailsId, $paymentId)
    {
        return Order::create([
            'status' => 'Processing',
            'date' => now(),
            'user_id' => $userId,
            'delivery_details_id' => $deliveryDetailsId,
            'payment_id' => $paymentId,
        ]);
    }

    private function getProductQuantities($cartItems)
    {
        return collect($cartItems)
            ->except(['total', 'tax'])
            ->map(function ($item, $productId) {
                return new Product_quantity([
                    'quantity' => (int)$item['quantity'],
                    'product_id' => $productId,
                ]);
            })->all();
    }

    private function saveOrderDetails($order, $productQuantities)
    {
        $order->save();

        foreach ($productQuantities as $productQuantity) {
            $productQuantity->order_id = $order->id;
            $productQuantity->save();
        }
    }


    public function getCart(Request $request)
    {
        return $this->cartService->getCart($request);
    }

    public function getCheckout(Request $request)
    {
        return $this->cartService->getCheckout($request);
    }

    public function getPaymentDetails(Request $request)
    {
        return $this->cartService->getPaymentDetails($request);
    }
}
