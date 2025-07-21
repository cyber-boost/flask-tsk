<?php
/**
 * dark-mode-toggle.php
 * Enhanced dark mode with system preference detection and smooth transitions
 */
?>

<section class="tusk-utility-dark-mode-toggle" id="dark-mode">
    <div class="utility-container">
        <h2>🌙 Dark Mode Toggle</h2>
        <p>Seamlessly switch between light and dark themes with system preference detection</p>
        
        <div class="theme-controls">
            <div class="theme-preview">
                <div class="preview-card light-preview" id="light-preview">
                    <h4>☀️ Light Mode</h4>
                    <p>Clean and bright interface for daytime use</p>
                    <div class="preview-elements">
                        <div class="preview-button">Button</div>
                        <div class="preview-text">Sample text content</div>
                    </div>
                </div>
                
                <div class="preview-card dark-preview" id="dark-preview">
                    <h4>🌙 Dark Mode</h4>
                    <p>Easy on the eyes for low-light environments</p>
                    <div class="preview-elements">
                        <div class="preview-button">Button</div>
                        <div class="preview-text">Sample text content</div>
                    </div>
                </div>
            </div>
            
            <div class="toggle-controls">
                <div class="theme-options">
                    <label class="theme-option">
                        <input type="radio" name="theme" value="light" id="theme-light">
                        <span class="theme-label">
                            <span class="theme-icon">☀️</span>
                            Light
                        </span>
                    </label>
                    
                    <label class="theme-option">
                        <input type="radio" name="theme" value="auto" id="theme-auto" checked>
                        <span class="theme-label">
                            <span class="theme-icon">🔄</span>
                            Auto
                        </span>
                    </label>
                    
                    <label class="theme-option">
                        <input type="radio" name="theme" value="dark" id="theme-dark">
                        <span class="theme-label">
                            <span class="theme-icon">🌙</span>
                            Dark
                        </span>
                    </label>
                </div>
                
                <div class="dark-mode-toggle" id="dark-mode-toggle" onclick="quickToggleDarkMode()">
                    <div class="toggle-thumb"></div>
                </div>
                
                <div class="theme-info">
                    <p id="theme-status">Current theme: Auto (following system)</p>
                    <p class="theme-description">
                        Auto mode automatically switches between light and dark themes based on your system preferences.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
let currentTheme = 'auto';

function applyTheme(theme) {
    const body = document.body;
    const toggle = document.getElementById('dark-mode-toggle');
    const status = document.getElementById('theme-status');
    
    // Remove existing theme classes
    body.classList.remove('light-mode', 'dark-mode');
    
    if (theme === 'dark') {
        body.classList.add('dark-mode');
        toggle.classList.add('active');
        status.textContent = 'Current theme: Dark';
    } else if (theme === 'light') {
        body.classList.add('light-mode');
        toggle.classList.remove('active');
        status.textContent = 'Current theme: Light';
    } else {
        // Auto mode
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (prefersDark) {
            body.classList.add('dark-mode');
            toggle.classList.add('active');
        } else {
            body.classList.add('light-mode');
            toggle.classList.remove('active');
        }
        status.textContent = `Current theme: Auto (${prefersDark ? 'Dark' : 'Light'})`;
    }
    
    currentTheme = theme;
    localStorage.setItem('theme-preference', theme);
}

function quickToggleDarkMode() {
    const body = document.body;
    if (body.classList.contains('dark-mode')) {
        applyTheme('light');
        document.getElementById('theme-light').checked = true;
    } else {
        applyTheme('dark');
        document.getElementById('theme-dark').checked = true;
    }
}

// Theme option change handlers
document.querySelectorAll('input[name="theme"]').forEach(radio => {
    radio.addEventListener('change', function() {
        if (this.checked) {
            applyTheme(this.value);
        }
    });
});

// System theme change detection
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
    if (currentTheme === 'auto') {
        applyTheme('auto');
    }
});

// Load saved theme preference
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme-preference') || 'auto';
    document.getElementById(`theme-${savedTheme}`).checked = true;
    applyTheme(savedTheme);
});
</script>