
@props([
    'label',
    'name',
    'type' => 'text',
    'value' => null,
    'placeholder' => '',
    'rows' => 5,
    'hint' => null,
    'required' => false,
    'min' => null,
    'step' => null,
])

<div class="mb-6">
    <label for="{{ $name }}"
        class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">
        {{ $label }}

        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    @if ($type === 'textarea')
        <textarea
            {{ $attributes->class([
                'w-full resize-y rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm leading-6 text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:border-amber-400',
            ]) }}
            name="{{ $name }}"
            id="{{ $name }}"
            rows="{{ $rows }}"
            placeholder="{{ $placeholder }}"
            @if ($required) required @endif
        >{{ old($name, $value) }}</textarea>
    @else
        <input
            {{ $attributes->class([
                'w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:border-amber-400',
            ]) }}
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            @if ($required) required @endif
            @if ($min !== null) min="{{ $min }}" @endif
            @if ($step !== null) step="{{ $step }}" @endif
        >
    @endif

    @if ($hint)
        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
            {{ $hint }}
        </p>
    @endif

    @error($name)
        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>