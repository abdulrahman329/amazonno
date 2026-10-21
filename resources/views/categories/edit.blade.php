<x-app-layout>

    <x-slot name="header">
        <x-ui.layout.page-header
            title="Edit Category"
            description="Add a new Category to your store"
        />
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-10 dark:bg-gray-900">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumb --}}
            <div class="mb-6 flex items-center gap-2 text-sm">
                <a href="{{ route('categories.index') }}"
                    class="text-gray-500 transition hover:text-amber-600 dark:text-gray-400">
                    Categories
                </a>

                <span class="text-gray-400">/</span>

                <span class="font-medium text-gray-900 dark:text-white">
                    Edit Category
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
                                Category Details
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Enter the information for your new Category.
                            </p>
                        </div>

                    </div>
                </div>

                {{-- Form --}}
                <x-ui.form 
                    action="{{ route('categories.update', $category->id) }}" 
                    method="PUT" 
                    class="p-6 sm:p-8">

                        {{-- Name --}}
                        <x-ui.form-field
                            label="Category Name"
                            name="name"
                            placeholder="Enter Category name"
                            :value="old('name', $category->name)"
                            required
                            autofocus
                        />
                        
                        {{-- Actions --}}
                        <div class="flex flex-col-reverse gap-3 border-t border-gray-200 pt-6 dark:border-gray-700 sm:flex-row sm:items-center sm:justify-between">
                        
                            <x-ui.button 
                                href="{{ route('categories.index') }}"
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