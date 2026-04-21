@php
    $navLinks = [
        ['id' => 'about', 'label' => 'About'],
        ['id' => 'skills', 'label' => 'Skills'],
        ['id' => 'projects', 'label' => 'Projects'],
        ['id' => 'testimonials', 'label' => 'Testimonials'],
        ['id' => 'contact', 'label' => 'Contact'],
    ];
@endphp

<header
    x-data="navController()"
    x-init="init()"
    class="fixed inset-x-0 top-0 z-[60] transition-transform duration-300"
    :class="isNavVisible ? 'translate-y-0' : '-translate-y-full'"
>
    <div class="mx-auto mt-3 w-[min(1120px,calc(100%-1.5rem))] rounded-2xl border border-slate-300/55 bg-white/75 shadow-[0_18px_45px_-30px_rgba(15,23,42,0.55)] backdrop-blur-xl">
        <div class="flex items-center justify-between px-4 py-3 sm:px-6">
            <a href="{{ route('home') }}" class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-900 sm:text-base" style="font-family: var(--font-display);">
                Dawud Muhammed
            </a>

            <nav class="hidden items-center gap-2 md:flex" aria-label="Primary navigation">
                @foreach ($navLinks as $link)
                    <a
                        href="{{ route('home').'#'.$link['id'] }}"
                        class="rounded-full border px-4 py-2 text-xs font-semibold uppercase tracking-[0.15em] transition"
                        :class="activeSection === '{{ $link['id'] }}'
                            ? 'border-orange-300 bg-orange-500/12 text-orange-700'
                            : 'border-transparent text-slate-700 hover:border-orange-200 hover:text-orange-700'"
                    >
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="flex items-center gap-2">
                <div class="relative" @click.outside="closeThemeMenu()">
                    <button
                        type="button"
                        @click="toggleThemeMenu()"
                        class="inline-flex items-center gap-1.5 rounded-full border border-slate-300/70 bg-white/70 px-3 py-2 text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700 sm:px-4"
                        :aria-expanded="isThemeMenuOpen"
                        aria-haspopup="true"
                        aria-label="Choose color theme"
                    >
                        <span class="inline-flex h-4 w-4 items-center justify-center" aria-hidden="true">
                            <svg x-show="selectedTheme === 'system'" x-cloak xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="h-4 w-4">
                                <rect x="3" y="4" width="18" height="12" rx="2" />
                                <path d="M8 20h8M12 16v4" />
                            </svg>
                            <svg x-show="selectedTheme === 'dark'" x-cloak xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="h-4 w-4">
                                <path d="M21 12.79A9 9 0 1 1 11.21 3c.25 0 .49.01.73.03A7 7 0 0 0 21 12.79z" />
                            </svg>
                            <svg x-show="selectedTheme === 'light'" x-cloak xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="h-4 w-4">
                                <circle cx="12" cy="12" r="4" />
                                <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41" />
                            </svg>
                        </span>
                        <span x-text="selectedTheme === 'system' ? 'System' : (selectedTheme === 'dark' ? 'Dark' : 'Light')"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5 text-slate-500">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.51a.75.75 0 0 1-1.08 0l-4.25-4.51a.75.75 0 0 1 .02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div
                        x-show="isThemeMenuOpen"
                        x-transition.origin.top.right.duration.160ms
                        x-cloak
                        class="absolute right-0 top-[calc(100%+0.5rem)] z-30 w-44 rounded-2xl border border-slate-300/80 bg-white/95 p-1.5 shadow-[0_18px_44px_-28px_rgba(15,23,42,0.58)] backdrop-blur"
                    >
                        <button
                            type="button"
                            @click="selectTheme('system')"
                            class="flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-[11px] font-semibold uppercase tracking-[0.14em] transition"
                            :class="selectedTheme === 'system' ? 'bg-orange-500/12 text-orange-700' : 'text-slate-700 hover:bg-orange-500/8 hover:text-orange-700'"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="h-4 w-4" aria-hidden="true">
                                <rect x="3" y="4" width="18" height="12" rx="2" />
                                <path d="M8 20h8M12 16v4" />
                            </svg>
                            <span>System</span>
                        </button>

                        <button
                            type="button"
                            @click="selectTheme('dark')"
                            class="mt-1 flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-[11px] font-semibold uppercase tracking-[0.14em] transition"
                            :class="selectedTheme === 'dark' ? 'bg-orange-500/12 text-orange-700' : 'text-slate-700 hover:bg-orange-500/8 hover:text-orange-700'"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="h-4 w-4" aria-hidden="true">
                                <path d="M21 12.79A9 9 0 1 1 11.21 3c.25 0 .49.01.73.03A7 7 0 0 0 21 12.79z" />
                            </svg>
                            <span>Dark</span>
                        </button>

                        <button
                            type="button"
                            @click="selectTheme('light')"
                            class="mt-1 flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-[11px] font-semibold uppercase tracking-[0.14em] transition"
                            :class="selectedTheme === 'light' ? 'bg-orange-500/12 text-orange-700' : 'text-slate-700 hover:bg-orange-500/8 hover:text-orange-700'"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="h-4 w-4" aria-hidden="true">
                                <circle cx="12" cy="12" r="4" />
                                <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41" />
                            </svg>
                            <span>Light</span>
                        </button>
                    </div>
                </div>

                @guest
                    <a
                        href="{{ route('login') }}"
                        class="hidden rounded-full border border-slate-300/70 bg-white/70 px-3 py-2 text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700 sm:px-4 md:inline-flex"
                        aria-label="Open login page"
                    >
                        Login
                    </a>
                @endguest

                @auth
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="hidden rounded-full border border-slate-300/70 bg-white/70 px-3 py-2 text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700 sm:px-4 md:inline-flex"
                        aria-label="Open admin dashboard"
                    >
                        Admin
                    </a>
                @endauth

                <button
                    type="button"
                    @click="toggleDrawer()"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-300/70 bg-white/70 text-slate-700 transition hover:border-orange-300 hover:text-orange-700 md:hidden"
                    aria-label="Toggle navigation menu"
                    :aria-expanded="isDrawerOpen"
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

        <div
            x-show="isDrawerOpen"
            x-transition.opacity.duration.200ms
            x-cloak
            class="border-t border-slate-300/60 px-4 py-4 md:hidden"
        >
            <nav class="grid gap-2" aria-label="Mobile navigation">
                @foreach ($navLinks as $link)
                    <a
                        href="{{ route('home').'#'.$link['id'] }}"
                        @click="closeDrawer()"
                        class="rounded-xl border px-4 py-3 text-xs font-semibold uppercase tracking-[0.14em] transition"
                        :class="activeSection === '{{ $link['id'] }}'
                            ? 'border-orange-300 bg-orange-500/12 text-orange-700'
                            : 'border-slate-300 text-slate-700 hover:border-orange-300 hover:text-orange-700'"
                    >
                        {{ $link['label'] }}
                    </a>
                @endforeach

                @guest
                    <a
                        href="{{ route('login') }}"
                        @click="closeDrawer()"
                        class="rounded-xl border border-slate-300 px-4 py-3 text-xs font-semibold uppercase tracking-[0.14em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700"
                        aria-label="Open login page"
                    >
                        Login
                    </a>
                @endguest

                @auth
                    <a
                        href="{{ route('admin.dashboard') }}"
                        @click="closeDrawer()"
                        class="rounded-xl border border-slate-300 px-4 py-3 text-xs font-semibold uppercase tracking-[0.14em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700"
                        aria-label="Open admin dashboard"
                    >
                        Admin
                    </a>
                @endauth
            </nav>
        </div>
    </div>
</header>
