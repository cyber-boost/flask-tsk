<?php
/**
 * alert-banners.php
 * Enhanced alert banner system with multiple types, auto-dismiss, and animations
 */
?>

<section class="tusk-utility-alert-banners" id="alerts">
    <div class="utility-container">
        <h2>🚨 Alert Banner System</h2>
        <p>Powerful notification system with auto-dismiss, progress indicators, and multiple alert types</p>
        
        <div class="alert-demo-controls">
            <h3>Try Different Alert Types:</h3>
            <div class="alert-buttons">
                <button class="btn btn-success" onclick="showAlert('success', 'Operation completed successfully! Your data has been saved.')">
                    ✅ Success Alert
                </button>
                <button class="btn btn-secondary" onclick="showAlert('info', 'Did you know? TuskPHP has over 50+ built-in components ready to use.')">
                    ℹ️ Info Alert
                </button>
                <button class="btn" style="background: #ff9800<?php
/**
 * alert-banners.php
 * Enhanced alert banner system with multiple types, auto-dismiss, and animations
 */
?>

<section class="tusk-utility-alert-banners" id="alerts">
    <div class="utility-container">
        <h2>🚨 Alert Banner System</h2>
        <p>Powerful notification system with auto-dismiss, progress indicators, and multiple alert types</p>
        
        <div class="alert-demo-controls">
            <h3>Try Different Alert Types:</h3>
            <div class="alert-buttons">
                <button class="btn btn-success" onclick="showAlert('success', 'Operation completed successfully! Your data has been saved.')">
                    ✅ Success Alert
                </button>
                <button class="btn btn-secondary" onclick="showAlert('info', 'Did you know? TuskPHP has over 50+ built-in components ready to use.')">
                    ℹ️ Info Alert
                </button>
                <button class="btn" style="background: #ff9800; color: white;" onclick="showAlert('warning', 'Warning: Your session will expire in 5 minutes. Please save your work.')">
                    ⚠️ Warning Alert
                </button>
                <button class="btn" style="background: #f44336; color: white;" onclick="showAlert('error', 'Error: Unable to connect to the server. Please check your internet connection.')">
                    ❌ Error Alert
                </button>
            </div>
            
            <div class="alert-options">
                <label class="checkbox-label">
                    <input type="checkbox" id="auto-dismiss" checked>
                    <span class="checkmark"></span>
                    Auto-dismiss after 5 seconds
                </label>
                
                <label class="checkbox-label">
                    <input type="checkbox" id="show-progress" checked>
                    <span class="checkmark"></span>
                    Show progress indicator
                </label>
                
                <label class="checkbox-label">
                    <input type="checkbox" id="play-sound">
                    <span class="checkmark"></span>
                    Play notification sound
                </label>
            </div>
        </div>
        
        <div class="alert-container" id="alert-container">
            <!-- Alerts will be dynamically inserted here -->
        </div>
        
        <div class="alert-history">
            <h3>📋 Alert History</h3>
            <div class="history-container" id="alert-history">
                <p class="no-history">No alerts yet. Try the buttons above!</p>
            </div>
            <button class="btn btn-secondary" onclick="clearHistory()">Clear History</button>
        </div>
    </div>
</section>

<script>
let alertCounter = 0;
let alertHistory = [];

const alertIcons = {
    success: '✅',
    info: 'ℹ️',
    warning: '⚠️',
    error: '❌'
};

