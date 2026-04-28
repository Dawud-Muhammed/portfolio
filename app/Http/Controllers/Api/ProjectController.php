<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $projects = Project::query()
            ->published()
            ->orderByDesc('published_at')
            ->paginate((int) $request->integer('per_page', 12));

        $payload = $projects->through(static fn (Project $project): array => [
            'id' => $project->id,
            'title' => $project->title,
            'slug' => $project->slug,
            'description' => $project->description,
            'details' => $project->details,
            'stack' => $project->stack,
            'filters' => $project->filters,
            'image' => $project->image_url,
            'github_url' => $project->github_url,
            'demo_url' => $project->demo_url,
            'is_featured' => $project->is_featured,
            'published_at' => optional($project->published_at)?->toIso8601String(),
        ]);

        return response()->json($payload);
    }

    public function show(string $project): JsonResponse
    {
        $projectRecord = Project::query()
            ->published()
            ->where('slug', $project)
            ->firstOrFail();

        return response()->json([
            'data' => [
                'id' => $projectRecord->id,
                'title' => $projectRecord->title,
                'slug' => $projectRecord->slug,
                'description' => $projectRecord->description,
                'details' => $projectRecord->details,
                'stack' => $projectRecord->stack,
                'filters' => $projectRecord->filters,
                'image' => $projectRecord->image_url,
                'github_url' => $projectRecord->github_url,
                'demo_url' => $projectRecord->demo_url,
                'is_featured' => $projectRecord->is_featured,
                'published_at' => optional($projectRecord->published_at)?->toIso8601String(),
            ],
        ]);
    }
}
