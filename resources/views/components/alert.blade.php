@props(['type', 'label'])

@switch($type)
    @case('danger')
        <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
            role="alert">
            <i class="fa-solid mr-2.5 fa-circle-exclamation"></i>
            {{ $slot }}
        </div>
    @break

    @case('success')
        <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
            role="alert">
            <i class="fa-solid mr-2.5 fa-check"></i>
            {{ $slot }}
        </div>
    @break

    @case('warning')
        <div class="flex items-center p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300"
            role="alert">
            <i class="fa-solid mr-2.5 fa-triangle-exclamation"></i>
            {{ $slot }}
        </div>
    @break

    @default
        <div class="flex items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
            role="alert">
            <i class="fa-solid mr-2.5 fa-circle-info"></i>
            {{ $slot }}
        </div>
@endswitch
