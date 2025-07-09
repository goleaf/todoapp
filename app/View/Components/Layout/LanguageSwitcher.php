<?php

namespace App\View\Components\Layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\View\Component;

class LanguageSwitcher extends Component
{
    public string $currentLocale;
    public array $availableLocales;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->currentLocale = App::getLocale();
        // Assuming available locales are stored in config/app.php
        // If not, it defaults to an array containing only the current locale.
        $this->availableLocales = config('app.available_locales', [$this->currentLocale]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.language-switcher');
    }
} 