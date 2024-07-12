@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center">
        <div class="flex items-center gap-4">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <button
                  class="flex items-center gap-2 px-6 py-3 font-sans text-xs font-bold text-center text-indigo-600 uppercase align-middle transition-all rounded-full select-none hover:bg-indigo-600/10 active:bg-indigo-600/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                  type="button" disabled>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    aria-hidden="true" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
                  </svg>
                  Previous
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="flex items-center gap-2 px-6 py-3 font-sans text-xs font-bold text-center text-indigo-600 uppercase align-middle transition-all rounded-full select-none hover:bg-indigo-600/10 active:bg-indigo-600/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                   aria-label="{{ __('pagination.previous') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                         aria-hidden="true" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
                    </svg>
                    Previous
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-full text-center align-middle font-sans text-xs font-medium uppercase text-indigo-600 transition-all disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page"
                                  class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-full bg-indigo-600 text-center align-middle font-sans text-xs font-medium uppercase text-white shadow-md shadow-indigo-600/10 transition-all hover:shadow-lg hover:shadow-indigo-600/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                                <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">{{ $page }}</span>
                            </span>
                        @else
                            <a href="{{ $url }}"
                               class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-full text-center align-middle font-sans text-xs font-medium uppercase text-indigo-600 transition-all hover:bg-indigo-600/10 active:bg-indigo-600/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                               aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">{{ $page }}</span>
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="flex items-center gap-2 px-6 py-3 font-sans text-xs font-bold text-center text-indigo-600 uppercase align-middle transition-all rounded-full select-none hover:bg-indigo-600/10 active:bg-indigo-600/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                   aria-label="{{ __('pagination.next') }}">
                    Next
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                         aria-hidden="true" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                    </svg>
                </a>
            @else
                <button
                  class="flex items-center gap-2 px-6 py-3 font-sans text-xs font-bold text-center text-indigo-600 uppercase align-middle transition-all rounded-full select-none hover:bg-indigo-600/10 active:bg-indigo-600/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                  type="button" disabled>
                  Next
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    aria-hidden="true" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                  </svg>
                </button>
            @endif
        </div>
    </nav>
@endif
