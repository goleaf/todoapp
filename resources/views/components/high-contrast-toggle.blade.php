{{-- High Contrast Toggle Button Component --}}
<div class="accessibility-control high-contrast-control">
    <button id="high-contrast-toggle" 
            class="high-contrast-toggle" 
            aria-pressed="false"
            title="{{ __('accessibility.toggle_high_contrast') }} (Alt+H)">
        <span class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M12 2a10 10 0 0 1 0 20 10 10 0 0 1 0-20z"></path>
                <path d="M12 2v20"></path>
            </svg>
        </span>
        <span class="label">{{ __('accessibility.high_contrast') }}: <span class="status-text">Off</span></span>
    </button>
</div>

<!-- Screen reader announcements area -->
<div class="sr-announcement sr-only" aria-live="polite" aria-atomic="true"></div> 