<?php
/**
 * features.php
 * Enhanced features showcase with animations and interactions
 */
?>

<section class="tusk-hero-features" id="features">
    <div class="hero-container">
        <h2>✨ Powerful Features</h2>
        <p>Discover what makes TuskPHP the perfect choice for your next project</p>
        
        <div class="features-grid">
            <div class="feature-card" data-tilt>
                <div class="feature-icon">🚀</div>
                <h3>Lightning Fast</h3>
                <p>Optimized performance with advanced caching and minimal overhead</p>
                <div class="feature-stats">
                    <span class="stat-number" data-target="99">0</span>
                    <span class="stat-label">% Uptime</span>
                </div>
            </div>
            
            <div class="feature-card" data-tilt>
                <div class="feature-icon">🔒</div>
                <h3>Ultra Secure</h3>
                <p>Built-in security features protect your applications from common threats</p>
                <div class="feature-stats">
                    <span class="stat-number" data-target="256">0</span>
                    <span class="stat-label">-bit Encryption</span>
                </div>
            </div>
            
            <div class="feature-card" data-tilt>
                <div class="feature-icon">📈</div>
                <h3>Highly Scalable</h3>
                <p>Effortlessly handle growth from startup to enterprise level</p>
                <div class="feature-stats">
                    <span class="stat-number" data-target="1000">0</span>
                    <span class="stat-label">+ Users Supported</span>
                </div>
            </div>
            
            <div class="feature-card" data-tilt>
                <div class="feature-icon">⚡</div>
                <h3>Developer Friendly</h3>
                <p>Intuitive API and comprehensive documentation for rapid development</p>
                <div class="feature-stats">
                    <span class="stat-number" data-target="24">0</span>
                    <span class="stat-label">/7 Support</span>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Animated counters
function animateCounters() {
    const counters = document.querySelectorAll('.stat-number');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const increment = target / 100;
        let current = 0;
        
        const updateCounter = () => {
            if (current < target) {
                current += increment;
                counter.textContent = Math.ceil(current);
                setTimeout(updateCounter, 20);
            } else {
                counter.textContent = target;
            }
        };
        
        updateCounter();
    });
}

// Trigger animations when section comes into view
const featuresSection = document.getElementById('features');
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            animateCounters();
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });

observer.observe(featuresSection);

// 3D tilt effect
document.querySelectorAll('[data-tilt]').forEach(card => {
    card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        
        const rotateX = (y - centerY) / centerY * -10;
        const rotateY = (x - centerX) / centerX * 10;
        
        card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.05)`;
    });
    
    card.addEventListener('mouseleave', () => {
        card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)';
    });
});
</script>