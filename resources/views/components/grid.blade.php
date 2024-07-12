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
          <div class="mt-10 max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 bg-white 
          shadow-lg rounded-xl hidden h-4/6 flex flex-col"
          id="productDetail"
          product-data-id="{{ $product->id }}">
              <div class="flex justify-end h-10">
                  <span id="closeModal"
                      class="cursor-pointer text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300 text-3xl">&times;</span>
              </div>
              <div class="flex flex-grow relative">
                <div class="basis-2/5 h-11/12 w-full items-center justify-center rounded-lg bg-gray-300 dark:bg-gray-700 mb-4 relative">
                    <div class="relative w-full h-full" data-carousel-inner>
                        <!-- Item 1 -->
                        @foreach ($product->images as $key => $image)
                            <div class=" duration-700 ease-in-out w-full h-full" data-carousel-item>
                                <img src={{ $image->img_uri}}
                                    class="object-cover w-full h-full rounded-lg" alt="Slide {{$key}}">
                            </div>
                        @endforeach
                    </div>
                    <!-- Slider indicators -->
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2 w-max" data-carousel-indicators>
                        @foreach ($product->images as $key => $image)
                            <button type="button" class="w-3 h-3 rounded-full bg-gray-300 hover:bg-gray-400 focus:outline-none focus:bg-gray-400 transition" data-carousel-slide-to="{{$key}}"></button>
                        @endforeach
                    </div>
                    <!-- Slider controls -->
                    <button type="button"
                        class="absolute top-1/2 left-3 z-40 flex items-center justify-center w-10 h-10 bg-gray-200/50 rounded-full hover:bg-gray-300 focus:outline-none transition"
                        data-carousel-prev>
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button type="button"
                        class="absolute top-1/2 right-3 z-40 flex items-center justify-center w-10 h-10 bg-gray-200/50 rounded-full hover:bg-gray-300 focus:outline-none transition"
                        data-carousel-next>
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
                  <div class="px-4 basis-3/5 h-full flex flex-col justify-between">
                      <div>
                          <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2 text-5xl">{{ $product->title }}</h2>
                          <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 text-base">{{ $product->brand->title}}</p>
                          <div class="mb-4 flex text-4xl ">
                              <div class="mr-10">
                                  <span class="font-bold text-gray-700 dark:text-gray-300 ">Price:</span>
                                  <span class="text-gray-600 dark:text-gray-300">${{ $product->price }}</span>
                              </div>
                              <div>
                                  <span class="font-bold text-gray-700 dark:text-gray-300">Size:</span>
                                  <span class="text-gray-600 dark:text-gray-300">{{ $product->diameter }}</span>
                              </div>
                          </div>
                          <div>
                              <span class="font-bold text-gray-700 dark:text-gray-300">Product Description:</span>
                              <p class="text-gray-600 dark:text-gray-300 text-sm mt-2">{{ $product->description }}</p>
                          </div>
                      </div>
                      <div class="flex -mx-2 mb-4 pt-5 justify-end">
                          <div class="w-1/2 px-2">
                              <button class="w-full bg-gray-900 dark:bg-gray-600 text-white py-2 px-4 rounded-full font-bold hover:bg-gray-800 dark:hover:bg-gray-700">
                              Add to Cart
                              </button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  @endforeach
  {{-- <script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script> --}}
    
</div>