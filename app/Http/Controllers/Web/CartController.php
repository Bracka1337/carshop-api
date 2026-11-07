<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cart) {}

    public function addProductsToCart(string $id): RedirectResponse
    {
        $this->cart->add(Product::with(['brand', 'images'])->findOrFail($id));

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function updateCart(string $id, string $quantity): RedirectResponse
    {
        if ($this->cart->isEmpty()) {
            return redirect()->back()->with('error', 'Cart is empty!');
        }

        if (! $this->cart->has($id)) {
            return redirect()->back()->with('error', 'Product not found in cart!');
        }

        $this->cart->setQuantity($id, (float) $quantity);

        return redirect()->back()->with('success', 'Cart updated successfully!');
    }

    public function removeFromCart(string $id): JsonResponse
    {
        if ($this->cart->isEmpty()) {
            return response()->json(['message' => 'Cart is empty!'], 404);
        }

        if (! $this->cart->has($id)) {
            return response()->json(['message' => 'Product not found in cart!'], 404);
        }

        $this->cart->remove($id);

        return response()->json(['message' => 'Product removed successfully!'], 200);
    }
}
