<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;

class FindTranslatableStrings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:find {--export= : Export found strings to a translation file with this name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find hardcoded strings in blade templates and PHP files that should be translated';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Scanning for hardcoded strings...');

        $bladeStrings = $this->findHardcodedStringsInBlades();
        $phpStrings = $this->findHardcodedStringsInPhpFiles();
        
        $totalFound = count($bladeStrings) + count($phpStrings);
        
        if ($totalFound === 0) {
            $this->info('No hardcoded strings found.');
            return 0;
        }
        
        $this->info("Found {$totalFound} potentially hardcoded strings:");
        
        $this->output->newLine();
        $this->info('In blade templates:');
        foreach ($bladeStrings as $file => $strings) {
            $this->output->writeln("<comment>{$file}:</comment>");
            foreach ($strings as $index => $string) {
                $this->output->writeln("  - " . $string);
            }
        }
        
        $this->output->newLine();
        $this->info('In PHP files:');
        foreach ($phpStrings as $file => $strings) {
            $this->output->writeln("<comment>{$file}:</comment>");
            foreach ($strings as $index => $string) {
                $this->output->writeln("  - " . $string);
            }
        }
        
        $exportFile = $this->option('export');
        if ($exportFile) {
            $this->exportTranslations($exportFile, array_merge($bladeStrings, $phpStrings));
        }
        
        return 0;
    }
    
    /**
     * Find hardcoded strings in blade templates.
     *
     * @return array
     */
    protected function findHardcodedStringsInBlades(): array
    {
        $strings = [];
        
        $finder = new Finder();
        $finder->files()->in(resource_path('views'))->name('*.blade.php');
        
        foreach ($finder as $file) {
            $content = $file->getContents();
            
            // Find all hardcoded strings that aren't already wrapped in translation functions
            // Pattern matches strings inside HTML tags, but skips those inside {{ __ }} or {{ trans }} or @lang
            preg_match_all('/(?<!=\s*["\']\s*|{{\s*__|{{\s*trans|@lang\()["\']([^"\']+)["\'](?!\s*\)\s*}}|\)\s*\}}|,)/', $content, $matches, PREG_SET_ORDER);
            
            $fileStrings = [];
            foreach ($matches as $match) {
                $string = $match[1];
                
                // Only include if it looks like translatable text (more than 2 words or contains special chars)
                if (str_word_count($string) > 2 || preg_match('/[:;,.!?]/', $string)) {
                    $fileStrings[] = $string;
                }
            }
            
            if (!empty($fileStrings)) {
                $relativePath = $file->getRelativePathname();
                $strings[$relativePath] = $fileStrings;
            }
        }
        
        return $strings;
    }
    
    /**
     * Find hardcoded strings in PHP files.
     *
     * @return array
     */
    protected function findHardcodedStringsInPhpFiles(): array
    {
        $strings = [];
        
        $finder = new Finder();
        $finder->files()->in(app_path())->name('*.php');
        
        foreach ($finder as $file) {
            $content = $file->getContents();
            
            // Skip language files
            if (strpos($file->getPathname(), 'lang') !== false) {
                continue;
            }
            
            // Find strings in returns, echo, etc. that aren't already translated
            preg_match_all('/(?<!=\s*|\s*__\(|\s*trans\()["\']([^"\']+)["\'](?!\s*\)\s*;)/', $content, $matches, PREG_SET_ORDER);
            
            $fileStrings = [];
            foreach ($matches as $match) {
                $string = $match[1];
                
                // Only include if it looks like translatable text (more than 2 words or contains special chars)
                if (str_word_count($string) > 2 || preg_match('/[:;,.!?]/', $string)) {
                    $fileStrings[] = $string;
                }
            }
            
            if (!empty($fileStrings)) {
                $relativePath = str_replace(app_path() . '/', '', $file->getPathname());
                $strings[$relativePath] = $fileStrings;
            }
        }
        
        return $strings;
    }
    
    /**
     * Export found strings to a translation file.
     *
     * @param string $filename
     * @param array $allStrings
     * @return void
     */
    protected function exportTranslations(string $filename, array $allStrings): void
    {
        $langPath = base_path('lang/en');
        $filePath = $langPath . '/' . $filename . '.php';
        
        $translations = [];
        
        // Flatten all strings and create translation keys
        foreach ($allStrings as $file => $strings) {
            foreach ($strings as $string) {
                $key = $this->createTranslationKey($string);
                $translations[$key] = $string;
            }
        }
        
        // Check if file exists and merge with existing content
        if (File::exists($filePath)) {
            $existingContent = require $filePath;
            $translations = array_merge($existingContent, $translations);
        }
        
        // Export as PHP array
        $fileContent = "<?php\n\nreturn " . var_export($translations, true) . ";\n";
        
        // Clean up the exported array format
        $fileContent = preg_replace('/array \(/', '[', $fileContent);
        $fileContent = preg_replace('/\)(,?)$/', ']$1', $fileContent);
        $fileContent = preg_replace('/\s+=>\s+/', ' => ', $fileContent);
        
        File::put($filePath, $fileContent);
        
        $this->info("Exported " . count($translations) . " translations to {$filePath}");
    }
    
    /**
     * Create a translation key from a string.
     *
     * @param string $string
     * @return string
     */
    protected function createTranslationKey(string $string): string
    {
        // Convert string to snake_case
        $key = strtolower($string);
        $key = preg_replace('/[^a-z0-9\s]/', '', $key);
        $key = preg_replace('/\s+/', '_', $key);
        
        // Truncate to max 50 chars
        if (strlen($key) > 50) {
            $key = substr($key, 0, 47) . '...';
        }
        
        return $key;
    }
} 