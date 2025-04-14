<?php

namespace App\Helpers;

class LanguageHelper
{
    /**
     * Get the mapping of language codes to flag emojis.
     *
     * @return array
     */
    public static function getFlagMap(): array
    {
        return [
            'en' => '🇬🇧', 
            'ru' => '🇷🇺', 
            'es' => '🇪🇸', 
            'fr' => '🇫🇷', 
            'de' => '🇩🇪',
            'it' => '🇮🇹',
            'ja' => '🇯🇵',
            'zh' => '🇨🇳',
            'lt' => '🇱🇹'
        ];
    }
    
    /**
     * Get the flag emoji for a specific language code.
     *
     * @param string $code
     * @return string
     */
    public static function getFlagForLanguage(string $code): string
    {
        $flagMap = self::getFlagMap();
        return $flagMap[$code] ?? '🌐';
    }
} 