<?php
/**
 * <?tusk> Enhanced Toast Notifications Component
 * Created: 2025-06-26
 * Strong. Secure. Scalable. 🐘
 *
 * <?tusk> toast-notifications Component
 * Auto-Inclusion: [tusk-component-toast-notifications]
 * Themes: default, dark, minimal, gradient, neon, corporate, warm, cool
 */

// Theme configuration
$theme = isset($theme) ? $theme : 'default';
$position = isset($position) ? $position : 'top-right'; // top-right, top-left, bottom-right, bottom-left, top-center, bottom-center
$auto_dismiss = isset($auto_dismiss) ? $auto_dismiss : true;
$dismiss_time = isset($dismiss_time) ? $dismiss_time : 5000; // milliseconds
?>

<div class="tusk-toast-container tusk-toast-container--<?php echo $theme; ?> tusk-toast-container--<?php echo $position; ?>" 
     id="toast-container" 
     role="region" 
     aria-label="Notifications"
     aria-live="polite">
</div>

<!-- Demo Section (Remove in production) -->
<section class="tusk-toast-demo tusk-toast-demo--<?php echo $theme; ?>">
    <div class="demo-container">
        <h2>Toast Notifications Demo</h2>
        <p>Click the buttons below to test different notification types:</p>
        
        <div class="demo-buttons">
            <button class="demo-btn demo-btn--success" onclick="showToast('success', 'Success!', 'Your action was completed successfully.')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20,6 9,17 4,12"/>
                </svg>
                Success
            </button>
            
            <button class="demo-btn demo-btn--error" onclick="showToast('error', 'Error!', 'Something went wrong. Please try again.')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
                Error
            </button>
            
            <button class="demo-btn demo-btn--warning" onclick="showToast('warning', 'Warning!', 'Please review your input before proceeding.')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
                Warning
            </button>
            
            <button class="demo-btn demo-btn--info" onclick="showToast('info', 'Info', 'Here is some useful information for you.')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="16" x2="12" y2="12"/>
                    <line x1="12" y1="8" x2="12.01" y2="8"/>
                </svg>
                Info
            </button>
            
            <button class="demo-btn demo-btn--loading" onclick="showToast('loading', 'Loading...', 'Please wait while we process your request.')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="2" x2="12" y2="6"/>
                    <line x1="12" y1="18" x2="12" y2="22"/>
                    <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"/>
                    <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"/>
                    <line x1="2" y1="12" x2="6" y2="12"/>
                    <line x1="18" y1="12" x2="22" y2="12"/>
                    <line x1="4.93" y1="19.07" x2="7.76" y2="16.24"/>
                    <line x1="16.24" y1="7.76" x2="19.07" y2="4.93"/>
                </svg>
                Loading
            </button>
            
            <button class="demo-btn demo-btn--custom" onclick="showToast('custom', '🎉 Celebration!', 'You have unlocked a new achievement!')">
                🎉 Custom
            </button>
        </div>
        
        <div class="demo-options">
            <h3>Options</h3>
            <div class="option-group">
                <label for="position-select">Position:</label>
                <select id="position-select" onchange="updatePosition(this.value)">
                    <option value="top-right">Top Right</option>
                    <option value="top-left">Top Left</option>
                    <option value="bottom-right">Bottom Right</option>
                    <option value="bottom-left">Bottom Left</option>
                    <option value="top-center">Top Center</option>
                    <option value="bottom-center">Bottom Center</option>
                </select>
            </div>
            
            <div class="option-group">
                <label>
                    <input type="checkbox" id="auto-dismiss" checked onchange="toggleAutoDismiss(this.checked)">
                    Auto dismiss (5 seconds)
                </label>
            </div>
        </div>
    </div>
</section>

<style>
/* Toast Container */
.tusk-toast-container {
    position: fixed;
    z-index: 9999;
    pointer-events: none;
    max-width: 420px;
    width: 100%;
}

