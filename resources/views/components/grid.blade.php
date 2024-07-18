<div class="relative flex min-h-96 flex-col justify-center overflow-hidden bg-gray-100 py-6 sm:py-12">
    <div class="mx-auto max-w-screen-xl px-4 w-full">
        @if ($products->isEmpty())
            <div class="flex items-center justify-center">
                <p class="text-2xl font-bold text-gray-600">No products found</p>
            </div>
        @else
            <h2 class="mb-4 font-bold text-xl text-gray-600">Product list:</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
                @foreach ($products as $index => $product)
                    <div class="relative flex flex-col shadow-md rounded-xl overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="flex flex-col hover:cursor-pointer" id="product" product-id="{{ $product->id }}">
                            <div class="h-auto overflow-hidden">
                                <div class="h-44 overflow-hidden relative">
                                    <img src="{{ asset('/storage/' . $product->images[0]->img_uri ) }}" alt="{{ $product->title }}">
                                </div>
                            </div>
                            <div class="bg-white flex flex-col justify-between flex-grow py-4 px-3">
                                <h3 class="text-xs mb-2 font-medium">{{ $product->title }}</h3>
                                <p class="text-xs text-gray-400 line-clamp-2 flex-grow">
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
