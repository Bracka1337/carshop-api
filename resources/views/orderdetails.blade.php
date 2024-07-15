<x-app-layout>
    @include('components.orderoverview', ['order' => $order,
    'cost' => $cost,])
</x-app-layout>