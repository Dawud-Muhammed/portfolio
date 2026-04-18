<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProjectController;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $projects = Project::query()
        ->published()
        ->where('is_featured', true)
        ->orderByDesc('published_at')
        ->take(6)
        ->get()
        ->map(fn (Project $project): array => [
            'title' => $project->title,
            'slug' => $project->slug,
            'description' => $project->description,
            'image' => $project->image,
            'stack' => $project->stack,
            'filters' => ['Laravel', 'PHP'],
            'github' => $project->github_url,
            'demo' => $project->demo_url,
            'details' => $project->details,
        ])
        ->values()
        ->all();

    return view('welcome', ['projects' => $projects]);
})->name('home');

Route::get('/projects', function () {
    return redirect()->to(route('home').'#projects');
})->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::resource('contacts', ContactController::class)->only(['index', 'store', 'show']);
