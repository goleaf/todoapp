<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;

class TranslationReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:report
                            {--output= : Path to save the report as JSON}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a report on translation completeness for all languages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating translation report...');
        
        // Get English translations as the base
        $englishTranslations = $this->getLanguageTranslations('en');
        $englishTotal = $this->countTranslationStrings($englishTranslations);
        
        // Get all language directories
        $languages = $this->getLanguageDirectories();
        
        $this->info('Found ' . count($languages) . ' languages: ' . implode(', ', $languages));
        $this->info('Base language (en) has ' . $englishTotal . ' translation strings');
        
        $report = [
            'timestamp' => now()->toIso8601String(),
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
        
        return Command::SUCCESS;
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
     * Get all language directories.
     *
     * @return array
     */
    protected function getLanguageDirectories(): array
    {
        $langPath = base_path('lang');
        $directories = File::directories($langPath);
        
        return array_filter(array_map(function ($path) {
            return basename($path);
        }, $directories), function ($dir) {
            return preg_match('/^[a-z]{2}(?:-[A-Z]{2})?$/', $dir);
        });
    }
} 