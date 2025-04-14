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
            
            // Get the language name from the common.php file
            $langName = $langCode;
            $commonFile = $directory . '/common.php';
            if (File::exists($commonFile)) {
                $translations = include $commonFile;
                if (is_array($translations) && isset($translations['language_name'])) {
                    $langName = $translations['language_name'];
                }
            }
            
            $languages[$langCode] = [
                'code' => $langCode,
                'name' => $langName,
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
     * Ensures translations are stored in a flat structure (file.value) without deep nesting.
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
        
        // Flatten nested arrays to ensure we only have file.value format
        $flatContent = self::flattenArray($content);
        
        $fileContent = "<?php\n\nreturn " . var_export($flatContent, true) . ";\n";
        
        // Clean up the exported array format
        $fileContent = preg_replace('/array \(/', '[', $fileContent);
        $fileContent = preg_replace('/\)(,?)$/', ']$1', $fileContent);
        $fileContent = preg_replace('/\s+=>\s+/', ' => ', $fileContent);
        
        return (bool) File::put($filePath, $fileContent);
    }

    /**
     * Flatten a nested array into a single level with dot notation keys.
     * Only flattens one level to ensure we maintain file.value format without going deeper.
     *
     * @param array $array
     * @param string $prefix
     * @return array
     */
    protected static function flattenArray(array $array, string $prefix = ''): array
    {
        $result = [];
        
        foreach ($array as $key => $value) {
            if (is_array($value) && !empty($value)) {
                // We only flatten one level to maintain file.value format
                foreach ($value as $subKey => $subValue) {
                    if (is_array($subValue)) {
                        // If there's another nested array, we convert it to JSON to avoid deep nesting
                        $result[$key . '.' . $subKey] = json_encode($subValue);
                    } else {
                        $result[$key . '.' . $subKey] = $subValue;
                    }
                }
            } else {
                $result[$key] = $value;
            }
        }
        
        return $result;
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
        
        // Create a common.php file with at least the language name
        $content = [
            'language_name' => ucfirst($langCode), // Default name, should be replaced with proper name
            'language_names' => [
                'en' => 'English',
                $langCode => ucfirst($langCode),
            ],
        ];
        
        return self::saveFileContent($langCode, 'common', $content);
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
} 