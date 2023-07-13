@props(['href' => '#', 'class' => ''])

<x-button.base href="{{ $href }}" class="{{ $class }}">
    <i class="fa-solid fa-pen-to-square mr-2.5"></i>
    {!! __('button.create') !!}
</x-button.base>
