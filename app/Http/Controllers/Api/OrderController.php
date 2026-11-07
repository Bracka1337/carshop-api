<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Contracts\View\View;

class OrderController extends Controller
{
    public function show(#[CurrentUser] User $user, string $id): View
    {
        // Only the owner may see an order; anything else is a 404.
        $order = $user->orders()
            ->with(['payment', 'productQuantities.product.images', 'productQuantities.product.brand'])
            ->findOrFail($id);

        $cost = $order->costBreakdown();
        $cost = [
            'total' => number_format($cost['total'], 2),
            'tax' => number_format($cost['tax'], 2),
            'shipping' => number_format($cost['shipping'], 2),
        ];

        return view('orderdetails', compact('order', 'cost'));
    }
}
