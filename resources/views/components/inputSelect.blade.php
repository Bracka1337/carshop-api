{{-- Labelled select for the catalogue filters. $options is value => label. --}}
@props(['name', 'label', 'options' => [], 'placeholder' => ''])

<div>
    <label for="{{ $name }}" class="block text-sm font-semibold text-ink-900">{{ $label }}</label>
    <select id="{{ $name }}" name="{{ $name }}"
        class="mt-2 block w-full rounded-control border-ink-300 bg-white py-2 text-sm text-ink-900 focus:border-accent-500 focus:ring-accent-500">
        <option value="">{{ $placeholder }}</option>
        @foreach ($options as $value => $optionLabel)
            <option value="{{ $value }}" @selected((string) request($name) === (string) $value)>{{ $optionLabel }}</option>
        @endforeach
    </select>
    @error($name)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
