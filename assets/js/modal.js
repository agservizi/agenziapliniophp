/**
 * Modal Management - AG Servizi Via Plinio 72
 */

class ModalManager {
    constructor() {
        this.currentModal = null;
        this.init();
    }
    
    init() {
        this.setupEventListeners();
        this.createModalContainer();
    }
    
    createModalContainer() {
        if (document.querySelector('.modal-overlay')) return;
        
        const overlay = document.createElement('div');
        overlay.className = 'modal-overlay';
        overlay.id = 'modal-overlay';
        overlay.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modal-title"></h3>
                    <button class="modal-close" aria-label="Chiudi modal">
                        <svg class="icon" viewBox="0 0 24 24">
                            <path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"/>
                        </svg>
                    </button>
                </div>
                <div class="modal-body" id="modal-body"></div>
                <div class="modal-footer" id="modal-footer"></div>
            </div>
        `;
        
        document.body.appendChild(overlay);
    }
    
    setupEventListeners() {
        // Close modal when clicking overlay
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal-overlay')) {
                this.close();
            }
        });
        
        // Close modal with escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.currentModal) {
                this.close();
            }
        });
        
        // Close button event delegation
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal-close') || 
                e.target.closest('.modal-close')) {
                this.close();
            }
        });
        
        // Modal trigger buttons
        document.addEventListener('click', (e) => {
            const trigger = e.target.closest('[data-modal]');
            if (trigger) {
                e.preventDefault();
                const modalConfig = JSON.parse(trigger.dataset.modal);
                this.open(modalConfig);
            }
        });
    }
    
    open(config = {}) {
        const overlay = document.getElementById('modal-overlay');
        const title = document.getElementById('modal-title');
        const body = document.getElementById('modal-body');
        const footer = document.getElementById('modal-footer');
        
        if (!overlay) return;
        
        // Set content
        title.textContent = config.title || '';
        body.innerHTML = config.body || '';
        footer.innerHTML = config.footer || '';
        
        // Show/hide sections based on content
        title.parentElement.style.display = config.title ? 'block' : 'none';
        footer.style.display = config.footer ? 'block' : 'none';
        
        // Add size class
        const modalContent = overlay.querySelector('.modal-content');
        modalContent.className = `modal-content ${config.size ? 'modal-' + config.size : ''}`;
        
        // Show modal
        overlay.classList.add('active');
        document.body.classList.add('modal-open');
        
        // Focus management
        this.trapFocus(overlay);
        
        this.currentModal = config;
        
        // Trigger event
        window.dispatchEvent(new CustomEvent('modalOpened', { detail: config }));
        
        return overlay;
    }
    
    close() {
        const overlay = document.getElementById('modal-overlay');
        if (!overlay) return;
        
        overlay.classList.remove('active');
        document.body.classList.remove('modal-open');
        
        // Clear content after animation
        setTimeout(() => {
            document.getElementById('modal-title').textContent = '';
            document.getElementById('modal-body').innerHTML = '';
            document.getElementById('modal-footer').innerHTML = '';
        }, 300);
        
        this.currentModal = null;
        
        // Trigger event
        window.dispatchEvent(new CustomEvent('modalClosed'));
    }
    
    trapFocus(element) {
        const focusableElements = element.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
        
        if (focusableElements.length === 0) return;
        
        const firstFocusable = focusableElements[0];
        const lastFocusable = focusableElements[focusableElements.length - 1];
        
        // Focus first element
        firstFocusable.focus();
        
        element.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === firstFocusable) {
                        e.preventDefault();
                        lastFocusable.focus();
                    }
                } else {
                    if (document.activeElement === lastFocusable) {
                        e.preventDefault();
                        firstFocusable.focus();
                    }
                }
            }
        });
    }
    
    // Convenience methods
    alert(message, title = 'Avviso') {
        return this.open({
            title: title,
            body: `<p>${message}</p>`,
            footer: '<button class="btn btn-primary modal-close">OK</button>'
        });
    }
    
    confirm(message, title = 'Conferma') {
        return new Promise((resolve) => {
            const modal = this.open({
                title: title,
                body: `<p>${message}</p>`,
                footer: `
                    <button class="btn btn-outline" onclick="window.modalManager.close(); window.modalConfirmResolve(false);">Annulla</button>
                    <button class="btn btn-primary" onclick="window.modalManager.close(); window.modalConfirmResolve(true);">Conferma</button>
                `
            });
            
            window.modalConfirmResolve = resolve;
        });
    }
    
    prompt(message, defaultValue = '', title = 'Inserisci') {
        return new Promise((resolve) => {
            const inputId = 'modal-prompt-input';
            const modal = this.open({
                title: title,
                body: `
                    <p>${message}</p>
                    <input type="text" id="${inputId}" class="form-control" value="${defaultValue}" placeholder="Inserisci valore...">
                `,
                footer: `
                    <button class="btn btn-outline" onclick="window.modalManager.close(); window.modalPromptResolve(null);">Annulla</button>
                    <button class="btn btn-primary" onclick="window.modalManager.handlePromptSubmit();">OK</button>
                `
            });
            
            window.modalPromptResolve = resolve;
            
            // Focus input and handle enter key
            setTimeout(() => {
                const input = document.getElementById(inputId);
                if (input) {
                    input.focus();
                    input.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter') {
                            this.handlePromptSubmit();
                        }
                    });
                }
            }, 100);
        });
    }
    
    handlePromptSubmit() {
        const input = document.getElementById('modal-prompt-input');
        const value = input ? input.value : null;
        this.close();
        if (window.modalPromptResolve) {
            window.modalPromptResolve(value);
        }
    }
    
    loading(message = 'Caricamento...') {
        return this.open({
            body: `
                <div class="text-center">
                    <div class="spinner-large"></div>
                    <p class="mt-3">${message}</p>
                </div>
            `,
            size: 'small'
        });
    }
}

// Image modal for galleries
class ImageModal {
    constructor() {
        this.init();
    }
    
    init() {
        document.addEventListener('click', (e) => {
            const trigger = e.target.closest('[data-image-modal]');
            if (trigger) {
                e.preventDefault();
                this.open(trigger);
            }
        });
    }
    
    open(element) {
        const src = element.dataset.imageModal || element.src || element.href;
        const alt = element.alt || element.dataset.alt || 'Immagine';
        const caption = element.dataset.caption || '';
        
        const body = `
            <div class="image-modal-content">
                <img src="${src}" alt="${alt}" class="modal-image">
                ${caption ? `<p class="image-caption">${caption}</p>` : ''}
            </div>
        `;
        
        window.modalManager.open({
            body: body,
            size: 'large'
        });
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.modalManager = new ModalManager();
    window.imageModal = new ImageModal();
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { ModalManager, ImageModal };
}