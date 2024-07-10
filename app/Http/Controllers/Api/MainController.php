<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class MainController extends Controller
{
    public function getMainPageParams()
    {
        $searchParameters = $this->getSearchParameters();
        $initialProducts = $this->getInitialProducts();

         return view('main', [
            'search' => $searchParameters,
            'initialProducts' => $initialProducts
        ]);
    }

    public function getSearchParameters()
    {
        $categories = Category::select('id', 'title')->distinct('title')->get();
        $brands = Brand::select(['id', 'title'])->distinct("title")->get();
        $sizes = Product::select('size')->distinct()->get();
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');

        $searchParametrs =  [
            'categories' => $categories,
            'brands' => $brands,
            'sizes' => $sizes,
            'priceRange' => [
                'min' => $minPrice,
                'max' => $maxPrice
            ]
        ];
        return $searchParametrs;
    }

    public function getInitialProducts()
    {
        $products = Product::inRandomOrder()->limit(8)->get();
        $products->load('category', 'brand');

        return $products;
    }
}
