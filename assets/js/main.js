/**
 * Main JavaScript - AG Servizi Via Plinio 72
 */

(function() {
    const defaultConfig = {
        version: '1.0.0',
        debug: false
    };
    
    const existingApp = window.AgenziaPlinio || {};
    const mergedConfig = Object.assign({}, defaultConfig, existingApp.config || {});
    
    const App = {
        config: mergedConfig,
        
        init() {
            this.setupGlobalEventListeners();
            this.setupAnimations();
            this.setupLazyLoading();
            this.setupFormEnhancements();
            this.setupAccessibility();
            if (this.config.debug) {
                console.info('AG Servizi - Sistema inizializzato', this.config);
            }
        },
        
        setupGlobalEventListeners() {
            document.addEventListener('click', (e) => {
                const selector = 'a[href^="http"]:not([href*="' + location.hostname + '"])';
                const link = e.target.closest(selector);
                if (link) {
                    link.target = '_blank';
                    link.rel = 'noopener noreferrer';
                }
            });
            
            document.addEventListener('click', (e) => {
                const phoneLink = e.target.closest('a[href^="tel:"]');
                if (phoneLink && window.gtag) {
                    gtag('event', 'phone_click', {
                        event_category: 'contact',
                        event_label: phoneLink.href
                    });
                }
            });
            
            document.addEventListener('submit', (e) => {
                const form = e.target;
                const submitBtn = form.querySelector('button[type="submit"]');
                
                if (submitBtn && !submitBtn.disabled) {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('loading');
                    
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('loading');
                    }, 3000);
                }
            });
        },
        
        setupAnimations() {
            if ('IntersectionObserver' in window) {
                const animationObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animate-in');
                            animationObserver.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                });
                
                document.querySelectorAll('[class*="fade-"], [class*="slide-"], .animate-on-scroll').forEach(el => {
                    animationObserver.observe(el);
                });
            }
            
            this.setupCounterAnimations();
        },
        
        setupCounterAnimations() {
            const counters = document.querySelectorAll('.counter');
            if (counters.length === 0) return;
            
            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.animateCounter(entry.target);
                        counterObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.2
            });
            
            counters.forEach(counter => counterObserver.observe(counter));
        },
        
        animateCounter(element) {
            const targetValue = parseInt(element.dataset.target || element.dataset.count || element.textContent, 10);
            const duration = parseInt(element.dataset.duration, 10) || 2000;
            const start = Date.now();
            const startValue = parseInt(element.dataset.start || '0', 10);
            
            const animate = () => {
                const elapsed = Date.now() - start;
                const progress = Math.min(elapsed / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 4);
                const current = Math.floor(startValue + (targetValue - startValue) * eased);
                
                element.textContent = current.toLocaleString('it-IT');
                
                if (progress < 1) {
                    requestAnimationFrame(animate);
                }
            };
            
            animate();
        },
        
        setupLazyLoading() {
            if (!('IntersectionObserver' in window)) {
                return;
            }
            
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.classList.add('loaded');
                        }
                        
                        if (img.dataset.srcset) {
                            img.srcset = img.dataset.srcset;
                        }
                        
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            document.querySelectorAll('img[data-src], source[data-srcset]').forEach(img => {
                imageObserver.observe(img);
            });
        },
        
        setupFormEnhancements() {
            document.querySelectorAll('input[type="tel"]').forEach(input => {
                input.addEventListener('input', (e) => {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 0) {
                        value = value.replace(/(\d{3})(\d{3})(\d{4})/, '$1 $2 $3');
                    }
                    e.target.value = value.trim();
                });
            });
            
            document.querySelectorAll('input[required], textarea[required]').forEach(field => {
                field.addEventListener('blur', () => {
                    this.validateField(field);
                });
            });
        },
        
        validateField(field) {
            const value = field.value.trim();
            let isValid = true;
            
            if (field.hasAttribute('required') && !value) {
                isValid = false;
            }
            
            if (field.type === 'email' && value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                isValid = emailRegex.test(value);
            }
            
            field.classList.toggle('error', !isValid);
            field.classList.toggle('valid', isValid && value.length > 0);
            
            return isValid;
        },
        
        setupAccessibility() {
            const skipLinks = document.querySelectorAll('.skip-link');
            skipLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = document.querySelector(link.getAttribute('href'));
                    if (target) {
                        target.setAttribute('tabindex', '-1');
                        target.focus({ preventScroll: true });
                        target.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });
            
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.dropdown-open').forEach(dropdown => {
                        dropdown.classList.remove('dropdown-open');
                    });
                    if (document.body.classList.contains('modal-open')) {
                        this.closeModal();
                    }
                }
            });
        },
        
        showToast(message, type = 'info', options = {}) {
            if (window.toastManager) {
                return window.toastManager.show({ message, type, ...options });
            }
            if (typeof window.showToast === 'function') {
                return window.showToast(message, type, options);
            }
            if (this.config.debug) {
                console.warn('Toast manager non disponibile:', message);
            }
            return null;
        },
        
        showSuccess(message, options = {}) {
            return this.showToast(message, 'success', options);
        },
        
        showError(message, options = {}) {
            return this.showToast(message, 'error', { duration: 6000, ...options });
        },
        
        showWarning(message, options = {}) {
            return this.showToast(message, 'warning', { duration: 5000, ...options });
        },
        
        showInfo(message, options = {}) {
            return this.showToast(message, 'info', options);
        },
        
        openModal(config = {}) {
            if (window.modalManager) {
                return window.modalManager.open(config);
            }
            if (this.config.debug) {
                console.warn('Modal manager non disponibile');
            }
            return null;
        },
        
        closeModal() {
            if (window.modalManager) {
                window.modalManager.close();
            }
        },
        
        getCsrfToken() {
            if (this.csrf_token) {
                return this.csrf_token;
            }
            const meta = document.querySelector('meta[name="csrf-token"]');
            return meta ? meta.getAttribute('content') : '';
        },
        
        getUser() {
            return this.user || { isLoggedIn: false };
        },
        
        handleError(error) {
            console.error('JavaScript Error:', error);
        }
    };
    
    window.AgenziaPlinio = Object.assign({}, existingApp, App);
    window.AGServizi = window.AgenziaPlinio;
    
    if (!window.AgenziaPlinio.utils) {
        window.AgenziaPlinio.utils = typeof sanitize === 'function' ? {
            sanitize,
            formatCurrency,
            formatDate,
            debounce,
            throttle,
            validateEmail,
            validatePhone,
            slugify,
            storage,
            cookies,
            ajax,
            setLoading,
            fadeIn,
            fadeOut
        } : {};
    }

    class CookieConsent {
        constructor() {
            this.consentKey = 'cookie-consent';
            this.init();
        }
        
        init() {
            if (!this.hasConsent()) {
                this.showBanner();
            }
        }
        
        hasConsent() {
            return localStorage.getItem(this.consentKey) === 'true';
        }
        
        showBanner() {
            const banner = document.createElement('div');
            banner.className = 'cookie-banner';
            banner.innerHTML = `
                <div class="cookie-banner-content">
                    <div class="cookie-message">
                        🍪 Utilizziamo cookie per migliorare la tua esperienza sul sito. 
                        <a href="/privacy-policy.php" target="_blank">Privacy Policy</a>
                    </div>
                    <div class="cookie-actions">
                        <button class="btn btn-outline" onclick="window.cookieConsent.acceptNecessary()">Solo Necessari</button>
                        <button class="btn btn-primary" onclick="window.cookieConsent.acceptAll()">Accetta Tutto</button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(banner);
            requestAnimationFrame(() => {
                banner.classList.add('show');
            });
        }
        
        acceptAll() {
            this.setConsent(true);
            this.hideBanner();
        }
        
        acceptNecessary() {
            this.setConsent(true);
            this.hideBanner();
        }
        
        setConsent(value) {
            localStorage.setItem(this.consentKey, value.toString());
        }
        
        hideBanner() {
            const banner = document.querySelector('.cookie-banner');
            if (banner) {
                banner.classList.add('hide');
                setTimeout(() => {
                    if (banner.parentNode) {
                        banner.parentNode.removeChild(banner);
                    }
                }, 300);
            }
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        try {
            window.AgenziaPlinio.init();
        } catch (error) {
            console.error('Errore durante l\'inizializzazione dell\'app:', error);
        }
        window.cookieConsent = new CookieConsent();
        window.CookieConsent = CookieConsent;
    });

    window.addEventListener('error', (e) => {
        const detail = e.error || e.message || e;
        window.AgenziaPlinio.handleError(detail);
    });
})();