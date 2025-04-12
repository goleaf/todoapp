@props([
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'iconPosition' => 'left',
    'type' => 'button',
    'disabled' => false,
    'href' => null,
    'before' => null,
])

@php
    use Illuminate\Support\Str;
    
    $baseClasses = 'inline-flex items-center justify-center gap-2 font-medium rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2';
    
    $variantClasses = [
        'primary' => 'bg-primary-600 text-white hover:bg-primary-500 focus:ring-primary-500 shadow-sm border border-black/10 dark:border-0',
        'secondary' => 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:ring-primary-500 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600',
        'danger' => 'bg-red-600 text-white hover:bg-red-500 focus:ring-red-500 shadow-sm',
        'success' => 'bg-green-600 text-white hover:bg-green-500 focus:ring-green-500 shadow-sm',
        'warning' => 'bg-yellow-500 text-white hover:bg-yellow-400 focus:ring-yellow-500 shadow-sm',
        'info' => 'bg-blue-600 text-white hover:bg-blue-500 focus:ring-blue-500 shadow-sm',
        'ghost' => 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-gray-500',
        'link' => 'text-primary-600 dark:text-primary-400 hover:text-primary-500 dark:hover:text-primary-300 underline-offset-4 hover:underline focus:ring-primary-500',
    ];
    
    $sizeClasses = [
        'xs' => 'text-xs h-6 px-2.5',
        'sm' => 'text-sm h-8 px-3',
        'md' => 'text-sm h-10 px-4',
        'lg' => 'text-base h-12 px-4',
        'xl' => 'text-base h-14 px-6',
    ];
    
    $iconSizes = [
        'xs' => 'w-3.5 h-3.5',
        'sm' => 'w-4 h-4',
        'md' => 'w-5 h-5',
        'lg' => 'w-5 h-5',
        'xl' => 'w-6 h-6',
    ];
    
    $iconMargins = [
        'left' => [
            'xs' => 'mr-1 -ml-0.5',
            'sm' => 'mr-1.5 -ml-0.5',
            'md' => 'mr-2 -ml-0.5',
            'lg' => 'mr-2 -ml-1',
            'xl' => 'mr-3 -ml-1',
        ],
        'right' => [
            'xs' => 'ml-1 -mr-0.5',
            'sm' => 'ml-1.5 -mr-0.5',
            'md' => 'ml-2 -mr-0.5',
            'lg' => 'ml-2 -mr-1',
            'xl' => 'ml-3 -mr-1',
        ]
    ];
    
    $iconClasses = $iconSizes[$size];
    $iconMarginClasses = $iconMargins[$iconPosition][$size];
    
    $classes = $baseClasses . ' ' . $variantClasses[$variant] . ' ' . $sizeClasses[$size];
    
    if ($disabled) {
        $classes .= ' opacity-50 cursor-not-allowed pointer-events-none';
    }
    
    // Handle icon rendering
    $iconContent = null;
    if ($icon) {
        if (is_string($icon) && Str::startsWith($icon, 'heroicon-o-')) {
            $iconName = Str::after($icon, 'heroicon-o-');
            $iconContent = '<x-heroicon-o-' . $iconName . ' class="' . $iconClasses . '" />';
        } elseif (is_string($icon) && Str::startsWith($icon, 'heroicon-s-')) {
            $iconName = Str::after($icon, 'heroicon-s-');
            $iconContent = '<x-heroicon-s-' . $iconName . ' class="' . $iconClasses . '" />';
        } else {
            $iconContent = $icon;
        }
    }
    
    // Handle before icon (used in dropdown items)
    $beforeContent = null;
    if ($before) {
        if (is_string($before) && Str::startsWith($before, 'heroicon-o-')) {
            $beforeName = Str::after($before, 'heroicon-o-');
            $beforeContent = '<x-heroicon-o-' . $beforeName . ' class="' . $iconClasses . ' ' . $iconMarginClasses . '" />';
        } elseif (is_string($before) && Str::startsWith($before, 'heroicon-s-')) {
            $beforeName = Str::after($before, 'heroicon-s-');
            $beforeContent = '<x-heroicon-s-' . $beforeName . ' class="' . $iconClasses . ' ' . $iconMarginClasses . '" />';
        } else {
            $beforeContent = $before;
        }
    }
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($before)
            <span class="{{ $iconMarginClasses }}">
                {!! $beforeContent !!}
            </span>
        @endif
        
        @if ($icon && $iconPosition === 'left')
            <span class="{{ $iconMarginClasses }}">
                {!! $iconContent !!}
            </span>
        @endif
        
        {{ $slot }}
        
        @if ($icon && $iconPosition === 'right')
            <span class="{{ $iconMarginClasses }}">
                {!! $iconContent !!}
            </span>
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }} @if($disabled) disabled @endif>
        @if ($before)
            <span class="{{ $iconMarginClasses }}">
                {!! $beforeContent !!}
            </span>
        @endif
        
        @if ($icon && $iconPosition === 'left')
            <span class="{{ $iconMarginClasses }}">
                {!! $iconContent !!}
            </span>
        @endif
        
        {{ $slot }}
        
        @if ($icon && $iconPosition === 'right')
            <span class="{{ $iconMarginClasses }}">
                {!! $iconContent !!}
            </span>
        @endif
    </button>
@endif 