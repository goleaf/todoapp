<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class BuildComponentManifest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blade:build-manifest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Builds an optimized component manifest for faster loading';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Building blade component manifest...');
        
        // Get all component blade files
        $componentPath = resource_path('views/components');
        $componentFiles = $this->findBladeFiles($componentPath);
        
        $this->info('Found ' . count($componentFiles) . ' component files.');
        
        $manifest = $this->buildManifest($componentFiles);
        
        // Save the manifest
        $manifestPath = storage_path('framework/cache/blade-manifest.php');
        $manifestContent = '<?php return ' . var_export($manifest, true) . ';';
        File::put($manifestPath, $manifestContent);
        
        // Store in cache
        Cache::put('blade_component_manifest', $manifest, 86400 * 30); // 30 days
        
        $this->info('Component manifest built successfully!');
        $this->info('Cached ' . count($manifest['components']) . ' components.');
        
        return Command::SUCCESS;
    }
    
    /**
     * Find all blade files in the given directory and its subdirectories
     */
    protected function findBladeFiles(string $directory): array
    {
        $files = [];
        
        foreach (File::allFiles($directory) as $file) {
            if ($file->getExtension() === 'php' && Str::endsWith($file->getFilename(), '.blade.php')) {
                $files[] = $file->getPathname();
            }
        }
        
        return $files;
    }
    
    /**
     * Build the component manifest
     */
    protected function buildManifest(array $componentFiles): array
    {
        $components = [];
        $dependencies = [];
        $nesting = [];
        
        // Process each component file
        foreach ($componentFiles as $file) {
            $relativePath = Str::after($file, resource_path('views/'));
            $componentName = $this->getComponentName($relativePath);
            
            // Skip if the component has no name
            if (!$componentName) {
                continue;
            }
            
            $content = File::get($file);
            
            // Store component metadata
            $components[$componentName] = [
                'path' => $relativePath,
                'size' => strlen($content),
                'modified' => filemtime($file),
                'hash' => md5($content),
            ];
            
            // Identify component references
            $deps = $this->extractComponentDependencies($content);
            if (!empty($deps)) {
                $dependencies[$componentName] = $deps;
                
                // Update nesting levels
                foreach ($deps as $dep) {
                    if (!isset($nesting[$dep])) {
                        $nesting[$dep] = [];
                    }
                    $nesting[$dep][] = $componentName;
                }
            }
        }
        
        // Calculate nesting optimization
        $nestingLevels = $this->calculateNestingLevels($nesting);
        
        return [
            'components' => $components,
            'dependencies' => $dependencies,
            'nesting' => $nestingLevels,
            'generated_at' => time(),
        ];
    }
    
    /**
     * Get component name from file path
     */
    protected function getComponentName(string $path): string
    {
        $path = Str::replaceFirst('components/', '', $path);
        $path = Str::replaceLast('.blade.php', '', $path);
        
        return str_replace('/', '.', $path);
    }
    
    /**
     * Extract component dependencies from content
     */
    protected function extractComponentDependencies(string $content): array
    {
        $dependencies = [];
        
        // Match x-component references
        preg_match_all('/<x-([a-zA-Z0-9._-]+)/', $content, $matches);
        
        if (!empty($matches[1])) {
            foreach ($matches[1] as $component) {
                // Skip dynamic components
                if ($component === 'dynamic-component') {
                    continue;
                }
                
                $dependencies[] = $component;
            }
        }
        
        return array_values(array_unique($dependencies));
    }
    
    /**
     * Calculate component nesting levels for optimization
     */
    protected function calculateNestingLevels(array $nesting): array
    {
        $levels = [];
        $visited = [];
        
        // Helper function to calculate level
        $calculateLevel = function($component, $currentLevel = 0) use (&$calculateLevel, &$levels, &$visited, $nesting) {
            if (isset($visited[$component])) {
                return $levels[$component];
            }
            
            $visited[$component] = true;
            $level = $currentLevel;
            
            if (isset($nesting[$component])) {
                foreach ($nesting[$component] as $parent) {
                    $parentLevel = $calculateLevel($parent, $currentLevel + 1);
                    $level = max($level, $parentLevel);
                }
            }
            
            $levels[$component] = $level;
            return $level;
        };
        
        // Calculate for all components
        foreach (array_keys($nesting) as $component) {
            if (!isset($visited[$component])) {
                $calculateLevel($component);
            }
        }
        
        return $levels;
    }
} 