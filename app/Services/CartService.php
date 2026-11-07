<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CartService
{
    public function __construct(private readonly ShippingCalculator $shipping) {}

    /**
     * The session cart with totals added, or null when it is empty.
     *
     * @return array<int|string, mixed>|null
     */
    public function getCart(): ?array
    {
        $cart = session()->get('cart');
        $total = session()->get('cart.total', 0);

        if (! empty($cart) && $total > 0) {
            $total = (float) str_replace(',', '', (string) $total);
            $tax = $total * 0.21;
            $shipping = $this->shipping->cost($total);

            $cart['total'] = number_format($total + $shipping, 2, '.', '');
            $cart['tax'] = number_format($tax, 2, '.', '');
            $cart['shipping'] = $shipping;
            $cart['subtotal'] = number_format($total - $tax, 2, '.', '');

            return $cart;
        }

        return $cart;
    }

    public function getCheckout(): View|RedirectResponse
    {
        $cart = $this->getCart();

        if (! empty($cart) && $cart['total'] > 0) {
            return view('checkout', ['cart' => $cart]);
        }

        return redirect()->route('main');
    }

    public function getPaymentDetails(User $user): View|RedirectResponse
    {
        $hasUnpaidOrder = $user->orders()
            ->where('payment_id', session('payment_id'))
            ->whereHas('payment', fn ($payment) => $payment->where('status', 'Processing'))
            ->exists();

        if ($hasUnpaidOrder) {
            $cart = $this->getCart();
            $total = $cart['total'] ?? 0;

            if ($total > 0) {
                return view('payment', ['cart' => $cart]);
            }
        }

        return redirect()->route('main');
    }
}
