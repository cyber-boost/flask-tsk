<?php
/**
 * <?tusk> footer-alt-1 Footer Component - Minimal Wave Variant
 * Auto-Inclusion: [tusk-component-footer-alt-1]
 */
?>

<footer class="tusk-footer-alt-1">
    <div class="footer-wave">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z"></path>
        </svg>
    </div>
    
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-brand">
                <div class="brand-logo">
                    <span class="logo-icon">🐘</span>
                    <div class="logo-text">
                        <h3>TuskPHP</h3>
                        <p>Strong. Secure. Scalable.</p>
                    </div>
                </div>
                <p class="brand-description">
                    Building the future of web development with elephant wisdom and modern technology.
                </p>
                <div class="social-links">
                    <a href="#" class="social-link github" title="GitHub">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="#" class="social-link twitter" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-link discord" title="Discord">
                        <i class="fab fa-discord"></i>
                    </a>
                    <a href="#" class="social-link linkedin" title="LinkedIn">
                        <i class="fab fa-linkedin"></i>
                    </a>
                </div>
            </div>
            
            <div class="footer-links">
                <div class="link-group">
                    <h4>Product</h4>
                    <ul>
                        <li><a href="#">Framework</a></li>
                        <li><a href="#">Components</a></li>
                        <li><a href="#">Themes</a></li>
                        <li><a href="#">CLI Tools</a></li>
                    </ul>
                </div>
                
                <div class="link-group">
                    <h4>Developers</h4>
                    <ul>
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">API Reference</a></li>
                        <li><a href="#">Examples</a></li>
                        <li><a href="#">Community</a></li>
                    </ul>
                </div>
                
                <div class="link-group">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-newsletter">
                <h4>Stay Updated</h4>
                <p>Get the latest updates and releases.</p>
                <form class="newsletter-form" onsubmit="subscribeNewsletter(event)">
                    <div class="input-group">
                        <input type="email" placeholder="Enter your email" required>
                        <button type="submit">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
                <div class="footer-badges">
                    <div class="badge">
                        <i class="fas fa-shield-alt"></i>
                        <span>Secure</span>
                    </div>
                    <div class="badge">
                        <i class="fas fa-bolt"></i>
                        <span>Fast</span>
                    </div>
                    <div class="badge">
                        <i class="fas fa-heart"></i>
                        <span>Open Source</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <div class="copyright">
                    <p>&copy; 2024 TuskPHP. All rights reserved. Made with 🐘 by developers, for developers.</p>
                </div>
                <div class="footer-legal">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Cookie Policy</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
.tusk-footer-alt-1 {
    position: relative;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    margin-top: 4rem;
}

.footer-wave {
    position: absolute;
    top: -1px;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
}

.footer-wave svg {
    position: relative;
    display: block;
    width: calc(100% + 1.3px);
    height: 60px;
    fill: white;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 4rem 2rem 0;
}

.footer-content {
    display: grid;
    grid-template-columns: 2fr 2fr 1.5fr;
    gap: 3rem;
    margin-bottom: 3rem;
}

.footer-brand {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.brand-logo {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.logo-icon {
    font-size: 2.5rem;
    padding: 0.75rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    backdrop-filter: blur(10px);
}

.logo-text h3 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
}

.logo-text p {
    margin: 0;
    font-size: 0.875rem;
    opacity: 0.8;
    font-weight: 500;
}

.brand-description {
    font-size: 0.95rem;
    line-height: 1.6;
    opacity: 0.9;
    margin: 0;
}

.social-links {
    display: flex;
    gap: 1rem;
}

.social-link {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.social-link:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-3px);
    text-decoration: none;
    color: white;
}

.social-link.github:hover { background: rgba(51, 51, 51, 0.8); }
.social-link.twitter:hover { background: rgba(29, 161, 242, 0.8); }
.social-link.discord:hover { background: rgba(114, 137, 218, 0.8); }
.social-link.linkedin:hover { background: rgba(0, 119, 181, 0.8); }

.footer-links {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
}

