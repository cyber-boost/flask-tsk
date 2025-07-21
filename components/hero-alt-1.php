<?php
/**
 * <?tusk> hero-alt-1 Hero Component - Video Background Variant
 * Auto-Inclusion: [tusk-component-hero-alt-1]
 */
?>

<section class="tusk-hero-alt-1" id="hero-alt-1">
    <div class="hero-video-container">
        <video class="hero-video" autoplay muted loop playsinline>
            <source src="/assets/videos/hero-bg.mp4" type="video/mp4">
            <source src="/assets/videos/hero-bg.webm" type="video/webm">
        </video>
        <div class="video-overlay"></div>
    </div>
    
    <div class="hero-content-wrapper">
        <div class="hero-container">
            <div class="hero-badge">
                <span class="badge-icon">🚀</span>
                <span class="badge-text">New Release v3.0</span>
            </div>
            
            <h1 class="hero-title">
                <span class="title-line">Build the Future</span>
                <span class="title-line">with <span class="highlight">TuskPHP</span></span>
            </h1>
            
            <p class="hero-subtitle">
                The most powerful PHP framework for modern web applications. 
                Experience unmatched performance, security, and developer productivity.
            </p>
            
            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-number" data-count="10000">0</div>
                    <div class="stat-label">Developers</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" data-count="500">0</div>
                    <div class="stat-label">Companies</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" data-count="99">0</div>
                    <div class="stat-label">% Uptime</div>
                </div>
            </div>
            
            <div class="hero-actions">
                <a href="#getting-started" class="cta-primary">
                    <span>Get Started Free</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
                <button class="cta-secondary" onclick="playDemoVideo()">
                    <i class="fas fa-play"></i>
                    <span>Watch Demo</span>
                </button>
            </div>
            
            <div class="hero-features">
                <div class="feature-tag">
                    <i class="fas fa-shield-alt"></i>
                    <span>Enterprise Security</span>
                </div>
                <div class="feature-tag">
                    <i class="fas fa-bolt"></i>
                    <span>Lightning Fast</span>
                </div>
                <div class="feature-tag">
                    <i class="fas fa-cogs"></i>
                    <span>Auto-Scaling</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="scroll-indicator">
        <div class="scroll-mouse">
            <div class="scroll-wheel"></div>
        </div>
        <span class="scroll-text">Scroll to explore</span>
    </div>
</section>

<!-- Demo Video Modal -->
<div class="demo-modal" id="demo-modal">
    <div class="modal-overlay" onclick="closeDemoVideo()"></div>
    <div class="modal-content">
        <button class="modal-close" onclick="closeDemoVideo()">
            <i class="fas fa-times"></i>
        </button>
        <div class="video-container">
            <iframe id="demo-iframe" src="" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</div>

<style>
.tusk-hero-alt-1 {
    position: relative;
    height: 100vh;
    min-height: 700px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.hero-video-container {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.hero-video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: brightness(0.7) contrast(1.2);
}

.video-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        135deg,
        rgba(102, 126, 234, 0.8) 0%,
        rgba(118, 75, 162, 0.8) 100%
    );
    z-index: 2;
}

.hero-content-wrapper {
    position: relative;
    z-index: 3;
    width: 100%;
    padding: 0 2rem;
}

.hero-container {
    max-width: 1200px;
    margin: 0 auto;
    text-align: center;
    color: white;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 2rem;
    animation: fadeInUp 1s ease 0.2s both;
}

.badge-icon {
    font-size: 1rem;
}

.hero-title {
    font-size: clamp(3rem, 8vw, 6rem);
    font-weight: 800;
    line-height: 1.1;
    margin: 0 0 2rem 0;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.title-line {
    display: block;
    animation: fadeInUp 1s ease 0.4s both;
}

.title-line:nth-child(2) {
    animation-delay: 0.6s;
}

.highlight {
    background: linear-gradient(45deg, #ffd700, #ffed4e);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    position: relative;
}

.highlight::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(45deg, #ffd700, #ffed4e);
    animation: underlineExpand 1s ease 1.2s both;
}

.hero-subtitle {
    font-size: clamp(1.125rem, 3vw, 1.5rem);
    line-height: 1.6;
    margin: 0 0 3rem 0;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
    opacity: 0.95;
    animation: fadeInUp 1s ease 0.8s both;
}

.hero-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
    margin: 0 0 3rem 0;
    padding: 2rem;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    animation: fadeInUp 1s ease 1s both;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: #ffd700;
    display: block;
    font-family: monospace;
}

.stat-label {
    font-size: 0.875rem;
    opacity: 0.9;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 600;
}

.hero-actions {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
    margin: 0 0 3rem 0;
    animation: fadeInUp 1s ease 1.2s both;
}

.cta-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2rem;
    background: linear-gradient(45deg, #ffd700, #ffed4e);
    color: #2d3748;
    text-decoration: none;
    font-weight: 700;
    font-size: 1.125rem;
    border-radius: 50px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(255, 215, 0, 0.4);
}

.cta-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(255, 215, 0, 0.6);
    text-decoration: none;
    color: #2d3748;
}

