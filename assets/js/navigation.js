/**
 * Navigation Management - AG Servizi Via Plinio 72
 */

class NavigationManager {
    constructor() {
        this.mobileMenuOpen = false;
        this.init();
    }
    
    init() {
        this.setupMobileMenu();
        this.setupDropdowns();
        this.setupScrollEffects();
        this.setupActiveStates();
        this.setupSmoothScroll();
    }
    
    setupMobileMenu() {
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        const navMenu = document.querySelector('.nav-menu');
        
        if (!mobileToggle || !navMenu) return;
        
        mobileToggle.addEventListener('click', () => {
            this.toggleMobileMenu();
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (this.mobileMenuOpen && 
                !mobileToggle.contains(e.target) && 
                !navMenu.contains(e.target)) {
                this.closeMobileMenu();
            }
        });
        
        // Close menu on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.mobileMenuOpen) {
                this.closeMobileMenu();
            }
        });
        
        // Close menu when window is resized to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768 && this.mobileMenuOpen) {
                this.closeMobileMenu();
            }
        });
    }
    
    toggleMobileMenu() {
        if (this.mobileMenuOpen) {
            this.closeMobileMenu();
        } else {
            this.openMobileMenu();
        }
    }
    
    openMobileMenu() {
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        const navMenu = document.querySelector('.nav-menu');
        
        this.mobileMenuOpen = true;
        mobileToggle.classList.add('active');
        mobileToggle.setAttribute('aria-expanded', 'true');
        navMenu.classList.add('active');
        document.body.classList.add('mobile-menu-open');
    }
    
    closeMobileMenu() {
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        const navMenu = document.querySelector('.nav-menu');
        
        this.mobileMenuOpen = false;
        mobileToggle.classList.remove('active');
        mobileToggle.setAttribute('aria-expanded', 'false');
        navMenu.classList.remove('active');
        document.body.classList.remove('mobile-menu-open');
    }
    
    setupDropdowns() {
        const dropdownItems = document.querySelectorAll('.nav-item.has-dropdown');
        
        dropdownItems.forEach(item => {
            const link = item.querySelector('.nav-link');
            const dropdown = item.querySelector('.mega-menu, .dropdown-menu');
            
            if (!link || !dropdown) return;
            
            let timeout;
            
            // Mouse events for desktop
            item.addEventListener('mouseenter', () => {
                clearTimeout(timeout);
                this.openDropdown(item);
            });
            
            item.addEventListener('mouseleave', () => {
                timeout = setTimeout(() => {
                    this.closeDropdown(item);
                }, 150);
            });
            
            // Click events for mobile
            link.addEventListener('click', (e) => {
                if (window.innerWidth <= 768) {
                    e.preventDefault();
                    const isOpen = item.classList.contains('dropdown-open');
                    this.closeAllDropdowns();
                    if (!isOpen) {
                        this.openDropdown(item);
                    }
                }
            });
            
            // Keyboard navigation
            link.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    const isOpen = item.classList.contains('dropdown-open');
                    this.closeAllDropdowns();
                    if (!isOpen) {
                        this.openDropdown(item);
                    }
                }
            });
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.nav-item.has-dropdown')) {
                this.closeAllDropdowns();
            }
        });
    }
    
    openDropdown(item) {
        item.classList.add('dropdown-open');
        const link = item.querySelector('.nav-link');
        link.setAttribute('aria-expanded', 'true');
    }
    
    closeDropdown(item) {
        item.classList.remove('dropdown-open');
        const link = item.querySelector('.nav-link');
        link.setAttribute('aria-expanded', 'false');
    }
    
    closeAllDropdowns() {
        const openDropdowns = document.querySelectorAll('.nav-item.has-dropdown.dropdown-open');
        openDropdowns.forEach(item => this.closeDropdown(item));
    }
    
    setupScrollEffects() {
        const header = document.querySelector('.site-header');
        if (!header) return;
        
        let lastScroll = 0;
        
        const handleScroll = throttle(() => {
            const currentScroll = window.pageYOffset;
            
            // Add scrolled class for styling
            if (currentScroll > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            
            // Hide/show header based on scroll direction
            if (currentScroll > 200) {
                if (currentScroll > lastScroll && !this.mobileMenuOpen) {
                    header.classList.add('header-hidden');
                } else {
                    header.classList.remove('header-hidden');
                }
            }
            
            lastScroll = currentScroll;
        }, 100);
        
        window.addEventListener('scroll', handleScroll);
    }
    
    setupActiveStates() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav-link');
        
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href && (href === currentPath || currentPath.startsWith(href + '/'))) {
                link.classList.add('active');
                
                // Also mark parent dropdown as active
                const parentDropdown = link.closest('.has-dropdown');
                if (parentDropdown) {
                    const parentLink = parentDropdown.querySelector(':scope > .nav-link');
                    if (parentLink) {
                        parentLink.classList.add('active');
                    }
                }
            }
        });
    }
    
    setupSmoothScroll() {
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(link => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');
                if (href === '#') return;
                
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    const headerHeight = document.querySelector('.site-header')?.offsetHeight || 0;
                    const targetPosition = target.offsetTop - headerHeight - 20;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    if (this.mobileMenuOpen) {
                        this.closeMobileMenu();
                    }
                }
            });
        });
    }
}

// User menu dropdown functionality
class UserMenuManager {
    constructor() {
        this.init();
    }
    
    init() {
        const userMenuToggle = document.querySelector('.user-menu-toggle');
        const userDropdown = document.querySelector('.user-dropdown');
        
        if (!userMenuToggle || !userDropdown) return;
        
        userMenuToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            this.toggleUserMenu();
        });
        
        // Close when clicking outside
        document.addEventListener('click', () => {
            this.closeUserMenu();
        });
        
        // Prevent closing when clicking inside dropdown
        userDropdown.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    }
    
    toggleUserMenu() {
        const userMenu = document.querySelector('.user-menu');
        const isOpen = userMenu.classList.contains('active');
        
        if (isOpen) {
            this.closeUserMenu();
        } else {
            this.openUserMenu();
        }
    }
    
    openUserMenu() {
        const userMenu = document.querySelector('.user-menu');
        const userMenuToggle = document.querySelector('.user-menu-toggle');
        
        userMenu.classList.add('active');
        userMenuToggle.setAttribute('aria-expanded', 'true');
    }
    
    closeUserMenu() {
        const userMenu = document.querySelector('.user-menu');
        const userMenuToggle = document.querySelector('.user-menu-toggle');
        
        if (userMenu) {
            userMenu.classList.remove('active');
        }
        if (userMenuToggle) {
            userMenuToggle.setAttribute('aria-expanded', 'false');
        }
    }
}

// Scroll to top functionality
class ScrollToTopManager {
    constructor() {
        this.init();
    }
    
    init() {
        const scrollBtn = document.querySelector('.scroll-to-top');
        if (!scrollBtn) return;
        
        // Show/hide button based on scroll position
        const handleScroll = throttle(() => {
            if (window.pageYOffset > 300) {
                scrollBtn.classList.add('visible');
            } else {
                scrollBtn.classList.remove('visible');
            }
        }, 100);
        
        window.addEventListener('scroll', handleScroll);
        
        // Scroll to top when clicked
        scrollBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.navigationManager = new NavigationManager();
    window.userMenuManager = new UserMenuManager();
    window.scrollToTopManager = new ScrollToTopManager();
});

// Utility function used by other scripts
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}