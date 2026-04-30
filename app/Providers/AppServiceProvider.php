<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
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
        // Force HTTPS in production to fix Mixed Content errors
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        $this->cleanupStaleViteHotFile();
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