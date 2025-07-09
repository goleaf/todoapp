<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class BladeComponentOptimizer
{
    /**
     * Indicates if the component manifest has been loaded.
     *
     * @var bool
     */
    protected $manifestLoaded = false;
    
    /**
     * Component manifest data
     *
     * @var array
     */
    protected $manifest = [];
    
    /**
     * Components that have been preloaded
     *
     * @var array
     */
    protected $preloadedComponents = [];
    
    /**
     * Boot the optimizer
     */
    public function boot()
    {
        $this->loadManifest();
        $this->optimizeComponentLoading();
    }
    
    /**
     * Load the component manifest
     */
    protected function loadManifest()
    {
        if ($this->manifestLoaded) {
            return;
        }
        
        // Try to get the manifest from cache first
        $manifest = Cache::get('blade_component_manifest');
        
        // If not in cache, try to load from file
        if (!$manifest) {
            $manifestPath = storage_path('framework/cache/blade-manifest.php');
            
            if (File::exists($manifestPath)) {
                $manifest = require $manifestPath;
            }
        }
        
        $this->manifest = $manifest ?: [
            'components' => [],
            'dependencies' => [],
            'nesting' => [],
            'generated_at' => 0,
        ];
        
        $this->manifestLoaded = true;
    }
    
    /**
     * Optimize component loading
     */
    protected function optimizeComponentLoading()
    {
        // Auto-register common top-level components
        $this->registerCommonComponents();
        
        // Add hook to optimize component resolution
        View::composer('*', function ($view) {
            $this->optimizeForView($view);
        });
    }
    
    /**
     * Register common components
     */
    protected function registerCommonComponents()
    {
        // Check if we have nesting information
        if (empty($this->manifest['nesting'])) {
            return;
        }
        
        // Find root level components (not used inside others)
        $rootComponents = [];
        foreach ($this->manifest['components'] as $name => $info) {
            if (!isset($this->manifest['nesting'][$name]) || count($this->manifest['nesting'][$name]) === 0) {
                $rootComponents[] = $name;
            }
        }
        
        // Preload common root components
        foreach ($rootComponents as $component) {
            $this->preloadComponent($component);
        }
    }
    
    /**
     * Optimize components for a specific view
     * 
     * @param \Illuminate\View\View $view
     */
    protected function optimizeForView($view)
    {
        $viewPath = $view->getName();
        
        // Skip for already compiled views
        if (Str::startsWith($viewPath, 'components.') || $view->compiled()) {
            return;
        }
        
        // Scan view content for component references
        $content = $view->getEngine()->get($view->getPath());
        $components = $this->extractComponentsFromContent($content);
        
        // Preload detected components
        foreach ($components as $component) {
            $this->preloadComponent($component);
        }
    }
    
    /**
     * Extract component references from content
     */
    protected function extractComponentsFromContent(string $content): array
    {
        $components = [];
        
        // Match x-component references
        preg_match_all('/<x-([a-zA-Z0-9._-]+)/', $content, $matches);
        
        if (!empty($matches[1])) {
            return array_values(array_unique($matches[1]));
        }
        
        return $components;
    }
    
    /**
     * Preload a component and its dependencies
     * 
     * @param string $component
     * @param int $level
     */
    protected function preloadComponent(string $component, int $level = 0)
    {
        // Avoid circular dependencies and already preloaded components
        if (isset($this->preloadedComponents[$component]) || $level > 5) {
            return;
        }
        
        // Skip if component doesn't exist in manifest
        if (!isset($this->manifest['components'][$component])) {
            return;
        }
        
        $path = $this->manifest['components'][$component]['path'];
        
        // Mark as preloaded
        $this->preloadedComponents[$component] = true;
        
        // Check for view existence to warm the cache
        if (View::exists('components.' . str_replace('.', '.', $component))) {
            // View exists, preload its dependencies
            if (isset($this->manifest['dependencies'][$component])) {
                foreach ($this->manifest['dependencies'][$component] as $dependency) {
                    $this->preloadComponent($dependency, $level + 1);
                }
            }
        }
    }
} 