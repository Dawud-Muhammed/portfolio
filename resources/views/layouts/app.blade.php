<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ trim($__env->yieldContent('meta_description', 'High-end Laravel portfolio hero section with Alpine animations.')) }}">
    <title>{{ trim($__env->yieldContent('page_title', config('app.name', 'Portfolio'))) }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --font-display: 'Sora', sans-serif;
            --font-body: 'Space Grotesk', sans-serif;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="themeController()" x-init="init()" class="min-h-screen bg-bg text-fg antialiased">
    <x-hero
        :name="trim($__env->yieldContent('hero_name', 'Dawud Muhammed'))"
        :title="trim($__env->yieldContent('hero_title', 'Laravel Developer'))"
        :cv-url="trim($__env->yieldContent('hero_cv_url', '#'))"
        :background-image="trim($__env->yieldContent('hero_background', 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1600&q=80'))"
    />

    @yield('content')
    @include('partials.footer')
</body>
</html>
