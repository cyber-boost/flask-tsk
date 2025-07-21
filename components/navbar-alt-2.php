<?php
/**
 * <?tusk> navbar-alt-2 Navigation Component - Split Layout Variant
 * Auto-Inclusion: [tusk-component-navbar-alt-2]
 */
?>

<nav class="tusk-navbar-alt-2" id="tusk-navbar-alt-2">
    <div class="navbar-left">
        <div class="navbar-brand">
            <div class="brand-container">
                <span class="brand-icon">🐘</span>
                <div class="brand-text">
                    <span class="brand-name">TuskPHP</span>
                    <span class="brand-subtitle">Framework</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="navbar-center">
        <div class="navbar-menu" id="navbar-menu-alt-2">
            <div class="menu-group">
                <a href="#home" class="navbar-link active">
                    <span class="link-label">Home</span>
                    <span class="link-description">Welcome page</span>
                </a>
                <a href="#about" class="navbar-link">
                    <span class="link-label">About</span>
                    <span class="link-description">Our story</span>
                </a>
                <a href="#services" class="navbar-link">
                    <span class="link-label">Services</span>
                    <span class="link-description">What we offer</span>
                </a>
            </div>
            
            <div class="menu-divider"></div>
            
            <div class="menu-group">
                <a href="#portfolio" class="navbar-link">
                    <span class="link-label">Portfolio</span>
                    <span class="link-description">Our work</span>
                </a>
                <a href="#blog" class="navbar-link">
                    <span class="link-label">Blog</span>
                    <span class="link-description">Latest news</span>
                </a>
                <a href="#contact" class="navbar-link">
                    <span class="link-label">Contact</span>
                    <span class="link-description">Get in touch</span>
                </a>
            </div>
        </div>
    </div>
    
    <div class="navbar-right">
        <div class="navbar-actions">
            <div class="search-container">
                <input type="text" placeholder="Search..." class="search-input">
                <button class="search-button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            
            <div class="action-buttons">
                <button class="action-btn login-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login</span>
                </button>
                <button class="action-btn signup-btn">
                    <i class="fas fa-user-plus"></i>
                    <span>Sign Up</span>
                </button>
            </div>
        </div>
        
        <button class="mobile-toggle" id="mobile-toggle-alt-2">
            <div class="toggle-container">
                <span class="toggle-line"></span>
                <span class="toggle-line"></span>
                <span class="toggle-line"></span>
            </div>
            <span class="toggle-text">Menu</span>
        </button>
    </div>
</nav>