/* Position variants */
.tusk-toast-container--top-right {
    top: 20px;
    right: 20px;
}

.tusk-toast-container--top-left {
    top: 20px;
    left: 20px;
}

.tusk-toast-container--bottom-right {
    bottom: 20px;
    right: 20px;
}

.tusk-toast-container--bottom-left {
    bottom: 20px;
    left: 20px;
}

.tusk-toast-container--top-center {
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
}

.tusk-toast-container--bottom-center {
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
}

/* Toast Item */
.toast-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 16px 20px;
    margin-bottom: 12px;
    background: white;
    border-radius: 12px;
    border-left: 4px solid #3498db;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
    backdrop-filter: blur(10px);
    pointer-events: auto;
    transform: translateX(100%);
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    position: relative;
    overflow: hidden;
    max-width: 400px;
    word-wrap: break-word;
}

.toast-item.show {
    transform: translateX(0);
    opacity: 1;
}

.toast-item.hide {
    transform: translateX(100%);
    opacity: 0;
    margin-bottom: 0;
    padding-top: 0;
    padding-bottom: 0;
    max-height: 0;
}

/* Left side positions */
.tusk-toast-container--top-left .toast-item,
.tusk-toast-container--bottom-left .toast-item {
    transform: translateX(-100%);
}

.tusk-toast-container--top-left .toast-item.hide,
.tusk-toast-container--bottom-left .toast-item.hide {
    transform: translateX(-100%);
}

/* Center positions */
.tusk-toast-container--top-center .toast-item,
.tusk-toast-container--bottom-center .toast-item {
    transform: translateY(-100%);
}

.tusk-toast-container--top-center .toast-item.show,
.tusk-toast-container--bottom-center .toast-item.show {
    transform: translateY(0);
}

.tusk-toast-container--top-center .toast-item.hide,
.tusk-toast-container--bottom-center .toast-item.hide {
    transform: translateY(-100%);
}

/* Toast Icon */
.toast-icon {
    flex-shrink: 0;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 2px;
}

.toast-icon svg {
    width: 14px;
    height: 14px;
}

/* Toast Content */
.toast-content {
    flex: 1;
    min-width: 0;
}

.toast-title {
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 4px;
    color: #2c3e50;
    line-height: 1.3;
}

.toast-message {
    font-size: 13px;
    color: #7f8c8d;
    line-height: 1.4;
    margin: 0;
}

/* Close Button */
.toast-close {
    flex-shrink: 0;
    background: none;
    border: none;
    color: #bdc3c7;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
    transition: all 0.2s ease;
    margin-top: -2px;
}

.toast-close:hover {
    background: rgba(0, 0, 0, 0.05);
    color: #7f8c8d;
}

.toast-close svg {
    width: 16px;
    height: 16px;
}

/* Progress Bar */
.toast-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 0 0 12px 12px;
    transform-origin: left;
    animation: progressBar linear;
}

@keyframes progressBar {
    from { transform: scaleX(1); }
    to { transform: scaleX(0); }
}

/* Loading Animation */
.toast-loading .toast-icon svg {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Toast Type Variants */
.toast-item--success {
    border-left-color: #2ecc71;
}

.toast-item--success .toast-icon {
    background: #2ecc71;
    color: white;
}

.toast-item--success .toast-progress {
    background: #2ecc71;
}

.toast-item--error {
    border-left-color: #e74c3c;
}

.toast-item--error .toast-icon {
    background: #e74c3c;
    color: white;
}

.toast-item--error .toast-progress {
    background: #e74c3c;
}

.toast-item--warning {
    border-left-color: #f39c12;
}

.toast-item--warning .toast-icon {
    background: #f39c12;
    color: white;
}

.toast-item--warning .toast-progress {
    background: #f39c12;
}

.toast-item--info {
    border-left-color: #3498db;
}

.toast-item--info .toast-icon {
    background: #3498db;
    color: white;
}

.toast-item--info .toast-progress {
    background: #3498db;
}

.toast-item--loading {
    border-left-color: #9b59b6;
}

.toast-item--loading .toast-icon {
    background: #9b59b6;
    color: white;
}

.toast-item--loading .toast-progress {
    background: #9b59b6;
}

.toast-item--custom {
    border-left-color: #e67e22;
}

.toast-item--custom .toast-icon {
    background: #e67e22;
    color: white;
    font-size: 12px;
}

.toast-item--custom .toast-progress {
    background: #e67e22;
}

/* Demo Section Styles */
.tusk-toast-demo {
    padding: 4rem 0;
    text-align: center;
}

.demo-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 2rem;
}

