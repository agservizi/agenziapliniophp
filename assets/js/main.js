/**
 * JavaScript Principale - Agenzia Plinio
 * Gestione delle interazioni, animazioni e funzionalità base
 */

// Gestione globale dello stato dell'applicazione
window.AgenziaPlinio = {
  theme: 'auto',
  cart: [],
  user: null,
  csrfToken: '',
  
  // Inizializzazione
  init: function() {
    this.initCSRFToken();
    this.initTheme();
    this.initNavigation();
    this.initScrollToTop();
    this.initAnimations();
    this.initForms();
    this.bindEvents();
    
    console.log('🚀 Agenzia Plinio - Sistema inizializzato');
  },
  
  // Token CSRF per sicurezza
  initCSRFToken: function() {
    const token = document.querySelector('meta[name="csrf-token"]');
    if (token) {
      this.csrfToken = token.getAttribute('content');
    }
  },
  
  // Sistema tema dark/light
  initTheme: function() {
    const savedTheme = localStorage.getItem('theme');
    const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    
    this.theme = savedTheme || 'auto';
    this.applyTheme();
    
    // Listener per cambio tema di sistema
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
      if (this.theme === 'auto') {
        this.applyTheme();
      }
    });
  },
  
  applyTheme: function() {
    const body = document.body;
    
    if (this.theme === 'auto') {
      const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
      body.setAttribute('data-theme', systemTheme);
    } else {
      body.setAttribute('data-theme', this.theme);
    }
  },
  
  toggleTheme: function() {
    const currentTheme = this.theme;
    
    if (currentTheme === 'auto' || currentTheme === 'dark') {
      this.theme = 'light';
    } else {
      this.theme = 'dark';
    }
    
    localStorage.setItem('theme', this.theme);
    this.applyTheme();
  },
  
  // Navigazione mobile e desktop
  initNavigation: function() {
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    const navLinks = document.querySelectorAll('.nav-link');
    
    if (mobileToggle && navMenu) {
      mobileToggle.addEventListener('click', () => {
        const isOpen = navMenu.classList.contains('active');
        
        if (isOpen) {
          this.closeMobileMenu();
        } else {
          this.openMobileMenu();
        }
      });
      
      // Chiudi menu quando si clicca su un link
      navLinks.forEach(link => {
        link.addEventListener('click', () => {
          this.closeMobileMenu();
        });
      });
      
      // Chiudi menu quando si clicca fuori
      document.addEventListener('click', (e) => {
        if (!e.target.closest('.main-nav') && navMenu.classList.contains('active')) {
          this.closeMobileMenu();
        }
      });
    }
    
    // Effetto scroll su header
    this.initHeaderScroll();
  },
  
  openMobileMenu: function() {
    const toggle = document.querySelector('.mobile-menu-toggle');
    const menu = document.querySelector('.nav-menu');
    
    toggle.setAttribute('aria-expanded', 'true');
    menu.classList.add('active');
    toggle.classList.add('active');
    
    // Animazione hamburger
    const lines = toggle.querySelectorAll('.hamburger-line');
    lines[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
    lines[1].style.opacity = '0';
    lines[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';
    
    document.body.style.overflow = 'hidden';
  },
  
  closeMobileMenu: function() {
    const toggle = document.querySelector('.mobile-menu-toggle');
    const menu = document.querySelector('.nav-menu');
    
    if (toggle && menu) {
      toggle.setAttribute('aria-expanded', 'false');
      menu.classList.remove('active');
      toggle.classList.remove('active');
      
      // Reset hamburger
      const lines = toggle.querySelectorAll('.hamburger-line');
      lines.forEach(line => {
        line.style.transform = '';
        line.style.opacity = '';
      });
      
      document.body.style.overflow = '';
    }
  },
  
  initHeaderScroll: function() {
    const header = document.getElementById('site-header');
    let lastScrollY = window.scrollY;
    let isScrolling = false;
    
    const handleScroll = () => {
      const currentScrollY = window.scrollY;
      
      if (currentScrollY > 100) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
      
      // Auto-hide header su scroll down (mobile)
      if (window.innerWidth <= 768) {
        if (currentScrollY > lastScrollY && currentScrollY > 200) {
          header.style.transform = 'translateY(-100%)';
        } else {
          header.style.transform = 'translateY(0)';
        }
      }
      
      lastScrollY = currentScrollY;
      isScrolling = false;
    };
    
    window.addEventListener('scroll', () => {
      if (!isScrolling) {
        requestAnimationFrame(handleScroll);
        isScrolling = true;
      }
    });
  },
  
  // Scroll to top
  initScrollToTop: function() {
    const scrollBtn = document.getElementById('scroll-to-top');
    
    if (scrollBtn) {
      window.addEventListener('scroll', () => {
        if (window.scrollY > 500) {
          scrollBtn.classList.add('visible');
        } else {
          scrollBtn.classList.remove('visible');
        }
      });
      
      scrollBtn.addEventListener('click', () => {
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
      });
    }
  },
  
  // Sistema animazioni
  initAnimations: function() {
    // Intersection Observer per animazioni on scroll
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0)';
        }
      });
    }, observerOptions);
    
    // Elementi con attributo data-aos
    const animatedElements = document.querySelectorAll('[data-aos]');
    animatedElements.forEach(el => {
      el.style.opacity = '0';
      el.style.transform = 'translateY(30px)';
      el.style.transition = 'all 0.6s ease-out';
      observer.observe(el);
    });
  },
  
  // Gestione form
  initForms: function() {
    const forms = document.querySelectorAll('form[data-ajax]');
    
    forms.forEach(form => {
      form.addEventListener('submit', (e) => {
        e.preventDefault();
        this.handleAjaxForm(form);
      });
    });
    
    // Validazione real-time
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
      input.addEventListener('blur', () => {
        this.validateField(input);
      });
      
      input.addEventListener('input', () => {
        this.clearFieldError(input);
      });
    });
  },
  
  handleAjaxForm: function(form) {
    const formData = new FormData(form);
    formData.append('csrf_token', this.csrfToken);
    
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    // Loading state
    submitBtn.disabled = true;
    submitBtn.textContent = 'Invio in corso...';
    
    fetch(form.action, {
      method: form.method,
      body: formData,
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        this.showToast('Operazione completata con successo!', 'success');
        form.reset();
        
        if (data.redirect) {
          setTimeout(() => {
            window.location.href = data.redirect;
          }, 1000);
        }
      } else {
        this.showToast(data.message || 'Errore durante l\'operazione', 'error');
        
        if (data.errors) {
          this.showFormErrors(form, data.errors);
        }
      }
    })
    .catch(error => {
      console.error('Errore:', error);
      this.showToast('Errore di connessione. Riprova.', 'error');
    })
    .finally(() => {
      submitBtn.disabled = false;
      submitBtn.textContent = originalText;
    });
  },
  
  validateField: function(input) {
    const value = input.value.trim();
    const type = input.type;
    let isValid = true;
    let message = '';
    
    if (input.hasAttribute('required') && !value) {
      isValid = false;
      message = 'Campo obbligatorio';
    } else if (type === 'email' && value && !this.isValidEmail(value)) {
      isValid = false;
      message = 'Email non valida';
    } else if (input.hasAttribute('minlength')) {
      const minLength = parseInt(input.getAttribute('minlength'));
      if (value.length < minLength) {
        isValid = false;
        message = `Minimo ${minLength} caratteri`;
      }
    }
    
    if (!isValid) {
      this.showFieldError(input, message);
    } else {
      this.clearFieldError(input);
    }
    
    return isValid;
  },
  
  showFieldError: function(input, message) {
    input.classList.add('error');
    
    let errorEl = input.parentNode.querySelector('.form-error');
    if (!errorEl) {
      errorEl = document.createElement('div');
      errorEl.className = 'form-error';
      input.parentNode.appendChild(errorEl);
    }
    
    errorEl.textContent = message;
  },
  
  clearFieldError: function(input) {
    input.classList.remove('error');
    
    const errorEl = input.parentNode.querySelector('.form-error');
    if (errorEl) {
      errorEl.remove();
    }
  },
  
  showFormErrors: function(form, errors) {
    Object.keys(errors).forEach(fieldName => {
      const input = form.querySelector(`[name="${fieldName}"]`);
      if (input) {
        this.showFieldError(input, errors[fieldName]);
      }
    });
  },
  
  // Utility functions
  isValidEmail: function(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
  },
  
  formatCurrency: function(amount) {
    return new Intl.NumberFormat('it-IT', {
      style: 'currency',
      currency: 'EUR'
    }).format(amount);
  },
  
  formatDate: function(date) {
    return new Intl.DateTimeFormat('it-IT').format(new Date(date));
  },
  
  // Event listeners globali
  bindEvents: function() {
    // Theme toggle
    const themeToggle = document.querySelector('.theme-toggle');
    if (themeToggle) {
      themeToggle.addEventListener('click', () => {
        this.toggleTheme();
      });
    }
    
    // Gestione escape key per modal e menu
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        this.closeMobileMenu();
        const activeModal = document.querySelector('.modal-overlay.active');
        if (activeModal) {
          this.closeModal();
        }
      }
    });
    
    // Prevent FOUC (Flash of Unstyled Content)
    document.documentElement.style.visibility = 'visible';
  },
  
  // Toast notifications
  showToast: function(message, type = 'info', duration = 5000) {
    const container = document.getElementById('toast-container') || this.createToastContainer();
    
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    
    toast.innerHTML = `
      <div class="toast-header">
        <span class="toast-title">${this.getToastTitle(type)}</span>
        <button class="toast-close" onclick="this.parentElement.parentElement.remove()">
          <svg viewBox="0 0 24 24"><path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"/></svg>
        </button>
      </div>
      <div class="toast-body">${message}</div>
    `;
    
    container.appendChild(toast);
    
    // Animazione entrata
    setTimeout(() => toast.classList.add('show'), 100);
    
    // Auto rimozione
    setTimeout(() => {
      toast.classList.remove('show');
      setTimeout(() => toast.remove(), 300);
    }, duration);
  },
  
  createToastContainer: function() {
    const container = document.createElement('div');
    container.id = 'toast-container';
    container.className = 'toast-container';
    document.body.appendChild(container);
    return container;
  },
  
  getToastTitle: function(type) {
    const titles = {
      success: 'Successo',
      error: 'Errore',
      warning: 'Attenzione',
      info: 'Informazione'
    };
    return titles[type] || 'Notifica';
  },
  
  // Modal system
  openModal: function(title, content, footer = '') {
    const overlay = document.getElementById('modal-overlay');
    const titleEl = document.getElementById('modal-title');
    const bodyEl = document.getElementById('modal-body');
    const footerEl = document.getElementById('modal-footer');
    
    if (overlay && titleEl && bodyEl && footerEl) {
      titleEl.textContent = title;
      bodyEl.innerHTML = content;
      footerEl.innerHTML = footer;
      
      overlay.classList.add('active');
      document.body.style.overflow = 'hidden';
    }
  },
  
  closeModal: function() {
    const overlay = document.getElementById('modal-overlay');
    if (overlay) {
      overlay.classList.remove('active');
      document.body.style.overflow = '';
    }
  },
  
  // Debounce utility
  debounce: function(func, wait) {
    let timeout;
    return function executedFunction(...args) {
      const later = () => {
        clearTimeout(timeout);
        func(...args);
      };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  },
  
  // Lazy loading images
  lazyLoadImages: function() {
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const img = entry.target;
          img.src = img.dataset.src;
          img.removeAttribute('data-src');
          observer.unobserve(img);
        }
      });
    });
    
    images.forEach(img => imageObserver.observe(img));
  }
};

// Inizializzazione quando il DOM è pronto
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    window.AgenziaPlinio.init();
  });
} else {
  window.AgenziaPlinio.init();
}

// Event listener per modal close buttons
document.addEventListener('click', (e) => {
  if (e.target.closest('.modal-close') || e.target.classList.contains('modal-overlay')) {
    window.AgenziaPlinio.closeModal();
  }
});

// Performance monitoring (development only)
if (window.location.hostname === 'localhost' || window.location.hostname.includes('local')) {
  window.addEventListener('load', () => {
    const loadTime = performance.now();
    console.log(`⚡ Pagina caricata in ${Math.round(loadTime)}ms`);
  });
}

// Service Worker registration (future implementation)
if ('serviceWorker' in navigator && window.location.protocol === 'https:') {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('/sw.js')
      .then((registration) => {
        console.log('SW registered: ', registration);
      })
      .catch((registrationError) => {
        console.log('SW registration failed: ', registrationError);
      });
  });
}