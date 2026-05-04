@extends('layouts.app')

@php
    use App\Models\SiteSetting;

    $blogLabel = (string) SiteSetting::get('footer_blog_label', 'Blog');
    $brandName = (string) SiteSetting::get('brand_name', SiteSetting::get('hero_name', config('seo.default_name', 'Portfolio')));
    $heroName = (string) SiteSetting::get('hero_name', $brandName);
    $heroTitle = (string) SiteSetting::get('hero_title', 'Laravel Developer');
    $aboutBio = (string) SiteSetting::get('about_bio', 'I design and ship Laravel products focused on reliability, maintainability, and user trust.');
    $aboutProfileImage = (string) SiteSetting::get('about_profile_image', config('seo.default_image', '/storage/images/photo-1542831371-29b0f74f9713.jpg'));
    $aboutProfileAlt = (string) SiteSetting::get('about_profile_alt', 'Profile portrait of '.$heroName);
    $pageTitle = $blogLabel.' | '.$brandName;
    $metaDescription = 'Read '.$blogLabel.' from '.$heroName.', '.$heroTitle.', with practical notes on Laravel architecture, product decisions, and frontend delivery.';
@endphp

@section('page_title', $pageTitle)
@section('meta_description', $metaDescription)
@section('show_hero', false)

@section('content')
    <main class="mx-auto w-full max-w-7xl px-6 pb-20 pt-10" aria-labelledby="blog-title">
        <section class="space-y-8">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-[1.45fr_0.95fr] lg:items-end">
                <div class="space-y-4">
                    <p class="inline-flex rounded-full border border-orange-300/45 bg-orange-400/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.22em] text-orange-700">
                        {{ $blogLabel }}
                    </p>
                    <h1 id="blog-title" class="text-3xl font-semibold tracking-tight text-slate-900 dark:text-slate-100 md:text-4xl" style="font-family: var(--font-display);">
                        Insights shaped by {{ $heroName }}.
                    </h1>
                    <p class="max-w-3xl text-sm leading-relaxed text-slate-600 dark:text-slate-300 md:text-base" style="font-family: var(--font-body);">
                        {{ $aboutBio }}
                    </p>
                </div>

                <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white/80 shadow-premium backdrop-blur-sm dark:border-slate-700/60 dark:bg-slate-900/85">
                    <div class="flex flex-col gap-4 p-5 sm:flex-row sm:items-center">
                        <img
                            src="{{ $aboutProfileImage }}"
                            alt="{{ $aboutProfileAlt }}"
                            class="h-20 w-20 shrink-0 rounded-2xl object-cover"
                            width="80"
                            height="80"
                            loading="lazy"
                            decoding="async"
                        >

                        <div class="min-w-0">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-orange-600 dark:text-orange-300">Author profile</p>
                            <h2 class="mt-2 text-xl font-semibold tracking-tight text-slate-900 dark:text-slate-100" style="font-family: var(--font-display);">
                                {{ $heroName }}
                            </h2>
                            <p class="mt-1 text-sm font-medium text-slate-600 dark:text-slate-300">{{ $heroTitle }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div x-data="{ activeCategory: 'all' }" class="space-y-6">
                <div class="flex flex-wrap gap-3" aria-label="Filter blog posts by category">
                    <button
                        type="button"
                        @click="activeCategory = 'all'"
                        :class="activeCategory === 'all' ? 'is-active' : ''"
                        class="portal-chip"
                    >
                        All
                    </button>

                    @foreach ($categories as $category)
                        @php
                            $categorySlug = data_get($category, 'slug');
                            $categoryName = data_get($category, 'name');
                        @endphp
                        <button
                            type="button"
                            @click="activeCategory = '{{ $categorySlug }}'"
                            :class="activeCategory === '{{ $categorySlug }}' ? 'is-active' : ''"
                            class="portal-chip"
                        >
                            {{ $categoryName }}
                        </button>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @forelse ($posts as $post)
                        <article
                            x-data="{ postCategories: @js($post->categories->pluck('slug')->values()->all()) }"
                            x-show="activeCategory === 'all' || postCategories.includes(activeCategory)"
                            x-transition.opacity.duration.200ms
                            class="group overflow-hidden rounded-3xl border border-slate-200/80 bg-white/80 shadow-premium backdrop-blur-sm transition duration-300 hover:-translate-y-1 hover:border-orange-300/80 dark:border-slate-700/60 dark:bg-slate-900/85 dark:hover:border-orange-400/80"
                        >
                            <a href="{{ route('blog.show', $post->slug) }}" class="block">
                                <div class="relative overflow-hidden">
                                    <img
                                        src="{{ $post->cover_image_url }}"
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
                                    <div class="flex flex-wrap items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500" style="font-family: var(--font-body);">
                                        <time datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->format('M d, Y') }}</time>
                                        <span aria-hidden="true">•</span>
                                        <span>{{ $post->reading_time_minutes }} min read</span>
                                    </div>

                                    <h2 class="text-xl font-semibold tracking-tight text-slate-900 dark:text-slate-100" style="font-family: var(--font-display);">
                                        {{ $post->title }}
                                    </h2>

                                    <p class="text-sm leading-relaxed text-slate-600 dark:text-slate-300" style="font-family: var(--font-body);">
                                        {{ $post->excerpt }}
                                    </p>

                                    <span class="portal-link-button portal-link-button-accent">
                                        Read Article
                                    </span>
                                </div>
                            </a>
                        </article>
                    @empty
                        <p class="rounded-3xl border border-slate-200 bg-white/70 p-8 text-sm text-slate-600 dark:border-slate-700/60 dark:bg-slate-900/70 dark:text-slate-300" style="font-family: var(--font-body);">
                            No articles have been published yet.
                        </p>
                    @endforelse
                </div>
            </div>
        </section>
    </main>
@endsection
