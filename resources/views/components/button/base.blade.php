@props(['href' => '', 'class' => '', 'type' => 'button'])

@if ($href)
    <a href="{{ $href }} " class="btn {{ $class }}">
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" class="btn {{ $class }}">
        {{ $slot }}
    </button>
@endif
