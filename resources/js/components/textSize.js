/**
 * Text Size Component
 * 
 * Alpine.js component for managing text size preferences:
 * - Allows users to switch between small, medium, and large text
 * - Stores preference in localStorage
 * - Supports keyboard navigation
 * - Shows notifications when text size changes
 * - Synchronizes across tabs
 */

const TEXT_SIZE_STORAGE_KEY = 'textSize';
const TEXT_SIZE_OPTIONS = ['small', 'medium', 'large'];
const DEFAULT_TEXT_SIZE = 'medium';

/**
 * Text Size Alpine component
 * @returns {Object} Alpine.js component definition
 */
export default function TextSize() {
    return {
        initialLoad: true, // Flag to prevent notification on initial load
        size: DEFAULT_TEXT_SIZE,
        
        /**
         * Initialize the component
         */
        init() {
            try {
                // Set initial size from localStorage
                this.size = localStorage.getItem(TEXT_SIZE_STORAGE_KEY) || DEFAULT_TEXT_SIZE;
                
                // Apply current size
                this.applyTextSize(false);
                
                // Listen for text size changes from other tabs
                window.addEventListener('storage', this.handleStorageEvent.bind(this));
                
                // Add a custom event listener for external triggers
                window.addEventListener('text-size-change', this.handleExternalChange.bind(this));
                
                // Mark as initialized after a short delay
                setTimeout(() => {
                    this.initialLoad = false;
                }, 200);
                
            } catch (error) {
                console.error('Failed to initialize text size component:', error);
                // Fallback to default size
                this.size = DEFAULT_TEXT_SIZE;
                this.applyTextSize(false);
            }
        },
        
        /**
         * Clean up event listeners when component is destroyed
         */
        destroy() {
            window.removeEventListener('storage', this.handleStorageEvent);
            window.removeEventListener('text-size-change', this.handleExternalChange);
        },
        
        /**
         * Handle storage event for cross-tab synchronization
         * @param {StorageEvent} event - The storage event
         */
        handleStorageEvent(event) {
            if (event.key === TEXT_SIZE_STORAGE_KEY) {
                this.size = event.newValue || DEFAULT_TEXT_SIZE;
                this.applyTextSize(false); // Don't show notification for cross-tab changes
            }
        },
        
        /**
         * Handle external change event
         */
        handleExternalChange() {
            this.size = localStorage.getItem(TEXT_SIZE_STORAGE_KEY) || DEFAULT_TEXT_SIZE;
            this.applyTextSize();
        },
        
        /**
         * Handle tab key to keep focus in the dropdown (focus trap)
         * @param {KeyboardEvent} event - The keyboard event
         */
        handleTabKey(event) {
            event.preventDefault();
            this.focusNextItem();
        },
        
        /**
         * Handle shift+tab key to move focus backward
         * @param {KeyboardEvent} event - The keyboard event
         */
        handleShiftTabKey(event) {
            event.preventDefault();
            this.focusPreviousItem();
        },
        
        /**
         * Focus the next item in the dropdown
         */
        focusNextItem() {
            if (!this.$refs.menu) return;
            
            const focusableElements = this.$refs.menu.querySelectorAll('[tabindex="0"]');
            if (focusableElements.length === 0) return;
            
            const focusedElement = document.activeElement;
            const index = Array.from(focusableElements).indexOf(focusedElement);
            const nextIndex = (index + 1) % focusableElements.length;
            
            focusableElements[nextIndex].focus();
        },
        
        /**
         * Focus the previous item in the dropdown
         */
        focusPreviousItem() {
            if (!this.$refs.menu) return;
            
            const focusableElements = this.$refs.menu.querySelectorAll('[tabindex="0"]');
            if (focusableElements.length === 0) return;
            
            const focusedElement = document.activeElement;
            const index = Array.from(focusableElements).indexOf(focusedElement);
            const prevIndex = (index - 1 + focusableElements.length) % focusableElements.length;
            
            focusableElements[prevIndex].focus();
        },
        
        /**
         * Get the current size indicator for display
         * @returns {string} Single letter indicator (S/M/L)
         */
        getCurrentSizeIndicator() {
            return {
                'small': 'S',
                'medium': 'M',
                'large': 'L'
            }[this.size] || 'M';
        },
        
        /**
         * Apply the current text size to the document
         * @param {boolean} [notify=true] - Whether to show a notification
         */
        applyTextSize(notify = true) {
            try {
                // Validate size value
                if (!TEXT_SIZE_OPTIONS.includes(this.size)) {
                    this.size = DEFAULT_TEXT_SIZE;
                }
                
                // Apply to HTML element
                this._updateHtmlClasses();
                
                // Apply highlight animation if not initial load
                if (!this.initialLoad) {
                    this.applyHighlightAnimation();
                }
                
                // Dispatch event for other components
                this._dispatchEvent();
                
                // Show notification if requested and not initial load
                if (notify && !this.initialLoad) {
                    this.showNotification(this.size);
                }
            } catch (error) {
                console.error('Error applying text size:', error);
            }
        },
        
        /**
         * Update HTML classes for text size
         * @private
         */
        _updateHtmlClasses() {
            document.documentElement.classList.remove('text-size-small', 'text-size-medium', 'text-size-large');
            document.documentElement.classList.add(`text-size-${this.size}`);
        },
        
        /**
         * Dispatch a custom event for text size change
         * @private
         */
        _dispatchEvent() {
            window.dispatchEvent(new CustomEvent('text-size-updated', { 
                detail: { size: this.size } 
            }));
        },
        
        /**
         * Apply highlight animation to important text elements
         */
        applyHighlightAnimation() {
            if (this.initialLoad) return;
            
            try {
                // Select important text elements for highlighting
                const selectors = [
                    'p', 'h1', 'h2', 'h3', 'h4', 
                    '.card', '.alert', '.badge',
                    'button', 'a.nav-link', 'label'
                ].join(',');
                
                // Get visible elements in viewport
                const visibleElements = this._getVisibleElements(selectors, 20);
                
                // Apply animation to visible elements
                this._animateElements(visibleElements);
            } catch (error) {
                console.error('Error applying highlight animation:', error);
            }
        },
        
        /**
         * Get elements that are visible in the viewport
         * @private
         * @param {string} selectors - CSS selectors to match
         * @param {number} limit - Maximum number of elements to return
         * @returns {Array} Array of visible elements
         */
        _getVisibleElements(selectors, limit) {
            return Array.from(document.querySelectorAll(selectors))
                .filter(el => {
                    const rect = el.getBoundingClientRect();
                    return (
                        rect.top >= 0 &&
                        rect.left >= 0 &&
                        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                    );
                })
                .slice(0, limit);
        },
        
        /**
         * Apply animation to elements
         * @private
         * @param {Array} elements - Elements to animate
         */
        _animateElements(elements) {
            elements.forEach(element => {
                element.classList.remove('text-size-highlight');
                void element.offsetWidth; // Force reflow
                element.classList.add('text-size-highlight');
                
                // Remove class after animation completes
                setTimeout(() => {
                    element.classList.remove('text-size-highlight');
                }, 1500);
            });
        },
        
        /**
         * Set text size to a specific value
         * @param {string} size - The size to set ('small', 'medium', or 'large')
         */
        setTextSize(size) {
            if (!TEXT_SIZE_OPTIONS.includes(size)) {
                console.warn(`Invalid text size: ${size}. Using default.`);
                size = DEFAULT_TEXT_SIZE;
            }
            
            this.size = size;
            localStorage.setItem(TEXT_SIZE_STORAGE_KEY, size);
            this.applyTextSize();
        },
        
        /**
         * Reset to default text size
         */
        resetTextSize() {
            localStorage.removeItem(TEXT_SIZE_STORAGE_KEY);
            this.size = DEFAULT_TEXT_SIZE;
            this.applyTextSize();
            this.showNotification('reset');
        },
        
        /**
         * Show notification for text size change
         * @param {string} size - The text size that was set
         */
        showNotification(size) {
            if (this.initialLoad) return;
            
            try {
                // Try to use Alpine.js toast system if available
                if (this._showToastNotification(size)) return;
                
                // Fallback to custom notification
                this._showCustomNotification(size);
            } catch (error) {
                console.error('Error showing text size notification:', error);
            }
        },
        
        /**
         * Show toast notification using Alpine.js store
         * @private
         * @param {string} size - The text size
         * @returns {boolean} Whether toast was shown successfully
         */
        _showToastNotification(size) {
            if (typeof window.Alpine !== 'undefined' && typeof window.Alpine.store === 'function') {
                try {
                    const toast = window.Alpine.store('toast');
                    if (toast && typeof toast.show === 'function') {
                        const messages = {
                            'small': 'Text size set to Small',
                            'medium': 'Text size set to Medium',
                            'large': 'Text size set to Large',
                            'reset': 'Text size reset to default'
                        };
                        
                        toast.show({
                            type: 'info',
                            message: messages[size] || `Text size: ${size}`,
                            duration: 2000
                        });
                        
                        return true;
                    }
                } catch (e) {
                    console.error('Error showing toast notification:', e);
                }
            }
            return false;
        },
        
        /**
         * Show custom notification when toast is not available
         * @private
         * @param {string} size - The text size
         */
        _showCustomNotification(size) {
            // Remove any existing notifications
            const existing = document.querySelector('.text-size-notification');
            if (existing) {
                document.body.removeChild(existing);
            }
            
            // Create notification element
            const notification = document.createElement('div');
            notification.className = 'text-size-notification';
            notification.setAttribute('role', 'status');
            notification.setAttribute('aria-live', 'polite');
            
            // Style the notification
            notification.style.cssText = `
                position: fixed;
                bottom: 20px;
                right: 20px;
                background-color: #4b5563;
                color: white;
                padding: 10px 20px;
                border-radius: 6px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                z-index: 9999;
                opacity: 0;
                transition: opacity 0.3s ease;
            `;
            
            // Set notification text
            const sizeLabels = {
                'small': 'Small',
                'medium': 'Medium',
                'large': 'Large',
                'reset': 'Default'
            };
            
            notification.textContent = size === 'reset' 
                ? 'Text size reset to default' 
                : `Text size: ${sizeLabels[size] || size}`;
            
            // Add to document
            document.body.appendChild(notification);
            
            // Show and fade out with proper cleanup
            setTimeout(() => {
                notification.style.opacity = '1';
                
                setTimeout(() => {
                    notification.style.opacity = '0';
                    
                    // Remove from DOM after fade out
                    setTimeout(() => {
                        if (notification.parentNode) {
                            document.body.removeChild(notification);
                        }
                    }, 300);
                }, 2000);
            }, 10);
        }
    };
} 