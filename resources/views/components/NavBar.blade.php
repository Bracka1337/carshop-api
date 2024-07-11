<div class="">

    <div class="relative z-40 lg:hidden" role="dialog" aria-modal="true">


        <div class="fixed inset-0 z-40 flex">


            <!-- side mobile menue   for now keep same headings as on main navbar -->
            <div class="relative flex w-full max-w-[250px] flex-col  items-center overflow-y-auto bg-white pb-12 ">



                <div class="flex flex-col gap-5">
                    <div class="ml-4 flex lg:ml-0">
                        <a href="#">
                            <span class="sr-only">Your Company</span>
                            <img class="h-10 w-auto" src="{{ asset('images/logo2.svg') }}" alt="">
                        </a>
                    </div>

                    <a href="#"
                        class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Home</a>
                    <a href="#"
                        class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">About us</a>
                    <a href="#"
                        class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Products</a>


                </div>



            </div>
        </div>
    </div>

    <header class="relative bg-white">
        <p
            class="flex h-10 items-center justify-center bg-indigo-600 px-4 text-sm font-medium text-white sm:px-6 lg:px-8">
            Get free delivery on orders over $100</p>

        <nav aria-label="Top" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="border-b border-gray-200">
                <div class="flex h-16 items-center">

                    <!-- Logo -->
                    <div class="ml-4 flex lg:ml-0">
                        <a href="#">
                            <span class="sr-only">East Squad</span>
                            <img class="h-10 w-auto" src="{{ asset('images/logo2.svg') }}" alt="EastSquad logo">
                        </a>
                    </div>

                    <div class="hidden lg:ml-8 lg:block lg:self-stretch">
                        <div class="flex h-full space-x-8">
                            <div class="flex">
                                <div class="relative flex">
                                    <button type="button"
                                        class="relative z-10 -mb-px flex items-center border-b-2 border-transparent pt-px text-sm font-medium text-gray-700 transition-colors duration-200 ease-out hover:text-gray-800"
                                        aria-expanded="false">Home</button>
                                </div>


                            </div>

                            <a href="#"
                                class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">About
                                us</a>
                            <a href="#"
                                class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Products</a>
                        </div>
                    </div>

                    <div class="ml-auto flex items-center">


                        <!-- Cart display only if logged in -->
                        @if (Route::has('login'))
                            <div class="space-x-4">
                                @auth
                                    <div class="space-y-6 border-gray-200 px-4 py-6">

                                        <a href="{{ route('logout') }}"
                                            class="text-sm font-medium text-gray-700 hover:text-gray-800">
                                            Log out
                                        </a>
                                    </div>
                                @else
                                    <div class="space-y-6 border-gray-200 px-4 py-6">
                                        <a href="{{ route('login') }}"
                                            class="text-sm font-medium text-gray-700 hover:text-gray-800">
                                            Sign in
                                        </a>
                                    </div>

                                @endauth
                            </div>
                            <div class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-end lg:space-x-6">

                                <span class="h-6 w-px bg-gray-200" aria-hidden="true"></span>
                            </div>
                        @endif

                        <div class="ml-4 flow-root lg:ml-6">
                            <button id="open-button" type="button" class="group -m-2 flex items-center p-2">
                                <svg class="h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                                <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800">{{ count((array) session('cart')) }}</span>
                            </button>
                            @if (session('success'))
                                <div class="text-sm text-green-400">{{ session('success') }}</div>
                            @endif
                        </div>
                        

                    </div>
                </div>
            </div>
        </nav>
    </header>
</div>
