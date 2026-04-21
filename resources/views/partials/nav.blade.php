@php
    $isHomeRoute = request()->routeIs('home');

    $primaryLinks = [
        [
            'label' => 'Home',
            'href' => $isHomeRoute ? '#top' : route('home').'#top',
            'active' => $isHomeRoute,
        ],
        [
            'label' => 'About',
            'href' => $isHomeRoute ? '#about' : route('home').'#about',
            'active' => false,
        ],
        [
            'label' => 'Projects',
            'href' => $isHomeRoute ? '#projects' : route('home').'#projects',
            'active' => false,
        ],
        [
            'label' => 'Contact',
            'href' => $isHomeRoute ? '#contact' : route('home').'#contact',
            'active' => false,
        ],
    ];

    $quickLinks = array_map(static fn ($link) => [
        'label' => $link['label'],
        'href' => $link['href'],
    ], $primaryLinks);
@endphp

<header
    x-data="navController({
        isHomeRoute: @js($isHomeRoute),
        homeUrl: @js(route('home')),
        linkCatalog: @js($quickLinks),
    })"
    x-init="init()"
    @keydown.escape.window="closeDrawer()"
    class="site-nav sticky top-0 z-[60] px-3 pt-3 sm:px-4"
    :class="isNavVisible ? 'translate-y-0 opacity-100' : '-translate-y-full opacity-0'"
