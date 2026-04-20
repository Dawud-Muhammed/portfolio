<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

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
                'details' => 'Includes secure auth, admin fleet controls, dynamic pricing, and booking lifecycle tracking.',
                'stack' => ['Laravel', 'PHP', 'MySQL', 'Tailwind'],
                'filters' => ['Laravel', 'PHP'],
                'image' => Storage::url('images/photo-1492144534655-ae79c964c9d7.jpg'),
                'github_url' => 'https://github.com/your-username/car-rental-platform',
                'demo_url' => 'https://example.com/car-rental-demo',
                'is_featured' => true,
                'published_at' => now()->subDays(30),
            ],
            [
                'title' => 'Support Desk App',
                'slug' => 'support-desk-app',
                'description' => 'A streamlined customer support app with ticket pipelines, status automation, and internal team collaboration.',
                'details' => 'Features SLA labels, threaded replies, assignment queues, and metrics-ready API endpoints.',
                'stack' => ['Laravel', 'PHP', 'Alpine.js', 'REST API'],
                'filters' => ['Laravel', 'PHP'],
                'image' => Storage::url('images/photo-1517248135467-4c7edcad34c4.jpg'),
                'github_url' => 'https://github.com/your-username/support-desk-app',
                'demo_url' => 'https://example.com/support-desk-demo',
                'is_featured' => true,
                'published_at' => now()->subDays(25),
            ],
            [
                'title' => 'Property Listing Suite',
                'slug' => 'property-listing-suite',
                'description' => 'A modern real-estate listing experience with media galleries, search filters, and agent inquiry management.',
                'details' => 'Optimized for fast browsing and conversion-driven detail pages with clean semantic markup.',
                'stack' => ['PHP', 'Laravel', 'Blade', 'Vite'],
                'filters' => ['Laravel', 'PHP'],
                'image' => Storage::url('images/photo-1560518883-ce09059eeffa.jpg'),
                'github_url' => 'https://github.com/your-username/property-listing-suite',
                'demo_url' => 'https://example.com/property-listing-demo',
                'is_featured' => true,
                'published_at' => now()->subDays(20),
            ],
            [
                'title' => 'School Management Portal',
                'slug' => 'school-management-portal',
                'description' => 'A centralized school portal for attendance, assessments, announcements, and parent communication.',
                'details' => 'Provides role-based dashboards for admins, teachers, students, and guardians.',
                'stack' => ['Laravel', 'PHP', 'MySQL', 'Alpine.js'],
                'filters' => ['Laravel', 'PHP'],
                'image' => Storage::url('images/photo-1503676260728-1c00da094a0b.jpg'),
                'github_url' => 'https://github.com/your-username/school-management-portal',
                'demo_url' => 'https://example.com/school-portal-demo',
                'is_featured' => true,
                'published_at' => now()->subDays(15),
            ],
            [
                'title' => 'Inventory Tracker',
                'slug' => 'inventory-tracker',
                'description' => 'A stock control system with movement logs, low-stock alerts, and exportable reporting.',
                'details' => 'Supports warehouse workflows, supplier records, and audit-friendly stock histories.',
                'stack' => ['PHP', 'Laravel', 'Queue Jobs', 'Blade'],
                'filters' => ['Laravel', 'PHP'],
                'image' => Storage::url('images/photo-1586528116311-ad8dd3c8310d.jpg'),
                'github_url' => 'https://github.com/your-username/inventory-tracker',
                'demo_url' => 'https://example.com/inventory-demo',
                'is_featured' => true,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Portfolio CMS Engine',
                'slug' => 'portfolio-cms-engine',
                'description' => 'A headless-ready content module for portfolio pages, case studies, and dynamic service blocks.',
                'details' => 'Enables modular content editing and publication flows for multi-section landing pages.',
                'stack' => ['Laravel', 'PHP', 'Alpine.js', 'Tailwind'],
                'filters' => ['Laravel', 'PHP'],
                'image' => Storage::url('images/photo-1461749280684-dccba630e2f6.jpg'),
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
