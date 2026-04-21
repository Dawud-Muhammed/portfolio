<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Admin portal for managing portfolio projects, blog posts, and contacts.">
    <title>{{ trim($__env->yieldContent('page_title', 'Admin Portal')) }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --font-display: 'Sora', sans-serif;
            --font-body: 'Space Grotesk', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    x-data="{
        mobileSidebarOpen: false,
        mediaQuery: null,
        mediaQueryHandler: null,
        init() {
            this.mediaQuery = window.matchMedia('(min-width: 768px)');
            this.mediaQueryHandler = (event) => {
                if (event.matches) {
                    this.mobileSidebarOpen = false;
                }
            };

            if (typeof this.mediaQuery.addEventListener === 'function') {
                this.mediaQuery.addEventListener('change', this.mediaQueryHandler);
            } else {
                this.mediaQuery.addListener(this.mediaQueryHandler);
            }

            if (this.mediaQuery.matches) {
                this.mobileSidebarOpen = false;
            }

            this.$el.addEventListener(
                'alpine:destroy',
                () => {
                    if (!this.mediaQuery || !this.mediaQueryHandler) {
                        return;
                    }

                    if (typeof this.mediaQuery.removeEventListener === 'function') {
                        this.mediaQuery.removeEventListener('change', this.mediaQueryHandler);
                    } else {
                        this.mediaQuery.removeListener(this.mediaQueryHandler);
                    }
                },
                { once: true }
            );
        },
        isMobileViewport() {
            return window.innerWidth < 768;
        },
    }"
    class="bg-slate-100 text-slate-900 antialiased"
    style="font-family: var(--font-body);"
