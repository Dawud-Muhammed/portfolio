@props([
    'name' => 'Dawud Muhammed',
    'title' => 'Laravel Developer',
    'cvUrl' => '#',
    'ctaLabel' => 'Download CV',
    'primaryCtaLabel' => 'View Projects',
    'primaryCtaUrl' => null,
    'availabilityText' => 'Available for freelance and full-time roles',
    'description' => 'I build robust, scalable backend systems powered by Laravel and polished interfaces using Tailwind CSS.',
    'backgroundImage' => '/storage/images/photo-1542831371-29b0f74f9713.jpg',
    'backgroundAlt' => 'Futuristic coding workstation with glowing monitors in a dark studio',
])

@php
    use App\Support\ImageAsset;

    $backgroundImage = ImageAsset::resolve((string) $backgroundImage, (string) config('seo.default_image', ''));
    $backgroundImageWebp = ImageAsset::webpVariant($backgroundImage);
    $ctaUrl = filter_var(trim((string) $cvUrl), FILTER_VALIDATE_URL) ? trim((string) $cvUrl) : null;
    $primaryCtaUrl = filter_var(trim((string) $primaryCtaUrl), FILTER_VALIDATE_URL) ? trim((string) $primaryCtaUrl) : (filled((string) $primaryCtaUrl) ? trim((string) $primaryCtaUrl) : null);
    $ctaPath = (string) parse_url($ctaUrl ?? '', PHP_URL_PATH);
    $ctaShouldDownload = $ctaUrl !== null && (
        str_starts_with($ctaUrl, url('/storage/')) || preg_match('/\.(pdf|docx?|zip)$/i', $ctaPath) === 1
    );
@endphp

<section
    aria-labelledby="hero-heading"
    class="hero-shell relative isolate flex min-h-[92vh] w-full items-center overflow-hidden lg:min-h-screen"
    x-data="heroTypewriter(@js($name), @js($title))"
>
    <picture class="absolute inset-0 block h-full w-full">
        @if (!empty($backgroundImageWebp))
            <source srcset="{{ $backgroundImageWebp }}" type="image/webp">
        @endif
        <img
            src="{{ $backgroundImage }}"
            alt="{{ $backgroundAlt }}"
            class="absolute inset-0 h-full w-full object-cover"
            width="1600"
            height="900"
            loading="eager"
            fetchpriority="high"
            decoding="async"
        >
    </picture>

    <div aria-hidden="true" class="absolute inset-0 bg-black/70"></div>
    <div aria-hidden="true" class="absolute inset-0 bg-gradient-to-r from-[#ff5e10]/35 via-[#f97316]/20 to-transparent"></div>
    <div aria-hidden="true" class="hero-bloom absolute -left-28 top-14 h-56 w-56 rounded-full bg-[#ff6b18]/45 blur-3xl"></div>
    <div aria-hidden="true" class="hero-bloom absolute bottom-12 right-8 h-48 w-48 rounded-full bg-[#ff9a3d]/35 blur-3xl"></div>

    <div class="relative z-10 mx-auto flex w-full max-w-7xl flex-col items-center gap-10 px-6 py-24 text-center lg:items-start lg:text-left">
        <div class="max-w-3xl space-y-6">
            <p class="animate-fade-up text-xs font-semibold uppercase tracking-[0.25em] text-orange-200/90 [animation-delay:120ms]">
                {{ $availabilityText }}
            </p>

            <h1 id="hero-heading" class="animate-fade-up text-balance text-4xl font-bold leading-tight text-white md:text-6xl [animation-delay:180ms]" style="font-family: var(--font-display);">
                <span x-text="displayText"></span>
                <span class="type-caret" aria-hidden="true">|</span>
            </h1>

            <p class="animate-fade-up max-w-2xl text-base text-zinc-200 md:text-lg [animation-delay:260ms]" style="font-family: var(--font-body);">
                {{ $description }}
            </p>

            <div class="animate-fade-up flex w-full flex-col items-center justify-center gap-4 pt-2 [animation-delay:320ms] sm:flex-row lg:justify-start">
                @if ($primaryCtaUrl)
                    <a
                        href="{{ $primaryCtaUrl }}"
                        class="portal-button hero-button-glow w-full sm:w-auto inline-flex items-center justify-center"
                        aria-label="{{ $primaryCtaLabel }}"
                    >
                        {{ $primaryCtaLabel }}
                    </a>
                @else
                    <button
                        type="button"
                        @click="scrollToProjects"
                        class="portal-button hero-button-glow w-full sm:w-auto"
                        aria-label="Scroll to the projects section"
                    >
                        {{ $primaryCtaLabel }}
                    </button>
                @endif
                    @if ($ctaUrl)
                        <a
                            href="{{ $ctaUrl }}"
                            @if ($ctaShouldDownload) download @endif
                            class="portal-button-secondary hero-button-glow w-full sm:w-auto inline-flex items-center justify-center gap-2"
                            aria-label="{{ $ctaLabel }}"
                        >
                            <span>{{ $ctaLabel }}</span>
                            
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download">
                                <path d="M12 15V3"></path>
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <path d="m7 10 5 5 5-5"></path>
                            </svg>
                        </a>
                    @endif
            </div>
        </div>
    </div>
</section>
