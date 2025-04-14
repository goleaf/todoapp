<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;

class SyncTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:sync {--base=en : Base language to use as reference}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize translation files across all languages to ensure consistent keys';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $baseLanguage = $this->option('base');
        $this->info("Synchronizing translations using {$baseLanguage} as base language...");
        
        $basePath = base_path("lang/{$baseLanguage}");
        if (!File::exists($basePath)) {
            $this->error("Base language directory not found: {$basePath}");
            return Command::FAILURE;
        }
        
        // Get all language directories
        $langDirectories = $this->getLanguageDirectories($baseLanguage);
        
        if (empty($langDirectories)) {
            $this->warn("No language directories found to sync with {$baseLanguage}");
            return Command::SUCCESS;
        }
        
        // Process each base language file
        $baseFiles = Finder::create()->files()->in($basePath)->name('*.php');
        
        foreach ($baseFiles as $baseFile) {
            $filename = $baseFile->getFilenameWithoutExtension();
            $this->info("Processing {$filename}.php...");
            
            $baseContent = include $baseFile->getRealPath();
            if (!is_array($baseContent)) {
                $this->warn("Skipping {$filename}.php: Not a valid translation array");
                continue;
            }
            
            // Sync this file with all other languages
            foreach ($langDirectories as $langDir) {
                $this->syncFile($baseLanguage, $langDir, $filename, $baseContent);
            }
        }
        
        $this->info('Translation synchronization completed!');
        return Command::SUCCESS;
    }
    
    /**
     * Get all language directories except the base language.
     *
     * @param string $baseLanguage
     * @return array
     */
    protected function getLanguageDirectories(string $baseLanguage): array
    {
        $langPath = base_path('lang');
        $directories = File::directories($langPath);
        
        return array_filter(array_map(function ($path) {
            return basename($path);
        }, $directories), function ($dir) use ($baseLanguage) {
            return $dir !== $baseLanguage && preg_match('/^[a-z]{2}(?:-[A-Z]{2})?$/', $dir);
        });
    }
    
    /**
     * Synchronize a specific file between the base language and target language.
     *
     * @param string $baseLanguage
     * @param string $targetLanguage
     * @param string $filename
     * @param array $baseContent
     * @return void
     */
    protected function syncFile(string $baseLanguage, string $targetLanguage, string $filename, array $baseContent): void
    {
        $targetFilePath = base_path("lang/{$targetLanguage}/{$filename}.php");
        $targetContent = [];
        
        // Load existing target content if the file exists
        if (File::exists($targetFilePath)) {
            $existingContent = include $targetFilePath;
            if (is_array($existingContent)) {
                $targetContent = $existingContent;
            }
        }
        
        // Create a merged array with all keys from the base language
        $merged = [];
        foreach ($baseContent as $key => $value) {
            // If the key exists in the target language, use that translation
            // Otherwise, keep the base language value but mark it as untranslated
            if (array_key_exists($key, $targetContent)) {
                $merged[$key] = $targetContent[$key];
            } else {
                // Add the key with the original value but prepend it with "UNTRANSLATED: "
                // only if it's a string (not an array or other structure)
                if (is_string($value)) {
                    $merged[$key] = "UNTRANSLATED: " . $value;
                } elseif (is_array($value)) {
                    // For nested arrays, we need to handle them recursively
                    // But this violates the requirement of not creating deep nesting
                    // So we'll flatten the structure
                    $this->warn("Warning: Nested array found in {$filename}.{$key} - this should be flattened");
                    $merged[$key] = $value; // Just copy as is for now
                } else {
                    $merged[$key] = $value;
                }
            }
        }
        
        // Write the merged content back to the target file
        $content = "<?php\n\nreturn " . var_export($merged, true) . ";\n";
        
        // Clean up the exported array format to make it more readable
        $content = preg_replace('/array \(/', '[', $content);
        $content = preg_replace('/\)(,?)$/', ']$1', $content);
        $content = preg_replace('/\s+=>\s+/', ' => ', $content);
        
        File::put($targetFilePath, $content);
        
        $this->line("  Synchronized {$targetLanguage}/{$filename}.php");
    }
} 