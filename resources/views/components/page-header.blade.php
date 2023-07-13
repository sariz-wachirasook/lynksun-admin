@props(['title', 'class'])

<div class="flex justify-between mb-5 items-center {{ $class ?? '' }}">
    <h1>{{ $title }}</h1>
    {{ $slot }}
</div>