<style>
.tusk-navbar-alt-2 {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 80px;
    background: linear-gradient(90deg, #1a202c 0%, #2d3748 50%, #1a202c 100%);
    border-bottom: 3px solid #4a5568;
    display: flex;
    align-items: center;
    z-index: 1000;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.navbar-left,
.navbar-right {
    flex: 1;
    display: flex;
    align-items: center;
    padding: 0 2rem;
}

.navbar-right {
    justify-content: flex-end;
}

.navbar-center {
    flex: 2;
    display: flex;
    justify-content: center;
}

.navbar-brand {
    display: flex;
    align-items: center;
}

.brand-container {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 1rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.brand-icon {
    font-size: 2rem;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
}

.brand-text {
    display: flex;
    flex-direction: column;
}

.brand-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: white;
    line-height: 1;
}

.brand-subtitle {
    font-size: 0.75rem;
    color: #a0aec0;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.navbar-menu {
    display: flex;
    align-items: center;
    gap: 2rem;
    background: rgba(255, 255, 255, 0.05);
    padding: 1rem 2rem;
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.menu-group {
    display: flex;
    gap: 1.5rem;
}

.menu-divider {
    width: 1px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
}

.navbar-link {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
    padding: 0.75rem 1rem;
    color: #cbd5e0;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
    position: relative;
    min-width: 80px;
}

.navbar-link::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    transition: width 0.3s ease;
}

.navbar-link:hover::before,
.navbar-link.active::before {
    width: 80%;
}

.navbar-link:hover,
.navbar-link.active {
    color: white;
    background: rgba(255, 255, 255, 0.1);
    text-decoration: none;
}

.link-label {
    font-weight: 600;
    font-size: 0.875rem;
}

.link-description {
    font-size: 0.75rem;
    color: #a0aec0;
    font-weight: 400;
}

.navbar-link:hover .link-description,
.navbar-link.active .link-description {
    color: #e2e8f0;
}

.navbar-actions {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.search-container {
    position: relative;
    display: flex;
    align-items: center;
}

.search-input {
    width: 200px;
    padding: 0.75rem 1rem;
    padding-right: 3rem;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    color: white;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.search-input:focus {
    outline: none;
    background: rgba(255, 255, 255, 0.15);
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
}

.search-input::placeholder {
    color: #a0aec0;
}

.search-button {
    position: absolute;
    right: 0.5rem;
    background: none;
    border: none;
    color: #a0aec0;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.search-button:hover {
    color: white;
    background: rgba(255, 255, 255, 0.1);
}

.action-buttons {
    display: flex;
    gap: 0.75rem;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.05);
    color: #cbd5e0;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.action-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border-color: rgba(255, 255, 255, 0.3);
    text-decoration: none;
}

.signup-btn {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-color: #667eea;
    color: white;
}

.signup-btn:hover {
    background: linear-gradient(135deg, #5a67d8, #6b46c1);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.mobile-toggle {
    display: none;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    padding: 0.75rem;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #cbd5e0;
}

.toggle-container {
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.toggle-line {
    width: 20px;
    height: 2px;
    background: #cbd5e0;
    border-radius: 2px;
    transition: all 0.3s ease;
}

.toggle-text {
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.mobile-toggle.active .toggle-line:nth-child(1) {
    transform: rotate(45deg) translate(5px, 5px);
}

.mobile-toggle.active .toggle-line:nth-child(2) {
    opacity: 0;
}

.mobile-toggle.active .toggle-line:nth-child(3) {
    transform: rotate(-45deg) translate(7px, -6px);
}

@media (max-width: 1024px) {
    .search-container {
        display: none;
    }
    
    .navbar-menu {
        gap: 1rem;
        padding: 0.75rem 1.5rem;
    }
    
    .menu-group {
        gap: 1rem;
    }
}

@media (max-width: 768px) {
    .tusk-navbar-alt-2 {
        height: 70px;
    }
    
    .navbar-left,
    .navbar-right {
        padding: 0 1rem;
    }
    
    .navbar-center {
        display: none;
    }
    
    .action-buttons {
        display: none;
    }
    
    .mobile-toggle {
        display: flex;
    }
    
    .brand-container {
        padding: 0.5rem 0.75rem;
    }
    
    .brand-name {
        font-size: 1.125rem;
    }
    
    /* Mobile menu overlay */
    .navbar-menu.mobile-active {
        position: fixed;
        top: 70px;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, #1a202c 0%, #2d3748 100%);
        border-radius: 0;
        border: none;
        padding: 2rem;
        flex-direction: column;
        justify-content: flex-start;
        gap: 2rem;
        z-index: 999;
        display: flex;
    }
    
    .mobile-active .menu-group {
        flex-direction: column;
        gap: 1rem;
        width: 100%;
    }
    
    .mobile-active .menu-divider {
        width: 100%;
        height: 1px;
    }
    
    .mobile-active .navbar-link {
        width: 100%;
        padding: 1rem;
        min-width: auto;
    }
}

@media (max-width: 480px) {
    .brand-subtitle {
        display: none;
    }
    
    .navbar-left,
    .navbar-right {
        padding: 0 0.75rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.getElementById('tusk-navbar-alt-2');
    const mobileToggle = document.getElementById('mobile-toggle-alt-2');
    const menu = document.getElementById('navbar-menu-alt-2');
    const navLinks = navbar.querySelectorAll('.navbar-link');
    const searchInput = navbar.querySelector('.search-input');
    
    // Mobile menu toggle
    mobileToggle.addEventListener('click', function() {
        this.classList.toggle('active');
        menu.classList.toggle('mobile-active');
        document.body.style.overflow = menu.classList.contains('mobile-active') ? 'hidden' : '';
    });
    
    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('focus', function() {
            this.style.width = '250px';
        });
        
        searchInput.addEventListener('blur', function() {
            if (!this.value) {
                this.style.width = '200px';
            }
        });
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                console.log('Search for:', this.value);
                // Implement search functionality here
            }
        });
    }
    
    // Active link management
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active from all links
            navLinks.forEach(l => l.classList.remove('active'));
            
            // Add active to clicked link
            this.classList.add('active');
            
            // Close mobile menu if open
            if (window.innerWidth <= 768) {
                mobileToggle.classList.remove('active');
                menu.classList.remove('mobile-active');
                document.body.style.overflow = '';
            }
            
            // Smooth scroll to section
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                const offsetTop = targetElement.offsetTop - 80;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!navbar.contains(e.target) && menu.classList.contains('mobile-active')) {
            mobileToggle.classList.remove('active');
            menu.classList.remove('mobile-active');
            document.body.style.overflow = '';
        }
    });
    
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.style.background = 'linear-gradient(90deg, rgba(26, 32, 44, 0.98) 0%, rgba(45, 55, 72, 0.98) 50%, rgba(26, 32, 44, 0.98) 100%)';
            navbar.style.backdropFilter = 'blur(10px)';
        } else {
            navbar.style.background = 'linear-gradient(90deg, #1a202c 0%, #2d3748 50%, #1a202c 100%)';
            navbar.style.backdropFilter = 'none';
        }
    });
    
    // Add typing effect to search placeholder
    if (searchInput) {
        const placeholders = ['Search...', 'Find docs...', 'Look for help...', 'Explore...'];
        let currentIndex = 0;
        let charIndex = 0;
        let isDeleting = false;
        
        function typeEffect() {
            const currentPlaceholder = placeholders[currentIndex];
            
            if (isDeleting) {
                searchInput.placeholder = currentPlaceholder.substring(0, charIndex - 1);
                charIndex--;
            } else {
                searchInput.placeholder = currentPlaceholder.substring(0, charIndex + 1);
                charIndex++;
            }
            
            if (!isDeleting && charIndex === currentPlaceholder.length) {
                setTimeout(() => isDeleting = true, 2000);
            } else if (isDeleting && charIndex === 0) {
                isDeleting = false;
                currentIndex = (currentIndex + 1) % placeholders.length;
            }
            
            const speed = isDeleting ? 50 : 100;
            setTimeout(typeEffect, speed);
        }
        
        // Only start typing effect if search input is not focused
        if (document.activeElement !== searchInput) {
            setTimeout(typeEffect, 1000);
        }
    }
});
</script>