>
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <div class="site-nav__shell mx-auto w-[min(1120px,100%)] rounded-2xl border border-slate-300/70 bg-white/90 shadow-[0_18px_45px_-30px_rgba(15,23,42,0.55)] backdrop-blur-xl dark:border-slate-700/70 dark:bg-slate-900/85">
        <div class="grid grid-cols-[1fr_auto] items-center gap-3 px-4 py-3 sm:px-6 lg:grid-cols-[auto_1fr_auto]">
            <a href="{{ route('home') }}" class="site-nav__brand justify-self-start text-sm font-semibold uppercase tracking-[0.16em] text-slate-900 transition hover:text-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-400 focus-visible:ring-offset-2 dark:text-slate-100 dark:hover:text-orange-300 dark:focus-visible:ring-offset-slate-900 sm:text-base" style="font-family: var(--font-display);">
                Dawud Muhammed
            </a>

            <nav class="site-nav__menu hidden items-center justify-center gap-2 md:flex" aria-label="Primary navigation" id="site-primary-nav">
                @foreach ($primaryLinks as $link)
                    <a
                        href="{{ $link['href'] }}"
                        @click="closeDrawer()"
                        :aria-current="isLinkActive(@js($link['href'])) ? 'page' : null"
                        class="site-nav__link group relative rounded-full border border-slate-300/80 bg-white/85 px-3 py-2 text-xs font-semibold uppercase tracking-[0.15em] text-slate-800 transition hover:border-orange-300 hover:text-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-400 focus-visible:ring-offset-2 dark:border-slate-700/80 dark:bg-slate-800/80 dark:text-slate-100 dark:hover:border-orange-400 dark:hover:text-orange-300 dark:focus-visible:ring-offset-slate-900 lg:px-4"
                        :class="isLinkActive(@js($link['href'])) ? 'border-orange-300 bg-orange-500/12 text-orange-800 dark:border-orange-400 dark:bg-orange-500/20 dark:text-orange-100' : ''"
                    >
                        <span>{{ $link['label'] }}</span>
                        <span
                            aria-hidden="true"
                            class="absolute -bottom-0.5 left-1/2 h-0.5 w-8 -translate-x-1/2 rounded-full bg-orange-500 opacity-0 transition-all duration-300 group-hover:opacity-100"
                            :class="isLinkActive(@js($link['href'])) ? 'opacity-100' : ''"
                        ></span>
                    </a>
                @endforeach
            </nav>

            <div class="hidden items-center gap-2 lg:flex">
                <form @submit.prevent="runQuickSearch()" class="site-nav__search flex items-center gap-2 rounded-full border border-slate-300/85 bg-white/85 px-3 py-1.5 dark:border-slate-700 dark:bg-slate-800/80" role="search" aria-label="Quick section search">
                    <label for="nav-quick-search" class="sr-only">Search sections</label>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 text-slate-500 dark:text-slate-300" aria-hidden="true">
                        <path d="m21 21-4.35-4.35" />
                        <circle cx="11" cy="11" r="7" />
                    </svg>
                    <input
                        id="nav-quick-search"
                        x-model="quickQuery"
                        type="search"
                        list="site-nav-search-options"
                        placeholder="Find section"
                        class="w-28 border-0 bg-transparent p-0 text-xs font-medium text-slate-800 placeholder:text-slate-500 focus:ring-0 dark:text-slate-100 dark:placeholder:text-slate-400 xl:w-36"
                        aria-label="Find section"
                    >
                </form>
            </div>

            <div class="flex items-center justify-self-end gap-2">
                @guest
                    <a
                        href="{{ route('login') }}"
                        class="hidden rounded-full border border-slate-300/70 bg-white/70 px-3 py-2 text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-400 focus-visible:ring-offset-2 dark:border-slate-700 dark:bg-slate-800/80 dark:text-slate-100 dark:hover:border-orange-400 dark:hover:text-orange-300 dark:focus-visible:ring-offset-slate-900 sm:px-4 md:inline-flex"
                        aria-label="Open login page"
                    >
                        Login
                    </a>
                @endguest

                @auth
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="hidden rounded-full border border-slate-300/70 bg-white/70 px-3 py-2 text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-400 focus-visible:ring-offset-2 dark:border-slate-700 dark:bg-slate-800/80 dark:text-slate-100 dark:hover:border-orange-400 dark:hover:text-orange-300 dark:focus-visible:ring-offset-slate-900 sm:px-4 md:inline-flex"
                        aria-label="Open admin dashboard"
                    >
                        Admin
                    </a>
                @endauth

                <button
                    type="button"
                    @click="toggleDrawer()"
                    @keydown.enter.prevent="toggleDrawer()"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-slate-300/70 bg-white/80 text-slate-700 transition hover:border-orange-300 hover:text-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-400 focus-visible:ring-offset-2 dark:border-slate-700 dark:bg-slate-800/80 dark:text-slate-100 dark:hover:border-orange-400 dark:hover:text-orange-300 dark:focus-visible:ring-offset-slate-900 md:hidden"
                    aria-label="Toggle primary navigation menu"
                    :aria-expanded="isDrawerOpen"
                    aria-controls="mobile-site-nav"
                    x-ref="drawerToggle"
                >
                    <svg x-show="!isDrawerOpen" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5" aria-hidden="true">
                        <path d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                    <svg x-show="isDrawerOpen" x-cloak xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5" aria-hidden="true">
                        <path d="m6 6 12 12M18 6 6 18" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="border-t border-slate-300/65 px-4 py-3 dark:border-slate-700/70 sm:px-6">
            <div class="mx-auto flex w-full max-w-xl items-center justify-center gap-2 rounded-2xl border border-slate-300/85 bg-slate-100/85 p-1.5">
                <button
                    type="button"
                    @click="selectTheme('light')"
                    class="inline-flex min-w-[84px] items-center justify-center rounded-xl border px-3 py-2 text-[11px] font-semibold uppercase tracking-[0.14em] transition"
                    :class="selectedTheme === 'light' ? 'border-slate-900 bg-slate-900 text-white shadow-sm' : 'border-slate-300 bg-white text-slate-800 hover:border-orange-400 hover:text-orange-700'"
                    aria-label="Set light theme"
                >
                    Light
                </button>
                <button
                    type="button"
                    @click="selectTheme('dark')"
                    class="inline-flex min-w-[84px] items-center justify-center rounded-xl border px-3 py-2 text-[11px] font-semibold uppercase tracking-[0.14em] transition"
                    :class="selectedTheme === 'dark' ? 'border-slate-900 bg-slate-900 text-white shadow-sm' : 'border-slate-300 bg-white text-slate-800 hover:border-orange-400 hover:text-orange-700'"
                    aria-label="Set dark theme"
                >
                    Dark
                </button>
                <button
                    type="button"
                    @click="selectTheme('system')"
                    class="inline-flex min-w-[84px] items-center justify-center rounded-xl border px-3 py-2 text-[11px] font-semibold uppercase tracking-[0.14em] transition"
                    :class="selectedTheme === 'system' ? 'border-blue-700 bg-blue-700 text-white shadow-sm' : 'border-slate-300 bg-white text-slate-800 hover:border-blue-600 hover:text-blue-700'"
                    aria-label="Use system theme"
                >
                    System
                </button>
            </div>
        </div>

        <div
            x-show="isDrawerOpen"
            x-transition:enter="transition ease-out duration-220"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            x-cloak
            id="mobile-site-nav"
            :aria-hidden="!isDrawerOpen"
            class="border-t border-slate-300/60 px-4 py-4 dark:border-slate-700/70 md:hidden"
        >
            <form @submit.prevent="runQuickSearch(); closeDrawer()" class="mb-3 flex items-center gap-2 rounded-xl border border-slate-300/80 bg-white/80 px-3 py-2 dark:border-slate-700 dark:bg-slate-800/80" role="search" aria-label="Mobile section search">
                <label for="mobile-nav-search" class="sr-only">Search sections</label>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 text-slate-500 dark:text-slate-300" aria-hidden="true">
                    <path d="m21 21-4.35-4.35" />
                    <circle cx="11" cy="11" r="7" />
                </svg>
                <input
                    id="mobile-nav-search"
                    x-ref="mobileNavSearch"
                    x-model="quickQuery"
                    type="search"
                    list="site-nav-search-options"
                    placeholder="Search sections"
                    class="w-full border-0 bg-transparent p-0 text-sm text-slate-800 placeholder:text-slate-500 focus:ring-0 dark:text-slate-100 dark:placeholder:text-slate-400"
                    aria-label="Search sections"
                >
            </form>

            <nav class="grid gap-2" aria-label="Mobile navigation links">
                @foreach ($primaryLinks as $link)
                    <a
                        href="{{ $link['href'] }}"
                        @click="closeDrawer()"
                        :aria-current="isLinkActive(@js($link['href'])) ? 'page' : null"
                        @if ($loop->first) x-ref="firstMobileLink" @endif
                        class="group relative rounded-xl border border-slate-300 px-4 py-3 text-xs font-semibold uppercase tracking-[0.14em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-400 focus-visible:ring-offset-2 dark:border-slate-700 dark:text-slate-100 dark:hover:border-orange-400 dark:hover:text-orange-300 dark:focus-visible:ring-offset-slate-900"
                        :class="isLinkActive(@js($link['href'])) ? 'border-orange-300 bg-orange-500/12 text-orange-700 dark:border-orange-400 dark:bg-orange-500/20 dark:text-orange-100' : ''"
                    >
                        <span>{{ $link['label'] }}</span>
                        <span
                            aria-hidden="true"
                            class="absolute left-2 top-1/2 h-5 w-0.5 -translate-y-1/2 rounded-full bg-orange-500 opacity-0 transition-all duration-300 group-hover:opacity-100"
                            :class="isLinkActive(@js($link['href'])) ? 'opacity-100' : ''"
                        ></span>
                    </a>
                @endforeach

                @guest
                    <a
                        href="{{ route('login') }}"
                        @click="closeDrawer()"
                        class="rounded-xl border border-slate-300 px-4 py-3 text-xs font-semibold uppercase tracking-[0.14em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-400 focus-visible:ring-offset-2 dark:border-slate-700 dark:text-slate-100 dark:hover:border-orange-400 dark:hover:text-orange-300 dark:focus-visible:ring-offset-slate-900"
                        aria-label="Open login page"
                    >
                        Login
                    </a>
                @endguest

                @auth
                    <a
                        href="{{ route('admin.dashboard') }}"
                        @click="closeDrawer()"
                        class="rounded-xl border border-slate-300 px-4 py-3 text-xs font-semibold uppercase tracking-[0.14em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-400 focus-visible:ring-offset-2 dark:border-slate-700 dark:text-slate-100 dark:hover:border-orange-400 dark:hover:text-orange-300 dark:focus-visible:ring-offset-slate-900"
                        aria-label="Open admin dashboard"
                    >
                        Admin
                    </a>
                @endauth
            </nav>
        </div>

        <datalist id="site-nav-search-options">
            @foreach ($primaryLinks as $link)
                <option value="{{ $link['label'] }}"></option>
            @endforeach
        </datalist>
    </div>
</header>
