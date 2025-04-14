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
        'primary' => 'bg-blue-600 text-white hover:bg-blue-500 focus:ring-blue-500 shadow-md border border-black/10 dark:border-0',
        'secondary' => 'bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-500 focus:ring-gray-400 shadow-md ring-1 ring-inset ring-gray-300 dark:ring-gray-500',
        'danger' => 'bg-red-600 text-white hover:bg-red-500 focus:ring-red-500 shadow-md',
        'success' => 'bg-green-600 text-white hover:bg-green-500 focus:ring-green-500 shadow-md',
        'warning' => 'bg-yellow-500 text-white hover:bg-yellow-400 focus:ring-yellow-500 shadow-md',
        'info' => 'bg-cyan-600 text-white hover:bg-cyan-500 focus:ring-cyan-500 shadow-md',
        'ghost' => 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-gray-500',
        'link' => 'text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 underline-offset-4 hover:underline focus:ring-blue-500',
    ];
    
    $sizeClasses = [
        'xs' => 'text-xs h-7 px-3',
        'sm' => 'text-sm h-9 px-4',
        'md' => 'text-base h-11 px-5',
        'lg' => 'text-lg h-13 px-6',
        'xl' => 'text-xl h-16 px-8',
    ];
    
    $iconSizes = [
        'xs' => 'w-4 h-4',
        'sm' => 'w-5 h-5',
        'md' => 'w-6 h-6',
        'lg' => 'w-7 h-7',
        'xl' => 'w-8 h-8',
    ];
    
    $iconMargins = [
        'left' => [
            'xs' => 'mr-1.5 -ml-0.5',
            'sm' => 'mr-2 -ml-0.5',
            'md' => 'mr-2.5 -ml-0.5',
            'lg' => 'mr-3 -ml-1',
            'xl' => 'mr-3.5 -ml-1',
        ],
        'right' => [
            'xs' => 'ml-1.5 -mr-0.5',
            'sm' => 'ml-2 -mr-0.5',
            'md' => 'ml-2.5 -mr-0.5',
            'lg' => 'ml-3 -mr-1',
            'xl' => 'ml-3.5 -mr-1',
        ]
    ];
    
    $iconClasses = $iconSizes[$size];
    $iconMarginClasses = $iconMargins[$iconPosition][$size];
    
    $classes = $baseClasses . ' ' . $variantClasses[$variant] . ' ' . $sizeClasses[$size] . ' font-bold';
    
    if ($disabled) {
        $classes .= ' opacity-50 cursor-not-allowed pointer-events-none';
    }
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($before)
            <span class="{{ $iconMarginClasses }}">
                <x-ui.button.render-icon :icon="$before" :classes="$iconClasses" />
            </span>
        @endif
        
        @if ($icon && $iconPosition === 'left')
            <span class="{{ $iconMarginClasses }}">
                <x-ui.button.render-icon :icon="$icon" :classes="$iconClasses" />
            </span>
        @endif
        
        {{ $slot }}
        
        @if ($icon && $iconPosition === 'right')
            <span class="{{ $iconMarginClasses }}">
                <x-ui.button.render-icon :icon="$icon" :classes="$iconClasses" />
            </span>
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }} @if($disabled) disabled @endif>
        @if ($before)
            <span class="{{ $iconMarginClasses }}">
                <x-ui.button.render-icon :icon="$before" :classes="$iconClasses" />
            </span>
        @endif
        
        @if ($icon && $iconPosition === 'left')
            <span class="{{ $iconMarginClasses }}">
                <x-ui.button.render-icon :icon="$icon" :classes="$iconClasses" />
            </span>
        @endif
        
        {{ $slot }}
        
        @if ($icon && $iconPosition === 'right')
            <span class="{{ $iconMarginClasses }}">
                <x-ui.button.render-icon :icon="$icon" :classes="$iconClasses" />
            </span>
        @endif
    </button>
@endif 