/**
 * Enhanced Focus Indicators
 * 
 * This script manages the enhanced focus indicator feature, which provides
 * more visible focus outlines for keyboard users to improve accessibility.
 */

document.addEventListener('DOMContentLoaded', () => {
    initEnhancedFocus();
});

/**
 * Initialize the enhanced focus indicators feature
 */
function initEnhancedFocus() {
    const focusToggle = document.getElementById('focus-toggle');
    if (!focusToggle) return;

    // Check for saved preference
    const enhancedFocusEnabled = localStorage.getItem('enhancedFocus') === 'true';
    
    // Apply saved setting
    if (enhancedFocusEnabled) {
        enableEnhancedFocus();
    } else {
        disableEnhancedFocus();
    }
    
    // Set initial toggle state
    if (focusToggle.type === 'checkbox') {
        focusToggle.checked = enhancedFocusEnabled;
    }
    
    // Add event listener for toggle change
    focusToggle.addEventListener('change', toggleEnhancedFocus);
    
    // Add keyboard shortcut (Alt+F)
    document.addEventListener('keydown', (e) => {
        if (e.altKey && e.key === 'f') {
            e.preventDefault();
            toggleEnhancedFocus();
            
            // Also toggle the checkbox if it exists
            if (focusToggle.type === 'checkbox') {
                focusToggle.checked = !focusToggle.checked;
            }
        }
    });
    
    // Update status text if it exists
    updateFocusStatus(enhancedFocusEnabled);
}

/**
 * Toggle enhanced focus state
 */
function toggleEnhancedFocus() {
    const isCurrentlyEnabled = document.body.classList.contains('enhanced-focus');
    
    if (isCurrentlyEnabled) {
        disableEnhancedFocus();
    } else {
        enableEnhancedFocus();
    }
    
    updateFocusStatus(!isCurrentlyEnabled);
}

/**
 * Enable enhanced focus indicators
 */
function enableEnhancedFocus() {
    document.body.classList.add('enhanced-focus');
    localStorage.setItem('enhancedFocus', 'true');
    announceToScreenReader('Enhanced focus indicators enabled');
}

/**
 * Disable enhanced focus indicators
 */
function disableEnhancedFocus() {
    document.body.classList.remove('enhanced-focus');
    localStorage.setItem('enhancedFocus', 'false');
    announceToScreenReader('Enhanced focus indicators disabled');
}

/**
 * Update focus status text if status element exists
 */
function updateFocusStatus(isEnabled) {
    const statusElement = document.getElementById('focus-status');
    if (!statusElement) return;
    
    statusElement.textContent = isEnabled ? 'Enabled' : 'Disabled';
    statusElement.classList.toggle('text-success', isEnabled);
    statusElement.classList.toggle('text-muted', !isEnabled);
}

/**
 * Announce changes to screen readers
 */
function announceToScreenReader(message) {
    let announcer = document.getElementById('a11y-announcer');
    
    if (!announcer) {
        announcer = document.createElement('div');
        announcer.id = 'a11y-announcer';
        announcer.setAttribute('aria-live', 'polite');
        announcer.setAttribute('class', 'sr-only');
        document.body.appendChild(announcer);
    }
    
    // Clear previous announcement
    announcer.textContent = '';
    
    // Set new announcement (wrapped in setTimeout to ensure it's read)
    setTimeout(() => {
        announcer.textContent = message;
    }, 100);
} 