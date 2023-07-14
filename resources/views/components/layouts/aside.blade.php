@php
    $routes = [
        [
            'route' => 'admin.dashboard',
            'title' => __('routes.dashboard'),
            'icon' => '<i class="fa-solid fa-house"></i>',
        ],
        [
            'route' => 'admin.links.index',
            'title' => __('routes.links'),
            'icon' => '<i class="fa-solid fa-link"></i>',
        ],
        [
            'route' => 'admin.users.index',
            'title' => __('routes.users'),
            'icon' => '<i class="fa-solid fa-users"></i>',
        ],
        [
            'route' => 'admin.logout',
            'title' => __('routes.logout'),
            'icon' => '<i class="fa-solid fa-sign-out"></i>',
        ],
    ];
    
@endphp


@if (auth()->guard('admin')->user())
    <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar"
        type="button"
        class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
            </path>
        </svg>
    </button>

    <aside id="default-sidebar"
        class="fixed md:relative top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                @foreach ($routes as $route)
                    <li>
                        <a href="{{ route($route['route']) }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group @if (request()->routeIs($route['route'])) bg-gray-100 dark:bg-gray-700 @endif">
                            <span class="mr-3 text-xl">{!! $route['icon'] !!}</span>
                            <span class="text-sm font-medium">{{ $route['title'] }}</span>
                        </a>
                    </li>
                @endforeach

            </ul>
        </div>
    </aside>
@endif
