@props([
    'name' => 'Dawud Muhammed',
    'title' => 'Laravel Developer',
    'cvUrl' => '#',
    'backgroundImage' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1600&q=80',
])

<section
    aria-labelledby="hero-heading"
    class="hero-shell relative isolate flex min-h-[92vh] w-full items-center overflow-hidden lg:min-h-screen"
    x-data="heroTypewriter(@js($name), @js($title))"
>
    <img
        src="{{ $backgroundImage }}"
        alt="Futuristic coding workstation with glowing monitors in a dark studio"
        class="absolute inset-0 h-full w-full object-cover"
        loading="eager"
        decoding="async"
    >

    <div aria-hidden="true" class="absolute inset-0 bg-black/70"></div>
    <div aria-hidden="true" class="absolute inset-0 bg-gradient-to-r from-[#ff5e10]/35 via-[#f97316]/20 to-transparent"></div>
    <div aria-hidden="true" class="hero-bloom absolute -left-28 top-14 h-56 w-56 rounded-full bg-[#ff6b18]/45 blur-3xl"></div>
    <div aria-hidden="true" class="hero-bloom absolute bottom-12 right-8 h-48 w-48 rounded-full bg-[#ff9a3d]/35 blur-3xl"></div>

    <div class="relative z-10 mx-auto flex w-full max-w-7xl flex-col items-center gap-10 px-6 py-24 text-center lg:items-start lg:text-left">
        <div class="max-w-3xl space-y-6">
            <p class="animate-fade-up text-xs font-semibold uppercase tracking-[0.25em] text-orange-200/90 [animation-delay:120ms]">
                Available for freelance and full-time roles
            </p>

            <h1 id="hero-heading" class="animate-fade-up text-balance text-4xl font-bold leading-tight text-white md:text-6xl [animation-delay:180ms]" style="font-family: var(--font-display);">
                <span x-text="displayText"></span>
                <span class="type-caret" aria-hidden="true">|</span>
            </h1>

            <p class="animate-fade-up max-w-2xl text-base text-zinc-200 md:text-lg [animation-delay:260ms]" style="font-family: var(--font-body);">
                I build robust, scalable backend systems and polished interfaces powered by Laravel 13, Alpine.js 3.14+, and Vite.
            </p>

            <div class="animate-fade-up flex w-full flex-col items-center justify-center gap-4 pt-2 [animation-delay:320ms] sm:flex-row lg:justify-start">
                <button
                    type="button"
                    @click="scrollToProjects"
                    class="hero-button-glow w-full rounded-xl border border-orange-300/50 bg-gradient-to-r from-[#ff6a1c] to-[#ff8743] px-7 py-3 text-sm font-semibold uppercase tracking-wide text-white transition duration-300 hover:-translate-y-0.5 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-300 sm:w-auto"
                    aria-label="Scroll to the projects section"
                >
                    View Projects
                </button>

                <a
                    href="{{ $cvUrl }}"
                    download
                    class="hero-button-glow w-full rounded-xl border border-white/45 bg-white/10 px-7 py-3 text-sm font-semibold uppercase tracking-wide text-white transition duration-300 hover:-translate-y-0.5 hover:bg-white/20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white sm:w-auto"
                    aria-label="Download curriculum vitae"
                >
                    Download CV
                </a>
            </div>
        </div>
    </div>
</section>
