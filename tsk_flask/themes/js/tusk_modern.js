/**
 * 🐘 TuskPHP Modern Theme JavaScript
 * ==================================
 * Interactive behaviors and animations for the modern theme
 */

(function() {
    'use strict';
    
    // Modern Theme Namespace
    window.TuskModern = {
        // Configuration
        config: {
            animationDuration: 300,
            scrollThreshold: 50,
            parallaxSpeed: 0.5
        },
        
        // Initialize modern theme
        init: function() {
            this.initScrollEffects();
            this.initAnimations();
            this.initInteractiveElements();
            this.initParallax();
            this.initSmootScroll();
            this.initNavbar();
            this.initCards();
            this.initForms();
            
            console.log('🐘 TuskPHP Modern Theme initialized');
        },
        
        // Scroll-based effects
        initScrollEffects: function() {
            let ticking = false;
            
            function updateScrollEffects() {
                const scrolled = window.pageYOffset;
                
                // Update navbar
                const navbar = document.querySelector('.navbar-modern');
                if (navbar) {
                    if (scrolled > TuskModern.config.scrollThreshold) {
                        navbar.classList.add('scrolled');
                    } else {
                        navbar.classList.remove('scrolled');
                    }
                }
                
                // Update scroll progress indicator
                const progressBar = document.querySelector('.scroll-progress');
                if (progressBar) {
                    const winHeight = document.body.scrollHeight - window.innerHeight;
                    const scrolled = (window.pageYOffset / winHeight) * 100;
                    progressBar.style.width = scrolled + '%';
                }
                
                ticking = false;
            }
            
            window.addEventListener('scroll', function() {
                if (!ticking) {
                    requestAnimationFrame(updateScrollEffects);
                    ticking = true;
                }
            });
        },
        
        // Intersection Observer animations
        initAnimations: function() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const element = entry.target;
                        
                        // Add animation classes
                        if (element.classList.contains('animate-on-scroll')) {
                            element.classList.add('animate-modern-fade-in');
                        }
                        
                        if (element.classList.contains('animate-slide-in')) {
                            element.classList.add('animate-modern-slide-in');
                        }
                        
                        // Stagger animations for groups
                        if (element.classList.contains('stagger-group')) {
                            const children = element.children;
                            Array.from(children).forEach((child, index) => {
                                setTimeout(() => {
                                    child.classList.add('animate-modern-fade-in');
                                }, index * 100);
                            });
                        }
                        
                        observer.unobserve(element);
                    }
                });
            }, observerOptions);
            
            // Observe elements
            document.querySelectorAll('.animate-on-scroll, .animate-slide-in, .stagger-group').forEach(el => {
                observer.observe(el);
            });
        },
        
        // Interactive element enhancements
        initInteractiveElements: function() {
            // Modern button effects
            document.querySelectorAll('.btn-modern').forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                
                btn.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
                
                btn.addEventListener('mousedown', function() {
                    this.style.transform = 'translateY(0) scale(0.98)';
                });
                
                btn.addEventListener('mouseup', function() {
                    this.style.transform = 'translateY(-2px) scale(1)';
                });
            });
            
            // Ripple effect for buttons
            document.querySelectorAll('.btn-modern').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    ripple.classList.add('ripple');
                    
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.cssText = `
                        position: absolute;
                        width: ${size}px;
                        height: ${size}px;
                        left: ${x}px;
                        top: ${y}px;
                        background: rgba(255, 255, 255, 0.3);
                        border-radius: 50%;
                        transform: scale(0);
                        animation: ripple 0.6s linear;
                        pointer-events: none;
                    `;
                    
                    this.style.position = 'relative';
                    this.style.overflow = 'hidden';
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        },
        
        // Parallax scrolling
        initParallax: function() {
            const parallaxElements = document.querySelectorAll('.parallax-modern');
            
            if (parallaxElements.length === 0) return;
            
            let ticking = false;
            
            function updateParallax() {
                const scrolled = window.pageYOffset;
                
                parallaxElements.forEach(element => {
                    const speed = element.dataset.speed || TuskModern.config.parallaxSpeed;
                    const yPos = -(scrolled * speed);
                    element.style.transform = `translateY(${yPos}px)`;
                });
                
                ticking = false;
            }
            
            window.addEventListener('scroll', function() {
                if (!ticking) {
                    requestAnimationFrame(updateParallax);
                    ticking = true;
                }
            });
        },
        
        // Smooth scrolling
        initSmootScroll: function() {
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        const offsetTop = target.offsetTop - 80; // Account for fixed navbar
                        
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        },
        
        // Navbar enhancements
        initNavbar: function() {
            // Mobile menu toggle
            const mobileToggle = document.querySelector('.navbar-toggler');
            const mobileMenu = document.querySelector('.navbar-collapse');
            
            if (mobileToggle && mobileMenu) {
                mobileToggle.addEventListener('click', function() {
                    mobileMenu.classList.toggle('show');
                    this.classList.toggle('active');
                });
                
                // Close menu when clicking outside
                document.addEventListener('click', function(e) {
                    if (!mobileToggle.contains(e.target) && !mobileMenu.contains(e.target)) {
                        mobileMenu.classList.remove('show');
                        mobileToggle.classList.remove('active');
                    }
                });
            }
            
            // Active link highlighting
            const currentPath = window.location.pathname;
            document.querySelectorAll('.nav-link-modern').forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        },
        
        // Card interactions
        initCards: function() {
            document.querySelectorAll('.card-modern').forEach(card => {
                // Add hover effects
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
                
                // Add click animation
                card.addEventListener('mousedown', function() {
                    this.style.transform = 'translateY(-2px) scale(0.98)';
                });
                
                card.addEventListener('mouseup', function() {
                    this.style.transform = 'translateY(-4px) scale(1)';
                });
            });
        },
        
        // Form enhancements
        initForms: function() {
            // Floating label effect
            document.querySelectorAll('.form-control-modern').forEach(input => {
                const updateLabel = () => {
                    const label = input.previousElementSibling;
                    if (label && label.classList.contains('form-label-modern')) {
                        if (input.value || input === document.activeElement) {
                            label.style.transform = 'translateY(-20px) scale(0.85)';
                            label.style.color = 'var(--primary-color)';
                        } else {
                            label.style.transform = 'translateY(0) scale(1)';
                            label.style.color = 'var(--text-secondary)';
                        }
                    }
                };
                
                input.addEventListener('focus', updateLabel);
                input.addEventListener('blur', updateLabel);
                input.addEventListener('input', updateLabel);
                
                // Initial check
                updateLabel();
            });
            
            // Form validation styling
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    const inputs = this.querySelectorAll('.form-control-modern[required]');
                    let isValid = true;
                    
                    inputs.forEach(input => {
                        if (!input.value.trim()) {
                            input.style.borderColor = 'var(--danger-color)';
                            input.style.boxShadow = '0 0 0 3px rgba(255, 95, 109, 0.1)';
                            isValid = false;
                        } else {
                            input.style.borderColor = 'var(--success-color)';
                            input.style.boxShadow = '0 0 0 3px rgba(0, 176, 155, 0.1)';
                        }
                    });
                    
                    if (!isValid) {
                        e.preventDefault();
                    }
                });
            });
        },
        
        // Utility functions
        utils: {
            // Debounce function
            debounce: function(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            },
            
            // Throttle function
            throttle: function(func, limit) {
                let inThrottle;
                return function() {
                    const args = arguments;
                    const context = this;
                    if (!inThrottle) {
                        func.apply(context, args);
                        inThrottle = true;
                        setTimeout(() => inThrottle = false, limit);
                    }
                };
            },
            
            // Check if element is in viewport
            isInViewport: function(element) {
                const rect = element.getBoundingClientRect();
                return (
                    rect.top >= 0 &&
                    rect.left >= 0 &&
                    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                );
            },
            
            // Create notification
            createNotification: function(message, type = 'info', duration = 3000) {
                const notification = document.createElement('div');
                notification.className = `alert-modern alert-modern-${type}`;
                notification.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    z-index: 9999;
                    min-width: 300px;
                    animation: modernSlideIn 0.3s ease;
                `;
                notification.innerHTML = `
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span>${message}</span>
                        <button onclick="this.parentElement.parentElement.remove()" style="background: none; border: none; font-size: 18px; cursor: pointer;">&times;</button>
                    </div>
                `;
                
                document.body.appendChild(notification);
                
                if (duration > 0) {
                    setTimeout(() => {
                        if (notification.parentElement) {
                            notification.style.animation = 'modernFadeOut 0.3s ease';
                            setTimeout(() => notification.remove(), 300);
                        }
                    }, duration);
                }
            }
        }
    };
    
    // Auto-initialize when DOM is loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', TuskModern.init.bind(TuskModern));
    } else {
        TuskModern.init();
    }
    
    // Add CSS for animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        @keyframes modernFadeOut {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }
        
        .form-label-modern {
            transition: all 0.3s ease;
            pointer-events: none;
        }
        
        .navbar-toggler.active {
            transform: rotate(90deg);
        }
        
        .scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: var(--gradient-primary);
            z-index: 9999;
            transition: width 0.1s ease;
        }
    `;
    document.head.appendChild(style);
    
})();