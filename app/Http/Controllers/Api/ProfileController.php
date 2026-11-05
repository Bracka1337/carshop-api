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
        return ['total' => number_format($order->costBreakdown()['total'], 2)];
    }
}
