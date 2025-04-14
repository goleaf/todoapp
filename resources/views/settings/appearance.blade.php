<x-layout.app :title="__('Appearance | Settings')">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Appearance')" :subheading=" __('Update the appearance settings for your account')">
        <!-- Theme Settings -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('Theme') }}</h3>
            <fieldset>
                <legend class="sr-only">Theme</legend>
                <x-ui.button.group>
                    <x-ui.button type="button" variant="secondary" before="heroicon-o-sun" value="light" onclick="setAppearance(this.value)">{{ __('Light') }}</x-ui.button>
                    <x-ui.button type="button" variant="secondary" before="heroicon-o-moon" value="dark" onclick="setAppearance(this.value)">{{ __('Dark') }}</x-ui.button>
                    <x-ui.button type="button" variant="secondary" before="heroicon-o-computer-desktop" value="system" onclick="setAppearance(this.value)">{{ __('System') }}</x-ui.button>
                </x-ui.button.group>
            </fieldset>
        </div>

        <!-- Text Size Settings -->
        <div x-data="textSize()">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('Text Size') }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ __('Choose the text size that is most comfortable for you to read.') }}</p>
            
            <fieldset>
                <legend class="sr-only">Text Size</legend>
                <x-ui.button.group>
                    <x-ui.button 
                        type="button" 
                        variant="secondary" 
                        value="small" 
                        x-on:click="setTextSize('small')"
                        class="text-sm"
                        x-bind:class="{ 'bg-gray-200 dark:bg-gray-600': localStorage.getItem('textSize') === 'small' }"
                    >
                        {{ __('Small') }}
                    </x-ui.button>
                    
                    <x-ui.button 
                        type="button" 
                        variant="secondary" 
                        value="medium" 
                        x-on:click="setTextSize('medium')"
                        class="text-base"
                        x-bind:class="{ 'bg-gray-200 dark:bg-gray-600': localStorage.getItem('textSize') === 'medium' || !localStorage.getItem('textSize') }"
                    >
                        {{ __('Medium') }}
                    </x-ui.button>
                    
                    <x-ui.button 
                        type="button" 
                        variant="secondary" 
                        value="large" 
                        x-on:click="setTextSize('large')"
                        class="text-lg"
                        x-bind:class="{ 'bg-gray-200 dark:bg-gray-600': localStorage.getItem('textSize') === 'large' }"
                    >
                        {{ __('Large') }}
                    </x-ui.button>
                </x-ui.button.group>
            </fieldset>
            
            <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">{{ __('Preview') }}</h4>
                <p class="mb-2" x-bind:class="{
                    'text-sm': localStorage.getItem('textSize') === 'small',
                    'text-base': !localStorage.getItem('textSize') || localStorage.getItem('textSize') === 'medium',
                    'text-lg': localStorage.getItem('textSize') === 'large'
                }">{{ __('This is a preview of how text will appear throughout the app.') }}</p>
                
                <div class="mt-2 grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <x-ui.badge color="green">{{ __('Completed Task') }}</x-ui.badge>
                    </div>
                    <div>
                        <x-ui.badge color="blue">{{ __('In Progress Task') }}</x-ui.badge>
                    </div>
                </div>
            </div>
        </div>
    </x-settings.layout>
</div>

@push('scripts')
<script>
    // Set theme function (already exists)
    function setAppearance(value) {
        const appearance = localStorage.appearance = value;
        
        if (appearance === 'dark' || (appearance === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
</script>
@endpush

</x-layout.app>
