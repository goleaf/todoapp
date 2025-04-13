#!/bin/bash

echo "Starting component migration..."

# Input Components
echo "Migrating input components..."
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-input /<x-input.input /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-form /<x-input.form /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-textarea /<x-input.textarea /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-select /<x-input.select /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-checkbox /<x-input.checkbox /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-radio /<x-input.radio /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-input-error /<x-input.input-error /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-label /<x-input.label /g' {} \;

# UI Components
echo "Migrating UI components..."
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-button /<x-ui.button /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-card /<x-ui.card /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-avatar /<x-ui.avatar /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-badge /<x-ui.badge /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-dropdown-item /<x-ui.dropdown.item /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-dropdown-menu /<x-ui.dropdown.menu /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-modal /<x-ui.modal /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-empty-state /<x-ui.empty-state /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-container /<x-ui.container /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-link /<x-ui.link /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-dark-mode-toggle /<x-ui.dark-mode-toggle /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-status /<x-ui.status /g' {} \;

# Layout Components
echo "Migrating layout components to top navigation..."

# Add migration commands for layout components
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-layouts.app /<x-layout.app /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-layouts.auth /<x-layout.auth /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-heading /<x-layout.heading /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-subheading /<x-layout.subheading /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-text /<x-layout.text /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-separator /<x-layout.separator /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-spacer /<x-layout.spacer /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-header /<x-layout.header /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-section-header /<x-layout.section-header /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-app-logo /<x-layout.app-logo /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-app-logo-icon /<x-layout.app-logo-icon /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-placeholder-pattern /<x-layout.placeholder-pattern /g' {} \;

# Data Components
echo "Migrating data components..."
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-table /<x-data.table /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-table.row /<x-data.table.row /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-table.cell /<x-data.table.cell /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-table.heading /<x-data.table.heading /g' {} \;

# Authentication Components
echo "Migrating authentication components..."
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-auth-header /<x-auth.auth-header /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-auth-session-status /<x-auth.auth-session-status /g' {} \;

# Feedback Components
echo "Migrating feedback components..."
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-error /<x-feedback.error /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-action-message /<x-feedback.action-message /g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-alert /<x-feedback.alert /g' {} \;

# Create backup directory
mkdir -p layout_backups
timestamp=$(date +%Y%m%d%H%M%S)

# Back up original files
echo "Creating backups of original files..."
cp resources/views/components/layout/app/header.blade.php layout_backups/header.blade.${timestamp}.bak
cp resources/views/components/layout/app/navigation.blade.php layout_backups/navigation.blade.${timestamp}.bak
cp resources/views/layouts/partials/navigation.blade.php layout_backups/partials_navigation.blade.${timestamp}.bak

