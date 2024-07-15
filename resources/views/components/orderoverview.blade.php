<section class="py-24 relative">
    <div class="w-full max-w-7xl px-4 md:px-5 lg:px-6 mx-auto">
        <h2 class="font-manrope font-bold text-3xl md:text-4xl leading-10 text-black text-center">
            Order Details
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
                    <div class="px-2 md:px-6 flex flex-row items-center py-6 border-b border-gray-200 gap-6 w-full">
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
