@extends('layouts.admin')

@section('page_title', 'Admin Dashboard')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-semibold tracking-tight text-slate-900" style="font-family: var(--font-display);">Dashboard</h1>
        <p class="mt-2 text-sm text-slate-600">Overview of portfolio activity and content.</p>
    </div>

    <section class="grid grid-cols-1 gap-5 md:grid-cols-3">
        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-premium">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Projects</p>
            <p class="mt-3 text-4xl font-semibold text-slate-900" style="font-family: var(--font-display);">{{ $projectCount }}</p>
        </article>

        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-premium">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Blog Posts</p>
            <p class="mt-3 text-4xl font-semibold text-slate-900" style="font-family: var(--font-display);">{{ $postCount }}</p>
        </article>

        <article class="rounded-3xl border border-orange-200 bg-orange-50 p-6 shadow-premium">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-orange-700">Unread Contacts</p>
            <p class="mt-3 text-4xl font-semibold text-orange-800" style="font-family: var(--font-display);">{{ $unreadContactCount }}</p>
        </article>
    </section>
@endsection
