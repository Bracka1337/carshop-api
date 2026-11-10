@if (session('success'))
    <div id="success-message" role="status"
        class="fixed right-4 top-20 z-50 flex items-center gap-2 rounded-control bg-ink-900 px-4 py-3 text-sm font-medium text-white shadow-panel ring-1 ring-white/10">
        <svg class="h-5 w-5 text-accent-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
        </svg>
        {{ session('success') }}
    </div>
@endif
