{{-- Text logo: a rim-like ring and the shop name. --}}
@props(['tone' => 'light'])

<a href="{{ route('main') }}" {{ $attributes->class('inline-flex items-center gap-2 font-display text-2xl font-bold uppercase leading-none tracking-wide') }}>
    <span class="relative inline-block h-6 w-6 rounded-full border-[5px] border-accent-500" aria-hidden="true">
        <span class="absolute inset-[3px] rounded-full {{ $tone === 'light' ? 'bg-white' : 'bg-ink-900' }}"></span>
    </span>
    <span class="{{ $tone === 'light' ? 'text-white' : 'text-ink-950' }}">{{ config('shop.name') }}</span>
</a>
