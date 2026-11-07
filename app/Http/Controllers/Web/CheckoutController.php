<?php

namespace App\Http\Controllers\Web;

use App\Actions\Checkout\PlaceOrder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\PlaceOrderRequest;
use App\Models\Order;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class CheckoutController extends Controller
{
    public function __construct(private readonly CartService $cart) {}

    public function getCheckout(): View|RedirectResponse
    {
        if (! $this->cart->hasItems()) {
            return redirect()->route('main');
        }

        return view('checkout', ['cart' => $this->cart->getCart()]);
    }

    public function proceedToPayment(PlaceOrderRequest $request, #[CurrentUser] User $user, PlaceOrder $placeOrder): RedirectResponse
    {
        $details = $request->validated();

        $order = $placeOrder->handle($user, $details, session('cart', []));

        if ($details['payment_method'] === 'pay-on-delivery') {
            $this->cart->clear();

            return redirect()->route('main')->with('success', 'Order created successfully!');
        }

        session([
            'order_id' => $order->id,
            'payment_id' => $order->payment_id,
            'delivery_details' => $order->delivery_details_id,
        ]);

        return redirect()->route('payment-details')->with('success', 'Order created successfully!');
    }

    /** Card form for the order placed in this session, while it is unpaid. */
    public function getPaymentDetails(#[CurrentUser] User $user): View|RedirectResponse
    {
        $order = Order::with('payment')->whereKey(session('order_id'))->first();

        if (! $order || Gate::forUser($user)->denies('pay', $order) || ! $this->cart->hasItems()) {
            return redirect()->route('main');
        }

        return view('payment', ['cart' => $this->cart->getCart()]);
    }

    public function finalise(): View|RedirectResponse
    {
        if (session('payment_id') && session('payment_confirmed')) {
            $this->cart->clear();

            return view('paymentSuccess');
        }

        return redirect()->route('main');
    }
}
