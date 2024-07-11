<div class="search">
    <div class="flex items-center justify-center mt-40">
        <form action="{{ route('main') }}" method="get"
            class="bg-white p-6 rounded-lg shadow-lg grid grid-cols-4 gap-2 w-full max-w-5xl">
            <div class="p-4">
                <label for="diameter" class="block mt-2 text-sm font-medium text-gray-900 dark:text-white">Diameter</label>
                <select id="diameter" name="diameter"
                    class="block mt-2 w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 hover:shadow-md">
                    <option value="">Choose a diameter</option>
                    @foreach ($diameter as $dia)
                        <option value="{{ $dia->diameter }}" {{ request('diameter') == $dia->diameter ? 'selected' : '' }}>{{ $dia->diameter }}</option>
                    @endforeach
                </select>
            </div>
            <div class="p-4">
                <label for="width" class="block mt-2 text-sm font-medium text-gray-900 dark:text-white">Width</label>
                <select id="width" name="width"
                    class="block mt-2 w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 hover:shadow-md">
                    <option value="">Choose a width</option>
                    @foreach ($width as $w)
                        <option value="{{ $w->width }}" {{ request('width') == $w->width ? 'selected' : '' }}>{{ $w->width }}</option>
                    @endforeach
                </select>
            </div>
            <div class="p-4">
                <label for="et" class="block mt-2 text-sm font-medium text-gray-900 dark:text-white">ET (Offset)</label>
                <select id="et" name="et"
                    class="block mt-2 w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 hover:shadow-md">
                    <option value="">Choose an ET</option>
                    @foreach ($et as $e)
                        <option value="{{ $e->et }}" {{ request('et') == $e->et ? 'selected' : '' }}>{{ $e->et }}</option>
                    @endforeach
                </select>
            </div>
            <div class="p-4">
                <label for="cb" class="block mt-2 text-sm font-medium text-gray-900 dark:text-white">CB (Center Bore)</label>
                <select id="cb" name="cb"
                    class="block mt-2 w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 hover:shadow-md">
                    <option value="">Choose a CB</option>
                    @foreach ($cb as $c)
                        <option value="{{ $c->cb }}" {{ request('cb') == $c->cb ? 'selected' : '' }}>{{ $c->cb }}</option>
                    @endforeach
                </select>
            </div>
            <div class="p-4">
                <label for="bolt" class="block mt-2 text-sm font-medium text-gray-900 dark:text-white">Bolt Pattern</label>
                <select id="bolt" name="bolt"
                    class="block mt-2 w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 hover:shadow-md">
                    <option value="">Choose a bolt pattern</option>
                    @foreach ($bolt as $b)
                        <option value="{{ $b->bolt }}" {{ request('bolt') == $b->bolt ? 'selected' : '' }}>{{ $b->bolt }}</option>
                    @endforeach
                </select>
            </div>
            <div class="p-4">
                <label for="bolt_diameter" class="block mt-2 text-sm font-medium text-gray-900 dark:text-white">Bolt Diameter</label>
                <select id="bolt_diameter" name="bolt_diameter"
                    class="block mt-2 w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 hover:shadow-md">
                    <option value="">Choose a bolt diameter</option>
                    @foreach ($bolt_diameter as $bd)
                        <option value="{{ $bd->bolt_diameter }}" {{ request('bolt_diameter') == $bd->bolt_diameter ? 'selected' : '' }}>{{ $bd->bolt_diameter }}</option>
                    @endforeach
                </select>
            </div>
            <div class="p-4">
                <label for="type" class="block mt-2 text-sm font-medium text-gray-900 dark:text-white">Type</label>
                <select id="type" name="type"
                    class="block mt-2 w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 hover:shadow-md">
                    <option value="">Choose a type</option>
                    @foreach ($type as $t)
                        <option value="{{ $t->type }}" {{ request('type') == $t->type ? 'selected' : '' }}>{{ $t->type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="p-4">
                <label for="brand" class="block mt-2 text-sm font-medium text-gray-900 dark:text-white">Brand</label>
                <select id="brand" name="brand"
                    class="block mt-2 w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 hover:shadow-md">
                    <option value="">Choose a Brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>{{ $brand->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="p-4">
                <label for="priceFrom" class="block text-sm font-semibold leading-6 text-gray-900">Price from:</label>
                <div class="mt-2.5">
                    <input type="number" name="price_from" id="priceFrom" value="{{ request('price_from', number_format($price_range['min'], 2, '.', '')) }}" step="0.01"
                        class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 hover:shadow-md">
                </div>
            </div>
            <div class="p-4">
                <label for="priceTo" class="block text-sm font-semibold leading-6 text-gray-900">Price to:</label>
                <div class="mt-2.5">
                    <input type="number" name="price_to" id="priceTo" value="{{ request('price_to', number_format($price_range['max'], 2, '.', '')) }}" step="0.01"
                        class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 hover:shadow-md">
                </div>
            </div>
            <div class="p-4 col-start-4">
                <div class="mt-8">
                    <button type="submit"
                        class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 hover:shadow-md">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>
