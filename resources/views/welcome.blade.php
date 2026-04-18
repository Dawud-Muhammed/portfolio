@extends('layouts.app')

@section('page_title', 'Dawud Muhammed | Laravel Developer')
@section('meta_description', 'Premium Laravel 13 portfolio with lazy sections, named route navigation, and persistent theme settings.')
@section('hero_name', 'Dawud Muhammed')
@section('hero_title', 'Laravel Developer')
@section('hero_cv_url', '#')
@section('about_bio', 'I design and ship Laravel products focused on reliability, maintainability, and user trust. From architecture to implementation, I prioritize clear communication, measurable outcomes, and long-term scalability.')
@section('about_profile_alt', 'Profile portrait of Dawud Muhammed')

@section('content')
    <section id="section-nav" class="mx-auto w-full max-w-7xl px-6 pt-10" aria-label="Portfolio section navigation">
        <div class="flex flex-wrap items-center justify-center gap-2 lg:justify-between">
            <nav class="flex flex-wrap items-center justify-center gap-2 lg:justify-start" aria-label="Primary section links">
                @foreach ($sectionLinks as $link)
                    <a
                        href="{{ $link['url'] }}"
                        class="rounded-full border border-slate-300/80 bg-white/75 px-4 py-2 text-xs font-semibold uppercase tracking-[0.16em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700"
                    >
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            <button
                type="button"
                @click="toggleTheme()"
                class="rounded-full border border-slate-300/80 bg-white/75 px-4 py-2 text-xs font-semibold uppercase tracking-[0.16em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700"
                aria-label="Toggle color theme"
            >
                <span x-text="theme === 'dark' ? 'Switch to Light' : 'Switch to Dark'"></span>
            </button>
        </div>
    </section>

    @include('partials.about')

    <main>
        <section class="mx-auto w-full max-w-7xl px-6">
            @include('partials.skills')
        </section>

        <section class="mx-auto w-full max-w-7xl px-6">
            <x-projects :projects="$projects" />
        </section>

        <section class="mx-auto w-full max-w-7xl px-6">
            <x-contact />
        </section>
    </main>
@endsection
