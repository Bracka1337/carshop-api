@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ? $title.' · '.config('shop.name') : config('shop.name').' · Wheels & rims' }}</title>
    {{ $meta ?? '' }}
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon/faviconn.ico') }}" sizes="32x32">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="flex min-h-screen flex-col bg-ink-50 font-sans text-ink-900 antialiased">
    @include('components.NavBar')
    @include('components.cookie')
    @include('components.cart')

    <main class="flex-1">
        {{ $slot }}
    </main>

    @include('components.footer')
</body>
</html>
