@if (session('success'))
<div class="flex flex-col gap-2 w-52 sm:w-60 text-[10px] sm:text-xs z-10" id="success-message">
    <div class="succsess-alert cursor-default flex items-center justify-between w-full h-10 rounded-lg bg-indigo-600 px-[10px]">
        <div class="flex items-center gap-2">
            <div class="flex items-center justify-center  h-6 text-white bg-indigo-600 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"></path>
                </svg>
            </div>
            <div class="text-sm text-white">{{ session('success') }}</div>
        </div>
        
    </div>
</div>
@endif