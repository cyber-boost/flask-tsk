<?php
/**
 * <?tusk> Enhanced Sub Hero Component
 * Created: 2025-06-26
 * Strong. Secure. Scalable. 🐘
 *
 * <?tusk> sub-hero Component
 * Auto-Inclusion: [tusk-component-sub-hero]
 * Themes: default, dark, minimal, gradient, neon, corporate, warm, cool
 */

$theme = isset($theme) ? $theme : 'default';
$style = isset($style) ? $style : 'centered'; // centered, split, minimal
$show_breadcrumbs = isset($show_breadcrumbs) ? $show_breadcrumbs : true;
$show_cta = isset($show_cta) ? $show_cta : true;
$animated = isset($animated) ? $animated : true;

// Hero content data
$hero_data = isset($hero_data) ? $hero_data : [
    'title' => 'About Our Company',
    'subtitle' => 'Discover Our Story',
    'description' => 'Learn about our mission, values, and the passionate team behind our innovative solutions.',
    'image' => 'https://via.placeholder.com/600x400/3498db/ffffff?text=About+Us',
    'cta_primary' => 'Learn More',
    'cta_secondary' => 'Contact Us',
    'stats' => [
        ['number' => '10+', 'label' => 'Years Experience'],
        ['number' => '500+', 'label' => 'Happy Clients'],
        ['number' => '1000+', 'label' => 'Projects Completed']
    ]
];

$breadcrumbs = isset($breadcrumbs) ? $breadcrumbs : [
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'About', 'url' => '/about'],
    ['title' => 'Our Story', 'url' => null]
];
?>

<section class="tusk-sub-hero tusk-sub-hero--<?php echo $theme; ?> tusk-sub-hero--<?php echo $style; ?>" 
         role="banner">
    <div class="sub-hero-container">
        <?php if ($show_breadcrumbs): ?>
        <nav class="breadcrumbs" aria-label="Breadcrumb">
            <ol class="breadcrumb-list">
                <?php foreach ($breadcrumbs as $index => $crumb): ?>
                <li class="breadcrumb-item">
                    <?php if ($crumb['url']): ?>
                    <a href="<?php echo htmlspecialchars($crumb['url']); ?>" class="breadcrumb-link">
                        <?php echo htmlspecialchars($crumb['title']); ?>
                    </a>
                    <?php else: ?>
                    <span class="breadcrumb-current" aria-current="page">
                        <?php echo htmlspecialchars($crumb['title']); ?>
                    </span>
                    <?php endif; ?>
                    
                    <?php if ($index < count($breadcrumbs) - 1): ?>
                    <svg class="breadcrumb-separator" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9,18 15,12 9,6"/>
                    </svg>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ol>
        </nav>
        <?php endif; ?>
        
        <div class="sub-hero-content<?php echo $animated ? ' animated' : ''; ?>">
            <div class="content-main">
                <div class="content-text">
                    <h1 class="sub-hero-title">
                        <?php echo htmlspecialchars($hero_data['title']); ?>
                    </h1>
                    
                    <div class="sub-hero-subtitle">
                        <?php echo htmlspecialchars($hero_data['subtitle']); ?>
                    </div>
                    
                    <p class="sub-hero-description">
                        <?php echo htmlspecialchars($hero_data['description']); ?>
                    </p>
                    
                    <?php if ($show_cta): ?>
                    <div class="sub-hero-actions">
                        <button class="btn btn-primary">
                            <?php echo htmlspecialchars($hero_data['cta_primary']); ?>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12,5 19,12 12,19"/>
                            </svg>
                        </button>
                        
                        <button class="btn btn-secondary">
                            <?php echo htmlspecialchars($hero_data['cta_secondary']); ?>
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="hero-stats">
                    <?php foreach ($hero_data['stats'] as $stat): ?>
                    <div class="stat-item">
                        <div class="stat-number" data-target="<?php echo htmlspecialchars($stat['number']); ?>">
                            <?php echo htmlspecialchars($stat['number']); ?>
                        </div>
                        <div class="stat-label">
                            <?php echo htmlspecialchars($stat['label']); ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="content-visual">
                <div class="hero-image">
                    <img src="<?php echo htmlspecialchars($hero_data['image']); ?>" 
                         alt="<?php echo htmlspecialchars($hero_data['title']); ?>"
                         loading="lazy">
                    <div class="image-overlay"></div>
                    <div class="image-decoration"></div>
                </div>
            </div>
        </div>
        
        <div class="scroll-indicator">
            <div class="scroll-text">Scroll to explore</div>
            <div class="scroll-arrow">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6,9 12,15 18,9"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="hero-background">
        <div class="bg-shape bg-shape-1"></div>
        <div class="bg-shape bg-shape-2"></div>
        <div class="bg-shape bg-shape-3"></div>
    </div>
</section>

<style>
/* Base Styles */
.tusk-sub-hero {
    position: relative;
    padding: 6rem 0 4rem;
    min-height: 70vh;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.sub-hero-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
    position: relative;
    z-index: 2;
    width: 100%;
}

/* Breadcrumbs */
.breadcrumbs {
    margin-bottom: 2rem;
}

