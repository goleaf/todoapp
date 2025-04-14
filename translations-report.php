<?php

/**
 * Translation Report Generator
 * 
 * This script analyzes translation files and generates a report on their completeness.
 * Run: php translations-report.php [output.json]
 */

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
        echo "Language directory not found: {$fullPath}\n";
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

function countTranslationStrings($translations) {
    $count = 0;
    
    foreach ($translations as $file => $keys) {
        $count += count($keys);
    }
    
    return $count;
}

function calculateStats($englishTranslations, $langTranslations) {
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

// Main Script
echo "Generating translation report...\n";

// Get English translations as the base
$englishTranslations = getLanguageTranslations($langPath, $baseLanguage);
$englishTotal = countTranslationStrings($englishTranslations);

// Get all language directories
$languages = getLanguageDirectories($langPath);

echo "Found " . count($languages) . " languages: " . implode(', ', $languages) . "\n";
echo "Base language (en) has " . $englishTotal . " translation strings\n\n";

$report = [
    'timestamp' => date('c'), // ISO 8601 date
    'base_language' => $baseLanguage,
    'base_language_strings' => $englishTotal,
    'languages' => []
];

// Generate table headers
echo str_pad("Language", 10) . " | ";
echo str_pad("Translated", 10) . " | ";
echo str_pad("Untranslated", 12) . " | ";
echo str_pad("Missing", 8) . " | ";
echo str_pad("Total", 8) . " | ";
echo "Progress\n";

echo str_repeat("-", 65) . "\n";

foreach ($languages as $lang) {
    $langTranslations = getLanguageTranslations($langPath, $lang);
    $stats = calculateStats($englishTranslations, $langTranslations);
    
    $report['languages'][$lang] = $stats;
    
    $percentage = number_format($stats['progress'] * 100, 2);
    
    // Output table row
    echo str_pad($lang, 10) . " | ";
    echo str_pad($stats['translated'], 10) . " | ";
    echo str_pad($stats['untranslated'], 12) . " | ";
    echo str_pad($stats['missing'], 8) . " | ";
    echo str_pad($stats['total'], 8) . " | ";
    echo "{$percentage}%\n";
}

// Save report to file if requested
$outputPath = $argv[1] ?? null;
if ($outputPath) {
    file_put_contents($outputPath, json_encode($report, JSON_PRETTY_PRINT));
    echo "\nReport saved to {$outputPath}\n";
}

// Summary
echo "\nMissing Translations by Language:\n";
echo str_repeat("-", 40) . "\n";

foreach ($report['languages'] as $lang => $stats) {
    if ($stats['missing'] > 0 || $stats['untranslated'] > 0) {
        echo str_pad($lang, 10) . ": " . 
             "Missing: " . str_pad($stats['missing'], 5) . " | " .
             "Untranslated: " . $stats['untranslated'] . "\n";
        
        // Show missing files
        $langTranslations = getLanguageTranslations($langPath, $lang);
        $missingFiles = array_diff(array_keys($englishTranslations), array_keys($langTranslations));
        
        if (count($missingFiles) > 0) {
            echo "   Missing files: " . implode(', ', $missingFiles) . "\n";
        }
    }
} 