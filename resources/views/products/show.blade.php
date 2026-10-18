<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <x-ui.layout.page-header
                title="Product Details"
                description="View complete information about your product"
            />
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-10 dark:bg-gray-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumb --}}
            <div class="mb-6 flex items-center gap-2 text-sm">
                <a href="{{ route('products.index') }}"
                    class="text-gray-500 transition hover:text-amber-600 dark:text-gray-400">
                    Products
                </a>

                <span class="text-gray-400">/</span>

                <span class="font-medium text-gray-900 dark:text-white">
                    Product Details
                </span>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700 dark:border-green-800 dark:bg-green-900/20 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Product Card --}}
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
                                    d="M12 3.75 4.5 7.5v9L12 20.25l7.5-3.75v-9L12 3.75Z" />
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m4.5 7.5 7.5 3.75m0 0 7.5-3.75m-7.5 3.75v9" />
                            </svg>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $product->name }}
                            </h3>

                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Complete product information and inventory details.
                            </p>
                        </div>

                        {{-- Stock Status --}}
                        <span class="shrink-0 rounded-full px-3 py-1 text-xs font-semibold
                            {{ $product->stock > 0
                                ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400'
                                : 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400' }}">
                            {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>

                    </div>
                </div>

                {{-- Product Content --}}
                <div class="grid grid-cols-1 gap-8 p-6 sm:p-8 lg:grid-cols-2">

                {{-- Product Images --}}
                <div>
                    <h4 class="mb-4 text-sm font-semibold text-gray-900 dark:text-white">
                        Product Images
                    </h4>

                    @php
                        // New table first; fall back to the old column for products not migrated yet
                        $urls = $product->images
                            ->map(fn ($img) => asset('storage/' . $img->path))
                            ->all();

                        if (! $urls && $product->image) {
                            $urls = [asset('storage/' . $product->image)];
                        }
                    @endphp

                    @if ($urls)
                        <div x-data="{ active: @js($urls[0]) }">

                            {{-- Big image --}}
                            <div class="flex min-h-72 items-center justify-center overflow-hidden rounded-2xl border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
                                <img
                                    :src="active"
                                    alt="{{ $product->name }}"
                                    class="h-72 w-full object-contain sm:h-96"
                                >
                            </div>

                            {{-- Thumbnails (only when there is more than one image) --}}
                            @if (count($urls) > 1)
                                <div class="mt-3 flex flex-wrap gap-2">
                                    @foreach ($urls as $url)
                                        <button
                                            type="button"
                                            @click="active = @js($url)"
                                            class="overflow-hidden rounded-lg border-2 transition"
                                            :class="active === @js($url)
                                                ? 'border-amber-500'
                                                : 'border-gray-200 hover:border-gray-300 dark:border-gray-700'">
                                            <img src="{{ $url }}" alt="" class="h-16 w-16 object-cover">
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="flex min-h-72 items-center justify-center overflow-hidden rounded-2xl border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
                            <div class="flex flex-col items-center justify-center py-12 text-gray-400 dark:text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.2" stroke="currentColor" class="h-20 w-20">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25m0-9L3 7.5m9 5.25v9m-9-14.25v9l9 5.25" />
                                </svg>
                                <p class="mt-3 text-sm">No image available</p>
                            </div>
                        </div>
                    @endif
                </div>

                    {{-- Product Information --}}
                    <div class="flex flex-col">

                        <h4 class="mb-5 text-sm font-semibold text-gray-900 dark:text-white">
                            Product Information
                        </h4>

                        {{-- Name --}}
                        <div class="border-b border-gray-100 pb-4 dark:border-gray-700">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Product Name
                            </p>

                            <p class="mt-1 text-lg font-bold text-gray-900 dark:text-white">
                                {{ $product->name }}
                            </p>
                        </div>

                        {{-- Price --}}
                        <div class="border-b border-gray-100 py-4 dark:border-gray-700">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Price
                            </p>

                            <p class="mt-1 text-3xl font-extrabold text-amber-600 dark:text-amber-400">
                                ${{ number_format($product->price, 2) }}
                            </p>
                        </div>

                        {{-- Stock --}}
                        <div class="border-b border-gray-100 py-4 dark:border-gray-700">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Available Stock
                            </p>

                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                {{ number_format($product->stock) }} units
                            </p>
                        </div>

                        {{-- Category --}}
                        <div class="border-b border-gray-100 py-4 dark:border-gray-700">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Category
                            </p>

                            <div class="mt-2">
                                <span class="inline-flex items-center rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-600/20 dark:bg-amber-500/10 dark:text-amber-400 dark:ring-amber-400/20">
                                    {{ $product->category?->name ?? 'Uncategorized' }}
                                </span>
                            </div>
                        </div>

                        {{-- Created By --}}
                        <div class="border-b border-gray-100 py-4 dark:border-gray-700">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Created By
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $product->user?->name ?? 'Unknown' }}
                            </p>
                        </div>

                        {{-- Created At --}}
                        <div class="py-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Created At
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $product->created_at?->format('M d, Y - h:i A') ?? 'N/A' }}
                            </p>
                        </div>

                    </div>
                </div>

                {{-- Description --}}
                <div class="border-t border-gray-200 px-6 py-6 dark:border-gray-700 sm:px-8">
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white">
                        Product Description
                    </h4>

                    <p class="mt-3 whitespace-pre-line text-sm leading-7 text-gray-600 dark:text-gray-300">
                        {{ $product->description }}
                    </p>
                </div>

                {{-- Footer Actions --}}
                <div class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-6 py-5 dark:border-gray-700 dark:bg-gray-900/50 sm:flex-row sm:items-center sm:justify-between sm:px-8">

                    <x-ui.button
                        href="{{ route('products.index') }}"
                        variant="Cancel">
                        Back to Products
                    </x-ui.button>

                    @can('update', $product)
                    <x-ui.button
                        href="{{ route('products.edit', $product->id) }}"
                        variant="warning">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-5 w-5">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                        </svg>
                        Edit Product
                    </x-ui.button>
                    @endcan

                </div>

            </div>

        </div>
    </div>

</x-app-layout>