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

    <x-filament::input.wrapper>
        <x-filament::input.select wire:model="status">

            <option value="draft">Draft</option>
            <option value="reviewing">Reviewing</option>
            <option value="published">Published</option>
        </x-filament::input.select>
    </x-filament::input.wrapper>

</x-app-layout>
