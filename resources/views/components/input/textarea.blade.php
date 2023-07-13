@props(['name', 'value' => '', 'label', 'placeholder', 'required' => false])

<div>
    <x-label for="{{ $name }}" :label="$label" :required="$required" />
    <textarea id="{{ $name }}" type="text" name="{{ $name }}" placeholder="{{ $placeholder ?? $label }}"
        @if ($required ?? false) required @endif rows="4"
        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{!! $value !!}</textarea>
</div>
