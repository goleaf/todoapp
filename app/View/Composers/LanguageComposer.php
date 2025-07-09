<?php

namespace App\View\Composers;

use App\Helpers\LanguageHelper;
use App\Models\Language;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class LanguageComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $currentLocale = App::getLocale();
        $currentLangName = \Locale::getDisplayName($currentLocale, $currentLocale);
        $flagMap = LanguageHelper::getFlagMap();
        $currentFlag = $flagMap[$currentLocale] ?? '🌐';
        
        $availableLocales = [];
        $directories = File::directories(resource_path('lang'));
        
        foreach ($directories as $directory) {
            $locale = basename($directory);
            // Skip non-language directories
            if (preg_match('/^[a-z]{2}(?:-[A-Z]{2})?$/', $locale)) {
                $availableLocales[] = $locale;
            }
        }
        
        $view->with(compact(
            'currentLocale', 
            'currentLangName', 
            'flagMap', 
            'currentFlag', 
            'availableLocales'
        ));
    }
} 