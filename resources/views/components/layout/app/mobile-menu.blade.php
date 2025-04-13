<div 
    x-data="{}"
    x-show="$store.sidebar.open"
    class="md:hidden border-t border-gray-200 dark:border-gray-700"
>
    <div class="px-2 pt-2 pb-3 space-y-1">
        <x-layout.navlist.item :href="route('dashboard')" :current="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-layout.navlist.item>
        
        @if(Route::has('todos.index'))
        <x-layout.navlist.item :href="route('todos.index')" :current="request()->routeIs('todos.*')">
            {{ __('Todos') }}
        </x-layout.navlist.item>
        @endif
        
        @if(auth()->check() && auth()->user()->hasRole('admin'))
        <x-layout.navlist.item :href="route('admin.todos.index')" :current="request()->routeIs('admin.todos.*')">
            {{ __('Admin') }}
        </x-layout.navlist.item>
        @endif
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