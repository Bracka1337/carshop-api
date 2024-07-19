<?php

namespace App\Services;

use Illuminate\Http\Request;

class CartService
{
    public function getCart(Request $request)
    {
        $cart = session()->get('cart');
        $total = session()->get('cart.total', 0);

        if (!empty($cart) && $total > 0) {
            $total = (float)str_replace(',', '', $total);
            $tax = $total * 0.21;
            $shipping = $total >= 1000 ? 0 : $total * 0.1;

            $cart['total'] = number_format($total + $shipping, 2, '.', '');
            $cart['tax'] = number_format($tax, 2, '.', '');
            $cart['shipping'] = $shipping;
            $cart['subtotal'] = number_format($total - $tax, 2, '.', '');

            return $cart;
        }

        return $cart;
    }

    public function getCheckout(Request $request)
    {
        $cart = $this->getCart($request);

        if (!empty($cart) && $cart['total'] > 0) {
            return view('checkout', ['cart' => $cart]);
        }

        return redirect()->route('main');
    }

    public function getPaymentDetails(Request $request)
    {
        $user = auth()->user();
        $orders = $user->orders;
        $unPaidOrders = $orders->filter(fn($order) => $order->payment->status == 'Processing');
        $unPaidOrder = $unPaidOrders->firstWhere('payment.id', session('payment_id'));

        if ($unPaidOrder) {
            $cart = $this->getCart($request);
            $total = $cart['total'] ?? 0;

            if ($total > 0) {
                return view("payment", ['cart' => $cart]);
            }
        }

        return redirect()->route('main');
    }


}
