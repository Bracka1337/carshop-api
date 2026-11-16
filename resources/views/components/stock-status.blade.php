{{-- "In stock" / "Only N left" / "Out of stock" with a coloured dot. --}}
@props(['product'])

@php
    [$dot, $label] = match (true) {
        ! $product->inStock() => ['bg-red-500', 'Out of stock'],
        $product->lowStock() => ['bg-amber-500', "Only {$product->stock} left"],
        default => ['bg-emerald-500', 'In stock'],
    };
@endphp

<span {{ $attributes->class('flex items-center gap-1.5 font-medium text-ink-700') }}>
    <span class="h-2 w-2 flex-shrink-0 rounded-full {{ $dot }}" aria-hidden="true"></span>
    {{ $label }}
</span>
