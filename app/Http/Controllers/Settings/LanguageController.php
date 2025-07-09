<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\LanguageHelper;
use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
    /**
     * Get the list of available locales based on directories in lang folder.
     *
     * @return array
     */
    protected function getAvailableLocales(): array
    {
        $langPath = base_path('lang');
        $directories = File::directories($langPath);
        
        $locales = [];
        foreach ($directories as $directory) {
            $locales[] = basename($directory);
        }
        
        // Filter out any non-locale directories
        $locales = array_filter($locales, function($locale) {
            return preg_match('/^[a-z]{2}(?:-[A-Z]{2})?$/', $locale);
        });
        
        return array_unique($locales);
    }

    /**
     * Show the language settings form.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $locales = Language::getAvailableLanguages();
        $currentLocale = Session::get('locale', config('app.locale'));
        $flagMap = LanguageHelper::getFlagMap();
        
        return view('settings.language', [
            'locales' => $locales,
            'currentLocale' => $currentLocale,
            'flagMap' => $flagMap,
        ]);
    }

    /**
     * Update the user's language preference.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $locale = $request->input('locale');
        $availableLocales = $this->getAvailableLocales();
        
        if (!in_array($locale, $availableLocales)) {
            return redirect()->back()->withErrors(['locale' => __('settings.language.invalid_locale')]);
        }
        
        // Store the locale in the session
        Session::put('locale', $locale);
        
        return redirect()->route('settings.language.edit')
            ->with('success', __('settings.language.updated_successfully'));
    }
} 