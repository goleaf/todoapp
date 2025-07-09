<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;

class BladeComponentService
{
    /**
     * Component migration map for smooth transition to new naming
     * 
     * @var array
     */
    protected $componentMigrationMap = [
        // Input Components
        'input' => 'input.input',
        'form' => 'input.form',
        'textarea' => 'input.textarea',
        'select' => 'input.select',
        'checkbox' => 'input.checkbox',
        'radio' => 'input.radio',
        'input-error' => 'input.input-error',
        'label' => 'input.label',
        
        // UI Components
        'button' => 'ui.button',
        'card' => 'ui.card',
        'avatar' => 'ui.avatar',
        'badge' => 'ui.badge',
        'dropdown-item' => 'ui.dropdown.item',
        'dropdown-menu' => 'ui.dropdown.menu',
        'modal' => 'ui.modal',
        'empty-state' => 'ui.empty-state',
        'container' => 'ui.container',
        'link' => 'ui.link',
        'dark-mode-toggle' => 'ui.dark-mode-toggle',
        'status' => 'ui.status',
        
        // Layout Components
        'layouts.app' => 'layout.app',
        'layouts.auth' => 'layout.auth',
        'heading' => 'layout.heading',
        'subheading' => 'layout.subheading',
        'text' => 'layout.text',
        'separator' => 'layout.separator',
        'spacer' => 'layout.spacer',
        'header' => 'layout.header',
        'section-header' => 'layout.section-header',
        'app-logo' => 'layout.app-logo',
        'app-logo-icon' => 'layout.app-logo-icon',
        'placeholder-pattern' => 'layout.placeholder-pattern',
        
        // Data Components
        'table' => 'data.table',
        'table.row' => 'data.table.row',
        'table.cell' => 'data.table.cell',
        'table.heading' => 'data.table.heading',
        
        // Authentication Components
        'auth-header' => 'auth.auth-header',
        'auth-session-status' => 'auth.auth-session-status',
        
        // Feedback Components
        'error' => 'feedback.error',
        'action-message' => 'feedback.action-message',
        'alert' => 'feedback.alert',
    ];
    
    /**
     * Default variable mappings for components
     * 
     * @var array
     */
    protected $defaultVariableMappings = [
        // UI components
        'ui.button' => ['classes', 'iconClasses', 'iconMarginClasses'],
        'ui.card' => ['baseClasses', 'contentPadding'],
        'ui.modal' => ['modalId', 'sizeCss', 'backdropClass'],
        'ui.empty-state' => ['iconClass'],
        
        // Input components
        'input.input' => ['inputClasses'],
        'input.textarea' => ['textareaClasses'],
        'input.select' => ['selectClasses'],
        'input.checkbox' => ['checkboxClasses'],
        'input.radio' => ['radioClasses'],
        'input.label' => ['labelClasses'],
        
        // Layout components
        'layout.app' => ['layoutClasses'],
        'layout.header' => ['headerClasses'],
        'layout.section-header' => ['headerClasses', 'descriptionClasses'],
        
        // Data components
        'data.table' => ['tableClasses'],
        'data.table.row' => ['rowClasses'],
        'data.table.cell' => ['cellClasses'],
    ];
    
    /**
     * Get button component attributes
     */
    public function getButtonAttributes(array $params): array
    {
        $variant = $params['variant'] ?? 'primary';
        $size = $params['size'] ?? 'md';
        $icon = $params['icon'] ?? null;
        $iconPosition = $params['iconPosition'] ?? 'left';
        $disabled = $params['disabled'] ?? false;
        
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
        $iconMarginClasses = $iconMargins[$iconPosition][$size] ?? '';
        
        $classes = $baseClasses . ' ' . ($variantClasses[$variant] ?? $variantClasses['primary']) . ' ' . $sizeClasses[$size] . ' font-bold';
        
        if ($disabled) {
            $classes .= ' opacity-50 cursor-not-allowed pointer-events-none';
        }
        
        return [
            'classes' => $classes,
            'iconClasses' => $iconClasses,
            'iconMarginClasses' => $iconMarginClasses,
        ];
    }
    
