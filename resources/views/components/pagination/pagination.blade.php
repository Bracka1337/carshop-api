@if ($paginator->hasPages())
    @php
        $base = 'inline-flex h-10 min-w-10 items-center justify-center gap-1.5 rounded-control px-3 text-sm font-semibold transition';
        $idle = $base.' text-ink-700 hover:bg-ink-200/60';
        $disabled = $base.' cursor-not-allowed text-ink-300';
        $current = $paginator->currentPage();
        $last = $paginator->lastPage();
    @endphp

    <nav role="navigation" aria-label="Pagination" class="flex items-center justify-between gap-2 sm:justify-center">
        @if ($paginator->onFirstPage())
            <span class="{{ $disabled }}" aria-disabled="true">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
                <span class="hidden sm:inline">Previous</span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="{{ $idle }}" aria-label="{{ __('pagination.previous') }}">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
                <span class="hidden sm:inline">Previous</span>
            </a>
        @endif

        <div class="flex items-center gap-1">
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $current)
                            <span aria-current="page" class="{{ $base }} bg-ink-900 text-white">{{ $page }}</span>
                        @elseif ($page == 1 || $page == $last || abs($page - $current) <= 1)
                            <a href="{{ $url }}" class="{{ $idle }}" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a>
                        @elseif (abs($page - $current) == 2)
                            <span class="{{ $base }} text-ink-400" aria-hidden="true">…</span>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="{{ $idle }}" aria-label="{{ __('pagination.next') }}">
                <span class="hidden sm:inline">Next</span>
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
            </a>
        @else
            <span class="{{ $disabled }}" aria-disabled="true">
                <span class="hidden sm:inline">Next</span>
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
            </span>
        @endif
    </nav>
@endif
