<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class BladeComponentPreloader
{
    /**
     * Components to always preload
     * 
     * @var array
     */
    protected $alwaysLoadComponents = [
        'ui.button',
        'ui.card',
        'ui.icon',
        'layout.app',
    ];
    
    /**
     * Maximum number of components to preload per route
     * 
     * @var int
     */
    protected $maxComponentsPerRoute = 15;
    
    /**
     * Boot the preloader
     */
    public function boot()
    {
        // Only preload in production
        if (config('app.debug')) {
            return;
        }
        
        // Add route-based preloading
        $this->registerRouteBasedPreloading();
        
        // Always preload common components
        $this->preloadCommonComponents();
    }
    
    /**
     * Register route-based component preloading
     */
    protected function registerRouteBasedPreloading()
    {
        // Add a global middleware to determine route
        app('router')->matched(function ($event) {
            $routeName = $event->route->getName();
            
            if ($routeName) {
                $this->preloadForRoute($routeName);
            } else {
                $path = $event->request->path();
                $this->preloadForPath($path);
            }
        });
    }
    
    /**
     * Preload components for a specific route
     */
    protected function preloadForRoute(string $routeName)
    {
        // Get route component usage patterns
        $routePatterns = Cache::get('blade_component_route_patterns', []);
        
        if (isset($routePatterns[$routeName])) {
            $components = $routePatterns[$routeName];
            $this->preloadComponents($components);
        }
    }
    
    /**
     * Preload components for a specific path
     */
    protected function preloadForPath(string $path)
    {
        // Normalize path
        $normalizedPath = $this->normalizePath($path);
        
        // Get path component usage patterns
        $pathPatterns = Cache::get('blade_component_usage_patterns', []);
        
        if (isset($pathPatterns[$normalizedPath])) {
            $components = $pathPatterns[$normalizedPath];
            $this->preloadComponents($components);
        }
    }
    
    /**
     * Normalize the path for consistent caching
     */
    protected function normalizePath(string $path): string
    {
        // Remove trailing slashes and normalize
        $path = trim($path, '/');
        
        // Handle home page
        if (empty($path)) {
            return 'home';
        }
        
        // Handle paths with numeric IDs (e.g., /users/123) 
        return preg_replace('/\/\d+($|\/)/', '/{id}$1', $path);
    }
    
    /**
     * Preload common components that are used on most pages
     */
    protected function preloadCommonComponents()
    {
        // Add frequency-based preloading
        $frequentComponents = Cache::get('blade_component_frequency', []);
        
        // Get top most frequent components
        $topComponents = array_slice(array_keys($frequentComponents), 0, 10, true);
        
        // Combine with always load components
        $components = array_unique(array_merge($this->alwaysLoadComponents, $topComponents));
        
        // Preload these components
        $this->preloadComponents($components);
    }
    
    /**
     * Preload a list of components
     */
    protected function preloadComponents(array $components)
    {
        // Limit number of components to preload
        if (count($components) > $this->maxComponentsPerRoute) {
            $components = array_slice($components, 0, $this->maxComponentsPerRoute);
        }
        
        // Preload each component
        foreach ($components as $component) {
            if (View::exists("components.{$component}")) {
                // Warm the view cache
                View::exists("components.{$component}");
            }
        }
    }
} 