.tusk-toast-demo h2 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: #2c3e50;
}

.tusk-toast-demo p {
    font-size: 1.1rem;
    color: #7f8c8d;
    margin-bottom: 3rem;
}

.demo-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
    margin-bottom: 3rem;
}

.demo-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    font-size: 0.95rem;
}

.demo-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.demo-btn--success {
    background: #2ecc71;
    color: white;
}

.demo-btn--error {
    background: #e74c3c;
    color: white;
}

.demo-btn--warning {
    background: #f39c12;
    color: white;
}

.demo-btn--info {
    background: #3498db;
    color: white;
}

.demo-btn--loading {
    background: #9b59b6;
    color: white;
}

.demo-btn--custom {
    background: #e67e22;
    color: white;
}

.demo-options {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 2rem;
    text-align: left;
    max-width: 400px;
    margin: 0 auto;
}

.demo-options h3 {
    margin-bottom: 1.5rem;
    color: #2c3e50;
    font-size: 1.2rem;
}

.option-group {
    margin-bottom: 1rem;
}

.option-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #2c3e50;
}

.option-group select {
    width: 100%;
    padding: 0.5rem;
    border: 2px solid #e9ecef;
    border-radius: 6px;
    font-size: 0.95rem;
}

.option-group input[type="checkbox"] {
    margin-right: 0.5rem;
}

