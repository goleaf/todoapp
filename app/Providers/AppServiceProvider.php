<?php

namespace App\Providers;

use App\View\Composers\LanguageComposer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Services\IconRenderer;
use App\Services\BladeComponentCache;
use App\Services\BladeComponentService;
use App\Services\BladeComponentOptimizer;
use App\Services\BladeComponentPreloader;

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
        
        // Register the IconRenderer service
        $this->app->singleton(IconRenderer::class, function ($app) {
            return new IconRenderer();
        });
        
        // Register the BladeComponentCache service
        $this->app->singleton(BladeComponentCache::class, function ($app) {
            return new BladeComponentCache();
        });
        
        // Register the BladeComponentService
        $this->app->singleton(BladeComponentService::class, function ($app) {
            return new BladeComponentService();
        });
        
        // Register the BladeComponentOptimizer
        $this->app->singleton(BladeComponentOptimizer::class, function ($app) {
            return new BladeComponentOptimizer();
        });
        
        // Register the BladeComponentPreloader
        $this->app->singleton(BladeComponentPreloader::class, function ($app) {
            return new BladeComponentPreloader();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Performance optimizations
        $this->optimizePerformance();
        
        // Register model observers
        \App\Models\Todo::observe(\App\Observers\TodoObserver::class);
        
        // Use the data.pagination component for pagination
        Paginator::defaultView('components.data.pagination.tailwind');
        Paginator::defaultSimpleView('components.data.pagination.simple-tailwind');

        // Register view composers
        View::composer([
            'components.ui.language-switcher', 
            'components.layout.language-switcher',
            'settings.language'
        ], LanguageComposer::class);

        // Add Blade directive for translation
        Blade::directive('t', function ($expression) {
            // Extract the parameters from the expression
            $segments = explode(',', $expression);
            
            // First segment is the key
            $key = trim($segments[0]);
            
            // Check if there are parameters (replace any parameters)
            if (count($segments) > 1) {
                $params = trim($segments[1]);
                return "<?php echo __({$key}, {$params}); ?>";
            }
            
            return "<?php echo __({$key}); ?>";
        });

        // Add blade directive for icons to reduce component loading
        Blade::directive('icon', function ($expression) {
            return "<?php echo app('\\App\\Services\\IconRenderer')->render($expression); ?>";
        });
        
        // Register the component cache
        if (config('blade-optimizations.component_cache_enabled', true)) {
            app(BladeComponentCache::class)->register();
        }
        
        // Register component service helpers
        app(BladeComponentService::class)->registerComponentHelpers();
        
        // Apply variable safety to blade components once if not already done
        // Removed slow component variable safety check
        
        // Boot the component optimizer
        if (!config('app.debug')) {
            // Removed slow component optimizers
        }
        
        // Add component caching
        View::composer('*', function ($view) {
            $view->with('cache_key', config('app.debug') ? time() : 'production');
        });
        
        // Register common icons as blade components
        $this->registerCommonIcons();
    }
    
    /**
     * Apply performance optimizations to the application.
     */
    protected function optimizePerformance(): void
    {
        // Prevent lazy loading in production to avoid N+1 problems
        Model::preventLazyLoading(!app()->isProduction());
        
        // Log slow queries if in debug mode
        if (config('app.debug')) {
            DB::listen(function ($query) {
                // Log queries taking longer than 100ms
                if ($query->time > 100) {
                    logger()->warning('Slow query: ' . $query->sql, [
                        'time' => $query->time,
                        'bindings' => $query->bindings
                    ]);
                }
            });
        }
        
        // Set reasonable chunk size for chunked queries
        config(['database.chunk_size' => 200]);
        
        // Enable query caching for production (improves repeat query performance)
        if (app()->isProduction()) {
            // Configure database for efficient connections
            config(['database.connections.sqlite.foreign_key_constraints' => false]);
            config(['database.connections.mysql.strict' => false]);
        }
        
        // Configure view optimization
        View::addNamespace('cached', resource_path('views/cached'));
        
        // Pre-compile common blade components
        // Removed slow component precompilation
    }
    
    /**
     * Pre-compile frequently used Blade components to improve rendering performance.
     */
    protected function precompileCommonBladeComponents(): void
    {
        // Define commonly used components
        $commonComponents = [
            'layout.app',
            'ui.button',
            'ui.card',
            'ui.dropdown.menu',
            'ui.dropdown.item',
            'input.input',
            'input.textarea',
            'input.select',
            'data.table',
        ];
        
        // Precompile components if in production
        if (app()->isProduction()) {
            foreach ($commonComponents as $component) {
                Blade::component($component, null);
            }
        }
    }

    protected function registerCommonIcons()
    {
        // Register commonly used icons directly
        $commonIcons = config('blade-optimizations.common_icons', [
            'clipboard-document-list',
            'plus',
            'check-circle',
            'chevron-down',
            'chevron-up',
        ]);
        
        foreach ($commonIcons as $icon) {
            Blade::component("components.ui.icon.heroicon-o.{$icon}", "icon-{$icon}");
        }
    }
}
