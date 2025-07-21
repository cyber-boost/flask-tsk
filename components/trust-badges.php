<?php
/**
 * <?tusk> Enhanced Trust Badges Component
 * Created: 2025-06-26
 * Strong. Secure. Scalable. 🐘
 *
 * <?tusk> trust-badges Component
 * Auto-Inclusion: [tusk-component-trust-badges]
 * Themes: default, dark, minimal, gradient, neon, corporate, warm, cool
 */

// Theme and configuration
$theme = isset($theme) ? $theme : 'default';
$layout = isset($layout) ? $layout : 'grid'; // grid, horizontal, vertical
$show_labels = isset($show_labels) ? $show_labels : true;
$animated = isset($animated) ? $animated : true;

// Badge data
$badges = isset($badges) ? $badges : [
    [
        'icon' => 'shield',
        'title' => 'SSL Secured',
        'description' => '256-bit encryption',
        'verified' => true
    ],
    [
        'icon' => 'award',
        'title' => 'Award Winner',
        'description' => 'Best in class 2024',
        'verified' => true
    ],
    [
        'icon' => 'users',
        'title' => '1M+ Users',
        'description' => 'Trusted worldwide',
        'verified' => true
    ],
    [
        'icon' => 'clock',
        'title' => '24/7 Support',
        'description' => 'Always here to help',
        'verified' => true
    ],
    [
        'icon' => 'star',
        'title' => '5-Star Rating',
        'description' => '4.9/5 customer rating',
        'verified' => true
    ],
    [
        'icon' => 'check',
        'title' => 'Money Back',
        'description' => '30-day guarantee',
        'verified' => true
    ]
];
?>

<section class="tusk-trust-badges tusk-trust-badges--<?php echo $theme; ?> tusk-trust-badges--<?php echo $layout; ?>" 
         role="region" 
         aria-label="Trust and Security Badges">
    <div class="trust-container">
        <div class="trust-header">
            <h2 class="trust-title">Trusted by Millions</h2>
            <p class="trust-subtitle">Join over 1 million satisfied customers who trust our platform</p>
        </div>
        
        <div class="badges-grid<?php echo $animated ? ' animated' : ''; ?>">
            <?php foreach ($badges as $index => $badge): ?>
            <div class="badge-item" 
                 data-index="<?php echo $index; ?>"
                 role="img" 
                 aria-label="<?php echo htmlspecialchars($badge['title'] . ': ' . $badge['description']); ?>">
                <div class="badge-icon">
                    <?php echo $this->getBadgeIcon($badge['icon']); ?>
                    <?php if ($badge['verified']): ?>
                    <div class="verified-check" aria-label="Verified">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <polyline points="20,6 9,17 4,12"/>
                        </svg>
                    </div>
                    <?php endif; ?>
                </div>
                
                <?php if ($show_labels): ?>
                <div class="badge-content">
                    <h3 class="badge-title"><?php echo htmlspecialchars($badge['title']); ?></h3>
                    <p class="badge-description"><?php echo htmlspecialchars($badge['description']); ?></p>
                </div>
                <?php endif; ?>
                
                <div class="badge-glow"></div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="trust-stats">
            <div class="stat-item">
                <div class="stat-icon">🔒</div>
                <div class="stat-content">
                    <span class="stat-number">100%</span>
                    <span class="stat-label">Secure</span>
                </div>
            </div>
            
            <div class="stat-item">
                <div class="stat-icon">⚡</div>
                <div class="stat-content">
                    <span class="stat-number">99.9%</span>
                    <span class="stat-label">Uptime</span>
                </div>
            </div>
            
            <div class="stat-item">
                <div class="stat-icon">🌟</div>
                <div class="stat-content">
                    <span class="stat-number">4.9/5</span>
                    <span class="stat-label">Rating</span>
                </div>
            </div>
            
            <div class="stat-item">
                <div class="stat-icon">🚀</div>
                <div class="stat-content">
                    <span class="stat-number">1M+</span>
                    <span class="stat-label">Users</span>
                </div>
            </div>
        </div>
        
        <div class="trust-logos">
            <div class="logo-item">
                <svg width="80" height="40" viewBox="0 0 200 100" fill="currentColor" opacity="0.6">
                    <rect x="10" y="30" width="180" height="40" rx="8" fill="none" stroke="currentColor" stroke-width="2"/>
                    <text x="100" y="55" text-anchor="middle" font-size="16" font-weight="bold">Norton</text>
                </svg>
            </div>
            <div class="logo-item">
                <svg width="80" height="40" viewBox="0 0 200 100" fill="currentColor" opacity="0.6">
                    <circle cx="50" cy="50" r="20" fill="none" stroke="currentColor" stroke-width="2"/>
                    <text x="100" y="55" text-anchor="middle" font-size="16" font-weight="bold">McAfee</text>
                </svg>
            </div>
            <div class="logo-item">
                <svg width="80" height="40" viewBox="0 0 200 100" fill="currentColor" opacity="0.6">
                    <path d="M20 30 L40 50 L20 70 M60 30 L180 30 L180 70 L60 70 Z" fill="none" stroke="currentColor" stroke-width="2"/>
                    <text x="120" y="55" text-anchor="middle" font-size="16" font-weight="bold">PayPal</text>
                </svg>
            </div>
            <div class="logo-item">
                <svg width="80" height="40" viewBox="0 0 200 100" fill="currentColor" opacity="0.6">
                    <rect x="10" y="35" width="30" height="30" rx="4" fill="none" stroke="currentColor" stroke-width="2"/>
                    <rect x="50" y="35" width="30" height="30" rx="4" fill="none" stroke="currentColor" stroke-width="2"/>
                    <text x="120" y="55" text-anchor="middle" font-size="16" font-weight="bold">Stripe</text>
                </svg>
            </div>
        </div>
    </div>
