<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $orders = $user->orders->map(function ($order) {
            $cost = $this->calculateOrderCost($order);
            $order->calculatedTotal = $cost['total'];
            return $order;
        });

        return view('profile', compact('user', 'orders'));
    }

    private function calculateOrderCost($order)
    {
        $total = $order->productQuantities->sum(function ($productQuantity) {
            return $productQuantity->quantity * $productQuantity->product->price;
        });

        $tax = number_format($total * 0.21, 2);
        $shippingFee = number_format($total * 0.001, 2);

        return [
            'total' => number_format($total + $tax + $shippingFee, 2),
            'tax' => $tax,
            'shipping' => $shippingFee
        ];
    }
}
