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
                        <!-- Mobile menu button -->
                        <div class="flex items-center mr-2 md:hidden">
                            <button 
                                type="button" 
                                class="flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 focus:text-gray-500 dark:focus:text-gray-400" 
                                x-on:click="$refs.mobileMenu.open = !$refs.mobileMenu.open"
                                aria-label="{{ __('common.toggle_mobile_menu') }}"
                            >
                                <x-ui.icon icon="phosphor-list" aria-hidden="true" width="20" height="20" />
                            </button>
                        </div>
                        
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                            <x-layout.app.logo />
                        </a>
                        
                        <!-- Main Navigation -->
                        <nav class="hidden md:ml-6 md:flex md:space-x-4">
                            <x-layout.navbar.item :href="route('dashboard')" :current="request()->routeIs('dashboard')">
                                {{ __('common.dashboard') }}
                            </x-layout.navbar.item>
                            
                            @if(Route::has('todos.index'))
                            <x-layout.navbar.item :href="route('todos.index')" :current="request()->routeIs('todos.*')">
                                {{ __('common.todos') }}
                            </x-layout.navbar.item>
                            @endif
                            
                            @if(Route::has('categories.index'))
                            <x-layout.navbar.item :href="route('categories.index')" :current="request()->routeIs('categories.*')">
                                {{ __('common.categories') }}
                            </x-layout.navbar.item>
                            @endif
                            
                            <!-- Add other navigation items here -->
                        </nav>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Documentation and Repository Links -->
                        <!-- Removed repository and documentation links as per todo.md -->
                        
                        <!-- Accessibility Menu -->
                        <x-ui.accessibility-menu />
                        
                        <!-- Language Switcher -->
                        <x-ui.language-switcher />
                        
                        <!-- Theme Switcher -->
                        <div class="relative" x-data="{ open: false }">
                            <x-ui.theme-switcher />
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
                                    <span class="sr-only">{{ __('common.user_menu_open') }}</span>
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
                                    {{ __('common.settings') }}
                                </x-ui.dropdown.item>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-ui.dropdown.item href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" icon="phosphor-sign-out">
                                        {{ __('common.logout') }}
                                    </x-ui.dropdown.item>
                                </form>
                            </div>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Mobile menu -->
        <div x-data="{ open: false }" x-ref="mobileMenu">
            <x-layout.app.mobile-menu />
        </div>

        {{ $slot }}
    </body>
</html>
