<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    public function addProductsToCart(string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $quantity = 1;
        $image = $product->images->first()?->img_uri;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'title' => $product->title,
                'brand' => $product->brand?->title,
                'quantity' => $quantity,
                'price' => $product->price,
                'image' => $image,
            ];
        }

        session()->put('cart', $cart);
        $this->calculateCartTotal();

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function updateCart(string $id, string $quantity): RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Cart is empty!');
        }

        if (isset($cart[$id])) {
            if ($quantity == 0) {
                unset($cart[$id]);
            } else {
                $cart[$id]['quantity'] = (float) $quantity;
            }

            session()->put('cart', $cart);
            $this->calculateCartTotal();

            return redirect()->back()->with('success', 'Cart updated successfully!');
        }

        return redirect()->back()->with('error', 'Product not found in cart!');
    }

    public function removeFromCart(string $id): JsonResponse
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return response()->json(['message' => 'Cart is empty!'], 404);
        }

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            $this->calculateCartTotal();

            return response()->json(['message' => 'Product removed successfully!'], 200);
        }

        return response()->json(['message' => 'Product not found in cart!'], 404);
    }

    private function calculateCartTotal(): void
    {
        $cart = session()->get('cart', []);

        $total = array_reduce($cart, function ($carry, $item) {
            return is_array($item) ? $carry + $item['price'] * $item['quantity'] : $carry;
        }, 0);

        session()->put('cart.total', $total);
    }
}
