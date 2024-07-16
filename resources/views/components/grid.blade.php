@props(['products'])

<div class="relative flex min-h-96 flex-col justify-center overflow-hidden bg-gray-100 py-6 sm:py-12">
    <div class="mx-auto max-w-screen-xl px-4 w-full">
        @if ($products->isEmpty())
            <div class="flex items-center justify-center">
                <p class="text-2xl font-bold text-gray-600">No products found</p>
            </div>
        @else
            <h2 class="mb-4 font-bold text-xl text-gray-600">Product list:</h2>
            <div class="grid w-full sm:grid-cols-2 xl:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div class="relative flex flex-col shadow-md rounded-xl overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 w-full md:w-72">
                        <div class="flex flex-col hover:cursor-pointer" id="product" product-id="{{ $product->id }}">
                            <div class="h-auto overflow-hidden">
                                <div class="h-44 overflow-hidden relative">
                                    <img src="{{ $product->images[0]->img_uri }}" alt="{{ $product->title }}">
                                </div>
                            </div>
                            <div class="bg-white flex flex-col justify-between flex-grow py-4 px-3">
                                <h3 class="text-xs mb-2 font-medium">{{ $product->title }}</h3>
                                <p class="text-xs text-gray-400 line-clamp-3 flex-grow">
                                    {{ $product->description }}
                                </p>
                            </div>
                        </div>
                        <div class="p-3 bg-white flex justify-between items-center mt-auto">
                            <p class="text-sm font-semibold text-gray-600">${{ $product->price }}</p>
                            <a href="{{ route('products.addToCart', $product->id) }}" class="flex items-center gap-2 px-6 py-3 font-sans text-xs font-bold text-center text-indigo-600 uppercase align-middle transition-all rounded-full select-none hover:bg-indigo-600/10 active:bg-indigo-600/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">Add to cart</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8 flex justify-center">
                {{$products->onEachSide(2)->links('components.pagination.pagination')}}
            </div>
        @endif
    </div>
</div>




        {{-- product details --}}
        @foreach ($products as $product)
            <div id="modal" class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-50 z-50 hidden">
                <div class="py-8 mt-10">
                    <div id="productDetail"
                        class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 bg-white shadow-lg rounded-xl hidden"
                        product-data-id="{{ $product->id }}">
                        <div class="flex justify-end">
                            <span id="closeModal"
                                class="cursor-pointer text-gray-500 hover:text-gray-800 text-3xl">&times;</span>
                        </div>
                        <div class="flex flex-col md:flex-row -mx-4">
                            <div class="md:flex-1 px-4">
                                <div class="rounded-lg bg-gray-300 mb-4">
                                    <img class="w-full h-full object-cover" src="{{ $product->image_url }}"
                                        alt="{{ $product->title }}">
                                </div>
                            </div>
                            <div class="md:flex-1 px-4 pt-10">
                                <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $product->title }}
                                </h2>
                                <p class="text-gray-600 text-sm mb-4">
                                    {{ $product->brand }}
                                </p>
                                <div class="mb-4">
                                    <div class="mr-4">
                                        <span class="font-bold text-gray-700">Price:</span>
                                        <span class="text-gray-600">${{ $product->price }}</span>
                                    </div>
                                    {{-- <div>
                                        <span class="font-bold text-gray-700 dark:text-gray-300">Category:</span>
                                        <span class="text-gray-600 dark:text-gray-300">{{ $product->category }}</span>
                                    </div> --}}
                                    <div>
                                        <span class="font-bold text-gray-700">Size:</span>
                                        <span class="text-gray-600">{{ $product->size }}</span>
                                    </div>
                                </div>
                                <div>
                                    <span class="font-bold text-gray-700">Product Description:</span>
                                    <p class="text-gray-600 text-sm mt-2">
                                        {{ $product->description }}
                                    </p>
                                </div>
                                <div class="flex -mx-2 mb-4 pt-5">
                                    <div class="w-1/2 px-2">
                                        <button
                                            class="w-full bg-gray-900 text-white py-2 px-4 rounded-full font-bold hover:bg-gray-800">Add
                                            to Cart</button>
                                    </div>
                                    <div class="w-1/2 px-2">
                                        <button
                                            class="w-full bg-gray-200 text-gray-800 py-2 px-4 rounded-full font-bold hover:bg-gray-300">Add
                                            to Wishlist</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    </div>
