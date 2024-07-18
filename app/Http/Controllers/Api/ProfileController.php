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
        $quantity = floatval($productQuantity->quantity);
        $price = floatval($productQuantity->product->price);
        return $quantity * $price;
    });

    $tax = $total * 0.21;
    
    $shippingFee = ($total <= 1000) ? $total * 0.001 : 0;

    return [
        'total' => number_format($total + $shippingFee, 2),
        'tax' => number_format($tax, 2),
        'shipping' => number_format($shippingFee, 2)
    ];
}
}
