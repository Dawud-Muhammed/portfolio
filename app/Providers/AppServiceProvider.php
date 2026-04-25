<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\App;
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
        $this->cleanupStaleViteHotFile();

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
                ['key' => 'home', 'label' => 'Home', 'url' => route('home')],
                ['key' => 'github', 'label' => 'GitHub', 'url' => SiteSetting::get('footer_github', 'https://github.com/your-username')],
                ['key' => 'linkedin', 'label' => 'LinkedIn', 'url' => SiteSetting::get('footer_linkedin', 'https://www.linkedin.com/in/your-username')],
                ['key' => 'x', 'label' => 'X', 'url' => SiteSetting::get('footer_x', 'https://x.com/your-username')],
                ['key' => 'tiktok', 'label' => 'TikTok', 'url' => SiteSetting::get('footer_tiktok', 'https://www.tiktok.com/@your-username')],
                ['key' => 'telegram', 'label' => 'Telegram', 'url' => SiteSetting::get('footer_telegram', 'https://t.me/your-username')],
                ['key' => 'instagram', 'label' => 'Instagram', 'url' => SiteSetting::get('footer_instagram', 'https://www.instagram.com/your-username')],
                ['key' => 'facebook', 'label' => 'Facebook', 'url' => SiteSetting::get('footer_facebook', 'https://www.facebook.com/your-username')],
                ['key' => 'whatsapp', 'label' => 'WhatsApp', 'url' => SiteSetting::get('footer_whatsapp', 'https://wa.me/2340000000000')],
            ]);
        });

    }

    private function cleanupStaleViteHotFile(): void
    {
        if (! App::isLocal()) {
            return;
        }

        $hotFile = public_path('hot');
        if (! is_file($hotFile)) {
            return;
        }

        $hotUrl = trim((string) @file_get_contents($hotFile));
        if ($hotUrl === '') {
            @unlink($hotFile);

            return;
        }

        $parts = parse_url($hotUrl);
        $host = (string) ($parts['host'] ?? '');
        $port = (int) ($parts['port'] ?? 5173);

        if ($host === '') {
            @unlink($hotFile);

            return;
        }

        $connection = @fsockopen($host, $port, $errorCode, $errorMessage, 0.25);

        if (is_resource($connection)) {
            fclose($connection);

            return;
        }

        @unlink($hotFile);
    }
}
