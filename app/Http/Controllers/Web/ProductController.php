<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

class ProductController extends Controller
{
    public function __invoke(Product $product): View
    {
        $product->load(['brand', 'images']);

        return view('product', [
            'product' => $product,
            'similar' => $this->similar($product),
        ]);
    }

    /**
     * Four wheels that fit the same car: same diameter and bolt pattern,
     * closest in price first.
     *
     * @return Collection<int, Product>
     */
    private function similar(Product $product)
    {
        return Product::query()
            ->with(['brand', 'images'])
            ->whereKeyNot($product->getKey())
            ->where('diameter', $product->diameter)
            ->where('bolt', $product->bolt)
            ->where('bolt_diameter', $product->bolt_diameter)
            ->orderByRaw('abs(price - ?)', [$product->price])
            ->orderBy('id')
            ->limit(4)
            ->get();
    }
}
