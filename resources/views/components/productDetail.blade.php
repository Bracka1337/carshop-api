{{-- Quick view, opened from a catalogue card. --}}
@props(['product'])

<div data-quick-view-modal="{{ $product->id }}" class="fixed inset-0 z-30 hidden overflow-y-auto bg-ink-950/60 p-4 sm:p-8"
    role="dialog" aria-modal="true" aria-labelledby="quick-view-title-{{ $product->id }}">
    <div data-quick-view-panel class="relative mx-auto grid max-w-5xl overflow-hidden rounded-card bg-white shadow-panel md:grid-cols-2">
        <button type="button" data-quick-view-close
            class="absolute right-3 top-3 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-white/90 text-ink-600 ring-1 ring-ink-200 hover:text-ink-950 focus:outline-none focus-visible:ring-2 focus-visible:ring-accent-500">
            <span class="sr-only">Close</span>
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
        </button>

        {{-- Gallery --}}
        <div class="relative aspect-square overflow-hidden bg-ink-100 md:aspect-auto md:min-h-[28rem]">
            <div class="flex h-full transition-transform duration-500 ease-out" data-carousel-inner>
                @foreach ($product->images as $key => $image)
                    <div class="flex-100" data-carousel-item="{{ $key }}">
                        <img src="{{ asset('/storage/'.$image->img_uri) }}" alt="{{ $product->title }}, photo {{ $key + 1 }}" loading="lazy"
                            class="h-full w-full object-contain p-8 mix-blend-multiply">
                    </div>
                @endforeach
            </div>
            <div class="absolute bottom-4 left-1/2 flex -translate-x-1/2 gap-2" data-carousel-indicators>
                @foreach ($product->images as $key => $image)
                    <button type="button" data-carousel-slide-to aria-label="Show photo {{ $key + 1 }}"
                        class="h-2 w-2 rounded-full transition {{ $key === 0 ? 'bg-ink-900' : 'bg-ink-300' }}"></button>
                @endforeach
            </div>
            @if ($product->images->count() > 1)
                <button type="button" data-carousel-prev aria-label="Previous photo"
                    class="absolute left-3 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-ink-700 shadow-card hover:text-ink-950">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
                </button>
                <button type="button" data-carousel-next aria-label="Next photo"
                    class="absolute right-3 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-ink-700 shadow-card hover:text-ink-950">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                </button>
            @endif
        </div>

        {{-- Details --}}
        <div class="flex flex-col p-6 sm:p-8">
            <p class="text-xs font-semibold uppercase tracking-wider text-ink-500">{{ $product->brand?->title }}</p>
            <h2 id="quick-view-title-{{ $product->id }}" class="mt-1 font-display text-3xl font-bold leading-tight text-ink-950">{{ $product->modelName() }}</h2>
            <p class="mt-3 text-2xl font-bold text-ink-950">@money($product->price) <span class="text-xs font-normal text-ink-500">incl. VAT</span></p>
            <p class="mt-4 text-sm leading-6 text-ink-600">{{ $product->description }}</p>

            <dl class="mt-6 divide-y divide-ink-200 border-y border-ink-200 text-sm">
                @foreach (['Type' => 'type', 'Diameter' => 'diameter', 'Width' => 'width', 'Offset (ET)' => 'et', 'Centre bore' => 'cb', 'Bolts' => 'bolt', 'Bolt circle' => 'bolt_diameter'] as $label => $field)
                    <div class="flex justify-between py-2">
                        <dt class="text-ink-500">{{ $label }}</dt>
                        <dd class="font-semibold text-ink-900">{{ $product->$field }}</dd>
                    </div>
                @endforeach
            </dl>

            @if (! Request::is('*/orderdetails/*'))
                <form action="{{ route('cart.add', $product->id) }}" method="POST" data-add-to-cart class="mt-6">
                    @csrf
                    <button type="submit" data-state="idle"
                        class="flex h-12 w-full items-center justify-center rounded-control bg-accent-500 px-6 text-base font-semibold text-ink-950 shadow-card hover:bg-accent-400 data-[state=loading]:cursor-wait">
                        <span data-when="idle">Add to cart</span>
                        <span data-when="loading">Adding…</span>
                        <span data-when="added">Added to cart</span>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
