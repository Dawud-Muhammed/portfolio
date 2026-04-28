@props(['projects' => [], 'categories' => [], 'kicker' => 'Featured Work', 'heading' => 'Crafted products with performance and polish.'])

@php
    use App\Support\ImageAsset;

    $projectWebp = fn (string $image): ?string => ImageAsset::webpVariant($image);
@endphp

<section
    id="projects"
    class="mx-auto w-full max-w-7xl px-6 py-20"
    x-data="projectsShowcase(@js($categories))"
    x-init="observe($el)"
    aria-labelledby="projects-heading"
>
    <div class="mb-10 flex flex-col items-center justify-between gap-6 text-center lg:flex-row lg:text-left">
        <div class="max-w-2xl">
            <p class="mb-3 inline-flex rounded-full border border-orange-300/45 bg-orange-400/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.22em] text-orange-700">
                {{ $kicker }}
            </p>
            <h2 id="projects-heading" class="text-3xl font-semibold tracking-tight text-slate-1000 md:text-4xl" style="font-family: var(--font-display);">
                {{ $heading }}
            </h2>
        </div>

        <div class="flex flex-wrap items-center justify-center gap-2 lg:justify-end" role="tablist" aria-label="Project filters">
            <button
                type="button"
                @click="activeCategory = 'all'"
                :class="activeCategory === 'all' ? 'is-active' : ''"
                class="portal-chip"
            >
                All
            </button>

            <template x-for="category in categories" :key="category.slug">
                <button
                    type="button"
                    @click="activeCategory = category.slug"
                    x-text="category.name"
                    class="portal-chip"
                    :class="activeCategory === category.slug ? 'is-active' : ''"
                    :aria-selected="activeCategory === category.slug"
                ></button>
            </template>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($projects as $index => $project)
            <article
                class="project-card group overflow-hidden rounded-3xl border border-slate-200/80 bg-white/80 shadow-[0_16px_45px_-28px_rgba(15,23,42,0.45)] backdrop-blur-sm"
                x-data="{ projectCategories: @js($project['categories'] ?? []) }"
                x-show="activeCategory === 'all' || projectCategories.includes(activeCategory)"
                x-transition.opacity.duration.350ms
                :class="isVisible ? 'project-card-visible' : ''"
                style="transition-delay: {{ 80 + ($index * 90) }}ms;"
            >
                <div class="relative overflow-hidden">
                    @php
                        $projectImage = (string) ($project['image'] ?? ImageAsset::default());
                        $projectImageWebp = $projectWebp($projectImage);
                    @endphp
                    <picture>
                        @if (!empty($projectImageWebp))
                            <source srcset="{{ $projectImageWebp }}" type="image/webp">
                        @endif
                        <img
                            src="{{ $projectImage }}"
                            alt="Preview image for {{ $project['title'] }}"
                            class="h-52 w-full object-cover transition duration-500 group-hover:scale-[1.04]"
                            width="1200"
                            height="800"
                            loading="lazy"
                            decoding="async"
                        >
                    </picture>
                    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-900/50 via-transparent to-transparent opacity-60"></div>
                </div>

                <div class="space-y-4 p-6">
                    <div class="space-y-2">
                        <h3 class="text-lg font-semibold tracking-tight text-slate-900" style="font-family: var(--font-display);">
                            {{ $project['title'] }}
                        </h3>
                        <p class="text-sm leading-relaxed text-slate-600" style="font-family: var(--font-body);">
                            {{ $project['description'] }}
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2" aria-label="Tech stack badges">
                        @foreach ($project['stack'] as $tech)
                            <span class="rounded-full border border-emerald-300/70 bg-emerald-500/10 px-3 py-1 text-xs font-medium text-emerald-800">
                                {{ $tech }}
                            </span>
                        @endforeach
                    </div>

                    <div class="project-reveal max-h-0 overflow-hidden text-sm text-slate-600 transition-all duration-300 group-hover:max-h-24">
                        <p class="pt-1">{{ $project['details'] }}</p>
                    </div>

                    @if (!empty($project['slug']))
                        <a
                            href="{{ route('projects.show', $project['slug']) }}"
                            class="portal-link-button portal-link-button-accent"
                        >
                            View Case Study
                        </a>
                    @endif

                    <div class="flex items-center gap-3 pt-1 text-xs font-semibold uppercase tracking-[0.16em]">
                        <a href="{{ $project['github'] }}" target="_blank" rel="noopener noreferrer" class="portal-link-button">
                            GitHub
                        </a>
                        <a href="{{ $project['demo'] }}" target="_blank" rel="noopener noreferrer" class="portal-link-button portal-link-button-accent">
                            Live Demo
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <p class="col-span-full rounded-3xl border border-slate-200 bg-white/70 p-8 text-sm text-slate-600" style="font-family: var(--font-body);">
                No projects are available yet.
            </p>
        @endforelse
    </div>
</section>
