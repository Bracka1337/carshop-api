<div class="relative z-30 hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true" id="modal">
    <div class="fixed inset-0 overflow-hidden bg-gray-500 bg-opacity-75 transition-opacity">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div class="pointer-events-auto w-screen max-w-md">
                    <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl hidden" id="shopping-cart">
                        <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Shopping cart</h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button id="cart-close-button" type="button"
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

                            @if (session('cart') && array_sum(array_column(session('cart'), 'quantity')) > 0)
                                <div class="mt-8">
                                    <div class="flow-root">
                                        <ul role="list" class="-my-6 divide-y divide-gray-200" id="cart-items">
                                            @foreach (session('cart') as $id => $details)
                                                @if (is_array($details))
                                                    <li class="flex py-6 cart-item" data-id="{{ $id }}">
                                                        <div
                                                            class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                                            <img src="{{ asset('/storage/' . $details['image']) }}"
                                                                class="w-full h-full object-center object-cover">
                                                        </div>
                                                        <div class="ml-4 flex flex-1 flex-col">
                                                            <div>
                                                                <div
                                                                    class="flex justify-between text-base font-medium text-gray-900">
                                                                    <h3>
                                                                        <a
                                                                            href="#">{{ $details['title'] ?? 'N/A' }}</a>
                                                                    </h3>
                                                                    <p class="ml-4 product-price"
                                                                        data-id="{{ $id }}">
                                                                        ${{ $details['price'] ?? 'N/A' }}
                                                                    </p>
                                                                </div>
                                                                <p class="mt-1 text-sm text-gray-500">
                                                                    {{ $details['brand'] ?? 'N/A' }}</p>
                                                            </div>
                                                            <div class="flex flex-1 items-end justify-between text-sm">
                                                                <div
                                                                    class="flex flex-1 items-end justify-between text-sm">
                                                                    <div class="flex items-center w-full gap-4">
                                                                        <div class="quantity-control flex items-center">
                                                                            <button type="button"
                                                                                class="decrease-quantity bg-gray-200 hover:bg-gray-300 rounded-md px-2 py-1"
                                                                                data-id="{{ $id }}">-</button>
                                                                            <div id="quantity-{{ $id }}"
                                                                                class="quantity-display text-gray-500 border-gray-300 rounded-md w-12 text-center">
                                                                                {{ $details['quantity'] ?? 1 }}
                                                                            </div>
                                                                            <button type="button"
                                                                                class="increase-quantity bg-gray-200 hover:bg-gray-300 rounded-md px-2 py-1"
                                                                                data-id="{{ $id }}">+</button>
                                                                        </div>
                                                                    </div>

                                                                    <a id="remove-item"
                                                                        href="{{ route('cart.remove', ['id' => $id]) }}"
                                                                        data-id="{{ $id }}"
                                                                        class="font-medium text-indigo-600 hover:text-indigo-500 ml-4">Remove</a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @else
                                <p class="mt-8 text-center text-lg font-semibold text-gray-600" id="empty-cart-message">
                                    Your cart is empty.
                                </p>
                            @endif
                        </div>
                        <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                            <div class="flex justify-between text-base font-medium text-gray-900">
                                <p>Subtotal</p>
                                <p id="subtotal-amount">$0.00</p>
                            </div>
                            <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>
                            @if (session('cart') && array_sum(array_column(session('cart'), 'quantity')) > 0)
                                <div class="mt-6">
                                    <a id="checkout" href='{{ route('checkout') }}'
                                        class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700">Checkout</a>
                                </div>
                            @endif
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


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const removeButtons = document.querySelectorAll("#remove-item");
        const quantityInputs = document.querySelectorAll(".quantity-display");

        removeButtons.forEach((button) => {
            button.addEventListener("click", (event) => {
                event.preventDefault();
                const productId = button.getAttribute("data-id");
                const url = `/cart/remove/${productId}`;
                fetch(url, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                })
                    .then((response) => {
                        if (response.ok) {
                            return response.json();
                        }
                        throw new Error("Network response was not ok.");
                    })
                    .then((data) => {
                        // Remove the item from the DOM
                        const itemElement = document.querySelector(`.cart-item[data-id="${productId}"]`);
                        if (itemElement) {
                            itemElement.remove();
                        }
                        // Recalculate the subtotal and update cart count
                        calculateSubtotal();
                        updateCartCount();

                        // If the cart is empty, show the empty cart message
                        const cartItems = document.querySelectorAll(".cart-item");
                        if (cartItems.length === 0) {
                            document.getElementById("empty-cart-message").classList.remove("hidden");
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                    });
            });
        });

        quantityInputs.forEach((display) => {
            const productId = display.getAttribute("id").split("-")[1];
            const decreaseButton = document.querySelector(
                `.decrease-quantity[data-id="${productId}"]`
            );
            const increaseButton = document.querySelector(
                `.increase-quantity[data-id="${productId}"]`
            );

            decreaseButton.addEventListener("click", (event) => {
                event.preventDefault();
                let quantity = parseInt(display.innerText);
                if (quantity > 1) {
                    quantity -= 1;
                    display.innerText = quantity;
                    updateCart(productId, quantity);
                    calculateSubtotal();
                    updateCartCount();
                }
            });

            increaseButton.addEventListener("click", (event) => {
                event.preventDefault();
                let quantity = parseInt(display.innerText);
                quantity += 1;
                display.innerText = quantity;
                updateCart(productId, quantity);
                calculateSubtotal();
                updateCartCount();
            });
        });

        function updateCart(productId, quantity) {
            const url = `/cart/update/${productId}/${quantity}`;
            fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify({
                    productId: productId,
                    quantity: quantity,
                }),
            })
                .then((response) => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error("Network response was not ok.");
                })
                .then((data) => {
                    console.log("Cart updated successfully.");
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        }

        function calculateSubtotal() {
            let subtotal = 0;
            const quantityDisplays = document.querySelectorAll(".quantity-display");
            quantityDisplays.forEach((display) => {
                const productId = display.getAttribute("id").split("-")[1];
                const priceElement = document.querySelector(
                    `.product-price[data-id="${productId}"]`
                );

                if (priceElement) {
                    const price = parseFloat(priceElement.innerText.replace("$", ""));
                    const quantity = parseInt(display.innerText);
                    subtotal += price * quantity;
                }
            });
            document.getElementById("subtotal-amount").innerText = `$${subtotal.toFixed(2)}`;
        }

        function updateCartCount() {
            let totalQuantity = 0;
            const quantityDisplays = document.querySelectorAll(".quantity-display");
            quantityDisplays.forEach((display) => {
                totalQuantity += parseInt(display.innerText);
            });
            document.getElementById("cart-count").innerText = totalQuantity;
        }

        calculateSubtotal();
        updateCartCount();
    });
</script>

