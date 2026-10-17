<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">

        <x-ui.layout.page-header
                title="Categories"
                description="Manage your store Categories"
            />
            <x-ui.button
                href="{{ route('categories.create') }}"
                class="mt-3 inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600 sm:mt-0">
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor"
                    class="h-5 w-5">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Category
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

            {{-- Categories Summary --}}
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        All Categories
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Showing {{ $categories->count() }} Categories on this page
                    </p>
                </div>
            </div>

            {{-- Categories Grid --}}
            @forelse ($categories as $category)

                @if ($loop->first)
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @endif

                <div class="group flex flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg dark:border-gray-700 dark:bg-gray-800">
                    
                    {{-- Categories Details --}}
                    <div class="flex flex-1 flex-col p-5">

                        <h4 class="line-clamp-1 text-lg font-bold text-gray-900 dark:text-white"
                            title="{{ $category->name }}">
                            {{ $category->name }}
                        </h4>

                        {{-- Actions --}}
                        <div class="mt-6 flex gap-3 border-t border-gray-100 pt-4 dark:border-gray-700">
                        
                            <x-ui.button 
                                href="{{ route('categories.edit', $category->id) }}"
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
                        
                            <x-ui.form 
                            action="{{ route('categories.destroy', $category->id) }}"
                            method="DELETE"
                            onsubmit="return confirm('Are you sure you want to delete this category?')"
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
                        No Categories yet
                    </h3>
                    
                    <p class="mt-2 mb-3 text-sm text-gray-500 dark:text-gray-400">
                        Start building your store by adding your first Categories.
                    </p>
                    
                    <x-ui.button 
                        href="{{ route('categories.create') }}"
                        variant="warning">
                            Add Your First Categories
                    </x-ui.button>
                </div>
            
            @endforelse

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $categories->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>