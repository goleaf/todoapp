<x-layout.header class="lg:hidden">
    <x-ui.container class="min-h-14 flex items-center">
        <x-layout.sidebar.toggle class="lg:hidden w-10 p-0">
            <x-phosphor-list aria-hidden="true" width="20" height="20" />
        </x-layout.sidebar.toggle>

        <x-layout.spacer />

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
            <x-slot:menu>
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