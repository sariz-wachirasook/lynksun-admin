@php
    $columns = [
        [
            'title' => __('app.id'),
            'key' => 'id',
            'type' => 'text',
            'order' => false,
        ],
        [
            'title' => __('app.short_url'),
            'key' => 'short_url',
            'type' => 'short_url',
            'order' => false,
        ],
        [
            'title' => __('app.original_url'),
            'key' => 'url',
            'type' => 'url',
            'order' => false,
        ],
        [
            'title' => __('app.created_at'),
            'key' => 'created_at',
            'type' => 'datetime',
            'order' => $sort === 'created_at' ? $order : null,
        ],
        [
            'title' => __('app.updated_at'),
            'key' => 'updated_at',
            'type' => 'datetime',
            'order' => $sort === 'updated_at' ? $order : null,
        ],
    ];
    
    $breadcrumbs = [
        [
            'route' => route('admin.links.index'),
            'title' => __('routes.links'),
        ],
    ];
@endphp

<x-layout>
    {{-- breadcrumbs --}}
    <x-breadcrumb :breadcrumbs="$breadcrumbs" />

    {{-- page header --}}
    <x-page-header title="{{ __('routes.links') }}">
    </x-page-header>

    {{-- table --}}
    <x-table :columns="$columns" :sort="$sort" :order="$order" :items="$items" route="admin.links"
        :search="$search" :per_page="$per_page" />
</x-layout>
