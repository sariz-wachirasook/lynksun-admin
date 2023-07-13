@php
    $locales = config('app.available_locales');
@endphp

<button id="dropdownHoverButton" data-dropdown-toggle="dropdownHover" data-dropdown-trigger="hover" class="btn btn--gray"
    type="button">
    <i class="fa-solid fa-earth-asia"></i>
</button>

<div id="dropdownHover" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">

        @foreach ($locales as $locale)
            <li
                class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600  @if ($locale === session('locale')) pointer-events-none @endif">
                <a href="{{ route('switch-language', $locale) }}" class="flex items-center justify-between">
                    <span>{!! __('locales.' . $locale) !!}</span>
                    @if ($locale === session('locale'))
                        <i class="fa-solid fa-check"></i>
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
</div>