    /**
     * Get card component attributes
     */
    public function getCardAttributes(array $params): array
    {
        $variant = $params['variant'] ?? 'default';
        $padding = $params['padding'] ?? 'default';
        $noPadding = $params['noPadding'] ?? false;
        
        // Card variant styles
        $variantClasses = [
            'default' => 'bg-white dark:bg-gray-800 shadow-md border border-gray-200 dark:border-gray-700 rounded-lg',
            'transparent' => 'bg-transparent',
            'outline' => 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg',
            'elevated' => 'bg-white dark:bg-gray-800 shadow-lg rounded-lg',
            'flat' => 'bg-gray-50 dark:bg-gray-900 rounded-lg',
        ];
        
        // Padding styles
        $paddingClasses = [
            'none' => '',
            'sm' => 'p-3',
            'default' => 'p-5',
            'lg' => 'p-7',
            'xl' => 'p-9',
        ];
        
        // Apply selected padding and variant
        $baseClasses = $variantClasses[$variant] ?? $variantClasses['default'];
        $contentPadding = $noPadding ? $paddingClasses['none'] : ($paddingClasses[$padding] ?? $paddingClasses['default']);
        
        return [
            'baseClasses' => $baseClasses,
            'contentPadding' => $contentPadding,
        ];
    }
    
    /**
     * Get empty state icon class
     */
    public function getEmptyStateIconClass(string $iconSize): string
    {
        return match($iconSize) {
            'sm' => 'w-8 h-8',
            'md' => 'w-12 h-12',
            'lg' => 'w-16 h-16',
            'xl' => 'w-20 h-20',
            default => 'w-20 h-20'
        };
    }
    
    /**
     * Get modal attributes
     */
    public function getModalAttributes(array $params): array
    {
        $id = $params['id'] ?? null;
        $size = $params['size'] ?? 'md';
        $blur = $params['blur'] ?? false;
        
        $modalId = $id ?? Str::random(10);
        $sizeCss = [
            'xs' => 'max-w-xs',
            'sm' => 'max-w-sm',
            'md' => 'max-w-md',
            'lg' => 'max-w-lg',
            'xl' => 'max-w-xl',
            '2xl' => 'max-w-2xl',
            '3xl' => 'max-w-3xl',
            '4xl' => 'max-w-4xl',
            '5xl' => 'max-w-5xl',
            '6xl' => 'max-w-6xl',
            '7xl' => 'max-w-7xl',
            'full' => 'max-w-full'
        ][$size] ?? 'max-w-md';
        
        $backdropClass = $blur ? 'backdrop-blur-sm' : '';
        
        return [
            'modalId' => $modalId,
            'sizeCss' => $sizeCss,
            'backdropClass' => $backdropClass,
        ];
    }
    
    /**
     * Registers component helpers in the view
     */
    public function registerComponentHelpers()
    {
        View::share('componentService', $this);
        
        // Register component aliases
        $this->registerComponentAliases();
        
        // Fix variables in components
        $this->fixComponentVariables();
    }
    
    /**
     * Register component aliases for backward compatibility during migration
     */
    public function registerComponentAliases(): void
    {
        foreach ($this->componentMigrationMap as $oldName => $newName) {
            // Only register the alias if the new component exists
            $newComponentPath = str_replace('.', '/', $newName);
            if (
                View::exists("components.{$newName}") || 
                View::exists("components.{$newComponentPath}") ||
                File::exists(resource_path("views/components/{$newComponentPath}.blade.php")) ||
                File::exists(resource_path("views/components/{$newComponentPath}/index.blade.php"))
            ) {
                // Register an alias from x-old-name to x-new-name
                Blade::component("components.{$newName}", $oldName);
            }
        }
    }
    
    /**
     * Fix component variables
     */
    public function fixComponentVariables(): void
    {
        // Add a global view composer for components
        View::composer('components.*', function ($view) {
            $viewName = $view->getName();
            
            // Extract component name from view path
            $componentName = str_replace('components.', '', $viewName);
            
            // Check if this component needs default variables
            foreach ($this->defaultVariableMappings as $pattern => $variables) {
                if (fnmatch($pattern, $componentName) || fnmatch("$pattern.*", $componentName)) {
                    $this->ensureComponentVariables($view, $pattern, $variables);
                    break;
                }
            }
        });
    }
    
