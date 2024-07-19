<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    @vite('resources/css/app.css')
    
    <title>Carshop</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon/faviconn.ico') }}" size="32x32">

    <!-- Styles & Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Page Heading -->
        
        <!-- Page Content -->
        <main>    
            @include('components.NavBar')
            @include('components.cookie')

            @if (Route::currentRouteName() == 'main')
                
                @include('components.banner')
            @endif
            
            @include('components.cart')
            {{ $slot }}


        </main>

        <!-- Footer -->
           
    </div>
    @include('components.footer')
    <script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
</body>
</html>