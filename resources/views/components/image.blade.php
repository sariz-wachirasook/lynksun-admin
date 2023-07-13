@props(['src' => '', 'alt' => '', 'class' => '', 'lazy' => true])

@php
    $fallback = asset('fallback.webp');
@endphp


<img src="{{ $lazy ? $fallback : $src }}" data-src="{{ $src }}" alt="{{ $alt }}"
    class="{{ $class }} lazy" onerror="this.onerror=null;this.src='{{ $fallback }}';" />
