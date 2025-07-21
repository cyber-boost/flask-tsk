<?php
/**
 * cookie-consent.php
 * Enhanced cookie consent with granular controls and animations
 */
?>

<section class="tusk-utility-cookie-consent" id="cookie-demo">
    <div class="utility-container">
        <h2>🍪 Cookie Consent Manager</h2>
        <p>GDPR-compliant cookie consent with granular controls and user preferences</p>
        
        <div class="cookie-demo-controls">
            <button class="btn btn-primary" onclick="showCookieBanner()">Show Cookie Banner</button>
            <button class="btn btn-secondary" onclick="openCookieSettings()">Cookie Settings</button>
            <button class="btn btn-secondary" onclick="resetCookiePreferences()">Reset Preferences</button>
        </div>
        
        <div class="current-cookie-status" id="cookie-status">
            <h3>Current Cookie Preferences:</h3>
            <div class="cookie-preference-list"></div>
        </div>
    </div>
</section>

<!-- Cookie Banner -->
<div id="cookie-banner" class="cookie-banner">
    <div class="cookie-content">
        <div class="cookie-message">
            <h3>🍪 We use cookies</h3>
            <p>We use cookies to enhance your browsing experience, serve personalized content, and analyze our traffic. By clicking "Accept All", you consent to our use of cookies.</p>
        </div>
        <div class="cookie-actions">
            <button class="btn btn-secondary" onclick="openCookieSettings()">Customize</button>
            <button class="btn btn-primary" onclick="acceptAllCookies()">Accept All</button>
            <button class="btn btn-outline" onclick="rejectAllCookies()">Reject All</button>
        </div>
    </div>
</div>

<!-- Cookie Settings Modal -->
<div id="cookie-settings-modal" class="modal-overlay">
    <div class="modal-content cookie-modal">
        <div class="modal-header">
            <h3>🍪 Cookie Preferences</h3>
            <button class="modal-close" onclick="closeCookieSettings()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="cookie-category">
                <div class="cookie-category-header">
                    <h4>Essential Cookies</h4>
                    <div class="cookie-toggle">
                        <input type="checkbox" id="essential-cookies" checked disabled>
                        <label for="essential-cookies" class="toggle-label">Always Active</label>
                    </div>
                </div>
                <p>These cookies are necessary for the website to function and cannot be switched off.</p>
            </div>
            
            <div class="cookie-category">
                <div class="cookie-category-header">
                    <h4>Analytics Cookies</h4>
                    <div class="cookie-toggle">
                        <input type="checkbox" id="analytics-cookies">
                        <label for="analytics-cookies" class="toggle-label"></label>
                    </div>
                </div>
                <p>These cookies help us understand how visitors interact with our website by collecting and reporting information anonymously.</p>
            </div>
            
            <div class="cookie-category">
                <div class="cookie-category-header">
                    <h4>Marketing Cookies</h4>
                    <div class="cookie-toggle">
                        <input type="checkbox" id="marketing-cookies">
                        <label for="marketing-cookies" class="toggle-label"></label>
                    </div>
                </div>
                <p>These cookies are used to deliver adverts more relevant to you and your interests.</p>
            </div>
            
            <div class="cookie-category">
                <div class="cookie-category-header">
                    <h4>Functional Cookies</h4>
                    <div class="cookie-toggle">
                        <input type="checkbox" id="functional-cookies">
                        <label for="functional-cookies" class="toggle-label"></label>
                    </div>
                </div>
                <p>These cookies enable enhanced functionality and personalization, such as videos and live chats.</p>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeCookieSettings()">Cancel</button>
            <button class="btn btn-primary" onclick="saveCookiePreferences()">Save Preferences</button>
        </div>
    </div>
</div>

<script>
const cookiePreferences = {
    essential: true,
    analytics: false,
    marketing: false,
    functional: false
};

function showCookieBanner() {
    const banner = document.getElementById('cookie-banner');
    banner.classList.add('show');
}

function hideCookieBanner() {
    const banner = document.getElementById('cookie-banner');
    banner.classList.remove('show');
}

function openCookieSettings() {
    // Load current preferences
    const saved = JSON.parse(localStorage.getItem('cookiePreferences') || '{}');
    
    document.getElementById('analytics-cookies').checked = saved.analytics || false;
    document.getElementById('marketing-cookies').checked = saved.marketing || false;
    document.getElementById('functional-cookies').checked = saved.functional || false;
    
    document.getElementById('cookie-settings-modal').classList.add('active');
    hideCookieBanner();
}

function closeCookieSettings() {
    document.getElementById('cookie-settings-modal').classList.remove('active');
}

function acceptAllCookies() {
    cookiePreferences.analytics = true;
    cookiePreferences.marketing = true;
    cookiePreferences.functional = true;
    
    saveCookiePreferences();
    hideCookieBanner();
    showCookieNotification('All cookies accepted');
}

function rejectAllCookies() {
    cookiePreferences.analytics = false;
    cookiePreferences.marketing = false;
    cookiePreferences.functional = false;
    
    saveCookiePreferences();
    hideCookieBanner();
    showCookieNotification('Only essential cookies accepted');
}

function saveCookiePreferences() {
    cookiePreferences.analytics = document.getElementById('analytics-cookies').checked;
    cookiePreferences.marketing = document.getElementById('marketing-cookies').checked;
    cookiePreferences.functional = document.getElementById('functional-cookies').checked;
    
    localStorage.setItem('cookiePreferences', JSON.stringify(cookiePreferences));
    localStorage.setItem('cookieConsentGiven', 'true');
    
    updateCookieStatus();
    closeCookieSettings();
    hideCookieBanner();
    showCookieNotification('Cookie preferences saved');
}

function resetCookiePreferences() {
    localStorage.removeItem('cookiePreferences');
    localStorage.removeItem('cookieConsentGiven');
    updateCookieStatus();
    showCookieBanner();
}

function updateCookieStatus() {
    const statusDiv = document.querySelector('.cookie-preference-list');
    const preferences = JSON.parse(localStorage.getItem('cookiePreferences') || '{}');
    
    statusDiv.innerHTML = `
        <div class="preference-item">
            <span>Essential Cookies:</span>
            <span class="status enabled">✅ Always Active</span>
        </div>
        <div class="preference-item">
            <span>Analytics Cookies:</span>
            <span class="status ${preferences.analytics ? 'enabled' : 'disabled'}">
                ${preferences.analytics ? '✅ Enabled' : '❌ Disabled'}
            </span>
        </div>
        <div class="preference-item">
            <span>Marketing Cookies:</span>
            <span class="status ${preferences.marketing ? 'enabled' : 'disabled'}">
                ${preferences.marketing ? '✅ Enabled' : '❌ Disabled'}
            </span>
        </div>
        <div class="preference-item">
            <span>Functional Cookies:</span>
            <span class="status ${preferences.functional ? 'enabled' : 'disabled'}">
                ${preferences.functional ? '✅ Enabled' : '❌ Disabled'}
            </span>
        </div>
    `;
}

function showCookieNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'cookie-notification';
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => notification.classList.add('show'), 100);
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => document.body.removeChild(notification), 300);
    }, 3000);
}

// Check if consent was given on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCookieStatus();
    
    const consentGiven = localStorage.getItem('cookieConsentGiven');
    if (!consentGiven) {
        setTimeout(showCookieBanner, 2000); // Show after 2 seconds
    }
});
</script>