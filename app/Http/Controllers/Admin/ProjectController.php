<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminProjectRequest;
use App\Http\Requests\Admin\UpdateAdminProjectRequest;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index(): View
    {
        return view('admin.projects.index', [
            'projects' => Project::query()->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.projects.form', [
            'project' => new Project(),
            'mode' => 'create',
        ]);
    }

    public function store(StoreAdminProjectRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image_file')) {
            $path = Storage::disk('public')->put('images', $request->file('image_file'));
            $validated['image'] = Storage::url($path);
        }

        unset($validated['image_file']);

        Project::query()->create($this->normalizePayload($validated, $request->boolean('is_featured')));

        return redirect()->route('admin.projects.index')->with('status', 'Project created successfully.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.form', [
            'project' => $project,
            'mode' => 'edit',
        ]);
    }

    public function update(UpdateAdminProjectRequest $request, Project $project): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image_file')) {
            $path = Storage::disk('public')->put('images', $request->file('image_file'));
            $validated['image'] = Storage::url($path);
        }

        unset($validated['image_file']);

        $project->update($this->normalizePayload($validated, $request->boolean('is_featured')));

        return redirect()->route('admin.projects.index')->with('status', 'Project updated successfully.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('status', 'Project deleted successfully.');
    }

    /**
     * @param array<string, mixed> $validated
     * @return array<string, mixed>
     */
    private function normalizePayload(array $validated, bool $isFeatured): array
    {
        $stackParts = array_filter(array_map(
            static fn (string $part): string => trim($part),
            explode(',', (string) ($validated['stack'] ?? ''))
        ));

        $validated['stack'] = array_values($stackParts);
        $validated['is_featured'] = $isFeatured;

        return $validated;
    }
}
