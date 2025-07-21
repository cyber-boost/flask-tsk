<?php
/**
 * accessibility-widget.php
 * Enhanced accessibility widget with comprehensive accessibility features
 */
?>

<section class="tusk-utility-accessibility-widget" id="accessibility">
    <div class="utility-container">
        <h2>♿ Accessibility Widget</h2>
        <p>Comprehensive accessibility tools to make websites inclusive for everyone</p>
        
        <div class="accessibility-demo">
            <h3>🌟 Features Available:</h3>
            <div class="features-showcase">
                <div class="feature-demo">
                    <h4>🔍 Text Size Adjustment</h4>
                    <p>Increase or decrease text size for better readability</p>
                </div>
                
                <div class="feature-demo">
                    <h4>🎨 High Contrast Mode</h4>
                    <p>Enhanced color contrast for users with visual impairments</p>
                </div>
                
                <div class="feature-demo">
                    <h4>📖 Dyslexia-Friendly Font</h4>
                    <p>Special fonts designed for users with dyslexia</p>
                </div>
                
                <div class="feature-demo">
                    <h4>⌨️ Keyboard Navigation</h4>
                    <p>Full keyboard navigation support with visual indicators</p>
                </div>
            </div>
            
            <button class="btn btn-primary" onclick="toggleAccessibilityWidget()">
                🛠️ Open Accessibility Tools
            </button>
        </div>
    </div>
</section>

<!-- Accessibility Toggle Button -->
<button class="accessibility-toggle" id="accessibility-toggle" onclick="toggleAccessibilityWidget()" 
        title="Open Accessibility Tools" aria-label="Accessibility Options">
    ♿
</button>

<!-- Accessibility Widget -->
<div class="accessibility-widget" id="accessibility-widget">
    <div class="widget-header">
        <h3>♿ Accessibility Options</h3>
        <button class="widget-close" onclick="toggleAccessibilityWidget()" aria-label="Close">×</button>
    </div>
    
    <div class="widget-body">
        <div class="accessibility-option">
            <div class="option-info">
                <strong>🔍 Text Size</strong>
                <small>Adjust text size for better readability</small>
            </div>
            <div class="size-controls">
                <button class="size-btn" onclick="adjustTextSize('decrease')" title="Decrease text size">A-</button>
                <span class="size-indicator" id="text-size-indicator">100%</span>
                <button class="size-btn" onclick="adjustTextSize('increase')" title="Increase text size">A+</button>
            </div>
        </div>
        
        <div class="accessibility-option">
            <div class="option-info">
                <strong>🎨 High Contrast</strong>
                <small>Enhance color contrast for better visibility</small>
            </div>
            <div class="option-toggle" onclick="toggleHighContrast()" id="contrast-toggle">
                <div class="toggle-slider"></div>
            </div>
        </div>
        
        <div class="accessibility-option">
            <div class="option-info">
                <strong>📖 Dyslexia Font</strong>
                <small>Use dyslexia-friendly OpenDyslexic font</small>
            </div>
            <div class="option-toggle" onclick="toggleDyslexiaFont()" id="dyslexia-toggle">
                <div class="toggle-slider"></div>
            </div>
        </div>
        
        <div class="accessibility-option">
            <div class="option-info">
                <strong>⌨️ Keyboard Navigation</strong>
                <small>Enhanced keyboard navigation highlights</small>
            </div>
            <div class="option-toggle active" onclick="toggleKeyboardNav()" id="keyboard-toggle">
                <div class="toggle-slider"></div>
            </div>
        </div>
        
        <div class="accessibility-option">
            <div class="option-info">
                <strong>🎯 Focus Indicators</strong>
                <small>Enhanced focus indicators for interactive elements</small>
            </div>
            <div class="option-toggle" onclick="toggleFocusIndicators()" id="focus-toggle">
                <div class="toggle-slider"></div>
            </div>
        </div>
        
        <div class="accessibility-option">
            <div class="option-info">
                <strong>🔊 Screen Reader Support</strong>
                <small>Optimize content for screen readers</small>
            </div>
            <div class="option-toggle active" onclick="toggleScreenReader()" id="screen-reader-toggle">
                <div class="toggle-slider"></div>
            </div>
        </div>
        
        <div class="accessibility-option">
            <div class="option-info">
                <strong>⏸️ Reduce Motion</strong>
                <small>Minimize animations and motion effects</small>
            </div>
            <div class="option-toggle" onclick="toggleReduceMotion()" id="motion-toggle">
                <div class="toggle-slider"></div>
            </div>
        </div>
        
        <div class="widget-actions">
            <button class="btn btn-secondary" onclick="resetAccessibilitySettings()">
                🔄 Reset All
            </button>
            <button class="btn btn-primary" onclick="saveAccessibilitySettings()">
                💾 Save Settings
            </button>
        </div>
        
        <div class="accessibility-info">
            <h4>📞 Need Help?</h4>
            <p>Contact our accessibility team:</p>
            <a href="mailto:accessibility@tuskphp.com">accessibility@tuskphp.com</a>
            <br>
            <a href="tel:+1-800-TUSK-A11Y">+1-800-TUSK-A11Y</a>
        </div>
    </div>
