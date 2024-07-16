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
        $orders = $user->orders;

        //validate user id vs order id....


        $order = Order::find($id);


        $productQuantities = $order->productQuantities;

        $total = 0;
        foreach ($order->productQuantities as $productQuantities) {
            $total += $productQuantities->quantity * $productQuantities->product->price;
        }
        $tax = number_format($total * 0.21, 2);
        $shippingFee = number_format($total * 0.001, 2);
        $cost = [
            'total' => number_format($total, 2),
            'tax' => $tax,
            'shipping' => $shippingFee
        ];

        return view("orderdetails", compact("order", 'cost'));
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