function showAlert(type, message, duration = 5000) {
    alertCounter++;
    const alertId = `alert-${alertCounter}`;
    const container = document.getElementById('alert-container');
    const autoDismiss = document.getElementById('auto-dismiss').checked;
    const showProgress = document.getElementById('show-progress').checked;
    const playSound = document.getElementById('play-sound').checked;
    
    // Create alert element
    const alertElement = document.createElement('div');
    alertElement.className = `alert-banner ${type}`;
    alertElement.id = alertId;
    
    alertElement.innerHTML = `
        <div class="alert-content">
            <span class="alert-icon">${alertIcons[type]}</span>
            <div class="alert-text">
                <strong>${type.charAt(0).toUpperCase() + type.slice(1)}:</strong>
                ${message}
            </div>
        </div>
        <button class="alert-close" onclick="dismissAlert('${alertId}')" title="Close alert">
            ×
        </button>
        ${showProgress && autoDismiss ? `<div class="alert-progress" id="${alertId}-progress"></div>` : ''}
    `;
    
    // Insert at the top of container
    container.insertBefore(alertElement, container.firstChild);
    
    // Add to history
    alertHistory.unshift({
        id: alertId,
        type: type,
        message: message,
        timestamp: new Date().toLocaleTimeString()
    });
    updateHistory();
    
    // Play sound if enabled
    if (playSound) {
        playNotificationSound(type);
    }
    
    // Auto-dismiss functionality
    if (autoDismiss) {
        const progressBar = document.getElementById(`${alertId}-progress`);
        
        if (showProgress && progressBar) {
            progressBar.style.width = '100%';
            progressBar.style.transition = `width ${duration}ms linear`;
            
            // Start countdown animation
            setTimeout(() => {
                progressBar.style.width = '0%';
            }, 50);
        }
        
        setTimeout(() => {
            dismissAlert(alertId);
        }, duration);
    }
    
    // Add entrance animation
    setTimeout(() => {
        alertElement.style.opacity = '1';
        alertElement.style.transform = 'translateY(0)';
    }, 50);
}

function dismissAlert(alertId) {
    const alertElement = document.getElementById(alertId);
    if (alertElement) {
        alertElement.style.animation = 'fadeOut 0.3s ease forwards';
        setTimeout(() => {
            if (alertElement.parentNode) {
                alertElement.parentNode.removeChild(alertElement);
            }
        }, 300);
    }
}

function updateHistory() {
    const historyContainer = document.getElementById('alert-history');
    
    if (alertHistory.length === 0) {
        historyContainer.innerHTML = '<p class="no-history">No alerts yet. Try the buttons above!</p>';
        return;
    }
    
    historyContainer.innerHTML = alertHistory.slice(0, 10).map(alert => `
        <div class="history-item ${alert.type}">
            <span class="history-icon">${alertIcons[alert.type]}</span>
            <div class="history-content">
                <div class="history-message">${alert.message}</div>
                <div class="history-time">${alert.timestamp}</div>
            </div>
        </div>
    `).join('');
}

function clearHistory() {
    alertHistory = [];
    updateHistory();
}

function playNotificationSound(type) {
    // Create audio context for sound generation
    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
    const oscillator = audioContext.createOscillator();
    const gainNode = audioContext.createGain();
    
    oscillator.connect(gainNode);
    gainNode.connect(audioContext.destination);
    
    // Different frequencies for different alert types
    const frequencies = {
        success: 800,
        info: 600,
        warning: 500,
        error: 400
    };
    
    oscillator.frequency.setValueAtTime(frequencies[type], audioContext.currentTime);
    oscillator.type = 'sine';
    
    gainNode.gain.setValueAtTime(0.1, audioContext.currentTime);
    gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);
    
    oscillator.start(audioContext.currentTime);
    oscillator.stop(audioContext.currentTime + 0.3);
}

// Keyboard shortcuts for alerts
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey || e.metaKey) {
        switch(e.key) {
            case '1':
                e.preventDefault();
                showAlert('success', 'Keyboard shortcut triggered!');
                break;
            case '2':
                e.preventDefault();
                showAlert('info', 'You can use Ctrl+1,2,3,4 for quick alerts!');
                break;
            case '3':
                e.preventDefault();
                showAlert('warning', 'This is a warning triggered by keyboard!');
                break;
            case '4':
                e.preventDefault();
                showAlert('error', 'Error alert via keyboard shortcut!');
                break;
        }
    }
});

// Initialize with a welcome alert
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        showAlert('info', 'Welcome to the TuskPHP Alert System! Try the buttons above to see different alert types.');
    }, 1000);
});
</script>