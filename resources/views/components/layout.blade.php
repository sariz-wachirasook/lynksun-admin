@props([
    'seo' => [
        'title' => null,
        'description' => null,
        'keywords' => null,
        'image' => null,
    ],
])


<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">


{{-- localstorage --}}

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <script>
        let mode = localStorage.getItem("color-theme");
        document.documentElement.classList.add(mode);
    </script>

    {{-- css --}}
    @vite('resources/css/app.css')
    @vite('resources/css/tailwind.css')

    {{-- js --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
    @vite('resources/js/app.js')

    {{-- fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    {{-- analytics and seo --}}
    <x-seo :title="$seo['title']" :description="$seo['description']" :keywords="$seo['keywords']" image="{{ $seo['image'] }}" />

    <x-google-analytics />
    <x-hotjar />
</head>

<body class="dark:bg-gray-900 antialiased">
    <x-layouts.header />
    <div class="grid  @if (auth()->guard('admin')->user()) md:grid-cols-[auto,1fr] @endif">
        <x-layouts.aside />

        <main class="min-h-[75vh]">
            <div class="max-w-screen-xl mx-auto px-5 py-5">
                {{-- validate --}}
                @if ($errors && $errors->any())
                    @foreach ($errors->all() as $error)
                        <x-alert type="danger">
                            {{ $error }}
                        </x-alert>
                    @endforeach
                @endif

                {{-- alert --}}
                @if (session()->has('success'))
                    <x-alert type="success">
                        {{ session()->get('success') }}
                    </x-alert>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>
</body>

</html>