.link-group h4 {
    margin: 0 0 1.5rem 0;
    font-size: 1.125rem;
    font-weight: 600;
    position: relative;
    padding-bottom: 0.5rem;
}

.link-group h4::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 30px;
    height: 2px;
    background: rgba(255, 255, 255, 0.3);
}

.link-group ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.link-group a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.25rem 0;
}

.link-group a:hover {
    color: white;
    text-decoration: none;
    transform: translateX(5px);
}

.link-group a::before {
    content: '→';
    opacity: 0;
    transition: opacity 0.3s ease;
}

.link-group a:hover::before {
    opacity: 1;
}

.footer-newsletter {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.footer-newsletter h4 {
    margin: 0;
    font-size: 1.125rem;
    font-weight: 600;
}

.footer-newsletter p {
    margin: 0;
    font-size: 0.875rem;
    opacity: 0.8;
}

.newsletter-form {
    margin: 1rem 0;
}

.input-group {
    display: flex;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    overflow: hidden;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.input-group input {
    flex: 1;
    padding: 1rem;
    background: transparent;
    border: none;
    color: white;
    font-size: 0.875rem;
}

.input-group input::placeholder {
    color: rgba(255, 255, 255, 0.6);
}

.input-group input:focus {
    outline: none;
}

.input-group button {
    padding: 1rem;
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
}

.input-group button:hover {
    background: rgba(255, 255, 255, 0.3);
}

.footer-badges {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    backdrop-filter: blur(10px);
}

.badge i {
    font-size: 0.875rem;
    color: #ffd700;
}

.footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding: 2rem 0;
}

.footer-bottom-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.copyright p {
    margin: 0;
    font-size: 0.875rem;
    opacity: 0.8;
}

.footer-legal {
    display: flex;
    gap: 2rem;
}

.footer-legal a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    font-size: 0.875rem;
    transition: color 0.3s ease;
}

.footer-legal a:hover {
    color: white;
    text-decoration: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .footer-container {
        padding: 3rem 1rem 0;
    }
    
    .footer-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .footer-links {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .footer-bottom-content {
        flex-direction: column;
        text-align: center;
    }
    
    .footer-legal {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .footer-badges {
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .footer-links {
        grid-template-columns: 1fr;
    }
    
    .social-links {
        justify-content: center;
    }
    
    .brand-logo {
        justify-content: center;
        text-align: center;
    }
    
    .brand-description {
        text-align: center;
    }
}
</style>

<script>
function subscribeNewsletter(event) {
    event.preventDefault();
    const email = event.target.querySelector('input[type="email"]').value;
    
    // Show loading state
    const button = event.target.querySelector('button');
    const originalContent = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    button.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        // Show success message
        const inputGroup = event.target.querySelector('.input-group');
        inputGroup.style.background = 'rgba(72, 187, 120, 0.2)';
        inputGroup.style.borderColor = 'rgba(72, 187, 120, 0.5)';
        
        button.innerHTML = '<i class="fas fa-check"></i>';
        
        // Reset form after 3 seconds
        setTimeout(() => {
            event.target.reset();
            inputGroup.style.background = 'rgba(255, 255, 255, 0.1)';
            inputGroup.style.borderColor = 'rgba(255, 255, 255, 0.2)';
            button.innerHTML = originalContent;
            button.disabled = false;
        }, 3000);
    }, 1500);
}

// Add scroll-triggered animations
document.addEventListener('DOMContentLoaded', function() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });
    
    // Animate footer sections
    const footerSections = document.querySelectorAll('.footer-brand, .footer-links, .footer-newsletter');
    footerSections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        section.style.transition = `all 0.6s ease ${index * 0.2}s`;
        observer.observe(section);
    });
    
    // Animate social links
    const socialLinks = document.querySelectorAll('.social-link');
    socialLinks.forEach((link, index) => {
        link.addEventListener('mouseenter', function() {
            this.style.transform = `translateY(-3px) rotate(${Math.random() * 10 - 5}deg)`;
        });
        
        link.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) rotate(0deg)';
        });
    });
});
</script>