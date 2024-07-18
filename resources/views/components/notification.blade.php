
@if (session('success'))
<div class="flex flex-col gap-2 w-60 sm:w-60 text-[10px] sm:text-xs z-10" id="success-message" >
    <div
      class="succsess-alert cursor-default flex items-center justify-between w-full h-10 rounded-lg bg-indigo-600  px-[10px]"
    >
      <div class="flex gap-2">
        <div class="text-white bg-white/5 backdrop-blur-xl rounded-lg">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-6 h-6"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="m4.5 12.75 6 6 9-13.5"
            ></path>
          </svg>
        </div>
            <div class="pt-0.5 text-sm text-white ">{{ session('success') }}</div>
      </div>
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M6 18 18 6M6 6l12 12"
          ></path>
        </svg>
    </div>
  </div>
  @endif