<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Blade Component Caching
    |--------------------------------------------------------------------------
    |
    | This option determines whether blade components should be cached in
    | production environments. Disabling this in development ensures
    | you see the latest changes without clearing cache.
    |
    */
    'component_cache_enabled' => env('BLADE_COMPONENT_CACHE_ENABLED', true),
    
    /*
    |--------------------------------------------------------------------------
    | Cache Duration
    |--------------------------------------------------------------------------
    |
    | The time in seconds that blade components should be cached.
    |
    */
    'cache_duration' => env('BLADE_COMPONENT_CACHE_DURATION', 3600),
    
    /*
    |--------------------------------------------------------------------------
    | Lazy Loading Components
    |--------------------------------------------------------------------------
    |
    | Components that should use lazy loading rather than being
    | eagerly loaded.
    |
    */
    'lazy_components' => [
        'ui.modal',
        'ui.dropdown',
        'ui.tooltip',
        'ui.popover',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Cacheable Components
    |--------------------------------------------------------------------------
    |
    | List of components that should be cached.
    |
    */
    'cacheable_components' => [
        'ui.button',
        'ui.card',
        'ui.empty-state',
        'ui.icon',
        'ui.link',
        'ui.dropdown',
        'ui.modal',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Common Icons
    |--------------------------------------------------------------------------
    |
    | Icons that are frequently used and should be directly registered
    | as Blade components.
    |
    */
    'common_icons' => [
        'clipboard-document-list',
        'plus',
        'check-circle',
        'chevron-down',
        'chevron-up',
        'user',
        'cog',
        'home',
        'trash',
        'pencil',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Icon Rendering Method
    |--------------------------------------------------------------------------
    |
    | Method to use for rendering icons.
    | Options: 'direct', 'component', 'cached'
    |
    */
    'icon_rendering' => env('BLADE_ICON_RENDERING', 'cached'),
]; 