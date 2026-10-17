<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">

        <x-ui.layout.page-header
                title="Products"
                description="Manage your store products"
            />
            <x-ui.button
                href="{{ route('products.create') }}"
                class="mt-3 inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600 sm:mt-0">
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor"
                    class="h-5 w-5">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Product
            </x-ui.button>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-10 dark:bg-gray-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700 dark:border-green-800 dark:bg-green-900/20 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Products Summary --}}
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        All Products
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Showing {{ $products->count() }} products on this page
                    </p>
                </div>
            </div>

            {{-- Products Grid --}}
            @forelse ($products as $product)

                @if ($loop->first)
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @endif

                <div class="group flex flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg dark:border-gray-700 dark:bg-gray-800">

                    <x-ui.button
                        href="{{ route('products.show', $product->id) }}" variant="empty">

                    {{-- Product Image Placeholder --}}
                    <div class="relative flex h-48 items-center justify-center overflow-hidden bg-gray-100 dark:bg-gray-700/50">

                        @if ($product->image)
                            <img
                                src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}"
                                class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                            >
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1"
                                stroke="currentColor"
                                class="h-20 w-20 text-gray-300 dark:text-gray-600">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25m0-9L3 7.5m9 5.25v9m-9-14.25v9l9 5.25" />
                            </svg>
                        @endif

                        <span class="absolute right-3 top-3 rounded-full px-3 py-1 text-xs font-semibold
                            {{ $product->stock > 0
                                ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400'
                                : 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400' }}">
                            {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </div>

                    {{-- Product Details --}}
                    <div class="flex flex-1 flex-col p-5">

                    <h4 class="line-clamp-1 text-lg font-bold text-gray-900 dark:text-white"
                        title="{{ $product->name }}">
                        {{ $product->name }}
                    </h4>

                        <p class="mt-2 line-clamp-3 min-h-[4.5rem] text-sm leading-6 text-gray-500 dark:text-gray-400">
                            {{ $product->description }}
                        </p>

                        <div class="mt-5 flex items-end justify-between gap-3">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Price
                                </p>
                                <p class="mt-1 text-2xl font-extrabold text-amber-600 dark:text-amber-400">
                                    ${{ number_format($product->price, 2) }}
                                </p>
                            </div>

                            <div class="text-right">
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Stock
                                </p>
                                <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ number_format($product->stock) }} units
                                </p>
                            </div>
                        </div>
                        </x-ui.button>

                        {{-- Actions --}}
                        <div class="mt-6 flex gap-3 border-t border-gray-100 pt-4 dark:border-gray-700">
                        
                        @can('update', $product)
                        <x-ui.button 
                                href="{{ route('products.edit', $product->id) }}"
                                variant="edit"
                                class="inline-flex flex-1">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.8" stroke="currentColor"
                                        class="h-4 w-4">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                Edit
                            </x-ui.button>
                            @endcan
                        
                            @can('delete', $product)
                            <x-ui.form 
                            action="{{ route('products.destroy', $product->id) }}"
                            method="DELETE"
                            onsubmit="return confirm('Are you sure you want to delete this product?')"
                            class="inline-flex flex-1">
                                <x-ui.button type="submit" variant="danger" class="w-full">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.8" stroke="currentColor"
                                        class="h-4 w-4">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-5.788 0L8.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L17.16 19.673A2.25 2.25 0 0 1 14.916 21H9.084a2.25 2.25 0 0 1-2.244-1.327L5.772 5.79m12.456 0a48.108 48.108 0 0 0-3.478-.397m-12.456 0c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.956 0V4.5A2.25 2.25 0 0 0 12.5 2.25h-1A2.25 2.25 0 0 0 9.25 4.5v.728m6.5 0a48.667 48.667 0 0 0-6.5 0" />
                                    </svg>
                                    Delete
                                </x-ui.button>
                            </x-ui.form>
                            @endcan
                        </div>
                        
                        {{-- Category --}}
                        <div class="pt-4 justify-end text-right">
                            <span class="inline-flex items-center gap-1.5 rounded-full
                                bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700
                                ring-1 ring-inset ring-amber-600/20
                                dark:bg-amber-500/10 dark:text-amber-400
                                dark:ring-amber-400/20">

                                {{ $product->category?->name ?? 'Uncategorized' }}
                            </span>
                        </div>
                    </div>
                </div>

                @if ($loop->last)
                    </div>
                @endif

            @empty

                <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-16 text-center dark:border-gray-700 dark:bg-gray-800">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor"
                            class="h-8 w-8">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25m0-9L3 7.5m9 5.25v9m-9-14.25v9l9 5.25" />
                        </svg>
                    </div>

                    <h3 class="mt-5 text-lg font-bold text-gray-900 dark:text-white">
                        No products yet
                    </h3>

                    <p class="mt-2 mb-3 text-sm text-gray-500 dark:text-gray-400">
                        Start building your store by adding your first product.
                    </p>
                    
                    <x-ui.button 
                        href="{{ route('products.create') }}"
                        variant="warning">
                            Add Your First Product
                    </x-ui.button>
                </div>
            
            @endforelse

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>