<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductSearchRequest;
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

        $products = $query->get();

        return response()->json(['products' => $products]);
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