# Update the header file to include navigation elements
echo "Updating header layout..."
cat > resources/views/components/layout/app/header.blade.php << 'EOL'
@props(['title' => null, 'withNav' => true, 'withFooter' => true])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || window.matchMedia('(prefers-color-scheme: dark)').matches }" :class="{ 'dark': darkMode }" class="h-full antialiased">
    <head>
        @include('partials.head')
    </head>
    <body class="font-sans text-gray-900 bg-white dark:bg-gray-950 dark:text-white flex min-h-screen flex-col">
        <x-ui.toast.container />
        <header class="z-10 bg-white dark:bg-gray-900 shadow-sm">
            <div class="px-4 sm:px-6 lg:px-8 mx-auto max-w-7xl">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                            <x-layout.app.logo />
                        </a>
                        
                        <!-- Main Navigation -->
                        <nav class="hidden md:ml-6 md:flex md:space-x-4">
                            <x-layout.navbar.item :href="route('dashboard')" :current="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-layout.navbar.item>
                            
                            <!-- Add other navigation items here -->
                        </nav>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Documentation and Repository Links -->
                        <div class="hidden md:flex md:items-center md:space-x-3">
                            <a href="https://github.com/imacrayon/blade-starter-kit" target="_blank" 
                               class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm font-medium">
                                {{ __('Repository') }}
                            </a>
                            <a href="https://laravel.com/docs/starter-kits" target="_blank" 
                               class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm font-medium">
                                {{ __('Documentation') }}
                            </a>
                        </div>
                        
                        <!-- Dark Mode Toggle -->
                        <x-ui.dark-mode-toggle />
                        
                        <!-- User Dropdown -->
                        @auth
                        <div x-data="{ open: false }" class="relative z-10">
                            <div>
                                <button
                                    type="button"
                                    class="bg-white dark:bg-gray-800 rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                    id="user-menu-button"
                                    x-on:click="open = !open"
                                    x-on:mousedown.away="open = false"
                                    aria-expanded="false"
                                    aria-haspopup="true"
                                >
                                    <span class="sr-only">Open user menu</span>
                                    <div class="h-8 w-8 rounded-full overflow-hidden bg-gray-200 dark:bg-gray-700 flex items-center justify-center uppercase font-medium">
                                        {{ auth()->user()->initials() }}
                                    </div>
                                </button>
                            </div>

                            <div
                                x-show="open"
                                x-on:keydown.escape.window="open = false"
                                x-on:mousedown.away="open = false"
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-800 dark:ring-gray-700"
                                x-description="user profile dropdown"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                style="display: none;"
                            >
                                <!-- User Account Menu -->
                                <div class="px-4 py-2 text-xs text-gray-500 dark:text-gray-400">
                                    {{ auth()->user()->name }}
                                </div>
                                <x-ui.dropdown.divider />
                                <x-ui.dropdown.item href="{{ route('settings.profile.edit') }}" icon="phosphor-gear-fine">
                                    {{ __('Settings') }}
                                </x-ui.dropdown.item>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-ui.dropdown.item href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" icon="phosphor-sign-out">
                                        {{ __('Log Out') }}
                                    </x-ui.dropdown.item>
                                </form>
                            </div>
                        </div>
                        @endauth
                        
                        <!-- Mobile menu button -->
                        <div class="flex items-center md:hidden">
                            <button type="button" class="flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 focus:text-gray-500 dark:focus:text-gray-400" x-on:click="$dispatch('toggle-mobile-menu')">
                                <x-ui.icon icon="phosphor-list" aria-hidden="true" width="20" height="20" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div x-data="{ open: false }" x-on:toggle-mobile-menu.window="open = !open" :class="{'block': open, 'hidden': !open}" class="hidden md:hidden border-t border-gray-200 dark:border-gray-700">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <x-layout.navlist.item :href="route('dashboard')" :current="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-layout.navlist.item>
                    <!-- Add other mobile navigation items here -->
                </div>
                
                <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-700">
                    @auth
                    <div class="px-4 flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center uppercase font-medium">
                                {{ auth()->user()->initials() }}
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-800 dark:text-gray-200">{{ auth()->user()->name }}</div>
                            <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                    
                    <div class="mt-3 px-2 space-y-1">
                        <x-layout.navlist.item :href="route('settings.profile.edit')">
                            {{ __('Settings') }}
                        </x-layout.navlist.item>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-layout.navlist.item href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-layout.navlist.item>
                        </form>
                    </div>
                    @endauth
                    
                    <div class="mt-3 px-2 space-y-1">
                        <x-layout.navlist.item href="https://github.com/imacrayon/blade-starter-kit" target="_blank">
                            {{ __('Repository') }}
                        </x-layout.navlist.item>
                        <x-layout.navlist.item href="https://laravel.com/docs/starter-kits" target="_blank">
                            {{ __('Documentation') }}
                        </x-layout.navlist.item>
                    </div>
                </div>
            </div>
        </header>

        {{ $slot }}
    </body>
</html>
EOL

