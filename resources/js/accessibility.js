/**
 * Accessibility Features
 * 
 * This file imports all accessibility-related JavaScript functionality
 */

// Import high contrast functionality
import { initHighContrast } from './accessibility/highContrast.js';

// Initialize the high contrast feature when the DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initHighContrast();
});

// Export any functions that might be needed outside this module
export { initHighContrast }; 