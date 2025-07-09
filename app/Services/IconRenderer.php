<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class IconRenderer
{
    /**
     * Cache time in seconds (1 hour)
     */
    const CACHE_TIME = 3600;

    /**
     * Render an icon with caching
     *
     * @param string $expression
     * @return string
     */
    public function render($expression)
    {
        $params = $this->parseExpression($expression);
        $icon = $params['icon'] ?? null;
        $class = $params['class'] ?? 'w-5 h-5';
        
        if (!$icon) {
            return $this->fallbackIcon($class);
        }
        
        // If caching is disabled, render directly
        if (config('app.debug') || config('blade-optimizations.icon_rendering') !== 'cached') {
            return $this->renderIcon($icon, $class, $params);
        }
        
        // Create a cache key based on the icon name and class
        $cacheKey = "icon:{$icon}:{$class}:" . md5(json_encode($params));
        $cacheDuration = config('blade-optimizations.cache_duration', self::CACHE_TIME);
        
        // Track the cache key for easy clearing
        $this->trackCacheKey($cacheKey);
        
        // Check if the icon is already cached
        return Cache::remember($cacheKey, $cacheDuration, function () use ($icon, $class, $params) {
            return $this->renderIcon($icon, $class, $params);
        });
    }
    
    /**
     * Parse the expression string
     *
     * @param string $expression
     * @return array
     */
    protected function parseExpression($expression)
    {
        // Remove any leading/trailing spaces to avoid syntax errors
        $expression = trim($expression);
        
        // Handle different parameter formats safely
        if (strpos($expression, ',') !== false) {
            // Multiple parameters: icon, class
            list($icon, $class) = array_pad(explode(',', $expression, 2), 2, null);
            $icon = trim($icon, " \t\n\r\0\x0B\"'");
            $class = $class ? trim($class, " \t\n\r\0\x0B\"'") : 'w-5 h-5';
            
            return ['icon' => $icon, 'class' => $class];
        } elseif (strpos($expression, '=>') !== false || strpos($expression, ':') !== false) {
            // Array format: ['icon' => 'name', 'class' => 'classes'] or compact syntax
            try {
                $params = [];
                eval("\$params = $expression;");
                return is_array($params) ? $params : ['icon' => null, 'class' => 'w-5 h-5'];
            } catch (\Throwable $e) {
                // If eval fails, return default values
                return ['icon' => null, 'class' => 'w-5 h-5'];
            }
        } else {
            // Single parameter: just the icon name
            $icon = trim($expression, " \t\n\r\0\x0B\"'");
            return ['icon' => $icon, 'class' => 'w-5 h-5'];
        }
    }
    
    /**
     * Render an icon
     *
     * @param string $icon
     * @param string $class
     * @param array $params
     * @return string
     */
    protected function renderIcon($icon, $class, $params)
    {
        // Map prefixes to their component paths for efficient lookup
        $iconMap = [
            'heroicon-o-' => 'vendor/blade-heroicons/o-',
            'heroicon-s-' => 'vendor/blade-heroicons/s-',
            'phosphor-' => 'vendor/blade-phosphor/',
        ];
        
        // Handle direct SVG retrieval for common icons
        foreach ($iconMap as $prefix => $path) {
            if (Str::startsWith($icon, $prefix)) {
                $iconName = Str::after($icon, $prefix);
                $vendorPath = public_path($path . $iconName . '.svg');
                
                if (File::exists($vendorPath)) {
                    $svgContent = File::get($vendorPath);
                    return $this->updateSvgAttributes($svgContent, $class);
                }
            }
        }
        
        // Fallback to component rendering
        if (View::exists("components.ui.icon.heroicon-o.{$icon}")) {
            return view("components.ui.icon.heroicon-o.{$icon}", ['class' => $class])->render();
        }
        
        return $this->fallbackIcon($class);
    }
    
    /**
     * Update SVG attributes
     *
     * @param string $svgContent
     * @param string $class
     * @return string
     */
    protected function updateSvgAttributes($svgContent, $class)
    {
        // Add class to SVG
        $svgContent = preg_replace('/<svg\s/', '<svg class="'.$class.'" ', $svgContent, 1);
        
        // Remove width/height/fill attributes from SVG if they exist
        $svgContent = preg_replace('/\s+width="[^"]*"/', '', $svgContent);
        $svgContent = preg_replace('/\s+height="[^"]*"/', '', $svgContent);
        
        return $svgContent;
    }
    
    /**
     * Track cache keys for easy clearing
     * 
     * @param string $key
     */
    protected function trackCacheKey($key)
    {
        $keys = Cache::get('cache_keys:icons', []);
        
        if (!in_array($key, $keys)) {
            $keys[] = $key;
            Cache::put('cache_keys:icons', $keys, 864000); // 10 days
        }
    }
    
    /**
     * Return a fallback icon
     *
     * @param string $class
     * @return string
     */
    protected function fallbackIcon($class)
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" class="' . $class . '" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>';
    }
}