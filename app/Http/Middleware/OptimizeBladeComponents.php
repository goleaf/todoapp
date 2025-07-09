<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class OptimizeBladeComponents
{
    /**
     * Component references found in HTML responses
     *
     * @var array
     */
    protected $componentCache = [];
    
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Only optimize in production and for HTML responses
        if (config('app.debug') || !$this->isHtmlResponse($response)) {
            return $response;
        }
        
        // Get the response content
        $content = $response->getContent();
        
        // Analyze and cache component usage patterns
        $this->analyzeComponentUsage($request->path(), $content);
        
        return $response;
    }
    
    /**
     * Check if this is an HTML response
     */
    protected function isHtmlResponse(Response $response): bool
    {
        return $response->headers->get('Content-Type') === 'text/html'
            || str_contains($response->headers->get('Content-Type', ''), 'text/html');
    }
    
    /**
     * Analyze component usage and cache usage patterns
     */
    protected function analyzeComponentUsage(string $path, string $content): void
    {
        // Find all component tags
        preg_match_all('/<x-([a-zA-Z0-9._-]+)/', $content, $matches);
        
        if (empty($matches[1])) {
            return;
        }
        
        $components = array_values(array_unique($matches[1]));
        
        // Normalize the path
        $normalizedPath = $this->normalizePath($path);
        
        // Get existing usage patterns
        $usagePatterns = Cache::get('blade_component_usage_patterns', []);
        
        // Add this page's patterns 
        $usagePatterns[$normalizedPath] = $components;
        
        // Keep only the most recent 100 path entries
        if (count($usagePatterns) > 100) {
            $usagePatterns = array_slice($usagePatterns, -100, null, true);
        }
        
        // Cache the updated patterns
        Cache::put('blade_component_usage_patterns', $usagePatterns, 86400); // 24 hours
        
        // Update component frequency data
        $this->updateComponentFrequency($components);
    }
    
    /**
     * Normalize the request path for consistent caching
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
     * Update component usage frequency data
     */
    protected function updateComponentFrequency(array $components): void
    {
        $frequencyData = Cache::get('blade_component_frequency', []);
        
        foreach ($components as $component) {
            if (!isset($frequencyData[$component])) {
                $frequencyData[$component] = 0;
            }
            
            $frequencyData[$component]++;
        }
        
        // Sort by frequency
        arsort($frequencyData);
        
        // Limit to top 50 components
        $frequencyData = array_slice($frequencyData, 0, 50, true);
        
        Cache::put('blade_component_frequency', $frequencyData, 86400); // 24 hours
    }
} 