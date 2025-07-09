<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CleanBladePHPCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blade:clean-php-code {--dry-run : Only show which files would be modified}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes complex PHP logic from component blade files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        $componentPath = resource_path('views/components');
        $this->info("Scanning components in: {$componentPath}");
        
        $bladeFiles = $this->findBladeFiles($componentPath);
        $this->info("Found " . count($bladeFiles) . " blade files to process.");
        
        $bar = $this->output->createProgressBar(count($bladeFiles));
        $bar->start();
        
        $modifiedCount = 0;
        
        foreach ($bladeFiles as $file) {
            $relativePath = Str::after($file, resource_path('views/'));
            $content = File::get($file);
            
            // Process file content
            $newContent = $this->processBladePHP($content);
            
            if ($content !== $newContent) {
                $modifiedCount++;
                $this->line("\n<info>Modified:</info> {$relativePath}");
                
                if (!$dryRun) {
                    File::put($file, $newContent);
                }
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        
        $this->newLine(2);
        if ($dryRun) {
            $this->info("Dry run completed. {$modifiedCount} files would be modified.");
        } else {
            $this->info("Processing completed. {$modifiedCount} files were modified.");
        }
        
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
     * Process blade PHP sections to simplify and remove complex logic
     */
    protected function processBladePHP(string $content): string
    {
        // Replace large @php blocks with comments to use component service instead
        $patterns = [
            // Match complex array definitions
            '/@php\s+\$[a-zA-Z0-9_]+(Classes|Map|Styles|Config)\s*=\s*\[[^\]]+\];/s',
            
            // Match variable definitions with conditionals
            '/@php\s+if\s*\([^)]+\)\s*{\s*[^}]+\s*}\s*@endphp/s',
            
            // Match helper functions
            '/@php\s+function\s+[a-zA-Z0-9_]+\([^)]*\)\s*{[^}]+}\s*@endphp/s',
            
            // Match large blocks with multiple variables
            '/@php\s+(\$[a-zA-Z0-9_]+\s*=\s*[^;]+;\s*){3,}\s*@endphp/s',
        ];
        
        foreach ($patterns as $pattern) {
            $content = preg_replace_callback($pattern, function($matches) {
                return '{{-- PHP logic moved to BladeComponentService --}}';
            }, $content);
        }
        
        return $content;
    }
} 