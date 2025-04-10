<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        {{-- Replace with SVG Logo --}}
                         <span class="text-2xl font-bold text-primary-600 dark:text-primary-400">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-layout.navbar.item :href="route('home')" :current="request()->routeIs('home')">
                        {{ __('Dashboard') }}
                    </x-layout.navbar.item>
                     <x-layout.navbar.item :href="route('todos.index')" :current="request()->routeIs('todos.*')">
                        {{ __('Todos') }}
                    </x-layout.navbar.item>
                    {{-- Add other main navigation links here --}}
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                
                <!-- Dark Mode Toggle -->
                <x-ui.dark-mode-toggle />
                
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
                    {{-- Use Popover component instead of Dropdown --}}
                    <x-ui.popover align="bottom" justify="right">
                        {{-- Trigger slot --}}
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                             <div class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mr-2">
                                {{-- Placeholder for user avatar or initial --}}
                                <span class="font-medium text-gray-600 dark:text-gray-300">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <x-ui.icon.heroicon-s-chevron-down class="fill-current h-4 w-4" />
                            </div>
                        </button>

                        {{-- Menu slot --}}
                        <x-slot name="menu">
                             {{-- <x-ui.popover.item :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-ui.popover.item> --}}

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
                    <x-ui.icon.heroicon-o-bars-3 x-show="!open" class="h-6 w-6" />
                    <x-ui.icon.heroicon-o-x-mark x-show="open" class="h-6 w-6" style="display: none;" />
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
             <x-layout.navlist.item :href="route('todos.index')" :current="request()->routeIs('todos.*')">
                {{ __('Todos') }}
            </x-layout.navlist.item>
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
                    {{-- <x-layout.navlist.item :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-layout.navlist.item> --}}

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
        </div>
    </div>
</nav> 