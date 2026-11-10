<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/css/app.css')
         <title>Sign in · {{ config('shop.name') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    </head>
    
    <body class="flex min-h-screen flex-col items-center justify-center bg-ink-950 px-4 py-10 font-sans text-ink-900 antialiased">
    
    <div class="login-container w-full max-w-sm rounded-card bg-white p-8 shadow-panel">
        <div class="-mx-8 -mt-8 mb-6 flex justify-center rounded-t-card bg-ink-900 py-5">
            <x-logo />
        </div>
        <h1 class="mb-5 font-display text-3xl font-bold text-ink-950">Login</h1>
        <form action="{{ route('login.store') }}" method="post">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-ink-700">E-mail</label>
                <input type="text" id="email" name="email" required
                       class="mt-1 block w-full px-3 py-2 border border-ink-300 rounded-control shadow-sm focus:outline-none focus:ring-accent-500 focus:border-accent-500 sm:text-sm">
            </div>
    
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-ink-700">Password</label>
                <input type="password" id="password" name="password" required
                       class="mt-1 block w-full px-3 py-2 border border-ink-300 rounded-control shadow-sm focus:outline-none focus:ring-accent-500 focus:border-accent-500 sm:text-sm">
            </div>         

            @if ($errors->any())
                <div class="mb-6 p-4 border border-red-500 bg-red-100 text-red-700 rounded" alert alert-danger>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <button type="submit" class="w-full rounded-control bg-accent-500 px-4 py-2.5 font-semibold text-ink-950 shadow-card hover:bg-accent-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-accent-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                Login
            </button>
        </form>
        <div class="mt-4 text-center">
            <p class="text-sm text-ink-600">Don't have an account?
                <a class="font-semibold text-accent-700 hover:underline" href="/register" >
                Register
            </a>
        </p>
            
        </div>
    </div>
    
    </body>
    </html>
