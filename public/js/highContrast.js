/**
 * High Contrast Mode Functionality
 * 
 * This script handles high contrast mode functionality, including:
 * - Toggling high contrast mode on/off
 * - Persisting user preferences with localStorage
 * - Keyboard shortcut support (Alt+H)
 * - Announcing changes to screen readers
 */

function initHighContrast() {
    // Constants
    const HIGH_CONTRAST_CLASS = 'high-contrast-mode';
    const HIGH_CONTRAST_STORAGE_KEY = 'highContrastMode';
    
    // Get DOM elements
    const htmlElement = document.documentElement;
    const toggleButton = document.getElementById('high-contrast-toggle');
    const menuToggleButton = document.getElementById('high-contrast-toggle-menu');
    const allToggleButtons = [toggleButton, menuToggleButton].filter(Boolean);
    const srAnnouncements = document.querySelectorAll('.sr-announcement');
    
    // Initialize high contrast state from localStorage
    const isHighContrastEnabled = localStorage.getItem(HIGH_CONTRAST_STORAGE_KEY) === 'true';
    
    // Apply initial state
    if (isHighContrastEnabled) {
        enableHighContrast();
    } else {
        disableHighContrast();
    }
    
    // Add event listeners to all toggle buttons
    allToggleButtons.forEach(button => {
        if (button) {
            button.addEventListener('click', toggleHighContrast);
        }
    });
    
    // Add keyboard shortcut event listener (Alt+H)
    document.addEventListener('keydown', function(event) {
        if (event.altKey && event.key === 'h') {
            toggleHighContrast();
            event.preventDefault();
        }
    });
    
    /**
     * Toggle high contrast mode
     */
    function toggleHighContrast() {
        const isEnabled = htmlElement.classList.contains(HIGH_CONTRAST_CLASS);
        
        if (isEnabled) {
            disableHighContrast();
        } else {
            enableHighContrast();
        }
    }
    
    /**
     * Enable high contrast mode
     */
    function enableHighContrast() {
        // Add class to HTML element
        htmlElement.classList.add(HIGH_CONTRAST_CLASS);
        
        // Update toggle button states
        allToggleButtons.forEach(button => {
            if (button) {
                button.setAttribute('aria-pressed', 'true');
                
                // Update status text if it exists
                const statusText = button.querySelector('.status-text');
                if (statusText) {
                    statusText.textContent = 'On';
                }
                
                // Update toggle indicator if exists (for menu toggle)
                if (button.id === 'high-contrast-toggle-menu') {
                    button.classList.add('bg-primary-600');
                    const indicator = button.querySelector('.high-contrast-toggle-indicator');
                    if (indicator) {
                        indicator.classList.add('translate-x-5');
                    }
                }
            }
        });
        
        // Save preference
        localStorage.setItem(HIGH_CONTRAST_STORAGE_KEY, 'true');
        
        // Announce to screen readers
        announceToScreenReader('High contrast mode enabled');
    }
    
    /**
     * Disable high contrast mode
     */
    function disableHighContrast() {
        // Remove class from HTML element
        htmlElement.classList.remove(HIGH_CONTRAST_CLASS);
        
        // Update toggle button states
        allToggleButtons.forEach(button => {
            if (button) {
                button.setAttribute('aria-pressed', 'false');
                
                // Update status text if it exists
                const statusText = button.querySelector('.status-text');
                if (statusText) {
                    statusText.textContent = 'Off';
                }
                
                // Update toggle indicator if exists (for menu toggle)
                if (button.id === 'high-contrast-toggle-menu') {
                    button.classList.remove('bg-primary-600');
                    const indicator = button.querySelector('.high-contrast-toggle-indicator');
                    if (indicator) {
                        indicator.classList.remove('translate-x-5');
                    }
                }
            }
        });
        
        // Save preference
        localStorage.setItem(HIGH_CONTRAST_STORAGE_KEY, 'false');
        
        // Announce to screen readers
        announceToScreenReader('High contrast mode disabled');
    }
    
    /**
     * Announce message to screen readers
     */
    function announceToScreenReader(message) {
        srAnnouncements.forEach(element => {
            element.textContent = message;
        });
    }
} 