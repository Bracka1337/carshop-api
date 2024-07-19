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

         if (!empty($validatedRequest['brand'])) {
            $query->where('brand_id', $validatedRequest['brand']);
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



   

}
