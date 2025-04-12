<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;

class HeroiconServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register both BladeUI packages
        $this->app->register(\BladeUI\Icons\BladeIconsServiceProvider::class);
        $this->app->register(\BladeUI\Heroicons\BladeHeroiconsServiceProvider::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register Heroicon component aliases
        Blade::componentNamespace('BladeUI\\Heroicons\\Components', 'heroicon');
        
        // Add a custom alias for accessing heroicons
        $this->app->singleton('heroicon', function ($app) {
            return new class($app) {
                protected $app;
                
                public function __construct($app)
                {
                    $this->app = $app;
                }
                
                public function outline($name)
                {
                    return "heroicon-o-{$name}";
                }
                
                public function solid($name)
                {
                    return "heroicon-s-{$name}";
                }
            };
        });
    }
} 