/**
 * Toast Notifications - AG Servizi Via Plinio 72
 */

class ToastManager {
    constructor() {
        this.toasts = [];
        this.container = null;
        this.init();
    }
    
    init() {
        this.createContainer();
        this.setupEventListeners();
    }
    
    createContainer() {
        if (document.getElementById('toast-container')) return;
        
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container';
        document.body.appendChild(container);
        this.container = container;
    }
    
    setupEventListeners() {
        // Listen for toast events
        window.addEventListener('showToast', (e) => {
            this.show(e.detail);
        });
        
        // Auto-dismiss on page navigation
        window.addEventListener('beforeunload', () => {
            this.clearAll();
        });
    }
    
    show(options = {}) {
        const config = {
            message: options.message || 'Notifica',
            type: options.type || 'info', // success, error, warning, info
            duration: options.duration || 4000,
            persistent: options.persistent || false,
            action: options.action || null,
            id: options.id || this.generateId()
        };
        
        // Remove existing toast with same ID
        if (config.id) {
            this.remove(config.id);
        }
        
        const toast = this.createToast(config);
        this.container.appendChild(toast);
        this.toasts.push({ element: toast, config: config });
        
        // Trigger show animation
        requestAnimationFrame(() => {
            toast.classList.add('show');
        });
        
        // Auto-dismiss unless persistent
        if (!config.persistent && config.duration > 0) {
            setTimeout(() => {
                this.remove(config.id);
            }, config.duration);
        }
        
        // Trigger event
        window.dispatchEvent(new CustomEvent('toastShown', { detail: config }));
        
        return config.id;
    }
    
    createToast(config) {
        const toast = document.createElement('div');
        toast.className = `toast toast-${config.type}`;
        toast.dataset.id = config.id;
        
        const iconMap = {
            success: '<path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            error: '<path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            warning: '<path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>',
            info: '<path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
        };
        
        const actionHtml = config.action ? 
            `<button class="toast-action" onclick="(${config.action.handler.toString()})()">${config.action.text}</button>` : '';
        
        toast.innerHTML = `
            <div class="toast-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    ${iconMap[config.type]}
                </svg>
            </div>
            <div class="toast-content">
                <div class="toast-message">${config.message}</div>
                ${actionHtml}
            </div>
            <button class="toast-close" onclick="window.toastManager.remove('${config.id}')" aria-label="Chiudi notifica">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </button>
        `;
        
        return toast;
    }
    
    remove(id) {
        const toast = this.container.querySelector(`[data-id="${id}"]`);
        if (!toast) return;
        
        toast.classList.add('hide');
        
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
            this.toasts = this.toasts.filter(t => t.config.id !== id);
        }, 300);
        
        // Trigger event
        window.dispatchEvent(new CustomEvent('toastRemoved', { detail: { id } }));
    }
    
    clearAll() {
        this.toasts.forEach(toast => {
            this.remove(toast.config.id);
        });
    }
    
    generateId() {
        return 'toast_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    }
    
    // Convenience methods
    success(message, options = {}) {
        return this.show({ ...options, message, type: 'success' });
    }
    
    error(message, options = {}) {
        return this.show({ ...options, message, type: 'error', duration: 6000 });
    }
    
    warning(message, options = {}) {
        return this.show({ ...options, message, type: 'warning', duration: 5000 });
    }
    
    info(message, options = {}) {
        return this.show({ ...options, message, type: 'info' });
    }
    
    // Show loading toast
    loading(message = 'Caricamento...') {
        return this.show({
            message: `<div class="toast-loading"><div class="spinner-small"></div>${message}</div>`,
            type: 'info',
            persistent: true,
            id: 'loading_toast'
        });
    }
    
    // Hide loading toast
    hideLoading() {
        this.remove('loading_toast');
    }
}

// Form validation toast helper
class FormToast {
    static showFieldError(field, message) {
        const rect = field.getBoundingClientRect();
        const fieldToast = document.createElement('div');
        fieldToast.className = 'field-toast toast-error';
        fieldToast.textContent = message;
        
        // Position near field
        fieldToast.style.position = 'fixed';
        fieldToast.style.top = (rect.bottom + 5) + 'px';
        fieldToast.style.left = rect.left + 'px';
        fieldToast.style.zIndex = '10000';
        
        document.body.appendChild(fieldToast);
        
        // Auto-remove
        setTimeout(() => {
            if (fieldToast.parentNode) {
                fieldToast.parentNode.removeChild(fieldToast);
            }
        }, 3000);
        
        // Remove on field focus
        field.addEventListener('focus', () => {
            if (fieldToast.parentNode) {
                fieldToast.parentNode.removeChild(fieldToast);
            }
        }, { once: true });
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.toastManager = new ToastManager();
    window.FormToast = FormToast;
});

// Global toast functions for easy use
window.showToast = (message, type = 'info', options = {}) => {
    return window.toastManager?.show({ message, type, ...options });
};

window.showSuccess = (message, options = {}) => {
    return window.toastManager?.success(message, options);
};

window.showError = (message, options = {}) => {
    return window.toastManager?.error(message, options);
};

window.showWarning = (message, options = {}) => {
    return window.toastManager?.warning(message, options);
};

window.showInfo = (message, options = {}) => {
    return window.toastManager?.info(message, options);
};

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { ToastManager, FormToast };
}