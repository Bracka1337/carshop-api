@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center">
        <div class="flex w-full items-center gap-1 sm:gap-3">
          
            @if ($paginator->onFirstPage())
                <button
                    class="flex items-center gap-2 px-6 py-3 font-sans text-xs font-bold text-center text-indigo-600 uppercase align-middle transition-all rounded-full select-none hover:bg-indigo-600/10 active:bg-indigo-600/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                    type="button" disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        aria-hidden="true" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
                    </svg>
                    <span class="hidden sm:inline">Previous</span>
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="flex items-center gap-2 px-6 py-3 font-sans text-xs font-bold text-center text-indigo-600 uppercase align-middle transition-all rounded-full select-none hover:bg-indigo-600/10 active:bg-indigo-600/20"
                    aria-label="{{ __('pagination.previous') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        aria-hidden="true" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
                    </svg>
                    <span class="hidden sm:inline">Previous</span>
                </a>
            @endif

            
            @php
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();
@endphp

@foreach ($elements as $element)
    @if (is_array($element))
        @foreach ($element as $page => $url)
            @if ($page == $currentPage)
                <span aria-current="page" class="relative h-8 sm:h-10 max-h-[40px] w-8 sm:w-10 max-w-[40px] select-none rounded-full bg-indigo-600 text-center align-middle font-sans text-xs font-medium uppercase text-white shadow-md shadow-indigo-600/10 transition-all hover:shadow-lg hover:shadow-indigo-600/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                    <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">{{ $page }}</span>
                </span>
            @elseif ($page == 1 || $page == $lastPage || ($page >= $currentPage - 1 && $page <= $currentPage + 1))
                <a href="{{ $url }}" class="relative h-8 sm:h-10 max-h-[40px] w-8 sm:w-10 max-w-[40px] select-none rounded-full text-center align-middle font-sans text-xs font-medium uppercase text-indigo-600 transition-all hover:bg-indigo-600/10 active:bg-indigo-600/20" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                    <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">{{ $page }}</span>
                </a>
            @elseif ($page == $currentPage - 2 || $page == $currentPage + 2)
                <span class="flex items-center justify-center h-8 sm:h-10 max-h-[40px] w-8 sm:w-10 max-w-[40px] select-none rounded-full text-center align-middle font-sans text-xs font-medium uppercase text-indigo-600 transition-all disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">...</span>
            @endif
        @endforeach
    @endif
@endforeach

           
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="flex items-center gap-2 px-6 py-3 font-sans text-xs font-bold text-center text-indigo-600 uppercase align-middle transition-all rounded-full select-none hover:bg-indigo-600/10 active:bg-indigo-600/20"
                    aria-label="{{ __('pagination.next') }}">
                    <span class="hidden sm:inline">Next</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        aria-hidden="true" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                    </svg>
                </a>
            @else
                <button
                    class="flex items-center gap-2 px-6 py-3 font-sans text-xs font-bold text-center text-indigo-600 uppercase align-middle transition-all rounded-full select-none hover:bg-indigo-600/10 active:bg-indigo-600/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                    type="button" disabled>
                    <span class="hidden sm:inline">Next</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        aria-hidden="true" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                    </svg>
                </button>
            @endif
        </div>
    </nav>
@endif