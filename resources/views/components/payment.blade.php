<section class="py-8 antialiased md:py-16">
    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
        <div class="mx-auto max-w-5xl">
            <h2 class="text-xl font-semibold text-ink-900 sm:text-2xl">Payment</h2>

            <div class="mt-6 sm:mt-8 lg:flex lg:items-start lg:gap-12">
                <form action="{{ route('processPayment') }}" method="POST"
                    class="w-full rounded-lg border border-ink-200 bg-white p-4 shadow-sm sm:p-6 lg:max-w-xl lg:p-8">
                    @csrf
                    <div class="mb-6 grid grid-cols-2 gap-4">
                        <div class="col-span-2 sm:col-span-1">
                            <label for="full_name" class="mb-2 block text-sm font-medium text-ink-900"> Full name (as
                                displayed on card)* </label>
                            <input type="text" id="full_name" name="full_name" pattern="[A-Za-z\s]+"
                                class="block w-full rounded-lg border border-ink-300 bg-ink-50 p-2.5 text-sm text-ink-900 focus:border-accent-500 focus:ring-accent-500"
                                oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');"
                                placeholder="Janis Berzins" title="Full name should only contain letters." required />
                            @error('full_name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label for="card-number-input" class="mb-2 block text-sm font-medium text-ink-900"> Card
                                number* </label>
                            <input type="text" id="card-number-input" name="card_number"
                                class="block w-full rounded-lg border border-ink-300 bg-ink-50 p-2.5 pe-10 text-sm text-ink-900 focus:border-accent-500 focus:ring-accent-500"
                                placeholder="xxxx xxxx xxxx xxxx" pattern="^\d{4}\s\d{4}\s\d{4}\s\d{4}$" maxlength="19"
                                required />
                            @error('card_number')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="card-expiration-input" class="mb-2 block text-sm font-medium text-ink-900">Card
                                expiration*
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">

                                </div>
                                <input name="expiry_date" id="card-expiration-input" type="text"
                                    pattern="^(0[1-9]|1[0-2])\/?([0-9]{4}|[0-9]{2})$" maxlength="5"
                                    class="block w-full rounded-lg border border-ink-300 bg-ink-50 p-2.5 text-sm text-ink-900 focus:border-accent-500 focus:ring-accent-500"
                                    placeholder="01/23" required />
                            </div>
                            @error('expiry_date')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="cvv-input"
                                class="mb-2 flex items-center gap-1 text-sm font-medium text-ink-900">CVV*</label>
                            <input type="text" name="cvv" id="cvv-input" pattern="\d{3}"
                                class="block w-full rounded-lg border border-ink-300 bg-ink-50 p-2.5 text-sm text-ink-900 focus:border-accent-500 focus:ring-accent-500"
                                placeholder="•••" maxlength="3" title="Please enter exactly 3 digits for CVV."
                                required />
                            @error('cvv')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <button type="submit"
                        class="flex w-full items-center justify-center rounded-lg bg-ink-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-ink-700 focus:outline-none focus:ring-4 focus:ring-accent-500">Pay
                        now</button>
                </form>


                <div class="mt-6 grow sm:mt-8 lg:mt-0">
                    <div class="space-y-4 rounded-lg border border-ink-100 bg-ink-50 p-6">
                        <div class="space-y-2">
                            <dl class="flex items-center justify-between gap-4">
                                <dt class="text-base font-normal text-ink-500">Original price</dt>
                                <dd class="text-base font-medium text-ink-900">
                                    @money($cart['subtotal'])</dd>
                            </dl>

                            <dl class="flex items-center justify-between gap-4">
                                <dt class="text-base font-normal text-ink-500">Tax</dt>
                                <dd class="text-base font-medium text-ink-900">@money($cart['tax'])</dd>
                            </dl>
                        </div>
                        @if (isset($cart['shipping']) && $cart['shipping'] > 0)
                            <dl class="flex items-center justify-between gap-4">
                                <dt class="text-base font-normal text-ink-500 dark:text-ink-400">Shipping</dt>
                                <dd class="text-base font-medium text-ink-900">@money($cart['shipping'])
                                </dd>
                            </dl>
                        @else
                            <dl class="flex items-center justify-between gap-4">
                                <dt class="text-base font-normal text-ink-500 dark:text-ink-400">Shipping</dt>
                                <dd class="text-base font-medium text-ink-900">Free</dd>
                            </dl>
                        @endif

                        <dl class="flex items-center justify-between gap-4 border-t border-ink-200 pt-2">
                            <dt class="text-base font-bold text-ink-900">Total</dt>
                            <dd class="text-base font-bold text-ink-900">@money($cart['total'])</dd>
                        </dl>
                    </div>

                    <div class="mt-6 flex items-center justify-center gap-8">
                        <img class="h-8 w-auto"
                            src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/visa.svg"
                            alt="" />
                        <img class="h-8 w-auto"
                            src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/mastercard.svg"
                            alt="" />
                    </div>
                </div>
            </div>

            <p class="mt-6 text-center text-ink-500 sm:mt-8 lg:text-left">
                Payment processed by <a href="/" title=""
                    class="font-medium text-accent-700 underline hover:no-underline">{{ config('shop.name') }}</a>
                - Latvia
            </p>
        </div>
    </div>
</section>