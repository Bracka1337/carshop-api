<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    public function show(Order $order): View
    {
        Gate::authorize('view', $order);

        $order->load(['payment', 'lines.product.images', 'lines.product.brand']);

        $totals = $order->costBreakdown();
        $cost = [
            'subtotal' => number_format($totals['subtotal'], 2),
            'total' => number_format($totals['total'], 2),
            'tax' => number_format($totals['tax'], 2),
            'shipping' => number_format($totals['shipping'], 2),
        ];

        return view('orderdetails', compact('order', 'cost'));
    }
}
