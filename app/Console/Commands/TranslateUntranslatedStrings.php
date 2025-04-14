<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Finder\Finder;

class TranslateUntranslatedStrings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:translate
                           {--language=all : Specific language code to translate}
                           {--api-key= : Google Translate API key}
                           {--delay=1 : Delay between API requests in seconds}
                           {--max-strings=100 : Maximum number of strings to translate per language}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Translate untranslated strings using Google Translate API';

    /**
     * Language codes mapping for Google Translate API.
     *
     * @var array
     */
    protected $languageMapping = [
        'en' => 'en',    // English
        'fr' => 'fr',    // French
        'es' => 'es',    // Spanish
        'de' => 'de',    // German
        'it' => 'it',    // Italian
        'ru' => 'ru',    // Russian
        'ja' => 'ja',    // Japanese
        'zh' => 'zh-CN', // Chinese (Simplified)
        'lt' => 'lt'     // Lithuanian
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $language = $this->option('language');
        $apiKey = $this->option('api-key');
        $delay = (int) $this->option('delay');
        $maxStrings = (int) $this->option('max-strings');
        
        if (empty($apiKey)) {
            $this->error('API key is required. Use --api-key option.');
            return Command::FAILURE;
        }
        
        // Get English translations as the base
        $englishTranslations = $this->getLanguageTranslations('en');
        
        if ($language === 'all') {
            // Get all language directories except English
            $languages = $this->getLanguageDirectories('en');
        } else {
            $languages = [$language];
        }
        
        $this->info('Translating strings for: ' . implode(', ', $languages));
        
        $totalTranslated = 0;
        
        foreach ($languages as $lang) {
            if (!isset($this->languageMapping[$lang])) {
                $this->warn("Language {$lang} not supported for translation. Skipping.");
                continue;
            }
            
            $targetLanguageCode = $this->languageMapping[$lang];
            
            $this->info("\n====== Language: {$lang} ({$targetLanguageCode}) ======");
            
            // Get translations for the current language
            $langTranslations = $this->getLanguageTranslations($lang);
            
            $translatedCount = 0;
            
            // Process each file
            foreach ($englishTranslations as $file => $keys) {
                if (!isset($langTranslations[$file])) {
                    continue; // Skip files that don't exist
                }
                
                $untranslatedStrings = [];
                
                // Find untranslated strings
                foreach ($keys as $key => $enValue) {
                    if (isset($langTranslations[$file][$key]) && 
                        is_string($langTranslations[$file][$key]) && 
                        strpos($langTranslations[$file][$key], 'UNTRANSLATED:') === 0) {
                        $untranslatedStrings[$key] = $enValue;
                    }
                }
                
                if (empty($untranslatedStrings)) {
                    continue;
                }
                
                $this->info("Translating {$file}.php - Found " . count($untranslatedStrings) . " untranslated strings");
                
                // Limit the number of strings to translate
                $untranslatedStrings = array_slice($untranslatedStrings, 0, $maxStrings - $translatedCount, true);
                
                if (empty($untranslatedStrings)) {
                    $this->warn("Reached maximum translation limit. Skipping remaining strings.");
                    break;
                }
                
                // Translate and update
                $translatedFile = $this->translateFile($lang, $file, $untranslatedStrings, $langTranslations[$file], $apiKey, $targetLanguageCode, $delay);
                $translatedCount += $translatedFile;
                $totalTranslated += $translatedFile;
                
                if ($translatedCount >= $maxStrings) {
                    $this->warn("Reached maximum translation limit. Skipping remaining files.");
                    break;
                }
            }
            
            $this->info("Total translated strings in {$lang}: {$translatedCount}");
        }
        
        $this->info("\n====== Summary ======");
        $this->info("Total translated strings: {$totalTranslated}");
        
        return Command::SUCCESS;
    }
    
    /**
     * Translate strings in a file.
     *
     * @param string $language
     * @param string $file
     * @param array $untranslatedStrings
     * @param array $existingTranslations
     * @param string $apiKey
     * @param string $targetLanguageCode
     * @param int $delay
     * @return int Number of strings translated
     */
    protected function translateFile(string $language, string $file, array $untranslatedStrings, array $existingTranslations, string $apiKey, string $targetLanguageCode, int $delay): int
    {
        $targetFilePath = base_path("lang/{$language}/{$file}.php");
        $translatedCount = 0;
        $updatedTranslations = $existingTranslations;
        
        $bar = $this->output->createProgressBar(count($untranslatedStrings));
        $bar->start();
        
        foreach ($untranslatedStrings as $key => $value) {
            if (!is_string($value)) {
                $bar->advance();
                continue; // Skip non-string values
            }
            
            try {
                $translatedText = $this->translateText($value, $apiKey, $targetLanguageCode);
                
                if ($translatedText) {
                    $updatedTranslations[$key] = $translatedText;
                    $translatedCount++;
                }
            } catch (\Exception $e) {
                $this->error("\nError translating '{$key}': " . $e->getMessage());
            }
            
            $bar->advance();
            
            if ($delay > 0) {
                sleep($delay); // Avoid API rate limits
            }
        }
        
        $bar->finish();
        $this->line('');
        
        if ($translatedCount > 0) {
            // Write back to file
            $content = "<?php\n\nreturn " . var_export($updatedTranslations, true) . ";\n";
            
            // Clean up the exported array format to make it more readable
            $content = str_replace("array (", "[", $content);
            $content = preg_replace('/\)(,?)$/', "]$1", $content);
            $content = preg_replace('/\s+=>\s+/', ' => ', $content);
            
            File::put($targetFilePath, $content);
            
            $this->info("Updated {$language}/{$file}.php with {$translatedCount} translated strings");
        }
        
        return $translatedCount;
    }
    
    /**
     * Translate text using Google Translate API.
     *
     * @param string $text
     * @param string $apiKey
     * @param string $targetLanguage
     * @return string|null
     */
    protected function translateText(string $text, string $apiKey, string $targetLanguage): ?string
    {
        // Clean text - remove UNTRANSLATED prefix if it exists
        $originalText = preg_replace('/^UNTRANSLATED:\s*/', '', $text);
        
        // Don't translate placeholders like :attribute or {variable}
        $placeholders = [];
        $pattern = '/(:[\w]+|\{[\w]+\})/';
        $cleanText = preg_replace_callback($pattern, function($matches) use (&$placeholders) {
            $placeholder = "PLACEHOLDER" . count($placeholders);
            $placeholders[$placeholder] = $matches[0];
            return $placeholder;
        }, $originalText);
        
        // Google Translate API endpoint
        $response = Http::get('https://translation.googleapis.com/language/translate/v2', [
            'key' => $apiKey,
            'q' => $cleanText,
            'target' => $targetLanguage,
            'format' => 'text'
        ]);
        
        if ($response->successful() && isset($response['data']['translations'][0]['translatedText'])) {
            $translatedText = $response['data']['translations'][0]['translatedText'];
            
            // Restore placeholders
            foreach ($placeholders as $placeholder => $original) {
                $translatedText = str_replace($placeholder, $original, $translatedText);
            }
            
            return $translatedText;
        }
        
        return null;
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