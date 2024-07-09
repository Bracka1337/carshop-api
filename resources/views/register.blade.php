<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/css/app.css')
         <title>Register</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    </head>
    <body class="antialiased bg-gray-100 flex items-center justify-center h-screen">
    
    <div class="register-container bg-white p-8 rounded-lg shadow-md w-96">
        
        <h1 class="text-2xl font-bold text-center text-green-500 mb-4"><a href="/">Register</a></h1>
        <form action="/register" method="post">
            <div class="mb-2">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="text" id="email" name="email" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
    
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="mb-8">
                <label for="password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" id="password" name="password" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
    
            <button type="submit" class="w-full bg-green-50 text-green-800 font-bold py-2 px-4 rounded hover:bg-green-100 focus:outline-none focus:bg-green-100">
                Register
            </button>
        </form>
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">Already have an account?
                <a class="text-green-500 text-decoration-line: underline" href="/login">
                Login
            </a>
        </p>
            
        </div>
    </div>
    
    </body>
    </html>
