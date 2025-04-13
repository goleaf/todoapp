@props(['icon', 'class' => '', 'width' => 24, 'height' => 24])

@php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

$iconClass = $class ?: 'w-5 h-5';
$svgPath = null;
$iconContent = null;

// Helper closure to avoid function redeclaration
$updateSvgAttributes = function($svgContent, $class, $attributes = null) {
    // Add class to SVG
    $svgContent = preg_replace('/<svg\s/', '<svg class="'.$class.'" ', $svgContent, 1);
    
    // Remove width/height/fill attributes from SVG if they exist
    $svgContent = preg_replace('/\s+width="[^"]*"/', '', $svgContent);
    $svgContent = preg_replace('/\s+height="[^"]*"/', '', $svgContent);
    
    return $svgContent;
};

// Map prefixes to their file locations
$iconMap = [
    'heroicon-o-' => [
        'prefix' => 'o-', 
        'paths' => [
            public_path('vendor/blade-heroicons'),
            resource_path('views/components/ui/icon/heroicon-o')
        ]
    ],
    'heroicon-s-' => [
        'prefix' => 's-', 
        'paths' => [
            public_path('vendor/blade-heroicons'),
            resource_path('views/components/ui/icon/heroicon-s')
        ]
    ],
    'phosphor-' => [
        'prefix' => '', 
        'paths' => [
            public_path('vendor/phosphor-icons'),
            public_path('vendor/blade-phosphor'),
            resource_path('views/components/ui/icon/phosphor')
        ]
    ],
];

// Only process if icon is a string
if (is_string($icon)) {
    $foundIcon = false;
    $iconName = '';
    $iconPrefix = '';
    
    // Identify which icon type we're dealing with
    foreach ($iconMap as $prefix => $config) {
        if (Str::startsWith($icon, $prefix)) {
            $iconName = Str::after($icon, $prefix);
            $iconPrefix = $prefix;
            $foundIcon = true;
            break;
        }
    }
    
    if ($foundIcon) {
        $config = $iconMap[$iconPrefix];
        
        // Search through all possible paths for this icon type
        foreach ($config['paths'] as $basePath) {
            if (File::isDirectory($basePath)) {
                // Try with the file prefix (for vendor directories)
                if (!empty($config['prefix'])) {
                    $fullPath = $basePath . '/' . $config['prefix'] . $iconName . '.svg';
                    if (File::exists($fullPath)) {
                        $iconContent = File::get($fullPath);
                        break;
                    }
                }
                
                // Try without prefix and with .blade.php extension (for component directories)
                $bladeFile = $basePath . '/' . $iconName . '.blade.php';
                if (File::exists($bladeFile)) {
                    // For components, use component rendering instead of direct SVG
                    $componentName = '';
                    if (Str::startsWith($iconPrefix, 'heroicon-o-')) {
                        $componentName = "ui.icon.heroicon-o.{$iconName}";
                    } elseif (Str::startsWith($iconPrefix, 'heroicon-s-')) {
                        $componentName = "ui.icon.heroicon-s.{$iconName}";
                    } elseif (Str::startsWith($iconPrefix, 'phosphor-')) {
                        $componentName = "ui.icon.phosphor.{$iconName}";
                    }
                    
                    if (View::exists("components.{$componentName}")) {
                        $component = $componentName;
                        break;
                    }
                }
                
                // Try just the SVG file in component directories
                $svgFile = $basePath . '/' . $iconName . '.svg';
                if (File::exists($svgFile)) {
                    $iconContent = File::get($svgFile);
                    break;
                }
            }
        }
        
        // If we found SVG content, update its attributes
        if (!empty($iconContent)) {
            $iconContent = $updateSvgAttributes($iconContent, $iconClass, $attributes);
        }
    }
}
@endphp

@if (!empty($iconContent))
    {!! $iconContent !!}
@elseif (isset($component))
    <x-dynamic-component :component="$component" :class="$iconClass" {{ $attributes->except(['class', 'icon']) }} />
@elseif (is_string($icon))
    {{-- Fallback SVG for icon not found --}}
    <svg xmlns="http://www.w3.org/2000/svg" {{ $attributes->merge(['class' => $iconClass]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
@else
    {{ $icon }}
@endif 