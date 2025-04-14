<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;

class ScanTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:scan {--output= : Output file for missing translations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan blade files for translatable strings and identify missing translations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Scanning blade files for translatable strings...');
        
        // Get all language files and their keys
        $existingTranslations = $this->getExistingTranslations();
        
        // Scan blade files for translation keys
        $usedTranslations = $this->scanBladeFiles();
        
        // Find missing translations
        $missingTranslations = $this->findMissingTranslations($usedTranslations, $existingTranslations);
        
        // Output results
        $this->outputResults($missingTranslations);
        
        return Command::SUCCESS;
    }
    
    /**
     * Get all existing translations from language files.
     *
     * @return array
     */
    protected function getExistingTranslations(): array
    {
        $translations = [];
        $langPath = base_path('lang/en'); // Use English as the base language
        
        if (!File::exists($langPath)) {
            $this->error('Base language directory not found: ' . $langPath);
            return [];
        }
        
        $files = Finder::create()->files()->in($langPath)->name('*.php');
        
        foreach ($files as $file) {
            $filename = $file->getFilenameWithoutExtension();
            $content = include $file->getRealPath();
            
            if (is_array($content)) {
                foreach ($content as $key => $value) {
                    $translations[$filename . '.' . $key] = true;
                }
            }
        }
        
        return $translations;
    }
    
    /**
     * Scan blade files for translation keys.
     *
     * @return array
     */
    protected function scanBladeFiles(): array
    {
        $usedTranslations = [];
        $viewsPath = resource_path('views');
        
        $files = Finder::create()
            ->files()
            ->in($viewsPath)
            ->name('*.blade.php');
        
        $pattern = '/__\([\'"]([^\'"]+)[\'"](,|\))/';
        
        foreach ($files as $file) {
            $content = File::get($file->getRealPath());
            
            if (preg_match_all($pattern, $content, $matches)) {
                foreach ($matches[1] as $match) {
                    $usedTranslations[$match] = $file->getRelativePathname();
                }
            }
        }
        
        return $usedTranslations;
    }
    
    /**
     * Find missing translations.
     *
     * @param array $usedTranslations
     * @param array $existingTranslations
     * @return array
     */
    protected function findMissingTranslations(array $usedTranslations, array $existingTranslations): array
    {
        $missing = [];
        
        foreach ($usedTranslations as $key => $file) {
            if (!isset($existingTranslations[$key])) {
                $missing[$key] = $file;
            }
        }
        
        return $missing;
    }
    
    /**
     * Output the results.
     *
     * @param array $missingTranslations
     * @return void
     */
    protected function outputResults(array $missingTranslations): void
    {
        if (empty($missingTranslations)) {
            $this->info('No missing translations found!');
            return;
        }
        
        $this->warn('Missing translations:');
        $this->table(['Translation Key', 'Used In'], array_map(function ($key, $file) {
            return [$key, $file];
        }, array_keys($missingTranslations), array_values($missingTranslations)));
        
        $outputFile = $this->option('output');
        if ($outputFile) {
            $output = [];
            
            foreach ($missingTranslations as $key => $file) {
                $parts = explode('.', $key, 2);
                if (count($parts) === 2) {
                    $filename = $parts[0];
                    $translationKey = $parts[1];
                    
                    if (!isset($output[$filename])) {
                        $output[$filename] = [];
                    }
                    
                    $output[$filename][$translationKey] = '';
                }
            }
            
            $content = "<?php\n\n// Missing translations found by translations:scan command\n\nreturn " . var_export($output, true) . ";\n";
            File::put($outputFile, $content);
            
            $this->info('Missing translations exported to: ' . $outputFile);
        }
    }
} 