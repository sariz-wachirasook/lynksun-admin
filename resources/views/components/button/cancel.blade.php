@props(['href' => '#', 'class' => ''])

<x-button.base href="{{ $href }}" class="btn--gray {{ $class }}">
    {!! __('button.cancel') !!}
</x-button.base>
