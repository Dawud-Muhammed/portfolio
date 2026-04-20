@extends('layouts.app')

@section('page_title', $project->title.' | Project Case Study')
@section('meta_description', $project->description)
@section('hero_name', 'Selected Work')
@section('hero_title', $project->title)
@section('hero_cv_url', route('home').'#projects')
@section('hero_background', $project->image)

@php
    $projectHeroWebp = preg_replace('/\.(jpe?g)(\?.*)?$/i', '.webp$2', $project->image);
@endphp

@section('content')
    <main class="mx-auto w-full max-w-6xl px-6 pb-20 pt-10" aria-labelledby="project-title">
        <div
            x-data="slideInOnScroll()"
            x-init="observe($el)"
            :class="isVisible ? 'is-visible' : ''"
            class="about-reveal space-y-8"
        >
            <a
                href="{{ route('home') }}#projects"
                class="inline-flex items-center rounded-full border border-slate-300/80 bg-white/75 px-4 py-2 text-xs font-semibold uppercase tracking-[0.16em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700"
            >
                Back to Projects
            </a>

            <article class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white/85 shadow-[0_24px_60px_-32px_rgba(15,23,42,0.55)] backdrop-blur-sm">
                <div class="relative overflow-hidden">
                    <picture>
                        <source srcset="{{ $projectHeroWebp }}" type="image/webp">
                        <img
                            src="{{ $project->image }}"
                            alt="Hero image for {{ $project->title }}"
                            class="h-64 w-full object-cover md:h-80"
                            width="1600"
                            height="900"
                            loading="eager"
                            fetchpriority="high"
                            decoding="async"
                        >
                    </picture>
                    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-950/60 via-slate-900/20 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <h1 id="project-title" class="text-3xl font-semibold tracking-tight text-white md:text-4xl" style="font-family: var(--font-display);">
                            {{ $project->title }}
                        </h1>
                        <p class="mt-3 max-w-3xl text-sm text-orange-100 md:text-base" style="font-family: var(--font-body);">
                            {{ $project->description }}
                        </p>
                    </div>
                </div>

                <div class="space-y-8 p-6 md:p-8">
                    <section aria-labelledby="stack-heading" class="space-y-3">
                        <h2 id="stack-heading" class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500" style="font-family: var(--font-body);">
                            Tech Stack
                        </h2>

                        <div class="flex flex-wrap gap-2" aria-label="Project tech stack">
                            @foreach ($project->stack as $tech)
                                <span class="rounded-full border border-orange-300/70 bg-orange-500/10 px-3 py-1 text-xs font-medium text-orange-800">
                                    {{ $tech }}
                                </span>
                            @endforeach
                        </div>
                    </section>

                    <section aria-labelledby="case-study-heading" class="space-y-4">
                        <h2 id="case-study-heading" class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500" style="font-family: var(--font-body);">
                            Case Study
                        </h2>

                        <div class="space-y-4 text-sm leading-relaxed text-slate-700 md:text-base" style="font-family: var(--font-body);">
                            @foreach (preg_split('/\r\n|\r|\n/', $project->details) as $paragraph)
                                @if (trim($paragraph) !== '')
                                    <p>{{ $paragraph }}</p>
                                @endif
                            @endforeach
                        </div>
                    </section>

                    <section class="flex flex-wrap items-center gap-3 border-t border-slate-200/80 pt-6 text-xs font-semibold uppercase tracking-[0.16em]">
                        @if (!empty($project->github_url))
                            <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer" class="rounded-full border border-slate-300 px-4 py-2 text-slate-700 transition hover:border-orange-300 hover:text-orange-700">
                                GitHub
                            </a>
                        @endif

                        @if (!empty($project->demo_url))
                            <a href="{{ $project->demo_url }}" target="_blank" rel="noopener noreferrer" class="rounded-full border border-orange-300 bg-orange-500/10 px-4 py-2 text-orange-700 transition hover:bg-orange-500 hover:text-white">
                                Live Demo
                            </a>
                        @endif
                    </section>
                </div>
            </article>
        </div>
    </main>
@endsection
