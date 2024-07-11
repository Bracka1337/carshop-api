<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
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

        if ($request->has('brand') && !empty($request->brand)) {
            $query->where('brand_id', $request->brand);
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

        if ($request->has('diameter') && !empty($request->diameter)) {
            $query->where('diameter', $request->diameter);
        }

        if ($request->has('width') && !empty($request->width)) {
            $query->where('width', $request->width);
        }

        if ($request->has('et') && !empty($request->et)) {
            $query->where('et', $request->et);
        }

        if ($request->has('cb') && !empty($request->cb)) {
            $query->where('cb', $request->cb);
        }

        if ($request->has('bolt') && !empty($request->bolt)) {
            $query->where('bolt', $request->bolt);
        }

        if ($request->has('bolt_diameter') && !empty($request->bolt_diameter)) {
            $query->where('bolt_diameter', $request->bolt_diameter);
        }

        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }

        return $query;
    }

    public function getSearchParameters()
    {

        $diameter = Product::select('diameter')->where('diameter', '>', 0)->distinct()->get();
        $width = Product::select('width')->where('width', '>', 0)->distinct()->get();
        $et = Product::select('et')->where('et', '>', 0)->distinct()->get();
        $cb = Product::select('cb')->where('cb', '>', 0)->distinct()->get();
        $bolt = Product::select('bolt')->where('bolt', '>', 0)->distinct()->get();
        $bolt_diameter = Product::select('bolt_diameter')->where('bolt_diameter', '>', 0)->distinct()->get();
        $type = Product::select('type')->where('type', '>', 0)->distinct()->get();
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');
        $brands = Brand::select('id', 'title')->get();

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
                'max' => $maxPrice
            ]
        ];
        return $searchParameters;
    }

    public function getInitialProducts(Request $request)
    {
        $products = Product::inRandomOrder()->paginate(12)->appends($request->query());
        $products->load('category', 'brand');

        return $products;
    }
}
