@if (config('app.env') === 'production')
    @php
        $GA = config('services.google_analytics.id');
    @endphp
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $GA }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', '{{ $GA }}');
    </script>
@endif
