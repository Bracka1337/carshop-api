{{-- Catalogue filters: a sidebar on desktop, a slide-over below lg. --}}
@php
    $input = 'block w-full rounded-control border-ink-300 bg-white py-2 text-sm text-ink-900 placeholder:text-ink-400 focus:border-accent-500 focus:ring-accent-500';
@endphp

<div id="filters-panel" class="fixed inset-0 z-40 hidden lg:static lg:z-auto lg:block" role="dialog" aria-modal="true" aria-label="Filters">
    <div class="absolute inset-0 bg-ink-950/60 lg:hidden" data-filters-close></div>

    <aside class="absolute inset-y-0 left-0 flex w-full max-w-xs flex-col bg-white shadow-panel lg:sticky lg:bottom-auto lg:top-24 lg:max-w-none lg:rounded-card lg:shadow-card lg:ring-1 lg:ring-ink-200/60">
        <div class="flex items-center justify-between border-b border-ink-200 px-5 py-4">
            <h2 class="font-display text-lg font-semibold uppercase tracking-wide text-ink-900">Filters</h2>
            <button type="button" data-filters-close class="-mr-2 flex h-9 w-9 items-center justify-center rounded-control text-ink-500 hover:bg-ink-100 lg:hidden">
                <span class="sr-only">Close filters</span>
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="filters" action="{{ route('main') }}" method="get" class="flex flex-1 flex-col overflow-y-auto">
            <div class="flex-1 space-y-5 px-5 py-5">
                <x-inputSelect name="brand" label="Brand" placeholder="All brands" :options="$options['brand']" />
                <x-inputSelect name="diameter" label="Diameter" placeholder="Any diameter" :options="$options['diameter']" />
                <x-inputSelect name="width" label="Width" placeholder="Any width" :options="$options['width']" />

                <fieldset>
                    <legend class="text-sm font-semibold text-ink-900">Type</legend>
                    <div class="mt-2 grid grid-cols-3 gap-1 rounded-control bg-ink-100 p-1">
                        @foreach (['' => 'All'] + $options['type'] as $value => $label)
                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="{{ $value }}" class="peer sr-only" @checked((string) request('type') === (string) $value)>
                                <span class="block rounded-[0.375rem] px-2 py-1.5 text-center text-sm font-medium text-ink-600 peer-checked:bg-white peer-checked:text-ink-950 peer-checked:shadow-card peer-focus-visible:ring-2 peer-focus-visible:ring-accent-500">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>

                <fieldset>
                    <legend class="text-sm font-semibold text-ink-900">Price <span class="font-normal text-ink-500">({{ \App\Support\Money::symbol() }}, incl. VAT)</span></legend>
                    <div class="mt-2 flex items-center gap-2">
                        <label for="priceFrom" class="sr-only">Price from</label>
                        <input type="number" name="price_from" id="priceFrom" min="0" step="1" inputmode="numeric"
                            value="{{ request('price_from') }}" placeholder="{{ floor((float) $priceRange['min']) }}" class="{{ $input }}">
                        <span class="text-ink-400" aria-hidden="true">–</span>
                        <label for="priceTo" class="sr-only">Price to</label>
                        <input type="number" name="price_to" id="priceTo" min="0" step="1" inputmode="numeric"
                            value="{{ request('price_to') }}" placeholder="{{ ceil((float) $priceRange['max']) }}" class="{{ $input }}">
                    </div>
                    @foreach (['price_from', 'price_to'] as $field)
                        @error($field)
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    @endforeach
                </fieldset>
            </div>

            <div class="flex items-center gap-3 border-t border-ink-200 px-5 py-4">
                <a href="{{ $clearFiltersUrl }}" class="text-sm font-semibold text-ink-600 hover:text-ink-900">Clear all</a>
                <button type="submit"
                    class="ml-auto rounded-control bg-accent-500 px-5 py-2.5 text-sm font-semibold text-ink-950 shadow-card hover:bg-accent-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-accent-500 focus-visible:ring-offset-2">
                    Show wheels
                </button>
            </div>
        </form>
    </aside>
</div>
