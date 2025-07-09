/**
 * Animation Components
 * 
 * This file contains various animation-related Alpine.js components.
 */

export default function Animations() {
    return {
        /**
         * Animates a checkmark when a todo is completed
         * 
         * @param {string} elementId - ID of the element to animate
         * @param {boolean} completed - Whether the todo is completed
         */
        animateCheckmark(elementId, completed) {
            if (!completed) return;
            
            const element = document.getElementById(elementId);
            if (!element) return;
            
            // Add the animation class
            element.classList.add('checkmark-animation');
            
            // Add success highlight
            element.closest('tr')?.classList.add('bg-green-50', 'dark:bg-green-900/20');
            
            // Remove animation class after animation completes to allow for replay
            setTimeout(() => {
                element.classList.remove('checkmark-animation');
            }, 1000);
        },
        
        /**
         * Shake animation for errors or warnings
         * 
         * @param {string} elementId - ID of the element to animate
         */
        shakeElement(elementId) {
            const element = document.getElementById(elementId);
            if (!element) return;
            
            // Add the shake animation class
            element.classList.add('shake-animation');
            
            // Remove animation class after animation completes
            setTimeout(() => {
                element.classList.remove('shake-animation');
            }, 500);
        },
        
        /**
         * Pulse animation for highlighting elements
         * 
         * @param {string} elementId - ID of the element to animate
         */
        pulseElement(elementId) {
            const element = document.getElementById(elementId);
            if (!element) return;
            
            // Add the pulse animation class
            element.classList.add('pulse-animation');
            
            // Remove animation class after animation completes
            setTimeout(() => {
                element.classList.remove('pulse-animation');
            }, 1000);
        }
    };
} 