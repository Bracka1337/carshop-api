<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductSearchRequest;
use App\Models\Category;
use App\Models\Brand;

class SearchController extends Controller
{
    public function search(ProductSearchRequest $request)
    {
        $validated = $request->validated();

        $query = Product::query();

        if (isset($validated['title']) && !empty($validated['title'])) {
            $query->where('title', 'like', "%{$validated['title']}%");
        }

        if (isset($validated['category']) && !empty($validated['category'])) {
            $query->where('category_id', $validated['category']);
        }

        if (isset($validated['brand']) && !empty($validated['brand'])) {
            $query->where('brand_id', $validated['brand']);
        }

        if (isset($validated['price_from']) && !empty($validated['price_from'])) {
            $query->where('price', '>=', $validated['price_from']);
        }

        if (isset($validated['price_to']) && !empty($validated['price_to'])) {
            $query->where('price', '<=', $validated['price_to']);
        }

        if (isset($validated['size']) && !empty($validated['size'])) {
            $query->where('size', $validated['size']);
        }

        $products = $query->paginate(8);
        
        return view('main', [
            'search' => $this->getSearchParameters(),
            'initialProducts' => $products
        ]);
    }

    private function getSearchParameters()
    {
        $categories = Category::select('id', 'title')->distinct('title')->get();
        $brands = Brand::select(['id', 'title'])->distinct("title")->get();
        $sizes = Product::select('size')->distinct()->get();
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');

        $searchParameters =  [
            'categories' => $categories,
            'brands' => $brands,
            'sizes' => $sizes,
            'priceRange' => [
                'min' => $minPrice,
                'max' => $maxPrice
            ]
        ];
        return $searchParameters;
    }
}