    /**
     * Ensure component variables are set
     */
    protected function ensureComponentVariables($view, $pattern, array $variables): void
    {
        // Get view data
        $data = $view->getData();
        $componentName = str_replace('components.', '', $view->getName());
        
        // Extract props from data
        $params = $this->extractPropsFromData($data);
        
        // Based on component type, ensure variables
        switch ($pattern) {
            case 'ui.button':
                if (!isset($data['classes']) || !isset($data['iconClasses']) || !isset($data['iconMarginClasses'])) {
                    $buttonAttributes = $this->getButtonAttributes($params);
                    foreach ($buttonAttributes as $key => $value) {
                        if (!isset($data[$key])) {
                            $view->with($key, $value);
                        }
                    }
                }
                break;
                
            case 'ui.card':
                if (!isset($data['baseClasses']) || !isset($data['contentPadding'])) {
                    $cardAttributes = $this->getCardAttributes($params);
                    foreach ($cardAttributes as $key => $value) {
                        if (!isset($data[$key])) {
                            $view->with($key, $value);
                        }
                    }
                }
                break;
                
            case 'ui.modal':
                if (!isset($data['modalId']) || !isset($data['sizeCss']) || !isset($data['backdropClass'])) {
                    $modalAttributes = $this->getModalAttributes($params);
                    foreach ($modalAttributes as $key => $value) {
                        if (!isset($data[$key])) {
                            $view->with($key, $value);
                        }
                    }
                }
                break;
                
            case 'ui.empty-state':
                if (!isset($data['iconClass'])) {
                    $iconSize = $params['iconSize'] ?? 'md';
                    $view->with('iconClass', $this->getEmptyStateIconClass($iconSize));
                }
                break;
                
            default:
                // For any other component, ensure the variables exist even if empty
                foreach ($variables as $variable) {
                    if (!isset($data[$variable])) {
                        $view->with($variable, '');
                    }
                }
                break;
        }
    }
    
    /**
     * Extract props from view data
     */
    protected function extractPropsFromData(array $data): array
    {
        $props = [];
        
        // Extract props that are commonly used
        $commonProps = [
            'variant', 'size', 'icon', 'iconPosition', 'disabled', 'href',
            'padding', 'noPadding', 'type', 'id', 'blur',
            'iconSize', 'before', 'after'
        ];
        
        foreach ($commonProps as $prop) {
            if (isset($data[$prop])) {
                $props[$prop] = $data[$prop];
            }
        }
        
        return $props;
    }
    
    /**
     * Apply initialization code to component files
     */
    public function applyVariableSafetyToAllComponents(): array
    {
        // Define the component directory path
        $componentPath = resource_path('views/components');
        
        // If components directory doesn't exist, skip
        if (!File::exists($componentPath)) {
            return [
                'processed' => 0,
                'updated' => 0
            ];
        }
        
        // Get all .blade.php files in the components directory and subdirectories
        $files = File::allFiles($componentPath);
        
        // Component variable mapping with initialization code
        $componentVariableMap = $this->getComponentVariableInitMap();
        
        // Files processed counter
        $processedCount = 0;
        $updatedCount = 0;
        
        // Process each file
        foreach ($files as $file) {
            // Only process .blade.php files
            if ($file->getExtension() !== 'php' || !str_ends_with($file->getFilename(), '.blade.php')) {
                continue;
            }
            
            $relativePath = str_replace(resource_path('views/components/'), '', $file->getPathname());
            $relativePath = str_replace('.blade.php', '', $relativePath);
            $componentName = str_replace('/', '.', $relativePath);
            
            // Skip index.blade.php files in directories
            if (str_ends_with($componentName, '.index')) {
                $componentName = substr($componentName, 0, -6);
            }
            
            // Read file content
            $content = File::get($file->getPathname());
            
            // Skip if file already has initialization code
            if (str_contains($content, '// Initialize required variables')) {
                continue;
            }
            
            // Find a matching component map entry
            $matchedComponent = null;
            foreach ($componentVariableMap as $pattern => $config) {
                if ($pattern === 'default') {
                    continue; // Skip default for now
                }
                
                if (fnmatch($pattern, $componentName) || fnmatch($pattern . '.*', $componentName)) {
                    $matchedComponent = $pattern;
                    break;
                }
            }
            
            // If no specific match, use default
            if ($matchedComponent === null) {
                $matchedComponent = 'default';
            }
            
            // Get the config for this component
            $config = $componentVariableMap[$matchedComponent];
            
            // Insert initialization code after @props or at the top if no @props
            $updatedContent = $content;
            if (str_contains($content, '@props')) {
                $updatedContent = preg_replace('/(@props\([^\)]*\))/', '$1' . "\n\n" . $config['init_code'], $content);
            } else {
                $updatedContent = $config['init_code'] . "\n\n" . $content;
            }
            
            // Write back if changed
            if ($updatedContent !== $content) {
                File::put($file->getPathname(), $updatedContent);
                $updatedCount++;
            }
            
            $processedCount++;
        }
        
        // Store that we've fixed the components
        Cache::put('blade_components_variables_fixed', true, 86400 * 30); // 30 days
        
        return [
            'processed' => $processedCount,
            'updated' => $updatedCount
        ];
    }
    
