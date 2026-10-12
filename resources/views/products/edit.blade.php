<x-app-layout>

    <x-slot name="header">
        <x-ui.layout.page-header
            title="Edit Product"
            description="Update your product information"
        />
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-10 dark:bg-gray-900">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumb --}}
            <div class="mb-6 flex items-center gap-2 text-sm">
                <a href="{{ route('products.index') }}"
                    class="text-gray-500 transition hover:text-amber-600 dark:text-gray-400">
                    Products
                </a>

                <span class="text-gray-400">/</span>

                <span class="font-medium text-gray-900 dark:text-white">
                    Edit Product
                </span>
            </div>

            {{-- Form Card --}}
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">

                {{-- Card Header --}}
                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-700 sm:px-8">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                class="h-6 w-6">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Product Details
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Make changes to your existing product.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Form --}}
                <form action="{{ route('products.update', $product->id) }}"
                    method="POST"
                    class="p-6 sm:p-8">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="mb-6">
                        <label for="name"
                                class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">
                            Product Name
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name', $product->name) }}"
                            placeholder="Enter product name"
                            required
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:border-amber-400"
                        >

                        @error('name')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-6">
                        <label for="description"
                                class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">
                            Description
                            <span class="text-red-500">*</span>
                        </label>

                        <textarea
                            name="description"
                            id="description"
                            rows="5"
                            placeholder="Describe your product..."
                            required
                            class="w-full resize-y rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm leading-6 text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:border-amber-400"
                        >{{ old('description', $product->description) }}</textarea>

                        @error('description')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Price & Stock --}}
                    <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2">

                    {{-- Price --}}
                        <div>
                            <label for="price"
                                    class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">
                                Price
                                <span class="text-red-500">*</span>
                            </label>

                            <div class="relative">
                                <input
                                    type="number"
                                    name="price"
                                    id="price"
                                    min="0"
                                    step="0.01"
                                    value="{{ old('price', $product->price) }}"
                                    placeholder="0.00"
                                    required
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:border-amber-400"
                                >
                            </div>

                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Enter the product price.
                            </p>

                            @error('price')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Stock --}}
                        <div>
                            <label for="stock"
                                    class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">
                                Stock Quantity
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="number"
                                name="stock"
                                id="stock"
                                min="0"
                                step="1"
                                value="{{ old('stock', $product->stock) }}"
                                placeholder="0"
                                required
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:border-amber-400"
                            >

                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Number of available items.
                            </p>

                            @error('stock')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- Actions --}}
                    <div class="flex flex-col-reverse gap-3 border-t border-gray-200 pt-6 dark:border-gray-700 sm:flex-row sm:items-center sm:justify-between">

                        <a href="{{ route('products.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600 focus:outline-none focus:ring-4 focus:ring-amber-500/30 active:scale-[0.98]"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="2"
                                stroke="currentColor"
                                class="h-5 w-5">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            Save Changes
                        </button>

                    </div>
                </form>
            </div>
            
            <p class="mt-4 text-center text-xs text-gray-400 dark:text-gray-500">
                Fields marked with <span class="text-red-500">*</span> are required.
            </p>
            
        </div>
    </div>
</x-app-layout>