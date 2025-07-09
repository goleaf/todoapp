@props([])



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
                        {{ __('navigation.dashboard') }}
                    </x-layout.navbar.item>
                    @if(Route::has('todos.index'))
                    <x-layout.navbar.item :href="route('todos.index')" :current="request()->routeIs('todos.*')">
                        {{ __('navigation.todos') }}
                    </x-layout.navbar.item>
                    @endif
                    <x-layout.navbar.item :href="route('help')" :current="request()->routeIs('help')">
                        {{ __('navigation.help') }}
                    </x-layout.navbar.item>
                    {{-- Add other main navigation links here --}}
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                
                <!-- Text Size Toggle -->
                <x-ui.text-size-toggle />
                
                <!-- Dark Mode Toggle -->
                <x-ui.dark-mode-toggle />
                
                <!-- Documentation and Repository Links -->
                <div class="hidden md:flex md:items-center md:space-x-3 ml-4">
                    <a href="https://github.com/imacrayon/blade-starter-kit" target="_blank" 
                       class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm font-medium">
                        {{ __('navigation.repository') }}
                    </a>
                    <a href="https://laravel.com/docs/starter-kits" target="_blank" 
                       class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm font-medium">
                        {{ __('navigation.documentation') }}
                    </a>
                </div>
                
                @guest
                    <x-layout.navbar.item :href="route('login')" :current="request()->routeIs('login')">
                        {{ __('navigation.log_in') }}
                    </x-layout.navbar.item>

                    @if (Route::has('register'))
                        <x-layout.navbar.item :href="route('register')" :current="request()->routeIs('register')" class="ml-4">
                            {{ __('navigation.register') }}
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
                                {{ __('navigation.profile') }}
                            </x-ui.popover.item>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-ui.popover.item href="#"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('navigation.log_out') }}
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
                {{ __('navigation.dashboard') }}
            </x-layout.navlist.item>
            @if(Route::has('todos.index'))
            <x-layout.navlist.item :href="route('todos.index')" :current="request()->routeIs('todos.*')">
                {{ __('navigation.todos') }}
            </x-layout.navlist.item>
            @endif
            <x-layout.navlist.item :href="route('help')" :current="request()->routeIs('help')">
                {{ __('navigation.help') }}
            </x-layout.navlist.item>
            {{-- Add other main responsive navigation links here --}}
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
            @guest
                <div class="px-4">
                     <x-layout.navlist.item :href="route('login')" :current="request()->routeIs('login')">
                        {{ __('navigation.log_in') }}
                    </x-layout.navlist.item>

                    @if (Route::has('register'))
                        <x-layout.navlist.item :href="route('register')" :current="request()->routeIs('register')" class="mt-1">
                            {{ __('navigation.register') }}
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
                        {{ __('navigation.profile') }}
                    </x-layout.navlist.item>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-layout.navlist.item href="#"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('navigation.log_out') }}
                        </x-layout.navlist.item>
                    </form>
                </div>
            @endguest
            
            <!-- Documentation and Repository Links for mobile -->
            <div class="mt-3 space-y-1 px-4">
                <x-layout.navlist.item href="https://github.com/imacrayon/blade-starter-kit" target="_blank">
                    {{ __('navigation.repository') }}
                </x-layout.navlist.item>
                <x-layout.navlist.item href="https://laravel.com/docs/starter-kits" target="_blank">
                    {{ __('navigation.documentation') }}
                </x-layout.navlist.item>
            </div>
            
            <!-- Text Size Settings for mobile -->
            <div x-data="textSize()" class="mt-3 space-y-1 px-4 border-t border-gray-200 dark:border-gray-700 pt-3">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                    {{ __('navigation.text_size') }}
                </div>
                <div class="flex space-x-2">
                    <button 
                        type="button"
                        class="px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none"
                        x-on:click="setTextSize('small')"
                        x-bind:class="{ 'bg-gray-100 dark:bg-gray-700': localStorage.getItem('textSize') === 'small' }"
                    >
                        <span class="text-sm">{{ __('navigation.small') }}</span>
                    </button>
                    
                    <button 
                        type="button"
                        class="px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none"
                        x-on:click="setTextSize('medium')"
                        x-bind:class="{ 'bg-gray-100 dark:bg-gray-700': localStorage.getItem('textSize') === 'medium' || !localStorage.getItem('textSize') }"
                    >
                        <span class="text-base">{{ __('navigation.medium') }}</span>
                    </button>
                    
                    <button 
                        type="button"
                        class="px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none"
                        x-on:click="setTextSize('large')"
                        x-bind:class="{ 'bg-gray-100 dark:bg-gray-700': localStorage.getItem('textSize') === 'large' }"
                    >
                        <span class="text-lg">{{ __('navigation.large') }}</span>
                    </button>
                </div>
            </div>
            
            <!-- Dark Mode Toggle for mobile -->
            <div class="mt-3 space-y-1 px-4 border-t border-gray-200 dark:border-gray-700 pt-3">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                    {{ __('navigation.appearance') }}
                </div>
                <div x-data="{ mode: localStorage.getItem('darkMode') === 'true' ? 'dark' : 'light' }">
                    <div class="flex space-x-2">
                        <button 
                            type="button"
                            class="px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none"
                            x-on:click="localStorage.setItem('darkMode', 'false'); window.location.reload();"
                            x-bind:class="{ 'bg-gray-100 dark:bg-gray-700': mode === 'light' }"
                        >
                            <div class="flex items-center">
                                <x-ui.icon icon="heroicon-o-sun" class="h-5 w-5 mr-1" />
                                <span>{{ __('navigation.light') }}</span>
                            </div>
                        </button>
                        
                        <button 
                            type="button"
                            class="px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none"
                            x-on:click="localStorage.setItem('darkMode', 'true'); window.location.reload();"
                            x-bind:class="{ 'bg-gray-100 dark:bg-gray-700': mode === 'dark' }"
                        >
                            <div class="flex items-center">
                                <x-ui.icon icon="heroicon-o-moon" class="h-5 w-5 mr-1" />
                                <span>{{ __('navigation.dark') }}</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
