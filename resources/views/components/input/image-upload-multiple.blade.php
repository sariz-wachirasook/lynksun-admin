@props(['name', 'value', 'label', 'placeholder', 'options' => [], 'required' => false])

<div>
    <x-label for="{{ $name }}" :label="$label" :required="$required" />

    <input name="{{ $name }}"
        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
        type="file" @if ($required) required @endif />
</div>
