<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;

class FlattenTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:flatten {--lang=all : Language to process (all for all languages)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flatten deeply nested translation keys to maintain "file.key" format';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lang = $this->option('lang');
        
        if ($lang === 'all') {
            $langPath = base_path('lang');
            $directories = File::directories($langPath);
            $languages = array_filter(array_map(function ($path) {
                return basename($path);
            }, $directories), function ($dir) {
                return preg_match('/^[a-z]{2}(?:-[A-Z]{2})?$/', $dir);
            });
        } else {
            $languages = [$lang];
        }
        
        foreach ($languages as $language) {
            $this->info("Processing language: {$language}");
            $this->processLanguage($language);
        }
        
        $this->info('Translation flattening completed!');
        return Command::SUCCESS;
    }
    
    /**
     * Process all translation files for a specific language.
     *
     * @param string $language
     * @return void
     */
    protected function processLanguage(string $language): void
    {
        $langPath = base_path("lang/{$language}");
        
        if (!File::exists($langPath)) {
            $this->error("Language directory not found: {$langPath}");
            return;
        }
        
        $files = Finder::create()->files()->in($langPath)->name('*.php');
        
        foreach ($files as $file) {
            $filename = $file->getFilenameWithoutExtension();
            $this->line("  Processing {$filename}.php...");
            
            $content = include $file->getRealPath();
            if (!is_array($content)) {
                $this->warn("  Skipping {$filename}.php: Not a valid translation array");
                continue;
            }
            
            $flattened = $this->flattenArray($content, $filename);
            
            if ($flattened !== $content) {
                $this->writeArrayToFile($langPath . '/' . $filename . '.php', $flattened);
                $this->info("  Flattened nested keys in {$filename}.php");
            } else {
                $this->line("  No nested keys found in {$filename}.php");
            }
        }
    }
    
    /**
     * Flatten a nested array of translations.
     *
     * @param array $array
     * @param string $prefix
     * @return array
     */
    protected function flattenArray(array $array, string $prefix = ''): array
    {
        $result = [];
        
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                // Found a nested array - we need to create new files for these
                $newFilename = $prefix . '_' . $key;
                $this->line("  Creating new file for nested key: {$newFilename}.php");
                
                // Create a new file for this nested structure
                $newFilePath = base_path("lang/{$this->option('lang')}/{$newFilename}.php");
                $this->writeArrayToFile($newFilePath, $value);
                
                // Replace the nested array with a note about where to find these translations
                $result[$key] = "See {$newFilename}.php file";
            } else {
                $result[$key] = $value;
            }
        }
        
        return $result;
    }
    
    /**
     * Write an array to a PHP file.
     *
     * @param string $filePath
     * @param array $array
     * @return void
     */
    protected function writeArrayToFile(string $filePath, array $array): void
    {
        $content = "<?php\n\nreturn " . var_export($array, true) . ";\n";
        
        // Clean up the exported array format to make it more readable
        $content = preg_replace('/array \(/', '[', $content);
        $content = preg_replace('/\)(,?)$/', ']$1', $content);
        $content = preg_replace('/\s+=>\s+/', ' => ', $content);
        
        File::put($filePath, $content);
    }
} 