<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Contracts\View\View;

class ProfileController extends Controller
{
    public function show(#[CurrentUser] User $user): View
    {
        $orders = $user->orders()->with(['payment', 'lines.product.images'])->get();

        $totals = $orders->mapWithKeys(fn (Order $order) => [
            $order->id => number_format($order->costBreakdown()['total'], 2),
        ]);

        return view('profile', compact('user', 'orders', 'totals'));
    }
}
