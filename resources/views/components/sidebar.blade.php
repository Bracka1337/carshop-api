@if (Route::currentRouteName() !== 'checkout')
<div class="relative z-20 md:ml-0 lg:hidden " role="dialog" aria-modal="true">

    <button type="button"
        class="justify-center w-full rounded-md px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500"
        id="menu-button" aria-expanded="false" aria-haspopup="true">
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
            fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd"
                d="M4 5h12a1 1 0 010 2H4a1 1 0 010-2zM4 9h12a1 1 0 010 2H4a1 1 0 010-2zM4 13h12a1 1 0 010 2H4a1 1 0 010-2z"
                clip-rule="evenodd" />
        </svg>
    </button>
    <div class="fixed inset-0 overflow-hidden overflow-hidden bg-gray-500 bg-opacity-75 transition-opacity hidden"
        id="sidebar-modal">
        <div class="pointer-events-auto w-screen max-w-md fixed inset-0 overflow-hidden bg-white transition-opacity flex flex-col"
            id="sidebar-menu">
            <button type="button" class="relative m-2 p-2 text-gray-400 hover:text-gray-500"
                id="close-button">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <a href="/"
                class="block px-8 py-4 text-sm text-lg text-gray-700 hover:text-gray-800 w-[fit-content]"
                role="menuitem" id="homeButton">Home</a>
            <a href="/aboutus"
                class="block px-8 py-4 text-sm text-lg text-gray-700 hover:text-gray-800 w-[fit-content]"
                role="menuitem">About us</a>
            @auth <a href="/profile"
                    class="block px-8 py-4 text-sm text-lg text-gray-700 hover:text-gray-800 w-[fit-content]"
                role="menuitem" id="myOrdersButton">My orders</a> @endauth

            <div class="mt-auto flex justify-center border-t py-10 px-4 sm:px-6">
                <img class="transform scale-50" src="{{ asset('images/logo2.svg') }}"
                    alt="EastSquad logo">
            </div>
        </div>
    </div>
</div>
@endif