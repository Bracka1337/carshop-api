<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
    <title>Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="antialiased bg-gray-100 flex flex-col min-h-screen ">
    <div class="container mx-auto p-8">
        <h1 class="text-2xl font-bold text-left text-indigo-600 mb-4">Hello, {{ $user->name }}</h1>
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Your Orders:</h2>

        <!--<div class="bg-white p-8 rounded-lg   shadow-md">
           
                <p class="text-gray-600 ">You have no orders :(</p>


        </div>-->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <ul>
                @foreach ($user->orders as $order)
                <a href="/"><li class="hover:bg-indigo-200 rounded-lg flex items-center ">
                    <div class=" p-4">
                        <img class =" w-30 rounded-lg" src="https://cdn.discordapp.com/attachments/1260118461368238105/1260130360122015764/Screenshot_20240709_091501_Gallery1.jpg?ex=668e3359&is=668ce1d9&hm=15e1a82db57076c7be16f09dffbf0f0c8fdab85969ba119b4c3de2c356236757&" alt="Product Image" class="object-cover w-full h-full rounded-lg shadow-md">
                    </div>
                    <div class="">
                        <p class="text-lg font-medium text-gray-900">Order #{{ $order->id }}</p>
                        <p class="text-sm text-gray-600">Placed on J{{ $order->date->format('F j, Y') }}</p>
                        <p class="text-sm text-gray-600">Status: {{ $order->status }}</p>
                        <p class="text-sm text-gray-600">Total: ${{ number_format($order->total, 2) }}</p>
                        
                    </div>
                    
                </li></a>
                @endforeach
            </ul>
        </div>
    </div>
    @include('components.footer')
</body>
</html>