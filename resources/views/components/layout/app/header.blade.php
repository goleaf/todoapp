<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="layout min-h-screen bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300">
        <x-layout.header class="border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
            <x-ui.container class="flex items-center">
                <x-sidebar.toggle class="lg:hidden w-10 p-0">
                    <x-phosphor-list aria-hidden="true" width="20" height="20" />
                </x-sidebar.toggle>

                <a href="{{ route('dashboard') }}" class="ml-2 mr-5 flex items-center space-x-2 lg:ml-0">
                    <x-layout.app-logo />
                </a>

                <x-layout.navbar class="-mb-px max-lg:hidden">
                    <x-layout.navbar.item before="phosphor-house-line" :href="route('dashboard')" :current="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-layout.navbar.item>
                </x-layout.navbar>

                <x-layout.spacer />

                <x-layout.navbar class="mr-1.5 space-x-0.5 py-0!">
                    <x-layout.navbar.item class="!h-10 [&>div>svg]:size-5" before="phosphor-magnifying-glass" href="#" label="Search" />
                    <x-layout.navbar.item
                        class="h-10 max-lg:hidden [&>div>svg]:size-5"
                        before="phosphor-git-branch"
                        href="https://github.com/imacrayon/blade-starter-kit"
                        target="_blank"
                        label="Repository"
                    />
                    <x-layout.navbar.item
                        class="h-10 max-lg:hidden [&>div>svg]:size-5"
                        before="phosphor-book-open-text"
                        href="https://laravel.com/docs/starter-kits"
                        target="_blank"
                        label="Documentation"
                    />
                </x-layout.navbar>

                <!-- Desktop User Menu -->
                <x-ui.popover align="top" justify="right">
                    <button type="button" class="w-full group flex items-center rounded-lg p-1 hover:bg-gray-800/5 dark:hover:bg-white/10">
                        <span class="shrink-0 size-8 bg-gray-200 rounded-sm overflow-hidden dark:bg-gray-700">
                            <span class="w-full h-full flex items-center justify-center text-sm">
                                {{ auth()->user()->initials() }}
                            </span>
                        </span>
                        <span class="shrink-0 ml-auto size-8 flex justify-center items-center">
                            <x-phosphor-caret-down width="16" height="16" class="text-gray-400 dark:text-white/80 group-hover:text-gray-800 dark:group-hover:text-white" />
                        </span>
                    </button>
                    <x-slot:menu class="w-max">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span class="flex h-full w-full items-center justify-center rounded-lg bg-gray-200 text-black dark:bg-gray-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>
                            <div class="grid flex-1 text-left text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                        <x-ui.popover.separator />
                        <x-ui.popover.item before="phosphor-gear-fine" href="/settings/profile">{{ __('Settings') }}</x-ui.popover.item>
                        <x-ui.popover.separator />
                        <x-input.form method="post" action="{{ route('logout') }}" class="w-full flex">
                            <x-ui.popover.item before="phosphor-sign-out">{{ __('Log Out') }}</x-ui.popover.item>
                        </x-input.form>
                    </x-slot:menu>
                </x-ui.popover>
            </x-ui.container>
        </x-layout.header>

        <!-- Mobile Menu -->
        <x-sidebar stashable sticky class="lg:hidden border-r border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
            <x-sidebar.toggle class="lg:hidden w-10 p-0">
                <x-phosphor-x aria-hidden="true" width="20" height="20" />
            </x-sidebar.toggle>

            <a href="{{ route('dashboard') }}" class="ml-1 flex items-center space-x-2">
                <x-layout.app-logo />
            </a>

            <x-layout.navlist>
                <x-layout.navlist.group :heading="__('Platform')">
                    <x-layout.navlist.item before="phosphor-squares-four" :href="route('dashboard')" :current="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                    </x-navlist.item>
                </x-navlist.group>
            </x-navlist>

            <x-layout.spacer />

            <x-layout.navlist>
                <x-layout.navlist.item before="phosphor-git-pull-request" href="https://github.com/imacrayon/blade-starter-kit" target="_blank">
                {{ __('Repository') }}
                </x-navlist.item>

                <x-layout.navlist.item before="phosphor-book-open-text" href="https://github.com/imacrayon/blade-starter-kit" target="_blank">
                {{ __('Documentation') }}
                </x-navlist.item>
            </x-navlist>
        </x-sidebar>

        {{ $slot }}

    </body>
</html>