</div>

<script>
let accessibilitySettings = {
    textSize: 100,
    highContrast: false,
    dyslexiaFont: false,
    keyboardNav: true,
    focusIndicators: false,
    screenReader: true,
    reduceMotion: false
};

function toggleAccessibilityWidget() {
    const widget = document.getElementById('accessibility-widget');
    const toggle = document.getElementById('accessibility-toggle');
    
    widget.classList.toggle('open');
    
    if (widget.classList.contains('open')) {
        toggle.setAttribute('aria-expanded', 'true');
        widget.querySelector('.widget-close').focus();
    } else {
        toggle.setAttribute('aria-expanded', 'false');
        toggle.focus();
    }
}

function adjustTextSize(direction) {
    const indicator = document.getElementById('text-size-indicator');
    const body = document.body;
    
    if (direction === 'increase' && accessibilitySettings.textSize < 150) {
        accessibilitySettings.textSize += 10;
    } else if (direction === 'decrease' && accessibilitySettings.textSize > 80) {
        accessibilitySettings.textSize -= 10;
    }
    
    indicator.textContent = accessibilitySettings.textSize + '%';
    body.style.fontSize = (accessibilitySettings.textSize / 100) + 'rem';
    
    announceToScreenReader(`Text size adjusted to ${accessibilitySettings.textSize}%`);
}

function toggleHighContrast() {
    const toggle = document.getElementById('contrast-toggle');
    const body = document.body;
    
    accessibilitySettings.highContrast = !accessibilitySettings.highContrast;
    toggle.classList.toggle('active');
    
    if (accessibilitySettings.highContrast) {
        body.classList.add('high-contrast');
        announceToScreenReader('High contrast mode enabled');
    } else {
        body.classList.remove('high-contrast');
        announceToScreenReader('High contrast mode disabled');
    }
}

function toggleDyslexiaFont() {
    const toggle = document.getElementById('dyslexia-toggle');
    const body = document.body;
    
    accessibilitySettings.dyslexiaFont = !accessibilitySettings.dyslexiaFont;
    toggle.classList.toggle('active');
    
    if (accessibilitySettings.dyslexiaFont) {
        body.classList.add('dyslexia-font');
        announceToScreenReader('Dyslexia-friendly font enabled');
    } else {
        body.classList.remove('dyslexia-font');
        announceToScreenReader('Dyslexia-friendly font disabled');
    }
}

function toggleKeyboardNav() {
    const toggle = document.getElementById('keyboard-toggle');
    const body = document.body;
    
    accessibilitySettings.keyboardNav = !accessibilitySettings.keyboardNav;
    toggle.classList.toggle('active');
    
    if (accessibilitySettings.keyboardNav) {
        body.classList.add('enhanced-keyboard-nav');
        announceToScreenReader('Enhanced keyboard navigation enabled');
    } else {
        body.classList.remove('enhanced-keyboard-nav');
        announceToScreenReader('Enhanced keyboard navigation disabled');
    }
}

function toggleFocusIndicators() {
    const toggle = document.getElementById('focus-toggle');
    const body = document.body;
    
    accessibilitySettings.focusIndicators = !accessibilitySettings.focusIndicators;
    toggle.classList.toggle('active');
    
    if (accessibilitySettings.focusIndicators) {
        body.classList.add('enhanced-focus');
        announceToScreenReader('Enhanced focus indicators enabled');
    } else {
        body.classList.remove('enhanced-focus');
        announceToScreenReader('Enhanced focus indicators disabled');
    }
}

function toggleScreenReader() {
    const toggle = document.getElementById('screen-reader-toggle');
    
    accessibilitySettings.screenReader = !accessibilitySettings.screenReader;
    toggle.classList.toggle('active');
    
    if (accessibilitySettings.screenReader) {
        announceToScreenReader('Screen reader optimization enabled');
    } else {
        announceToScreenReader('Screen reader optimization disabled');
    }
}

function toggleReduceMotion() {
    const toggle = document.getElementById('motion-toggle');
    const body = document.body;
    
    accessibilitySettings.reduceMotion = !accessibilitySettings.reduceMotion;
    toggle.classList.toggle('active');
    
    if (accessibilitySettings.reduceMotion) {
        body.classList.add('reduce-motion');
        announceToScreenReader('Motion effects reduced');
    } else {
        body.classList.remove('reduce-motion');
        announceToScreenReader('Motion effects restored');
    }
}

