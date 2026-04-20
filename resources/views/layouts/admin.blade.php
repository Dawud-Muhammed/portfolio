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
<body x-data="{ mobileSidebarOpen: false }" class="bg-slate-100 text-slate-900 antialiased" style="font-family: var(--font-body);">
    <div class="min-h-screen md:pl-72">
        <aside class="fixed inset-y-0 left-0 z-40 hidden w-72 border-r border-slate-700 bg-slate-900 p-6 text-slate-100 md:block">
            <a href="{{ route('admin.dashboard') }}" class="block text-xl font-semibold tracking-tight" style="font-family: var(--font-display);">
                Admin Portal
            </a>

            <p class="mt-2 text-xs uppercase tracking-[0.18em] text-slate-400">
                Portfolio Control
            </p>

            <nav class="mt-10 space-y-2 text-sm" aria-label="Admin navigation">
                <a href="{{ route('admin.dashboard') }}" class="block rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}">Dashboard</a>
                <a href="{{ route('admin.projects.index') }}" class="block rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.projects.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}">Projects</a>
                <a href="{{ route('admin.posts.index') }}" class="block rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.posts.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}">Blog Posts</a>
                <a href="{{ route('admin.categories.index') }}" class="block rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.categories.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}">Categories</a>
                <a href="{{ route('admin.skills.index') }}" class="block rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.skills.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}">Skills</a>
                <a href="{{ route('admin.testimonials.index') }}" class="block rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.testimonials.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}">Testimonials</a>
                <a href="{{ route('admin.contacts.index') }}" class="block rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.contacts.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}">Contacts Inbox</a>
            </nav>

            <div class="mt-10 rounded-2xl border border-slate-700 bg-slate-800/80 p-4 text-xs text-slate-300">
                <p class="font-semibold text-slate-100">Signed in as</p>
                <p class="mt-1">{{ auth()->user()?->email }}</p>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full rounded-xl border border-orange-300/40 bg-orange-500/15 px-4 py-2 text-sm font-semibold text-orange-200 transition hover:bg-orange-500/30">
                    Logout
                </button>
            </form>
        </aside>

        <div
            x-cloak
            x-show="mobileSidebarOpen"
            x-transition.opacity.duration.200ms
            class="fixed inset-0 z-50 md:hidden"
            aria-modal="true"
            role="dialog"
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
                class="fixed inset-y-0 right-0 z-50 w-full max-w-xs bg-slate-900 p-6 text-slate-100"
            >
                <div class="flex items-center justify-between gap-4">
                    <a href="{{ route('admin.dashboard') }}" @click="mobileSidebarOpen = false" class="block text-xl font-semibold tracking-tight" style="font-family: var(--font-display);">
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
                    <a href="{{ route('admin.dashboard') }}" @click="mobileSidebarOpen = false" class="block rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}">Dashboard</a>
                    <a href="{{ route('admin.projects.index') }}" @click="mobileSidebarOpen = false" class="block rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.projects.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}">Projects</a>
                    <a href="{{ route('admin.posts.index') }}" @click="mobileSidebarOpen = false" class="block rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.posts.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}">Blog Posts</a>
                    <a href="{{ route('admin.categories.index') }}" @click="mobileSidebarOpen = false" class="block rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.categories.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}">Categories</a>
                    <a href="{{ route('admin.skills.index') }}" @click="mobileSidebarOpen = false" class="block rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.skills.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}">Skills</a>
                    <a href="{{ route('admin.testimonials.index') }}" @click="mobileSidebarOpen = false" class="block rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.testimonials.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}">Testimonials</a>
                    <a href="{{ route('admin.contacts.index') }}" @click="mobileSidebarOpen = false" class="block rounded-xl px-4 py-3 transition hover:bg-slate-800 {{ request()->routeIs('admin.contacts.*') ? 'bg-slate-800 text-orange-300' : 'text-slate-200' }}">Contacts Inbox</a>
                </nav>

                <div class="mt-10 rounded-2xl border border-slate-700 bg-slate-800/80 p-4 text-xs text-slate-300">
                    <p class="font-semibold text-slate-100">Signed in as</p>
                    <p class="mt-1 break-all">{{ auth()->user()?->email }}</p>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full rounded-xl border border-orange-300/40 bg-orange-500/15 px-4 py-2 text-sm font-semibold text-orange-200 transition hover:bg-orange-500/30">
                        Logout
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
                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-300 bg-white text-slate-700 transition hover:border-orange-300 hover:text-orange-700"
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
