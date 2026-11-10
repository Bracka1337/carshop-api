<?php

namespace App\Http\Controllers\Web;

use App\Enums\WheelSpec;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSearchRequest;
use App\Models\Brand;
use App\Models\Product;
use App\Support\Money;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;

class CatalogueController extends Controller
{
    /** Sort options for the toolbar; keys match ProductSearchRequest. */
    public const SORT_OPTIONS = [
        'price_asc' => 'Price: low to high',
        'price_desc' => 'Price: high to low',
        'brand_asc' => 'Brand: A to Z',
        'brand_desc' => 'Brand: Z to A',
    ];

    public function __invoke(ProductSearchRequest $request): View
    {
        $filters = $request->validated();

        $products = Product::filter($filters)
            ->with(['images', 'brand'])
            ->paginate(12)
            ->withQueryString();

        $options = $this->filterOptions();

        return view('main', [
            'initialProducts' => $products,
            'options' => $options,
            'priceRange' => ['min' => Product::min('price'), 'max' => Product::max('price')],
            'activeFilters' => $this->activeFilters($filters, $options, $request->query()),
            'clearFiltersUrl' => route('main', Arr::only($request->query(), ['order'])),
        ]);
    }

    /**
     * Value => label for each filter select.
     *
     * @return array<string, array<int|string, string>>
     */
    private function filterOptions(): array
    {
        $distinct = fn (string $column) => Product::query()
            ->where($column, '>', 0)
            ->distinct()
            ->orderBy($column)
            ->pluck($column);

        return [
            'brand' => Brand::orderBy('title')->pluck('title', 'id')->all(),
            'diameter' => $distinct('diameter')->mapWithKeys(fn ($d) => [(string) $d => WheelSpec::diameter($d)])->all(),
            'width' => $distinct('width')->mapWithKeys(fn ($w) => [(string) $w => WheelSpec::width($w)])->all(),
            'type' => Product::query()->distinct()->orderBy('type')->pluck('type', 'type')->all(),
        ];
    }

    /**
     * One chip per applied filter, each linking to the same page without it.
     *
     * @param  array<string, mixed>  $filters
     * @param  array<string, array<int|string, string>>  $options
     * @param  array<string, mixed>  $query
     * @return list<array{label: string, url: string}>
     */
    private function activeFilters(array $filters, array $options, array $query): array
    {
        $chips = [];

        foreach (['brand', 'diameter', 'width', 'type', 'price_from', 'price_to'] as $key) {
            $value = $filters[$key] ?? null;

            if ($value === null || $value === '') {
                continue;
            }

            $label = match ($key) {
                'brand', 'type' => $options[$key][$value] ?? (string) $value,
                'diameter' => WheelSpec::diameter($value),
                'width' => WheelSpec::width($value),
                'price_from' => 'From '.Money::format($value, 0),
                'price_to' => 'Up to '.Money::format($value, 0),
            };

            $chips[] = ['label' => $label, 'url' => route('main', Arr::except($query, [$key, 'page']))];
        }

        return $chips;
    }
}
