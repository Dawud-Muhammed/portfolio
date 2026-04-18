<?php

use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SitemapController;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SitemapController::class, 'show'])->name('sitemap.show');
Route::get('/robots.txt', [RobotsController::class, 'show'])->name('robots.show');

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

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function (): void {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::resource('projects', AdminProjectController::class)->except(['show']);
    Route::resource('posts', AdminPostController::class)->except(['show']);

    Route::get('contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::patch('contacts/{contact}/read', [AdminContactController::class, 'markRead'])->name('contacts.read');
});
