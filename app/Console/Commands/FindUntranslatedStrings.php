<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;

class FindUntranslatedStrings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:find-untranslated {--language=all : Specific language code to check}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find untranslated strings in language files compared to English';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $language = $this->option('language');
        
        // Get English translations as the base
        $englishTranslations = $this->getLanguageTranslations('en');
        
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
        
        return Command::SUCCESS;
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
            $this->error("Language directory not found: {$langPath}");
            return [];
        }
        
        $files = Finder::create()->files()->in($langPath)->name('*.php');
        
        foreach ($files as $file) {
            $filename = $file->getFilenameWithoutExtension();
            $content = include $file->getRealPath();
            
            if (is_array($content)) {
                $translations[$filename] = $content;
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