>
    <div class="min-h-screen md:pl-72">
        <aside class="admin-sidebar fixed inset-y-0 left-0 z-40 hidden w-72 overflow-y-auto border-r border-slate-700 bg-slate-900 px-6 pb-6 pt-6 text-slate-100 md:block">
            <a href="{{ route('admin.dashboard') }}" class="block text-xl font-semibold tracking-tight" style="font-family: var(--font-display);">
                Admin Portal
            </a>

            <p class="mt-2 text-xs uppercase tracking-[0.18em] text-slate-400">
                Portfolio Control
            </p>

            <nav class="mt-10 space-y-2 text-sm" aria-label="Admin navigation">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="inline-block h-4 w-4 align-middle" aria-hidden="true"><rect x="3" y="3" width="8" height="8" rx="1.5" /><rect x="13" y="3" width="8" height="8" rx="1.5" /><rect x="3" y="13" width="8" height="8" rx="1.5" /><rect x="13" y="13" width="8" height="8" rx="1.5" /></svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.projects.index') }}" class="flex items-center gap-2 rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.projects.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="inline-block h-4 w-4 align-middle" aria-hidden="true"><path d="M3 7a2 2 0 0 1 2-2h5l2 2h7a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7z" /></svg>
                    <span>Projects</span>
                </a>
                <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-2 rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.posts.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="inline-block h-4 w-4 align-middle" aria-hidden="true"><path d="M7 3h7l5 5v13H7z" /><path d="M14 3v5h5" /><path d="M9 13h8M9 17h8" /></svg>
                    <span>Blog Posts</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-2 rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.categories.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="inline-block h-4 w-4 align-middle" aria-hidden="true"><path d="M20 12l-8 8-8-8 8-8h8v8z" /><circle cx="16.5" cy="7.5" r="1.2" /></svg>
                    <span>Categories</span>
                </a>
                <a href="{{ route('admin.skills.index') }}" class="flex items-center gap-2 rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.skills.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="inline-block h-4 w-4 align-middle" aria-hidden="true"><path d="m12 3 2.7 5.47 6.04.88-4.37 4.26 1.03 6.02L12 16.8 6.6 19.63l1.03-6.02-4.37-4.26 6.04-.88L12 3z" /></svg>
                    <span>Skills</span>
                </a>
                <a href="{{ route('admin.testimonials.index') }}" class="flex items-center gap-2 rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.testimonials.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="inline-block h-4 w-4 align-middle" aria-hidden="true"><path d="M21 12a8 8 0 0 1-8 8H5l-2 2V12a8 8 0 0 1 8-8h2a8 8 0 0 1 8 8z" /></svg>
                    <span>Testimonials</span>
                </a>
                <a href="{{ route('admin.settings.edit') }}" class="flex items-center gap-2 rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.settings.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="inline-block h-4 w-4 align-middle" aria-hidden="true"><circle cx="12" cy="12" r="3" /><path d="M19.4 15a1.8 1.8 0 0 0 .36 1.98l.05.05a2 2 0 1 1-2.83 2.83l-.05-.05a1.8 1.8 0 0 0-1.98-.36 1.8 1.8 0 0 0-1.1 1.65V21a2 2 0 1 1-4 0v-.08a1.8 1.8 0 0 0-1.1-1.65 1.8 1.8 0 0 0-1.98.36l-.05.05a2 2 0 1 1-2.83-2.83l.05-.05A1.8 1.8 0 0 0 4.6 15a1.8 1.8 0 0 0-1.65-1.1H2.9a2 2 0 1 1 0-4h.05a1.8 1.8 0 0 0 1.65-1.1 1.8 1.8 0 0 0-.36-1.98l-.05-.05a2 2 0 1 1 2.83-2.83l.05.05a1.8 1.8 0 0 0 1.98.36H9.1a1.8 1.8 0 0 0 1.1-1.65V3a2 2 0 1 1 4 0v.05a1.8 1.8 0 0 0 1.1 1.65 1.8 1.8 0 0 0 1.98-.36l.05-.05a2 2 0 1 1 2.83 2.83l-.05.05a1.8 1.8 0 0 0-.36 1.98v.05a1.8 1.8 0 0 0 1.65 1.1H21a2 2 0 1 1 0 4h-.05a1.8 1.8 0 0 0-1.55.9z" /></svg>
                    <span>Site Settings</span>
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="flex items-center gap-2 rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.contacts.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="inline-block h-4 w-4 align-middle" aria-hidden="true"><path d="M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1z" /><path d="m3 7 9 7 9-7" /></svg>
                    <span>Contacts Inbox</span>
                </a>
            </nav>

            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" onclick="return confirm('Are you sure you want to log out?')" class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-orange-300/40 bg-orange-500/15 px-4 py-2 text-sm font-semibold text-orange-200 transition hover:bg-orange-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="inline-block h-4 w-4 align-middle" aria-hidden="true"><path d="M14 7l5 5-5 5" /><path d="M19 12H9" /><path d="M12 19H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h6" /></svg>
                    <span>Logout</span>
                </button>
            </form>

            <div class="mt-10 rounded-2xl border border-slate-700 bg-slate-800/80 p-4 text-xs text-slate-300">
                <p class="font-semibold text-slate-100">Signed in as</p>
                <p class="mt-1">{{ auth()->user()?->email }}</p>
            </div>

        </aside>

        <div
            x-cloak
            x-show="mobileSidebarOpen && isMobileViewport()"
            x-transition.opacity.duration.200ms
            class="fixed inset-0 z-50 md:hidden"
            aria-modal="true"
            role="dialog"
            aria-labelledby="mobile-admin-sidebar-title"
        >
            <div class="absolute inset-0 bg-slate-950/65" @click="mobileSidebarOpen = false"></div>

            <aside
                x-show="mobileSidebarOpen"
                x-transition:enter="transform transition ease-out duration-200"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in duration-150"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="admin-sidebar fixed inset-y-0 right-0 z-50 w-full max-w-xs overflow-y-auto bg-slate-900 p-6 text-slate-100"
            >
                <div class="flex items-center justify-between gap-4">
                    <a id="mobile-admin-sidebar-title" href="{{ route('admin.dashboard') }}" @click="mobileSidebarOpen = false" class="block text-xl font-semibold tracking-tight" style="font-family: var(--font-display);">
                        Admin Portal
                    </a>

                    <button
                        type="button"
                        @click="mobileSidebarOpen = false"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-700 bg-slate-800 text-xl text-slate-200 transition hover:border-orange-300 hover:text-orange-200"
                        aria-label="Close navigation"
                    >
                        ×
                    </button>
                </div>

                <p class="mt-2 text-xs uppercase tracking-[0.18em] text-slate-400">
                    Portfolio Control
                </p>

                <nav class="mt-10 space-y-2 text-sm" aria-label="Mobile admin navigation">
                    <a href="{{ route('admin.dashboard') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-2 rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="inline-block h-4 w-4 align-middle" aria-hidden="true"><rect x="3" y="3" width="8" height="8" rx="1.5" /><rect x="13" y="3" width="8" height="8" rx="1.5" /><rect x="3" y="13" width="8" height="8" rx="1.5" /><rect x="13" y="13" width="8" height="8" rx="1.5" /></svg><span>Dashboard</span></a>
                    <a href="{{ route('admin.projects.index') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-2 rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.projects.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="inline-block h-4 w-4 align-middle" aria-hidden="true"><path d="M3 7a2 2 0 0 1 2-2h5l2 2h7a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7z" /></svg><span>Projects</span></a>
                    <a href="{{ route('admin.posts.index') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-2 rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.posts.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="inline-block h-4 w-4 align-middle" aria-hidden="true"><path d="M7 3h7l5 5v13H7z" /><path d="M14 3v5h5" /><path d="M9 13h8M9 17h8" /></svg><span>Blog Posts</span></a>
                    <a href="{{ route('admin.categories.index') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-2 rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.categories.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="inline-block h-4 w-4 align-middle" aria-hidden="true"><path d="M20 12l-8 8-8-8 8-8h8v8z" /><circle cx="16.5" cy="7.5" r="1.2" /></svg><span>Categories</span></a>
                    <a href="{{ route('admin.skills.index') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-2 rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.skills.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="inline-block h-4 w-4 align-middle" aria-hidden="true"><path d="m12 3 2.7 5.47 6.04.88-4.37 4.26 1.03 6.02L12 16.8 6.6 19.63l1.03-6.02-4.37-4.26 6.04-.88L12 3z" /></svg><span>Skills</span></a>
                    <a href="{{ route('admin.testimonials.index') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-2 rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.testimonials.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="inline-block h-4 w-4 align-middle" aria-hidden="true"><path d="M21 12a8 8 0 0 1-8 8H5l-2 2V12a8 8 0 0 1 8-8h2a8 8 0 0 1 8 8z" /></svg><span>Testimonials</span></a>
                    <a href="{{ route('admin.settings.edit') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-2 rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.settings.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="inline-block h-4 w-4 align-middle" aria-hidden="true"><circle cx="12" cy="12" r="3" /><path d="M19.4 15a1.8 1.8 0 0 0 .36 1.98l.05.05a2 2 0 1 1-2.83 2.83l-.05-.05a1.8 1.8 0 0 0-1.98-.36 1.8 1.8 0 0 0-1.1 1.65V21a2 2 0 1 1-4 0v-.08a1.8 1.8 0 0 0-1.1-1.65 1.8 1.8 0 0 0-1.98.36l-.05.05a2 2 0 1 1-2.83-2.83l.05-.05A1.8 1.8 0 0 0 4.6 15a1.8 1.8 0 0 0-1.65-1.1H2.9a2 2 0 1 1 0-4h.05a1.8 1.8 0 0 0 1.65-1.1 1.8 1.8 0 0 0-.36-1.98l-.05-.05a2 2 0 1 1 2.83-2.83l.05.05a1.8 1.8 0 0 0 1.98.36H9.1a1.8 1.8 0 0 0 1.1-1.65V3a2 2 0 1 1 4 0v.05a1.8 1.8 0 0 0 1.1 1.65 1.8 1.8 0 0 0 1.98-.36l.05-.05a2 2 0 1 1 2.83 2.83l-.05.05a1.8 1.8 0 0 0-.36 1.98v.05a1.8 1.8 0 0 0 1.65 1.1H21a2 2 0 1 1 0 4h-.05a1.8 1.8 0 0 0-1.55.9z" /></svg><span>Site Settings</span></a>
                    <a href="{{ route('admin.contacts.index') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-2 rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.contacts.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="inline-block h-4 w-4 align-middle" aria-hidden="true"><path d="M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1z" /><path d="m3 7 9 7 9-7" /></svg><span>Contacts Inbox</span></a>
                </nav>

                <div class="mt-10 rounded-2xl border border-slate-700 bg-slate-800/80 p-4 text-xs text-slate-300">
                    <p class="font-semibold text-slate-100">Signed in as</p>
                    <p class="mt-1 break-all">{{ auth()->user()?->email }}</p>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" onclick="return confirm('Are you sure you want to log out?')" class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-orange-300/40 bg-orange-500/15 px-4 py-2 text-sm font-semibold text-orange-200 transition hover:bg-orange-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="inline-block h-4 w-4 align-middle" aria-hidden="true"><path d="M14 7l5 5-5 5" /><path d="M19 12H9" /><path d="M12 19H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h6" /></svg>
                        <span>Logout</span>
                    </button>
                </form>
            </aside>
        </div>

        <main class="min-h-screen p-5 md:p-10">
            <header class="mb-6 flex items-center justify-between rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-premium md:hidden">
                <p class="text-sm font-semibold tracking-[0.04em] text-slate-900" style="font-family: var(--font-display);">Admin Portal</p>
                <button
                    type="button"
                    @click="mobileSidebarOpen = true"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-300 bg-white text-slate-700 transition hover:border-orange-300 hover:text-orange-700 md:hidden"
                    aria-label="Open navigation"
                >
                    <span class="text-lg leading-none">☰</span>
                </button>
            </header>

            @if (session('status'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-3 text-sm text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
