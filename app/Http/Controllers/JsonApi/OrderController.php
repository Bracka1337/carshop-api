<?php

namespace App\Http\Controllers\JsonApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    private const RELATIONS = ['payment', 'delivery_details', 'productQuantities.product'];

    /**
     * The authenticated user's orders, newest first.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $orders = $request->user()->orders()
            ->with(self::RELATIONS)
            ->latest('id')
            ->paginate(20);

        return OrderResource::collection($orders);
    }

    /**
     * A single order; other users' orders are reported as not found.
     */
    public function show(Request $request, string $order): OrderResource
    {
        $order = $request->user()->orders()->with(self::RELATIONS)->findOrFail($order);

        return new OrderResource($order);
    }
}
