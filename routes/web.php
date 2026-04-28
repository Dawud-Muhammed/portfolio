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
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SitemapController::class, 'show'])->name('sitemap.show');
Route::get('/robots.txt', [RobotsController::class, 'show'])->name('robots.show');

Route::get('/', HomeController::class)->name('home');

$redirectToHomeSection = static fn (string $section) => redirect()->to(route('home').'#'.$section);

Route::get('/about', static fn () => $redirectToHomeSection('about'))->name('home.about');
Route::get('/skills', static fn () => $redirectToHomeSection('skills'))->name('home.skills');
Route::get('/testimonials', static fn () => $redirectToHomeSection('testimonials'))->name('home.testimonials');
Route::get('/contact', static fn () => $redirectToHomeSection('contact'))->name('home.contact');

Route::get('/projects', function () {
    return redirect()->to(route('home').'#projects');
})->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

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
