<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TranslationHelper
{
    /**
     * Convert a string to a valid translation key.
     *
     * @param string $string
     * @return string
     */
    public static function stringToKey(string $string): string
    {
        // Normalize the string: lowercase, no special chars, underscores for spaces
        $key = Str::of($string)
            ->lower()
            ->replaceMatches('/[^\w\s]/', '') // Remove special characters
            ->replace(' ', '_')              // Replace spaces with underscores
            ->limit(50, '');                 // Limit length
            
        return $key;
    }
    
    /**
     * Add a new translation key to a specific file.
     *
     * @param string $file
     * @param string $key
     * @param string $value
     * @param string $locale
     * @return bool
     */
    public static function addTranslation(string $file, string $key, string $value, string $locale = 'en'): bool
    {
        $langPath = base_path("lang/{$locale}");
        
        if (!File::exists($langPath)) {
            return false;
        }
        
        $filePath = "{$langPath}/{$file}.php";
        
        // Initialize with empty array if file doesn't exist
        if (!File::exists($filePath)) {
            $translations = [];
        } else {
            $translations = include $filePath;
            if (!is_array($translations)) {
                $translations = [];
            }
        }
        
        // Add the new translation
        $translations[$key] = $value;
        
        // Write the file
        $content = "<?php\n\nreturn " . var_export($translations, true) . ";\n";
        
        // Clean up the format
        $content = preg_replace('/array \(/', '[', $content);
        $content = preg_replace('/\)(,?)$/', ']$1', $content);
        $content = preg_replace('/\s+=>\s+/', ' => ', $content);
        
        return (bool) File::put($filePath, $content);
    }
    
    /**
     * Find the most appropriate translation file for a string.
     *
     * @param string $string
     * @param string $section
     * @return string
     */
    public static function guessTranslationFile(string $string, string $section = null): string
    {
        // Default files based on content type
        $commonPhrases = ['yes', 'no', 'ok', 'cancel', 'save', 'delete', 'edit', 'create', 'update', 'view'];
        
        // If section is specified, use it
        if ($section) {
            return $section;
        }
        
        // Try to guess based on the string content
        $lower = strtolower($string);
        
        if (in_array($lower, $commonPhrases)) {
            return 'common';
        }
        
        if (strpos($lower, 'error') !== false || strpos($lower, 'failed') !== false) {
            return 'messages';
        }
        
        if (strpos($lower, 'login') !== false || strpos($lower, 'register') !== false || 
            strpos($lower, 'password') !== false || strpos($lower, 'email') !== false) {
            return 'auth';
        }
        
        // Default to common for unclassified strings
        return 'common';
    }
    
    /**
     * List available languages with their native names.
     *
     * @return array
     */
    public static function getAvailableLanguages(): array
    {
        $langPath = base_path('lang');
        $directories = File::directories($langPath);
        
        $languages = [];
        foreach ($directories as $directory) {
            $langCode = basename($directory);
            
            // Skip non-language directories
            if (!preg_match('/^[a-z]{2}(?:-[A-Z]{2})?$/', $langCode)) {
                continue;
            }
            
            // Get the language name
            $languages[$langCode] = self::getLanguageName($langCode);
        }
        
        return $languages;
    }
    
    /**
     * Get the native name of a language.
     *
     * @param string $langCode
     * @return string
     */
    public static function getLanguageName(string $langCode): string
    {
        $langNames = [
            'en' => 'English',
            'fr' => 'Français',
            'es' => 'Español',
            'de' => 'Deutsch',
            'it' => 'Italiano',
            'pt' => 'Português',
            'ru' => 'Русский',
            'zh' => '中文',
            'ja' => '日本語',
            'lt' => 'Lietuvių',
        ];
        
        // Check if we have the language name in common.php
        $commonFile = base_path("lang/{$langCode}/common.php");
        if (File::exists($commonFile)) {
            $translations = include $commonFile;
            if (isset($translations['language_name'])) {
                return $translations['language_name'];
            }
        }
        
        // Return from our hardcoded list or default to the code
        return $langNames[$langCode] ?? ucfirst($langCode);
    }
} 