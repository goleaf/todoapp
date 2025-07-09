<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;

class ComponentManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'components
                            {action=migrate : Action to perform (migrate|list)}
                            {--dry-run : Show changes without applying them}
                            {--path= : Specific path to search in (default: resources/views)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage component names according to main.mdc rules';

    /**
     * The migration rules loaded from main.mdc.
     *
     * @var array
     */
    protected $migrationRules = [];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');
        $dryRun = $this->option('dry-run');
        $path = $this->option('path') ?: resource_path('views');
        
        // Load rules from .cursor/rules/main.mdc
        $this->loadRulesFromMdc();
        
        if (empty($this->migrationRules)) {
            $this->error('No migration rules found in .cursor/rules/main.mdc');
            return Command::FAILURE;
        }
        
        $this->info('Loaded ' . count($this->migrationRules) . ' component migration rules.');
        
        // Route to the appropriate action
        return match ($action) {
            'migrate' => $this->migrateComponents($path, $dryRun),
            'list' => $this->listRules(),
            default => $this->error("Unknown action: {$action}. Valid actions are: migrate, list"),
        };
    }
    
    /**
     * Load migration rules from the main.mdc file.
     *
     * @return void
     */
    protected function loadRulesFromMdc(): void
    {
        $mdcPath = base_path('.cursor/rules/main.mdc');
        
        if (!File::exists($mdcPath)) {
            $this->warn('Rules file not found: ' . $mdcPath);
            return;
        }
        
        $content = File::get($mdcPath);
        $rules = [];
        
        // Regular expression to extract rules from markdown sections
        $pattern = '/##\s+(.*?)\s+Components\s*\n((?:- Replace.*?\n)+)/';
        
        if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $category = $match[1]; // e.g., "Input", "UI", etc.
                $ruleLines = explode("\n", trim($match[2]));
                
                foreach ($ruleLines as $line) {
                    if (preg_match('/- Replace `(.*?)` with `(.*?)`/', $line, $ruleParts)) {
                        $old = $ruleParts[1];
                        $new = $ruleParts[2];
                        $rules[$old] = $new;
                    }
                }
            }
        }
        
        $this->migrationRules = $rules;
    }
    
    /**
     * Migrate component names in blade files.
     *
     * @param string $path
     * @param bool $dryRun
     * @return int
     */
    protected function migrateComponents(string $path, bool $dryRun): int
    {
        if ($dryRun) {
            $this->info('Running in dry-run mode. No changes will be applied.');
        }
        
        $finder = new Finder();
        $finder->files()->in($path)->name('*.blade.php');
        
        $filesModified = 0;
        $totalChanges = 0;
        
        foreach ($finder as $file) {
            $filePath = $file->getRealPath();
            $content = file_get_contents($filePath);
            $originalContent = $content;
            
            foreach ($this->migrationRules as $old => $new) {
                $pattern = '/' . preg_quote($old, '/') . '(?!\.)(?=\s|>)/';
                $content = preg_replace($pattern, $new, $content);
            }
            
            if ($content !== $originalContent) {
                $changesCount = $this->countChanges($originalContent, $content);
                $totalChanges += $changesCount;
                $filesModified++;
                
                $relativePath = str_replace(base_path() . '/', '', $filePath);
                $this->info("File: {$relativePath} - {$changesCount} changes");
                
                if (!$dryRun) {
                    file_put_contents($filePath, $content);
                }
            }
        }
        
        if ($dryRun) {
            $this->info("Dry run completed. {$filesModified} files would be modified with {$totalChanges} changes.");
        } else {
            $this->info("Migration completed. {$filesModified} files modified with {$totalChanges} changes.");
        }
        
        return Command::SUCCESS;
    }
    
    /**
     * List all migration rules.
     *
     * @return int
     */
    protected function listRules(): int
    {
        $table = [];
        
        foreach ($this->migrationRules as $old => $new) {
            $table[] = [$old, $new];
        }
        
        $this->table(['Original', 'New'], $table);
        
        return Command::SUCCESS;
    }
    
    /**
     * Count the number of changes between two strings.
     *
     * @param string $original
     * @param string $new
     * @return int
     */
    protected function countChanges(string $original, string $new): int
    {
        $count = 0;
        
        foreach ($this->migrationRules as $old => $newPattern) {
            $oldCount = preg_match_all('/' . preg_quote($old, '/') . '(?!\.)(?=\s|>)/', $original, $matches);
            $newCount = preg_match_all('/' . preg_quote($newPattern, '/') . '(?!\.)(?=\s|>)/', $new, $matches);
            
            // If we've added new patterns, count them
            $count += max(0, $newCount - $oldCount);
        }
        
        return $count;
    }
} 