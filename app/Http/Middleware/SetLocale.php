<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // First priority: user's preferred language from session
        $locale = Session::get('locale');
        
        // Second priority: authenticated user's preference
        if (!$locale && Auth::check()) {
            $user = Auth::user();
            if ($user->preferences && isset($user->preferences['locale'])) {
                $locale = $user->preferences['locale'];
            }
        }
        
        // Third priority: browser's Accept-Language header
        if (!$locale) {
            $browserLocales = $request->getLanguages();
            foreach ($browserLocales as $browserLocale) {
                $browserLocale = substr($browserLocale, 0, 2); // Get first 2 chars (en-US -> en)
                if ($this->isValidLocale($browserLocale)) {
                    $locale = $browserLocale;
                    break;
                }
            }
        }
        
        // Fallback: use app default
        if (!$locale || !$this->isValidLocale($locale)) {
            $locale = config('app.locale');
        }
        
        // Set the application locale
        App::setLocale($locale);
        
        // Also store it in session for future requests
        if (Session::get('locale') !== $locale) {
            Session::put('locale', $locale);
        }
        
        return $next($request);
    }
    
    /**
     * Check if the locale directory exists.
     *
     * @param string $locale
     * @return bool
     */
    protected function isValidLocale($locale)
    {
        return File::isDirectory(base_path("lang/{$locale}"));
    }
} 