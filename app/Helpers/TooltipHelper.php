<?php

namespace App\Helpers;

class TooltipHelper
{
    /**
     * Get the position classes for a tooltip
     *
     * @param string $position
     * @return string
     */
    public static function getPositionClasses(string $position = 'top'): string
    {
        $positionClasses = [
            'top' => 'bottom-full left-1/2 -translate-x-1/2 mb-1',
            'bottom' => 'top-full left-1/2 -translate-x-1/2 mt-1',
            'left' => 'right-full top-1/2 -translate-y-1/2 mr-1',
            'right' => 'left-full top-1/2 -translate-y-1/2 ml-1',
        ];
        
        return $positionClasses[$position] ?? $positionClasses['top'];
    }

    /**
     * Get the arrow classes for a tooltip
     *
     * @param string $position
     * @return string
     */
    public static function getArrowClasses(string $position = 'top'): string
    {
        $arrowClasses = [
            'top' => 'top-full left-1/2 -translate-x-1/2 -mt-px border-t-gray-700 dark:border-t-gray-600 border-l-transparent border-r-transparent border-b-transparent',
            'bottom' => 'bottom-full left-1/2 -translate-x-1/2 -mb-px border-b-gray-700 dark:border-b-gray-600 border-l-transparent border-r-transparent border-t-transparent',
            'left' => 'left-full top-1/2 -translate-y-1/2 -ml-px border-l-gray-700 dark:border-l-gray-600 border-t-transparent border-b-transparent border-r-transparent',
            'right' => 'right-full top-1/2 -translate-y-1/2 -mr-px border-r-gray-700 dark:border-r-gray-600 border-t-transparent border-b-transparent border-l-transparent',
        ];
        
        return $arrowClasses[$position] ?? $arrowClasses['top'];
    }
} 