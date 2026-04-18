<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Car Rental Platform',
                'slug' => 'car-rental-platform',
                'description' => 'A booking-focused car rental system with role-aware dashboards, reservation workflows, and fleet availability management.',
                'details' => <<<'TEXT'
Car Rental Platform is a production-style Laravel system built for speed, reliability, and conversion.

The case study focused on reducing booking friction from browse to confirmation. I designed the flow with role-based dashboards for customers, operators, and admins so each user type sees only mission-critical actions.

Core modules include availability logic, reservation lifecycle tracking, dynamic pricing tiers, and payment-state aware order management. On the backend, queue-backed notifications and activity logs improved operational transparency. On the frontend, Alpine interactions were used to keep forms responsive without overloading the interface.

The result is a polished rental product that balances performance, clarity, and operational control.
TEXT,
                'stack' => ['Laravel', 'PHP', 'MySQL', 'Tailwind'],
                'image' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=1600&q=80',
                'github_url' => 'https://github.com/your-username/car-rental-platform',
                'demo_url' => 'https://example.com/car-rental-demo',
                'is_featured' => true,
                'published_at' => now()->subDays(30),
            ],
            [
                'title' => 'Support Desk App',
                'slug' => 'support-desk-app',
                'description' => 'A streamlined customer support app with ticket pipelines, status automation, and internal team collaboration.',
                'details' => <<<'TEXT'
Support Desk App was designed to help distributed teams resolve tickets faster with better ownership.

I mapped support workflows into structured stages and created automation for status transitions, SLA labels, and assignee notifications. Threaded updates and internal notes keep context in one place, while role permissions secure sensitive conversations.

The API layer was structured to support reporting dashboards and future integrations. Alpine-powered interactions reduce context switching for agents by keeping key ticket actions inline.

This project demonstrates practical product thinking: less friction for agents, clearer communication for customers, and measurable throughput for teams.
TEXT,
                'stack' => ['Laravel', 'PHP', 'Alpine.js', 'REST API'],
                'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1600&q=80',
                'github_url' => 'https://github.com/your-username/support-desk-app',
                'demo_url' => 'https://example.com/support-desk-demo',
                'is_featured' => true,
                'published_at' => now()->subDays(25),
            ],
            [
                'title' => 'Property Listing Suite',
                'slug' => 'property-listing-suite',
                'description' => 'A modern real-estate listing experience with media galleries, search filters, and agent inquiry management.',
                'details' => <<<'TEXT'
Property Listing Suite is a Laravel-based real-estate experience focused on discovery and lead generation.

I built a media-first listing presentation with optimized image loading, semantic markup, and clear contact actions. The search and filtering architecture was designed for scalability, supporting future geographic and metadata extensions.

Agent workflows include inquiry routing, listing updates, and moderation checks. The UI prioritizes readability and trust, using a premium visual rhythm aligned with the broader portfolio system.

This case study shows how performance and visual polish can coexist in conversion-focused listing products.
TEXT,
                'stack' => ['PHP', 'Laravel', 'Blade', 'Vite'],
                'image' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1600&q=80',
                'github_url' => 'https://github.com/your-username/property-listing-suite',
                'demo_url' => 'https://example.com/property-listing-demo',
                'is_featured' => true,
                'published_at' => now()->subDays(20),
            ],
            [
                'title' => 'School Management Portal',
                'slug' => 'school-management-portal',
                'description' => 'A centralized school portal for attendance, assessments, announcements, and parent communication.',
                'details' => <<<'TEXT'
School Management Portal centralizes daily academic operations into a single role-aware platform.

I implemented modules for attendance, assessment management, communication streams, and dashboard snapshots for administrators, teachers, students, and parents. The information architecture was designed to reduce clutter and improve decision-making.

Data integrity and access control were key priorities. Sensitive records are permission-gated, and audit-friendly histories provide accountability across workflows.

The finished system supports institutional consistency while remaining approachable for non-technical users.
TEXT,
                'stack' => ['Laravel', 'PHP', 'MySQL', 'Alpine.js'],
                'image' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=1600&q=80',
                'github_url' => 'https://github.com/your-username/school-management-portal',
                'demo_url' => 'https://example.com/school-portal-demo',
                'is_featured' => true,
                'published_at' => now()->subDays(15),
            ],
            [
                'title' => 'Inventory Tracker',
                'slug' => 'inventory-tracker',
                'description' => 'A stock control system with movement logs, low-stock alerts, and exportable reporting.',
                'details' => <<<'TEXT'
Inventory Tracker was built for teams that need reliable stock visibility without enterprise complexity.

I implemented movement logging, threshold alerts, supplier references, and reporting exports to support warehouse and operations workflows. Transaction flows were designed to preserve traceability and reduce stock inconsistencies.

The dashboard architecture highlights actionable metrics first, while archival data remains accessible for audits. Queue-backed processing handles heavier report generation jobs without degrading UI responsiveness.

This project demonstrates robust backend design paired with practical operational UX.
TEXT,
                'stack' => ['PHP', 'Laravel', 'Queue Jobs', 'Blade'],
                'image' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=1600&q=80',
                'github_url' => 'https://github.com/your-username/inventory-tracker',
                'demo_url' => 'https://example.com/inventory-demo',
                'is_featured' => true,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Portfolio CMS Engine',
                'slug' => 'portfolio-cms-engine',
                'description' => 'A headless-ready content module for portfolio pages, case studies, and dynamic service blocks.',
                'details' => <<<'TEXT'
Portfolio CMS Engine powers modular content publishing for high-end portfolio websites.

I designed a content model for case studies, service blocks, and reusable sections, enabling clean authoring workflows and predictable rendering on the frontend. The architecture supports both Blade-rendered pages and API-ready distribution.

Editorial actions are structured around publish states, version-safe edits, and predictable content hierarchies. On the UI side, Tailwind + Alpine keep interactions fast and maintainable.

The case study highlights a balance between content flexibility, frontend performance, and long-term maintainability.
TEXT,
                'stack' => ['Laravel', 'PHP', 'Alpine.js', 'Tailwind'],
                'image' => 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?auto=format&fit=crop&w=1600&q=80',
                'github_url' => 'https://github.com/your-username/portfolio-cms-engine',
                'demo_url' => 'https://example.com/portfolio-cms-demo',
                'is_featured' => true,
                'published_at' => now()->subDays(5),
            ],
        ];

        foreach ($projects as $project) {
            Project::query()->updateOrCreate(
                ['slug' => $project['slug']],
                $project
            );
        }
    }
}
