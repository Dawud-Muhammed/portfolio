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

    <div x-data="scrollToTop()" x-init="init()" class="pointer-events-none">
        <div x-ref="topSentinel" aria-hidden="true" class="absolute top-0 left-0 h-px w-px"></div>

        <button
            x-show="isVisible"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-3 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-3 scale-95"
            @click="scrollToTop"
            type="button"
            class="pointer-events-auto fixed bottom-4 right-4 z-50 inline-flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-orange-400 via-orange-500 to-amber-500 text-white shadow-[0_8px_24px_rgba(249,115,22,0.35)] transition duration-200 hover:scale-105 hover:shadow-[0_12px_28px_rgba(234,88,12,0.38)] focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-300 focus-visible:ring-offset-2 sm:bottom-6 sm:right-6 sm:h-12 sm:w-12"
            aria-label="Scroll back to top"
            title="Scroll to top"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 sm:h-5 sm:w-5" aria-hidden="true">
                <path d="M12 19V5" />
                <path d="m5 12 7-7 7 7" />
            </svg>
        </button>
    </div>
</body>
</html>
