<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_renders_welcome_view_with_projects()
    {
        $project = Project::create([
            'title' => 'Test Project',
            'slug' => 'test-project',
            'description' => 'Project description',
            'details' => 'Detailed info',
            'stack' => ['php', 'laravel'],
            'filters' => ['web'],
            'image' => null,
            'is_featured' => true,
            'published_at' => now(),
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('welcome');
        $response->assertViewHas('projects', function ($projects) use ($project) {
            return collect($projects)->pluck('slug')->contains($project->slug);
        });
    }
}
