/**
 * High Contrast Mode Functionality
 * 
 * This module provides accessibility features for users who need high contrast:
 * - Toggle high contrast mode on/off via button or keyboard (Alt+H)
 * - Persist user preferences with localStorage
 * - Announce changes to screen readers
 * - Support for multiple toggle buttons across the application
 */

// Constants
const HIGH_CONTRAST_CLASS = 'high-contrast-mode';
const HIGH_CONTRAST_STORAGE_KEY = 'highContrastMode';
const KEYBOARD_SHORTCUT = { key: 'h', altKey: true };

/**
 * Initialize high contrast functionality
 * @returns {Object} - Public methods for controlling high contrast
 */
export function initHighContrast() {
    // Private variables
    let _htmlElement;
    let _toggleButtons = [];
    let _srAnnouncements = [];
    
    /**
     * Initialize the module
     * @private
     */
    const _init = () => {
        try {
            // Cache DOM elements
            _htmlElement = document.documentElement;
            _toggleButtons = [
                document.getElementById('high-contrast-toggle'),
                document.getElementById('high-contrast-toggle-menu')
            ].filter(Boolean);
            _srAnnouncements = Array.from(document.querySelectorAll('.sr-announcement'));
            
            // Initialize state from localStorage
            const isEnabled = localStorage.getItem(HIGH_CONTRAST_STORAGE_KEY) === 'true';
            isEnabled ? enableHighContrast() : disableHighContrast();
            
            // Add event listeners
            _attachEventListeners();
            
            // Handle page visibility changes (for better cross-tab sync)
            document.addEventListener('visibilitychange', _handleVisibilityChange);
            
            // Log success
            console.debug('High contrast module initialized');
        } catch (error) {
            console.error('Failed to initialize high contrast mode:', error);
        }
    };
    
    /**
     * Attach event listeners
     * @private
     */
    const _attachEventListeners = () => {
        // Button click events
        _toggleButtons.forEach(button => {
            button?.addEventListener('click', toggleHighContrast);
        });
        
        // Keyboard shortcut
        document.addEventListener('keydown', _handleKeyDown);
        
        // Storage event (for cross-tab sync)
        window.addEventListener('storage', _handleStorageChange);
    };
    
    /**
     * Handle keyboard shortcuts
     * @private
     * @param {KeyboardEvent} event - The keyboard event
     */
    const _handleKeyDown = (event) => {
        if (event.altKey && event.key === KEYBOARD_SHORTCUT.key) {
            toggleHighContrast();
            event.preventDefault();
        }
    };
    
    /**
     * Handle storage changes for cross-tab sync
     * @private
     * @param {StorageEvent} event - The storage event
     */
    const _handleStorageChange = (event) => {
        if (event.key === HIGH_CONTRAST_STORAGE_KEY) {
            const isEnabled = event.newValue === 'true';
            isEnabled ? enableHighContrast(false) : disableHighContrast(false);
        }
    };
    
    /**
     * Handle visibility changes for cross-tab sync
     * @private
     */
    const _handleVisibilityChange = () => {
        if (document.visibilityState === 'visible') {
            // Sync with localStorage when tab becomes visible
            const isEnabled = localStorage.getItem(HIGH_CONTRAST_STORAGE_KEY) === 'true';
            const currentlyEnabled = _htmlElement.classList.contains(HIGH_CONTRAST_CLASS);
            
            if (isEnabled !== currentlyEnabled) {
                isEnabled ? enableHighContrast(false) : disableHighContrast(false);
            }
        }
    };
    
    /**
     * Toggle high contrast mode
     * @public
     */
    function toggleHighContrast() {
        try {
            const isEnabled = _htmlElement.classList.contains(HIGH_CONTRAST_CLASS);
            isEnabled ? disableHighContrast() : enableHighContrast();
        } catch (error) {
            console.error('Error toggling high contrast mode:', error);
        }
    }
    
    /**
     * Enable high contrast mode
     * @public
     * @param {boolean} [announce=true] - Whether to announce the change to screen readers
     */
    function enableHighContrast(announce = true) {
        try {
            // Apply class to HTML element
            _htmlElement.classList.add(HIGH_CONTRAST_CLASS);
            
            // Update toggle button states
            _updateButtonStates(true);
            
            // Save preference
            localStorage.setItem(HIGH_CONTRAST_STORAGE_KEY, 'true');
            
            // Announce to screen readers if requested
            if (announce) {
                announceToScreenReader('High contrast mode enabled');
            }
            
            // Dispatch event for other components
            window.dispatchEvent(new CustomEvent('high-contrast-change', { 
                detail: { enabled: true } 
            }));
        } catch (error) {
            console.error('Error enabling high contrast mode:', error);
        }
    }
    
    /**
     * Disable high contrast mode
     * @public
     * @param {boolean} [announce=true] - Whether to announce the change to screen readers
     */
    function disableHighContrast(announce = true) {
        try {
            // Remove class from HTML element
            _htmlElement.classList.remove(HIGH_CONTRAST_CLASS);
            
            // Update toggle button states
            _updateButtonStates(false);
            
            // Save preference
            localStorage.setItem(HIGH_CONTRAST_STORAGE_KEY, 'false');
            
            // Announce to screen readers if requested
            if (announce) {
                announceToScreenReader('High contrast mode disabled');
            }
            
            // Dispatch event for other components
            window.dispatchEvent(new CustomEvent('high-contrast-change', { 
                detail: { enabled: false } 
            }));
        } catch (error) {
            console.error('Error disabling high contrast mode:', error);
        }
    }
    
    /**
     * Update all toggle button states
     * @private
     * @param {boolean} enabled - Whether high contrast is enabled
     */
    const _updateButtonStates = (enabled) => {
        _toggleButtons.forEach(button => {
            if (!button) return;
            
            // Update ARIA state
            button.setAttribute('aria-pressed', enabled.toString());
            
            // Update status text if it exists
            const statusText = button.querySelector('.status-text');
            if (statusText) {
                statusText.textContent = enabled ? 'On' : 'Off';
            }
            
            // Update toggle indicator for menu toggle
            if (button.id === 'high-contrast-toggle-menu') {
                button.classList.toggle('bg-primary-600', enabled);
                
                const indicator = button.querySelector('.high-contrast-toggle-indicator');
                if (indicator) {
                    indicator.classList.toggle('translate-x-5', enabled);
                }
            }
        });
    };
    
    /**
     * Announce message to screen readers
     * @public
     * @param {string} message - The message to announce
     */
    function announceToScreenReader(message) {
        _srAnnouncements.forEach(element => {
            if (element) {
                element.textContent = message;
            }
        });
    }
    
    /**
     * Get current state
     * @public
     * @returns {boolean} Whether high contrast is currently enabled
     */
    function isEnabled() {
        return _htmlElement.classList.contains(HIGH_CONTRAST_CLASS);
    }
    
    // Initialize the module
    _init();
    
    // Return public API
    return {
        toggle: toggleHighContrast,
        enable: enableHighContrast,
        disable: disableHighContrast,
        announce: announceToScreenReader,
        isEnabled
    };
} 