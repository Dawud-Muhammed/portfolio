<?php

namespace Database\Seeders;

use App\Enums\SkillCategory;
use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SkillSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Skill::query()
            ->where(function ($query): void {
                $query->whereNull('skill_id')->orWhere('skill_id', '');
            })
            ->orderBy('id')
            ->get()
            ->each(function (Skill $skill): void {
                $base = Str::slug($skill->name);

                if ($base === '') {
                    return;
                }

                $candidate = $base;
                $suffix = 2;

                while (Skill::query()
                    ->where('skill_id', $candidate)
                    ->whereKeyNot($skill->getKey())
                    ->exists()) {
                    $candidate = $base.'-'.$suffix;
                    $suffix++;
                }

                $skill->update(['skill_id' => $candidate]);
            });

        $skills = [
            [
                'skill_id' => 'laravel-13',
                'name' => 'Laravel 13',
                'level' => 95,
                'years' => 5,
                'description' => 'Architecting robust APIs, queues, policies, and modular service layers for production applications.',
                'category' => SkillCategory::Backend->value,
                'is_published' => true,
                'published_at' => now()->subDays(30),
            ],
            [
                'skill_id' => 'php-84',
                'name' => 'PHP',
                'level' => 92,
                'years' => 6,
                'description' => 'Writing maintainable, testable business logic with strong domain modeling and performance-aware patterns.',
                'category' => SkillCategory::Backend->value,
                'is_published' => true,
                'published_at' => now()->subDays(30),
            ],
            [
                'skill_id' => 'blade-alpine',
                'name' => 'Blade + Alpine.js',
                'level' => 88,
                'years' => 4,
                'description' => 'Building responsive, high-fidelity interfaces with lean interactivity and smooth progressive enhancement.',
                'category' => SkillCategory::Frontend->value,
                'is_published' => true,
                'published_at' => now()->subDays(30),
            ],
            [
                'skill_id' => 'mysql',
                'name' => 'MySQL',
                'level' => 85,
                'years' => 5,
                'description' => 'Designing indexes, schema migrations, and efficient query strategies for data-heavy workloads.',
                'category' => SkillCategory::Data->value,
                'is_published' => true,
                'published_at' => now()->subDays(30),
            ],
            [
                'skill_id' => 'redis-queue',
                'name' => 'Redis + Queues',
                'level' => 84,
                'years' => 4,
                'description' => 'Implementing asynchronous pipelines, background processing, and resilient retry policies.',
                'category' => SkillCategory::Tooling->value,
                'is_published' => true,
                'published_at' => now()->subDays(30),
            ],
            [
                'skill_id' => 'vite-tailwind',
                'name' => 'Vite + Tailwind',
                'level' => 90,
                'years' => 4,
                'description' => 'Shipping polished frontends with rapid iteration, optimized bundles, and cohesive design systems.',
                'category' => SkillCategory::Frontend->value,
                'is_published' => true,
                'published_at' => now()->subDays(30),
            ],
        ];

        foreach ($skills as $skill) {
            $skill['skill_id'] = $skill['skill_id'] ?? Str::slug($skill['name']);

            Skill::query()->updateOrCreate(
                ['skill_id' => $skill['skill_id']],
                $skill
            );
        }
    }
}
