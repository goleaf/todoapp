@props(['icon', 'class' => '', 'width' => 24, 'height' => 24])

@php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

$iconClass = $class ?: 'w-5 h-5';
$iconContent = null;
$component = null;

// Helper closure to avoid function redeclaration
$updateSvgAttributes = function($svgContent, $class, $attributes = null) {
    // Add class to SVG
    $svgContent = preg_replace('/<svg\s/', '<svg class="'.$class.'" ', $svgContent, 1);
    
    // Remove width/height/fill attributes from SVG if they exist
    $svgContent = preg_replace('/\s+width="[^"]*"/', '', $svgContent);
    $svgContent = preg_replace('/\s+height="[^"]*"/', '', $svgContent);
    
    return $svgContent;
};

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
                $iconContent = $updateSvgAttributes($iconContent, $iconClass);
            }
        } elseif (Str::startsWith($icon, 'heroicon-s-')) {
            $iconName = Str::after($icon, 'heroicon-s-');
            $vendorPath = public_path('vendor/blade-heroicons/s-' . $iconName . '.svg');
            
            if (File::exists($vendorPath)) {
                $iconContent = File::get($vendorPath);
                $iconContent = $updateSvgAttributes($iconContent, $iconClass);
            }
        } elseif (Str::startsWith($icon, 'phosphor-')) {
            $iconName = Str::after($icon, 'phosphor-');
            $vendorPath = public_path('vendor/blade-phosphor/' . $iconName . '.svg');
            
            if (File::exists($vendorPath)) {
                $iconContent = File::get($vendorPath);
                $iconContent = $updateSvgAttributes($iconContent, $iconClass);
            }
        }
    }
}
@endphp

@if (!empty($iconContent))
    {!! $iconContent !!}
@elseif (isset($component))
    <x-dynamic-component :component="$component" :class="$class" {{ $attributes->except(['class', 'icon']) }} />
@elseif (is_string($icon))
    {{-- Fallback SVG for icon not found --}}
    <svg xmlns="http://www.w3.org/2000/svg" {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
@else
    {{ $icon }}
@endif 