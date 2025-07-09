<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class OptimizeBladeStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blade:optimize-storage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimizes blade storage organization for faster loading';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Optimizing blade storage...');
        
        // Prepare compiled views directory
        $compiledDir = storage_path('framework/views');
        $optimizedDir = storage_path('framework/optimized-views');
        
        // Create optimized directory if it doesn't exist
        if (!File::exists($optimizedDir)) {
            File::makeDirectory($optimizedDir, 0755, true);
        }
        
        // Get component usage data
        $frequencyData = Cache::get('blade_component_frequency', []);
        
        if (empty($frequencyData)) {
            $this->warn('No component usage data found. Run your application in production mode first.');
            return Command::FAILURE;
        }
        
        $this->info('Found usage data for ' . count($frequencyData) . ' components.');
        
        // Get all compiled view files
        $compiledFiles = File::files($compiledDir);
        $this->info('Found ' . count($compiledFiles) . ' compiled view files.');
        
        // Create component map for faster lookup
        $componentMap = $this->createComponentMap($frequencyData);
        
        // Count of optimized components
        $optimizedCount = 0;
        
        // Process each compiled file
        $bar = $this->output->createProgressBar(count($compiledFiles));
        $bar->start();
        
        foreach ($compiledFiles as $file) {
            $filename = $file->getFilename();
            
            // Skip PHP files that don't correspond to components
            if (!$this->isComponentFile($filename, $componentMap)) {
                continue;
            }
            
            // Get component priority
            $priority = $this->getComponentPriority($filename, $componentMap);
            
            // If this is a frequently used component, optimize its storage
            if ($priority > 0) {
                // Create optimized version with symlinks or copy
                $optimizedPath = $this->getOptimizedPath($optimizedDir, $filename, $priority);
                
                // Create symlink to the compiled file
                if (!File::exists($optimizedPath)) {
                    File::copy($file->getPathname(), $optimizedPath);
                    $optimizedCount++;
                }
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        
        $this->newLine(2);
        $this->info("Optimized {$optimizedCount} component files for faster loading.");
        
        // Update configuration to use optimized files
        $this->updateViewConfig();
        
        return Command::SUCCESS;
    }
    
    /**
     * Create a component map for faster lookup
     */
    protected function createComponentMap(array $frequencyData): array
    {
        $map = [];
        $priority = 1;
        
        // Sort by frequency (already sorted)
        foreach ($frequencyData as $component => $count) {
            // Convert dot notation to directory structure
            $normalizedName = str_replace('.', '_', $component);
            
            // Store with priority (1 is highest)
            $map[$normalizedName] = $priority++;
        }
        
        return $map;
    }
    
    /**
     * Check if a compiled file corresponds to a component
     */
    protected function isComponentFile(string $filename, array $componentMap): bool
    {
        // Check against component map keys
        foreach (array_keys($componentMap) as $component) {
            if (Str::contains($filename, $component)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Get the priority of a component (lower is more important)
     */
    protected function getComponentPriority(string $filename, array $componentMap): int
    {
        foreach ($componentMap as $component => $priority) {
            if (Str::contains($filename, $component)) {
                return $priority;
            }
        }
        
        return 999; // Low priority for unmatched components
    }
    
    /**
     * Get the optimized path for a component file
     */
    protected function getOptimizedPath(string $baseDir, string $filename, int $priority): string
    {
        // For top priority components, store in the root
        if ($priority <= 10) {
            return $baseDir . '/' . $filename;
        }
        
        // For other components, group by priority range
        $group = floor($priority / 10) * 10;
        $groupDir = $baseDir . '/' . $group;
        
        if (!File::exists($groupDir)) {
            File::makeDirectory($groupDir, 0755, true);
        }
        
        return $groupDir . '/' . $filename;
    }
    
    /**
     * Update the view configuration to use optimized files
     */
    protected function updateViewConfig(): void
    {
        // This would normally modify the config, but since we want to avoid
        // changing config files directly, we'll create a runtime cache value
        Cache::put('blade_storage_optimized', true, 86400 * 30); // 30 days
    }
} 