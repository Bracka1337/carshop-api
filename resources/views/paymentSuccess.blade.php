<x-app-layout>
    <div class="flex flex-col items-center pt-20 min-h-screen">
        <div class="flex items-center mt-40 justify-center">
            <svg class="me-2 h-24 w-24 text-green-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24" fill="none">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
        <div class="text-center mt-4">
            <p class="font-bold text-3xl">Payment successful</p>
            <p class="text-gray-500 text-xl mt-2">Your payment has been completed</p>
            <button id="order-details" href="/profile"
                class="mt-6 w-full rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4  focus:ring-primary-300">
                Order Details</button>
        </div>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "/profile";
        }, 4000);

        document.getElementById('order-details').addEventListener('click', function(event) {
            event.preventDefault();
            window.location.href = "/profile";
        });
    </script>
</x-app-layout>
