<x-layout>

    <div class="grid md:grid-cols-4 sm:grid-cols-3 gap-4">
        <x-card class="flex justify-between">
            <h4>{!! __('app.total_links') !!}</h4>
            <h4>{{ $total_links }}</h4>
        </x-card>

        <x-card class="flex justify-between">
            <h4>{!! __('app.total_link_opened') !!}</h4>
            <h4>{{ $total_visits }}</h4>
        </x-card>

        <x-card class="flex justify-between">
            <h4>{!! __('app.total_users') !!}</h4>
            <h4>{{ $total_users }}</h4>
        </x-card>

        <x-card class="flex justify-between">
            <h4>{!! __('app.today_new_links') !!}</h4>
            <h4>{{ $today_visits }}</h4>
        </x-card>
    </div>

    <canvas id="js-bar-chart" aria-label="chart" height="350" width="580"></canvas>

</x-layout>
