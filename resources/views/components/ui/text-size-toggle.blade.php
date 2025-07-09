@props(['class' => ''])

















<div 
    x-data="textSize()" 
    class="relative"
    {{ $attributes->merge(['class' => $class]) }}
>
    <button 
        type="button" 
        x-on:click="$refs.menu.classList.toggle('hidden'); if(!$refs.menu.classList.contains('hidden')) { setTimeout(() => $refs.firstItem.focus(), 10); }"
        class="relative p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-800 focus:ring-primary-500 group"
        aria-label="{{ __('Text Size') }}"
        aria-haspopup="true"
        aria-expanded="false"
        x-on:click="$el.setAttribute('aria-expanded', $refs.menu.classList.contains('hidden') ? 'false' : 'true')"
    >
        <span class="sr-only">{{ __('Text Size') }}</span>
        <x-ui.icon icon="heroicon-o-document-text" class="h-5 w-5" />
        
        <!-- Current text size indicator -->
        <span 
            class="absolute -top-1 -right-1 bg-primary-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-[10px] font-bold"
            x-text="getCurrentSizeIndicator()"
        ></span>
    </button>

    <!-- Dropdown menu -->
    <div 
        x-ref="menu" 
        x-on:keydown.escape.window="$refs.menu.classList.add('hidden')"
        x-on:click.away="$refs.menu.classList.add('hidden')"
        x-on:keydown.tab="handleTabKey($event)"
        x-on:keydown.shift.tab="handleShiftTabKey($event)"
        x-on:keydown.arrow-down.prevent="focusNextItem()"
        x-on:keydown.arrow-up.prevent="focusPreviousItem()"
        x-on:keydown.enter.prevent="document.activeElement.click()"
        x-on:keydown.space.prevent="document.activeElement.click()"
        class="absolute right-0 mt-2 w-48 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 hidden dark:bg-gray-800 dark:ring-gray-700 z-10"
        role="menu"
        aria-orientation="vertical"
        aria-labelledby="text-size-menu"
    >
        <div class="py-1">
            <button
                type="button"
                x-ref="firstItem"
                class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 focus:text-gray-900 dark:focus:text-gray-100"
                x-on:click="setTextSize('small'); $refs.menu.classList.add('hidden')"
                x-bind:class="{ 'bg-gray-100 dark:bg-gray-700': localStorage.getItem('textSize') === 'small' }"
                role="menuitem"
                tabindex="0"
            >
                <span class="text-sm">{{ __('Small') }}</span>
            </button>
            
            <button
                type="button"
                class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 focus:text-gray-900 dark:focus:text-gray-100"
                x-on:click="setTextSize('medium'); $refs.menu.classList.add('hidden')"
                x-bind:class="{ 'bg-gray-100 dark:bg-gray-700': localStorage.getItem('textSize') === 'medium' || !localStorage.getItem('textSize') }"
                role="menuitem"
                tabindex="0"
            >
                <span class="text-base">{{ __('Medium') }}</span>
            </button>
            
            <button
                type="button"
                class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 focus:text-gray-900 dark:focus:text-gray-100"
                x-on:click="setTextSize('large'); $refs.menu.classList.add('hidden')"
                x-bind:class="{ 'bg-gray-100 dark:bg-gray-700': localStorage.getItem('textSize') === 'large' }"
                role="menuitem"
                tabindex="0"
            >
                <span class="text-lg">{{ __('Large') }}</span>
            </button>
            
            <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>
            
            <button
                type="button"
                x-ref="lastItem"
                class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 focus:text-gray-900 dark:focus:text-gray-100"
                x-on:click="resetTextSize(); $refs.menu.classList.add('hidden')"
                role="menuitem"
                tabindex="0"
            >
                <div class="flex items-center">
                    <x-ui.icon icon="heroicon-o-arrow-path" class="h-4 w-4 mr-2" />
                    <span>{{ __('Reset to Default') }}</span>
                </div>
            </button>
        </div>
    </div>
</div> 