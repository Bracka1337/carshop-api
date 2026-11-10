@php
    $items = array_filter(session('cart', []), 'is_array');
    $hasItems = array_sum(array_column($items, 'quantity')) > 0;
@endphp

<div class="flex items-center justify-between border-b border-ink-200 px-5 py-4">
    <h2 class="font-display text-xl font-semibold uppercase tracking-wide text-ink-950" id="slide-over-title">Your cart</h2>
    <button id="cart-close-button" type="button" class="-mr-2 flex h-9 w-9 items-center justify-center rounded-control text-ink-500 hover:bg-ink-100 hover:text-ink-900">
        <span class="sr-only">Close panel</span>
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>

<div class="flex-1 overflow-y-auto px-5">
    @if ($hasItems)
        <ul role="list" class="divide-y divide-ink-200" id="cart-items">
            @foreach ($items as $id => $details)
                <li class="cart-item flex gap-4 py-5" data-id="{{ $id }}">
                    <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-control bg-ink-100">
                        @if (! empty($details['image']))
                            <img src="{{ asset('/storage/'.$details['image']) }}" alt="" class="h-full w-full object-contain p-1.5 mix-blend-multiply">
                        @endif
                    </div>
                    <div class="flex flex-1 flex-col">
                        <div class="flex justify-between gap-3">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-ink-500">{{ $details['brand'] ?? '' }}</p>
                                <h3 class="text-sm font-semibold text-ink-900">{{ \App\Models\Product::withoutBrand($details['title'] ?? 'N/A', $details['brand'] ?? null) }}</h3>
                            </div>
                            <p class="product-price whitespace-nowrap text-sm font-semibold text-ink-900" data-id="{{ $id }}" data-price="{{ $details['price'] ?? 0 }}">
                                {{ isset($details['price']) ? \App\Support\Money::format($details['price']) : 'N/A' }}
                            </p>
                        </div>
                        <div class="mt-auto flex items-center justify-between pt-3 text-sm">
                            <div class="quantity-control inline-flex items-center rounded-control border border-ink-300">
                                <button type="button" class="decrease-quantity h-8 w-8 text-ink-700 hover:bg-ink-100" data-id="{{ $id }}" aria-label="Decrease quantity">−</button>
                                <span id="quantity-{{ $id }}" class="quantity-display w-8 text-center font-semibold text-ink-900">{{ $details['quantity'] ?? 1 }}</span>
                                <button type="button" class="increase-quantity h-8 w-8 text-ink-700 hover:bg-ink-100" data-id="{{ $id }}" aria-label="Increase quantity">+</button>
                            </div>
                            <a href="{{ route('cart.remove', ['id' => $id]) }}" data-id="{{ $id }}" class="remove-item font-medium text-ink-500 hover:text-ink-900">Remove</a>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

    <p id="empty-cart-message" class="py-16 text-center text-sm text-ink-500 {{ $hasItems ? 'hidden' : '' }}">Your cart is empty.</p>
</div>

<div class="border-t border-ink-200 px-5 py-5">
    <div class="flex justify-between text-base font-semibold text-ink-950">
        <p>Subtotal</p>
        <p id="subtotal-amount" data-currency="{{ \App\Support\Money::symbol() }}">@money(0)</p>
    </div>
    <p class="mt-0.5 text-xs text-ink-500">Incl. VAT. Shipping calculated at checkout.</p>
    @if ($hasItems)
        <a id="checkout" href="{{ route('checkout') }}"
            class="mt-5 flex items-center justify-center rounded-control bg-accent-500 px-6 py-3 text-base font-semibold text-ink-950 shadow-card hover:bg-accent-400">Checkout</a>
    @endif
    <p class="mt-4 text-center text-sm text-ink-500">
        or <button id="continue-shopping" type="button" class="font-semibold text-ink-900 hover:underline">Continue shopping <span aria-hidden="true">&rarr;</span></button>
    </p>
</div>
