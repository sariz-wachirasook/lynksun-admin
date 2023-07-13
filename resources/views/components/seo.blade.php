@props([
    'title' => 'Home',
    'separator' => ' - ',
    'site_name' => 'Laravel Starter',
    'description' => 'Laravel By Sariz Wachirasook',
    'keywords' => 'Laravel By Sariz Wachirasook',
    'author' => 'Laravel By Sariz Wachirasook',
    'image' => asset('favicon.ico'),
    'url' => url()->current(),
    'type' => 'website',
])

<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
<title>{{ $title }} {{ $separator }} {{ $site_name }}</title>

<meta name="description" content="{{ $description }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="author" content="{{ $author }}">

<meta property="og:title" content="{{ $title }} {{ $separator }} {{ $site_name }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:site_name" content="{{ $site_name }}">
<meta property="og:type" content="{{ $type }}">

<meta name="twitter:title" content="{{ $title }} {{ $separator }} {{ $site_name }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $image }}">
<meta name="twitter:card" content="summary_large_image">
