/**
 * 🐘 TuskPHP Custom Theme JavaScript
 * =================================
 * Interactive functionality for the custom theme
 */

class TuskCustomTheme {
    constructor() {
        this.init();
    }

    init() {
        this.setupAnimations();
        this.setupInteractiveElements();
        this.setupThemeCustomization();
        this.setupDarkModeToggle();
        this.setupParallax();
    }

    // Setup entrance animations
    setupAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeInUp');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe cards, buttons, and other elements
        document.querySelectorAll('.card-custom, .btn-custom, .alert-custom').forEach(el => {
            observer.observe(el);
        });
    }

    // Setup interactive elements
    setupInteractiveElements() {
        // Button ripple effect
        document.querySelectorAll('.btn-custom').forEach(button => {
            button.addEventListener('click', (e) => {
                const ripple = document.createElement('span');
                const rect = button.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');

                button.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Card hover effects
        document.querySelectorAll('.card-custom').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-8px) scale(1.02)';
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(-4px) scale(1)';
            });
        });
    }

    // Setup theme customization
    setupThemeCustomization() {
        // Color customization
        const colorInputs = document.querySelectorAll('[data-color-var]');
        colorInputs.forEach(input => {
            input.addEventListener('change', (e) => {
                const varName = e.target.dataset.colorVar;
                document.documentElement.style.setProperty(varName, e.target.value);
                this.saveCustomization(varName, e.target.value);
            });
        });

        // Font customization
        const fontSelects = document.querySelectorAll('[data-font-var]');
        fontSelects.forEach(select => {
            select.addEventListener('change', (e) => {
                const varName = e.target.dataset.fontVar;
                document.documentElement.style.setProperty(varName, e.target.value);
                this.saveCustomization(varName, e.target.value);
            });
        });

        // Load saved customizations
        this.loadCustomizations();
    }

    // Setup dark mode toggle
    setupDarkModeToggle() {
        const darkModeToggle = document.getElementById('darkModeToggle');
        if (darkModeToggle) {
            const savedMode = localStorage.getItem('tusk-custom-dark-mode');
            if (savedMode === 'true') {
                document.body.classList.add('dark-mode');
                darkModeToggle.checked = true;
            }

            darkModeToggle.addEventListener('change', (e) => {
                if (e.target.checked) {
                    document.body.classList.add('dark-mode');
                    localStorage.setItem('tusk-custom-dark-mode', 'true');
                } else {
                    document.body.classList.remove('dark-mode');
                    localStorage.setItem('tusk-custom-dark-mode', 'false');
                }
            });
        }
    }

    // Setup parallax effects
    setupParallax() {
        const parallaxElements = document.querySelectorAll('[data-parallax]');
        
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            
            parallaxElements.forEach(element => {
                const speed = element.dataset.parallax || 0.5;
                const yPos = -(scrolled * speed);
                element.style.transform = `translateY(${yPos}px)`;
            });
        });
    }

    // Save customization to localStorage
    saveCustomization(property, value) {
        const customizations = JSON.parse(localStorage.getItem('tusk-custom-theme') || '{}');
        customizations[property] = value;
        localStorage.setItem('tusk-custom-theme', JSON.stringify(customizations));
    }

    // Load customizations from localStorage
    loadCustomizations() {
        const customizations = JSON.parse(localStorage.getItem('tusk-custom-theme') || '{}');
        
        Object.entries(customizations).forEach(([property, value]) => {
            document.documentElement.style.setProperty(property, value);
            
            // Update form inputs
            const input = document.querySelector(`[data-color-var="${property}"], [data-font-var="${property}"]`);
            if (input) {
                input.value = value;
            }
        });
    }

    // Reset theme to defaults
    resetTheme() {
        localStorage.removeItem('tusk-custom-theme');
        localStorage.removeItem('tusk-custom-dark-mode');
        location.reload();
    }

    // Export theme configuration
    exportTheme() {
        const customizations = JSON.parse(localStorage.getItem('tusk-custom-theme') || '{}');
        const darkMode = localStorage.getItem('tusk-custom-dark-mode') === 'true';
        
        const config = {
            customizations,
            darkMode,
            timestamp: new Date().toISOString(),
            version: '1.0.0'
        };

        const blob = new Blob([JSON.stringify(config, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'tusk-custom-theme.json';
        a.click();
        URL.revokeObjectURL(url);
    }

    // Import theme configuration
    importTheme(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            try {
                const config = JSON.parse(e.target.result);
                
                // Apply customizations
                if (config.customizations) {
                    localStorage.setItem('tusk-custom-theme', JSON.stringify(config.customizations));
                }
                
                // Apply dark mode setting
                if (config.darkMode !== undefined) {
                    localStorage.setItem('tusk-custom-dark-mode', config.darkMode.toString());
                }
                
                // Reload to apply changes
                location.reload();
            } catch (error) {
                console.error('Failed to import theme:', error);
                alert('Failed to import theme configuration. Please check the file format.');
            }
        };
        reader.readAsText(file);
    }

    // Generate random theme
    generateRandomTheme() {
        const colors = [
            '#6366f1', '#8b5cf6', '#ec4899', '#ef4444', '#f97316',
            '#f59e0b', '#eab308', '#84cc16', '#22c55e', '#10b981',
            '#14b8a6', '#06b6d4', '#0ea5e9', '#3b82f6', '#6366f1'
        ];

        const randomColor = () => colors[Math.floor(Math.random() * colors.length)];

        const randomizations = {
            '--custom-primary': randomColor(),
            '--custom-secondary': randomColor(),
            '--custom-accent-1': randomColor(),
            '--custom-accent-2': randomColor(),
            '--custom-accent-3': randomColor(),
            '--custom-accent-4': randomColor()
        };

        Object.entries(randomizations).forEach(([property, value]) => {
            document.documentElement.style.setProperty(property, value);
            this.saveCustomization(property, value);
        });

        // Update color inputs
        Object.entries(randomizations).forEach(([property, value]) => {
            const input = document.querySelector(`[data-color-var="${property}"]`);
            if (input) {
                input.value = value;
            }
        });
    }
}

// Custom CSS for ripple effect and animations
const customStyles = `
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }

    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    .dark-mode {
        --bg-primary: var(--custom-neutral-900);
        --bg-secondary: var(--custom-neutral-800);
        --bg-tertiary: var(--custom-neutral-700);
        --text-primary: var(--custom-neutral-100);
        --text-secondary: var(--custom-neutral-300);
        --text-muted: var(--custom-neutral-400);
    }

    .animate-fadeInUp {
        animation: fadeInUp var(--duration-slow) ease-out;
    }

    .animate-pulse {
        animation: pulse 2s infinite;
    }

    /* Theme customization panel */
    .theme-customizer {
        position: fixed;
        top: 50%;
        right: -300px;
        transform: translateY(-50%);
        width: 280px;
        background: var(--bg-secondary);
        border: 1px solid var(--custom-neutral-300);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-xl);
        padding: var(--space-6);
        z-index: 9999;
        transition: right var(--transition-slow);
    }

    .theme-customizer.open {
        right: var(--space-4);
    }

    .theme-customizer-toggle {
        position: absolute;
        left: -40px;
        top: 50%;
        transform: translateY(-50%);
        background: var(--custom-primary);
        color: var(--text-white);
        border: none;
        border-radius: var(--radius-md) 0 0 var(--radius-md);
        padding: var(--space-3);
        cursor: pointer;
        font-size: 1.2rem;
    }

    .color-input-group {
        margin-bottom: var(--space-4);
    }

    .color-input-group label {
        display: block;
        margin-bottom: var(--space-2);
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .color-input-group input[type="color"] {
        width: 100%;
        height: 40px;
        border: 1px solid var(--custom-neutral-300);
        border-radius: var(--radius-md);
        cursor: pointer;
    }
`;

// Inject custom styles
const styleSheet = document.createElement('style');
styleSheet.textContent = customStyles;
document.head.appendChild(styleSheet);

// Initialize theme when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.tuskCustomTheme = new TuskCustomTheme();
    
    // Add theme customizer panel if it doesn't exist
    if (!document.querySelector('.theme-customizer')) {
        const customizer = document.createElement('div');
        customizer.className = 'theme-customizer';
        customizer.innerHTML = `
            <button class="theme-customizer-toggle" onclick="this.parentElement.classList.toggle('open')">
                🎨
            </button>
            <h4>Customize Theme</h4>
            <div class="color-input-group">
                <label for="primary-color">Primary Color</label>
                <input type="color" id="primary-color" data-color-var="--custom-primary" value="#6366f1">
            </div>
            <div class="color-input-group">
                <label for="secondary-color">Secondary Color</label>
                <input type="color" id="secondary-color" data-color-var="--custom-secondary" value="#10b981">
            </div>
            <div class="color-input-group">
                <label for="accent1-color">Accent 1</label>
                <input type="color" id="accent1-color" data-color-var="--custom-accent-1" value="#f59e0b">
            </div>
            <div class="color-input-group">
                <label for="accent2-color">Accent 2</label>
                <input type="color" id="accent2-color" data-color-var="--custom-accent-2" value="#ef4444">
            </div>
            <div style="margin-top: var(--space-6); display: flex; flex-direction: column; gap: var(--space-2);">
                <button class="btn-custom btn-custom-primary" onclick="window.tuskCustomTheme.generateRandomTheme()" style="width: 100%; font-size: 0.75rem;">
                    🎲 Random Theme
                </button>
                <button class="btn-custom btn-custom-secondary" onclick="window.tuskCustomTheme.exportTheme()" style="width: 100%; font-size: 0.75rem;">
                    📦 Export Theme
                </button>
                <button class="btn-custom btn-custom-outline" onclick="window.tuskCustomTheme.resetTheme()" style="width: 100%; font-size: 0.75rem;">
                    🔄 Reset Theme
                </button>
            </div>
            <div style="margin-top: var(--space-4);">
                <label style="display: flex; align-items: center; gap: var(--space-2); font-size: 0.875rem;">
                    <input type="checkbox" id="darkModeToggle" style="margin: 0;">
                    Dark Mode
                </label>
            </div>
        `;
        document.body.appendChild(customizer);
    }
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = TuskCustomTheme;
}