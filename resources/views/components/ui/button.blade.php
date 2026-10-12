@props([
    'variant' => 'primary',
    'href' => null,
])

@php
    $classes = match ($variant) {
        'danger' => '
        inline-flex w-full items-center justify-center gap-2 rounded-xl bg-red-50 px-3 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-100 dark:bg-red-500/10 dark:text-red-400 dark:hover:bg-red-500/20
        ',

        'warning' => '
            mt-3 inline-flex items-center justify-center gap-2 rounded-xl
            bg-amber-500 px-5 py-3 text-sm font-semibold text-white
            shadow-sm transition hover:bg-amber-600 sm:mt-0
        ',



        'edit' => '
        inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-amber-50 px-3 py-2.5 text-sm font-semibold text-amber-700 transition hover:bg-amber-100 dark:bg-amber-500/10 dark:text-amber-400 dark:hover:bg-amber-500/20
        ',

        'Cancel' => '
        inline-flex items-center justify-center rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700        
        ',

        'primary' => '
            mt-3 inline-flex items-center justify-center gap-2 rounded-xl
            bg-amber-500 px-5 py-3 text-sm font-semibold text-white
            shadow-sm transition hover:bg-amber-600 sm:mt-0
        ',

        'default' => '
            bg-blue-600 text-white hover:bg-blue-800
            dark:bg-blue-500 dark:hover:bg-blue-600
        ',
    };
@endphp

@if ($href)
    <a href="{{ $href }}"
        {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
