@props(['id'])

<h5 id="accordion-open-heading-{{ $id }}">
    <button type="button"
        class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800"
        data-accordion-target="#accordion-open-body-{{ $id }}" aria-expanded="true"
        aria-controls="accordion-open-body-{{ $id }}">
        <span class="flex items-center">
            {{ $slot }}
    </button>
</h5>
