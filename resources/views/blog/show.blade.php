@extends('layouts.app')

@section('page_title', $post->title.' | Blog')
@section('meta_description', $post->excerpt)
@section('hero_name', 'Article')
@section('hero_title', $post->title)
@section('hero_cv_url', route('blog.index'))
@section('hero_background', $post->cover_image)

@php
    $postCoverWebp = preg_replace('/\.(jpe?g)(\?.*)?$/i', '.webp$2', $post->cover_image);
@endphp

@section('content')
    <main class="mx-auto w-full max-w-4xl px-6 pb-20 pt-10" aria-labelledby="post-title">
        <div class="fixed left-0 right-0 top-0 z-40 h-1 bg-slate-200/60" aria-hidden="true">
            <div x-data="blogReadingProgress()" x-init="init()" class="h-full w-full">
                <div class="h-full bg-gradient-to-r from-orange-400 via-orange-500 to-amber-500 transition-[width] duration-100" :style="`width: ${progress}%`"></div>
            </div>
        </div>

        <article
            x-data="slideInOnScroll()"
            x-init="observe($el)"
            :class="isVisible ? 'is-visible' : ''"
            class="about-reveal overflow-hidden rounded-3xl border border-slate-200/80 bg-white/85 shadow-premium backdrop-blur-sm"
        >
            <picture>
                <source srcset="{{ $postCoverWebp }}" type="image/webp">
                <img
                    src="{{ $post->cover_image }}"
                    alt="Cover image for {{ $post->title }}"
                    class="h-64 w-full object-cover md:h-80"
                    width="1600"
                    height="900"
                    loading="eager"
                    fetchpriority="high"
                    decoding="async"
                >
            </picture>

            <div class="space-y-8 p-6 md:p-10" id="article-content">
                <a href="{{ route('blog.index') }}" class="inline-flex items-center rounded-full border border-slate-300/80 bg-white/75 px-4 py-2 text-xs font-semibold uppercase tracking-[0.16em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700">
                    Back to Blog
                </a>

                <header class="space-y-4">
                    <div class="flex flex-wrap items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500" style="font-family: var(--font-body);">
                        <time datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->format('M d, Y') }}</time>
                        <span aria-hidden="true">•</span>
                        <span>{{ $post->reading_time_minutes }} min read</span>
                    </div>

                    <h1 id="post-title" class="text-3xl font-semibold tracking-tight text-slate-900 md:text-4xl" style="font-family: var(--font-display);">
                        {{ $post->title }}
                    </h1>

                    <p class="text-base leading-relaxed text-slate-600" style="font-family: var(--font-body);">
                        {{ $post->excerpt }}
                    </p>
                </header>

                <section class="space-y-5 text-sm leading-relaxed text-slate-700 md:text-base" style="font-family: var(--font-body);">
                    @foreach (preg_split('/\r\n|\r|\n/', $post->body) as $paragraph)
                        @if (trim($paragraph) !== '')
                            <p>{{ $paragraph }}</p>
                        @endif
                    @endforeach
                </section>
            </div>
        </article>
    </main>
@endsection
