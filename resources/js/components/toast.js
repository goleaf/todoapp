export default function Toast() {
    return {
        toasts: [],
        add(message, options = {}) {
            const id = Date.now();
            const toast = {
                id,
                message,
                type: options.type || 'info',
                timeout: options.timeout || 5000,
                position: options.position || 'bottom-right',
                hideAfter: options.timeout || 5000
            };
            
            this.toasts.push(toast);
            
            if (toast.hideAfter) {
                setTimeout(() => {
                    this.remove(id);
                }, toast.hideAfter);
            }
            
            return id;
        },
        remove(id) {
            this.toasts = this.toasts.filter(toast => toast.id !== id);
        },
        success(message, options = {}) {
            return this.add(message, { ...options, type: 'success' });
        },
        error(message, options = {}) {
            return this.add(message, { ...options, type: 'error' });
        },
        warning(message, options = {}) {
            return this.add(message, { ...options, type: 'warning' });
        },
        info(message, options = {}) {
            return this.add(message, { ...options, type: 'info' });
        }
    };
} 