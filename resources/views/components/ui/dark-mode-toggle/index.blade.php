@props(['class' => ''])

<button 
    x-data="{ 
        darkMode: localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),
        toggle() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    }" 
    @click="toggle()" 
    type="button" 
    {{ $attributes->merge(['class' => 'relative p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-800 focus:ring-primary-500 ' . $class]) }}>
        
    <span class="sr-only" x-text="darkMode ? 'Switch to light mode' : 'Switch to dark mode'"></span>
    
    <template x-if="darkMode">
        <x-heroicon-o-sun class="h-5 w-5" />
    </template>
    
    <template x-if="!darkMode">
        <x-heroicon-o-moon class="h-5 w-5" />
    </template>
</button> 