    /**
     * Get component variable initialization map
     */
    protected function getComponentVariableInitMap(): array
    {
        return [
            // UI components variables
            'ui.button' => [
                'variables' => ['classes', 'iconClasses', 'iconMarginClasses'],
                'init_code' => "@php
    // Initialize required variables if they don't exist
    \$attributes = \$attributes ?? collect();
    \$slot = \$slot ?? '';
    \$classes = \$classes ?? '';
    \$iconClasses = \$iconClasses ?? '';
    \$iconMarginClasses = \$iconMarginClasses ?? '';
    
    // Get attributes from component service if not already set
    if (empty(\$classes)) {
        \$params = [
            'variant' => \$variant ?? 'primary',
            'size' => \$size ?? 'md',
            'icon' => \$icon ?? null,
            'iconPosition' => \$iconPosition ?? 'left',
            'disabled' => \$disabled ?? false,
        ];
        \$attrs = app(\\App\\Services\\BladeComponentService::class)->getButtonAttributes(\$params);
        \$classes = \$attrs['classes'];
        \$iconClasses = \$attrs['iconClasses'];
        \$iconMarginClasses = \$attrs['iconMarginClasses'];
    }
@endphp"
            ],
            'ui.card' => [
                'variables' => ['baseClasses', 'contentPadding'],
                'init_code' => "@php
    // Initialize required variables if they don't exist
    \$attributes = \$attributes ?? collect();
    \$slot = \$slot ?? '';
    \$baseClasses = \$baseClasses ?? '';
    \$contentPadding = \$contentPadding ?? '';
    
    // Get attributes from component service if not already set
    if (empty(\$baseClasses)) {
        \$params = [
            'variant' => \$variant ?? 'default',
            'padding' => \$padding ?? 'default',
            'noPadding' => \$noPadding ?? false,
        ];
        \$attrs = app(\\App\\Services\\BladeComponentService::class)->getCardAttributes(\$params);
        \$baseClasses = \$attrs['baseClasses'];
        \$contentPadding = \$attrs['contentPadding'];
    }
@endphp"
            ],
            'ui.modal' => [
                'variables' => ['modalId', 'sizeCss', 'backdropClass'],
                'init_code' => "@php
    // Initialize required variables if they don't exist
    \$attributes = \$attributes ?? collect();
    \$slot = \$slot ?? '';
    \$modalId = \$modalId ?? '';
    \$sizeCss = \$sizeCss ?? '';
    \$backdropClass = \$backdropClass ?? '';
    
    // Get attributes from component service if not already set
    if (empty(\$modalId)) {
        \$params = [
            'id' => \$id ?? null,
            'size' => \$size ?? 'md',
            'blur' => \$blur ?? false,
        ];
        \$attrs = app(\\App\\Services\\BladeComponentService::class)->getModalAttributes(\$params);
        \$modalId = \$attrs['modalId'];
        \$sizeCss = \$attrs['sizeCss'];
        \$backdropClass = \$attrs['backdropClass'];
    }
@endphp"
            ],
            'ui.empty-state' => [
                'variables' => ['iconClass'],
                'init_code' => "@php
    // Initialize required variables if they don't exist
    \$attributes = \$attributes ?? collect();
    \$slot = \$slot ?? '';
    \$iconClass = \$iconClass ?? '';
    
    // Get icon class from component service if not already set
    if (empty(\$iconClass)) {
        \$iconSize = \$iconSize ?? 'md';
        \$iconClass = app(\\App\\Services\\BladeComponentService::class)->getEmptyStateIconClass(\$iconSize);
    }
@endphp"
            ],
            // Default initialization for any component
            'default' => [
                'variables' => ['attributes', 'slot'],
                'init_code' => "@php
    // Initialize basic component variables
    \$attributes = \$attributes ?? collect();
    \$slot = \$slot ?? '';
@endphp"
            ],
        ];
    }
} 