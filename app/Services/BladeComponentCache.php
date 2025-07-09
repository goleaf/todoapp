<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class BladeComponentCache
{
    /**
     * Cache time in seconds (1 hour)
     */
    const CACHE_TIME = 3600;
    
    /**
     * Components to cache
     */
    protected $cachableComponents = [];
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cachableComponents = config('blade-optimizations.cacheable_components', [
            'ui.button',
            'ui.card',
            'ui.empty-state',
            'ui.icon',
            'ui.link',
            'ui.dropdown',
            'ui.modal',
        ]);
    }
    
    /**
     * Register component caching
     */
    public function register()
    {
        View::composer($this->getComponentPaths(), function ($view) {
            $this->handleComponentCaching($view);
        });
    }
    
    /**
     * Get component paths to cache
     * 
     * @return array
     */
    protected function getComponentPaths()
    {
        return array_map(function ($component) {
            return "components.{$component}";
        }, $this->cachableComponents);
    }
    
    /**
     * Handle component caching
     * 
     * @param \Illuminate\View\View $view
     */
    protected function handleComponentCaching($view)
    {
        // Skip caching in debug mode or for nested components
        if (config('app.debug') || $this->isNestedComponent($view)) {
            return;
        }
        
        $cacheKey = $this->generateCacheKey($view);
        $cacheDuration = config('blade-optimizations.cache_duration', self::CACHE_TIME);
        
        // Track the cache key
        $this->trackCacheKey($cacheKey);
        
        if (Cache::has($cacheKey)) {
            $view->setPath(Cache::get($cacheKey));
        } else {
            // After the view is rendered, cache the compiled version
            $view->afterRendering(function () use ($view, $cacheKey, $cacheDuration) {
                Cache::put($cacheKey, $view->getPath(), $cacheDuration);
            });
        }
    }
    
    /**
     * Generate a cache key for the view
     * 
     * @param \Illuminate\View\View $view
     * @return string
     */
    protected function generateCacheKey($view)
    {
        $name = $view->getName();
        $data = json_encode($view->getData());
        
        return "blade_component:{$name}:" . md5($data);
    }
    
    /**
     * Check if this is a nested component render
     * 
     * @param \Illuminate\View\View $view
     * @return bool
     */
    protected function isNestedComponent($view)
    {
        $debugBacktrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 10);
        
        $renderCalls = 0;
        foreach ($debugBacktrace as $trace) {
            if (isset($trace['function']) && $trace['function'] === 'render') {
                $renderCalls++;
                if ($renderCalls > 1) {
                    return true;
                }
            }
        }
        
        return false;
    }
    
    /**
     * Track cache keys for easy clearing
     * 
     * @param string $key
     */
    protected function trackCacheKey($key)
    {
        $keys = Cache::get('cache_keys:components', []);
        
        if (!in_array($key, $keys)) {
            $keys[] = $key;
            Cache::put('cache_keys:components', $keys, 864000); // 10 days
        }
    }
} 