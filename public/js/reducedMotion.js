/**
 * Reduced Motion Accessibility Feature
 * 
 * Handles toggling reduced motion mode and persists user preferences.
 * Responds to both toggle button clicks and Alt+M keyboard shortcut.
 */

document.addEventListener('DOMContentLoaded', function() {
    initReducedMotion();
});

function initReducedMotion() {
    // Constants and elements
    const STORAGE_KEY = 'reducedMotionEnabled';
    const REDUCED_MOTION_CLASS = 'reduced-motion';
    const KEY_COMBO = {alt: true, key: 'm'};
    
    const toggle = document.getElementById('reduced-motion-toggle');
    const statusBadge = document.getElementById('reduced-motion-status');
    
    if (!toggle) return; // Exit if toggle element doesn't exist
    
    // Initialize based on saved preference or prefers-reduced-motion media query
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const savedPreference = localStorage.getItem(STORAGE_KEY);
    
    // If user has saved preference, use that; otherwise use system preference
    const shouldEnableReducedMotion = 
        savedPreference !== null ? savedPreference === 'true' : prefersReducedMotion;
    
    // Set initial state
    if (shouldEnableReducedMotion) {
        enableReducedMotion();
    } else {
        disableReducedMotion();
    }
    
    // Set up event listeners
    toggle.addEventListener('change', toggleReducedMotion);
    
    // Add keyboard shortcut (Alt+M)
    document.addEventListener('keydown', function(e) {
        if (e.altKey && e.key.toLowerCase() === KEY_COMBO.key) {
            e.preventDefault();
            toggleReducedMotion();
        }
    });
    
    // Functions to manage reduced motion state
    function toggleReducedMotion() {
        if (document.body.classList.contains(REDUCED_MOTION_CLASS)) {
            disableReducedMotion();
        } else {
            enableReducedMotion();
        }
    }
    
    function enableReducedMotion() {
        document.body.classList.add(REDUCED_MOTION_CLASS);
        toggle.checked = true;
        updateStatusBadge(true);
        localStorage.setItem(STORAGE_KEY, 'true');
        announceToScreenReader('Reduced motion mode enabled');
    }
    
    function disableReducedMotion() {
        document.body.classList.remove(REDUCED_MOTION_CLASS);
        toggle.checked = false;
        updateStatusBadge(false);
        localStorage.setItem(STORAGE_KEY, 'false');
        announceToScreenReader('Reduced motion mode disabled');
    }
    
    function updateStatusBadge(enabled) {
        if (!statusBadge) return;
        
        if (enabled) {
            statusBadge.textContent = 'On';
            statusBadge.className = 'ms-2 badge bg-success';
        } else {
            statusBadge.textContent = 'Off';
            statusBadge.className = 'ms-2 badge bg-secondary';
        }
    }
    
    function announceToScreenReader(message) {
        let announcement = document.createElement('div');
        announcement.setAttribute('aria-live', 'assertive');
        announcement.setAttribute('role', 'status');
        announcement.className = 'sr-only';
        announcement.textContent = message;
        
        document.body.appendChild(announcement);
        
        // Remove after screen reader has had time to announce
        setTimeout(() => {
            document.body.removeChild(announcement);
        }, 3000);
    }
} 