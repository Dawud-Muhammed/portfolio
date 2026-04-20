<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        RateLimiter::for('contact', fn (Request $request): Limit => Limit::perMinute(3)
            ->by((string) $request->ip())
            ->response(fn () => response()->json([
                'message' => 'Too many contact attempts. Please try again in a minute.',
            ], 429))
        );
    }
}