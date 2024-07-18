<div class="p-4">
    <label for="et" class="block mt-2 text-sm font-medium text-gray-900">ET (Offset)</label>
    <select id="et" name="et"
        class="block mt-2 w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 hover:shadow-md">
        <option value="">Choose an ET</option>
        @foreach ($et as $e)
            <option value="{{ $e->et }}" {{ request('et') == $e->et ? 'selected' : '' }}>
                {{ $e->et }}</option>
        @endforeach
    </select>
    @if ($errors->has('et'))
        <p class="text-red-500 text-xs mt-1">{{ $errors->first('et') }}</p>
    @endif
</div>


<div class="p-4">
    <label for="cb" class="block mt-2 text-sm font-medium text-gray-900">CB (Center Bore)</label>
    <select id="cb" name="cb"
        class="block mt-2 w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 hover:shadow-md">
        <option value="">Choose a CB</option>
        @foreach ($cb as $c)
            <option value="{{ $c->cb }}" {{ request('cb') == $c->cb ? 'selected' : '' }}>
                {{ $c->cb }}</option>
        @endforeach
    </select>
    @if ($errors->has('cb'))
        <p class="text-red-500 text-xs mt-1">{{ $errors->first('cb') }}</p>
    @endif
</div>



<div class="p-4">
    <label for="bolt_diameter" class="block mt-2 text-sm font-medium text-gray-900">Bolt Diameter</label>
    <select id="bolt_diameter" name="bolt_diameter"
        class="block mt-2 w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 hover:shadow-md">
        <option value="">Choose a bolt diameter</option>
        @foreach ($bolt_diameter as $bd)
            <option value="{{ $bd->bolt_diameter }}"
                {{ request('bolt_diameter') == $bd->bolt_diameter ? 'selected' : '' }}>
                {{ $bd->bolt_diameter }}</option>
        @endforeach
    </select>
    @if ($errors->has('bolt_diameter'))
        <p class="text-red-500 text-xs mt-1">{{ $errors->first('bolt_diameter') }}</p>
    @endif
</div>


<div class="p-4">
    <label for="bolt" class="block mt-2 text-sm font-medium text-gray-900">Bolt Pattern</label>
    <select id="bolt" name="bolt"
        class="block mt-2 w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 hover:shadow-md">
        <option value="">Choose a bolt pattern</option>
        @foreach ($bolt as $b)
            <option value="{{ $b->bolt }}" {{ request('bolt') == $b->bolt ? 'selected' : '' }}>
                {{ $b->bolt }}</option>
        @endforeach
    </select>
    @if ($errors->has('bolt'))
        <p class="text-red-500 text-xs mt-1">{{ $errors->first('bolt') }}</p>
    @endif
</div>
