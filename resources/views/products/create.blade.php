<x-app-layout>

    <x-slot name="header">
        <x-ui.layout.page-header
            title="Create Product"
            description="Add a new product to your store"
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
                    Create Product
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
                                    d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Product Details
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Enter the information for your new product.
                            </p>
                        </div>

                    </div>
                </div>

                {{-- Form --}}
                <x-ui.form 
                    action="{{ route('products.store') }}" 
                    method="POST" 
                    class="p-6 sm:p-8">

                        {{-- Name --}}
                        <x-ui.form-field
                            label="Product Name"
                            name="name"
                            placeholder="Enter product name"
                            :value="null"
                            required
                            autofocus
                        />
                    
                        {{-- Description --}}
                        <x-ui.form-field
                            label="Description"
                            name="description"
                            type="textarea"
                            :value="null"
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
                            :value="null"
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
                                    value="{{ old('price', 0.00) }}"
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
                                    value="{{ old('stock', 0) }}"
                                    placeholder="0"
                                    hint="Number of available items."
                                    required
                                />
                            </div>
                        </div>
                        
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
                                Create Product
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