.cta-primary i {
    transition: transform 0.3s ease;
}

.cta-primary:hover i {
    transform: translateX(5px);
}

.cta-secondary {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2rem;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    font-weight: 600;
    font-size: 1.125rem;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.cta-secondary:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-3px);
}

.hero-features {
    display: flex;
    justify-content: center;
    gap: 2rem;
    animation: fadeInUp 1s ease 1.4s both;
}

.feature-tag {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 25px;
    font-size: 0.875rem;
    font-weight: 500;
}

.feature-tag i {
    color: #ffd700;
}

.scroll-indicator {
    position: absolute;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    z-index: 3;
    text-align: center;
    animation: fadeInUp 1s ease 1.6s both;
}

.scroll-mouse {
    width: 24px;
    height: 40px;
    border: 2px solid rgba(255, 255, 255, 0.5);
    border-radius: 12px;
    position: relative;
    margin: 0 auto 0.5rem;
}

.scroll-wheel {
    width: 4px;
    height: 8px;
    background: rgba(255, 255, 255, 0.7);
    border-radius: 2px;
    position: absolute;
    top: 6px;
    left: 50%;
    transform: translateX(-50%);
    animation: scrollWheel 2s infinite;
}

.scroll-text {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.7);
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Demo Modal */
.demo-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    display: none;
}

.demo-modal.active {
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.9);
    backdrop-filter: blur(5px);
}

.modal-content {
    position: relative;
    width: 90%;
    max-width: 900px;
    background: #000;
    border-radius: 12px;
    overflow: hidden;
    z-index: 2;
}

.modal-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    border: none;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    font-size: 1.25rem;
    z-index: 3;
    transition: all 0.3s ease;
}

.modal-close:hover {
    background: rgba(255, 255, 255, 0.2);
}

.video-container {
    position: relative;
    width: 100%;
    height: 0;
    padding-bottom: 56.25%;
}

.video-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes underlineExpand {
    from {
        transform: scaleX(0);
    }
    to {
        transform: scaleX(1);
    }
}

@keyframes scrollWheel {
    0% {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
    50% {
        opacity: 0;
        transform: translateX(-50%) translateY(10px);
    }
    100% {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-stats {
        grid-template-columns: 1fr;
        gap: 1rem;
        padding: 1.5rem;
    }
    
    .hero-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .hero-features {
        flex-direction: column;
        gap: 1rem;
    }
    
    .cta-primary,
    .cta-secondary {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .hero-badge {
        padding: 0.5rem 1rem;
        font-size: 0.75rem;
    }
    
    .stat-number {
        font-size: 2rem;
    }
    
    .hero-features {
        display: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animated counters
    const counters = document.querySelectorAll('.stat-number');
    
    function animateCounter(counter) {
        const target = parseInt(counter.getAttribute('data-count'));
        const duration = 2000;
        const increment = target / (duration / 16);
        let current = 0;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            counter.textContent = Math.floor(current);
        }, 16);
    }
    
    // Intersection Observer for counter animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                if (!counter.classList.contains('animated')) {
                    counter.classList.add('animated');
                    animateCounter(counter);
                }
            }
        });
    }, { threshold: 0.5 });
    
    counters.forEach(counter => observer.observe(counter));
    
    // Smooth scroll for CTA
    document.querySelector('.cta-primary').addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth' });
        }
    });
    
    // Parallax effect for video
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const video = document.querySelector('.hero-video');
        if (video) {
            video.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
    });
});

function playDemoVideo() {
    const modal = document.getElementById('demo-modal');
    const iframe = document.getElementById('demo-iframe');
    
    // Replace with actual demo video URL
    iframe.src = 'https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1';
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeDemoVideo() {
    const modal = document.getElementById('demo-modal');
    const iframe = document.getElementById('demo-iframe');
    
    iframe.src = '';
    modal.classList.remove('active');
    document.body.style.overflow = '';
}

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDemoVideo();
    }
});
</script>