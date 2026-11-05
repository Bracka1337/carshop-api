<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\ProductQuantity;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $orders = $user->orders->map(function ($order) {
            $cost = $this->calculateOrderCost($order);
            $order->calculatedTotal = $cost['total'];
            return $order;
        });

        return view('orders.index', compact('user', 'orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Only the owner may see an order; anything else is a 404.
        $order = auth()->user()->orders()->findOrFail($id);

        $cost = $this->calculateOrderCost($order);

        return view("orderdetails", compact("order", 'cost'));
    }

    private function calculateOrderCost($order)
    {
        $cost = $order->costBreakdown();

        return [
            'total' => number_format($cost['total'], 2),
            'tax' => number_format($cost['tax'], 2),
            'shipping' => number_format($cost['shipping'], 2),
        ];
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
