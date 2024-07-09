<x-app-layout> 
    <x-slot name="header">

    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{-- @foreach($products as $product)
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div class="flex items
                        -center justify-between">
                            <div class="font-bold">{{ $product->name }}</div>
                            <div class="font-bold">{{ $product->price }}</div>
                    </div>
                @endforeach --}}
            </div>
        </div>
    </div>
</x-app-layout>