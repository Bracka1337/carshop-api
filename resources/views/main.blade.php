<x-app-layout>
    @include('components.search', [
        'categories' => $search['categories'],
        'brands' => $search['brands'],
        'sizes' => $search['sizes'],
        'price_range' => $search['priceRange'],
    ])
    @include('components.grid', ['products' => $initialProducts])
</x-app-layout>
