<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Customers see only their own orders, in the shop and in the API.
     * Others get a 404, so order ids can't be probed.
     */
    public function view(User $user, Order $order): Response
    {
        return $order->user_id === $user->id
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    /**
     * A card payment can only be made for the customer's own order while
     * it is unpaid; a declined payment can be retried.
     */
    public function pay(User $user, Order $order): Response
    {
        if ($order->user_id !== $user->id) {
            return Response::denyAsNotFound();
        }

        return $order->payment?->status->isPayable()
            ? Response::allow()
            : Response::deny('This order has already been paid or cancelled.');
    }
}
