<x-layout.sidebar sticky stashable class="border-r border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
    <x-layout.sidebar.toggle class="lg:hidden w-10 p-0">
        <x-ui.icon icon="phosphor-x" aria-hidden="true" width="20" height="20" />
    </x-layout.sidebar.toggle>

    <a href="{{ route('dashboard') }}" class="mb-2 flex items-center space-x-2">
        <x-layout.app.logo />
    </a>

    <x-layout.navlist>
        <x-layout.navlist.group :heading="__('navigation.platform')" class="mb-2">
            <x-layout.navlist.item before="phosphor-house-line" :href="route('dashboard')" :current="request()->routeIs('dashboard')">
                {{ __('common.dashboard') }}
            </x-layout.navlist.item>
        </x-layout.navlist.group>
    </x-layout.navlist>

    <x-layout.spacer />

    <x-layout.navlist>
        <x-layout.navlist.item before="phosphor-git-pull-request" href="https://github.com/imacrayon/blade-starter-kit" target="_blank" class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
        {{ __('Repository') }}
        </x-layout.navlist.item>

        <x-layout.navlist.item before="phosphor-book-open-text" href="https://laravel.com/docs/starter-kits" target="_blank" class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
        {{ __('Documentation') }}
        </x-layout.navlist.item>
    </x-layout.navlist>

    <x-ui.popover align="bottom" justify="left">
        <button type="button" class="w-full group flex items-center rounded-lg p-1 hover:bg-gray-800/5 dark:hover:bg-white/10">
            <span class="shrink-0 size-8 bg-gray-200 rounded-sm overflow-hidden dark:bg-gray-700">
                <span class="w-full h-full flex items-center justify-center text-sm">
                    {{ auth()->user()->initials() }}
                </span>
            </span>
            <span class="ml-2 text-sm text-gray-500 dark:text-white/80 group-hover:text-gray-800 dark:group-hover:text-white font-medium truncate">
                {{ auth()->user()->name }}
            </span>
            <span class="shrink-0 ml-auto size-8 flex justify-center items-center">
                <x-ui.icon icon="phosphor-caret-up-down" aria-hidden="true" width="16" height="16" class="text-gray-400 dark:text-white/80 group-hover:text-gray-800 dark:group-hover:text-white" />
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
</x-layout.sidebar>
