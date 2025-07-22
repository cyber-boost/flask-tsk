/**
 * 🐘 TuskPHP Peanuts Theme JavaScript
 * ===================================
 * Configuration management and memory tracking functionality
 */

class TuskPeanutsTheme {
    constructor() {
        this.configCache = new Map();
        this.memoryTracker = {
            peak: 0,
            current: 0,
            history: []
        };
        this.init();
    }

    init() {
        this.setupConfigMonitoring();
        this.setupMemoryTracking();
        this.setupConfigEditor();
        this.setupRealtimeUpdates();
        this.setupKeyboardShortcuts();
    }

    // Configuration monitoring
    setupConfigMonitoring() {
        // Monitor configuration changes
        const configElements = document.querySelectorAll('[data-config-key]');
        configElements.forEach(element => {
            const key = element.dataset.configKey;
            const observer = new MutationObserver(() => {
                this.onConfigChange(key, element.textContent || element.value);
            });
            observer.observe(element, { childList: true, characterData: true, attributes: true });
        });

        // Setup config validation
        this.setupConfigValidation();
    }

    // Memory tracking
    setupMemoryTracking() {
        // Simulate memory tracking (in real app, this would connect to actual memory stats)
        this.startMemoryTracking();
        this.createMemoryIndicators();
    }

    // Configuration editor
    setupConfigEditor() {
        const editors = document.querySelectorAll('.form-control-peanuts[data-type="json"]');
        editors.forEach(editor => {
            this.enhanceJsonEditor(editor);
        });
    }

    // Real-time updates
    setupRealtimeUpdates() {
        // Setup WebSocket or polling for real-time config updates
        this.startRealtimeMonitoring();
    }

