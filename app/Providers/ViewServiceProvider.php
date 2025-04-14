<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\LanguageController; // Assuming the logic is kept there for reuse

class ViewServiceProvider extends ServiceProvider
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
        // Share available locales with the language switcher component
        View::composer('components.ui.language-switcher', function ($view) {
            // Duplicate the logic here for simplicity
            $langPath = base_path('lang');
            $directories = File::exists($langPath) ? File::directories($langPath) : [];
            $locales = [];
            foreach ($directories as $directory) {
                $locales[] = basename($directory);
            }
            $locales = array_filter($locales, fn($locale) => preg_match('/^[a-z]{2}(?:-[A-Z]{2})?$/', $locale));
            if (!in_array('en', $locales)) {
                $locales[] = 'en';
            }
            $availableLocales = array_unique($locales);
            sort($availableLocales); // Optional: sort locales alphabetically
            
            $view->with('availableLocales', $availableLocales);
        });
    }
} 