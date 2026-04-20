@php
    use App\Enums\SkillCategory;

    $skills = collect($skills ?? []);

    $categories = collect(SkillCategory::cases())
        ->map(fn (SkillCategory $category) => [
            'value' => $category->value,
            'label' => $category->shortLabel(),
            'longLabel' => $category->label(),
        ])
        ->values();

    $skillPayload = $skills
        ->map(fn (array $skill) => [
            'id' => $skill['id'],
            'name' => $skill['name'],
            'level' => $skill['level'],
            'years' => $skill['years'],
            'description' => $skill['description'],
            'category' => $skill['category'] instanceof SkillCategory ? $skill['category']->value : (string) $skill['category'],
            'categoryLabel' => ($skill['category'] instanceof SkillCategory
                ? $skill['category']
                : SkillCategory::tryFrom((string) $skill['category']))?->label() ?? SkillCategory::Backend->label(),
        ])
        ->values();

    $maxExperience = (int) ($skills->max('years') ?? 0);
    $averageProficiency = (int) round((float) ($skills->avg('level') ?? 0));
@endphp

<section
    id="skills"
    class="skills-shell mx-auto w-full max-w-7xl px-6 py-20"
    x-data="skillsShowcase(@js($skillPayload), @js($categories), @js($maxExperience), @js($averageProficiency))"
    x-init="observe($el)"
    aria-labelledby="skills-heading"
>
    <div class="mb-10 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
        <div class="max-w-2xl text-center lg:text-left">
            <p class="skills-kicker mb-3 inline-flex rounded-full border px-4 py-1 text-xs font-semibold uppercase tracking-[0.2em]">
                Core Skills
            </p>
            <h2 id="skills-heading" class="text-3xl font-semibold tracking-tight text-slate-100 md:text-4xl" style="font-family: var(--font-display);">
                Precision engineering with a product-first mindset.
            </h2>
            <p class="mt-4 text-sm leading-relaxed text-slate-300 md:text-base" style="font-family: var(--font-body);">
                Skill levels and counters animate on scroll, with category grouping powered by Laravel enums.
            </p>
        </div>

        <div class="grid grid-cols-2 gap-3 text-center lg:min-w-[320px]">
            <div class="skills-stat rounded-2xl border p-4">
                <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Skill Areas</p>
                <p class="mt-2 text-2xl font-semibold text-slate-100"><span x-text="stats.categories"></span></p>
            </div>
            <div class="skills-stat rounded-2xl border p-4">
                <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Avg Proficiency</p>
                <p class="mt-2 text-2xl font-semibold text-slate-100"><span x-text="stats.avgProficiency"></span>%</p>
            </div>
        </div>
    </div>

    <div class="mb-8 flex flex-wrap justify-center gap-2 lg:justify-start" role="tablist" aria-label="Skill category filters">
        <button
            type="button"
            @click="activeCategory = 'all'"
            class="skills-filter rounded-full border px-4 py-2 text-xs font-semibold uppercase tracking-[0.16em]"
            :class="activeCategory === 'all' ? 'is-active' : ''"
            :aria-selected="activeCategory === 'all'"
        >
            All
        </button>

        <template x-for="category in categories" :key="category.value">
            <button
                type="button"
                @click="activeCategory = category.value"
                class="skills-filter rounded-full border px-4 py-2 text-xs font-semibold uppercase tracking-[0.16em]"
                :class="activeCategory === category.value ? 'is-active' : ''"
                :aria-label="`Show ${category.longLabel} skills`"
                :aria-selected="activeCategory === category.value"
                x-text="category.label"
            ></button>
        </template>
    </div>

    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
        <template x-for="(skill, index) in filteredSkills()" :key="skill.id">
            <article
                class="skills-card rounded-3xl border p-6"
                x-show="true"
                x-transition.opacity.duration.350ms
                :style="isVisible ? `transition-delay: ${100 + (index * 75)}ms` : ''"
                :class="isVisible ? 'skills-card-visible' : ''"
            >
                <div class="mb-4 flex items-center justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-100" style="font-family: var(--font-display);" x-text="skill.name"></h3>
                        <p class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-400" x-text="skill.categoryLabel"></p>
                    </div>
                    <div class="rounded-full border border-orange-300/40 bg-orange-400/10 px-3 py-1 text-xs font-semibold text-orange-200">
                        <span x-text="displayYears[skill.id] ?? 0"></span>y
                    </div>
                </div>

                <p class="mb-4 text-sm leading-relaxed text-slate-300" style="font-family: var(--font-body);" x-text="skill.description"></p>

                <div>
                    <div class="mb-2 flex items-center justify-between text-xs uppercase tracking-[0.16em] text-slate-400">
                        <span>Proficiency</span>
                        <span><span x-text="displayLevels[skill.id] ?? 0"></span>%</span>
                    </div>
                    <svg viewBox="0 0 100 10" class="h-3 w-full" role="img" :aria-label="`${skill.name} proficiency`">
                        <rect x="0" y="0" width="100" height="10" rx="5" fill="var(--skills-track)" />
                        <rect x="0" y="0" :width="displayLevels[skill.id] ?? 0" height="10" rx="5" :fill="`url(#skillsProgressGradient-${skill.id})`" />
                        <defs>
                            <linearGradient :id="`skillsProgressGradient-${skill.id}`" x1="0" y1="0" x2="100" y2="0" gradientUnits="userSpaceOnUse">
                                <stop offset="0%" stop-color="var(--skills-accent-start)" />
                                <stop offset="100%" stop-color="var(--skills-accent-end)" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
            </article>
        </template>
    </div>
</section>
