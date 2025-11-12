/**
 * Main JavaScript - AG Servizi Via Plinio 72
 */

// Global app object
window.AGServizi = {
    config: {
        version: '1.0.0',
        debug: false
    },
    
    // Initialize all modules
    init() {
        this.setupGlobalEventListeners();
        this.setupAnimations();
        this.setupLazyLoading();
        this.setupFormEnhancements();
        this.setupAccessibility();
        console.log('🚀 AG Servizi - Sistema inizializzato');
    },
    
    setupGlobalEventListeners() {
        // Handle all external links
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a[href^="http"]:not([href*="' + location.hostname + '"])');
            if (link) {
                link.target = '_blank';
                link.rel = 'noopener noreferrer';
            }
        });
        
        // Handle phone number links
        document.addEventListener('click', (e) => {
            const phoneLink = e.target.closest('a[href^="tel:"]');
            if (phoneLink && window.gtag) {
                gtag('event', 'phone_click', {
                    event_category: 'contact',
                    event_label: phoneLink.href
                });
            }
        });
        
        // Prevent form double submission
        document.addEventListener('submit', (e) => {
            const form = e.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            
            if (submitBtn && !submitBtn.disabled) {
                submitBtn.disabled = true;
                submitBtn.classList.add('loading');
                
                // Re-enable after delay to prevent permanent disable on validation errors
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('loading');
                }, 3000);
            }
        });
    },
    
    setupAnimations() {
        // Intersection Observer for animations
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
            
            // Observe elements with animation classes
            document.querySelectorAll('[class*="fade-"], [class*="slide-"], .animate-on-scroll').forEach(el => {
                animationObserver.observe(el);
            });
        }
        
        // Counter animations
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
        });
        
        counters.forEach(counter => counterObserver.observe(counter));
    },
    
    animateCounter(element) {
        const target = parseInt(element.dataset.target || element.textContent);
        const duration = parseInt(element.dataset.duration) || 2000;
        const start = Date.now();
        
        const animate = () => {
            const elapsed = Date.now() - start;
            const progress = Math.min(elapsed / duration, 1);
            
            // Easing function
            const easeOutQuart = 1 - Math.pow(1 - progress, 4);
            const current = Math.floor(target * easeOutQuart);
            
            element.textContent = current.toLocaleString('it-IT');
            
            if (progress < 1) {
                requestAnimationFrame(animate);
            }
        };
        
        animate();
    },
    
    setupLazyLoading() {
        if ('IntersectionObserver' in window) {
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
            
            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    },
    
    setupFormEnhancements() {
        // Auto-format phone numbers
        document.querySelectorAll('input[type="tel"]').forEach(input => {
            input.addEventListener('input', (e) => {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 0) {
                    value = value.replace(/(\d{3})(\d{3})(\d{4})/, '$1 $2 $3');
                }
                e.target.value = value;
            });
        });
        
        // Real-time validation feedback
        document.querySelectorAll('input[required], textarea[required]').forEach(field => {
            field.addEventListener('blur', () => {
                this.validateField(field);
            });
        });
    },
    
    validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        
        // Required field validation
        if (field.hasAttribute('required') && !value) {
            isValid = false;
        }
        
        // Email validation
        if (field.type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            isValid = emailRegex.test(value);
        }
        
        // Update field state
        field.classList.toggle('error', !isValid);
        field.classList.toggle('valid', isValid && value);
        
        return isValid;
    },
    
    setupAccessibility() {
        // Skip links
        const skipLinks = document.querySelectorAll('.skip-link');
        skipLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector(link.getAttribute('href'));
                if (target) {
                    target.focus();
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
        
        // Escape to close dropdowns
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const openDropdowns = document.querySelectorAll('.dropdown-open');
                openDropdowns.forEach(dropdown => {
                    dropdown.classList.remove('dropdown-open');
                });
            }
        });
    }
};

// Cookie consent (GDPR compliance)
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
        
        // Show with animation
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

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.AGServizi.init();
    window.cookieConsent = new CookieConsent();
});

// Error handling
window.addEventListener('error', (e) => {
    console.error('JavaScript Error:', e.error);
});