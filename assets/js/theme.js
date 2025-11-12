/**
 * Theme Management - AG Servizi Via Plinio 72
 */

class ThemeManager {
    constructor() {
        this.themes = {
            light: {
                '--color-background': '#ffffff',
                '--color-text': '#333333',
                '--color-text-muted': '#666666',
                '--color-primary': '#ffbf00',
                '--color-secondary': '#121212',
                '--color-accent': '#ffbf00',
                '--color-border': '#e5e5e5',
                '--color-light-background': '#f8f9fa'
            },
            dark: {
                '--color-background': '#121212',
                '--color-text': '#f5f5f5',
                '--color-text-muted': '#cccccc',
                '--color-primary': '#ffbf00',
                '--color-secondary': '#333333',
                '--color-accent': '#ffbf00',
                '--color-border': '#333333',
                '--color-light-background': '#1a1a1a'
            }
        };
        
        this.currentTheme = this.getStoredTheme();
        this.init();
    }
    
    init() {
        // Apply stored theme
        this.applyTheme(this.currentTheme);
        
        // Set up theme toggle buttons
        this.setupThemeToggles();
        
        // Listen for system theme changes
        this.setupSystemThemeListener();
        
        // Update toggle button state
        this.updateToggleButtons();
    }
    
    getStoredTheme() {
        const stored = localStorage.getItem('theme');
        if (stored && ['light', 'dark', 'auto'].includes(stored)) {
            return stored;
        }
        return 'auto';
    }
    
    getSystemTheme() {
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return 'dark';
        }
        return 'light';
    }
    
    getActiveTheme() {
        if (this.currentTheme === 'auto') {
            return this.getSystemTheme();
        }
        return this.currentTheme;
    }
    
    applyTheme(theme) {
        const activeTheme = theme === 'auto' ? this.getSystemTheme() : theme;
        const root = document.documentElement;
        
        // Apply CSS custom properties
        Object.entries(this.themes[activeTheme]).forEach(([property, value]) => {
            root.style.setProperty(property, value);
        });
        
        // Update body class
        document.body.className = document.body.className
            .replace(/theme-\w+/g, '')
            .trim() + ` theme-${activeTheme}`;
        
        // Update data attribute for theme
        document.body.setAttribute('data-theme', theme);
        
        // Trigger custom event
        window.dispatchEvent(new CustomEvent('themeChanged', {
            detail: { theme: activeTheme, setting: theme }
        }));
    }
    
    setTheme(theme) {
        if (!['light', 'dark', 'auto'].includes(theme)) {
            console.warn('Invalid theme:', theme);
            return;
        }
        
        this.currentTheme = theme;
        localStorage.setItem('theme', theme);
        this.applyTheme(theme);
        this.updateToggleButtons();
    }
    
    toggleTheme() {
        const themes = ['light', 'dark', 'auto'];
        const currentIndex = themes.indexOf(this.currentTheme);
        const nextTheme = themes[(currentIndex + 1) % themes.length];
        this.setTheme(nextTheme);
    }
    
    setupThemeToggles() {
        const toggles = document.querySelectorAll('.theme-toggle');
        toggles.forEach(toggle => {
            toggle.addEventListener('click', () => {
                this.toggleTheme();
            });
        });
        
        // Theme selector dropdowns
        const selectors = document.querySelectorAll('.theme-selector');
        selectors.forEach(selector => {
            selector.addEventListener('change', (e) => {
                this.setTheme(e.target.value);
            });
        });
    }
    
    updateToggleButtons() {
        const toggles = document.querySelectorAll('.theme-toggle');
        const selectors = document.querySelectorAll('.theme-selector');
        const activeTheme = this.getActiveTheme();
        
        // Update toggle button icons
        toggles.forEach(toggle => {
            const sunIcon = toggle.querySelector('.icon-sun');
            const moonIcon = toggle.querySelector('.icon-moon');
            
            if (sunIcon && moonIcon) {
                if (activeTheme === 'dark') {
                    sunIcon.style.display = 'block';
                    moonIcon.style.display = 'none';
                } else {
                    sunIcon.style.display = 'none';
                    moonIcon.style.display = 'block';
                }
            }
            
            // Update title
            toggle.setAttribute('title', 
                activeTheme === 'dark' ? 'Passa al tema chiaro' : 'Passa al tema scuro'
            );
        });
        
        // Update selectors
        selectors.forEach(selector => {
            selector.value = this.currentTheme;
        });
    }
    
    setupSystemThemeListener() {
        if (window.matchMedia) {
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            mediaQuery.addEventListener('change', () => {
                if (this.currentTheme === 'auto') {
                    this.applyTheme('auto');
                }
            });
        }
    }
    
    // Utility method to get current theme info
    getThemeInfo() {
        return {
            setting: this.currentTheme,
            active: this.getActiveTheme(),
            system: this.getSystemTheme()
        };
    }
}

// Initialize theme manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.themeManager = new ThemeManager();
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ThemeManager;
}