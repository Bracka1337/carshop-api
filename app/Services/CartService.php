<?php

namespace App\Services;

use App\Models\Product;

/**
 * The session cart: product id => item, plus a running "total" key.
 */
class CartService
{
    public function __construct(private readonly TotalsCalculator $totals) {}

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
            $totals = $this->totals->forItems((float) str_replace(',', '', (string) $total));

            $cart['total'] = number_format($totals['total'], 2, '.', '');
            $cart['tax'] = number_format($totals['tax'], 2, '.', '');
            $cart['shipping'] = number_format($totals['shipping'], 2, '.', '');
            $cart['subtotal'] = number_format($totals['subtotal'], 2, '.', '');

            return $cart;
        }

        return $cart;
    }

    /** Whether the cart has something to pay for. */
    public function hasItems(): bool
    {
        $cart = $this->getCart();

        return ! empty($cart) && $cart['total'] > 0;
    }

    public function isEmpty(): bool
    {
        return empty(session()->get('cart', []));
    }

    /** Number of items in the cart, counting quantities. */
    public function count(): int
    {
        $items = array_filter(session()->get('cart', []), 'is_array');

        return (int) array_sum(array_column($items, 'quantity'));
    }

    public function has(string $productId): bool
    {
        return isset(session()->get('cart', [])[$productId]);
    }

    public function add(Product $product): void
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += 1;
        } else {
            $cart[$product->id] = [
                'title' => $product->title,
                'brand' => $product->brand?->title,
                'quantity' => 1,
                'price' => $product->price,
                'image' => $product->images->first()?->img_uri,
            ];
        }

        $this->save($cart);
    }

    /** Sets the quantity of an item already in the cart; 0 removes it. */
    public function setQuantity(string $productId, float $quantity): void
    {
        $cart = session()->get('cart', []);

        if ($quantity == 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId]['quantity'] = $quantity;
        }

        $this->save($cart);
    }

    public function remove(string $productId): void
    {
        $cart = session()->get('cart', []);
        unset($cart[$productId]);

        $this->save($cart);
    }

    public function clear(): void
    {
        session()->forget(['cart', 'order_id', 'payment_id', 'delivery_details', 'payment_confirmed']);
    }

    /**
     * @param  array<int|string, mixed>  $cart
     */
    private function save(array $cart): void
    {
        session()->put('cart', $cart);

        $total = array_reduce($cart, function ($carry, $item) {
            return is_array($item) ? $carry + $item['price'] * $item['quantity'] : $carry;
        }, 0);

        session()->put('cart.total', $total);
    }
}
