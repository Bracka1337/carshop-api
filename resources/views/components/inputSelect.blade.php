@props(['name', 'options', 'selected'])
{{-- {{dd($options)}} --}}
@php
    if (!is_array($options)) {
        if ($name !== 'brand') {
            $options = $options->pluck($name)->toArray();
        }
        else {
            $options = $options->pluck('title', 'id')->toArray();
        }
    }
@endphp
</select>
<div class="p-4">
    <label for="{{ $name }}" class="block mt-2 text-sm font-medium text-gray-900">{{ ucfirst($name)}}</label>
    <select id="{{ $name }}" name="{{ $name }}"
            class="block mt-2 w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 hover:shadow-md">
        <option value="">Choose {{ strtolower($name) }}</option>
        @foreach ($options as $key => $option)
            @php
                $value = $name === 'brand' || $name === 'order' ? $key : $option;
                $isSelected = request($name) == $value ? 'selected' : '';
            @endphp
            <option value="{{ $value }}" {{ $isSelected }}>
                {{$option}}
            </option>
        @endforeach
    </select>
    @if ($errors->has($name))
        <p class="text-red-500 text-xs mt-1">{{ $errors->first($name) }}</p>
    @endif
</div>