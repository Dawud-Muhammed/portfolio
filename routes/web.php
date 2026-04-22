<?php

use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\SkillController as AdminSkillController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SitemapController;
use App\Models\Project;
use App\Models\SiteSetting;
use App\Models\Skill;
use App\Support\ImageAsset;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SitemapController::class, 'show'])->name('sitemap.show');
Route::get('/robots.txt', [RobotsController::class, 'show'])->name('robots.show');

Route::get('/', function () {
    $featuredProjects = Project::query()
        ->published()
        ->where('is_featured', true)
        ->orderByDesc('published_at')
        ->take(6)
        ->get();

    $filters = array_merge(['All'], $featuredProjects
        ->flatMap(fn (Project $project) => $project->filters ?? [])
        ->unique()
        ->sort()
        ->values()
        ->all());

    $projects = $featuredProjects
        ->map(fn (Project $project): array => [
            'title' => $project->title,
            'slug' => $project->slug,
            'description' => $project->description,
            'image' => $project->image_url,
            'stack' => $project->stack,
            'filters' => $project->filters ?? ['Laravel', 'PHP'],
            'github' => $project->github_url,
            'demo' => $project->demo_url,
            'details' => $project->details,
        ])
        ->values()
        ->all();

    $skills = Skill::query()
        ->published()
        ->orderByDesc('level')
        ->get()
        ->map(fn (Skill $skill): array => [
            'id' => $skill->skill_id,
            'name' => $skill->name,
            'level' => $skill->level,
            'years' => $skill->years,
            'description' => $skill->description,
            'category' => $skill->category,
        ])
        ->values()
        ->all();

    $siteSettings = [
        'hero_name' => SiteSetting::get('hero_name', 'Dawud Muhammed'),
        'hero_title' => SiteSetting::get('hero_title', 'Laravel Developer'),
        'hero_cv_url' => SiteSetting::get('hero_cv_url', url('/')),
        'hero_background' => ImageAsset::resolve(
            SiteSetting::get('hero_background'),
            (string) config('seo.default_image', '')
        ),
        'about_bio' => SiteSetting::get('about_bio', 'I design and ship Laravel products focused on reliability, maintainability, and user trust. From architecture to implementation, I prioritize clear communication, measurable outcomes, and long-term scalability.'),
        'about_profile_image' => ImageAsset::resolve(
            SiteSetting::get('about_profile_image'),
            '/storage/images/photo-1542831371-29b0f74f9713.jpg'
        ),
    ];

    return view('welcome', [
        'projects' => $projects,
        'filters' => $filters,
        'skills' => $skills,
        'siteSettings' => $siteSettings,
    ]);
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
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('skills', AdminSkillController::class)->except(['show']);
    Route::patch('skills/{skill}/toggle', [AdminSkillController::class, 'toggle'])->name('skills.toggle');
    Route::resource('testimonials', AdminTestimonialController::class)->except(['show']);
    Route::patch('testimonials/sort', [AdminTestimonialController::class, 'sort'])->name('testimonials.sort');
    Route::get('settings', [AdminSettingsController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [AdminSettingsController::class, 'update'])->name('settings.update');

    Route::get('contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::patch('contacts/read-all', [AdminContactController::class, 'markAllRead'])->name('contacts.read-all');
    Route::patch('contacts/{contact}/read', [AdminContactController::class, 'markRead'])->name('contacts.read');
    Route::post('contacts/{contact}/reply', [AdminContactController::class, 'reply'])->name('contacts.reply');
});
