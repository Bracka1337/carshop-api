<x-app-layout>

@foreach($products as $product)
    <div class="container mx-auto">
        <div class="flex flex-wrap">
            <div class="w-1/2">
                <img src="{{ $product->image }}" alt="{{ $product->name }}">
            </div>
            <div class="w-1/2">
                <h2>{{ $product->name }}</h2>
                <p>{{ $product->description }}</p>
                <p>{{ $product->price }}</p>
            </div>
        </div>
    </div>
@endforeach
{{ }}
</x-app-layout>

