@php
    use App\Enums\WheelSpec;
    use Illuminate\Support\Str;

    $brand = $product->brand;
    $images = $product->images;
    $description = Str::limit(Str::squish($product->description), 155);
    $url = route('products.show', $product);
    $image = $product->imageUrl();
@endphp

<x-app-layout :title="$product->title">
    <x-slot:meta>
        <meta name="description" content="{{ $description }}">
        <link rel="canonical" href="{{ $url }}">
        <meta property="og:type" content="product">
        <meta property="og:site_name" content="{{ config('shop.name') }}">
        <meta property="og:title" content="{{ $product->title }}">
        <meta property="og:description" content="{{ $description }}">
        <meta property="og:url" content="{{ $url }}">
        @if ($image)
            <meta property="og:image" content="{{ $image }}">
        @endif
        <meta property="product:price:amount" content="{{ number_format((float) $product->price, 2, '.', '') }}">
        <meta property="product:price:currency" content="{{ \App\Support\Money::code() }}">
        <meta name="twitter:card" content="summary_large_image">
    </x-slot:meta>

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 lg:py-10">
        <nav aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center gap-1.5 text-sm text-ink-500">
                <li><a href="{{ route('main') }}" class="hover:text-ink-900">Catalogue</a></li>
                @if ($brand)
                    <li aria-hidden="true">/</li>
                    <li><a href="{{ route('main', ['brand' => $brand->id]) }}" class="hover:text-ink-900">{{ $brand->title }}</a></li>
                @endif
                <li aria-hidden="true">/</li>
                <li aria-current="page" class="font-medium text-ink-900">{{ $product->modelName() }}</li>
            </ol>
        </nav>

        <div class="mt-6 grid gap-8 lg:grid-cols-2 lg:gap-12">
            {{-- Gallery --}}
            <div data-gallery>
                <div class="aspect-square overflow-hidden rounded-card bg-ink-100 ring-1 ring-ink-200/60">
                    @if ($image)
                        <img data-gallery-main src="{{ $image }}" alt="{{ $product->title }}" width="800" height="800"
                            class="h-full w-full object-contain p-8 mix-blend-multiply sm:p-12">
                    @endif
                </div>
                @if ($images->count() > 1)
                    <ul class="mt-3 grid grid-cols-4 gap-3 sm:grid-cols-5">
                        @foreach ($images as $i => $thumb)
                            <li>
                                <button type="button" data-gallery-thumb="{{ asset('storage/'.$thumb->img_uri) }}"
                                    aria-label="Show photo {{ $i + 1 }}" aria-pressed="{{ $i === 0 ? 'true' : 'false' }}"
                                    class="block aspect-square w-full overflow-hidden rounded-control bg-ink-100 ring-1 ring-ink-200 transition hover:ring-ink-400 aria-pressed:ring-2 aria-pressed:ring-ink-900">
                                    <img src="{{ asset('storage/'.$thumb->img_uri) }}" alt="" loading="lazy"
                                        class="h-full w-full object-contain p-2 mix-blend-multiply">
                                </button>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Summary --}}
            <div>
                @if ($brand)
                    <a href="{{ route('main', ['brand' => $brand->id]) }}" class="text-sm font-semibold uppercase tracking-wider text-ink-500 hover:text-ink-900">{{ $brand->title }}</a>
                @endif
                <h1 class="mt-1 font-display text-4xl font-bold leading-tight text-ink-950 sm:text-5xl">{{ $product->modelName() }}</h1>

                <ul class="mt-4 flex flex-wrap gap-1.5">
                    @foreach (WheelSpec::KEY as $spec)
                        <li class="rounded-full bg-ink-100 px-3 py-1 text-sm font-medium text-ink-700">
                            <span class="sr-only">{{ $spec->label() }}: </span>{{ $spec->short($product) }}
                        </li>
                    @endforeach
                </ul>

                <p class="mt-6 flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-ink-950">@money($product->price)</span>
                    <span class="text-sm text-ink-500">incl. {{ config('shop.vat_rate') * 100 }}% VAT</span>
                </p>

                <p class="mt-3 flex items-center gap-2 text-sm font-medium text-ink-700">
                    <span class="h-2 w-2 rounded-full bg-emerald-500" aria-hidden="true"></span>
                    Available to order
                </p>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" data-add-to-cart class="mt-6 flex gap-3">
                    @csrf
                    <div class="inline-flex items-center rounded-control border border-ink-300 bg-white" data-quantity>
                        <button type="button" data-quantity-step="-1" class="h-12 w-11 text-lg text-ink-700 hover:bg-ink-100" aria-label="Decrease quantity">−</button>
                        <label for="quantity" class="sr-only">Quantity</label>
                        <input id="quantity" name="quantity" type="number" min="1" max="99" value="1" inputmode="numeric"
                            class="h-12 w-12 border-0 p-0 text-center font-semibold text-ink-900 [appearance:textfield] focus:ring-0 [&::-webkit-inner-spin-button]:appearance-none">
                        <button type="button" data-quantity-step="1" class="h-12 w-11 text-lg text-ink-700 hover:bg-ink-100" aria-label="Increase quantity">+</button>
                    </div>
                    <button type="submit" data-state="idle"
                        class="flex h-12 flex-1 items-center justify-center rounded-control bg-accent-500 px-6 text-base font-semibold text-ink-950 shadow-card transition hover:bg-accent-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-accent-500 focus-visible:ring-offset-2 data-[state=loading]:cursor-wait">
                        <span data-when="idle">Add to cart</span>
                        <span data-when="loading">Adding…</span>
                        <span data-when="added">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                            Added to cart
                        </span>
                    </button>
                </form>
                @error('quantity')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <p class="mt-4 text-sm text-ink-600">
                    Free delivery across the EU on orders over @money(config('shop.shipping.free_from'), 0).
                </p>

                <div class="mt-8 border-t border-ink-200 pt-6">
                    <h2 class="font-display text-xl font-semibold uppercase tracking-wide text-ink-950">Description</h2>
                    <p class="mt-3 leading-7 text-ink-700">{{ $product->description }}</p>
                </div>

                <div class="mt-8">
                    <h2 class="font-display text-xl font-semibold uppercase tracking-wide text-ink-950">Specifications</h2>
                    <table class="mt-3 w-full text-sm">
                        <tbody class="divide-y divide-ink-200 border-y border-ink-200">
                            @foreach (WheelSpec::cases() as $spec)
                                <tr>
                                    <th scope="row" class="py-2.5 pr-4 text-left font-normal text-ink-600">{{ $spec->labelWithUnit() }}</th>
                                    <td class="py-2.5 text-right font-semibold text-ink-900">{{ $spec->value($product) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($similar->isNotEmpty())
            <section class="mt-16" aria-labelledby="similar-heading">
                <h2 id="similar-heading" class="font-display text-3xl font-bold text-ink-950">Similar wheels</h2>
                <p class="mt-1 text-sm text-ink-600">
                    Same {{ WheelSpec::Diameter->short($product) }} diameter and {{ WheelSpec::BoltPattern->short($product) }} bolt pattern.
                </p>
                <div class="mt-6 grid grid-cols-1 gap-4 min-[480px]:grid-cols-2 sm:gap-6 lg:grid-cols-4">
                    @foreach ($similar as $wheel)
                        <x-product-card :product="$wheel" />
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</x-app-layout>
