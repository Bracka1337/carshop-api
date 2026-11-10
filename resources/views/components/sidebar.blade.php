{{-- Mobile menu: a button in the header and a slide-over from the left. --}}
@if (Route::currentRouteName() !== 'checkout')
    <div class="lg:hidden">
        <button type="button" id="menu-button" aria-expanded="false" aria-controls="sidebar-modal"
            class="-ml-2 flex h-10 w-10 items-center justify-center rounded-control text-ink-200 hover:bg-white/5 hover:text-white">
            <span class="sr-only">Open menu</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
            </svg>
        </button>

        <div id="sidebar-modal" class="fixed inset-0 z-40 hidden bg-ink-950/60" role="dialog" aria-modal="true" aria-label="Menu">
            <div id="sidebar-menu" class="flex h-full w-full max-w-xs flex-col bg-ink-950 shadow-panel">
                <div class="flex h-16 items-center justify-between px-4">
                    <x-logo />
                    <button type="button" id="close-button" class="flex h-10 w-10 items-center justify-center rounded-control text-ink-300 hover:bg-white/5 hover:text-white">
                        <span class="sr-only">Close menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <nav class="flex flex-col gap-1 px-2 py-4 text-base font-medium">
                    <a href="{{ route('main') }}" class="rounded-control px-3 py-3 text-ink-100 hover:bg-white/5">Wheels</a>
                    <a href="{{ route('aboutus') }}" class="rounded-control px-3 py-3 text-ink-100 hover:bg-white/5">About us</a>
                    @auth
                        <a href="{{ route('profile.show') }}" class="rounded-control px-3 py-3 text-ink-100 hover:bg-white/5">My orders</a>
                    @endauth
                </nav>
                <p class="mt-auto border-t border-white/10 px-5 py-6 text-sm text-ink-400">
                    Free EU delivery over @money(config('shop.shipping.free_from'), 0)
                </p>
            </div>
        </div>
    </div>
@endif
