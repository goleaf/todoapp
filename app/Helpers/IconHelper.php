<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class IconHelper
{
    /**
     * Get the icon details based on the icon name
     *
     * @param string|mixed $icon
     * @param string $class
     * @return array
     */
    public static function getIconDetails($icon, string $class = 'w-5 h-5'): array
    {
        $iconContent = null;
        $component = null;

        // Map prefixes to their component paths for efficient lookup
        $iconMap = [
            'heroicon-o-' => 'ui.icon.heroicon-o',
            'heroicon-s-' => 'ui.icon.heroicon-s',
            'phosphor-' => 'ui.icon.phosphor',
        ];

        // Only process if icon is a string
        if (is_string($icon)) {
            // First try as component with standardized naming
            foreach ($iconMap as $prefix => $componentPath) {
                if (Str::startsWith($icon, $prefix)) {
                    $iconName = Str::after($icon, $prefix);
                    $fullComponentName = "{$componentPath}.{$iconName}";
                    
                    if (View::exists("components.{$fullComponentName}")) {
                        $component = $fullComponentName;
                        break;
                    }
                }
            }
            
            // If no component found, try to load raw SVG from vendor directory
            if (!$component) {
                // Check for vendor SVG files (Blade Heroicons and Phosphor)
                if (Str::startsWith($icon, 'heroicon-o-')) {
                    $iconName = Str::after($icon, 'heroicon-o-');
                    $vendorPath = public_path('vendor/blade-heroicons/o-' . $iconName . '.svg');
                    
                    if (File::exists($vendorPath)) {
                        $iconContent = File::get($vendorPath);
                        $iconContent = self::updateSvgAttributes($iconContent, $class);
                    }
                } elseif (Str::startsWith($icon, 'heroicon-s-')) {
                    $iconName = Str::after($icon, 'heroicon-s-');
                    $vendorPath = public_path('vendor/blade-heroicons/s-' . $iconName . '.svg');
                    
                    if (File::exists($vendorPath)) {
                        $iconContent = File::get($vendorPath);
                        $iconContent = self::updateSvgAttributes($iconContent, $class);
                    }
                } elseif (Str::startsWith($icon, 'phosphor-')) {
                    $iconName = Str::after($icon, 'phosphor-');
                    $vendorPath = public_path('vendor/blade-phosphor/' . $iconName . '.svg');
                    
                    if (File::exists($vendorPath)) {
                        $iconContent = File::get($vendorPath);
                        $iconContent = self::updateSvgAttributes($iconContent, $class);
                    }
                }
            }
        }

        return [
            'iconContent' => $iconContent,
            'component' => $component
        ];
    }

    /**
     * Update SVG attributes
     *
     * @param string $svgContent
     * @param string $class
     * @param array|null $attributes
     * @return string
     */
    public static function updateSvgAttributes(string $svgContent, string $class, ?array $attributes = null): string
    {
        // Add class to SVG
        $svgContent = preg_replace('/<svg\s/', '<svg class="'.$class.'" ', $svgContent, 1);
        
        // Remove width/height/fill attributes from SVG if they exist
        $svgContent = preg_replace('/\s+width="[^"]*"/', '', $svgContent);
        $svgContent = preg_replace('/\s+height="[^"]*"/', '', $svgContent);
        
        return $svgContent;
    }
} 