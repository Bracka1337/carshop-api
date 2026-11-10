<footer class="mt-16 bg-ink-950 text-ink-400">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:grid-cols-2 sm:px-6 lg:grid-cols-4 lg:px-8">
        <div class="lg:col-span-2">
            <x-logo />
            <p class="mt-4 max-w-sm text-sm leading-6">
                Alloy and steel wheels from 13″ to 22″, shipped across the EU.
                Prices include {{ config('shop.vat_rate') * 100 }}% VAT.
            </p>
        </div>
        <div>
            <h2 class="font-display text-sm font-semibold uppercase tracking-wider text-white">Shop</h2>
            <ul class="mt-4 space-y-2 text-sm">
                <li><a href="{{ route('main') }}" class="hover:text-white">All wheels</a></li>
                <li><a href="{{ route('aboutus') }}" class="hover:text-white">About us</a></li>
            </ul>
        </div>
        <div>
            <h2 class="font-display text-sm font-semibold uppercase tracking-wider text-white">Contact</h2>
            <ul class="mt-4 space-y-2 text-sm">
                <li><a href="mailto:{{ config('shop.contact.email') }}" class="hover:text-white">{{ config('shop.contact.email') }}</a></li>
                <li>{{ config('shop.contact.phone') }}</li>
            </ul>
        </div>
    </div>
    <div class="border-t border-white/10">
        <p class="mx-auto max-w-7xl px-4 py-6 text-xs sm:px-6 lg:px-8">
            &copy; {{ date('Y') }} {{ config('shop.name') }}. Built for the Magebit Summer Bootcamp 2024.
        </p>
    </div>
</footer>
