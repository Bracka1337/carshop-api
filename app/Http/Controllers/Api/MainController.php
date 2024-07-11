<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class MainController extends Controller
{
    public function __invoke(Request $request)
    {
        $initialProducts = $this->filterProducts($request)->paginate(10)->withQueryString();

        $searchParameters = $this->getSearchParameters();

        return view('main', [
            'search' => $searchParameters,
            'initialProducts' => $initialProducts
        ]);
    }

    private function filterProducts(Request $request)
    {
        $query = Product::query();

        if ($request->has('title') && !empty($request->title)) {
            $query->where('title', 'like', "%{$request->title}%");
        }

        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('brand_id') && !empty($request->brand_id)) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->has('price_from') && !empty($request->price_from)) {
            $query->where('price', '>=', $request->price_from);
        }

        if ($request->has('price_to') && !empty($request->price_to)) {
            $query->where('price', '<=', $request->price_to);
        }

        if ($request->has('size') && !empty($request->size)) {
            $query->where('size', $request->size);
        }

        return $query;
    }

    public function getSearchParameters()
    {
        // $categories = Category::select('id', 'title')->distinct('title')->get();
        $brands = Brand::select(['id', 'title'])->distinct("title")->get();
        $sizes = Product::select('size')->distinct()->get();
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');

        $searchParametrs =  [
            // 'categories' => $categories,
            'brands' => $brands,
            'sizes' => $sizes,
            'priceRange' => [
                'min' => $minPrice,
                'max' => $maxPrice
            ]
        ];
        return $searchParametrs;
    }

    public function getInitialProducts(Request $request)
    {
        $products = Product::inRandomOrder()->paginate(20)->appends($request->query());
        $products->load('category', 'brand');

        return $products;
    }
}
