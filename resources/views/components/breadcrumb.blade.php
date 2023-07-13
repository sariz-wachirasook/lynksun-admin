@props(['class', 'breadcrumbs' => []])

<nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700 mb-5 {{ $class ?? '' }}"
    aria-label="Breadcrumb">
    <ol class="inline-flex items-center overflow-hidden whitespace-nowrap" itemscope
        itemtype="https://schema.org/BreadcrumbList">
        @foreach ($breadcrumbs as $breadcrumb)
            <li class="inline-flex items-center overflow-hidden" itemprop="itemListElement" itemscope
                itemtype="https://schema.org/ListItem">
                <a href="{{ $breadcrumb['route'] }}" itemprop="item"
                    class="inline-block items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white @if ($loop->last) pointer-events-none truncate @endif">
                    <span itemprop="name">{{ $breadcrumb['title'] }}</span>
                    <meta itemprop="position" content="{{ $loop->iteration }}">
                    @if (!$loop->last)
                        <i class="fa-solid fa-chevron-right mx-1 mr-2 md:mx-2.5"></i>
                    @endif
                </a>
            </li>
        @endforeach
    </ol>
</nav>
