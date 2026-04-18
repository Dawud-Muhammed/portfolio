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

    <main x-data="lazySections()" x-init="initObservers($refs)">
        <section id="skills-lazy" data-lazy-section="skills" x-ref="skills" class="mx-auto w-full max-w-7xl px-6">
            <template x-if="loaded.skills">
                <div>
                    @include('partials.skills')
                </div>
            </template>
            <div x-show="!loaded.skills" class="rounded-3xl border border-slate-200/70 bg-white/75 p-8 text-sm text-slate-500">
                Loading skills section...
            </div>
        </section>

        <section id="projects-lazy" data-lazy-section="projects" x-ref="projects" class="mx-auto w-full max-w-7xl px-6">
            <template x-if="loaded.projects">
                <div>
                    <x-projects />
                </div>
            </template>
            <div x-show="!loaded.projects" class="rounded-3xl border border-slate-200/70 bg-white/75 p-8 text-sm text-slate-500">
                Loading projects section...
            </div>
        </section>

        <section id="contact-lazy" data-lazy-section="contact" x-ref="contact" class="mx-auto w-full max-w-7xl px-6">
            <template x-if="loaded.contact">
                <div>
                    <x-contact />
                </div>
            </template>
            <div x-show="!loaded.contact" class="rounded-3xl border border-slate-200/70 bg-white/75 p-8 text-sm text-slate-500">
                Loading contact section...
            </div>
        </section>
    </main>
@endsection
