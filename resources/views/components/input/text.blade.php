@props(['name', 'value', 'label', 'placeholder', 'required' => false, 'hidden' => false])

<div class="@if ($hidden ?? false) hidden @endif">
    <x-label for="{{ $name }}" :label="$label" :required="$required" />
    <input id="{{ $name }}" type="text" name="{{ $name }}" value="{{ $value ?? '' }}"
        placeholder="{{ $placeholder ?? $label }}" maxlength="255" @if ($required ?? false) required @endif
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
</div>
