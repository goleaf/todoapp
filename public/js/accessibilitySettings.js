/**
 * Accessibility Settings Manager
 * 
 * Handles user accessibility preferences including:
 * - Text size adjustment
 * - High contrast mode
 * - Enhanced focus indicators
 * - Reduced motion
 */

// Initialize all accessibility features when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    initTextSize();
    initHighContrast();
    initEnhancedFocus();
    initReduceMotion();
    initResetButton();
});

// Text Size Settings
function initTextSize() {
    // Get text size buttons if they exist
    const smallButton = document.getElementById('text-size-small');
    const mediumButton = document.getElementById('text-size-medium');
    const largeButton = document.getElementById('text-size-large');
    
    // Exit if buttons don't exist (we're not on the settings page)
    if (!smallButton || !mediumButton || !largeButton) return;
    
    // Get current text size from localStorage or default to medium
    const currentSize = localStorage.getItem('textSize') || 'medium';
    
    // Apply the stored text size class to the body
    applyTextSize(currentSize);
    
    // Mark the active button
    markActiveTextSize(currentSize);
    
    // Add event listeners to buttons
    smallButton.addEventListener('click', function() {
        applyTextSize('small');
        markActiveTextSize('small');
        announceToScreenReader('Text size set to small');
    });
    
    mediumButton.addEventListener('click', function() {
        applyTextSize('medium');
        markActiveTextSize('medium');
        announceToScreenReader('Text size set to medium');
    });
    
    largeButton.addEventListener('click', function() {
        applyTextSize('large');
        markActiveTextSize('large');
        announceToScreenReader('Text size set to large');
    });
}

function applyTextSize(size) {
    // Remove any existing text-size classes
    document.body.classList.remove('text-size-small', 'text-size-medium', 'text-size-large');
    
    // Add the selected size class
    document.body.classList.add(`text-size-${size}`);
    
    // Save preference to localStorage
    localStorage.setItem('textSize', size);
}

function markActiveTextSize(size) {
    // Get all text size buttons
    const allButtons = document.querySelectorAll('.text-size-btn');
    
    // Remove active class from all buttons
    allButtons.forEach(button => {
        button.classList.remove('active');
        button.setAttribute('aria-pressed', 'false');
    });
    
    // Add active class to selected button
    const activeButton = document.getElementById(`text-size-${size}`);
    if (activeButton) {
        activeButton.classList.add('active');
        activeButton.setAttribute('aria-pressed', 'true');
    }
}

// High Contrast Mode
function initHighContrast() {
    // This function is assumed to be implemented in highContrast.js
    // It handles toggling high contrast mode and saving preferences
}

// Enhanced Focus Indicators
function initEnhancedFocus() {
    const focusToggle = document.getElementById('enhanced-focus-toggle');
    if (!focusToggle) return;
    
    // Check stored preference or default to disabled
    const enhancedFocusEnabled = localStorage.getItem('enhancedFocus') === 'true';
    
    // Initialize toggle state
    focusToggle.checked = enhancedFocusEnabled;
    
    // Apply current setting
    applyEnhancedFocus(enhancedFocusEnabled);
    
    // Update status text
    updateFocusStatus(enhancedFocusEnabled);
    
    // Add event listener
    focusToggle.addEventListener('change', function() {
        const isEnabled = this.checked;
        applyEnhancedFocus(isEnabled);
        updateFocusStatus(isEnabled);
        announceToScreenReader(`Enhanced focus indicators ${isEnabled ? 'enabled' : 'disabled'}`);
    });
}

function applyEnhancedFocus(enable) {
    if (enable) {
        document.body.classList.add('enhanced-focus');
    } else {
        document.body.classList.remove('enhanced-focus');
    }
    
    // Save preference
    localStorage.setItem('enhancedFocus', enable);
}

function updateFocusStatus(enabled) {
    const statusElement = document.getElementById('enhanced-focus-status');
    if (statusElement) {
        statusElement.textContent = enabled ? 
            statusElement.getAttribute('data-enabled-text') : 
            statusElement.getAttribute('data-disabled-text');
    }
}

