<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\FileEngine;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;
use Illuminate\Filesystem\Filesystem;
use App\Http\Controllers\LanguageController; // Assuming the logic is kept there for reuse

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerFileSystem();
        
        $this->registerBladeCompiler();

        $this->registerEngineResolver();

        $this->registerViewFinder();

        $this->registerFactory();
    }

    /**
     * Register the filesystem implementation.
     */
    protected function registerFileSystem(): void
    {
        $this->app->singleton('files', function () {
            return new Filesystem;
        });
    }

    /**
     * Register the Blade compiler implementation.
     */
    protected function registerBladeCompiler(): void
    {
        $this->app->singleton('blade.compiler', function ($app) {
            return tap(new BladeCompiler(
                $app['files'], $app['config']['view.compiled']
            ), function ($blade) {
                $blade->component('dynamic-component', \Illuminate\View\DynamicComponent::class);
            });
        });
    }

    /**
     * Register the engine resolver instance.
     */
    protected function registerEngineResolver(): void
    {
        $this->app->singleton('view.engine.resolver', function () {
            $resolver = new EngineResolver;

            $this->registerPhpEngine($resolver);
            $this->registerBladeEngine($resolver);
            $this->registerFileEngine($resolver);

            return $resolver;
        });
    }

    /**
     * Register the PHP engine implementation.
     */
    protected function registerPhpEngine($resolver): void
    {
        $resolver->register('php', function () {
            return new PhpEngine;
        });
    }

    /**
     * Register the Blade engine implementation.
     */
    protected function registerBladeEngine($resolver): void
    {
        $resolver->register('blade', function () {
            return new CompilerEngine($this->app['blade.compiler']);
        });
    }

    /**
     * Register the File engine implementation.
     */
    protected function registerFileEngine($resolver): void
    {
        $resolver->register('file', function () {
            return new FileEngine;
        });
    }

    /**
     * Register the view finder implementation.
     */
    protected function registerViewFinder(): void
    {
        $this->app->bind('view.finder', function ($app) {
            return new FileViewFinder($app['files'], $app['config']['view.paths']);
        });
    }

    /**
     * Register the view factory implementation.
     */
    protected function registerFactory(): void
    {
        $this->app->singleton('view', function ($app) {
            $factory = new Factory(
                $app['view.engine.resolver'],
                $app['view.finder'],
                $app['events']
            );

            $factory->setContainer($app);

            $factory->share('app', $app);

            return $factory;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share available locales with the language switcher component
        View::composer('components.ui.language-switcher', function ($view) {
            // Duplicate the logic here for simplicity
            $langPath = base_path('lang');
            $directories = File::exists($langPath) ? File::directories($langPath) : [];
            $locales = [];
            foreach ($directories as $directory) {
                $locales[] = basename($directory);
            }
            $locales = array_filter($locales, fn($locale) => preg_match('/^[a-z]{2}(?:-[A-Z]{2})?$/', $locale));
            if (!in_array('en', $locales)) {
                $locales[] = 'en';
            }
            $availableLocales = array_unique($locales);
            sort($availableLocales); // Optional: sort locales alphabetically
            
            $view->with('availableLocales', $availableLocales);
        });
    }
} 