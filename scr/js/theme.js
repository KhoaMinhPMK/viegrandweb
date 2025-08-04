// Theme Controller for VieGrand Landing Page
class ThemeController {
    constructor() {
        this.themes = ['light', 'dark', 'system'];
        this.currentTheme = this.getStoredTheme() || 'system';
        this.init();
    }

    init() {
        this.applyTheme(this.currentTheme);
        this.createThemeToggle();
        this.setupSystemThemeListener();
        console.log('Theme controller initialized with theme:', this.currentTheme);
    }

    getStoredTheme() {
        try {
            return localStorage.getItem('viegrand-theme');
        } catch (e) {
            console.warn('localStorage not available, using system theme');
            return null;
        }
    }

    storeTheme(theme) {
        try {
            localStorage.setItem('viegrand-theme', theme);
        } catch (e) {
            console.warn('Cannot store theme preference');
        }
    }

    getSystemTheme() {
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    applyTheme(theme) {
        const root = document.documentElement;
        
        // Remove existing theme attributes
        root.removeAttribute('data-theme');
        
        if (theme === 'system') {
            // Don't set data-theme, let CSS handle system preference
            const systemTheme = this.getSystemTheme();
            root.style.setProperty('--actual-theme', systemTheme);
        } else {
            root.setAttribute('data-theme', theme);
            root.style.setProperty('--actual-theme', theme);
        }

        // Add transition class for smooth theme changes
        document.body.classList.add('theme-transition');
        setTimeout(() => {
            document.body.classList.remove('theme-transition');
        }, 300);

        this.currentTheme = theme;
        this.storeTheme(theme);
        this.updateThemeToggle();
        
        // Dispatch custom event for other components to listen
        window.dispatchEvent(new CustomEvent('themeChanged', { 
            detail: { 
                theme, 
                actualTheme: theme === 'system' ? this.getSystemTheme() : theme 
            } 
        }));
    }

    createThemeToggle() {
        // Find the header content to add theme toggle
        const headerContent = document.querySelector('.header-content');
        if (!headerContent) {
            console.warn('Header content not found, cannot add theme toggle');
            return;
        }

        // Create theme toggle container
        const themeToggle = document.createElement('div');
        themeToggle.className = 'theme-toggle';
        themeToggle.setAttribute('title', 'Switch theme');

        // Create theme options
        const themeOptions = [
            { theme: 'light', icon: '☀️', title: 'Light mode' },
            { theme: 'dark', icon: '🌙', title: 'Dark mode' },
            { theme: 'system', icon: '💻', title: 'System preference' }
        ];

        themeOptions.forEach(option => {
            const themeOption = document.createElement('div');
            themeOption.className = 'theme-option';
            themeOption.setAttribute('data-theme', option.theme);
            themeOption.setAttribute('title', option.title);
            themeOption.innerHTML = option.icon;
            
            themeOption.addEventListener('click', (e) => {
                e.stopPropagation();
                this.setTheme(option.theme);
            });

            themeToggle.appendChild(themeOption);
        });

        // Add to header (after language toggle if it exists)
        const languageToggle = headerContent.querySelector('.language-toggle');
        if (languageToggle) {
            languageToggle.parentNode.insertBefore(themeToggle, languageToggle.nextSibling);
        } else {
            headerContent.appendChild(themeToggle);
        }

        this.themeToggleElement = themeToggle;
        this.updateThemeToggle();
    }

    updateThemeToggle() {
        if (!this.themeToggleElement) return;

        const options = this.themeToggleElement.querySelectorAll('.theme-option');
        options.forEach(option => {
            const theme = option.getAttribute('data-theme');
            if (theme === this.currentTheme) {
                option.classList.add('active');
            } else {
                option.classList.remove('active');
            }
        });
    }

    setTheme(theme) {
        if (this.themes.includes(theme)) {
            this.applyTheme(theme);
            
            // Add a nice visual feedback
            this.showThemeChangeNotification(theme);
        }
    }

    showThemeChangeNotification(theme) {
        // Create a subtle notification
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            background: var(--bg-card);
            color: var(--text-primary);
            padding: 12px 20px;
            border-radius: 25px;
            border: 1px solid var(--border-color);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-light);
            z-index: 10000;
            font-size: 14px;
            font-weight: 500;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.3s ease;
            pointer-events: none;
        `;

        const themeNames = {
            light: 'Light mode',
            dark: 'Dark mode', 
            system: 'System preference'
        };

        const themeIcons = {
            light: '☀️',
            dark: '🌙',
            system: '💻'
        };

        notification.innerHTML = `${themeIcons[theme]} ${themeNames[theme]} activated`;
        document.body.appendChild(notification);

        // Animate in
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateX(0)';
        }, 10);

        // Animate out and remove
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 2000);
    }

    setupSystemThemeListener() {
        // Listen for system theme changes
        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        mediaQuery.addEventListener('change', (e) => {
            if (this.currentTheme === 'system') {
                // Re-apply system theme to trigger updates
                this.applyTheme('system');
            }
        });
    }

    // Method to get current effective theme (resolves 'system' to actual theme)
    getEffectiveTheme() {
        if (this.currentTheme === 'system') {
            return this.getSystemTheme();
        }
        return this.currentTheme;
    }

    // Method for other scripts to check if dark mode is active
    isDarkMode() {
        return this.getEffectiveTheme() === 'dark';
    }

    // Method to programmatically cycle through themes
    cycleTheme() {
        const currentIndex = this.themes.indexOf(this.currentTheme);
        const nextIndex = (currentIndex + 1) % this.themes.length;
        this.setTheme(this.themes[nextIndex]);
    }
}

// Global theme controller instance
let themeController;

// Initialize theme controller when DOM is ready
function initializeThemeController() {
    if (!themeController) {
        themeController = new ThemeController();
        
        // Make it globally accessible for debugging and external use
        window.themeController = themeController;
        
        console.log('Theme controller ready');
    }
}

// Auto-initialize if DOM is already loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeThemeController);
} else {
    initializeThemeController();
}

// Keyboard shortcut for theme cycling (Ctrl/Cmd + Shift + T)
document.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'T') {
        e.preventDefault();
        if (themeController) {
            themeController.cycleTheme();
        }
    }
});

// Export for module use if needed
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ThemeController;
}
