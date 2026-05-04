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
            class="about-reveal space-y-8"
        >
            <article class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white/85 shadow-[0_24px_60px_-32px_rgba(15,23,42,0.55)] backdrop-blur-sm dark:border-slate-700/60 dark:bg-slate-900/85 dark:shadow-[0_24px_60px_-32px_rgba(2,6,23,0.75)]">
                <div class="space-y-8 p-6 md:p-8">
                    <section aria-labelledby="stack-heading" class="space-y-3">
                        <h2 id="stack-heading" class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400" style="font-family: var(--font-body);">
                            Tech Stack
                        </h2>

                        <div class="flex flex-wrap gap-2" aria-label="Project tech stack">
                            @foreach ($project->stack as $tech)
                                <span class="rounded-full border border-orange-300/70 bg-orange-500/10 px-3 py-1 text-xs font-medium text-orange-800 dark:border-orange-400/40 dark:bg-orange-500/15 dark:text-orange-200">
                                    {{ $tech }}
                                </span>
                            @endforeach
                        </div>
                    </section>

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

                    <section class="flex flex-wrap items-center gap-3 border-t border-slate-200/80 pt-6 text-xs font-semibold uppercase tracking-[0.16em] dark:border-slate-700/60">
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
                    </section>
                </div>
            </article>
        </div>
    </main>
@endsection