.breadcrumb-list {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    list-style: none;
    padding: 0;
    margin: 0;
    flex-wrap: wrap;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.breadcrumb-link {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.breadcrumb-link:hover {
    color: white;
}

.breadcrumb-current {
    color: white;
    font-size: 0.9rem;
    font-weight: 500;
}

.breadcrumb-separator {
    color: rgba(255, 255, 255, 0.5);
    width: 12px;
    height: 12px;
}

/* Content Layout */
.sub-hero-content {
    display: grid;
    grid-template-columns: 1fr;
    gap: 3rem;
    align-items: center;
}

.tusk-sub-hero--split .sub-hero-content {
    grid-template-columns: 1fr 1fr;
}

.tusk-sub-hero--centered .sub-hero-content {
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
}

.tusk-sub-hero--minimal .sub-hero-content {
    max-width: 600px;
    margin: 0 auto;
}

/* Content Text */
.content-text {
    order: 1;
}

.tusk-sub-hero--split .content-text {
    order: 1;
}

.sub-hero-title {
    font-size: clamp(2.5rem, 6vw, 4rem);
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 1rem;
    color: white;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.sub-hero-subtitle {
    font-size: 1.3rem;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 1.5rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.sub-hero-description {
    font-size: 1.2rem;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 2.5rem;
    max-width: 500px;
}

.tusk-sub-hero--centered .sub-hero-description {
    max-width: none;
}

/* Actions */
.sub-hero-actions {
    display: flex;
    gap: 1rem;
    margin-bottom: 3rem;
    flex-wrap: wrap;
}

.tusk-sub-hero--centered .sub-hero-actions {
    justify-content: center;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 2rem;
    border: none;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-primary {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(10px);
}

.btn-primary:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.btn-secondary {
    background: transparent;
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.5);
}

.btn-secondary:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: white;
    transform: translateY(-2px);
}

/* Stats */
.hero-stats {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.tusk-sub-hero--centered .hero-stats {
    justify-content: center;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: white;
    line-height: 1;
    margin-bottom: 0.5rem;
    display: block;
}

.stat-label {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Visual Content */
.content-visual {
    order: 2;
    position: relative;
}

.tusk-sub-hero--split .content-visual {
    order: 2;
}

.tusk-sub-hero--centered .content-visual,
.tusk-sub-hero--minimal .content-visual {
    display: none;
}

.hero-image {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.hero-image img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.hero-image:hover img {
    transform: scale(1.05);
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(52, 152, 219, 0.2) 0%, rgba(155, 89, 182, 0.2) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.hero-image:hover .image-overlay {
    opacity: 1;
}

.image-decoration {
    position: absolute;
    top: -20px;
    right: -20px;
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #3498db, #e74c3c);
    border-radius: 50%;
    opacity: 0.7;
    filter: blur(20px);
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

/* Scroll Indicator */
.scroll-indicator {
    position: absolute;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    text-align: center;
    color: rgba(255, 255, 255, 0.7);
    animation: bounce 2s infinite;
}

.scroll-text {
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.scroll-arrow {
    opacity: 0.8;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateX(-50%) translateY(0); }
    40% { transform: translateX(-50%) translateY(-5px); }
    60% { transform: translateX(-50%) translateY(-3px); }
}

/* Background */
.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
    overflow: hidden;
}

.bg-shape {
    position: absolute;
    border-radius: 50%;
    opacity: 0.1;
    animation: rotate 20s linear infinite;
}

.bg-shape-1 {
    width: 300px;
    height: 300px;
    top: 10%;
    right: 10%;
    background: linear-gradient(135deg, #3498db, #e74c3c);
    animation-duration: 25s;
}

.bg-shape-2 {
    width: 200px;
    height: 200px;
    bottom: 20%;
    left: 10%;
    background: linear-gradient(135deg, #2ecc71, #f39c12);
    animation-duration: 30s;
    animation-direction: reverse;
}

.bg-shape-3 {
    width: 150px;
    height: 150px;
    top: 50%;
    left: 50%;
    background: linear-gradient(135deg, #9b59b6, #1abc9c);
    animation-duration: 35s;
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Animated Entrance */
.sub-hero-content.animated .content-text {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.8s ease 0.2s forwards;
}

.sub-hero-content.animated .content-visual {
    opacity: 0;
    transform: translateX(30px);
    animation: fadeInRight 0.8s ease 0.4s forwards;
}

.sub-hero-content.animated .hero-stats {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.8s ease 0.6s forwards;
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInRight {
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Theme Variants */
.tusk-sub-hero--default {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.tusk-sub-hero--dark {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    color: white;
}

.tusk-sub-hero--minimal {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    color: #2c3e50;
}

.tusk-sub-hero--minimal .sub-hero-title,
.tusk-sub-hero--minimal .sub-hero-subtitle,
.tusk-sub-hero--minimal .sub-hero-description,
.tusk-sub-hero--minimal .stat-number,
.tusk-sub-hero--minimal .breadcrumb-current {
    color: #2c3e50;
}

.tusk-sub-hero--minimal .breadcrumb-link {
    color: #7f8c8d;
}

.tusk-sub-hero--minimal .btn-primary {
    background: #3498db;
    border-color: #3498db;
}

.tusk-sub-hero--minimal .btn-secondary {
    color: #3498db;
    border-color: #3498db;
}

.tusk-sub-hero--gradient {
    background: linear-gradient(135deg, #ff9a56 0%, #ff6b6b 50%, #4ecdc4 100%);
    color: white;
}

.tusk-sub-hero--neon {
    background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 100%);
    color: #00ff88;
}

.tusk-sub-hero--neon .sub-hero-title {
    color: #00ff88;
    text-shadow: 0 0 20px rgba(0, 255, 136, 0.5);
}

.tusk-sub-hero--corporate {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: white;
}

.tusk-sub-hero--warm {
    background: linear-gradient(135deg, #ff9a56 0%, #ffad56 100%);
    color: white;
}

.tusk-sub-hero--cool {
    background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
    color: white;
}

/* Responsive Design */
@media (max-width: 968px) {
    .tusk-sub-hero {
        padding: 4rem 0 3rem;
    }
    
    .sub-hero-container {
        padding: 0 1.5rem;
    }
    
    .tusk-sub-hero--split .sub-hero-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .content-visual {
        order: 1;
    }
    
    .content-text {
        order: 2;
    }
    
    .hero-stats {
        gap: 1.5rem;
    }
}

@media (max-width: 768px) {
    .tusk-sub-hero {
        min-height: 60vh;
        padding: 3rem 0 2rem;
    }
    
    .sub-hero-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .btn {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
    
    .hero-stats {
        justify-content: center;
    }
    
    .hero-image img {
        height: 300px;
    }
}

@media (max-width: 480px) {
    .sub-hero-container {
        padding: 0 1rem;
    }
    
    .breadcrumb-list {
        gap: 0.25rem;
    }
    
    .breadcrumb-link,
    .breadcrumb-current {
        font-size: 0.8rem;
    }
    
    .hero-stats {
        gap: 1rem;
    }
    
    .stat-number {
        font-size: 2rem;
    }
    
    .scroll-indicator {
        display: none;
    }
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
    .hero-image img,
    .bg-shape,
    .scroll-indicator,
    .image-decoration {
        animation: none;
        transition: none;
    }
    
    .sub-hero-content.animated .content-text,
    .sub-hero-content.animated .content-visual,
    .sub-hero-content.animated .hero-stats {
        animation: none;
        opacity: 1;
        transform: none;
    }
}

/* High contrast mode */
@media (prefers-contrast: high) {
    .btn {
        border: 2px solid black;
    }
    
    .hero-image {
        border: 2px solid black;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const subHeros = document.querySelectorAll('.tusk-sub-hero');
    
    subHeros.forEach(hero => {
        const statNumbers = hero.querySelectorAll('.stat-number');
        const buttons = hero.querySelectorAll('.btn');
        
        // Animate stats on scroll
        const observerOptions = {
            threshold: 0.3,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Animate stat numbers
                    statNumbers.forEach(stat => {
                        animateStatNumber(stat);
                    });
                }
            });
        }, observerOptions);
        
        observer.observe(hero);
        
        // Button click handlers
        buttons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                handleButtonClick(btn, e);
            });
        });
        
        // Scroll indicator click
        const scrollIndicator = hero.querySelector('.scroll-indicator');
        if (scrollIndicator) {
            scrollIndicator.addEventListener('click', () => {
                const nextSection = hero.nextElementSibling;
                if (nextSection) {
                    nextSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        }
    });
    
    function animateStatNumber(element) {
        const target = element.dataset.target;
        const hasPlus = target.includes('+');
        const targetValue = parseInt(target.replace(/[^\d]/g, ''));
        
        if (isNaN(targetValue)) return;
        
        let currentValue = 0;
        const increment = targetValue / 60;
        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= targetValue) {
                currentValue = targetValue;
                clearInterval(timer);
            }
            
            let displayValue = Math.floor(currentValue);
            if (hasPlus) displayValue += '+';
            
            element.textContent = displayValue;
        }, 33);
    }
    
    function handleButtonClick(btn, e) {
        const text = btn.textContent.trim();
        
        // Add click effect
        btn.style.transform = 'scale(0.95)';
        setTimeout(() => {
            btn.style.transform = '';
        }, 150);
        
        // Log interaction
        console.log(`Sub hero button clicked: ${text}`);
        
        // Show feedback
        if (window.TuskToast) {
            if (text.includes('Learn More')) {
                window.TuskToast.info('Learn More', 'Exploring more information...');
            } else if (text.includes('Contact')) {
                window.TuskToast.success('Contact', 'Opening contact form...');
            } else {
                window.TuskToast.info('Action', `You clicked: ${text}`);
            }
        }
        
        // Send analytics
        if (typeof gtag !== 'undefined') {
            gtag('event', 'sub_hero_cta_click', {
                'button_text': text,
                'button_type': btn.classList.contains('btn-primary') ? 'primary' : 'secondary'
            });
        }
    }
});
</script>