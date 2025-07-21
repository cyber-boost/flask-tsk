<?php
/**
 * <?tusk> navbar-alt-1 Navigation Component - Floating Glass Variant
 * Auto-Inclusion: [tusk-component-navbar-alt-1]
 */
?>

<nav class="tusk-navbar-alt-1" id="tusk-navbar-alt-1">
    <div class="navbar-container">
        <div class="navbar-brand">
            <div class="brand-logo">
                <span class="logo-icon">🐘</span>
            </div>
            <span class="brand-text">TuskPHP</span>
        </div>
        
        <div class="navbar-menu" id="navbar-menu-alt-1">
            <a href="#home" class="navbar-link active">
                <span class="link-icon">🏠</span>
                <span class="link-text">Home</span>
            </a>
            <a href="#about" class="navbar-link">
                <span class="link-icon">📖</span>
                <span class="link-text">About</span>
            </a>
            <a href="#services" class="navbar-link">
                <span class="link-icon">⚡</span>
                <span class="link-text">Services</span>
            </a>
            <a href="#portfolio" class="navbar-link">
                <span class="link-icon">💼</span>
                <span class="link-text">Portfolio</span>
            </a>
            <a href="#contact" class="navbar-link">
                <span class="link-icon">📞</span>
                <span class="link-text">Contact</span>
            </a>
        </div>
        
        <div class="navbar-actions">
            <button class="theme-toggle" id="theme-toggle">
                <i class="fas fa-moon"></i>
            </button>
            <button class="cta-button">
                <span>Get Started</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
        
        <button class="navbar-toggle" id="navbar-toggle-alt-1">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>
    </div>
</nav>

<style>
.tusk-navbar-alt-1 {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: calc(100% - 40px);
    max-width: 1200px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 0.75rem 1.5rem;
    z-index: 1000;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.tusk-navbar-alt-1.scrolled {
    background: rgba(255, 255, 255, 0.98);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.navbar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.navbar-brand {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.brand-logo {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.brand-text {
    font-size: 1.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.navbar-menu {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.navbar-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    color: #4a5568;
    text-decoration: none;
    border-radius: 12px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.navbar-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #667eea, #764ba2);
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 12px;
}

.navbar-link:hover::before,
.navbar-link.active::before {
    opacity: 0.1;
}

.navbar-link:hover,
.navbar-link.active {
    color: #667eea;
    text-decoration: none;
    transform: translateY(-2px);
}

.link-icon {
    font-size: 1rem;
    position: relative;
    z-index: 1;
}

.link-text {
    font-weight: 500;
    font-size: 0.875rem;
    position: relative;
    z-index: 1;
}

.navbar-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.theme-toggle {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.8);
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #4a5568;
}

.theme-toggle:hover {
    background: rgba(255, 255, 255, 1);
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.cta-button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.cta-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}

.cta-button i {
    font-size: 0.75rem;
    transition: transform 0.3s ease;
}

.cta-button:hover i {
    transform: translateX(2px);
}

.navbar-toggle {
    display: none;
    flex-direction: column;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.8);
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    cursor: pointer;
    gap: 4px;
    transition: all 0.3s ease;
}

.hamburger-line {
    width: 20px;
    height: 2px;
    background: #4a5568;
    border-radius: 2px;
    transition: all 0.3s ease;
}

.navbar-toggle.active .hamburger-line:nth-child(1) {
    transform: rotate(45deg) translate(5px, 5px);
}

.navbar-toggle.active .hamburger-line:nth-child(2) {
    opacity: 0;
}

.navbar-toggle.active .hamburger-line:nth-child(3) {
    transform: rotate(-45deg) translate(7px, -6px);
}

@media (max-width: 768px) {
    .tusk-navbar-alt-1 {
        top: 10px;
        width: calc(100% - 20px);
        padding: 0.75rem 1rem;
    }
    
    .navbar-menu {
        position: absolute;
        top: calc(100% + 10px);
        left: 0;
        right: 0;
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        padding: 1rem;
        flex-direction: column;
        gap: 0.5rem;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
    }
    
    .navbar-menu.active {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    
    .navbar-link {
        width: 100%;
        justify-content: flex-start;
        padding: 1rem;
    }
    
    .navbar-toggle {
        display: flex;
    }
    
    .navbar-actions .cta-button {
        display: none;
    }
    
    .brand-text {
        font-size: 1.25rem;
    }
}

@media (max-width: 480px) {
    .tusk-navbar-alt-1 {
        padding: 0.5rem 0.75rem;
    }
    
    .brand-text {
        display: none;
    }
    
    .theme-toggle {
        width: 36px;
        height: 36px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.getElementById('tusk-navbar-alt-1');
    const toggle = document.getElementById('navbar-toggle-alt-1');
    const menu = document.getElementById('navbar-menu-alt-1');
    const themeToggle = document.getElementById('theme-toggle');
    const navLinks = navbar.querySelectorAll('.navbar-link');
    
    // Mobile menu toggle
    toggle.addEventListener('click', function() {
        this.classList.toggle('active');
        menu.classList.toggle('active');
    });
    
    // Theme toggle
    let isDark = false;
    themeToggle.addEventListener('click', function() {
        isDark = !isDark;
        const icon = this.querySelector('i');
        
        if (isDark) {
            icon.className = 'fas fa-sun';
            navbar.style.background = 'rgba(26, 32, 44, 0.95)';
            navbar.style.color = 'white';
            document.documentElement.style.setProperty('--navbar-text-color', 'white');
        } else {
            icon.className = 'fas fa-moon';
            navbar.style.background = 'rgba(255, 255, 255, 0.95)';
            navbar.style.color = '#4a5568';
            document.documentElement.style.setProperty('--navbar-text-color', '#4a5568');
        }
    });
    
    // Scroll effect
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
    
    // Active link tracking
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all links
            navLinks.forEach(l => l.classList.remove('active'));
            
            // Add active class to clicked link
            this.classList.add('active');
            
            // Smooth scroll to target
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                const offsetTop = targetElement.offsetTop - 100;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
            
            // Close mobile menu
            if (window.innerWidth <= 768) {
                toggle.classList.remove('active');
                menu.classList.remove('active');
            }
        });
    });
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!navbar.contains(e.target)) {
            toggle.classList.remove('active');
            menu.classList.remove('active');
        }
    });
    
    // Floating animation on hover
    const ctaButton = navbar.querySelector('.cta-button');
    if (ctaButton) {
        ctaButton.addEventListener('mouseenter', function() {
            this.style.animation = 'float 2s ease-in-out infinite';
        });
        
        ctaButton.addEventListener('mouseleave', function() {
            this.style.animation = '';
        });
    }
    
    // Add floating animation keyframes
    const style = document.createElement('style');
    style.textContent = `
        @keyframes float {
            0%, 100% { transform: translateY(-2px); }
            50% { transform: translateY(-6px); }
        }
    `;
    document.head.appendChild(style);
});
</script>