<x-app-layout>
    <section class="relative">
        <div class="w-full max-w-7xl px-4 md:px-5 lg-6 mx-auto">
            <div class="container mx-auto p-8">
                <h1 class="text-5xl font-bold text-left text-indigo-500 mb-8">Hello, {{ $user->username }}</h1>
                <h2 class="text-3xl font-semibold text-gray-800 mb-8">Your Orders:</h2>

                
                @if ($user->orders->isEmpty())
                <div class="bg-white p-8 rounded-lg   shadow-md">
                
                        <p class="text-gray-600 ">You have no orders </p>
        
        
                </div>
                
                @else
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <ul>
                        @foreach ($user->orders as $order)
                        <a href="{{ route('orderdetails', ['id' => $order->id]) }}"><li class="hover:bg-indigo-200 rounded-lg flex items-center ">
                            <div class=" p-4">
                                <img class =" w-30 rounded-lg" src="{{ asset('/storage/' . $order->productQuantities[0]->product->images[0]->img_uri) }} " alt="Product Image" class="object-cover w-full h-full rounded-lg shadow-md">
                            </div>
                            <div class="">
                                <p class="text-lg font-medium text-gray-900">Order #{{ $order->id }}</p>
                                <p class="text-sm text-gray-600">Placed on {{ \Carbon\Carbon::parse($order->date)->format('F j, Y') }}</p>
                                <p class="text-sm text-gray-600">Status: {{ $order->status }}</p>
                                <p class="text-sm text-gray-600">Total: ${{ number_format($order->total, 2) }}</p>
                                
                            </div>
                            
                        </li></a>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </section>    
 
</x-app-layout>