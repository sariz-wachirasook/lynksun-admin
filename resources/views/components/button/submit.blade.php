@props(['href' => '', 'class' => ''])

<x-button.base href="{{ $href }}" class="{{ $class }}" type="submit">
    {!! __('button.submit') !!}
</x-button.base>
