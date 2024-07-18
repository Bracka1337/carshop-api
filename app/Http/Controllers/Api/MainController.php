<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSearchRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;

class MainController extends Controller
{
    public function __invoke(ProductSearchRequest $request)
    {
        // Check if there are any search parameters in the request
        if ($request->all()) {
            $initialProducts = $this->filterProducts($request)
                ->with("images")
                ->paginate(12)
                ->withQueryString();
        } else {
            $initialProducts = Product::with('images')->paginate(12);
        }

        $searchParameters = $this->getSearchParameters();

        return view('main', [
            'search' => $searchParameters,
            'initialProducts' => $initialProducts,
        ]);
    }
    private function filterProducts(ProductSearchRequest $request)
    {
        $query = Product::query();

        $filters = [
            'title' => 'like',
            'brand_id' => '=',
            'size' => '=',
            'diameter' => '=',
            'width' => '=',
            'et' => '=',
            'cb' => '=',
            'bolt' => '=',
            'bolt_diameter' => '=',
            'type' => '='
        ];

        $validatedRequest = $request->validated();

        foreach ($filters as $field => $operator) {
            if (array_key_exists($field, $validatedRequest) && !empty($validatedRequest[$field])) {
                $value = $operator === 'like' ? "%{$validatedRequest[$field]}%" : $validatedRequest[$field];
                $query->where($field, $operator, $value);
            }
        }

        if (array_key_exists('price_from', $validatedRequest) && !empty($validatedRequest['price_from'])) {
            $query->where('price', '>=', $validatedRequest['price_from']);
        }

        if (array_key_exists('price_to', $validatedRequest) && !empty($validatedRequest['price_to'])) {
            $query->where('price', '<=', $validatedRequest['price_to']);
        }

        if (array_key_exists('order', $validatedRequest) && !empty($validatedRequest['order'])) {
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
        $diameter = Product::select('diameter')->where('diameter', '>', 0)->distinct()->get()->sortBy('diameter');
        $width = Product::select('width')->where('width', '>', 0)->distinct()->get()->sortBy('width');
        $et = Product::select('et')->where('et', '>', 0)->distinct()->get()->sortBy('et');
        $cb = Product::select('cb')->where('cb', '>', 0)->distinct()->get()->sortBy('cb');
        $bolt = Product::select('bolt')->where('bolt', '>', 0)->distinct()->get()->sortBy('bolt');
        $bolt_diameter = Product::select('bolt_diameter')->where('bolt_diameter', '>', 0)->distinct()->get()->sortBy('bolt_diameter');
        $type = Product::select('type')->distinct()->get()->sortBy('type');
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');
        $brands = Brand::select('id', 'title')->get()->sortBy('title');


        $searchParameters = [
            'brands' => $brands,
            'diameter' => $diameter,
            'width' => $width,
            'et' => $et,
            'cb' => $cb,
            'bolt' => $bolt,
            'bolt_diameter' => $bolt_diameter,
            'type' => $type,
            'priceRange' => [
                'min' => $minPrice,
                'max' => $maxPrice,
            ],
        ];
        return $searchParameters;
    }

    public function getInitialProducts(Request $request)
    {
        $products = Product::inRandomOrder()
            ->paginate(20)
            ->appends($request->query());
        $products->load('category', 'brand');

        return $products;
    }

    public function addProductsToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $quantity = (float)1;
        $image = $product->images[0]['img_uri'];

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'title' => $product->title,
                'brand' => $product->brand->title,
                'quantity' => $quantity,
                'price' => (float)$product->price,
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

            return response()->json([
                'message' => 'Product removed successfully!',
            ], 200);
        }

        return response()->json(['message' => 'Product not found in cart!'], 404);
    }

    private function calculateCartTotal()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            session()->put('cart.total', 0);
            return;
        }

        $total = 0;

        foreach ($cart as $key => $item) {
            if (is_array($item) && $key !== 'total') {
                $total += $item['price'] * $item['quantity'];
            }
        }

        session()->put('cart.total', $total);
    }

    public function getCart(Request $request)
    {
        $cart = session()->get('cart');
        $total = session()->get('cart.total', 0);

        if (!empty($cart) && ($total > 0)) {
            $total = session()->get('cart.total', 0);
            $total = str_replace(',', '', $total);
            $total = (float)$total;

            $tax = $total * 0.21;
            $cart['total'] = number_format($total, 2, '.', '');
            $cart['tax'] = number_format($tax, 2, '.', '');

            session()->put('cart.tax', $cart['tax']);
            session()->put('cart.total', $cart['total']);

            return view('checkout', [
                'cart' => $cart,
            ]);
        } else {

            $searchParameters = $this->getSearchParameters();

            return redirect()->route('main')
                ->with('search', $searchParameters);
        }
    }
}
