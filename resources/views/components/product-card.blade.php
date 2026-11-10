{{-- Catalogue card. Needs the product's brand and images loaded. --}}
@props(['product', 'eager' => false])

<article class="group relative flex flex-col overflow-hidden rounded-card bg-white shadow-card ring-1 ring-ink-200/60 transition duration-200 hover:-translate-y-0.5 hover:shadow-card-hover">
    <button type="button" data-quick-view="{{ $product->id }}" class="block text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-accent-500">
        <span class="sr-only">Quick view: {{ $product->title }}</span>
        <div class="relative aspect-[4/3] bg-ink-100 {{ $product->imageUrl() ? 'animate-pulse' : '' }}">
            @if ($imageUrl = $product->imageUrl())
                <img src="{{ $imageUrl }}" alt="" width="480" height="360"
                    loading="{{ $eager ? 'eager' : 'lazy' }}" decoding="async"
                    onload="this.classList.remove('opacity-0'); this.parentElement.classList.remove('animate-pulse')"
                    onerror="this.parentElement.classList.remove('animate-pulse')"
                    class="h-full w-full object-contain p-5 opacity-0 mix-blend-multiply transition duration-300 group-hover:scale-[1.03]">
            @endif
            <span class="absolute left-3 top-3 rounded-full bg-white/90 px-2 py-0.5 text-[11px] font-semibold uppercase tracking-wider text-ink-600 ring-1 ring-ink-200">{{ $product->type }}</span>
        </div>
    </button>

    <div class="flex flex-1 flex-col p-4">
        <p class="text-xs font-semibold uppercase tracking-wider text-ink-500">{{ $product->brand?->title }}</p>
        <h3 class="mt-0.5 font-display text-xl font-semibold leading-tight text-ink-950">{{ $product->modelName() }}</h3>

        <ul class="mt-3 flex flex-wrap gap-1.5">
            @foreach (\App\Enums\WheelSpec::KEY as $spec)
                <li class="rounded-full bg-ink-100 px-2.5 py-1 text-xs font-medium text-ink-700" title="{{ $spec->label() }}">
                    <span class="sr-only">{{ $spec->label() }}: </span>{{ $spec->short($product) }}
                </li>
            @endforeach
        </ul>

        <div class="mt-auto flex items-end justify-between gap-3 pt-5">
            <p>
                <span class="block text-xl font-bold leading-none text-ink-950">@money($product->price)</span>
                <span class="mt-1 block text-[11px] text-ink-500">incl. VAT</span>
            </p>
            <form action="{{ route('cart.add', $product->id) }}" method="POST" data-add-to-cart>
                @csrf
                <button type="submit" data-state="idle"
                    class="inline-flex h-10 min-w-[7.5rem] items-center justify-center gap-1.5 rounded-control bg-ink-900 px-4 text-sm font-semibold text-white transition hover:bg-ink-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-accent-500 focus-visible:ring-offset-2 data-[state=added]:bg-accent-500 data-[state=added]:text-ink-950 data-[state=loading]:cursor-wait">
                    <span data-when="idle">Add to cart</span>
                    <span data-when="loading" aria-hidden="true">
                        <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-opacity=".25" stroke-width="3" /><path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round" /></svg>
                        Adding
                    </span>
                    <span data-when="added">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        Added
                    </span>
                </button>
            </form>
        </div>
    </div>
</article>
