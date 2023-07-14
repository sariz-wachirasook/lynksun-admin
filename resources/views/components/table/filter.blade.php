@props([
    'search' => '',
    'per_page' => '10',
    'route' => '',
])

<form action="{{ route($route . '.index') }}" method="GET" class="flex justify-between my-5">
    <div class="flex gap-x-5">
        <x-input.text name="search" label="{{ __('app.search') }}" placeholder="{{ __('app.search') }}"
            value="{{ $search }}" />

        @php
            $options = [
                [
                    'name' => '10',
                    'value' => '10',
                ],
                [
                    'name' => '20',
                    'value' => '20',
                ],
                [
                    'name' => '50',
                    'value' => '50',
                ],
                [
                    'name' => '100',
                    'value' => '100',
                ],
            ];
        @endphp

        <x-input.select name="per_page" label="{{ __('app.per_page') }}" :options="$options" :value="$per_page" />
        <x-button.group class="items-end">
            <x-button.submit />
        </x-button.group>
    </div>
</form>
