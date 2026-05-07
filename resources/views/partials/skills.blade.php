@php
    use App\Enums\SkillCategory;
    use App\Models\Skill;

    $skills = collect($skills ?? []);

    if ($skills->isEmpty()) {
        $skills = Skill::query()
            ->published()
            ->orderByRaw("CASE WHEN proficiency = 'proficient' THEN 3 WHEN proficiency = 'intermediate' THEN 2 ELSE 1 END DESC")
            ->orderByDesc('years')
            ->get();
    }

    $categories = collect(SkillCategory::cases())
        ->map(fn (SkillCategory $category) => [
            'value' => $category->value,
            'label' => $category->shortLabel(),
            'longLabel' => $category->label(),
        ])
        ->values();

    $skillPayload = $skills
        ->map(function (mixed $skill): array {
            $id = data_get($skill, 'id');
            $name = (string) data_get($skill, 'name', '');
            $rawProficiency = data_get($skill, 'proficiency', null);
            $numericLevel = data_get($skill, 'level', null);
            $years = (int) data_get($skill, 'years', 0);
            $description = (string) data_get($skill, 'description', '');
            $rawCategory = data_get($skill, 'category');
            $category = $rawCategory instanceof SkillCategory ? $rawCategory : SkillCategory::tryFrom((string) $rawCategory);

            // Backwards-compatibility: if numeric level exists, map to qualitative
            if ($rawProficiency === null && is_numeric($numericLevel)) {
                $levelInt = (int) $numericLevel;
                if ($levelInt <= 40) {
                    $proficiency = 'beginner';
                } elseif ($levelInt <= 70) {
                    $proficiency = 'intermediate';
                } else {
                    $proficiency = 'proficient';
                }
            } else {
                if ($rawProficiency instanceof \App\Enums\SkillProficiency) {
                    $proficiency = $rawProficiency->value;
                } else {
                    $proficiency = (string) ($rawProficiency ?? 'beginner');
                }
            }

            $proficiencyLabel = match ($proficiency) {
                'proficient' => 'Proficient',
                'intermediate' => 'Intermediate',
                default => 'Beginner',
            };

            return [
                'id' => $id,
                'name' => $name,
                'proficiency' => $proficiency,
                'proficiencyLabel' => $proficiencyLabel,
                'years' => $years,
                'description' => $description,
                'category' => $category?->value ?? SkillCategory::Backend->value,
                'categoryLabel' => $category?->label() ?? SkillCategory::Backend->label(),
            ];
        })
        ->filter(fn (array $skill): bool => $skill['id'] !== null && $skill['name'] !== '')
        ->values();

    $maxExperience = (int) ($skills->max('years') ?? 0);

    // Compute an average proficiency label for display (backwards-compatible)
    $averageNumeric = (int) round((float) ($skills->map(function ($s) {
        if (($p = data_get($s, 'proficiency')) !== null) {
            return match ($p) {
                'proficient' => 85,
                'intermediate' => 55,
                default => 30,
            };
        }

        return (int) data_get($s, 'level', 0);
    })->avg() ?? 0));

    $averageProficiency = $averageNumeric <= 40 ? 'Beginner' : ($averageNumeric <= 70 ? 'Intermediate' : 'Proficient');
    $kicker = (string) ($kicker ?? 'Core Skills');
    $heading = (string) ($heading ?? 'Precision engineering with a product-first mindset.');
    $subheading = (string) ($subheading ?? 'Skill levels and counters animate on scroll, with category grouping powered by Laravel enums.');
@endphp

<section
    id="skills"
    class="skills-shell mx-auto w-full max-w-7xl px-6 py-20"
    x-data="skillsShowcase(@js($skillPayload), @js($categories), @js($maxExperience))"
    x-init="observe($el)"
    aria-labelledby="skills-heading"
>
    <div class="mb-10 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
        <div class="max-w-2xl text-center lg:text-left">
            <p class="skills-kicker mb-3 inline-flex rounded-full border  border-orange-300/45 bg-orange-400/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-orange-700">
                {{ $kicker }}
            </p>
            <h2 id="skills-heading" class="text-3xl font-semibold tracking-tight text-slate-100 md:text-4xl" style="font-family: var(--font-display);">
                {{ $heading }}
            </h2>
            <p class="mt-4 text-sm leading-relaxed text-slate-300 md:text-base" style="font-family: var(--font-body);">
                {{ $subheading }}
            </p>
        </div>

        <div class="grid text-center lg:min-w-[320px]">
            <div class="skills-stat rounded-2xl border p-8">
                <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Skill Areas</p>
                <p class="mt-2 text-2xl font-semibold text-slate-100"><span x-text="stats.categories"></span></p>
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

                </div>
                <p class="text-sm text-slate-300 break-all" x-text="skill.description"></p>
            </article>
        </template>
    </div>
</section>
