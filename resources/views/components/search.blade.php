@php
    $orderOptions = [
        'price_asc' => 'Price: Low to High',
        'price_desc' => 'Price: High to Low',
        'brand_asc' => 'Brand: A to Z',
        'brand_desc' => 'Brand: Z to A',
    ];
@endphp

<div class="search w-full">
    <div class="flex w-full items-center justify-center mt-28 px-4">
        <form action="{{ route('main') }}" method="get"
            class="bg-white p-6 w-full rounded-lg shadow-lg grid grid-cols-1 gap-2 w-full max-w-6xl md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            {{-- <x-inputSelect name="diameter" :options="$diameter" :selected="request('diameter')" />
            <x-inputSelect name="width" :options="$width" :selected="request('width')" />
            <x-inputSelect name="type" :options="$type" :selected="request('type')" /> --}}
            {{-- {{dd($diameter)}} --}}
            {{-- <x-inputSelect name="brand" :options="$brands" :selected="request('brand')" /> --}}
            
            <div class="p-4">
                <label for="brand" class="block mt-2 text-sm font-medium text-gray-900">Brand</label>
                <select id="brand" name="brand"
                    class="block mt-2 w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 hover:shadow-md">
                    <option value="">Choose a Brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->title }}</option>
                    @endforeach
                </select>
                @if ($errors->has('brand'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('brand') }}</p>
                @endif
            </div>
            {{-- <div class="p-4">
                <label for="priceFrom" class="block text-sm font-semibold leading-6 text-gray-900">Price from:</label>
                <div class="mt-2.5">
                    <input type="number" name="price_from" id="priceFrom"
                        value="{{ request('price_from', number_format($price_range['min'], 2, '.', '')) }}"
                        step="0.01" oninput="this.value = this.value.replace(/[^0-9.]/g, '');"
                        class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 hover:shadow-md">
                </div>
                @if ($errors->has('price_from'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('price_from') }}</p>
                @endif
            </div>
            <div class="p-4">
                <label for="priceTo" class="block text-sm font-semibold leading-6 text-gray-900">Price to:</label>
                <div class="mt-2.5">
                    <input type="number" name="price_to" id="priceTo"
                        value="{{ request('price_to', number_format($price_range['max'], 2, '.', '')) }}"
                        step="0.01" oninput="this.value = this.value.replace(/[^0-9.]/g, '');"
                        class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 hover:shadow-md">
                </div>
                @if ($errors->has('price_to'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('price_to') }}</p>
                @endif
            </div>
            <div class="p-4">
                <label for="order" class="block text-sm font-semibold leading-6 text-gray-900">Order by:</label>
                <select id="order" name="order"
                    class="block mt-2 w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 hover:shadow-md">
                    <option value="">Choose an order</option>
                    @foreach ($orderOptions as $key => $label)
                        <option value="{{ $key }}" {{ request('order') == $key ? 'selected' : '' }}>
                            {{ $label }}</option>
                    @endforeach
                </select>
            </div> --}}
            <div class="p-4 lg:col-start-4">
                <div class="mt-8">
                    <button type="submit"
                        class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 hover:shadow-md">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>
