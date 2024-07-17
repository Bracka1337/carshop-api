@props(['product' => []])

<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="mt-10 max-w-screen-2xl mx-auto px-4 sm:px-4 lg:px-5 bg-white shadow-lg rounded-xl hidden h-5/6 flex flex-col" id="productDetail" product-data-id="{{ $product->id }}">
        <!-- Close modal -->
        <div class="relative flex justify-end md:h-5 z-50">
            <span id="closeModal" class="cursor-pointer text-gray-500 hover:text-gray-800 text-3xl" role="button" aria-label="Close modal">&times;</span>
        </div>
        <!-- Product description -->
        <div class="md:flex md:flex-grow relative h-full sm:flex-column overflow-y-auto">
            <div class="md:h-10/12 h-11/12 basis-1/2 w-full flex items-center justify-center rounded-lg mb-5 relative overflow-hidden">
                <!-- Product image carousel -->
                <div class="relative w-full h-full flex transition-transform duration-500 ease" data-carousel-inner>
                    @foreach ($product->images as $key => $image)
                        <div class="flex-100" data-carousel-item="{{ $key }}">
                            <img src="{{ asset('/storage/' . $image->img_uri) }}" class="object-cover w-full h-full rounded-lg" alt="Slide {{ $key }}">
                        </div>
                    @endforeach
                </div>
                <!-- Slider indicators -->
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2 w-max" data-carousel-indicators>
                    @foreach ($product->images as $key => $image)
                        <button type="button" class="w-3 h-3 rounded-full transition {{ $key === 0 ? 'bg-gray-400' : 'bg-gray-300' }}" data-carousel-slide-to></button>
                    @endforeach
                </div>
                <!-- Slider controls -->
                <button type="button" class="absolute top-1/2 left-3 z-40 flex items-center justify-center w-10 h-10 bg-gray-200/50 rounded-full hover:bg-gray-300 focus:outline-none transition" data-carousel-prev>
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button type="button" class="absolute top-1/2 right-3 z-40 flex items-center justify-center w-10 h-10 bg-gray-200/50 rounded-full hover:bg-gray-300 focus:outline-none transition" data-carousel-next>
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
            <!-- Product details -->
            <div class="px-4 basis-1/2 flex flex-col justify-between overflow-y-auto">
                <div>
                    <h2 class="font-bold text-gray-800 mb-2 text-5xl">{{ $product->title }}</h2>
                    <p class="text-gray-600 text-3xl mb-4">{{ $product->brand->title }}</p>
                    <div class="mb-4 flex text-4xl">
                        <div class="mr-10">
                            <span class="text-gray-600">${{ $product->price }}</span>
                        </div>
                    </div>
                    <div class="h-52 mt-10 overflow-auto">
                        <span class="font-bold text-gray-700 text-xl">Описание продукта:</span>
                        <p class="text-gray-600 text-lg mt-2">{{ $product->description }}</p>
                    </div>
                    <div class="mt-3">
                        <p class="font-bold text-gray-700 text-xl">Характеристики продукта:</p>
                    </div>
                    <!-- Product specification table -->
                    <div>
                        <table class="w-full text-base text-left rtl:text-right text-gray-500">
                            <thead class="text-base text-gray-700">
                                @foreach (['Type' => 'type', 'Size' => 'diameter', 'Width' => 'width', 'Et' => 'et', 'Cb' => 'cb', 'Bolt' => 'bolt', 'Bolt Diameter' => 'bolt_diameter'] as $label => $field)
                                    <tr>
                                        <th scope="col" class="px-6 py-2 border-b border-gray-200">{{ $label }}</th>
                                        <td class="px-6 py-2 border-b border-gray-200 font-bold text-right">{{ $product->$field }}</td>
                                    </tr>
                                @endforeach
                            </thead>
                        </table>
                    </div>
                    <!-- Add to Cart button -->
                    @if (!Request::is('*/orderdetails/*'))
                        <div class="flex -mx-2 justify-end my-5">
                            <button class="w-1/2 bg-gray-900 text-white py-2 px-4 rounded-full font-bold hover:bg-gray-800" id="btn-addToCart" productLink="{{ route('products.addToCart', $product->id) }}">
                                Добавить в корзину
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
