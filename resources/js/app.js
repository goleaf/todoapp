/**
 * First we will load all of this project's JavaScript dependencies
 */

import './bootstrap';
import '../css/app.css';

/**
 * Custom Tailwind-based application JS
 * 
 * This application uses Tailwind CSS for styling the UI.
 */

// Add event listeners for dropdowns
document.addEventListener('DOMContentLoaded', function() {
    // Handle dropdowns
    const dropdownButtons = document.querySelectorAll('[data-dropdown-toggle]');
    
    dropdownButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-dropdown-toggle');
            const dropdown = document.getElementById(targetId);
            
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', (event) => {
        dropdownButtons.forEach(button => {
            const targetId = button.getAttribute('data-dropdown-toggle');
            const dropdown = document.getElementById(targetId);
            
            if (dropdown && !dropdown.contains(event.target) && !button.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });
    
    // Handle mobile menu toggle
    const mobileMenuButton = document.querySelector('[data-collapse-toggle="navbar-menu"]');
    const mobileMenu = document.getElementById('navbar-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }
});
