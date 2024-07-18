<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSearchRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\User;

class MainController extends Controller
{
    public function __invoke(ProductSearchRequest $request)
    {
        $initialProducts = $request->all() ? 
            $this->filterProducts($request)->with("images")->paginate(12)->withQueryString() :
            Product::with('images')->paginate(12);

        $searchParameters = $this->getSearchParameters();

        return view('main', [
            'search' => $searchParameters,
            'initialProducts' => $initialProducts,
        ]);
    }

    private function filterProducts(ProductSearchRequest $request)
    {
        $query = Product::query();
        $validatedRequest = $request->validated();

        $filters = [
            'brand_id' => '=',
            'size' => '=',
            'diameter' => '=',
            'width' => '=',
            'type' => '='
        ];

        foreach ($filters as $field => $operator) {
            if (!empty($validatedRequest[$field])) {
                $value = $operator === 'like' ? "%{$validatedRequest[$field]}%" : $validatedRequest[$field];
                $query->where($field, $operator, $value);
            }
        }

        if (!empty($validatedRequest['price_from'])) {
            $query->where('price', '>=', $validatedRequest['price_from']);
        }

        if (!empty($validatedRequest['price_to'])) {
            $query->where('price', '<=', $validatedRequest['price_to']);
        }

        if (!empty($validatedRequest['order'])) {
            $orderOptions = [
                'price_asc' => ['price', 'asc'],
                'price_desc' => ['price', 'desc'],
                'brand_asc' => ['brand_id', 'asc'],
                'brand_desc' => ['brand_id', 'desc'],
            ];

            if (isset($orderOptions[$validatedRequest['order']])) {
                $query->orderBy($orderOptions[$validatedRequest['order']][0], $orderOptions[$validatedRequest['order']][1]);
            }
        }

        return $query;
    }

    public function getSearchParameters()
    {
        $parameters = [
            'diameter' => 'diameter',
            'width' => 'width',
            'bolt_diameter' => 'bolt_diameter',
        ];

        $searchParameters = array_map(function($param) {
            return Product::select($param)->where($param, '>', 0)->distinct()->get()->sortBy($param);
        }, $parameters);

        $searchParameters['type'] = Product::select('type')->distinct()->get()->sortBy('type');
        $searchParameters['brands'] = Brand::select('id', 'title')->get()->sortBy('title');
        $searchParameters['priceRange'] = [
            'min' => Product::min('price'),
            'max' => Product::max('price'),
        ];

        return $searchParameters;
    }

    public function getInitialProducts(Request $request)
    {
        $products = Product::inRandomOrder()->paginate(20)->appends($request->query());
        $products->load('category', 'brand');

        return $products;
    }

    public function addProductsToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $quantity = 1;
        $image = $product->images[0]['img_uri'];

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'title' => $product->title,
                'brand' => $product->brand->title,
                'quantity' => $quantity,
                'price' => $product->price,
                'image' => $image,
            ];
        }

        session()->put('cart', $cart);
        $this->calculateCartTotal();

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function updateCart($id, $quantity)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Cart is empty!');
        }

        if (isset($cart[$id])) {
            if ($quantity == 0) {
                unset($cart[$id]);
            } else {
                $cart[$id]['quantity'] = (float)$quantity;
            }

            session()->put('cart', $cart);
            $this->calculateCartTotal();

            return redirect()->back()->with('success', 'Cart updated successfully!');
        }

        return redirect()->back()->with('error', 'Product not found in cart!');
    }

    public function removeFromCart($id)
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

    private function calculateCartTotal()
    {
        $cart = session()->get('cart', []);

        $total = array_reduce($cart, function($carry, $item) {
            return is_array($item) ? $carry + $item['price'] * $item['quantity'] : $carry;
        }, 0);

        session()->put('cart.total', $total);
    }

    public function getCart(Request $request)
    {
        $cart = session()->get('cart');
        $total = session()->get('cart.total', 0);

        if (!empty($cart) && $total > 0) {
            $total = (float)str_replace(',', '', $total);
            $tax = $total * 0.21;
            $shipping = $total >= 1000 ? 0 : $total * 0.1;

            $cart['total'] = number_format($total + $shipping, 2, '.', '');
            $cart['tax'] = number_format($tax, 2, '.', '');
            $cart['shipping'] = $shipping;
            $cart['subtotal'] = number_format($total - $tax, 2, '.', '');

            return $cart;
        }

        return $cart;
    }

    public function getCheckout(Request $request)
    {
        $cart = $this->getCart($request);

        if (!empty($cart) && $cart['total'] > 0) {
            return view('checkout', ['cart' => $cart]);
        }

        return redirect()->route('main')->with('search', $this->getSearchParameters());
    }

    public function getPaymentDetails(Request $request)
    {
        $user = auth()->user();
        $orders = $user->orders;
        $unPaidOrders = $orders->filter(fn($order) => $order->payment->status == 'Processing');
        $unPaidOrder = $unPaidOrders->firstWhere('payment.id', session('payment_id'));

        if ($unPaidOrder) {
            $cart = $this->getCart($request);
            $total = $cart['total'] ?? 0;

            if ($total > 0) {
                return view("payment", ['cart' => $cart]);
            }
        }

        return redirect()->route('main')->with('search', $this->getSearchParameters());
    }
}
