<?php

namespace App\Http\Controllers\JsonApi;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSearchRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    /**
     * Paginated catalogue with the same filters as the shop page
     * (diameter, width, type, brand, price_from, price_to, order).
     */
    public function index(ProductSearchRequest $request): AnonymousResourceCollection
    {
        $products = Product::filter($request->validated())
            ->with(['brand', 'images'])
            ->paginate(12)
            ->withQueryString();

        return ProductResource::collection($products);
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product->load(['brand', 'images']));
    }
}