// Reduce Motion
function initReduceMotion() {
    const motionToggle = document.getElementById('reduce-motion-toggle');
    if (!motionToggle) return;
    
    // Check stored preference or default to disabled
    const reduceMotionEnabled = localStorage.getItem('reduceMotion') === 'true';
    
    // Initialize toggle state
    motionToggle.checked = reduceMotionEnabled;
    
    // Apply current setting
    applyReduceMotion(reduceMotionEnabled);
    
    // Update status text
    updateMotionStatus(reduceMotionEnabled);
    
    // Add event listener
    motionToggle.addEventListener('change', function() {
        const isEnabled = this.checked;
        applyReduceMotion(isEnabled);
        updateMotionStatus(isEnabled);
        announceToScreenReader(`Reduced motion ${isEnabled ? 'enabled' : 'disabled'}`);
    });
}

function applyReduceMotion(enable) {
    if (enable) {
        document.body.classList.add('reduce-motion');
    } else {
        document.body.classList.remove('reduce-motion');
    }
    
    // Save preference
    localStorage.setItem('reduceMotion', enable);
}

function updateMotionStatus(enabled) {
    const statusElement = document.getElementById('reduce-motion-status');
    if (statusElement) {
        statusElement.textContent = enabled ? 
            statusElement.getAttribute('data-enabled-text') : 
            statusElement.getAttribute('data-disabled-text');
    }
}

// Reset All Settings
function initResetButton() {
    const resetButton = document.getElementById('reset-accessibility');
    if (!resetButton) return;
    
    resetButton.addEventListener('click', function() {
        // Reset text size
        applyTextSize('medium');
        markActiveTextSize('medium');
        
        // Reset high contrast (assuming this function exists in highContrast.js)
        if (typeof disableHighContrast === 'function') {
            disableHighContrast();
        }
        
        // Reset enhanced focus
        applyEnhancedFocus(false);
        if (document.getElementById('enhanced-focus-toggle')) {
            document.getElementById('enhanced-focus-toggle').checked = false;
        }
        updateFocusStatus(false);
        
        // Reset reduced motion
        applyReduceMotion(false);
        if (document.getElementById('reduce-motion-toggle')) {
            document.getElementById('reduce-motion-toggle').checked = false;
        }
        updateMotionStatus(false);
        
        // Show success message
        const successMsg = resetButton.getAttribute('data-success-message');
        if (successMsg) {
            const alertElement = document.createElement('div');
            alertElement.className = 'alert alert-success mt-3';
            alertElement.setAttribute('role', 'alert');
            alertElement.textContent = successMsg;
            
            resetButton.parentNode.appendChild(alertElement);
            
            // Remove message after 3 seconds
            setTimeout(() => {
                alertElement.remove();
            }, 3000);
        }
        
        // Announce to screen readers
        announceToScreenReader('All accessibility settings have been reset to defaults');
    });
}

// Utility function for screen reader announcements
function announceToScreenReader(message) {
    const announcer = document.getElementById('sr-announcer');
    
    if (!announcer) {
        // Create announcer if it doesn't exist
        const newAnnouncer = document.createElement('div');
        newAnnouncer.id = 'sr-announcer';
        newAnnouncer.setAttribute('aria-live', 'polite');
        newAnnouncer.classList.add('sr-only');
        document.body.appendChild(newAnnouncer);
        
        // Use the newly created announcer
        newAnnouncer.textContent = message;
    } else {
        // Use existing announcer
        announcer.textContent = '';
        
        // Timeout to ensure screen readers register the change
        setTimeout(() => {
            announcer.textContent = message;
        }, 50);
    }
}

// Apply settings on page load (for any page, not just settings page)
window.addEventListener('DOMContentLoaded', function() {
    // Apply text size
    const textSize = localStorage.getItem('textSize') || 'medium';
    document.body.classList.add(`text-size-${textSize}`);
    
    // Apply enhanced focus if enabled
    if (localStorage.getItem('enhancedFocus') === 'true') {
        document.body.classList.add('enhanced-focus');
    }
    
    // Apply reduced motion if enabled
    if (localStorage.getItem('reduceMotion') === 'true') {
        document.body.classList.add('reduce-motion');
    }
}); 