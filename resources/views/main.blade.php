<x-app-layout>
    @include('components.search', [
        'brands' => $search['brands'],
        'diameter' => $search['diameter'],
        'width' => $search['width'],
        'et' => $search['et'],
        'cb' => $search['cb'],
        'bolt' => $search['bolt'],
        'bolt_diameter' => $search['bolt_diameter'],
        'type' => $search['type'],
        'price_range' => $search['priceRange'],
    ])
    @include('components.grid', ['products' => $initialProducts])

</x-app-layout>