</section>

<style>
/* Base Styles */
.tusk-trust-badges {
    padding: 5rem 0;
    position: relative;
    overflow: hidden;
}

.trust-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

.trust-header {
    text-align: center;
    margin-bottom: 4rem;
}

.trust-title {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 800;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.trust-subtitle {
    font-size: 1.2rem;
    opacity: 0.8;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

/* Badge Grid Layouts */
.badges-grid {
    display: grid;
    gap: 2rem;
    margin-bottom: 4rem;
}

.tusk-trust-badges--grid .badges-grid {
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
}

.tusk-trust-badges--horizontal .badges-grid {
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.tusk-trust-badges--vertical .badges-grid {
    grid-template-columns: 1fr;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

/* Badge Items */
.badge-item {
    position: relative;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    overflow: hidden;
    cursor: pointer;
}

.badge-item:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.badge-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #3498db, #e74c3c, #f39c12, #2ecc71);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.badge-item:hover::before {
    transform: scaleX(1);
}

.badge-icon {
    position: relative;
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
}

.badge-item:hover .badge-icon {
    transform: rotate(360deg) scale(1.1);
    box-shadow: 0 12px 40px rgba(102, 126, 234, 0.4);
}

.badge-icon svg {
    width: 32px;
    height: 32px;
}

.verified-check {
    position: absolute;
    top: -4px;
    right: -4px;
    width: 24px;
    height: 24px;
    background: #2ecc71;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    border: 3px solid white;
    animation: verifiedPulse 2s infinite;
}

@keyframes verifiedPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.badge-content {
    position: relative;
    z-index: 2;
}

.badge-title {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: #2c3e50;
}

.badge-description {
    font-size: 0.95rem;
    color: #7f8c8d;
    line-height: 1.4;
    margin: 0;
}

.badge-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100px;
    height: 100px;
    background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
    border-radius: 50%;
    transform: translate(-50%, -50%) scale(0);
    transition: transform 0.3s ease;
    pointer-events: none;
}

.badge-item:hover .badge-glow {
    transform: translate(-50%, -50%) scale(2);
}

/* Animated entrance */
.badges-grid.animated .badge-item {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.6s ease forwards;
}

.badges-grid.animated .badge-item:nth-child(1) { animation-delay: 0.1s; }
.badges-grid.animated .badge-item:nth-child(2) { animation-delay: 0.2s; }
.badges-grid.animated .badge-item:nth-child(3) { animation-delay: 0.3s; }
.badges-grid.animated .badge-item:nth-child(4) { animation-delay: 0.4s; }
.badges-grid.animated .badge-item:nth-child(5) { animation-delay: 0.5s; }
.badges-grid.animated .badge-item:nth-child(6) { animation-delay: 0.6s; }

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Trust Stats */
.trust-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    margin-bottom: 4rem;
    padding: 2rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 16px;
    backdrop-filter: blur(10px);
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    text-align: left;
}

.stat-icon {
    font-size: 2rem;
    filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
}

.stat-number {
    display: block;
    font-size: 1.8rem;
    font-weight: 800;
    color: #2c3e50;
    line-height: 1;
}

.stat-label {
    display: block;
    font-size: 0.9rem;
    color: #7f8c8d;
    font-weight: 500;
}

/* Trust Logos */
.trust-logos {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 3rem;
    flex-wrap: wrap;
    padding: 2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.logo-item {
    transition: all 0.3s ease;
    opacity: 0.6;
}

.logo-item:hover {
    opacity: 1;
    transform: scale(1.05);
}

/* Theme Variants */
.tusk-trust-badges--default {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    color: #2c3e50;
}

.tusk-trust-badges--dark {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    color: white;
}

.tusk-trust-badges--dark .badge-item {
    background: rgba(45, 45, 45, 0.95);
    border-color: rgba(255, 255, 255, 0.1);
}

.tusk-trust-badges--dark .badge-title,
.tusk-trust-badges--dark .stat-number {
    color: white;
}

.tusk-trust-badges--dark .trust-title {
    background: linear-gradient(135deg, #00ff88 0%, #00d4ff 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.tusk-trust-badges--minimal {
    background: #ffffff;
    color: #333333;
}

.tusk-trust-badges--minimal .badge-item {
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
}

.tusk-trust-badges--gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.tusk-trust-badges--gradient .badge-item {
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.2);
}

.tusk-trust-badges--gradient .badge-title,
.tusk-trust-badges--gradient .stat-number {
    color: white;
}

.tusk-trust-badges--neon {
    background: #0a0a0a;
    color: #00ff88;
}

.tusk-trust-badges--neon .badge-item {
    background: rgba(0, 20, 40, 0.9);
    border: 1px solid #00ff88;
    box-shadow: 0 0 30px rgba(0, 255, 136, 0.2);
}

.tusk-trust-badges--neon .badge-icon {
    background: linear-gradient(135deg, #00ff88 0%, #00d4ff 100%);
}

.tusk-trust-badges--corporate {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: white;
}

.tusk-trust-badges--corporate .badge-item {
    background: rgba(255, 255, 255, 0.1);
}

.tusk-trust-badges--corporate .badge-title,
.tusk-trust-badges--corporate .stat-number {
    color: white;
}

.tusk-trust-badges--warm {
    background: linear-gradient(135deg, #ff9a56 0%, #ffad56 100%);
    color: #2c3e50;
}

.tusk-trust-badges--cool {
    background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
    color: white;
}

.tusk-trust-badges--cool .badge-item {
    background: rgba(255, 255, 255, 0.15);
}

.tusk-trust-badges--cool .badge-title,
.tusk-trust-badges--cool .stat-number {
    color: white;
}

/* Responsive Design */
@media (max-width: 968px) {
    .trust-container {
        padding: 0 1.5rem;
    }
    
    .badges-grid {
        gap: 1.5rem;
    }
    
    .trust-stats {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .tusk-trust-badges {
        padding: 3rem 0;
    }
    
    .trust-header {
        margin-bottom: 2.5rem;
    }
    
    .badge-item {
        padding: 1.5rem;
    }
    
    .badge-icon {
        width: 60px;
        height: 60px;
        margin-bottom: 1rem;
    }
    
    .badge-icon svg {
        width: 24px;
        height: 24px;
    }
    
    .trust-stats {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .trust-logos {
        gap: 2rem;
    }
    
    .logo-item svg {
        width: 60px;
        height: 30px;
    }
}

@media (max-width: 480px) {
    .trust-container {
        padding: 0 1rem;
    }
    
    .tusk-trust-badges--grid .badges-grid {
        grid-template-columns: 1fr;
    }
    
    .badge-item {
        padding: 1rem;
    }
    
    .trust-stats {
        padding: 1rem;
    }
    
    .stat-item {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
    .badge-item,
    .badge-icon,
    .verified-check,
    .badge-glow,
    .logo-item {
        animation: none;
        transition: none;
    }
    
    .badges-grid.animated .badge-item {
        animation: none;
        opacity: 1;
        transform: none;
    }
}

/* High contrast mode */
@media (prefers-contrast: high) {
    .badge-item {
        border: 2px solid black;
    }
    
    .badge-icon {
        border: 2px solid black;
    }
}

/* Print styles */
@media print {
    .tusk-trust-badges {
        background: white !important;
        color: black !important;
    }
    
    .badge-item {
        background: white !important;
        border: 1px solid black !important;
        box-shadow: none !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const trustBadges = document.querySelectorAll('.tusk-trust-badges');
    
    trustBadges.forEach(section => {
        const badges = section.querySelectorAll('.badge-item');
        const stats = section.querySelectorAll('.stat-number');
        
        // Animate numbers on scroll
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Animate stats
                    stats.forEach(stat => {
                        animateNumber(stat);
                    });
                    
                    // Add entrance animations if not already animated
                    if (!section.querySelector('.badges-grid').classList.contains('animated')) {
                        section.querySelector('.badges-grid').classList.add('animated');
                    }
                }
            });
        }, observerOptions);
        
        observer.observe(section);
        
        // Add click effects to badges
        badges.forEach((badge, index) => {
            badge.addEventListener('click', () => {
                // Add click ripple effect
                const ripple = document.createElement('div');
                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(102, 126, 234, 0.3);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    pointer-events: none;
                `;
                
                const rect = badge.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = '50%';
                ripple.style.top = '50%';
                ripple.style.marginLeft = ripple.style.marginTop = -(size / 2) + 'px';
                
                badge.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
                
                // Trigger badge interaction
                triggerBadgeInteraction(badge, index);
            });
            
            // Add keyboard support
            badge.setAttribute('tabindex', '0');
            badge.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    badge.click();
                }
            });
        });
        
        // Add hover effects to logos
        const logos = section.querySelectorAll('.logo-item');
        logos.forEach(logo => {
            logo.addEventListener('mouseenter', () => {
                logo.style.filter = 'brightness(1.2)';
            });
            
            logo.addEventListener('mouseleave', () => {
                logo.style.filter = 'brightness(1)';
            });
        });
    });
    
    function animateNumber(element) {
        const target = element.textContent;
        const isPercentage = target.includes('%');
        const isRating = target.includes('/');
        const hasPlus = target.includes('+');
        
        let finalNumber;
        if (isPercentage) {
            finalNumber = parseFloat(target.replace('%', ''));
        } else if (isRating) {
            finalNumber = parseFloat(target.split('/')[0]);
        } else if (hasPlus) {
            finalNumber = parseFloat(target.replace(/[^\d.]/g, ''));
        } else {
            finalNumber = parseFloat(target.replace(/[^\d.]/g, ''));
        }
        
        if (isNaN(finalNumber)) return;
        
        let current = 0;
        const increment = finalNumber / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= finalNumber) {
                current = finalNumber;
                clearInterval(timer);
            }
            
            let displayValue;
            if (isPercentage) {
                displayValue = current.toFixed(1) + '%';
            } else if (isRating) {
                displayValue = current.toFixed(1) + '/5';
            } else if (hasPlus) {
                if (finalNumber >= 1000000) {
                    displayValue = (current / 1000000).toFixed(1) + 'M+';
                } else if (finalNumber >= 1000) {
                    displayValue = (current / 1000).toFixed(1) + 'k+';
                } else {
                    displayValue = Math.floor(current) + '+';
                }
            } else {
                displayValue = Math.floor(current).toString();
            }
            
            element.textContent = displayValue;
        }, 40);
    }
    
    function triggerBadgeInteraction(badge, index) {
        // Add pulse effect
        badge.style.animation = 'none';
        badge.offsetHeight; // Trigger reflow
        badge.style.animation = 'badgePulse 0.6s ease';
        
        // Log interaction (replace with your analytics)
        console.log(`Trust badge clicked: ${index}`);
        
        // You could trigger a modal, tooltip, or other interaction here
        showBadgeDetails(badge, index);
    }
    
    function showBadgeDetails(badge, index) {
        const title = badge.querySelector('.badge-title')?.textContent || 'Trust Badge';
        const description = badge.querySelector('.badge-description')?.textContent || 'More information';
        
        // Simple alert for demo - replace with modal or tooltip
        if (window.TuskToast) {
            window.TuskToast.info(title, `You clicked on: ${description}`);
        } else {
            console.log(`Badge: ${title} - ${description}`);
        }
    }
});

// Add CSS animation for badge pulse
const style = document.createElement('style');
style.textContent = `
@keyframes badgePulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

@keyframes ripple {
    to {
        transform: scale(4);
        opacity: 0;
    }
}
`;
document.head.appendChild(style);
</script>

<?php
// Helper method to get badge icons
function getBadgeIcon($icon) {
    $icons = [
        'shield' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
        'award' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><path d="M8.21 13.89L7 23l5-3 5 3-1.21-9.12"/></svg>',
        'users' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        'clock' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>',
        'star' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>',
        'check' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>'
    ];
    
    return isset($icons[$icon]) ? $icons[$icon] : $icons['check'];
}

// Make the function accessible to the template
$this = new class {
    public function getBadgeIcon($icon) {
        return getBadgeIcon($icon);
    }
};
?>