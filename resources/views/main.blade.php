<x-app-layout>
    @php($products = $initialProducts)

    <section class="bg-ink-950 text-white">
        <div class="mx-auto max-w-7xl px-4 pb-10 pt-8 sm:px-6 sm:pb-14 sm:pt-12 lg:px-8">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-accent-400">Alloy &amp; steel wheels</p>
            <h1 class="mt-3 max-w-3xl font-display text-4xl font-bold leading-[1.05] tracking-tight sm:text-5xl lg:text-6xl">
                Wheels &amp; rims, shipped across the EU
            </h1>
            <p class="mt-4 flex items-center gap-2 text-sm text-ink-300 sm:text-base">
                <svg class="h-5 w-5 shrink-0 text-accent-400" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                </svg>
                Free delivery on orders over @money(config('shop.shipping.free_from'), 0). Prices include VAT.
            </p>
        </div>
    </section>

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:grid lg:grid-cols-[15rem_minmax(0,1fr)] lg:gap-8 lg:px-8 lg:py-10">
        @include('components.search', ['options' => $options, 'priceRange' => $priceRange, 'clearFiltersUrl' => $clearFiltersUrl])

        <section aria-labelledby="results-heading">
            <h2 id="results-heading" class="sr-only">Wheels</h2>

            {{-- Toolbar: filters button (mobile), result count, sort. --}}
            <div class="flex flex-wrap items-center gap-3 border-b border-ink-200 pb-4">
                <button type="button" data-filters-open aria-controls="filters-panel"
                    class="inline-flex items-center gap-2 rounded-control border border-ink-300 bg-white px-3 py-2 text-sm font-semibold text-ink-800 shadow-card hover:bg-ink-50 lg:hidden">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                    </svg>
                    Filters
                    @if (count($activeFilters))
                        <span class="rounded-full bg-accent-500 px-1.5 text-xs text-ink-950">{{ count($activeFilters) }}</span>
                    @endif
                </button>

                <p class="text-sm text-ink-600" aria-live="polite">
                    @if ($products->total())
                        Showing <span class="font-semibold text-ink-900">{{ $products->firstItem() }}–{{ $products->lastItem() }}</span>
                        of <span class="font-semibold text-ink-900">{{ $products->total() }}</span> {{ Str::plural('wheel', $products->total()) }}
                    @else
                        <span class="font-semibold text-ink-900">0</span> wheels
                    @endif
                </p>

                <div class="ml-auto flex items-center gap-2">
                    <label for="order" class="hidden text-sm text-ink-600 sm:block">Sort by</label>
                    <select id="order" name="order" form="filters" data-autosubmit
                        class="rounded-control border-ink-300 bg-white py-2 pl-3 pr-9 text-sm font-medium text-ink-900 shadow-card focus:border-accent-500 focus:ring-accent-500">
                        <option value="">Recommended</option>
                        @foreach (\App\Http\Controllers\Web\CatalogueController::SORT_OPTIONS as $value => $label)
                            <option value="{{ $value }}" @selected(request('order') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if (count($activeFilters))
                <div class="flex flex-wrap items-center gap-2 pt-4" aria-label="Active filters">
                    @foreach ($activeFilters as $chip)
                        <a href="{{ $chip['url'] }}"
                            class="group inline-flex items-center gap-1.5 rounded-full bg-ink-900 py-1.5 pl-3 pr-2 text-xs font-medium text-white hover:bg-ink-700">
                            {{ $chip['label'] }}
                            <svg class="h-3.5 w-3.5 text-ink-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                            <span class="sr-only">Remove filter</span>
                        </a>
                    @endforeach
                    <a href="{{ $clearFiltersUrl }}" class="ml-1 text-xs font-semibold text-accent-700 underline-offset-2 hover:underline">Clear all</a>
                </div>
            @endif

            @if ($products->isEmpty())
                <div class="mt-6 flex flex-col items-center rounded-card border border-dashed border-ink-300 bg-white px-6 py-16 text-center">
                    <span class="relative inline-block h-14 w-14 rounded-full border-[10px] border-ink-200" aria-hidden="true">
                        <span class="absolute inset-[6px] rounded-full bg-ink-100"></span>
                    </span>
                    <h3 class="mt-5 font-display text-2xl font-semibold text-ink-900">No wheels match these filters</h3>
                    <p class="mt-2 max-w-sm text-sm text-ink-600">Try a different size or a wider price range, or clear the filters to see the whole catalogue.</p>
                    <a href="{{ $clearFiltersUrl }}"
                        class="mt-6 rounded-control bg-ink-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-ink-800">Clear all filters</a>
                </div>
            @else
                <div class="mt-6 grid grid-cols-1 gap-4 min-[480px]:grid-cols-2 sm:gap-6 xl:grid-cols-3">
                    @foreach ($products as $product)
                        <x-product-card :product="$product" :eager="$loop->index < 3" />
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $products->onEachSide(1)->links('components.pagination.pagination') }}
                </div>
            @endif
        </section>
    </div>
</x-app-layout>
