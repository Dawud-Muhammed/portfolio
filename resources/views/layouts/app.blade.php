<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php
        use App\Models\SiteSetting;
        use Illuminate\Support\Facades\Storage;

        $defaultTitle = (string) config('seo.default_name', config('app.name', 'Portfolio'));
        $defaultDescription = (string) config('seo.default_description', 'High-end Laravel portfolio hero section with Alpine animations.');
        $defaultImage = (string) config('seo.default_image', Storage::url('images/photo-1518770660439-4636190af475.jpg'));
        $defaultUrl = (string) config('seo.default_url', config('app.url'));

        $pageTitle = trim($__env->yieldContent('page_title', $defaultTitle));
        $pageDescription = trim($__env->yieldContent('meta_description', $defaultDescription));
        $canonicalUrl = trim($__env->yieldContent('canonical_url', url()->current()));

        $defaultHeroName = (string) SiteSetting::get('hero_name', 'Dawud Muhammed');
        $defaultHeroTitle = (string) SiteSetting::get('hero_title', 'Laravel Developer');
        $defaultHeroCvUrl = (string) SiteSetting::get('hero_cv_url', url('/'));
        $defaultHeroCtaLabel = (string) SiteSetting::get('hero_cta_label', 'Download CV');
        $defaultHeroPrimaryCtaLabel = (string) SiteSetting::get('hero_primary_cta_label', 'View Projects');
        $defaultHeroPrimaryCtaUrl = trim((string) $__env->yieldContent('hero_primary_cta_url', ''));
        $defaultHeroAvailabilityText = (string) SiteSetting::get('hero_availability_text', 'Available for freelance and full-time roles');
        $defaultHeroDescription = (string) SiteSetting::get('hero_description', 'I build robust, scalable backend systems powered by Laravel and polished interfaces using Tailwind CSS.');
        $defaultHeroBackground = (string) SiteSetting::get('hero_background', Storage::url('images/photo-1518770660439-4636190af475.jpg'));
        $defaultHeroBackgroundAlt = (string) SiteSetting::get('hero_background_alt', 'Futuristic coding workstation with glowing monitors in a dark studio');

        $ogTitle = trim($__env->yieldContent('og_title', $pageTitle));
        $ogDescription = trim($__env->yieldContent('og_description', $pageDescription));
        $ogImage = trim($__env->yieldContent('og_image', $defaultImage));
        $ogUrl = trim($__env->yieldContent('og_url', $canonicalUrl));
        $ogType = trim($__env->yieldContent('og_type', request()->routeIs('home') ? 'website' : 'article'));

        $twitterCard = trim($__env->yieldContent('twitter_card', 'summary_large_image'));
        $twitterTitle = trim($__env->yieldContent('twitter_title', $pageTitle));
        $twitterDescription = trim($__env->yieldContent('twitter_description', $pageDescription));
        $twitterImage = trim($__env->yieldContent('twitter_image', $ogImage));

        $schema = request()->routeIs('home')
            ? [
                '@context' => 'https://schema.org',
                '@type' => 'Person',
                'name' => (string) config('seo.default_name', 'Portfolio Owner'),
                'jobTitle' => (string) config('seo.job_title', 'Laravel Developer'),
                'url' => $defaultUrl,
                'sameAs' => array_values(array_filter([
                    SiteSetting::get('footer_github', config('seo.social.github')),
                    SiteSetting::get('footer_linkedin', config('seo.social.linkedin')),
                ])),
            ]
            : [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => $pageTitle,
                'description' => $pageDescription,
                'url' => $canonicalUrl,
            ];
    @endphp

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#ff6a1c">
    <meta name="description" content="{{ $pageDescription }}">
    <title>{{ $pageTitle }}</title>
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">

    <link rel="canonical" href="{{ $canonicalUrl }}">

    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:url" content="{{ $ogUrl }}">
    <meta property="og:type" content="{{ $ogType }}">

    <meta name="twitter:card" content="{{ $twitterCard }}">
    <meta name="twitter:title" content="{{ $twitterTitle }}">
    <meta name="twitter:description" content="{{ $twitterDescription }}">
    <meta name="twitter:image" content="{{ $twitterImage }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --font-display: 'Sora', sans-serif;
            --font-body: 'Space Grotesk', sans-serif;
        }
    </style>

    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @yield('schema')

    @if (app()->environment('production') && filled(config('services.plausible.domain')))
        <script defer data-domain="{{ config('services.plausible.domain') }}" src="https://plausible.io/js/script.js"></script>
    @endif
</head>
<body id="top" x-data="themeController()" x-init="init()" @theme-change-request.window="setTheme($event.detail?.theme)" class="min-h-screen bg-bg text-fg antialiased">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[90] focus:rounded-md focus:bg-white focus:px-4 focus:py-2 focus:text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-400 dark:focus:bg-slate-800 dark:focus:text-slate-100">
        Skip to main content
    </a>

    @php
        $showHero = trim($__env->yieldContent('show_hero', 'true'));
    @endphp

    <main id="main-content" tabindex="-1">
        @if (! in_array(strtolower($showHero), ['false', '0', 'off', 'no'], true))
            <x-hero
                :name="trim($__env->yieldContent('hero_name', $defaultHeroName))"
                :title="trim($__env->yieldContent('hero_title', $defaultHeroTitle))"
                :cv-url="trim($__env->yieldContent('hero_cv_url', $defaultHeroCvUrl))"
                :cta-label="trim($__env->yieldContent('hero_cta_label', $defaultHeroCtaLabel))"
                :primary-cta-label="trim($__env->yieldContent('hero_primary_cta_label', $defaultHeroPrimaryCtaLabel))"
                :primary-cta-url="trim($__env->yieldContent('hero_primary_cta_url', $defaultHeroPrimaryCtaUrl))"
                :availability-text="trim($__env->yieldContent('hero_availability_text', $defaultHeroAvailabilityText))"
                :description="trim($__env->yieldContent('hero_description', $defaultHeroDescription))"
                :background-image="trim($__env->yieldContent('hero_background', $defaultHeroBackground))"
                :background-alt="trim($__env->yieldContent('hero_background_alt', $defaultHeroBackgroundAlt))"
            />
        @endif

        @yield('content')
    </main>

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
            class="pointer-events-auto portal-icon-button portal-icon-button-accent fixed bottom-4 right-4 z-50 sm:bottom-6 sm:right-6 sm:h-12 sm:w-12"
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
