@props(['name', 'value', 'label', 'placeholder', 'options' => [], 'required' => false])

<div>
    <x-label for="{{ $name }}" :label="$label" :required="$required" />

    <select id="{{ $name }}" name="{{ $name }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        @if ($placeholder ?? false)
            <option @if ($value == '') selected @endif value="">{{ $placeholder }}</option>
        @endif

        @foreach ($options as $option)
            <option @if ($value == $option['value']) selected @endif value="{{ $option['value'] }}">
                {{ $option['name'] }}
            </option>
        @endforeach
    </select>
</div>
