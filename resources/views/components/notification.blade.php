@if (session('success'))
<div class="fixed top-12 right-4 sm:relative sm:top-2 sm:right-0 w-76 sm:w-76 max-w-md z-50" id="success-message">
    <div class="success-alert cursor-default flex items-center w-full rounded-lg bg-indigo-600 p-4 shadow-md">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div class="ml-3 flex-grow">
            <p class="text-sm text-white">{{ session('success') }}</p>
        </div>
        <button type="button" class="ml-auto flex-shrink-0 text-white focus:outline-none" onclick="this.parentElement.parentElement.remove()">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
@endif