<?php

namespace App\Helpers;

class AvatarHelper
{
    /**
     * Get size classes for avatar
     *
     * @return array
     */
    public static function getSizeClasses(): array
    {
        return [
            'xs' => 'h-6 w-6 text-xs',
            'sm' => 'h-8 w-8 text-xs',
            'md' => 'h-10 w-10 text-sm',
            'lg' => 'h-12 w-12 text-base',
            'xl' => 'h-16 w-16 text-lg',
            '2xl' => 'h-20 w-20 text-xl',
        ];
    }
    
    /**
     * Get status indicator sizes
     *
     * @return array
     */
    public static function getStatusSizes(): array
    {
        return [
            'xs' => 'h-1.5 w-1.5',
            'sm' => 'h-2 w-2',
            'md' => 'h-2.5 w-2.5',
            'lg' => 'h-3 w-3',
            'xl' => 'h-3.5 w-3.5',
            '2xl' => 'h-4 w-4',
        ];
    }
    
    /**
     * Get status colors
     *
     * @return array
     */
    public static function getStatusColors(): array
    {
        return [
            'online' => 'bg-green-400',
            'away' => 'bg-yellow-400',
            'busy' => 'bg-red-400',
            'offline' => 'bg-gray-400',
        ];
    }
    
    /**
     * Get status positions
     *
     * @return array
     */
    public static function getStatusPositions(): array
    {
        return [
            'top-right' => 'top-0 right-0 -mt-1 -mr-1',
            'top-left' => 'top-0 left-0 -mt-1 -ml-1',
            'bottom-right' => 'bottom-0 right-0 -mb-1 -mr-1',
            'bottom-left' => 'bottom-0 left-0 -mb-1 -ml-1',
        ];
    }
    
    /**
     * Get border radius based on shape
     *
     * @param bool $square
     * @return string
     */
    public static function getBorderRadius(bool $square = false): string
    {
        return $square ? 'rounded-md' : 'rounded-full';
    }
    
    /**
     * Get initials from name
     *
     * @param string|null $name
     * @return string
     */
    public static function getInitials(?string $name): string
    {
        if (!$name) {
            return '';
        }
        
        $words = explode(' ', $name);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr(end($words), 0, 1));
        } else {
            return strtoupper(substr($name, 0, 2));
        }
    }
} 