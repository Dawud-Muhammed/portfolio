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
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-900 antialiased" style="font-family: var(--font-body);">
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

        <main class="min-h-screen p-5 md:p-10">
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
