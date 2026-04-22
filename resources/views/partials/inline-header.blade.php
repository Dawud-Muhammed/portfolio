@php
    $isHomeRoute = request()->routeIs('home');

    $activeNavKey = request()->routeIs('projects.*')
        ? 'projects'
        : (request()->routeIs('contacts.*') ? 'contact' : 'home');
@endphp

<section
    x-data="inlineHeaderController({
        isHomeRoute: @js($isHomeRoute),
        initialSection: @js($activeNavKey),
        sections: @js(['about', 'skills', 'projects', 'testimonials', 'contact']),
    })"
    x-init="init()"
    class="mx-auto w-full max-w-7xl px-6 pt-8"
>
    <div class="inline-header-shell rounded-2xl border border-slate-300/75 bg-slate-100/80 px-4 py-3 backdrop-blur-sm dark:border-slate-700/75 dark:bg-slate-900/75">
        <div class="flex items-center justify-between gap-3">
            <a
                href="{{ route('home') }}"
                class="inline-flex items-center rounded-md px-1 py-1 text-sm font-semibold text-slate-600 transition-colors hover:text-orange-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-400 dark:text-slate-100 dark:hover:text-orange-300"
                style="font-family: var(--font-display);"
                aria-label="Go to homepage"
            >
                Dawud Muhammed
            </a>

            <button
                type="button"
                @click="cycleTheme()"
                class="inline-flex items-center gap-2 rounded-md border border-slate-300/80 bg-slate-50/90 px-3 py-2 text-sm font-medium text-slate-700 transition-colors hover:border-orange-300 hover:text-orange-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-400 dark:border-slate-700/80 dark:bg-slate-800/90 dark:text-slate-200 dark:hover:border-orange-400 dark:hover:text-orange-300"
                :title="themeLabel()"
                :aria-label="themeLabel()"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="h-4 w-4" aria-hidden="true">
                    <path d="M12 3v2.5M12 18.5V21M4.8 4.8l1.8 1.8M17.4 17.4l1.8 1.8M3 12h2.5M18.5 12H21M4.8 19.2l1.8-1.8M17.4 6.6l1.8-1.8" />
                    <circle cx="12" cy="12" r="4" />
                </svg>
                <span>Theme</span>
            </button>
        </div>

        <nav class="mt-3 flex flex-wrap items-center gap-1" aria-label="Primary navigation">
            <a
                href="{{ $isHomeRoute ? '#about' : route('home').'#about' }}"
                @click="navigateTo('about', @js($isHomeRoute ? '#about' : route('home').'#about'), $event)"
                :aria-current="isActive('about') ? 'page' : null"
                class="inline-nav-link rounded-md px-3 py-2 text-sm font-medium text-slate-700 transition-colors hover:text-orange-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-400 dark:text-slate-200 dark:hover:text-orange-300"
                :class="isActive('about') ? 'is-active text-orange-600 dark:text-orange-300' : ''"
            >
                About
            </a>
            <a
                href="{{ $isHomeRoute ? '#skills' : route('home').'#skills' }}"
                @click="navigateTo('skills', @js($isHomeRoute ? '#skills' : route('home').'#skills'), $event)"
                :aria-current="isActive('skills') ? 'page' : null"
                class="inline-nav-link rounded-md px-3 py-2 text-sm font-medium text-slate-700 transition-colors hover:text-orange-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-400 dark:text-slate-200 dark:hover:text-orange-300"
                :class="isActive('skills') ? 'is-active text-orange-600 dark:text-orange-300' : ''"
            >
                Skills
            </a>
            <a
                href="{{ $isHomeRoute ? '#projects' : route('home').'#projects' }}"
                @click="navigateTo('projects', @js($isHomeRoute ? '#projects' : route('home').'#projects'), $event)"
                :aria-current="isActive('projects') ? 'page' : null"
                class="inline-nav-link rounded-md px-3 py-2 text-sm font-medium text-slate-700 transition-colors hover:text-orange-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-400 dark:text-slate-200 dark:hover:text-orange-300"
                :class="isActive('projects') ? 'is-active text-orange-600 dark:text-orange-300' : ''"
            >
                Projects
            </a>
            <a
                href="{{ $isHomeRoute ? '#testimonials' : route('home').'#testimonials' }}"
                @click="navigateTo('testimonials', @js($isHomeRoute ? '#testimonials' : route('home').'#testimonials'), $event)"
                :aria-current="isActive('testimonials') ? 'page' : null"
                class="inline-nav-link rounded-md px-3 py-2 text-sm font-medium text-slate-700 transition-colors hover:text-orange-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-400 dark:text-slate-200 dark:hover:text-orange-300"
                :class="isActive('testimonials') ? 'is-active text-orange-600 dark:text-orange-300' : ''"
            >
                Testimonials
            </a>
            <a
                href="{{ $isHomeRoute ? '#contact' : route('home').'#contact' }}"
                @click="navigateTo('contact', @js($isHomeRoute ? '#contact' : route('home').'#contact'), $event)"
                :aria-current="isActive('contact') ? 'page' : null"
                class="inline-nav-link rounded-md px-3 py-2 text-sm font-medium text-slate-700 transition-colors hover:text-orange-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-400 dark:text-slate-200 dark:hover:text-orange-300"
                :class="isActive('contact') ? 'is-active text-orange-600 dark:text-orange-300' : ''"
            >
                Contact
            </a>
        </nav>
    </div>
</section>
