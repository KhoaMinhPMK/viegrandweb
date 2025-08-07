// Theme Controller for VieGrand Landing Page
class ThemeController {
    constructor() {
        this.themes = ['light', 'dark'];
        this.currentTheme = this.getStoredTheme() || 'light';
        this.init();
    }

    init() {
        this.applyTheme(this.currentTheme);
        this.createThemeToggle();
        console.log('Theme controller initialized with theme:', this.currentTheme);
    }

    getStoredTheme() {
        try {
            const stored = localStorage.getItem('viegrand-theme');
            return this.themes.includes(stored) ? stored : null;
        } catch (e) {
            console.warn('localStorage not available, using light theme');
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

    applyTheme(theme) {
        const root = document.documentElement;
        
        // Remove existing theme attributes and styles
        root.removeAttribute('data-theme');
        root.style.removeProperty('--actual-theme');
        
        // Set the data-theme attribute for light/dark modes
        root.setAttribute('data-theme', theme);

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
                actualTheme: theme
            } 
        }));
        
        console.log('Theme applied:', theme);
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
            { theme: 'dark', icon: '🌙', title: 'Dark mode' }
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
            dark: 'Dark mode'
        };

        const themeIcons = {
            light: '☀️',
            dark: '🌙'
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

    // Method to get current effective theme
    getEffectiveTheme() {
        return this.currentTheme;
    }

    // Method for other scripts to check if dark mode is active
    isDarkMode() {
        return this.currentTheme === 'dark';
    }

    // Method to programmatically cycle through themes
    cycleTheme() {
        const currentIndex = this.themes.indexOf(this.currentTheme);
        const nextIndex = (currentIndex + 1) % this.themes.length;
        this.setTheme(this.themes[nextIndex]);
    }

    // Debug method to compare themes
    debugThemeComparison() {
        const root = document.documentElement;
        
        console.log('=== Theme Debug Information ===');
        console.log('Current theme setting:', this.currentTheme);
        console.log('Has data-theme attribute:', root.hasAttribute('data-theme'));
        console.log('data-theme value:', root.getAttribute('data-theme'));
        console.log('CSS variables check:');
        console.log('- --bg-primary:', getComputedStyle(root).getPropertyValue('--bg-primary'));
        console.log('- --text-primary:', getComputedStyle(root).getPropertyValue('--text-primary'));
        console.log('- --brand-primary:', getComputedStyle(root).getPropertyValue('--brand-primary'));
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
    
    // Debug shortcut (Ctrl/Cmd + Shift + D)
    if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'D') {
        e.preventDefault();
        if (themeController) {
            themeController.debugThemeComparison();
        }
    }
});

// Export for module use if needed
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ThemeController;
}
