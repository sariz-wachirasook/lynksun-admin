@php
    $menu = [
        [
            'name' => __('routes.home'),
            'route' => 'home',
        ],
        [
            'name' => __('routes.technology'),
            'route' => 'technologies.index',
            'icon' => '<i class="fa-solid fa-code mr-1"></i>',
        ],
        [
            'name' => __('routes.cms'),
            'route' => 'posts.index',
            'icon' => '<i class="fa-solid fa-newspaper mr-1"></i>',
        ],
        [
            'name' => __('routes.gallery'),
            'route' => 'galleries.index',
            'icon' => '<i class="fa-solid fa-image mr-1"></i>',
        ],
        [
            'name' => __('routes.api'),
            'route' => 'swagger',
            'icon' => '<i class="fa-solid fa-code mr-1"></i>',
        ],
    ];
@endphp


<header>
    <nav class="bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-700">
        <div
            class="max-w-screen-xl grid grid-cols-1 items-center justify-between md:justify-center lg:justify-between mx-auto p-4 gap-4">
            <a href="{{ route('home', session('locale')) }}" class="grid grid-cols-[auto,1fr,auto]">
                <x-image src="https://laravel.com/img/logomark.min.svg" class="h-8 mr-3" alt="Laravel Logo"
                    :lazy="false" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Laravel Starter By Sariz
                    Wachirasook
                </span>
            </a>
            <button data-collapse-toggle="navbar-multi-level" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 absolute right-[1.2rem] top-[.8rem]"
                aria-controls="navbar-multi-level" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="hidden w-full md:block lg:w-auto" id="navbar-multi-level">
                <ul
                    class="flex flex-col flex-wrap md:justify-center md:items-center gap-2.5 md:gap-4 font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    @foreach ($menu as $item)
                        <li class="w-full md:w-auto whitespace-nowrap">
                            <a href="{{ route($item['route'], session('locale')) }}"
                                class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent
                                @if (request()->routeIs($item['route'])) font-semibold @endif">
                                {!! $item['icon'] ?? '' !!}
                                {{ $item['name'] }}
                            </a>
                        </li>
                    @endforeach

                    <li>
                        <x-divider class="md:hidden" />
                    </li>

                    <li class="inline-flex gap-2.5 mx-auto md:mx-0">
                        <x-locales-switcher />
                        <x-dark-mode-switcher />
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
