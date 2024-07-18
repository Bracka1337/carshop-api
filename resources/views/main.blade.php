<x-app-layout>
    @include('components.search', [
        'brands' => $search['brands'],
        'diameter' => $search['diameter'],
        'width' => $search['width'],
        'type' => $search['type'],
        'price_range' => $search['priceRange'],
    ])
    @include('components.grid', ['products' => $initialProducts])


</x-app-layout>
