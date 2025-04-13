<div class="w-full">
    <!-- Horizontal Tabs for Desktop and Tablet -->
    <div class="hidden md:block mb-8 border-b border-gray-200 dark:border-gray-700">
        <nav class="flex -mb-px">
            <x-layout.navbar.item 
                :href="route('settings.profile.edit')" 
                :current="request()->routeIs('settings.profile.edit')"
                class="px-6 py-3 text-sm font-medium"
            >
                {{ __('Profile') }}
            </x-layout.navbar.item>
            
            <x-layout.navbar.item 
                :href="route('settings.password.edit')" 
                :current="request()->routeIs('settings.password.edit')"
                class="px-6 py-3 text-sm font-medium"
            >
                {{ __('Password') }}
            </x-layout.navbar.item>
            
            <x-layout.navbar.item 
                :href="route('settings.appearance.edit')" 
                :current="request()->routeIs('settings.appearance.edit')"
                class="px-6 py-3 text-sm font-medium"
            >
                {{ __('Appearance') }}
            </x-layout.navbar.item>
        </nav>
    </div>

    <!-- Vertical List for Mobile -->
    <div class="md:hidden mb-6">
        <x-ui.dropdown>
            <x-slot name="trigger">
                <x-ui.button variant="secondary" class="w-full justify-between">
                    @if(request()->routeIs('settings.profile.edit'))
                        {{ __('Profile') }}
                    @elseif(request()->routeIs('settings.password.edit'))
                        {{ __('Password') }}
                    @elseif(request()->routeIs('settings.appearance.edit'))
                        {{ __('Appearance') }}
                    @else
                        {{ __('Settings') }}
                    @endif
                    <x-ui.icon icon="phosphor-caret-down" class="ml-2" />
                </x-ui.button>
            </x-slot>
            
            <x-ui.dropdown.item :href="route('settings.profile.edit')">
                {{ __('Profile') }}
            </x-ui.dropdown.item>
            
            <x-ui.dropdown.item :href="route('settings.password.edit')">
                {{ __('Password') }}
            </x-ui.dropdown.item>
            
            <x-ui.dropdown.item :href="route('settings.appearance.edit')">
                {{ __('Appearance') }}
            </x-ui.dropdown.item>
        </x-ui.dropdown>
    </div>

    <div class="w-full">
        <x-layout.heading>{{ $heading ?? '' }}</x-layout.heading>
        <x-layout.subheading>{{ $subheading ?? '' }}</x-layout.subheading>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
