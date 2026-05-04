@extends('layouts.app')

@php
    use App\Models\SiteSetting;

    $blogLabel = (string) SiteSetting::get('footer_blog_label', 'Blog');
    $brandName = (string) SiteSetting::get('brand_name', SiteSetting::get('hero_name', config('seo.default_name', 'Portfolio')));
    $heroName = (string) SiteSetting::get('hero_name', $brandName);
    $heroTitle = (string) SiteSetting::get('hero_title', 'Laravel Developer');
    $aboutBio = (string) SiteSetting::get('about_bio', 'Building thoughtful Laravel products with a focus on clarity, performance, and maintainability.');
    $authorAvatar = (string) SiteSetting::get('about_profile_image', config('seo.default_image', '/storage/images/photo-1518770660439-4636190af475.jpg'));
    $authorAlt = (string) SiteSetting::get('about_profile_alt', 'Portrait of '.$heroName);
    $canonicalUrl = route('blog.show', $post->slug);
@endphp

@section('page_title', $post->title.' | '.$blogLabel.' | '.$brandName)
@section('meta_description', $post->excerpt.' Written by '.$heroName.', '.$heroTitle.'.')
@section('show_hero', false)
@section('og_image', $post->og_image)
@section('canonical_url', $canonicalUrl)
@section('schema')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post->title,
            'description' => $post->excerpt,
            'image' => $post->cover_image_url,
            'datePublished' => $post->published_at?->toAtomString(),
            'author' => [
                '@type' => 'Person',
                'name' => config('seo.default_name', config('app.name', 'Portfolio')),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('seo.default_name', config('app.name', 'Portfolio')),
                'url' => config('seo.default_url', config('app.url')),
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endsection

@php
    use App\Support\ImageAsset;

    $postCover = $post->cover_image_url;
    $postCoverWebp = ImageAsset::webpVariant($postCover);
@endphp

@php
    $shareTitle = $post->title;
    $authorName = $heroName;
    $authorJobTitle = $heroTitle;
    $authorBio = $aboutBio;
    $githubUrl = (string) SiteSetting::get('footer_github', config('seo.social.github'));
    $linkedinUrl = (string) SiteSetting::get('footer_linkedin', config('seo.social.linkedin'));
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
            class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white/85 shadow-premium backdrop-blur-sm dark:border-slate-700/60 dark:bg-slate-900/85"
        >
            <picture>
                @if (!empty($postCoverWebp))
                    <source srcset="{{ $postCoverWebp }}" type="image/webp">
                @endif
                <img
                    src="{{ $postCover }}"
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
                <a href="{{ route('blog.index') }}" class="portal-link-button">
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

                    <p class="text-base leading-relaxed text-slate-600 dark:text-slate-300" style="font-family: var(--font-body);">
                        {{ $post->excerpt }}
                    </p>
                </header>

                    <section class="prose prose-slate max-w-none prose-headings:font-semibold prose-headings:tracking-tight prose-headings:text-slate-900 prose-p:text-slate-700 prose-a:text-orange-600 prose-a:decoration-orange-300 prose-a:underline-offset-4 prose-a:transition hover:prose-a:text-orange-700 prose-blockquote:border-orange-300 prose-blockquote:text-slate-600 prose-code:rounded-md prose-code:bg-slate-100 prose-code:px-1.5 prose-code:py-0.5 prose-code:before:content-none prose-code:after:content-none prose-img:rounded-2xl prose-pre:rounded-2xl prose-pre:bg-slate-900 prose-pre:text-slate-100 dark:prose-invert dark:prose-headings:text-slate-100 dark:prose-p:text-slate-300 dark:prose-a:text-orange-300 dark:prose-a:decoration-orange-400 dark:hover:prose-a:text-orange-200 dark:prose-blockquote:text-slate-300 dark:prose-code:bg-slate-800 dark:prose-code:text-slate-100 dark:prose-pre:bg-slate-950 dark:prose-pre:text-slate-100" style="font-family: var(--font-body);">
                    {!! $post->rendered_body !!}
                </section>

                <section class="space-y-5 border-t border-slate-200 pt-8">
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 md:p-6 dark:border-slate-700/60 dark:bg-slate-950/50">
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-start">
                            <div class="shrink-0">
                                <img
                                    src="{{ $authorAvatar }}"
                                    alt="{{ $authorAlt }}"
                                    class="h-16 w-16 rounded-full border-2 border-orange-300 object-cover"
                                    width="64"
                                    height="64"
                                    loading="lazy"
                                    decoding="async"
                                >
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-orange-600 dark:text-orange-300">About the author</p>
                                <h2 class="mt-2 text-xl font-semibold tracking-tight text-slate-900 dark:text-slate-100" style="font-family: var(--font-display);">
                                    {{ $authorName }}
                                </h2>
                                <p class="mt-1 text-sm font-medium text-slate-600 dark:text-slate-300">{{ $authorJobTitle }}</p>
                                <p class="mt-3 text-sm leading-relaxed text-slate-700 dark:text-slate-300">
                                    {{ $authorBio }}
                                </p>

                                <div class="mt-4 flex flex-wrap items-center gap-3 text-xs font-semibold uppercase tracking-[0.16em]">
                                    @if (!empty($githubUrl))
                                        <a href="{{ $githubUrl }}" target="_blank" rel="noopener noreferrer" class="portal-link-button portal-link-button-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                                                <path d="M12 .5C5.7.5.6 5.7.6 12.1c0 5.1 3.3 9.4 7.8 10.9.6.1.8-.3.8-.6v-2c-3.2.7-3.9-1.4-3.9-1.4-.5-1.3-1.2-1.7-1.2-1.7-1-.7.1-.7.1-.7 1.1.1 1.7 1.1 1.7 1.1 1 .1 1.6-.7 1.9-1.1.1-.7.4-1.1.8-1.4-2.6-.3-5.3-1.3-5.3-5.8 0-1.3.5-2.4 1.2-3.3-.1-.3-.5-1.5.1-3.1 0 0 1-.3 3.3 1.2.9-.2 1.9-.3 2.9-.3s2 .1 2.9.3c2.3-1.5 3.3-1.2 3.3-1.2.6 1.6.2 2.8.1 3.1.8.9 1.2 2 1.2 3.3 0 4.5-2.7 5.5-5.3 5.8.4.4.8 1 .8 2.1v3.1c0 .3.2.7.8.6 4.5-1.5 7.8-5.8 7.8-10.9C23.4 5.7 18.3.5 12 .5Z"/>
                                            </svg>
                                            GitHub
                                        </a>
                                    @endif

                                    @if (!empty($linkedinUrl))
                                        <a href="{{ $linkedinUrl }}" target="_blank" rel="noopener noreferrer" class="portal-link-button portal-link-button-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                                                <path d="M20.45 20.45h-3.56v-5.57c0-1.33-.03-3.04-1.86-3.04-1.87 0-2.16 1.46-2.16 2.94v5.67H9.31V9h3.42v1.56h.05c.48-.9 1.66-1.86 3.42-1.86 3.66 0 4.34 2.41 4.34 5.54v6.21ZM5.33 7.43a2.07 2.07 0 1 1 0-4.14 2.07 2.07 0 0 1 0 4.14ZM7.11 20.45H3.55V9h3.56v11.45Z"/>
                                            </svg>
                                            LinkedIn
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        x-data="{
                            copied: false,
                            async copyLink() {
                                try {
                                    await navigator.clipboard.writeText(window.location.href);
                                    this.copied = true;
                                    window.setTimeout(() => { this.copied = false; }, 1500);
                                } catch (error) {
                                    this.copied = false;
                                }
                            },
                        }"
                        class="rounded-3xl border border-slate-200 bg-white p-5 md:p-6 dark:border-slate-700/60 dark:bg-slate-950/50"
                    >
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500 dark:text-slate-400">Share this article</p>

                        <div class="mt-4 flex flex-wrap gap-3 text-xs font-semibold uppercase tracking-[0.16em]">
                            <a
                                href="https://twitter.com/intent/tweet?url={{ urlencode($canonicalUrl) }}&text={{ urlencode($shareTitle) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="portal-link-button"
                            >
                                Share on X
                            </a>
                            <a
                                href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($canonicalUrl) }}&title={{ urlencode($shareTitle) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="portal-link-button"
                            >
                                Share on LinkedIn
                            </a>
                            <button
                                type="button"
                                @click="copyLink()"
                                class="portal-link-button portal-link-button-accent"
                                x-text="copied ? 'Copied!' : 'Copy Link'"
                            ></button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            @if ($previousPost)
                                <a
                                    href="{{ route('blog.show', $previousPost->slug) }}"
                                    class="portal-link-button flex h-full flex-col justify-center items-start text-left"
                                >
                                    <span class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500 dark:text-slate-400">← Previous</span>
                                    <span class="mt-1 line-clamp-2 text-sm font-semibold text-slate-800 dark:text-slate-100">{{ $previousPost->title }}</span>
                                </a>
                            @endif
                        </div>

                        <div class="sm:text-right">
                            @if ($nextPost)
                                <a
                                    href="{{ route('blog.show', $nextPost->slug) }}"
                                    class="portal-link-button flex h-full flex-col justify-center items-start text-left sm:items-end sm:text-right"
                                >
                                    <span class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500 dark:text-slate-400">Next →</span>
                                    <span class="mt-1 line-clamp-2 text-sm font-semibold text-slate-800 dark:text-slate-100">{{ $nextPost->title }}</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-start">
                        <a href="{{ route('blog.index') }}" class="portal-link-button">
                            Back to Blog
                        </a>
                    </div>
                </section>
            </div>
        </article>
    </main>
@endsection
