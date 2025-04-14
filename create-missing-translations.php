<?php

/**
 * Create Missing Translations
 * 
 * This script creates missing translation files and marks untranslated strings.
 * Run: php create-missing-translations.php [language] [--mark-untranslated]
 * 
 * Examples:
 *   php create-missing-translations.php              # Process all languages
 *   php create-missing-translations.php fr           # Process only French
 *   php create-missing-translations.php fr mark      # Process French and mark untranslated
 */

// Parse arguments
$targetLanguage = $argv[1] ?? 'all';
$markUntranslated = isset($argv[2]) && $argv[2] === 'mark';

// Config
$baseLanguage = 'en';
$langPath = __DIR__ . '/lang';

// Functions
function getLanguageDirectories($langPath, $excludeLanguage = '') {
    $directories = array_filter(glob($langPath . '/*'), 'is_dir');
    
    return array_filter(array_map(function ($path) {
        return basename($path);
    }, $directories), function ($dir) use ($excludeLanguage) {
        return $dir !== $excludeLanguage && preg_match('/^[a-z]{2}(?:-[A-Z]{2})?$/', $dir);
    });
}

function getLanguageTranslations($langPath, $language) {
    $translations = [];
    $fullPath = $langPath . '/' . $language;
    
    if (!file_exists($fullPath) || !is_dir($fullPath)) {
        return [];
    }
    
    $files = glob($fullPath . '/*.php');
    
    foreach ($files as $file) {
        $filename = basename($file, '.php');
        try {
            $content = include $file;
            
            if (is_array($content)) {
                $translations[$filename] = $content;
            }
        } catch (Exception $e) {
            echo "Error loading file {$file}: " . $e->getMessage() . "\n";
        }
    }
    
    return $translations;
}

function createTranslationFile($langPath, $language, $file, $keys, $markUntranslated) {
    $targetDir = $langPath . '/' . $language;
    $targetFilePath = $targetDir . '/' . $file . '.php';
    
    // Create language directory if it doesn't exist
    if (!file_exists($targetDir)) {
        if (!mkdir($targetDir, 0755, true)) {
            echo "Failed to create directory: {$targetDir}\n";
            return false;
        }
        echo "Created new language directory: {$language}\n";
    }
    
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
    
    if (file_put_contents($targetFilePath, $content)) {
        echo "Created new translation file: {$language}/{$file}.php with " . count($keys) . " keys\n";
        return true;
    } else {
        echo "Failed to write file: {$targetFilePath}\n";
        return false;
    }
}

function addMissingKeys($langPath, $language, $file, $englishKeys, $existingKeys, $markUntranslated) {
    $targetFilePath = $langPath . '/' . $language . '/' . $file . '.php';
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
        
        if (file_put_contents($targetFilePath, $content)) {
            echo "Added {$addedCount} missing keys to {$language}/{$file}.php\n";
        } else {
            echo "Failed to update file: {$targetFilePath}\n";
        }
    }
    
    return $addedCount;
}

// Main Script
echo "Creating missing translations...\n";

// Get English translations as the base
$englishTranslations = getLanguageTranslations($langPath, $baseLanguage);

// Get languages to process
$languages = [];
if ($targetLanguage === 'all') {
    $languages = getLanguageDirectories($langPath, $baseLanguage);
} else {
    $languages = [$targetLanguage];
    
    // Create new language directory if needed
    if (!in_array($targetLanguage, array_merge([$baseLanguage], getLanguageDirectories($langPath)))) {
        $newLangDir = $langPath . '/' . $targetLanguage;
        if (!file_exists($newLangDir)) {
            if (mkdir($newLangDir, 0755, true)) {
                echo "Created new language directory: {$targetLanguage}\n";
            }
        }
    }
}

echo "Processing languages: " . implode(', ', $languages) . "\n";
echo "Marking untranslated strings: " . ($markUntranslated ? "Yes" : "No") . "\n\n";

$totalCreatedFiles = 0;
$totalAddedKeys = 0;

foreach ($languages as $lang) {
    echo "\n====== Language: {$lang} ======\n";
    
    // Get translations for the current language
    $langTranslations = getLanguageTranslations($langPath, $lang);
    
    // Find and create missing translation files
    $missingFiles = array_diff(array_keys($englishTranslations), array_keys($langTranslations));
    foreach ($missingFiles as $file) {
        if (createTranslationFile($langPath, $lang, $file, $englishTranslations[$file], $markUntranslated)) {
            $totalCreatedFiles++;
        }
    }
    
    // Add missing keys to existing files
    foreach ($englishTranslations as $file => $keys) {
        if (!isset($langTranslations[$file])) {
            continue; // Skip files that were just created
        }
        
        $addedKeys = addMissingKeys($langPath, $lang, $file, $keys, $langTranslations[$file], $markUntranslated);
        $totalAddedKeys += $addedKeys;
    }
}

echo "\n====== Summary ======\n";
echo "Total created files: {$totalCreatedFiles}\n";
echo "Total added keys: {$totalAddedKeys}\n"; 