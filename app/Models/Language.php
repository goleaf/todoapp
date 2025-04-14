<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Language extends Model
{
    protected $fillable = [
        'code',
        'name',
        'is_active',
        'is_default',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    /**
     * Get all available languages from the filesystem.
     *
     * @return array
     */
    public static function getAvailableLanguages(): array
    {
        $langPath = base_path('lang');
        $directories = File::exists($langPath) ? File::directories($langPath) : [];
        
        $languages = [];
        foreach ($directories as $directory) {
            $langCode = basename($directory);
            
            // Skip non-language directories
            if (!preg_match('/^[a-z]{2}(?:-[A-Z]{2})?$/', $langCode)) {
                continue;
            }
            
            $nativeName = \Locale::getDisplayName($langCode, $langCode);
            $englishName = \Locale::getDisplayName($langCode, 'en');
            
            $languages[$langCode] = [
                'code' => $langCode,
                'native' => $nativeName,
                'english' => $englishName,
            ];
        }
        
        return $languages;
    }

    /**
     * Get translation files for a specific language.
     *
     * @param string $langCode
     * @return array
     */
    public static function getLanguageFiles(string $langCode): array
    {
        $langPath = base_path("lang/{$langCode}");
        
        if (!File::exists($langPath)) {
            return [];
        }
        
        $files = File::files($langPath);
        $result = [];
        
        foreach ($files as $file) {
            if ($file->getExtension() === 'php') {
                $filename = $file->getFilenameWithoutExtension();
                $result[$filename] = $file->getRealPath();
            }
        }
        
        return $result;
    }

    /**
     * Get the content of a specific translation file.
     *
     * @param string $langCode
     * @param string $filename
     * @return array|null
     */
    public static function getFileContent(string $langCode, string $filename): ?array
    {
        $filePath = base_path("lang/{$langCode}/{$filename}.php");
        
        if (!File::exists($filePath)) {
            return null;
        }
        
        $content = include $filePath;
        return is_array($content) ? $content : null;
    }

    /**
     * Save translation file content.
     * Ensures translations are stored in a flat structure without nesting.
     *
     * @param string $langCode
     * @param string $filename
     * @param array $content
     * @return bool
     */
    public static function saveFileContent(string $langCode, string $filename, array $content): bool
    {
        $filePath = base_path("lang/{$langCode}/{$filename}.php");
        $directoryPath = dirname($filePath);
        
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }
        
        // Ensure we have a flat array
        $flatContent = [];
        foreach ($content as $key => $value) {
            // If the value is an array, we don't want to flatten it further
            // We'll convert it to JSON to maintain a flat structure
            if (is_array($value)) {
                $flatContent[$key] = json_encode($value);
            } else {
                $flatContent[$key] = $value;
            }
        }
        
        // Export the array in a cleaner format
        $arrayExport = var_export($flatContent, true);
        $arrayExport = preg_replace('/array \(/', '[', $arrayExport);
        $arrayExport = preg_replace('/\)(,?)$/', ']$1', $arrayExport);
        $arrayExport = preg_replace('/\s+=>\s+/', ' => ', $arrayExport);
        
        $fileContent = "<?php\n\nreturn {$arrayExport};\n";
        
        return (bool) File::put($filePath, $fileContent);
    }

    /**
     * Create a new language directory.
     *
     * @param string $langCode
     * @return bool
     */
    public static function createLanguage(string $langCode): bool
    {
        $langPath = base_path("lang/{$langCode}");
        
        if (File::exists($langPath)) {
            return false; // Language already exists
        }
        
        File::makeDirectory($langPath, 0755, true);
        
        // Copy English files as templates
        $enPath = base_path("lang/en");
        if (File::exists($enPath)) {
            foreach (File::files($enPath) as $file) {
                if ($file->getExtension() === 'php') {
                    File::copy($file->getRealPath(), "{$langPath}/{$file->getFilename()}");
                }
            }
        } else {
            // Create a common.php file with at least the language name
            $content = [
                'language_name' => \Locale::getDisplayName($langCode, $langCode),
            ];
            
            self::saveFileContent($langCode, 'common', $content);
        }
        
        return true;
    }

    /**
     * Delete a language directory.
     *
     * @param string $langCode
     * @return bool
     */
    public static function deleteLanguage(string $langCode): bool
    {
        // Don't allow deleting the default language
        if ($langCode === config('app.fallback_locale')) {
            return false;
        }
        
        $langPath = base_path("lang/{$langCode}");
        
        if (!File::exists($langPath)) {
            return false; // Language doesn't exist
        }
        
        return File::deleteDirectory($langPath);
    }
    
    /**
     * Import missing keys from one language to another.
     *
     * @param string $fromLangCode
     * @param string $toLangCode
     * @return int Number of imported keys
     */
    public static function importMissingKeys(string $fromLangCode, string $toLangCode): int
    {
        $fromPath = base_path("lang/{$fromLangCode}");
        $toPath = base_path("lang/{$toLangCode}");
        
        if (!File::exists($fromPath) || !File::exists($toPath)) {
            return 0;
        }
        
        $importedCount = 0;
        
        foreach (File::files($fromPath) as $file) {
            if ($file->getExtension() === 'php') {
                $filename = $file->getFilenameWithoutExtension();
                $fromContent = self::getFileContent($fromLangCode, $filename) ?? [];
                $toContent = self::getFileContent($toLangCode, $filename) ?? [];
                
                $updated = false;
                
                foreach ($fromContent as $key => $value) {
                    if (!isset($toContent[$key])) {
                        $toContent[$key] = $value;
                        $updated = true;
                        $importedCount++;
                    }
                }
                
                if ($updated) {
                    self::saveFileContent($toLangCode, $filename, $toContent);
                }
            }
        }
        
        return $importedCount;
    }
} 