<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;

class TranslationManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations
                            {action : Action to perform (report|find|create|sync)}
                            {--language=all : Specific language code to work with}
                            {--mark-untranslated : Mark untranslated strings with UNTRANSLATED prefix}
                            {--output= : Path to save the report as JSON (for report action)}
                            {--dry-run : Show changes without applying them (for sync action)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage translations - report status, find untranslated strings, create missing translations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');
        $language = $this->option('language');

        // Get English translations as the base
        $englishTranslations = $this->getLanguageTranslations('en');
        $englishTotal = $this->countTranslationStrings($englishTranslations);
        
        $this->info("Base language (en) has {$englishTotal} translation strings");

        // Route to the appropriate action
        match ($action) {
            'report' => $this->generateReport($englishTranslations, $englishTotal),
            'find' => $this->findUntranslatedStrings($englishTranslations, $language),
            'create' => $this->createMissingTranslations($englishTranslations, $language),
            'sync' => $this->syncTranslations($englishTranslations, $language),
            default => $this->error("Unknown action: {$action}. Valid actions are: report, find, create, sync"),
        };

        return Command::SUCCESS;
    }

    /**
     * Generate a report on translation completeness.
     *
     * @param array $englishTranslations
     * @param int $englishTotal
     * @return void
     */
    protected function generateReport(array $englishTranslations, int $englishTotal): void
    {
        $this->info('Generating translation report...');
        
        // Get all language directories
        $languages = $this->getLanguageDirectories();
        
        $this->info('Found ' . count($languages) . ' languages: ' . implode(', ', $languages));
        
        $report = [
            'timestamp' => date('c'), // ISO 8601 date
            'base_language' => 'en',
            'base_language_strings' => $englishTotal,
            'languages' => []
        ];
        
        $table = [];
        
        foreach ($languages as $lang) {
            $langTranslations = $this->getLanguageTranslations($lang);
            $stats = $this->calculateStats($englishTranslations, $langTranslations);
            
            $report['languages'][$lang] = $stats;
            
            $percentage = number_format($stats['progress'] * 100, 2);
            $table[] = [
                $lang,
                $stats['translated'],
                $stats['untranslated'],
                $stats['missing'],
                $stats['total'],
                "{$percentage}%"
            ];
        }
        
        // Display the results in a table
        $this->table(
            ['Language', 'Translated', 'Untranslated', 'Missing', 'Total', 'Progress'],
            $table
        );
        
        // Save report to file if requested
        $outputPath = $this->option('output');
        if ($outputPath) {
            File::put($outputPath, json_encode($report, JSON_PRETTY_PRINT));
            $this->info("Report saved to {$outputPath}");
        }
    }

    /**
     * Find untranslated strings in language files.
     *
     * @param array $englishTranslations
     * @param string $language
     * @return void
     */
    protected function findUntranslatedStrings(array $englishTranslations, string $language): void
    {
        if ($language === 'all') {
            // Get all language directories except English
            $languages = $this->getLanguageDirectories('en');
        } else {
            $languages = [$language];
        }
        
        $this->info('Checking translations for: ' . implode(', ', $languages));
        
        $totalMissing = 0;
        $totalUntranslated = 0;
        
        foreach ($languages as $lang) {
            $this->info("\n====== Language: {$lang} ======");
            
            // Get translations for the current language
            $langTranslations = $this->getLanguageTranslations($lang);
            
            // Find missing translation files
            $missingFiles = array_diff(array_keys($englishTranslations), array_keys($langTranslations));
            if (count($missingFiles) > 0) {
                $this->warn("Missing translation files: " . implode(', ', $missingFiles));
                $totalMissing += count($missingFiles);
            }
            
            // Check for untranslated keys within each file
            $untranslatedCount = 0;
            
            foreach ($englishTranslations as $file => $keys) {
                if (!isset($langTranslations[$file])) {
                    continue; // Skip files that don't exist
                }
                
                $untranslatedKeys = [];
                
                foreach ($keys as $key => $enValue) {
                    // If the key doesn't exist or it has the UNTRANSLATED prefix
                    if (!isset($langTranslations[$file][$key]) || 
                        (is_string($langTranslations[$file][$key]) && 
                         strpos($langTranslations[$file][$key], 'UNTRANSLATED:') === 0)) {
                        $untranslatedKeys[$key] = $enValue;
                    }
                }
                
                if (count($untranslatedKeys) > 0) {
                    $this->line("File: {$file}.php");
                    $this->table(['Key', 'English Value'], array_map(function ($key, $value) {
                        return [$key, is_string($value) ? $value : 'COMPLEX VALUE'];
                    }, array_keys($untranslatedKeys), array_values($untranslatedKeys)));
                    
                    $untranslatedCount += count($untranslatedKeys);
                }
            }
            
            $this->info("Total untranslated strings in {$lang}: {$untranslatedCount}");
            $totalUntranslated += $untranslatedCount;
        }
        
        $this->info("\n====== Summary ======");
        $this->info("Total missing files: {$totalMissing}");
        $this->info("Total untranslated strings: {$totalUntranslated}");
    }

    /**
     * Create missing translation files and keys.
     *
     * @param array $englishTranslations
     * @param string $language
     * @return void
     */
    protected function createMissingTranslations(array $englishTranslations, string $language): void
    {
        $markUntranslated = $this->option('mark-untranslated');
        
        if ($language === 'all') {
            // Get all language directories except English
            $languages = $this->getLanguageDirectories('en');
        } else {
            if (!in_array($language, array_merge(['en'], $this->getLanguageDirectories('en')))) {
                // Create directory for new language
                $langPath = base_path("lang/{$language}");
                if (!File::exists($langPath)) {
                    File::makeDirectory($langPath, 0755, true);
                    $this->info("Created new language directory: {$language}");
                }
            }
            $languages = [$language];
        }
        
        $this->info('Processing translations for: ' . implode(', ', $languages));
        
        $totalCreatedFiles = 0;
        $totalAddedKeys = 0;
        
        foreach ($languages as $lang) {
            $this->info("\n====== Language: {$lang} ======");
            
            // Get translations for the current language
            $langTranslations = $this->getLanguageTranslations($lang);
            
            // Find and create missing translation files
            $missingFiles = array_diff(array_keys($englishTranslations), array_keys($langTranslations));
            foreach ($missingFiles as $file) {
                $this->createTranslationFile($lang, $file, $englishTranslations[$file], $markUntranslated);
                $totalCreatedFiles++;
            }
            
            // Add missing keys to existing files
            foreach ($englishTranslations as $file => $keys) {
                if (!isset($langTranslations[$file])) {
                    continue; // Skip files that were just created
                }
                
                $addedKeys = $this->addMissingKeys($lang, $file, $keys, $langTranslations[$file], $markUntranslated);
                $totalAddedKeys += $addedKeys;
            }
        }
        
        $this->info("\n====== Summary ======");
        $this->info("Total created files: {$totalCreatedFiles}");
        $this->info("Total added keys: {$totalAddedKeys}");
    }

    /**
     * Sync translations between languages.
     *
     * @param array $englishTranslations
     * @param string $language
     * @return void
     */
    protected function syncTranslations(array $englishTranslations, string $language): void
    {
        $dryRun = $this->option('dry-run');
        $markUntranslated = $this->option('mark-untranslated');
        
        if ($dryRun) {
            $this->info('Running in dry-run mode. No changes will be applied.');
        }
        
        if ($language === 'all') {
            // Get all language directories except English
            $languages = $this->getLanguageDirectories('en');
        } else {
            $languages = [$language];
        }
        
        $this->info('Syncing translations for: ' . implode(', ', $languages));
        
        $totalSyncedFiles = 0;
        $totalSyncedKeys = 0;
        
        foreach ($languages as $lang) {
            $this->info("\n====== Language: {$lang} ======");
            
            // Get translations for the current language
            $langTranslations = $this->getLanguageTranslations($lang);
            
            // Sync all files from English to target language
            foreach ($englishTranslations as $file => $keys) {
                if (!isset($langTranslations[$file])) {
                    if (!$dryRun) {
                        $this->createTranslationFile($lang, $file, $keys, $markUntranslated);
                    }
                    $totalSyncedFiles++;
                    continue;
                }
                
                // Add missing keys to existing file
                $syncedKeys = $this->syncKeys($lang, $file, $keys, $langTranslations[$file], $markUntranslated, $dryRun);
                $totalSyncedKeys += $syncedKeys;
            }
        }
        
        $this->info("\n====== Summary ======");
        if ($dryRun) {
            $this->info("Dry run completed. Would sync {$totalSyncedFiles} files and {$totalSyncedKeys} keys.");
        } else {
            $this->info("Sync completed. Synced {$totalSyncedFiles} files and {$totalSyncedKeys} keys.");
        }
    }

    /**
     * Create a new translation file with all keys from English.
     *
     * @param string $language
     * @param string $file
     * @param array $keys
     * @param bool $markUntranslated
     * @return void
     */
    protected function createTranslationFile(string $language, string $file, array $keys, bool $markUntranslated): void
    {
        $targetFilePath = base_path("lang/{$language}/{$file}.php");
        
        // Prepare the content
        $translatedKeys = [];
        foreach ($keys as $key => $value) {
            if ($markUntranslated && is_string($value)) {
                $translatedKeys[$key] = "UNTRANSLATED: {$value}";
            } else {
                $translatedKeys[$key] = $value;
            }
        }
        
        $content = "<?php\n\nreturn " . var_export($translatedKeys, true) . ";\n";
        
        // Clean up the exported array format to make it more readable
        $content = $this->formatArrayOutput($content);
        
        File::put($targetFilePath, $content);
        
        $this->info("Created new translation file: {$language}/{$file}.php with " . count($keys) . " keys");
    }

    /**
     * Add missing keys to an existing translation file.
     *
     * @param string $language
     * @param string $file
     * @param array $englishKeys
     * @param array $existingKeys
     * @param bool $markUntranslated
     * @return int Number of keys added
     */
    protected function addMissingKeys(string $language, string $file, array $englishKeys, array $existingKeys, bool $markUntranslated): int
    {
        $targetFilePath = base_path("lang/{$language}/{$file}.php");
        $addedCount = 0;
        
        // Find missing keys
        $missingKeys = [];
        foreach ($englishKeys as $key => $value) {
            if (!isset($existingKeys[$key])) {
                if ($markUntranslated && is_string($value)) {
                    $missingKeys[$key] = "UNTRANSLATED: {$value}";
                } else {
                    $missingKeys[$key] = $value;
                }
                $addedCount++;
            }
        }
        
        if ($addedCount > 0) {
            // Merge existing and missing keys
            $mergedKeys = array_merge($existingKeys, $missingKeys);
            
            // Write back to file
            $content = "<?php\n\nreturn " . var_export($mergedKeys, true) . ";\n";
            
            // Clean up the exported array format
            $content = $this->formatArrayOutput($content);
            
            File::put($targetFilePath, $content);
            
            $this->info("Added {$addedCount} missing keys to {$language}/{$file}.php");
        }
        
        return $addedCount;
    }

    /**
     * Sync keys between English and target language files.
     *
     * @param string $language
     * @param string $file
     * @param array $englishKeys
     * @param array $existingKeys
     * @param bool $markUntranslated
     * @param bool $dryRun
     * @return int Number of keys synced
     */
    protected function syncKeys(string $language, string $file, array $englishKeys, array $existingKeys, bool $markUntranslated, bool $dryRun): int
    {
        $targetFilePath = base_path("lang/{$language}/{$file}.php");
        $syncedCount = 0;
        
        // Find missing keys and remove obsolete keys
        $missingKeys = [];
        $finalKeys = [];
        
        // First add all valid keys from the existing file
        foreach ($existingKeys as $key => $value) {
            if (isset($englishKeys[$key])) {
                $finalKeys[$key] = $value;
            } else {
                $syncedCount++; // Counting removed keys
            }
        }
        
        // Then add all missing keys from English
        foreach ($englishKeys as $key => $value) {
            if (!isset($existingKeys[$key])) {
                if ($markUntranslated && is_string($value)) {
                    $finalKeys[$key] = "UNTRANSLATED: {$value}";
                } else {
                    $finalKeys[$key] = $value;
                }
                $syncedCount++;
            }
        }
        
        if ($syncedCount > 0 && !$dryRun) {
            // Write back to file
            $content = "<?php\n\nreturn " . var_export($finalKeys, true) . ";\n";
            
            // Clean up the exported array format
            $content = $this->formatArrayOutput($content);
            
            File::put($targetFilePath, $content);
            
            $this->info("Synced {$syncedCount} keys in {$language}/{$file}.php");
        } elseif ($syncedCount > 0) {
            $this->info("Would sync {$syncedCount} keys in {$language}/{$file}.php");
        }
        
        return $syncedCount;
    }

    /**
     * Format the var_export output to be more readable.
     *
     * @param string $content
     * @return string
     */
    protected function formatArrayOutput(string $content): string
    {
        $content = str_replace("array (", "[", $content);
        $content = preg_replace('/\)(,?)$/', "]$1", $content);
        $content = preg_replace('/\s+=>\s+/', ' => ', $content);
        return $content;
    }

    /**
     * Calculate statistics for a language.
     *
     * @param array $englishTranslations
     * @param array $langTranslations
     * @return array
     */
    protected function calculateStats(array $englishTranslations, array $langTranslations): array
    {
        $translated = 0;
        $untranslated = 0;
        $missing = 0;
        
        foreach ($englishTranslations as $file => $keys) {
            if (!isset($langTranslations[$file])) {
                $missing += count($keys);
                continue;
            }
            
            foreach ($keys as $key => $value) {
                if (!isset($langTranslations[$file][$key])) {
                    $missing++;
                } elseif (is_string($langTranslations[$file][$key]) && 
                         strpos($langTranslations[$file][$key], 'UNTRANSLATED:') === 0) {
                    $untranslated++;
                } else {
                    $translated++;
                }
            }
        }
        
        $total = $translated + $untranslated + $missing;
        $progress = $total > 0 ? $translated / $total : 0;
        
        return [
            'translated' => $translated,
            'untranslated' => $untranslated,
            'missing' => $missing,
            'total' => $total,
            'progress' => $progress
        ];
    }

    /**
     * Count all translation strings in an array of files.
     *
     * @param array $translations
     * @return int
     */
    protected function countTranslationStrings(array $translations): int
    {
        $count = 0;
        
        foreach ($translations as $file => $keys) {
            $count += count($keys);
        }
        
        return $count;
    }

    /**
     * Get all translations for a specific language.
     *
     * @param string $language
     * @return array
     */
    protected function getLanguageTranslations(string $language): array
    {
        $translations = [];
        $langPath = base_path("lang/{$language}");
        
        if (!File::exists($langPath)) {
            if ($language !== 'all') {
                $this->warn("Language directory not found: {$langPath}");
            }
            return [];
        }
        
        // Skip blade compiler dependency by directly getting PHP files
        $files = glob("{$langPath}/*.php");
        
        foreach ($files as $file) {
            $filename = pathinfo($file, PATHINFO_FILENAME);
            try {
                $content = include $file;
                
                if (is_array($content)) {
                    $translations[$filename] = $content;
                }
            } catch (\Exception $e) {
                $this->error("Error loading file {$file}: " . $e->getMessage());
            }
        }
        
        return $translations;
    }

    /**
     * Get all language directories except the excluded one.
     *
     * @param string $excludeLanguage
     * @return array
     */
    protected function getLanguageDirectories(string $excludeLanguage = ''): array
    {
        $langPath = base_path('lang');
        $directories = File::directories($langPath);
        
        return array_filter(array_map(function ($path) {
            return basename($path);
        }, $directories), function ($dir) use ($excludeLanguage) {
            return ($excludeLanguage === '' || $dir !== $excludeLanguage) && 
                   preg_match('/^[a-z]{2}(?:-[A-Z]{2})?$/', $dir);
        });
    }
} 