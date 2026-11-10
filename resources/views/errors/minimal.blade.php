<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · {{ config('shop.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="flex min-h-screen flex-col items-center justify-center bg-ink-950 px-4 py-16 text-center font-sans text-white antialiased">
    <x-logo />

    <p class="mt-14 font-display text-8xl font-bold leading-none text-accent-500 sm:text-9xl">@yield('code')</p>
    <h1 class="mt-4 font-display text-3xl font-bold sm:text-4xl">@yield('message')</h1>
    <p class="mt-3 max-w-md text-ink-300">Sorry about that. The catalogue is a good place to start again.</p>

    <a href="{{ route('main') }}"
        class="mt-8 rounded-control bg-accent-500 px-5 py-2.5 text-sm font-semibold text-ink-950 shadow-card hover:bg-accent-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-accent-500 focus-visible:ring-offset-2 focus-visible:ring-offset-ink-950">
        Back to the catalogue
    </a>
</body>

</html>
