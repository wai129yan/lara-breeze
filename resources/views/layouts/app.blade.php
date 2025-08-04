<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <title>@if(isset($post)){{ $post->title }}@else{{ config('app.name', 'Medium Clone') }}@endif</title>

<meta name="description" content="@if(isset($post)){{ Str::limit($post->excerpt, 155) }}@else{{ 'A platform for writers and readers to connect through meaningful content' }}@endif">

<!-- Open Graph Meta Tags -->
<meta property="og:type" content="@if(isset($post))article@else{{ 'website' }}@endif">
<meta property="og:title" content="@if(isset($post)){{ $post->title }}@else{{ config('app.name', 'Medium Clone') }}@endif">
<meta property="og:description" content="@if(isset($post)){{ Str::limit($post->excerpt, 155) }}@else{{ 'A platform for writers and readers to connect through meaningful content' }}@endif">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="@if(isset($post)){{ asset('storage/' . $post->cover_image) }}@else{{ asset('images/default-og.jpg') }}@endif">

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@if(isset($post)){{ $post->title }}@else{{ config('app.name', 'Medium Clone') }}@endif">
<meta name="twitter:description" content="@if(isset($post)){{ Str::limit($post->excerpt, 155) }}@else{{ 'A platform for writers and readers to connect through meaningful content' }}@endif">
<meta name="twitter:image" content="@if(isset($post)){{ asset('storage/' . $post->cover_image) }}@else{{ asset('images/default-og.jpg') }}@endif">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Merriweather:wght@300;400;700&display=swap"
        rel="stylesheet">
    @stack('style')
</head>

<body class="bg-gray-50 text-gray-800 font-sans">
    @include('layouts.header')

    <!-- Page Content -->
    <div class="min-h-screen">
        @yield('content')
    </div>

    @include('layouts.footer')
    @stack('script')
</body>

</html>
