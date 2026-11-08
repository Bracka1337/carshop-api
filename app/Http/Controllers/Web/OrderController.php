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

        $cost = $order->costBreakdown();

        return view('orderdetails', compact('order', 'cost'));
    }
}
