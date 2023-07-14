<x-layout>
    <x-card class="max-w-md mx-auto mt-[10rem] mb-[10rem]">
        <h1 class="h4 mb-4">
            {!! __('app.login') !!}
        </h1>
        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <x-input.text name="email" label="{!! __('app.email') !!}" required class="mb-4" />
            <x-input.text name="password" label="{!! __('app.password') !!}" required class="mb-4"/>

            <p>username: admin@lynksun.com</p>
            <p>password: admin1234</p>

            <x-button.submit class="w-full mt-4">
                {!! __('app.login') !!}
            </x-button.submit>
        </form>
    </x-card>
</x-layout>
