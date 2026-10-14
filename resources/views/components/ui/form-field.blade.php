
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
    'options' => [],
    'optionValue' => 'id',
    'optionLabel' => 'name',
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

    @elseif ($type === 'select')
        <select
            {{ $attributes->class([
                'w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:border-amber-400',
            ]) }}
            name="{{ $name }}"
            id="{{ $name }}"
            @if ($required) required @endif
        >
            <option value=""> {{ $placeholder ?: 'Select an option' }} </option>

            @foreach ($options as $option)
                <option
                    value="{{ data_get($option, $optionValue) }}"
                    @selected(
                        (string) old($name, $value) ===
                        (string) data_get($option, $optionValue)
                    )
                >
                    {{ data_get($option, $optionLabel) }}
                </option>
            @endforeach
        </select>
        @elseif ($type === 'file')
    <input
        {{ $attributes->class([
            'block w-full rounded-xl border border-gray-300
            bg-white text-sm text-gray-900
            file:mr-4 file:rounded-l-xl file:border-0
            file:bg-amber-50 file:px-4 file:py-3
            file:font-semibold file:text-amber-700
            hover:file:bg-amber-100
            dark:border-gray-600 dark:bg-gray-900
            dark:text-white',
        ]) }}
        type="file"
        name="{{ $name }}"
        id="{{ $name }}"
        accept="image/jpeg,image/png,image/jpg,image/gif"
        @if ($required) required @endif
    >
    
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