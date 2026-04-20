<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('welcome', function ($view): void {
            $view->with('sectionLinks', [
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'About', 'url' => route('home').'#about'],
                ['label' => 'Skills', 'url' => route('home').'#skills'],
                ['label' => 'Projects', 'url' => route('home').'#projects'],
                ['label' => 'Contact', 'url' => route('home').'#contact'],
                ['label' => 'Projects API', 'url' => route('projects.index')],
            ]);
        });

        View::composer('partials.footer', function ($view): void {
            $view->with('socialLinks', [
                ['label' => 'GitHub', 'url' => 'https://github.com/your-username'],
                ['label' => 'LinkedIn', 'url' => 'https://www.linkedin.com/in/your-username'],
                ['label' => 'X', 'url' => 'https://x.com/your-username'],
                ['label' => 'Email', 'url' => 'mailto:hello@example.com'],
            ]);
        });

    }
}
