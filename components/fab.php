<?php
/**
 * fab.php
 * Enhanced Floating Action Button with multiple actions
 */
?>

<section class="tusk-utility-fab" id="fab-demo">
    <div class="utility-container">
        <h2>🎯 Floating Action Button</h2>
        <p>A versatile FAB with multiple quick actions and smooth animations</p>
        
        <div class="fab-showcase">
            <div class="fab-description">
                <h3>Features:</h3>
                <ul>
                    <li>✨ Smooth animations</li>
                    <li>📱 Mobile-first design</li>
                    <li>🎨 Customizable colors</li>
                    <li>⚡ Lightning fast</li>
                    <li>♿ Accessible</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Main FAB -->
<div class="fab-container">
    <div class="fab-menu" id="fab-menu">
        <button class="fab-action" onclick="scrollToTop()" title="Scroll to Top">
            <span>⬆️</span>
            <span class="fab-label">Top</span>
        </button>
        <button class="fab-action" onclick="openModal('contact-fab')" title="Quick Contact">
            <span>💬</span>
            <span class="fab-label">Contact</span>
        </button>
        <button class="fab-action" onclick="toggleDarkMode()" title="Toggle Theme">
            <span id="theme-icon">🌙</span>
            <span class="fab-label">Theme</span>
        </button>
        <button class="fab-action" onclick="shareWebsite()" title="Share">
            <span>📤</span>
            <span class="fab-label">Share</span>
        </button>
    </div>
    
    <button class="fab fab-main" id="fab-main" onclick="toggleFabMenu()" title="Quick Actions">
        <span class="fab-icon">⚡</span>
    </button>
</div>

<!-- Quick Contact Modal for FAB -->
<div id="contact-fab" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3>📞 Quick Contact</h3>
            <button class="modal-close" onclick="closeModal('contact-fab')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="contact-options">
                <a href="tel:+1234567890" class="contact-option">
                    <span class="contact-icon">📞</span>
                    <span>Call Us</span>
                </a>
                <a href="mailto:hello@tuskphp.com" class="contact-option">
                    <span class="contact-icon">📧</span>
                    <span>Email</span>
                </a>
                <a href="#" onclick="openChat()" class="contact-option">
                    <span class="contact-icon">💬</span>
                    <span>Live Chat</span>
                </a>
                <a href="#" onclick="scheduleCall()" class="contact-option">
                    <span class="contact-icon">📅</span>
                    <span>Schedule Call</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
let fabMenuOpen = false;

function toggleFabMenu() {
    const fabMenu = document.getElementById('fab-menu');
    const fabMain = document.getElementById('fab-main');
    
    fabMenuOpen = !fabMenuOpen;
    
    if (fabMenuOpen) {
        fabMenu.classList.add('open');
        fabMain.classList.add('open');
        fabMain.querySelector('.fab-icon').textContent = '✕';
    } else {
        fabMenu.classList.remove('open');
        fabMain.classList.remove('open');
        fabMain.querySelector('.fab-icon').textContent = '⚡';
    }
}

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
    toggleFabMenu();
}

function toggleDarkMode() {
    const body = document.body;
    const themeIcon = document.getElementById('theme-icon');
    
    body.classList.toggle('dark-mode');
    
    if (body.classList.contains('dark-mode')) {
        themeIcon.textContent = '☀️';
        localStorage.setItem('theme', 'dark');
    } else {
        themeIcon.textContent = '🌙';
        localStorage.setItem('theme', 'light');
    }
    
    toggleFabMenu();
}

function shareWebsite() {
    if (navigator.share) {
        navigator.share({
            title: 'TuskPHP - Strong. Secure. Scalable.',
            text: 'Check out this amazing PHP framework!',
            url: window.location.href
        });
    } else {
        // Fallback for browsers that don't support Web Share API
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            alert('Website URL copied to clipboard!');
        });
    }
    toggleFabMenu();
}

function openChat() {
    closeModal('contact-fab');
    document.getElementById('live-chat').scrollIntoView({ behavior: 'smooth' });
}

function scheduleCall() {
    alert('Redirecting to calendar booking...');
    // In a real app, this would open a calendar booking system
}

// Close FAB menu when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.fab-container') && fabMenuOpen) {
        toggleFabMenu();
    }
});

// Show/hide FAB based on scroll position
let lastScrollTop = 0;
window.addEventListener('scroll', function() {
    const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
    const fabContainer = document.querySelector('.fab-container');
    
    if (currentScroll > lastScrollTop && currentScroll > 300) {
        // Scrolling down
        fabContainer.style.transform = 'translateY(100px)';
    } else {
        // Scrolling up
        fabContainer.style.transform = 'translateY(0)';
    }
    lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
});

// Load saved theme
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-mode');
        document.getElementById('theme-icon').textContent = '☀️';
    }
});
</script>