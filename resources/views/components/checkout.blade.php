<section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16">

    @if (session('cart') && count(session('cart')) > 0)
        <form action="{{ route('proceedToPayment') }}" method="GET" class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            @csrf
            <ol
                class="items-center flex w-full max-w-2xl text-center text-sm font-medium text-gray-500 dark:text-gray-400 sm:text-base">
                <li
                    class="after:border-1 flex items-center text-primary-700 after:mx-6 after:hidden after:h-1 after:w-full after:border-b after:border-gray-200 dark:text-primary-500 dark:after:border-gray-700 sm:after:inline-block sm:after:content-[''] md:w-full xl:after:mx-10">
                    <span
                        class="flex items-center after:mx-2 after:text-gray-200 after:content-['/'] dark:after:text-gray-500 sm:after:hidden">
                        <svg class="me-2 h-4 w-4 sm:h-5 sm:w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Cart
                    </span>
                </li>
                <li
                    class="after:border-1 flex items-center text-primary-700 after:mx-6 after:hidden after:h-1 after:w-full after:border-b after:border-gray-200 dark:text-primary-500 dark:after:border-gray-700 sm:after:inline-block sm:after:content-[''] md:w-full xl:after:mx-10">
                    <span
                        class="flex items-center after:mx-2 after:text-gray-200 after:content-['/'] dark:after:text-gray-500 sm:after:hidden">
                        <svg class="me-2 h-4 w-4 sm:h-5 sm:w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Checkout
                    </span>
                </li>
                <li class="flex shrink-0 items-center">
                    <svg class="me-2 h-4 w-4 sm:h-5 sm:w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Order summary
                </li>
            </ol>

            <div class="mt-6 sm:mt-8 lg:flex lg:items-start lg:gap-12 xl:gap-16">
                <div class="min-w-0 flex-1 space-y-8">
                    {{-- Order Summary --}}
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Delivery Details</h2>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label for="f_name"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">First
                                    name*</label>
                                <input type="text" id="f_name" name="f_name"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="Bonnie" pattern="[A-Za-z\s]+"
                                    title="First name should only contain letters." required
                                    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" />
                                @error('f_name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="m_name"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Middle
                                    name</label>
                                <input type="text" id="m_name" name="m_name"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    pattern="[A-Za-z\s]+" title="Middle name should only contain letters."
                                    placeholder="" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" />
                                @error('m_name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="l_name"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Last
                                    name*</label>
                                <input type="text" id="l_name" name="l_name"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="Green" pattern="[A-Za-z\s]+"
                                    title="Last name should only contain letters." required
                                    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" />
                                @error('l_name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="your_email"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Your
                                    email*</label>
                                <input type="email" id="your_email" name="your_email"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400"
                                    value="{{ Auth::user()->email }}" readonly />
                                @error('your_email')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="city"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">City*</label>
                                <input type="text" id="city" name="city"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="Riga" pattern="[A-Za-z\s]+" title="City should only contain letters."
                                    required />
                                @error('city')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <div class="mb-2 flex items-center gap-2">
                                    <label for="select-country-input-3"
                                        class="block text-sm font-medium text-gray-900 dark:text-white">Country*</label>
                                </div>
                                <select id="select-country-input-3" name="country"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    required>
                                    <option value="Latvia" selected>Latvia</option>
                                    <option value="LT">Lithuania</option>
                                    <option value="EST">Estonia</option>
                                </select>
                                @error('country')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="addr_line_1"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Address Line
                                    1*</label>
                                <input type="text" id="addr_line_1" name="addr_line_1"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="Green Street 12" required />
                                @error('addr_line_1')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="addr_line_2"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Address Line
                                    2</label>
                                <input type="text" id="addr_line_2" name="addr_line_2"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="Green Street 12" />
                                @error('addr_line_2')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone-input-3"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Phone
                                    Number*</label>
                                <div class="flex items-center">
                                    <button id="dropdown-phone-button-3" data-dropdown-toggle="dropdownDivider"
                                        class="az-10 inline-flex items-center rounded-s-lg border border-gray-300 bg-gray-100 px-4 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-700"
                                        type="button">
                                        <span class="inline-flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="me-2 h-4 w-4"
                                                fill="none" viewBox="0 0 200 100">
                                                <rect width="200" height="40" fill="#CF142B" />
                                                <rect y="40" width="200" height="20" fill="#FFFFFF" />
                                                <rect y="60" width="200" height="40" fill="#CF142B" />
                                            </svg>
                                            +371
                                        </span>
                                        <svg class="-me-0.5 ms-2 h-4 w-4" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div id="dropdown-phone-3"
                                        class="bg-gray-100 mt-40 absolute z-10 hidden w-56 divide-y divide-gray-100 rounded-lg bg-white shadow dark:bg-gray-700">
                                        <ul class="p-2 text-sm font-medium text-gray-700 dark:text-gray-200"
                                            aria-labelledby="dropdown-phone-button-3">
                                            <li>
                                                <button type="button"
                                                    class="dropdown-item inline-flex w-full rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-indigo-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                                    role="menuitem">
                                                    <span class="inline-flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="me-2 h-4 w-4"
                                                            fill="none" viewBox="0 0 200 100">
                                                            <rect width="200" height="40" fill="#CF142B" />
                                                            <rect y="40" width="200" height="20"
                                                                fill="#FFFFFF" />
                                                            <rect y="60" width="200" height="40"
                                                                fill="#CF142B" />
                                                        </svg>
                                                        +371
                                                    </span>
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button"
                                                    class="dropdown-item inline-flex w-full rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-indigo-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                                    role="menuitem">
                                                    <span class="inline-flex items-center">
                                                        <svg class="w-4 h-4 me-2" fill="none" viewBox="0 0 20 15">
                                                            <rect width="19.6" height="14" y=".5" fill="#fff"
                                                                rx="2" />
                                                            <mask id="a" style="mask-type:luminance"
                                                                width="20" height="15" x="0" y="0"
                                                                maskUnits="userSpaceOnUse">
                                                                <rect width="19.6" height="14" y=".5"
                                                                    fill="#fff" rx="2" />
                                                            </mask>
                                                            <g mask="url(#a)">
                                                                <path fill="#FFD700" fill-rule="evenodd"
                                                                    d="M0 5.167h19.6V.5H0v4.667z"
                                                                    clip-rule="evenodd" />
                                                                <g filter="url(#filter0_d_374_135180)">
                                                                    <path fill="#006A4E" fill-rule="evenodd"
                                                                        d="M0 9.833h19.6V5.167H0v4.666z"
                                                                        clip-rule="evenodd" />
                                                                </g>
                                                                <g filter="url(#filter1_d_374_135180)">
                                                                    <path fill="#C1272D" fill-rule="evenodd"
                                                                        d="M0 14.5h19.6V9.833H0V14.5z"
                                                                        clip-rule="evenodd" />
                                                                </g>
                                                            </g>
                                                            <defs>
                                                                <filter id="filter0_d_374_135180" width="19.6"
                                                                    height="4.667" x="0" y="5.167"
                                                                    color-interpolation-filters="sRGB"
                                                                    filterUnits="userSpaceOnUse">
                                                                    <feFlood flood-opacity="0"
                                                                        result="BackgroundImageFix" />
                                                                    <feColorMatrix in="SourceAlpha" result="hardAlpha"
                                                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" />
                                                                    <feOffset />
                                                                    <feColorMatrix
                                                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.06 0" />
                                                                    <feBlend in2="BackgroundImageFix"
                                                                        result="effect1_dropShadow_374_135180" />
                                                                    <feBlend in="SourceGraphic"
                                                                        in2="effect1_dropShadow_374_135180"
                                                                        result="shape" />
                                                                </filter>
                                                                <filter id="filter1_d_374_135180" width="19.6"
                                                                    height="4.667" x="0" y="9.833"
                                                                    color-interpolation-filters="sRGB"
                                                                    filterUnits="userSpaceOnUse">
                                                                    <feFlood flood-opacity="0"
                                                                        result="BackgroundImageFix" />
                                                                    <feColorMatrix in="SourceAlpha" result="hardAlpha"
                                                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" />
                                                                    <feOffset />
                                                                    <feColorMatrix
                                                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.06 0" />
                                                                    <feBlend in2="BackgroundImageFix"
                                                                        result="effect1_dropShadow_374_135180" />
                                                                    <feBlend in="SourceGraphic"
                                                                        in2="effect1_dropShadow_374_135180"
                                                                        result="shape" />
                                                                </filter>
                                                            </defs>
                                                        </svg>
                                                        +370
                                                    </span>
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button"
                                                    class="dropdown-item inline-flex w-full rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-indigo-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                                    role="menuitem">
                                                    <span class="inline-flex items-center">
                                                        <svg class="w-4 h-4 me-2" fill="none" viewBox="0 0 20 15">
                                                            <rect width="19.6" height="14" y=".5" fill="#fff"
                                                                rx="2" />
                                                            <mask id="a" style="mask-type:luminance"
                                                                width="20" height="15" x="0" y="0"
                                                                maskUnits="userSpaceOnUse">
                                                                <rect width="19.6" height="14" y=".5"
                                                                    fill="#fff" rx="2" />
                                                            </mask>
                                                            <g mask="url(#a)">
                                                                <path fill="#0072CE" fill-rule="evenodd"
                                                                    d="M0 5.167h19.6V.5H0v4.667z"
                                                                    clip-rule="evenodd" />
                                                                <g filter="url(#filter0_d_374_135180)">
                                                                    <path fill="#000000" fill-rule="evenodd"
                                                                        d="M0 9.833h19.6V5.167H0v4.666z"
                                                                        clip-rule="evenodd" />
                                                                </g>
                                                                <g filter="url(#filter1_d_374_135180)">
                                                                    <path fill="#FFFFFF" fill-rule="evenodd"
                                                                        d="M0 14.5h19.6V9.833H0V14.5z"
                                                                        clip-rule="evenodd" />
                                                                </g>
                                                            </g>
                                                            <defs>
                                                                <filter id="filter0_d_374_135180" width="19.6"
                                                                    height="4.667" x="0" y="5.167"
                                                                    color-interpolation-filters="sRGB"
                                                                    filterUnits="userSpaceOnUse">
                                                                    <feFlood flood-opacity="0"
                                                                        result="BackgroundImageFix" />
                                                                    <feColorMatrix in="SourceAlpha" result="hardAlpha"
                                                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" />
                                                                    <feOffset />
                                                                    <feColorMatrix
                                                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.06 0" />
                                                                    <feBlend in2="BackgroundImageFix"
                                                                        result="effect1_dropShadow_374_135180" />
                                                                    <feBlend in="SourceGraphic"
                                                                        in2="effect1_dropShadow_374_135180"
                                                                        result="shape" />
                                                                </filter>
                                                                <filter id="filter1_d_374_135180" width="19.6"
                                                                    height="4.667" x="0" y="9.833"
                                                                    color-interpolation-filters="sRGB"
                                                                    filterUnits="userSpaceOnUse">
                                                                    <feFlood flood-opacity="0"
                                                                        result="BackgroundImageFix" />
                                                                    <feColorMatrix in="SourceAlpha" result="hardAlpha"
                                                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" />
                                                                    <feOffset />
                                                                    <feColorMatrix
                                                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.06 0" />
                                                                    <feBlend in2="BackgroundImageFix"
                                                                        result="effect1 dropShadow_374_135180" />
                                                                    <feBlend in="SourceGraphic"
                                                                        in2="effect1_dropShadow_374_135180"
                                                                        result="shape" />
                                                                </filter>
                                                            </defs>
                                                        </svg>
                                                        +372
                                                    </span>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="relative w-full">
                                        <input type="tel" id="phone-input" name="phone"
                                            class="z-20 block w-full rounded-e-lg border border-s-0 border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:border-s-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500"
                                            inputmode="numeric" pattern="[0-9]{7,16}"
                                            title="Phone number should be numeric and between 7 to 16 digits."
                                            placeholder="29227648" required
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                                        @error('phone')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="company_email"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Company
                                    email</label>
                                <input type="email" id="company_email" name="company_email"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="company@eastsquad.com" />
                                @error('company_email')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="company_name"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Company
                                    name</label>
                                <input type="text" id="company_name" name="company_name"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="East Squad LLC" />
                                @error('company_name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="vat_number"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">VAT
                                    number</label>
                                <input type="text" id="vat_number" name="vat_number"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="DE42313253" />
                                @error('vat_number')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                    </div>
                    {{-- Delivery Details --}}
                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Payment</h3>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <div
                                class="rounded-lg border border-gray-200 bg-gray-50 p-4 ps-4 dark:border-gray-700 dark:bg-gray-800">
                                <div class="flex items-start">
                                    <div class="flex h-5 items-center">
                                        <input id="credit-card" aria-describedby="credit-card-text" type="radio"
                                            name="payment_method" value="credit-card"
                                            class="h-4 w-4 border-gray-300 bg-white text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600"
                                            checked />
                                    </div>

                                    <div class="ms-4 text-sm">
                                        <label for="credit-card"
                                            class="font-medium leading-none text-gray-900 dark:text-white"> Credit
                                            Card</label>
                                        <p id="credit-card-text"
                                            class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">Pay with
                                            your credit card</p>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="rounded-lg border border-gray-200 bg-gray-50 p-4 ps-4 dark:border-gray-700 dark:bg-gray-800">
                                <div class="flex items-start">
                                    <div class="flex h-5 items-center">
                                        <input id="pay-on-delivery" aria-describedby="pay-on-delivery-text"
                                            type="radio" name="payment_method" value="pay-on-delivery"
                                            class="h-4 w-4 border-gray-300 bg-white text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600" />
                                    </div>

                                    <div class="ms-4 text-sm">
                                        <label for="pay-on-delivery"
                                            class="font-medium leading-none text-gray-900 dark:text-white"> Payment on
                                            delivery </label>
                                        <p id="pay-on-delivery-text"
                                            class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">Pay on
                                            delivery</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('payment_method')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Payment Methods --}}
                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Delivery Methods</h3>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <div
                                class="rounded-lg border border-gray-200 bg-gray-50 p-4 ps-4 dark:border-gray-700 dark:bg-gray-800">
                                <div class="flex items-start">
                                    <div class="flex h-5 items-center">
                                        <input id="dhl" aria-describedby="dhl-text" type="radio"
                                            name="delivery_method" value="dhl"
                                            class="h-4 w-4 border-gray-300 bg-white text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600"
                                            checked />
                                    </div>

                                    <div class="ms-4 text-sm">
                                        <label for="dhl"
                                            class="font-medium leading-none text-gray-900 dark:text-white"> DPD
                                        </label>
                                        <p id="dhl-text"
                                            class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">Get it by
                                            Tomorrow</p>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="rounded-lg border border-gray-200 bg-gray-50 p-4 ps-4 dark:border-gray-700 dark:bg-gray-800">
                                <div class="flex items-start">
                                    <div class="flex h-5 items-center">
                                        <input id="express" aria-describedby="express-text" type="radio"
                                            name="delivery_method" value="express"
                                            class="h-4 w-4 border-gray-300 bg-white text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600" />
                                    </div>

                                    <div class="ms-4 text-sm">
                                        <label for="express"
                                            class="font-medium leading-none text-gray-900 dark:text-white"> Venipak
                                        </label>
                                        <p id="express-text"
                                            class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">Get it
                                            yesterday</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('delivery_method')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                {{-- Cart sums Items --}}
                <div class="mt-6 w-full space-y-6 sm:mt-8 lg:mt-0 lg:max-w-xs xl:max-w-md">
                    <div class="flow-root">
                        <div class="-my-3 divide-y divide-gray-200 dark:divide-gray-800">
                            <dl class="flex items-center justify-between gap-4 py-3">
                                <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Subtotal</dt>
                                <dd>
                                    <span class="text-base font-medium text-gray-900 dark:text-white">${{ $cart['subtotal'] }}
                                    </span>
                                </dd>
                            </dl>

                            <dl class="flex items-center justify-between gap-4 py-3">
                                <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Tax</dt>
                                <dd class="text-base font-medium text-gray-900 dark:text-white">${{ $cart['tax'] }}
                                </dd>
                            </dl>

                            @if(isset($cart['shipping']) && $cart['shipping'] > 0)
                             <dl class="flex items-center justify-between gap-4 py-3">
                                <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Shipping</dt>
                                <dd class="text-base font-medium text-gray-900 dark:text-white">${{ $cart['shipping'] }}
                                </dd>
                            </dl>
                            @else
                            <dl class="flex items
                            -center justify-between gap-4 py-3">
                                <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Shipping</dt>
                                <dd class="text-base font-medium text-emerald-500 dark:text-white">Free</dd>
                            </dl>
                            @endif

                            <dl class="flex items-center justify-between gap-4 py-3">
                                <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                                <dd class="text-base font-bold text-gray-900 dark:text-white">${{ $cart['total'] }}
                                </dd>
                            </dl>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <button type="submit"
                            class="flex w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Proceed
                            to Payment</button>
                        <p class="text-sm font-normal text-gray-500 dark:text-gray-400">One or more items in your cart
                            require an account. <a href="/login" title=""
                                class="font-medium text-primary-700 underline hover:no-underline dark:text-primary-500">Sign
                                in or create an account now.</a></p>
                    </div>
                </div>
            </div>
        </form>
    
    @endif
</section>
