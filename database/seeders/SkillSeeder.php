<?php

namespace Database\Seeders;

use App\Enums\SkillCategory;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
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
            Skill::query()->updateOrCreate(
                ['skill_id' => $skill['skill_id']],
                $skill
            );
        }
    }
}
