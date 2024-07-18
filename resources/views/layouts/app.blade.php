<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    
    <title>Carshop</title>
    {{-- <link rel="icon" href="/public/favicon/favicon.svg" sizes="16x16" type="image/x-icon" > --}}
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon/faviconn.ico') }}" size="32x32">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap">

    <!-- Styles & Scripts -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Page Heading -->
      

        <!-- Page Content -->
        <main>    
            @include('components.NavBar')

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