<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cart) {}

    /** Catalogue buttons use fetch (JSON with the re-rendered drawer); without JS it's a form post. */
    public function addProductsToCart(Request $request, string $id): RedirectResponse|JsonResponse
    {
        $quantity = (int) ($request->validate(['quantity' => 'sometimes|integer|min:1|max:'.CartService::MAX_QUANTITY])['quantity'] ?? 1);

        $product = Product::with(['brand', 'images'])->findOrFail($id);

        if (($error = $this->cart->stockError($product, $quantity)) !== null) {
            return $request->wantsJson()
                ? response()->json(['message' => $error], 422)
                : redirect()->back()->with('error', $error);
        }

        $this->cart->add($product, $quantity);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Product added successfully!',
                'count' => $this->cart->count(),
                'drawer' => view('components.cart-panel')->render(),
            ]);
        }

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    /** Called by the cart drawer with fetch (JSON) or by a plain form post (redirect). */
    public function updateCart(Request $request, string $id, string $quantity): RedirectResponse|JsonResponse
    {
        // Same rules as adding to the cart, except that 0 is allowed: it removes the item.
        $quantity = (int) Validator::make(
            ['quantity' => $quantity],
            ['quantity' => 'required|integer|min:0|max:'.CartService::MAX_QUANTITY],
        )->validate()['quantity'];

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

        // Lowering is always allowed, so a cart holding more than is left can be fixed.
        $stock = (int) Product::whereKey($id)->value('stock');
        $current = $this->cart->quantityOf($id);

        if ($quantity > $current && $quantity > $stock) {
            $error = $stock > 0 ? "Only {$stock} in stock." : 'This product is out of stock.';

            return $request->wantsJson()
                ? response()->json(['message' => $error, 'quantity' => $current], 422)
                : redirect()->back()->with('error', $error);
        }

        $this->cart->setQuantity($id, $quantity);

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
