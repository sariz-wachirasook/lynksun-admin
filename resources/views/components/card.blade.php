@props(['href', 'class' => ''])

@isset($href)
    <a href="{{ $href }}" class="card hover:bg-gray-100 dark:hover:bg-gray-700 {{ $class }}">
        {{ $slot }}
    </a>
@else
    <div class="card {{ $class }}">
        {{ $slot }}
    </div>
@endisset