    // Keyboard shortcuts
    setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Ctrl+S: Save configuration
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                this.saveConfiguration();
            }
            
            // Ctrl+R: Reload configuration
            if (e.ctrlKey && e.key === 'r') {
                e.preventDefault();
                this.reloadConfiguration();
            }
            
            // Ctrl+E: Export configuration
            if (e.ctrlKey && e.key === 'e') {
                e.preventDefault();
                this.exportConfiguration();
            }
        });
    }

    // Configuration change handler
    onConfigChange(key, value) {
        this.configCache.set(key, {
            value: value,
            timestamp: Date.now(),
            type: this.detectConfigType(value)
        });

        // Update status indicator
        this.updateConfigStatus(key, 'modified');
        
        // Validate configuration
        this.validateConfig(key, value);
        
        // Update memory usage
        this.updateMemoryUsage();
    }

    // Detect configuration value type
    detectConfigType(value) {
        if (typeof value === 'boolean') return 'boolean';
        if (!isNaN(value) && !isNaN(parseFloat(value))) return 'number';
        if (value.startsWith('[') || value.startsWith('{')) return 'json';
        if (value.includes('://')) return 'url';
        if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) return 'email';
        return 'string';
    }

    // Configuration validation
    validateConfig(key, value) {
        const validators = {
            email: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val),
            url: (val) => {
                try { new URL(val); return true; } catch { return false; }
            },
            json: (val) => {
                try { JSON.parse(val); return true; } catch { return false; }
            },
            number: (val) => !isNaN(val) && !isNaN(parseFloat(val)),
            boolean: (val) => val === 'true' || val === 'false'
        };

        const type = this.detectConfigType(value);
        const validator = validators[type];
        
        if (validator && !validator(value)) {
            this.showValidationError(key, `Invalid ${type} format`);
            return false;
        }
        
        this.clearValidationError(key);
        return true;
    }

    // Show validation error
    showValidationError(key, message) {
        const element = document.querySelector(`[data-config-key="${key}"]`);
        if (element) {
            element.classList.add('invalid');
            
            // Create or update error message
            let errorEl = element.parentNode.querySelector('.config-error');
            if (!errorEl) {
                errorEl = document.createElement('div');
                errorEl.className = 'config-error';
                element.parentNode.appendChild(errorEl);
            }
            errorEl.textContent = message;
        }
    }

    // Clear validation error
    clearValidationError(key) {
        const element = document.querySelector(`[data-config-key="${key}"]`);
        if (element) {
            element.classList.remove('invalid');
            const errorEl = element.parentNode.querySelector('.config-error');
            if (errorEl) {
                errorEl.remove();
            }
        }
    }

    // Update configuration status
    updateConfigStatus(key, status) {
        const statusEl = document.querySelector(`[data-config-status="${key}"]`);
        if (statusEl) {
            statusEl.className = `config-status ${status}`;
            statusEl.textContent = status.toUpperCase();
        }
    }

    // Memory tracking simulation
    startMemoryTracking() {
        setInterval(() => {
            // Simulate memory usage (in real app, get from server)
            const usage = Math.random() * 100 + this.configCache.size * 2;
            this.updateMemoryIndicator(usage);
            this.memoryTracker.current = usage;
            this.memoryTracker.peak = Math.max(this.memoryTracker.peak, usage);
            this.memoryTracker.history.push({
                timestamp: Date.now(),
                usage: usage
            });
            
            // Keep only last 100 entries
            if (this.memoryTracker.history.length > 100) {
                this.memoryTracker.history.shift();
            }
        }, 2000);
    }

    // Create memory indicators
    createMemoryIndicators() {
        const indicators = document.querySelectorAll('.memory-indicator');
        indicators.forEach(indicator => {
            this.enhanceMemoryIndicator(indicator);
        });
    }

    // Enhance memory indicator
    enhanceMemoryIndicator(indicator) {
        const canvas = document.createElement('canvas');
        canvas.width = 100;
        canvas.height = 30;
        canvas.style.marginLeft = '8px';
        indicator.appendChild(canvas);
        
        const ctx = canvas.getContext('2d');
        
        // Store canvas reference for updates
        indicator._canvas = canvas;
        indicator._ctx = ctx;
    }

    // Update memory indicator
    updateMemoryIndicator(usage) {
        const indicators = document.querySelectorAll('.memory-indicator');
        indicators.forEach(indicator => {
            const valueEl = indicator.querySelector('.memory-value') || indicator;
            valueEl.textContent = `${usage.toFixed(1)}MB`;
            
            // Update canvas if exists
            if (indicator._canvas && indicator._ctx) {
                this.drawMemoryGraph(indicator._ctx, indicator._canvas);
            }
        });
    }

    // Draw memory usage graph
    drawMemoryGraph(ctx, canvas) {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        const history = this.memoryTracker.history.slice(-20); // Last 20 points
        if (history.length < 2) return;
        
        const maxUsage = Math.max(...history.map(h => h.usage));
        const minUsage = Math.min(...history.map(h => h.usage));
        const range = maxUsage - minUsage || 1;
        
        ctx.strokeStyle = '#8b5cf6';
        ctx.lineWidth = 2;
        ctx.beginPath();
        
        history.forEach((point, index) => {
            const x = (index / (history.length - 1)) * canvas.width;
            const y = canvas.height - ((point.usage - minUsage) / range) * canvas.height;
            
            if (index === 0) {
                ctx.moveTo(x, y);
            } else {
                ctx.lineTo(x, y);
            }
        });
        
        ctx.stroke();
    }

    // Enhance JSON editor
    enhanceJsonEditor(editor) {
        editor.addEventListener('input', (e) => {
            this.validateJson(e.target);
            this.formatJson(e.target);
        });
        
        editor.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                e.preventDefault();
                const start = e.target.selectionStart;
                const end = e.target.selectionEnd;
                e.target.value = e.target.value.substring(0, start) + '  ' + e.target.value.substring(end);
                e.target.selectionStart = e.target.selectionEnd = start + 2;
            }
        });
    }

    // Validate JSON
    validateJson(editor) {
        try {
            JSON.parse(editor.value);
            editor.classList.remove('invalid');
        } catch (e) {
            editor.classList.add('invalid');
        }
    }

    // Format JSON
    formatJson(editor) {
        if (editor.dataset.autoFormat !== 'false') {
            try {
                const parsed = JSON.parse(editor.value);
                const formatted = JSON.stringify(parsed, null, 2);
                if (formatted !== editor.value) {
                    const cursorPos = editor.selectionStart;
                    editor.value = formatted;
                    editor.selectionStart = editor.selectionEnd = cursorPos;
                }
            } catch (e) {
                // Don't format invalid JSON
            }
        }
    }

    // Real-time monitoring
    startRealtimeMonitoring() {
        // Simulate real-time updates
        setInterval(() => {
            this.checkConfigUpdates();
        }, 5000);
    }

    // Check for configuration updates
    checkConfigUpdates() {
        // In real app, this would poll server for changes
        const tables = document.querySelectorAll('.table-peanuts');
        tables.forEach(table => {
            this.updateConfigTable(table);
        });
    }

    // Update configuration table
    updateConfigTable(table) {
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
            // Simulate random updates
            if (Math.random() < 0.1) { // 10% chance
                const statusCell = row.querySelector('.config-status');
                if (statusCell) {
                    const statuses = ['active', 'cached', 'loading'];
                    const newStatus = statuses[Math.floor(Math.random() * statuses.length)];
                    statusCell.className = `config-status ${newStatus}`;
                    statusCell.textContent = newStatus.toUpperCase();
                }
            }
        });
    }

    // Save configuration
    saveConfiguration() {
        const config = {};
        this.configCache.forEach((value, key) => {
            config[key] = value.value;
        });
        
        // In real app, send to server
        console.log('Saving configuration:', config);
        
        // Show success message
        this.showNotification('Configuration saved successfully', 'success');
        
        // Update all status indicators
        this.configCache.forEach((value, key) => {
            this.updateConfigStatus(key, 'saved');
        });
    }

    // Reload configuration
    reloadConfiguration() {
        // In real app, fetch from server
        console.log('Reloading configuration...');
        
        this.showNotification('Configuration reloaded', 'info');
        
        // Clear cache
        this.configCache.clear();
        
        // Reset all status indicators
        const statusElements = document.querySelectorAll('.config-status');
        statusElements.forEach(el => {
            el.className = 'config-status active';
            el.textContent = 'ACTIVE';
        });
    }

    // Export configuration
    exportConfiguration() {
        const config = {};
        this.configCache.forEach((value, key) => {
            config[key] = {
                value: value.value,
                type: value.type,
                timestamp: value.timestamp
            };
        });
        
        const exportData = {
            config: config,
            memory: this.memoryTracker,
            timestamp: new Date().toISOString(),
            version: '1.0.0'
        };
        
        const blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `peanuts-config-${Date.now()}.json`;
        a.click();
        URL.revokeObjectURL(url);
        
        this.showNotification('Configuration exported', 'success');
    }

    // Show notification
    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert-peanuts alert-peanuts-${type}`;
        notification.style.position = 'fixed';
        notification.style.top = '20px';
        notification.style.right = '20px';
        notification.style.zIndex = '9999';
        notification.style.minWidth = '300px';
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Update memory usage estimate
    updateMemoryUsage() {
        const usage = this.configCache.size * 0.1 + Math.random() * 2;
        this.updateMemoryIndicator(usage);
    }

    // Configuration setup validator
    setupConfigValidation() {
        const style = document.createElement('style');
        style.textContent = `
            .form-control-peanuts.invalid {
                border-color: var(--status-error);
                box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
            }
            
            .config-error {
                color: var(--status-error);
                font-size: 0.75rem;
                margin-top: var(--space-1);
                font-family: var(--font-mono);
            }
            
            .config-status {
                display: inline-block;
                padding: var(--space-1) var(--space-2);
                border-radius: var(--radius-sm);
                font-size: 0.625rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }
            
            .config-status.active {
                background: rgba(22, 163, 74, 0.1);
                color: var(--status-active);
            }
            
            .config-status.cached {
                background: rgba(234, 88, 12, 0.1);
                color: var(--status-cached);
            }
            
            .config-status.loading {
                background: rgba(37, 99, 235, 0.1);
                color: var(--status-loading);
            }
            
            .config-status.modified {
                background: rgba(245, 158, 11, 0.1);
                color: var(--status-warning);
            }
            
            .config-status.saved {
                background: rgba(22, 163, 74, 0.1);
                color: var(--status-completed);
            }
            
            .memory-value {
                font-weight: 600;
                color: var(--memory-purple);
            }
            
            .notification-enter {
                animation: slideInRight 0.3s ease;
            }
            
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
        `;
        document.head.appendChild(style);
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.tuskPeanutsTheme = new TuskPeanutsTheme();
    
    // Add keyboard shortcut help
    const helpPanel = document.createElement('div');
    helpPanel.style.position = 'fixed';
    helpPanel.style.bottom = '20px';
    helpPanel.style.left = '20px';
    helpPanel.style.background = 'var(--bg-secondary)';
    helpPanel.style.border = '1px solid var(--bg-accent)';
    helpPanel.style.borderRadius = 'var(--radius-md)';
    helpPanel.style.padding = 'var(--space-3)';
    helpPanel.style.fontSize = '0.75rem';
    helpPanel.style.fontFamily = 'var(--font-mono)';
    helpPanel.style.opacity = '0.7';
    helpPanel.innerHTML = `
        <strong>Shortcuts:</strong><br>
        Ctrl+S: Save | Ctrl+R: Reload | Ctrl+E: Export
    `;
    document.body.appendChild(helpPanel);
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = TuskPeanutsTheme;
}