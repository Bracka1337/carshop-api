<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSearchRequest;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function __invoke(ProductSearchRequest $request)
    {
        $initialProducts = $request->all() ?
            Product::filter($request->validated())->with('images')->paginate(12)->withQueryString() :
            Product::with('images')->paginate(12);

        $searchParameters = $this->getSearchParameters();

        return view('main', [
            'search' => $searchParameters,
            'initialProducts' => $initialProducts,
        ]);
    }

    public function getSearchParameters()
    {
        $parameters = [
            'diameter' => 'diameter',
            'width' => 'width',
            'bolt_diameter' => 'bolt_diameter',
        ];

        $searchParameters = array_map(function ($param) {
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
}
