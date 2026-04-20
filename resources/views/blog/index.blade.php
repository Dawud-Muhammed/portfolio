@extends('layouts.app')

@section('page_title', 'Blog | Insights and Build Notes')
@section('meta_description', 'Articles on Laravel architecture, product design, and Alpine.js interaction patterns.')
@section('hero_name', 'Dawud Muhammed')
@section('hero_title', 'Laravel Developer')
@section('hero_cv_url', '#')
@section('hero_background', \Illuminate\Support\Facades\Storage::url('images/photo-1484417894907-623942c8ee29.jpg'))

@section('content')
    <main class="mx-auto w-full max-w-7xl px-6 pb-20 pt-10" aria-labelledby="blog-title">
        <section
            x-data="slideInOnScroll()"
            x-init="observe($el)"
            :class="isVisible ? 'is-visible' : ''"
            class="about-reveal space-y-8"
        >
            <div class="space-y-3">
                <p class="inline-flex rounded-full border border-orange-300/45 bg-orange-400/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.22em] text-orange-700">
                    Blog
                </p>
                <h1 id="blog-title" class="text-3xl font-semibold tracking-tight text-slate-900 md:text-4xl" style="font-family: var(--font-display);">
                    Insights on building resilient Laravel products.
                </h1>
                <p class="max-w-3xl text-sm leading-relaxed text-slate-600 md:text-base" style="font-family: var(--font-body);">
                    Practical articles on architecture, product decisions, and frontend interaction patterns designed for maintainable delivery.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($posts as $post)
                    <article class="group overflow-hidden rounded-3xl border border-slate-200/80 bg-white/80 shadow-premium backdrop-blur-sm transition duration-300 hover:-translate-y-1 hover:border-orange-300/80">
                        <a href="{{ route('blog.show', $post->slug) }}" class="block">
                            <div class="relative overflow-hidden">
                                <img
                                    src="{{ $post->cover_image }}"
                                    alt="Cover image for {{ $post->title }}"
                                    class="h-52 w-full object-cover transition duration-500 group-hover:scale-[1.04]"
                                    width="1600"
                                    height="900"
                                    loading="lazy"
                                    decoding="async"
                                >
                                <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-900/50 via-transparent to-transparent opacity-70"></div>
                            </div>

                            <div class="space-y-4 p-6">
                                <div class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500" style="font-family: var(--font-body);">
                                    <time datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->format('M d, Y') }}</time>
                                    <span aria-hidden="true">•</span>
                                    <span>{{ $post->reading_time_minutes }} min read</span>
                                </div>

                                <h2 class="text-xl font-semibold tracking-tight text-slate-900" style="font-family: var(--font-display);">
                                    {{ $post->title }}
                                </h2>

                                <p class="text-sm leading-relaxed text-slate-600" style="font-family: var(--font-body);">
                                    {{ $post->excerpt }}
                                </p>

                                <span class="inline-flex rounded-full border border-orange-300 bg-orange-500/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.16em] text-orange-700 transition group-hover:bg-orange-500 group-hover:text-white">
                                    Read Article
                                </span>
                            </div>
                        </a>
                    </article>
                @empty
                    <p class="rounded-3xl border border-slate-200 bg-white/70 p-8 text-sm text-slate-600" style="font-family: var(--font-body);">
                        No articles have been published yet.
                    </p>
                @endforelse
            </div>
        </section>
    </main>
@endsection
