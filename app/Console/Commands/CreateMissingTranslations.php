<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;

class CreateMissingTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:create-missing 
                            {--language=all : Specific language code to update}
                            {--mark-untranslated : Mark untranslated strings with UNTRANSLATED prefix}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create missing translation files and keys based on English translations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $language = $this->option('language');
        $markUntranslated = $this->option('mark-untranslated');
        
        // Get English translations as the base
        $englishTranslations = $this->getLanguageTranslations('en');
        
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
        
        return Command::SUCCESS;
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
        $content = str_replace("array (", "[", $content);
        $content = preg_replace('/\)(,?)$/', "]$1", $content);
        $content = preg_replace('/\s+=>\s+/', ' => ', $content);
        
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
            
            // Clean up the exported array format to make it more readable
            $content = str_replace("array (", "[", $content);
            $content = preg_replace('/\)(,?)$/', "]$1", $content);
            $content = preg_replace('/\s+=>\s+/', ' => ', $content);
            
            File::put($targetFilePath, $content);
            
            $this->info("Added {$addedCount} missing keys to {$language}/{$file}.php");
        }
        
        return $addedCount;
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
            return [];
        }
        
        // Skip blade compiler dependency by directly getting PHP files
        $files = File::files($langPath);
        
        foreach ($files as $file) {
            if ($file->getExtension() === 'php') {
                $filename = $file->getFilenameWithoutExtension();
                try {
                    $content = include $file->getRealPath();
                    
                    if (is_array($content)) {
                        $translations[$filename] = $content;
                    }
                } catch (\Exception $e) {
                    $this->error("Error loading file {$file->getRealPath()}: " . $e->getMessage());
                }
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
    protected function getLanguageDirectories(string $excludeLanguage): array
    {
        $langPath = base_path('lang');
        $directories = File::directories($langPath);
        
        return array_filter(array_map(function ($path) {
            return basename($path);
        }, $directories), function ($dir) use ($excludeLanguage) {
            return $dir !== $excludeLanguage && preg_match('/^[a-z]{2}(?:-[A-Z]{2})?$/', $dir);
        });
    }
} 