<section class="py-8 antialiased md:py-16">
    <div class="w-full max-w-7xl px-4 md:px-5 lg:px-6 mx-auto">
        <h2 class="font-manrope font-bold text-3xl md:text-4xl leading-10 text-black text-center">
            <ol class="items-center flex w-full max-w-3xl text-center text-sm font-medium text-gray-500 sm:text-base">
                <li class="after:border-1 flex items-center text-primary-700 after:mx-6 after:hidden after:h-1 after:w-full after:border-b after:border-gray-200 sm:after:inline-block sm:after:content-[''] md:w-full xl:after:mx-10">
                  <span class="flex items-center after:mx-2 after:text-gray-200 after:content-['/'] sm:after:hidden">
                    <svg class="me-2 h-4 w-4 sm:h-5 sm:w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Cart
                  </span>
                </li>
          
                <li class="after:border-1 flex items-center text-primary-700 after:mx-6 after:hidden after:h-1 after:w-full after:border-b after:border-gray-200 sm:after:inline-block sm:after:content-[''] md:w-full xl:after:mx-10">
                  <span class="flex items-center after:mx-2 after:text-gray-200 after:content-['/'] sm:after:hidden">
                    <svg class="me-2 h-4 w-4 sm:h-5 sm:w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Checkout
                  </span>
                </li>
          
                <li class=" flex items-center text-primary-700 ">
                    <span class="flex items-center ">
                      <svg class="me-2 h-4 w-4 sm:h-5 sm:w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                      </svg>
                      Order&nbspSummary
                    </span>
                  </li>
              </ol>
        </h2>
        <p class="mt-4 font-normal text-base md:text-lg leading-8 text-gray-500 mb-11 text-center"></p>
        <div class="bg-indigo-100 main-box border border-gray-200 rounded-xl pt-6 max-w-xl mx-auto lg:max-w-full">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between px-6 pb-6 border-b border-gray-200">
                <div class="data">
                    <p class="font-semibold text-base leading-7 text-black">Order Id: <span
                            class="text-indigo-600 font-medium">{{ $order->id }}</span></p>
                    <p class="font-semibold text-base leading-7 text-black mt-4">Order Date: <span
                            class="text-gray-500 font-medium">{{ $order->date }}</span></p>
                </div>
                <div>
                    <div>
                        @php
                            [$paymentBgColor, $paymentTextColor, $paymentText] = $order->getPaymentStatusAttributes();
                            [
                                $deliveryBgColor,
                                $deliveryTextColor,
                                $deliveryText,
                            ] = $order->getDeliveryStatusAttributes();
                        @endphp
                        <p class="font-semibold text-base leading-7 text-black mt-4">Payment Status: <span
                                class="font-medium px-2 py-1 rounded {{ $paymentBgColor }} {{ $paymentTextColor }}">{{ $paymentText }}</span>
                        </p>
                        <p class="font-semibold text-base leading-7 text-black mt-4">Delivery Status: <span
                                class="font-medium px-2 py-1 rounded {{ $deliveryBgColor }} {{ $deliveryTextColor }}">{{ $deliveryText }}</span>
                        </p>
                    </div>
                </div>
            </div>



            <div class="bg-white w-full">
                <!-- First item -->
                @foreach ($order->productQuantities as $productQuantity)
                    <div class="px-2 md:px-6 flex flex-row items-center py-6 border-b border-gray-200 gap-6 w-full" id="product" product-id="{{ $productQuantity->product->id }}"">
                        <div class="img-box flex-shrink-0">
                            <img src="{{ $productQuantity->product->images[0]->img_uri }}" alt="Product Image"
                                class="w-20 lg:w-30 rounded-lg object-cover shadow-md">
                        </div>
                        <div class="flex flex-1 items-center justify-between">
                            <div class="flex flex-col">
                                <h2 class="font-semibold text-lg lg:text-lg leading-8 text-black mb-1">
                                    {{ $productQuantity->product->title }}</h2>
                                <div class="flex items-center">
                                    <p
                                        class="font-medium text-sm leading-7 text-black pr-4 mr-4 border-r border-gray-200">
                                        Size: <span
                                            class="text-gray-500">{{ $productQuantity->product->diameter }}"</span></p>
                                    <p class="font-medium text-sm leading-7 text-black">Quantity: <span
                                            class="text-gray-500">{{ $productQuantity->quantity }}</span></p>
                                </div>
                            </div>
                            <div class="flex items-center justify-end">
                                <p class="font-medium text-lg leading-7 text-indigo-600">
                                    ${{ $productQuantity->quantity * $productQuantity->product->price }}</p>
                            </div>
                        </div>
                    </div>
                    {{-- add boolean order page... so that it doesnt show add to cart --}}
                    <x-productDetail :product="$productQuantity->product" :isOrderPage="true"/>
                @endforeach


                <div class="bg-white w-full border-t border-gray-200 px-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <p class="font-medium text-lg text-gray-900 pl-6 py-3">Sales Tax:</p>
                    </div>
                    <p class="font-semibold text-lg text-indigo-600 py-3">${{ $cost['tax'] }}</p>
                </div>
                <div class="bg-indigo-50 w-full border-t border-gray-200 px-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <p class="font-medium text-lg text-gray-900 pl-6 py-3">Shipping Fee:</p>
                    </div>
                    <p class="font-semibold text-lg text-indigo-600 py-3">${{ $cost['shipping'] }}</p>
                </div>
                <div
                    class="bg-white w-full rounded-b-xl border-t border-gray-200 px-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <p class="font-medium text-2xl text-gray-900 pl-6 py-3">Total Price:</p>
                    </div>
                    <p class="font-semibold text-2xl text-indigo-600 py-3">${{ $cost['total'] }}</p>
                </div>
            </div>


</section>