echo "Updating navigation component..."
cat > resources/views/components/layout/app/navigation.blade.php << 'EOL'
<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-layout.app.logo />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-layout.navbar.item :href="route('home')" :current="request()->routeIs('home')">
                        {{ __('Dashboard') }}
                    </x-layout.navbar.item>
                    @if(Route::has('todos.index'))
                    <x-layout.navbar.item :href="route('todos.index')" :current="request()->routeIs('todos.*')">
                        {{ __('Todos') }}
                    </x-layout.navbar.item>
                    @endif
                    {{-- Add other main navigation links here --}}
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                
                <!-- Dark Mode Toggle -->
                <x-ui.dark-mode-toggle />
                
                <!-- Documentation and Repository Links -->
                <div class="hidden md:flex md:items-center md:space-x-3 ml-4">
                    <a href="https://github.com/imacrayon/blade-starter-kit" target="_blank" 
                       class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm font-medium">
                        {{ __('Repository') }}
                    </a>
                    <a href="https://laravel.com/docs/starter-kits" target="_blank" 
                       class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm font-medium">
                        {{ __('Documentation') }}
                    </a>
                </div>
                
                @guest
                    <x-layout.navbar.item :href="route('login')" :current="request()->routeIs('login')">
                        {{ __('Log in') }}
                    </x-layout.navbar.item>

                    @if (Route::has('register'))
                        <x-layout.navbar.item :href="route('register')" :current="request()->routeIs('register')" class="ml-4">
                            {{ __('Register') }}
                        </x-layout.navbar.item>
                    @endif
                 @else
                    {{-- Use Popover component for user menu --}}
                    <x-ui.popover align="bottom" justify="right">
                        {{-- Trigger slot --}}
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                             <div class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mr-2">
                                <span class="font-medium text-gray-600 dark:text-gray-300">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <x-ui.icon icon="heroicon-s-chevron-down" class="fill-current h-4 w-4" />
                            </div>
                        </button>

                        {{-- Menu slot --}}
                        <x-slot name="menu">
                             <x-ui.popover.item :href="route('settings.profile.edit')">
                                {{ __('Profile') }}
                            </x-ui.popover.item>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-ui.popover.item href="#"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-ui.popover.item>
                            </form>
                        </x-slot>
                    </x-ui.popover>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <x-ui.icon icon="heroicon-o-bars-3" x-show="!open" class="h-6 w-6" />
                    <x-ui.icon icon="heroicon-o-x-mark" x-show="open" class="h-6 w-6" style="display: none;" />
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-layout.navlist.item :href="route('home')" :current="request()->routeIs('home')">
                {{ __('Dashboard') }}
            </x-layout.navlist.item>
            @if(Route::has('todos.index'))
            <x-layout.navlist.item :href="route('todos.index')" :current="request()->routeIs('todos.*')">
                {{ __('Todos') }}
            </x-layout.navlist.item>
            @endif
            {{-- Add other main responsive navigation links here --}}
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
            @guest
                <div class="px-4">
                     <x-layout.navlist.item :href="route('login')" :current="request()->routeIs('login')">
                        {{ __('Log in') }}
                    </x-layout.navlist.item>

                    @if (Route::has('register'))
                        <x-layout.navlist.item :href="route('register')" :current="request()->routeIs('register')" class="mt-1">
                            {{ __('Register') }}
                        </x-layout.navlist.item>
                    @endif
                </div>
            @else
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-layout.navlist.item :href="route('settings.profile.edit')">
                        {{ __('Profile') }}
                    </x-layout.navlist.item>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-layout.navlist.item href="#"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-layout.navlist.item>
                    </form>
                </div>
            @endguest
            
            <!-- Documentation and Repository Links for mobile -->
            <div class="mt-3 space-y-1 px-4">
                <x-layout.navlist.item href="https://github.com/imacrayon/blade-starter-kit" target="_blank">
                    {{ __('Repository') }}
                </x-layout.navlist.item>
                <x-layout.navlist.item href="https://laravel.com/docs/starter-kits" target="_blank">
                    {{ __('Documentation') }}
                </x-layout.navlist.item>
            </div>
        </div>
    </div>
</nav>
EOL

echo "Updating partials navigation file..."
cat > resources/views/layouts/partials/navigation.blade.php << 'EOL'
<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <span class="text-2xl font-bold text-primary-600 dark:text-primary-400">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-layout.navbar.item :href="route('home')" :current="request()->routeIs('home')">
                        {{ __('Dashboard') }}
                    </x-layout.navbar.item>
                    @if(Route::has('todos.index'))
                    <x-layout.navbar.item :href="route('todos.index')" :current="request()->routeIs('todos.*')">
                        {{ __('Todos') }}
                    </x-layout.navbar.item>
                    @endif
                    {{-- Add other main navigation links here --}}
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                
                <!-- Dark Mode Toggle -->
                <x-ui.dark-mode-toggle />
                
                <!-- Documentation and Repository Links -->
                <div class="hidden md:flex md:items-center md:space-x-3 ml-4">
                    <a href="https://github.com/imacrayon/blade-starter-kit" target="_blank" 
                       class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm font-medium">
                        {{ __('Repository') }}
                    </a>
                    <a href="https://laravel.com/docs/starter-kits" target="_blank" 
                       class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm font-medium">
                        {{ __('Documentation') }}
                    </a>
                </div>
                
                @guest
                    <x-layout.navbar.item :href="route('login')" :current="request()->routeIs('login')">
                        {{ __('Log in') }}
                    </x-layout.navbar.item>

                    @if (Route::has('register'))
                        <x-layout.navbar.item :href="route('register')" :current="request()->routeIs('register')" class="ml-4">
                            {{ __('Register') }}
                        </x-layout.navbar.item>
                    @endif
                 @else
                    {{-- Use Popover component for user menu --}}
                    <x-ui.popover align="bottom" justify="right">
                        {{-- Trigger slot --}}
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                             <div class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mr-2">
                                {{-- Placeholder for user avatar or initial --}}
                                <span class="font-medium text-gray-600 dark:text-gray-300">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <x-ui.icon icon="heroicon-s-chevron-down" class="fill-current h-4 w-4" />
                            </div>
                        </button>

                        {{-- Menu slot --}}
                        <x-slot name="menu">
                             <x-ui.popover.item :href="route('settings.profile.edit')">
                                {{ __('Profile') }}
                            </x-ui.popover.item>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-ui.popover.item href="#"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-ui.popover.item>
                            </form>
                        </x-slot>
                    </x-ui.popover>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <x-ui.icon icon="heroicon-o-bars-3" x-show="!open" class="h-6 w-6" />
                    <x-ui.icon icon="heroicon-o-x-mark" x-show="open" class="h-6 w-6" style="display: none;" />
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-layout.navlist.item :href="route('home')" :current="request()->routeIs('home')">
                {{ __('Dashboard') }}
            </x-layout.navlist.item>
            @if(Route::has('todos.index'))
            <x-layout.navlist.item :href="route('todos.index')" :current="request()->routeIs('todos.*')">
                {{ __('Todos') }}
            </x-layout.navlist.item>
            @endif
            {{-- Add other main responsive navigation links here --}}
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
            @guest
                <div class="px-4">
                     <x-layout.navlist.item :href="route('login')" :current="request()->routeIs('login')">
                        {{ __('Log in') }}
                    </x-layout.navlist.item>

                    @if (Route::has('register'))
                        <x-layout.navlist.item :href="route('register')" :current="request()->routeIs('register')" class="mt-1">
                            {{ __('Register') }}
                        </x-layout.navlist.item>
                    @endif
                </div>
            @else
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-layout.navlist.item :href="route('settings.profile.edit')">
                        {{ __('Profile') }}
                    </x-layout.navlist.item>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-layout.navlist.item href="#"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-layout.navlist.item>
                    </form>
                </div>
            @endguest
            
            <!-- Documentation and Repository Links for mobile -->
            <div class="mt-3 space-y-1 px-4">
                <x-layout.navlist.item href="https://github.com/imacrayon/blade-starter-kit" target="_blank">
                    {{ __('Repository') }}
                </x-layout.navlist.item>
                <x-layout.navlist.item href="https://laravel.com/docs/starter-kits" target="_blank">
                    {{ __('Documentation') }}
                </x-layout.navlist.item>
            </div>
        </div>
    </div>
