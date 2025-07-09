/**
 * Accessibility Toggle Handler
 * 
 * This script handles the events dispatched by the accessibility toggle component.
 * It connects the UI interactions to the actual accessibility feature implementations.
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize accessibility toggle listeners
    initAccessibilityToggleListeners();
});

/**
 * Initialize event listeners for accessibility toggle events
 */
function initAccessibilityToggleListeners() {
    // Listen for text size change events
    document.addEventListener('text-size-change', function(event) {
        const size = event.detail || 'medium';
        applyTextSize(size);
        announceToScreenReader(`Text size set to ${size}`);
    });
    
    // Listen for high contrast toggle events
    document.addEventListener('toggle-high-contrast', function() {
        const isHighContrastEnabled = document.documentElement.classList.contains('high-contrast-mode');
        if (isHighContrastEnabled) {
            disableHighContrast();
        } else {
            enableHighContrast();
        }
    });
    
    // Listen for reduced motion toggle events
    document.addEventListener('toggle-reduced-motion', function() {
        const isReducedMotionEnabled = document.documentElement.classList.contains('reduce-motion');
        if (isReducedMotionEnabled) {
            disableReducedMotion();
        } else {
            enableReducedMotion();
        }
    });
    
    // Listen for enhanced focus toggle events
    document.addEventListener('toggle-enhanced-focus', function() {
        const isEnhancedFocusEnabled = document.documentElement.classList.contains('enhanced-focus');
        if (isEnhancedFocusEnabled) {
            disableEnhancedFocus();
        } else {
            enableEnhancedFocus();
        }
    });
}

/**
 * Apply text size to the document
 * @param {string} size - The text size to apply (small, medium, large)
 */
function applyTextSize(size) {
    // Remove any existing text size classes
    document.documentElement.classList.remove('text-size-small', 'text-size-medium', 'text-size-large');
    
    // Add the new text size class
    document.documentElement.classList.add(`text-size-${size}`);
    
    // Save preference to localStorage
    localStorage.setItem('textSize', size);
}

/**
 * Enable high contrast mode
 */
function enableHighContrast() {
    document.documentElement.classList.add('high-contrast-mode');
    localStorage.setItem('highContrastMode', 'true');
    announceToScreenReader('High contrast mode enabled');
}

/**
 * Disable high contrast mode
 */
function disableHighContrast() {
    document.documentElement.classList.remove('high-contrast-mode');
    localStorage.setItem('highContrastMode', 'false');
    announceToScreenReader('High contrast mode disabled');
}

/**
 * Enable reduced motion mode
 */
function enableReducedMotion() {
    document.documentElement.classList.add('reduce-motion');
    localStorage.setItem('reduceMotion', 'true');
    announceToScreenReader('Reduced motion enabled');
}

/**
 * Disable reduced motion mode
 */
function disableReducedMotion() {
    document.documentElement.classList.remove('reduce-motion');
    localStorage.setItem('reduceMotion', 'false');
    announceToScreenReader('Reduced motion disabled');
}

/**
 * Enable enhanced focus indicators
 */
function enableEnhancedFocus() {
    document.documentElement.classList.add('enhanced-focus');
    localStorage.setItem('enhancedFocus', 'true');
    announceToScreenReader('Enhanced focus indicators enabled');
}

/**
 * Disable enhanced focus indicators
 */
function disableEnhancedFocus() {
    document.documentElement.classList.remove('enhanced-focus');
    localStorage.setItem('enhancedFocus', 'false');
    announceToScreenReader('Enhanced focus indicators disabled');
}

/**
 * Announce a message to screen readers
 * @param {string} message - The message to announce
 */
function announceToScreenReader(message) {
    const announcer = document.querySelector('[aria-live="polite"]');
    
    if (!announcer) {
        // If no announcer found, create one
        const newAnnouncer = document.createElement('div');
        newAnnouncer.setAttribute('aria-live', 'polite');
        newAnnouncer.classList.add('sr-only');
        document.body.appendChild(newAnnouncer);
        
        // Use the newly created announcer
        newAnnouncer.textContent = message;
    } else {
        // Clear existing content (needed for some screen readers to announce again)
        announcer.textContent = '';
        
        // Set the message after a small delay
        setTimeout(() => {
            announcer.textContent = message;
        }, 50);
    }
} 