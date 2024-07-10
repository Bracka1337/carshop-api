<div class="search">
    <div class="flex items-center justify-center mt-40">
        <form action="{{ route('products.search') }}" method="POST"
            class="bg-white p-6 rounded-lg shadow-lg grid grid-cols-4 gap-2 w-full max-w-5xl">
            @csrf
            <div class="p-4">
                <label for="category"
                    class="block mt-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                <select id="category" name="category_id"
                    class="block mt-2 w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 hover:shadow-md">
                    <option value="">Choose a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="p-4">
                <label for="brand" class="block mt-2 text-sm font-medium text-gray-900 dark:text-white">Brand</label>
                <select id="brand" name="brand_id"
                    class="block mt-2 w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 hover:shadow-md">
                    <option value="">Choose a brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="p-4">
                <label for="size" class="block mt-2 text-sm font-medium text-gray-900 dark:text-white">Size</label>
                <select id="size" name="size"
                    class="block mt-2 w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 hover:shadow-md">
                    <option value="">Choose a size</option>
                    @foreach ($sizes as $size)
                        <option value="{{ $size->size }}">{{ $size->size }}</option>
                    @endforeach
                </select>
            </div>
            <div class="p-4">
                <label for="priceFrom" class="block text-sm font-semibold leading-6 text-gray-900">Price from:</label>
                <div class="mt-2.5">
                    <input type="number" name="price_from" id="priceFrom"  value="{{ number_format($price_range['min'], 2, '.', '') }}" step="0.01"
                        autocomplete="given-name"
                        autocomplete="given-name"
                        class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 hover:shadow-md">
                </div>
            </div>
            <div class="p-4">
                <label for="priceTo" class="block text-sm font-semibold leading-6 text-gray-900">Price to:</label>
                <div class="mt-2.5">
                    <input type="number" name="price_to" id="priceTo"
                        value="{{ number_format($price_range['max'], 2, '.', '') }}" step="0.01"
                        autocomplete="given-name"
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
