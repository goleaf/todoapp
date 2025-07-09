@props(['class' => ''])

















<button 
    id="high-contrast-toggle"
    type="button" 
    class="high-contrast-toggle relative p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-800 focus:ring-primary-500 {{ $class }}"
    aria-pressed="false"
    title="{{ __('Toggle high contrast mode (Alt+H)') }}">
    
    <span class="sr-only">{{ __('Toggle high contrast mode') }}</span>
    
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10"></circle>
        <path d="M12 2a10 10 0 0 1 0 20 10 10 0 0 1 0-20z"></path>
        <path d="M12 2v20"></path>
    </svg>
</button>

<!-- Screen reader announcements area -->
<div class="sr-announcement sr-only" aria-live="polite" aria-atomic="true"></div> 