/* Theme Variants for Demo */
.tusk-toast-demo--default {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.tusk-toast-demo--dark {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    color: white;
}

.tusk-toast-demo--dark h2,
.tusk-toast-demo--dark .demo-options h3,
.tusk-toast-demo--dark .option-group label {
    color: white;
}

.tusk-toast-demo--dark p {
    color: #bdc3c7;
}

.tusk-toast-demo--minimal {
    background: #ffffff;
}

.tusk-toast-demo--gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.tusk-toast-demo--gradient h2,
.tusk-toast-demo--gradient .demo-options h3,
.tusk-toast-demo--gradient .option-group label {
    color: white;
}

.tusk-toast-demo--neon {
    background: #0a0a0a;
    color: #00ff88;
}

.tusk-toast-demo--corporate {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: white;
}

.tusk-toast-demo--warm {
    background: linear-gradient(135deg, #ff9a56 0%, #ffad56 100%);
}

.tusk-toast-demo--cool {
    background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
    color: white;
}

/* Theme Variants for Toast Items */
.tusk-toast-container--dark .toast-item {
    background: rgba(45, 45, 45, 0.95);
    color: white;
    border-left-color: #00ff88;
}

.tusk-toast-container--dark .toast-title {
    color: white;
}

.tusk-toast-container--dark .toast-message {
    color: #bdc3c7;
}

.tusk-toast-container--neon .toast-item {
    background: rgba(0, 20, 40, 0.95);
    color: #00ff88;
    border: 1px solid #00ff88;
    box-shadow: 0 0 20px rgba(0, 255, 136, 0.2);
}

/* Responsive Design */
@media (max-width: 768px) {
    .tusk-toast-container {
        max-width: calc(100vw - 40px);
        left: 20px !important;
        right: 20px !important;
        transform: none !important;
    }
    
    .tusk-toast-demo {
        padding: 2rem 0;
    }
    
    .demo-container {
        padding: 0 1rem;
    }
    
    .demo-buttons {
        gap: 0.5rem;
    }
    
    .demo-btn {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    
    .toast-item {
        max-width: none;
        margin-left: 0;
        margin-right: 0;
    }
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
    .toast-item,
    .toast-progress,
    .demo-btn {
        animation: none;
        transition: none;
    }
    
    .toast-loading .toast-icon svg {
        animation: none;
    }
}

/* High contrast mode */
@media (prefers-contrast: high) {
    .toast-item {
        border: 2px solid black;
    }
    
    .demo-btn {
        border: 2px solid black;
    }
}
</style>

<script>
class ToastManager {
    constructor(options = {}) {
        this.container = document.getElementById('toast-container');
        this.autoDismiss = options.autoDismiss !== false;
        this.dismissTime = options.dismissTime || <?php echo $dismiss_time; ?>;
        this.position = options.position || '<?php echo $position; ?>';
        this.maxToasts = options.maxToasts || 5;
        this.toasts = [];
    }
    
    show(type, title, message, options = {}) {
        const toastId = 'toast-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
        const autoDismiss = options.autoDismiss !== undefined ? options.autoDismiss : this.autoDismiss;
        const dismissTime = options.dismissTime || this.dismissTime;
        
        // Remove oldest toast if we've hit the limit
        if (this.toasts.length >= this.maxToasts) {
            this.remove(this.toasts[0].id);
        }
        
        const toast = this.createToastElement(toastId, type, title, message, autoDismiss, dismissTime);
        
        // Add to container
        if (this.position.includes('bottom')) {
            this.container.insertBefore(toast, this.container.firstChild);
        } else {
            this.container.appendChild(toast);
        }
        
        // Add to tracking array
        this.toasts.push({
            id: toastId,
            element: toast,
            type: type,
            autoDismiss: autoDismiss,
            dismissTime: dismissTime
        });
        
        // Trigger show animation
        requestAnimationFrame(() => {
            toast.classList.add('show');
        });
        
        // Auto dismiss if enabled
        if (autoDismiss && type !== 'loading') {
            setTimeout(() => {
                this.remove(toastId);
            }, dismissTime);
        }
        
        // Announce to screen readers
        this.announceToScreenReader(type, title, message);
        
        return toastId;
    }
    
    createToastElement(id, type, title, message, autoDismiss, dismissTime) {
        const toast = document.createElement('div');
        toast.className = `toast-item toast-item--${type}`;
        toast.id = id;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        
        const icon = this.getIcon(type);
        
        toast.innerHTML = `
            <div class="toast-icon">
                ${icon}
            </div>
            <div class="toast-content">
                <div class="toast-title">${this.escapeHtml(title)}</div>
                <div class="toast-message">${this.escapeHtml(message)}</div>
            </div>
            <button class="toast-close" aria-label="Close notification" onclick="toastManager.remove('${id}')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
            ${autoDismiss && type !== 'loading' ? `<div class="toast-progress" style="animation-duration: ${dismissTime}ms;"></div>` : ''}
        `;
        
        return toast;
    }
    
    getIcon(type) {
        const icons = {
            success: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20,6 9,17 4,12"/></svg>',
            error: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
            warning: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
            info: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>',
            loading: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="2" x2="12" y2="6"/><line x1="12" y1="18" x2="12" y2="22"/><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"/><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"/><line x1="2" y1="12" x2="6" y2="12"/><line x1="18" y1="12" x2="22" y2="12"/><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"/><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"/></svg>',
            custom: '🎉'
        };
        
        return icons[type] || icons.info;
    }
    
    remove(toastId) {
        const toastIndex = this.toasts.findIndex(t => t.id === toastId);
        if (toastIndex === -1) return;
        
        const toast = this.toasts[toastIndex];
        
        // Trigger hide animation
        toast.element.classList.add('hide');
        
        // Remove from DOM after animation
        setTimeout(() => {
            if (toast.element && toast.element.parentNode) {
                toast.element.parentNode.removeChild(toast.element);
            }
            this.toasts.splice(toastIndex, 1);
        }, 400);
    }
    
    removeAll() {
        this.toasts.forEach(toast => {
            this.remove(toast.id);
        });
    }
    
    updatePosition(position) {
        this.position = position;
        this.container.className = this.container.className.replace(/tusk-toast-container--\w+-?\w*/g, '');
        this.container.classList.add(`tusk-toast-container--${position}`);
    }
    
    updateAutoDismiss(autoDismiss) {
        this.autoDismiss = autoDismiss;
    }
    
    escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }
    
    announceToScreenReader(type, title, message) {
        const announcement = `${type}: ${title}. ${message}`;
        const announcer = document.createElement('div');
        announcer.setAttribute('aria-live', 'polite');
        announcer.setAttribute('aria-atomic', 'true');
        announcer.className = 'sr-only';
        announcer.textContent = announcement;
        announcer.style.position = 'absolute';
        announcer.style.left = '-10000px';
        announcer.style.width = '1px';
        announcer.style.height = '1px';
        announcer.style.overflow = 'hidden';
        
        document.body.appendChild(announcer);
        
        setTimeout(() => {
            document.body.removeChild(announcer);
        }, 1000);
    }
}

// Initialize toast manager
const toastManager = new ToastManager({
    autoDismiss: <?php echo $auto_dismiss ? 'true' : 'false'; ?>,
    dismissTime: <?php echo $dismiss_time; ?>,
    position: '<?php echo $position; ?>'
});

// Global function for easy access
function showToast(type, title, message, options = {}) {
    return toastManager.show(type, title, message, options);
}

// Demo functions
function updatePosition(position) {
    toastManager.updatePosition(position);
}

function toggleAutoDismiss(autoDismiss) {
    toastManager.updateAutoDismiss(autoDismiss);
}

// Keyboard shortcuts for accessibility
document.addEventListener('keydown', function(e) {
    // ESC to close all toasts
    if (e.key === 'Escape') {
        toastManager.removeAll();
    }
});

// Handle page visibility changes
document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
        // Pause auto-dismiss when page is hidden
        toastManager.toasts.forEach(toast => {
            if (toast.autoDismiss) {
                const progressBar = toast.element.querySelector('.toast-progress');
                if (progressBar) {
                    progressBar.style.animationPlayState = 'paused';
                }
            }
        });
    } else {
        // Resume auto-dismiss when page is visible
        toastManager.toasts.forEach(toast => {
            if (toast.autoDismiss) {
                const progressBar = toast.element.querySelector('.toast-progress');
                if (progressBar) {
                    progressBar.style.animationPlayState = 'running';
                }
            }
        });
    }
});

// Handle window resize for mobile optimization
window.addEventListener('resize', function() {
    if (window.innerWidth <= 768) {
        toastManager.updatePosition('bottom-center');
    }
});

// Expose toast manager globally for external use
window.TuskToast = {
    show: showToast,
    success: (title, message, options) => showToast('success', title, message, options),
    error: (title, message, options) => showToast('error', title, message, options),
    warning: (title, message, options) => showToast('warning', title, message, options),
    info: (title, message, options) => showToast('info', title, message, options),
    loading: (title, message, options) => showToast('loading', title, message, options),
    custom: (title, message, options) => showToast('custom', title, message, options),
    remove: (id) => toastManager.remove(id),
    removeAll: () => toastManager.removeAll(),
    updatePosition: (position) => toastManager.updatePosition(position),
    updateAutoDismiss: (autoDismiss) => toastManager.updateAutoDismiss(autoDismiss)
};
</script>