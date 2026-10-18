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
                <x-ui.form 
                    action="{{ route('products.update', $product->id) }}"
                    method="PUT"
                    class="p-6 sm:p-8">

                    {{-- Name --}}
                    <x-ui.form-field
                        label="Product Name"
                        name="name"
                        placeholder="Enter product name"
                        :value="old('name', $product->name)"
                        required
                        autofocus
                    />

                    {{-- Description --}}
                    <x-ui.form-field
                        label="Description"
                        name="description"
                        type="textarea"
                        :value="old('description', $product->description)"
                        rows="4"
                        placeholder="Describe your product..."
                        required
                    />

                    {{-- Category --}}
                    <x-ui.form-field
                            label="Category"
                            name="category_id"
                            type="select"
                            :options="$categories"
                            option-value="id"
                            option-label="name"
                            :value="$product->category_id"                            
                            placeholder="Choose a category"
                            required
                        />

                    {{-- Price & Stock --}}
                    <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2">

                    {{-- Price --}}
                        <div>
                            <x-ui.form-field
                                label="Price"
                                name="price"
                                type="number"
                                min="0"
                                step="0.01"
                                value="{{ old('price', $product->price) }}"
                                placeholder="0.00"
                                hint="Enter the product price."
                                required
                            />
                        </div>

                        {{-- Stock --}}
                        <div>
                            <x-ui.form-field
                                label="stock Quantity"
                                name="stock"
                                type="number"
                                min="0"
                                step="1"
                                value="{{ old('stock', $product->stock) }}"
                                placeholder="0"
                                hint="Number of available items."
                                required
                            />
                        </div>
                    </div>
                    {{-- Current Images --}}
                        @if ($product->images->isNotEmpty())
                            <div class="mb-6">
                                <label class="mb-1 block text-sm font-semibold text-gray-700 dark:text-gray-200">
                                    Current Images
                                </label>
                                <p class="mb-3 text-xs text-gray-500 dark:text-gray-400">
                                    Click an image to mark it for removal.
                                </p>

                                <div class="flex flex-wrap gap-4">
                                    @foreach ($product->images as $image)
                                        <label class="relative cursor-pointer">
                                            <input
                                                type="checkbox"
                                                name="remove_images[]"
                                                value="{{ $image->id }}"
                                                @checked(in_array($image->id, old('remove_images', [])))
                                                class="peer sr-only"
                                            >
                                            <img
                                                src="{{ asset('storage/' . $image->path) }}"
                                                alt="{{ $product->name }}"
                                                class="h-28 w-28 rounded-xl border border-gray-200 object-cover transition
                                                    peer-checked:opacity-40 peer-checked:ring-2 peer-checked:ring-red-500
                                                    dark:border-gray-700"
                                            >
                                            <span class="absolute inset-x-0 bottom-0 hidden rounded-b-xl bg-red-600/90 py-1
                                                        text-center text-xs font-semibold text-white peer-checked:block">
                                                Will be removed
                                            </span>
                                        </label>
                                    @endforeach
                                    @error('images')   <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    @error('images.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        @endif

                        {{-- Add Images --}}
                        <x-ui.form-field
                            label="Add Images"
                            name="images[]"
                            type="file"
                            multiple
                            accept="image/*"
                            hint="Up to 5 images in total (2 MB each). The first one is the cover."
                        />
                    
                    {{-- Actions --}}
                    <div class="flex flex-col-reverse gap-3 border-t border-gray-200 pt-6 dark:border-gray-700 sm:flex-row sm:items-center sm:justify-between">

                        <x-ui.button 
                            href="{{ route('products.index') }}"
                            variant="Cancel">
                                Cancel
                        </x-ui.button>
                        
                        <x-ui.button
                            type="submit"
                            variant="warning"                            
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
                        </x-ui.button>
                    </div>

                </x-ui.form>
            </div>
            
            <p class="mt-4 text-center text-xs text-gray-400 dark:text-gray-500">
                Fields marked with <span class="text-red-500">*</span> are required.
            </p>
            
        </div>
    </div>
</x-app-layout>