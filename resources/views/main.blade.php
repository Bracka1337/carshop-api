<x-app-layout>

    @include('components.search', [
        'categories' => $categories,
        'brands' => $brands,
        'sizes' => $sizes,
        'price_range' => $price_range,
    ])
    @include('components.grid')



</x-app-layout>

