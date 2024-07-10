@props(['products'])

<div class="relative flex min-h-96 flex-col justify-center overflow-hidden bg-gray- py-6 sm:py-12">
    <div class="mx-auto max-w-screen-xl px-4 w-full">
        <h2 class="mb-4 font-bold text-xl text-gray-600">Product list:</h2>
        <div class="grid w-full sm:grid-cols-2 xl:grid-cols-4 gap-6">
            @foreach ($products as $product)
                {{-- element --}}
                <div class="relative flex flex-col shadow-md rounded-xl overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 max-w-sm" id="product">
                    <div class="h-auto overflow-hidden">
                        <div class="h-44 overflow-hidden relative">
                            <img src="{{ $product->image_url }}" alt="{{ $product->title }}">
                        </div>
                    </div>
                    <div class="bg-white py-4 px-3">
                        <h3 class="text-xs mb-2 font-medium">{{ $product->title }}</h3>
                        <div class="flex justify-between items-center">
                            <p class="text-xs text-gray-400">
                                {{ $product->description }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @php
            $randomProduct = $products->random();
        @endphp

        {{-- product details --}}
        <div class="dark:bg-gray-800 py-8 mt-10 shadow-lg rounded-xl " id="productDetail">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row -mx-4">
                    <div class="md:flex-1 px-4">
                        <div class="rounded-lg bg-gray-300 dark:bg-gray-700 mb-4">
                            <img class="w-full h-full object-cover" src="{{ $randomProduct->image_url }}" alt="{{ $randomProduct->title }}">
                        </div>
                    </div>
                    <div class="md:flex-1 px-4 pt-10">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">{{ $randomProduct->title }}</h2>
                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">
                            {{ $randomProduct->brand }}
                        </p>
                        <div class="mb-4">
                            <div class="mr-4">
                                <span class="font-bold text-gray-700 dark:text-gray-300">Price:</span>
                                <span class="text-gray-600 dark:text-gray-300">${{ $randomProduct->price }}</span>
                            </div>
                            <div>
                                <span class="font-bold text-gray-700 dark:text-gray-300">Category:</span>
                                <span class="text-gray-600 dark:text-gray-300">{{ $randomProduct->category }}</span>
                            </div>
                            <div>
                                <span class="font-bold text-gray-700 dark:text-gray-300">Size:</span>
                                <span class="text-gray-600 dark:text-gray-300">{{ $randomProduct->size }}</span>
                            </div>
                        </div>
                        <div>
                            <span class="font-bold text-gray-700 dark:text-gray-300">Product Description:</span>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mt-2">
                                {{ $randomProduct->description }}
                            </p>
                        </div>
                        <div class="flex -mx-2 mb-4 pt-5">
                            <div class="w-1/2 px-2">
                                <button class="w-full bg-gray-900 dark:bg-gray-600 text-white py-2 px-4 rounded-full font-bold hover:bg-gray-800 dark:hover:bg-gray-700">Add to Cart</button>
                            </div>
                            <div class="w-1/2 px-2">
                                <button class="w-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white py-2 px-4 rounded-full font-bold hover:bg-gray-300 dark:hover:bg-gray-600">Add to Wishlist</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
