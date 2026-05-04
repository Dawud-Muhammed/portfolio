@extends('layouts.app')

@section('page_title', $project->title.' | Project Case Study')
@section('meta_description', $project->description)
@section('hero_name', 'Selected Work')
@section('hero_title', $project->title)
@section('hero_description', $project->description)
@section('hero_availability_text', filled($project->stack) ? implode(' · ', array_slice($project->stack, 0, 3)) : 'Project case study')
@section('hero_cv_url', filled($project->demo_url) ? $project->demo_url : (filled($project->github_url) ? $project->github_url : route('home').'#projects'))
@section('hero_cta_label', filled($project->demo_url) ? 'Open Live Demo' : (filled($project->github_url) ? 'View GitHub' : 'Back to Projects'))
@section('hero_primary_cta_url', route('home').'#projects')
@section('hero_primary_cta_label', 'Back to Projects')
@section('hero_background', $project->image_url)
@section('hero_background_alt', 'Case study preview image for '.$project->title)
@section('og_image', $project->og_image)
@section('schema')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'CreativeWork',
            'name' => $project->title,
            'description' => $project->description,
            'image' => $project->image_url,
            'url' => route('projects.show', $project->slug),
            'programmingLanguage' => array_values(array_filter($project->stack ?? [])),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endsection

@php
    use App\Support\ImageAsset;

    $projectImage = $project->image_url;
    $projectHeroWebp = ImageAsset::webpVariant($projectImage);
@endphp

@section('content')
    <main class="mx-auto w-full max-w-6xl px-6 pb-20 pt-10" aria-labelledby="project-title">
        <div
            x-data="slideInOnScroll()"
            x-init="observe($el)"
            :class="isVisible ? 'is-visible' : ''"
            class="space-y-8"
        >
            <article class="overflow-hidden rounded-[2rem] border border-slate-200/80 bg-white/88 shadow-[0_24px_60px_-32px_rgba(15,23,42,0.55)] backdrop-blur-sm dark:border-slate-700/60 dark:bg-slate-900/88 dark:shadow-[0_24px_60px_-32px_rgba(2,6,23,0.75)]">
                <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1.4fr)_minmax(280px,0.6fr)]">
                    <div class="relative">
                        <picture>
                            @if (!empty($projectHeroWebp))
                                <source srcset="{{ $projectHeroWebp }}" type="image/webp">
                            @endif
                            <img
                                src="{{ $projectImage }}"
                                alt="Preview image for {{ $project->title }}"
                                class="h-72 w-full object-cover sm:h-[28rem]"
                                width="1600"
                                height="1000"
                                loading="eager"
                                fetchpriority="high"
                                decoding="async"
                            >
                        </picture>

                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/75 via-slate-950/10 to-transparent"></div>

                        <div class="absolute inset-x-0 bottom-0 space-y-4 p-6 sm:p-8">
                            <div class="flex flex-wrap gap-2 text-[11px] font-semibold uppercase tracking-[0.18em]">
                                @if ($project->is_featured)
                                    <span class="rounded-full border border-orange-300/60 bg-orange-500/90 px-3 py-1 text-white shadow-lg">Featured</span>
                                @endif

                                @if ($project->published_at)
                                    <span class="rounded-full border border-white/15 bg-white/10 px-3 py-1 text-slate-100 backdrop-blur">
                                        {{ $project->published_at->format('M Y') }}
                                    </span>
                                @endif
                            </div>

                            <div class="max-w-3xl space-y-3 text-white">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-orange-200">Project Case Study</p>
                                <h1 id="project-title" class="text-3xl font-semibold tracking-tight sm:text-4xl lg:text-5xl" style="font-family: var(--font-display);">
                                    {{ $project->title }}
                                </h1>
                                <p class="max-w-2xl text-base leading-relaxed text-slate-200 sm:text-lg">
                                    {{ $project->description }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <aside class="space-y-5 border-t border-slate-200/80 bg-slate-50/80 p-6 dark:border-slate-700/60 dark:bg-slate-950/40 lg:border-l lg:border-t-0 lg:p-8">
                        <section class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm dark:border-slate-700/60 dark:bg-slate-900/80">
                            <h2 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Tech Stack</h2>
                            <div class="mt-4 flex flex-wrap gap-2" aria-label="Project tech stack">
                                @forelse ((array) ($project->stack ?? []) as $tech)
                                    <span class="rounded-full border border-orange-300/70 bg-orange-500/10 px-3 py-1 text-xs font-medium text-orange-800 dark:border-orange-400/40 dark:bg-orange-500/15 dark:text-orange-200">
                                        {{ $tech }}
                                    </span>
                                @empty
                                    <p class="text-sm text-slate-600 dark:text-slate-300">No stack details were provided.</p>
                                @endforelse
                            </div>
                        </section>

                        <section class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm dark:border-slate-700/60 dark:bg-slate-900/80">
                            <h2 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Project Links</h2>
                            <div class="mt-4 flex flex-wrap gap-3 text-xs font-semibold uppercase tracking-[0.16em]">
                                @if (!empty($project->github_url))
                                    <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer" class="portal-link-button">
                                        GitHub
                                    </a>
                                @endif

                                @if (!empty($project->demo_url))
                                    <a href="{{ $project->demo_url }}" target="_blank" rel="noopener noreferrer" class="portal-link-button portal-link-button-accent">
                                        Live Demo
                                    </a>
                                @endif

                                <a href="{{ route('home').'#projects' }}" class="portal-link-button portal-link-button-secondary">
                                    Back to Projects
                                </a>
                            </div>
                        </section>
                    </aside>
                </div>

                <div class="grid grid-cols-1 gap-8 p-6 md:p-8 lg:grid-cols-[minmax(0,1.25fr)_minmax(280px,0.75fr)]">
                    <section aria-labelledby="case-study-heading" class="space-y-4">
                        <h2 id="case-study-heading" class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400" style="font-family: var(--font-body);">
                            Case Study
                        </h2>

                        <div class="space-y-4 text-sm leading-relaxed text-slate-700 dark:text-slate-300 md:text-base" style="font-family: var(--font-body);">
                            @foreach (preg_split('/\r\n|\r|\n/', $project->details) as $paragraph)
                                @if (trim($paragraph) !== '')
                                    <p>{{ $paragraph }}</p>
                                @endif
                            @endforeach
                        </div>
                    </section>

                    <section class="space-y-4 rounded-2xl border border-slate-200/80 bg-slate-50/90 p-5 dark:border-slate-700/60 dark:bg-slate-950/50">
                        <h2 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Quick Summary</h2>
                        <div class="space-y-3 text-sm text-slate-700 dark:text-slate-300">
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-slate-500 dark:text-slate-400">Focus</span>
                                <span class="text-right font-medium">{{ $project->is_featured ? 'Featured portfolio highlight' : 'Portfolio project' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-slate-500 dark:text-slate-400">Timeline</span>
                                <span class="text-right font-medium">
                                    {{ $project->published_at?->format('M Y') ?? 'In progress' }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-slate-500 dark:text-slate-400">Stack size</span>
                                <span class="text-right font-medium">{{ count((array) ($project->stack ?? [])) }} tools</span>
                            </div>
                        </div>
                    </section>
                </div>
            </article>
        </div>
    </main>
@endsection