function resetAccessibilitySettings() {
    const body = document.body;
    
    // Reset all settings
    accessibilitySettings = {
        textSize: 100,
        highContrast: false,
        dyslexiaFont: false,
        keyboardNav: true,
        focusIndicators: false,
        screenReader: true,
        reduceMotion: false
    };
    
    // Reset UI
    document.getElementById('text-size-indicator').textContent = '100%';
    body.style.fontSize = '';
    body.classList.remove('high-contrast', 'dyslexia-font', 'enhanced-focus', 'reduce-motion');
    body.classList.add('enhanced-keyboard-nav');
    
    // Reset toggles
    document.querySelectorAll('.option-toggle').forEach(toggle => {
        toggle.classList.remove('active');
    });
    document.getElementById('keyboard-toggle').classList.add('active');
    document.getElementById('screen-reader-toggle').classList.add('active');
    
    announceToScreenReader('All accessibility settings have been reset to defaults');
}

function saveAccessibilitySettings() {
    localStorage.setItem('tuskphp-accessibility', JSON.stringify(accessibilitySettings));
    announceToScreenReader('Accessibility settings saved');
    
    // Show temporary confirmation
    const confirmation = document.createElement('div');
    confirmation.className = 'accessibility-confirmation';
    confirmation.textContent = '✅ Settings saved successfully!';
    
    document.body.appendChild(confirmation);
    
    setTimeout(() => {
        confirmation.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        confirmation.classList.remove('show');
        setTimeout(() => {
            if (confirmation.parentNode) {
                confirmation.parentNode.removeChild(confirmation);
            }
        }, 300);
    }, 3000);
}

function loadAccessibilitySettings() {
    const saved = localStorage.getItem('tuskphp-accessibility');
    if (saved) {
        const settings = JSON.parse(saved);
        
        // Apply saved settings
        if (settings.textSize !== 100) {
            accessibilitySettings.textSize = settings.textSize;
            document.getElementById('text-size-indicator').textContent = settings.textSize + '%';
            document.body.style.fontSize = (settings.textSize / 100) + 'rem';
        }
        
        if (settings.highContrast) {
            toggleHighContrast();
        }
        
        if (settings.dyslexiaFont) {
            toggleDyslexiaFont();
        }
        
        if (!settings.keyboardNav) {
            toggleKeyboardNav();
        }
        
        if (settings.focusIndicators) {
            toggleFocusIndicators();
        }
        
        if (!settings.screenReader) {
            toggleScreenReader();
        }
        
        if (settings.reduceMotion) {
            toggleReduceMotion();
        }
    }
}

function announceToScreenReader(message) {
    if (!accessibilitySettings.screenReader) return;
    
    const announcement = document.createElement('div');
    announcement.className = 'sr-only';
    announcement.setAttribute('aria-live', 'polite');
    announcement.textContent = message;
    
    document.body.appendChild(announcement);
    
    setTimeout(() => {
        if (announcement.parentNode) {
            announcement.parentNode.removeChild(announcement);
        }
    }, 1000);
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Alt + A to open accessibility widget
    if (e.altKey && e.key === 'a') {
        e.preventDefault();
        toggleAccessibilityWidget();
    }
    
    // Alt + 1-7 for quick toggles
    if (e.altKey && e.key >= '1' && e.key <= '7') {
        e.preventDefault();
        const shortcuts = {
            '1': () => adjustTextSize('increase'),
            '2': () => adjustTextSize('decrease'),
            '3': toggleHighContrast,
            '4': toggleDyslexiaFont,
            '5': toggleKeyboardNav,
            '6': toggleFocusIndicators,
            '7': toggleReduceMotion
        };
        
        if (shortcuts[e.key]) {
            shortcuts[e.key]();
        }
    }
});

// Close widget on Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const widget = document.getElementById('accessibility-widget');
        if (widget.classList.contains('open')) {
            toggleAccessibilityWidget();
        }
    }
});

// Initialize accessibility settings
document.addEventListener('DOMContentLoaded', function() {
    loadAccessibilitySettings();
    
    // Add screen reader only styles
    const style = document.createElement('style');
    style.textContent = `
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
        
        .high-contrast {
            filter: contrast(150%) brightness(1.2);
        }
        
        .dyslexia-font * {
            font-family: 'OpenDyslexic', 'Comic Sans MS', cursive !important;
        }
        
        .enhanced-keyboard-nav *:focus {
            outline: 3px solid #0066cc !important;
            outline-offset: 2px !important;
        }
        
        .enhanced-focus *:focus {
            box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.25) !important;
            outline: 2px solid #007bff !important;
        }
        
        .reduce-motion * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
        
        .accessibility-confirmation {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #28a745;
            color: white;
            padding: 1rem;
            border-radius: 8px;
            z-index: 10000;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.3s ease;
        }
        
        .accessibility-confirmation.show {
            opacity: 1;
            transform: translateX(0);
        }
    `;
    document.head.appendChild(style);
});

// Detect system preferences
if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    toggleReduceMotion();
}

if (window.matchMedia && window.matchMedia('(prefers-contrast: high)').matches) {
    toggleHighContrast();
}
</script>