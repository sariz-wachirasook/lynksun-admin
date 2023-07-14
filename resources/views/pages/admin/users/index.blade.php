@php
    $columns = [
        [
            'title' => __('app.id'),
            'key' => 'id',
            'type' => 'text',
            'order' => false,
        ],
        [
            'title' => __('app.email'),
            'key' => 'email',
            'type' => 'email',
            'order' => false,
        ],
        [
            'title' => __('app.name'),
            'key' => 'name',
            'type' => 'name',
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
            'route' => route('admin.users.index'),
            'title' => __('routes.users'),
        ],
    ];
@endphp

<x-layout>
    {{-- breadcrumbs --}}
    <x-breadcrumb :breadcrumbs="$breadcrumbs" />

    {{-- page header --}}
    <x-page-header title="{{ __('routes.users') }}">
    </x-page-header>

    {{-- table --}}
    <x-table :columns="$columns" :sort="$sort" :order="$order" :items="$items" route="admin.links"
        :search="$search" :per_page="$per_page" />
</x-layout>
