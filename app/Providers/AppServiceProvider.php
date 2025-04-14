<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('heroicon', function () {
            return new class {
                public function solid($name)
                {
                    return heroicon('solid', $name);
                }
                
                public function outline($name)
                {
                    return heroicon('outline', $name);
                }
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register model observers
        \App\Models\Todo::observe(\App\Observers\TodoObserver::class);
        
        // Use the data.pagination component for pagination
        Paginator::defaultView('components.data.pagination.tailwind');
        Paginator::defaultSimpleView('components.data.pagination.simple-tailwind');
    }
}
