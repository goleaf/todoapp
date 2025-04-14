<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class JetstreamServiceProvider extends ServiceProvider
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
        // This is a placeholder since the application might be configured to use Jetstream
        // but not actually using it. We include this class to prevent errors.
    }
} 