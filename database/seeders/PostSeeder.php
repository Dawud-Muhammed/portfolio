<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PostSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Designing Laravel Architectures That Scale Gracefully',
                'slug' => 'designing-laravel-architectures-that-scale-gracefully',
                'excerpt' => 'A practical breakdown of service boundaries, queue strategy, and data modeling decisions that keep Laravel products stable as usage grows.',
                'body' => <<<'TEXT'
Building scalable Laravel applications starts with reducing hidden complexity before it compounds.

In this article, I walk through a structure that keeps domain logic separated from controllers and request classes. The goal is to avoid feature growth turning into unmaintainable coupling. Clean boundaries make it easier to test behavior, reason about side effects, and safely evolve features over time.

I also cover queue design: when to defer work, how to shape jobs for idempotency, and where to draw transaction boundaries. Correctly using async workflows can improve responsiveness, but only when failure modes are considered upfront.

Finally, we look at schema decisions that support future reporting and product iteration. Naming consistency and explicit status models often outperform clever shortcuts.

If you can predict where complexity will land, you can build systems that scale without sacrificing clarity.
TEXT,
                'cover_image' => Storage::url('images/photo-1555066931-4365d14bab8c.jpg'),
                'published_at' => now()->subDays(14),
                'reading_time_minutes' => 7,
            ],
            [
                'title' => 'From Concept to Case Study: Building Premium Portfolio Pages',
                'slug' => 'from-concept-to-case-study-building-premium-portfolio-pages',
                'excerpt' => 'How to structure project storytelling, visual hierarchy, and content blocks so portfolio pages feel strategic, not just decorative.',
                'body' => <<<'TEXT'
A strong portfolio page should communicate outcomes, not only aesthetics.

The most effective case studies begin with context: who the product serves, what the constraint was, and why the solution mattered. Once the problem is clear, visual design becomes a support system for comprehension.

I use a modular narrative pattern: overview, constraints, implementation details, and measurable impact. This keeps readers engaged while making technical depth accessible to non-technical stakeholders.

Typography and spacing also do real work. When headings, body rhythm, and call-to-action hierarchy are intentional, scanning becomes effortless.

A premium page is not about adding more sections. It is about reducing friction between story and trust.
TEXT,
                'cover_image' => Storage::url('images/photo-1467232004584-a241de8bcf5d.jpg'),
                'published_at' => now()->subDays(9),
                'reading_time_minutes' => 5,
            ],
            [
                'title' => 'Alpine.js Patterns for Fast, Focused User Interactions',
                'slug' => 'alpine-js-patterns-for-fast-focused-user-interactions',
                'excerpt' => 'Simple Alpine.js patterns for reveal animations, progressive enhancement, and interaction logic that stays clean in Blade-first apps.',
                'body' => <<<'TEXT'
Alpine.js is most powerful when used as intentional interaction glue, not as a mini framework substitute.

In Blade-heavy Laravel projects, Alpine can handle micro-interactions elegantly: reveal-on-scroll sections, local UI state, filtered lists, and contextual feedback. The key is to keep each component narrowly scoped and predictable.

I recommend defining small factories in app.js with one responsibility each. This helps you reuse behavior across pages while avoiding giant global components that become hard to debug.

For scroll effects, IntersectionObserver gives better performance than constantly polling scroll position. Combine observer triggers with transition classes to keep motion smooth and maintainable.

The result is a frontend that feels dynamic while preserving server-rendered simplicity.
TEXT,
                'cover_image' => Storage::url('images/photo-1517180102446-f3ece451e9d8.jpg'),
                'published_at' => now()->subDays(4),
                'reading_time_minutes' => 6,
            ],
        ];

        foreach ($posts as $post) {
            Post::query()->updateOrCreate(
                ['slug' => $post['slug']],
                $post
            );
        }
    }
}
