<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_show_displays_project_view()
    {
        $project = Project::create([
            'title' => 'Visible Project',
            'slug' => 'visible-project',
            'description' => 'Desc',
            'details' => 'Details',
            'stack' => ['php'],
            'filters' => [],
            'image' => null,
            'published_at' => now(),
        ]);

        $response = $this->get(route('projects.show', ['slug' => $project->slug]));

        $response->assertStatus(200);
        $response->assertViewIs('projects.show');
        $response->assertViewHas('project', function ($p) use ($project) {
            return $p->is($project);
        });
    }
}
