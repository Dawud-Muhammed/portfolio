<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Contracts\View\View;

class ProjectController extends Controller
{
    public function show(string $slug): View
    {
        $projectRecord = Project::query()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('projects.show', ['project' => $projectRecord]);
    }
}
