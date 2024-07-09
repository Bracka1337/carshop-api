<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getSearchParameters()
    {
        $categories = Category::all(['id', 'title']);
        $brands = Brand::all(['id', 'title']);
        $sizes = Product::select('size')->distinct()->get();
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');

        return view('main', [
            'categories' => $categories,
            'brands' => $brands,
            'sizes' => $sizes,
            'price_range' => [
                'min' => $minPrice,
                'max' => $maxPrice,
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