</nav>
EOL

echo "Creating necessary component directories..."

# Create necessary component directories if they don't exist
mkdir -p resources/views/components/layout
mkdir -p resources/views/components/input
mkdir -p resources/views/components/ui
mkdir -p resources/views/components/data
mkdir -p resources/views/components/auth
mkdir -p resources/views/components/feedback

echo "Moving component files to their appropriate directories..."

# Function to move component files while preserving directory structure
move_components() {
    local source_dir=$1
    local target_dir=$2
    local components=$3
    
    for component in $components; do
        # Check if the file exists
        if [ -f "resources/views/components/${component}.blade.php" ]; then
            # Create target directory if it doesn't exist
            mkdir -p "resources/views/components/${target_dir}"
            # Move the file
            mv "resources/views/components/${component}.blade.php" "resources/views/components/${target_dir}/"
            echo "Moved ${component}.blade.php to ${target_dir}/"
        fi
    done
}

# Move input components
input_components="input form textarea select checkbox radio input-error label"
move_components "components" "input" "$input_components"

# Move UI components
ui_components="button card avatar badge dropdown-item dropdown-menu modal empty-state container link dark-mode-toggle status"
move_components "components" "ui" "$ui_components"

# Move layout components
layout_components="app auth heading subheading text separator spacer header section-header app-logo app-logo-icon placeholder-pattern"
move_components "components" "layout" "$layout_components"

# Move data components
data_components="table"
move_components "components" "data" "$data_components"

# Move data subcomponents
mkdir -p resources/views/components/data/table
for subcomponent in row cell heading; do
    if [ -f "resources/views/components/table/${subcomponent}.blade.php" ]; then
        mv "resources/views/components/table/${subcomponent}.blade.php" "resources/views/components/data/table/"
        echo "Moved table/${subcomponent}.blade.php to data/table/"
    fi
done

# Move auth components
auth_components="auth-header auth-session-status"
move_components "components" "auth" "$auth_components"

# Move feedback components
feedback_components="error action-message alert"
move_components "components" "feedback" "$feedback_components"

# Update nested component references in blade files
echo "Updating nested component references in blade files..."
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<\/x-layouts.app>/<\/x-layout.app>/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<\/x-layouts.auth>/<\/x-layout.auth>/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<\/x-table>/<\/x-data.table>/g' {} \;

echo "Script completed. Layout components have been updated to move navigation to the top."
echo "Backups of original files were saved to the layout_backups directory."
echo "You may need to clear your application cache with: php artisan view:clear"

# Make the script executable
chmod +x migrate-components.sh 