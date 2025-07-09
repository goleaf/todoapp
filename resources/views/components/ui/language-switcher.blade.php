@props([])

















<div class="language-switcher">
    <div class="relative" x-data="{ open: false }">
        <button 
            @click="open = !open" 
            @keydown.escape="open = false"
            class="flex items-center space-x-2 px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
            aria-label="{{ __('messages.select_language') }}"
        >
            <span class="text-sm font-medium">
                {{-- PHP logic moved to BladeComponentService --}}
                <span class="flex items-center">
                    <span class="text-xs mr-2">{{ $currentFlag }}</span>
                    {{ $currentLangName }}
                </span>
            </span>
            <x-ui.icon icon="heroicon-m-chevron-down" class="h-4 w-4" />
        </button>
        
        <div 
            x-show="open" 
            @click.away="open = false"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="language-menu-button"
            tabindex="-1"
            style="display: none;"
        >
            <div class="py-1" role="none">
                @php
                    $availableLanguages = \App\Helpers\TranslationHelper::getAvailableLanguages();
                    $flagMap = \App\Helpers\LanguageHelper::getFlagMap();
                @endphp
                
                @foreach(array_keys($availableLanguages) as $localeCode)
                    @php
                        $nativeName = \Locale::getDisplayName($localeCode, $localeCode);
                        $flag = $flagMap[$localeCode] ?? '🌐';
                    @endphp
                    <x-ui.link 
                        href="{{ route('language.switch', $localeCode) }}" 
                        class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 {{ app()->getLocale() == $localeCode ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                        role="menuitem"
                        tabindex="-1"
                    >
                        <span class="text-xs mr-2">{{ $flag }}</span>
                        {{ $nativeName }}
                    </x-ui.link>
                @endforeach
            </div>
        </div>
    </div>
</div> 