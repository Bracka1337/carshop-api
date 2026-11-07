<?php

namespace App\Http\Controllers\JsonApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    private const RELATIONS = ['payment', 'deliveryDetails', 'lines.product'];

    /**
     * The authenticated user's orders, newest first.
     */
    public function index(#[CurrentUser] User $user): AnonymousResourceCollection
    {
        $orders = $user->orders()
            ->with(self::RELATIONS)
            ->latest('id')
            ->paginate(20);

        return OrderResource::collection($orders);
    }

    /**
     * A single order; other users' orders are reported as not found.
     */
    public function show(Order $order): OrderResource
    {
        Gate::authorize('view', $order);

        return new OrderResource($order->load(self::RELATIONS));
    }
}
