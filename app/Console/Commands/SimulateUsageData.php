<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class SimulateUsageData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blade:simulate-usage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulates component usage data for testing optimization';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Simulating component usage data...');
        
        // Find all component files
        $componentPath = resource_path('views/components');
        $components = $this->findComponents($componentPath);
        
        $this->info('Found ' . count($components) . ' components to simulate usage for.');
        
        // Simulate frequency data
        $frequencyData = $this->generateFrequencyData($components);
        
        // Save frequency data to cache
        Cache::put('blade_component_frequency', $frequencyData, 86400); // 24 hours
        
        // Simulate usage patterns for routes
        $usagePatterns = $this->generateUsagePatterns($components);
        
        // Save usage patterns to cache
        Cache::put('blade_component_usage_patterns', $usagePatterns, 86400); // 24 hours
        
        $this->info('Successfully simulated usage data for ' . count($components) . ' components.');
        
        return Command::SUCCESS;
    }
    
    /**
     * Find all components in the given directory and return their names
     */
    protected function findComponents(string $directory): array
    {
        $components = [];
        $files = File::allFiles($directory);
        
        foreach ($files as $file) {
            if ($file->getExtension() === 'php' && str_ends_with($file->getFilename(), '.blade.php')) {
                $relativePath = str_replace(resource_path('views/components/'), '', $file->getPathname());
                $relativePath = str_replace('.blade.php', '', $relativePath);
                $componentName = str_replace('/', '.', $relativePath);
                $components[] = $componentName;
            }
        }
        
        return $components;
    }
    
    /**
     * Generate simulated frequency data
     */
    protected function generateFrequencyData(array $components): array
    {
        $frequencyData = [];
        
        // Common components that should be prioritized
        $commonComponents = [
            'ui.button',
            'ui.card',
            'ui.icon',
            'ui.empty-state',
            'layout.app',
        ];
        
        // Add common components with high frequency
        foreach ($commonComponents as $component) {
            if (in_array($component, $components)) {
                $frequencyData[$component] = rand(50, 100);
            }
        }
        
        // Add remaining components with random frequency
        foreach ($components as $component) {
            if (!isset($frequencyData[$component])) {
                $frequencyData[$component] = rand(1, 49);
            }
        }
        
        // Sort by frequency (highest first)
        arsort($frequencyData);
        
        return $frequencyData;
    }
    
    /**
     * Generate simulated usage patterns
     */
    protected function generateUsagePatterns(array $components): array
    {
        $usagePatterns = [];
        
        // Define some common routes/paths
        $routes = [
            'home',
            'dashboard',
            'todos/list',
            'todos/{id}',
            'settings',
            'profile',
        ];
        
        // Generate random component usage for each route
        foreach ($routes as $route) {
            // Pick a random number of components (3-10)
            $count = rand(3, 10);
            
            // Shuffle components and pick the first $count
            $shuffled = $components;
            shuffle($shuffled);
            $routeComponents = array_slice($shuffled, 0, $count);
            
            // Add to patterns
            $usagePatterns[$route] = $routeComponents;
        }
        
        return $usagePatterns;
    }
} 