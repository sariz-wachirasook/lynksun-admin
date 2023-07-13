@props(['id'])

<div id="accordion-open-body-{{ $id }}" class="hidden"
    aria-labelledby="accordion-open-heading-{{ $id }}">
    <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
        {{ $slot }}
    </div>
</div>
