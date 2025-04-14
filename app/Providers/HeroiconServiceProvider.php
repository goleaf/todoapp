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
        Blade::componentNamespace('BladeUI\\Heroicons\\Components', 'ui.icon.heroicon');
        
        // Register components in the heroicon-o namespace 
        Blade::component('components.ui.icon.heroicon-o.check-circle', 'ui.icon.heroicon-o-check-circle');
        Blade::component('components.ui.icon.heroicon-o.ellipsis-horizontal', 'ui.icon.heroicon-o-ellipsis-horizontal');
        Blade::component('components.ui.icon.heroicon-o.clipboard-document-list', 'ui.icon.heroicon-o-clipboard-document-list');
        Blade::component('components.ui.icon.heroicon-o.funnel', 'ui.icon.heroicon-o-funnel');
        Blade::component('components.ui.icon.heroicon-o.plus', 'ui.icon.heroicon-o-plus');
        Blade::component('components.ui.icon.heroicon-o.eye', 'ui.icon.heroicon-o-eye');
        Blade::component('components.ui.icon.heroicon-o.pencil-square', 'ui.icon.heroicon-o-pencil-square');
        Blade::component('components.ui.icon.heroicon-o.trash', 'ui.icon.heroicon-o-trash');
        Blade::component('components.ui.icon.heroicon-o.exclamation-triangle', 'ui.icon.heroicon-o-exclamation-triangle');
        
        // Register components in the heroicon-s namespace
        Blade::component('components.ui.icon.heroicon-s.check-circle', 'ui.icon.heroicon-s-check-circle');
        Blade::component('components.ui.icon.heroicon-s.ellipsis-vertical', 'ui.icon.heroicon-s-ellipsis-vertical');
        
        // Register phosphor icons
        Blade::component('components.ui.icon.phosphor.x', 'ui.icon.phosphor-x');
        
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
                    return "ui.icon.heroicon-o-{$name}";
                }
                
                public function solid($name)
                {
                    return "ui.icon.heroicon-s-{$name}";
                }
            };
        });
    }
} 