<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class LazyLoadComponents
{
    /**
     * Components that should be lazy loaded
     */
    protected $lazyComponents = [];
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lazyComponents = config('blade-optimizations.lazy_components', [
            'ui.modal',
            'ui.dropdown',
            'ui.tooltip',
            'ui.popover',
        ]);
    }
    
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Register lazy component rendering
        $this->registerLazyComponents();
        
        return $next($request);
    }
    
    /**
     * Register lazy component rendering
     */
    protected function registerLazyComponents(): void
    {
        foreach ($this->lazyComponents as $component) {
            View::composer("components.{$component}*", function ($view) {
                $view->with('lazy_load', true);
            });
        }
    }
} 