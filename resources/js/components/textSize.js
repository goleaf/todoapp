export default function TextSize() {
    // Apply text size immediately when the script is loaded
    const savedTextSize = localStorage.getItem('textSize') || 'medium';
    document.documentElement.classList.remove('text-size-small', 'text-size-medium', 'text-size-large');
    document.documentElement.classList.add(`text-size-${savedTextSize}`);
    
    return {
        initialLoad: true, // Flag to prevent notification on initial load
        
        init() {
            // Initialize text size on component initialization
            this.applyTextSize();
            
            // Listen for text size changes from other tabs/windows
            window.addEventListener('storage', (event) => {
                if (event.key === 'textSize') {
                    this.applyTextSize();
                }
            });
            
            // Add a global event that can be triggered from anywhere
            window.addEventListener('text-size-change', () => {
                this.applyTextSize();
            });
        },
        
        // Handle tab key to keep focus in the dropdown (focus trap)
        handleTabKey(event) {
            // Prevent default tab behavior
            event.preventDefault();
            
            // Use the focusNextItem method for consistency
            this.focusNextItem();
        },
        
        // Handle shift+tab key to move focus backward
        handleShiftTabKey(event) {
            // Prevent default tab behavior
            event.preventDefault();
            
            // Use the focusPreviousItem method for consistency
            this.focusPreviousItem();
        },
        
        // Focus the next item in the dropdown
        focusNextItem() {
            // Get all focusable elements in the dropdown
            const focusableElements = this.$refs.menu.querySelectorAll('[tabindex="0"]');
            
            // Get currently focused element
            const focusedElement = document.activeElement;
            
            // Find the index of the currently focused element
            let index = Array.from(focusableElements).indexOf(focusedElement);
            
            // Move to next element, or back to first if we're at the end
            index = (index + 1) % focusableElements.length;
            
            // Focus the next element
            focusableElements[index].focus();
        },
        
        // Focus the previous item in the dropdown
        focusPreviousItem() {
            // Get all focusable elements in the dropdown
            const focusableElements = this.$refs.menu.querySelectorAll('[tabindex="0"]');
            
            // Get currently focused element
            const focusedElement = document.activeElement;
            
            // Find the index of the currently focused element
            let index = Array.from(focusableElements).indexOf(focusedElement);
            
            // Move to previous element, or to last if we're at the beginning
            index = (index - 1 + focusableElements.length) % focusableElements.length;
            
            // Focus the previous element
            focusableElements[index].focus();
        },
        
        getCurrentSizeIndicator() {
            const size = localStorage.getItem('textSize') || 'medium';
            return {
                'small': 'S',
                'medium': 'M',
                'large': 'L'
            }[size] || 'M';
        },
        
        applyTextSize() {
            // Get saved text size preference, default to medium
            const savedTextSize = localStorage.getItem('textSize') || 'medium';
            
            // Remove existing text size classes
            document.documentElement.classList.remove('text-size-small', 'text-size-medium', 'text-size-large');
            
            // Add the appropriate text size class
            document.documentElement.classList.add(`text-size-${savedTextSize}`);
            
            // Apply highlight animation to key elements
            this.applyHighlightAnimation();
            
            // Dispatch an event for other components to respond to text size changes
            window.dispatchEvent(new CustomEvent('text-size-updated', { 
                detail: { size: savedTextSize } 
            }));
            
            // Show notification toast
            this.showNotification(savedTextSize);
        },
        
        // Apply highlight animation to important text elements
        applyHighlightAnimation() {
            // Skip on initial load
            if (this.initialLoad) {
                return;
            }
            
            // Select important text elements that should be highlighted
            const elementsToHighlight = [
                'p', 'h1', 'h2', 'h3', 'h4', 
                '.card', '.alert', '.badge',
                'button', 'a', 'label',
                '.nav-link', '.btn'
            ].join(',');
            
            // Get a limited set of visible elements (to avoid performance issues)
            const visibleElements = Array.from(
                document.querySelectorAll(elementsToHighlight)
            ).filter(el => {
                // Only select elements that are visible in the viewport
                const rect = el.getBoundingClientRect();
                return (
                    rect.top >= 0 &&
                    rect.left >= 0 &&
                    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                );
            }).slice(0, 25); // Limit to 25 elements for performance
            
            // Apply highlight class to each element
            visibleElements.forEach(element => {
                // Remove any existing animation
                element.classList.remove('text-size-highlight');
                
                // Force a reflow to restart the animation
                void element.offsetWidth;
                
                // Add the highlight class to trigger the animation
                element.classList.add('text-size-highlight');
                
                // Remove the class after animation completes
                setTimeout(() => {
                    element.classList.remove('text-size-highlight');
                }, 1500);
            });
        },
        
        setTextSize(size) {
            // Save the preference
            localStorage.setItem('textSize', size);
            
            // Apply the text size to the document
            this.applyTextSize();
        },
        
        // Reset to the default text size (medium)
        resetTextSize() {
            // Remove the preference from localStorage
            localStorage.removeItem('textSize');
            
            // Apply the default text size
            this.applyTextSize();
            
            // Show a special reset notification
            this.showNotification('reset');
        },
        
        showNotification(size) {
            // Skip notification on initial load
            if (this.initialLoad) {
                this.initialLoad = false;
                return;
            }
            
            // Check if Alpine.js and Toast component is available
            if (typeof window.Alpine !== 'undefined' && typeof window.Alpine.store === 'function') {
                try {
                    // Try to use the toast system if available
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
                            duration: 2000 // 2 seconds
                        });
                        
                        return;
                    }
                } catch (e) {
                    console.error('Error showing toast notification:', e);
                }
            }
            
            // Fallback: create a simple notification if toast is not available
            const notification = document.createElement('div');
            notification.className = 'text-size-notification';
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
            
            const sizeLabels = {
                'small': 'Small',
                'medium': 'Medium',
                'large': 'Large',
                'reset': 'Default'
            };
            
            notification.textContent = size === 'reset' 
                ? `Text size reset to default` 
                : `Text size: ${sizeLabels[size] || size}`;
            
            document.body.appendChild(notification);
            
            // Show and then fade out
            setTimeout(() => {
                notification.style.opacity = '1';
                
                setTimeout(() => {
                    notification.style.opacity = '0';
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 2000);
            }, 10);
        }
    };
} 