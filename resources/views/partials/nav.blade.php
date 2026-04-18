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
                <button
                    type="button"
                    @click="$dispatch('theme-toggle-request')"
                    class="inline-flex items-center rounded-full border border-slate-300/70 bg-white/70 px-3 py-2 text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700 sm:px-4"
                    aria-label="Toggle color theme"
                >
                    Theme
                </button>

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
            </nav>
        </div>
    </div>
</header>
