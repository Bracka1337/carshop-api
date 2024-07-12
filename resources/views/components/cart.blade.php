<div class="relative z-10 hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true" id="modal">
    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div class="pointer-events-auto w-screen max-w-md">
                    <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl hidden" id="shopping-cart">
                        <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Shopping cart</h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button id="close-button" type="button"
                                        class="relative -m-2 p-2 text-gray-400 hover:text-gray-500">
                                        <span class="absolute -inset-0.5"></span>
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @if (session('cart'))
                                <div class="mt-8">
                                    <div class="flow-root">
                                        <ul role="list" class="-my-6 divide-y divide-gray-200">
                                            @foreach (session('cart') as $id => $details)
                                                <li class="flex py-6">
                                                    <div
                                                        class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                                        <img src="{{ $details['preview_img'] }}"
                                                            alt="{{ $details['title'] }}"
                                                            class="h-full w-full object-cover object-center">
                                                    </div>
                                                    <div class="ml-4 flex flex-1 flex-col">
                                                        <div>
                                                            <div
                                                                class="flex justify-between text-base font-medium text-gray-900">
                                                                <h3>
                                                                    <a href="#">{{ $details['title'] }}</a>
                                                                </h3>
                                                                <p class="ml-4">${{ $details['price'] }}</p>
                                                            </div>
                                                            <p class="mt-1 text-sm text-gray-500">
                                                                {{ $details['brand'] }}</p>
                                                        </div>
                                                        <div class="flex flex-1 items-end justify-between text-sm">
                                                            <div class="flex w-full gap-4">
                                                                <input type="number" name="quantity"
                                                                    id="quantity-{{ $id }}"
                                                                    class="text-gray-500 border-gray-300 rounded-md w-12"
                                                                    value="{{ $details['quantity'] }}" min="1">
                                                                <a href="{{ route('cart.update', ['id' => $id, 'quantity' => 1]) }}"
                                                                    class="font-medium text-indigo-600 hover:text-indigo-500 ml-2">Update</a>
                                                            </div>
                                                            <div class="flex">
                                                                <a href="{{ route('cart.remove', ['id' => $id]) }}"
                                                                    class="font-medium text-indigo-600 hover:text-indigo-500 ml-4">Remove</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                             <a href="{{ route('cart.update', ['id' => 2, 'quantity' => 1]) }}"
                                                class="font-medium text-indigo-600 hover:text-indigo-500 ml-2">Update</a>
                                        </ul>
                                    </div>
                                </div>
                            @else
                                <p>Your cart is empty.</p>
                            @endif
                        </div>
                        <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                            <div class="flex justify-between text-base font-medium text-gray-900">
                                <p>Subtotal</p>
                                <p>$ {{ session('total', 0) }}</p>
                            </div>
                            <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>
                            <div class="mt-6">
                                <a href="#"
                                    class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700">Checkout</a>
                            </div>
                            <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                                <p>
                                    or
                                    <button id="continue-shopping" type="button"
                                        class="font-medium text-indigo-600 hover:text-indigo-500">
                                        Continue Shopping
                                        <span aria-hidden="true"> &rarr;</span>
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
