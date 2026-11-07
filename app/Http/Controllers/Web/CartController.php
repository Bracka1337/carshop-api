<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cart) {}

    public function addProductsToCart(string $id): RedirectResponse
    {
        $this->cart->add(Product::with(['brand', 'images'])->findOrFail($id));

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    /** Called by the cart drawer with fetch (JSON) or by a plain form post (redirect). */
    public function updateCart(Request $request, string $id, string $quantity): RedirectResponse|JsonResponse
    {
        $error = match (true) {
            $this->cart->isEmpty() => 'Cart is empty!',
            ! $this->cart->has($id) => 'Product not found in cart!',
            default => null,
        };

        if ($error !== null) {
            return $request->wantsJson()
                ? response()->json(['message' => $error], 404)
                : redirect()->back()->with('error', $error);
        }

        $this->cart->setQuantity($id, (float) $quantity);

        return $request->wantsJson()
            ? response()->json(['message' => 'Cart updated successfully!', 'total' => session('cart.total')])
            : redirect()->back()->with('success', 'Cart updated successfully!');
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
