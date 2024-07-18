@if (session('success'))
    <div id="successMessage" 
        class="fixed bottom-0 right-0 m-6 p-4 bg-green-500 text-white rounded-lg shadow-lg transition-opacity duration-500 ease-out">
        <p>{{ session('success') }}</p>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function() {
                document.getElementById('successMessage').classList.add('opacity-0');
            }, 2000);

            setTimeout(function() {
                document.getElementById('successMessage').remove();
            }, 2500);
        });
    </script>
@endif
