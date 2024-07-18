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
        $authId = auth()->user()->id;
        $user = User::where("id", $authId)->first();
        $order = Order::find($id);
        
        // Validate user id vs order id (you might want to add this logic)
        
        $cost = $this->calculateOrderCost($order);

        return view("orderdetails", compact("order", 'cost'));
    }

    private function calculateOrderCost($order)
    {
        $total = $order->productQuantities->sum(function ($productQuantity) {
            $quantity = floatval($productQuantity->quantity);
            $price = floatval($productQuantity->product->price);
            return $quantity * $price;
        });
    
        $tax = $total * 0.21;
        
        // Only apply shipping fee if total is less than or equal to $1000
        $shippingFee = ($total <= 1000) ? $total * 0.02 : 0;
    
        return [
            'total' => number_format($total + $shippingFee, 2),
            'tax' => number_format($tax, 2),
            'shipping' => number_format($shippingFee, 2)
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
