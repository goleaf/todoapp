<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

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
        
        // Filter out any non-locale directories like 'vendor'
        $locales = array_filter($locales, function($locale) {
            return preg_match('/^[a-z]{2}(?:-[A-Z]{2})?$/', $locale); // Basic validation
        });
        
        // Ensure 'en' is always available as a fallback
        if (!in_array('en', $locales)) {
            $locales[] = 'en';
        }
        
        return array_unique($locales);
    }

    /**
     * Change the application language.
     *
     * @param  string  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLang($locale)
    {
        $availableLocales = $this->getAvailableLocales();
        
        // Check if the language is supported
        if (!in_array($locale, $availableLocales)) {
            $locale = App::getFallbackLocale(); // Use Laravel's fallback locale
        }
        
        // Store the locale in the session
        Session::put('locale', $locale);
        
        // If user is logged in, update their preferences
        if (Auth::check()) {
            $user = Auth::user();
            $user->preferences = array_merge($user->preferences ?? [], ['locale' => $locale]);
            $user->save();
        }
        
        // Set the application locale for the current request
        App::setLocale($locale);
        
        // Redirect back to the previous page
        return redirect()->back()->with('success', __('messages.language_switched'));
    }
    
    /**
     * Show language settings page
     */
    public function edit()
    {
        $availableLocales = $this->getAvailableLocales();
        $currentLocale = App::getLocale();
        
        // Get locale display names
        $locales = [];
        foreach ($availableLocales as $locale) {
            $locales[$locale] = [
                'native' => \Locale::getDisplayName($locale, $locale),
                'english' => \Locale::getDisplayName($locale, 'en')
            ];
        }
        
        return view('settings.language', compact('locales', 'currentLocale'));
    }
    
    /**
     * Update user's language preference
     */
    public function update(Request $request)
    {
        $request->validate([
            'locale' => 'required|string|size:2'
        ]);
        
        $locale = $request->input('locale');
        $availableLocales = $this->getAvailableLocales();
        
        // Check if the language is supported
        if (!in_array($locale, $availableLocales)) {
            return redirect()->back()->with('error', __('messages.language_not_supported'));
        }
        
        // Store the locale in the session
        Session::put('locale', $locale);
        
        // Update user preferences
        $user = Auth::user();
        $user->preferences = array_merge($user->preferences ?? [], ['locale' => $locale]);
        $user->save();
        
        // Set the application locale for the current request
        App::setLocale($locale);
        
        return redirect()->route('settings.language.edit')
            ->with('success', __('messages.language_preference_updated'));
    }
} 