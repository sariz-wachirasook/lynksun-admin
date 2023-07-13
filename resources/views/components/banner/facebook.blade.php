@props(['src' => 'https://picsum.photos/1200/630', 'alt' => ''])

<div class="facebook-banner mb-5">
    <div class="facebook-banner__image">
        <x-image src="{{ $src }}" alt="{{ $alt }}" class="w-full h-full object-cover" />
    </div>
</div>
