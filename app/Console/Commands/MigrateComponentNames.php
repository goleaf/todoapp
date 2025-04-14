<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;

class MigrateComponentNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'components:migrate {--dry-run : Show changes without applying them}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate component names according to main.mdc rules';

    /**
     * The migration rules.
     *
     * @var array
     */
    protected $migrationRules = [
        // Input Components
        '<x-input' => '<x-input.input',
        '<x-form' => '<x-input.form',
        '<x-textarea' => '<x-input.textarea',
        '<x-select' => '<x-input.select',
        '<x-checkbox' => '<x-input.checkbox',
        '<x-radio' => '<x-input.radio',
        '<x-input-error' => '<x-input.input-error',
        '<x-label' => '<x-input.label',
        
        // UI Components
        '<x-button' => '<x-ui.button',
        '<x-card' => '<x-ui.card',
        '<x-avatar' => '<x-ui.avatar',
        '<x-badge' => '<x-ui.badge',
        '<x-dropdown-item' => '<x-ui.dropdown.item',
        '<x-dropdown-menu' => '<x-ui.dropdown.menu',
        '<x-modal' => '<x-ui.modal',
        '<x-empty-state' => '<x-ui.empty-state',
        '<x-container' => '<x-ui.container',
        '<x-link' => '<x-ui.link',
        '<x-dark-mode-toggle' => '<x-ui.dark-mode-toggle',
        '<x-status' => '<x-ui.status',
        
        // Layout Components
        '<x-layouts.app' => '<x-layout.app',
        '<x-layouts.auth' => '<x-layout.auth',
        '<x-heading' => '<x-layout.heading',
        '<x-subheading' => '<x-layout.subheading',
        '<x-text' => '<x-layout.text',
        '<x-separator' => '<x-layout.separator',
        '<x-spacer' => '<x-layout.spacer',
        '<x-header' => '<x-layout.header',
        '<x-section-header' => '<x-layout.section-header',
        '<x-app-logo' => '<x-layout.app-logo',
        '<x-app-logo-icon' => '<x-layout.app-logo-icon',
        '<x-placeholder-pattern' => '<x-layout.placeholder-pattern',
        
        // Data Components
        '<x-table' => '<x-data.table',
        '<x-table.row' => '<x-data.table.row',
        '<x-table.cell' => '<x-data.table.cell',
        '<x-table.heading' => '<x-data.table.heading',
        
        // Authentication Components
        '<x-auth-header' => '<x-auth.auth-header',
        '<x-auth-session-status' => '<x-auth.auth-session-status',
        
        // Feedback Components
        '<x-error' => '<x-feedback.error',
        '<x-action-message' => '<x-feedback.action-message',
        '<x-alert' => '<x-feedback.alert',
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->info('Running in dry-run mode. No changes will be applied.');
        }
        
        $viewsPath = resource_path('views');
        
        $finder = new Finder();
        $finder->files()->in($viewsPath)->name('*.blade.php');
        
        $filesModified = 0;
        $totalChanges = 0;
        
        foreach ($finder as $file) {
            $path = $file->getRealPath();
            $content = file_get_contents($path);
            $originalContent = $content;
            
            foreach ($this->migrationRules as $old => $new) {
                $pattern = '/' . preg_quote($old, '/') . '(?!\.)(?=\s|>)/';
                $content = preg_replace($pattern, $new, $content);
            }
            
            if ($content !== $originalContent) {
                $changesCount = $this->countChanges($originalContent, $content);
                $totalChanges += $changesCount;
                $filesModified++;
                
                $relativePath = str_replace(base_path() . '/', '', $path);
                $this->info("File: {$relativePath} - {$changesCount} changes");
                
                if (!$dryRun) {
                    file_put_contents($path, $content);
                }
            }
        }
        
        if ($dryRun) {
            $this->info("Dry run completed. {$filesModified} files would be modified with {$totalChanges} changes.");
        } else {
            $this->info("Migration completed. {$filesModified} files modified with {$totalChanges} changes.");
        }
        
        return 0;
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
            $oldCount = substr_count($original, $old);
            $newCount = substr_count($new, $newPattern);
            $count += $newCount;
        }
        
        return $count;
    }
} 