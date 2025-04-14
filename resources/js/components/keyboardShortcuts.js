export default function KeyboardShortcuts() {
    // Track key sequence for multi-key shortcuts
    let keySequence = [];
    let keySequenceTimeout;
    
    // Reset key sequence after a delay
    const resetKeySequence = () => {
        clearTimeout(keySequenceTimeout);
        keySequenceTimeout = setTimeout(() => {
            keySequence = [];
        }, 1000); // Reset after 1 second of inactivity
    };
    
    return {
        init() {
            document.addEventListener('keydown', (e) => {
                // Only process shortcuts when no input/textarea is focused
                if (['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName)) {
                    return;
                }
                
                // Handle key combinations
                if (e.key === 'n' && e.ctrlKey) {
                    // Ctrl+N: Create new todo
                    e.preventDefault();
                    if (window.location.pathname.includes('/todos')) {
                        window.location.href = '/todos/create';
                    }
                }
                
                // Handle single key shortcuts
                if (!e.ctrlKey && !e.altKey && !e.metaKey) {
                    // Track key sequence for multi-key shortcuts
                    keySequence.push(e.key.toLowerCase());
                    resetKeySequence();
                    
                    // Check for "ts" sequence to open text size menu
                    if (keySequence.join('').endsWith('ts')) {
                        e.preventDefault();
                        // Find the text size button and click it
                        const textSizeButton = document.querySelector('[aria-label="Text Size"]');
                        if (textSizeButton) {
                            textSizeButton.click();
                        }
                        keySequence = []; // Reset sequence after use
                    }
                    
                    switch (e.key) {
                        case '/': 
                            // Quick search focus
                            e.preventDefault();
                            const searchInput = document.getElementById('search-input');
                            if (searchInput) searchInput.focus();
                            break;
                            
                        case 'h':
                            // Back to home
                            e.preventDefault();
                            window.location.href = '/';
                            break;
                            
                        case 't':
                            // Go to todos
                            e.preventDefault();
                            window.location.href = '/todos';
                            break;
                            
                        case '?':
                            // Show keyboard shortcut help modal
                            e.preventDefault();
                            this.$dispatch('modal:open', 'keyboard-shortcuts-help');
                            break;
                            
                        // Text size shortcuts
                        case '1':
                            // Set small text size
                            e.preventDefault();
                            if (typeof this.setTextSize === 'function') {
                                this.setTextSize('small');
                            }
                            break;
                            
                        case '2':
                            // Set medium text size
                            e.preventDefault();
                            if (typeof this.setTextSize === 'function') {
                                this.setTextSize('medium');
                            }
                            break;
                            
                        case '3':
                            // Set large text size
                            e.preventDefault();
                            if (typeof this.setTextSize === 'function') {
                                this.setTextSize('large');
                            }
                            break;
                            
                        case '0':
                            // Reset text size to default
                            e.preventDefault();
                            if (typeof this.resetTextSize === 'function') {
                                this.resetTextSize();
                            }
                            break;
                    }
                }
            });
        }
    };
} 