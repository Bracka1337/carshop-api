@php
    $route = Route::currentRouteName();
    $showCart = ! in_array($route, ['checkout', 'paymentSuccess', 'payment-details'], true);
    $cartCount = app(\App\Services\CartService::class)->count();
    $navLink = 'rounded-control px-3 py-2 text-sm font-medium text-ink-300 transition hover:bg-white/5 hover:text-white';
    $active = 'text-white';
@endphp

<header class="sticky top-0 z-20 bg-ink-950 text-white">
    @unless ($route === 'main')
        <p class="bg-ink-900 px-4 py-2 text-center text-xs font-medium text-ink-300">
            Free delivery across the EU on orders over <span class="text-accent-400">@money(config('shop.shipping.free_from'), 0)</span>
        </p>
    @endunless

    <nav aria-label="Main" class="mx-auto flex h-16 max-w-7xl items-center gap-2 px-4 sm:px-6 lg:px-8">
        @include('components.sidebar')

        <x-logo class="mr-4" />

        <div class="hidden items-center gap-1 lg:flex">
            <a href="{{ route('main') }}" id="homeButton" @class([$navLink, $active => $route === 'main'])>Wheels</a>
            <a href="{{ route('aboutus') }}" @class([$navLink, $active => $route === 'aboutus'])>About us</a>
            @auth
                <a href="{{ route('profile.show') }}" id="myOrdersButton" @class([$navLink, $active => $route === 'profile.show'])>My orders</a>
            @endauth
        </div>

        <div class="ml-auto flex items-center gap-1">
            <x-notification />

            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="{{ $navLink }}">Log out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="{{ $navLink }}">Sign in</a>
            @endauth

            @if ($showCart)
                <button id="open-button" type="button"
                    class="relative ml-1 flex h-10 w-10 items-center justify-center rounded-control text-ink-200 transition hover:bg-white/5 hover:text-white">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <span id="cart-count"
                        class="{{ $cartCount ? '' : 'hidden' }} absolute -right-0.5 -top-0.5 flex h-5 min-w-5 items-center justify-center rounded-full bg-accent-500 px-1 text-[11px] font-bold text-ink-950">{{ $cartCount }}</span>
                    <span class="sr-only">items in cart, view cart</span>
                </button>
            @endif
        </div>
    </nav>
</header>
