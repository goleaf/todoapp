<?php

namespace App\Helpers;

class CardHelper
{
    /**
     * Get padding classes for different card sizes
     *
     * @return array
     */
    public static function getPaddingClasses(): array
    {
        return [
            'none' => '',
            'sm' => 'p-3 sm:p-4',
            'normal' => 'p-4 sm:p-6',
            'lg' => 'p-6 sm:p-8'
        ];
    }
    
    /**
     * Get card classes based on options
     *
     * @param bool $withShadow
     * @param bool $withBorder
     * @param bool $withHover
     * @return array
     */
    public static function getCardClasses(bool $withShadow = true, bool $withBorder = false, bool $withHover = false): array
    {
        $classes = ['bg-white dark:bg-gray-800 rounded-lg'];
        
        if ($withShadow) {
            $classes[] = 'shadow-sm';
        }
        
        if ($withBorder) {
            $classes[] = 'border border-gray-200 dark:border-gray-700';
        }
        
        if ($withHover) {
            $classes[] = 'transition-all duration-200 hover:shadow-md';
        }
        
        return $classes;
    }
} 