<?php

namespace App\Providers;

use App\View\Composers\LanguageComposer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;

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
    }
}
