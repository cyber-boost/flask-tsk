<?php
/**
 * <?tusk> Enhanced Services Component
 * Created: 2025-06-26
 * Strong. Secure. Scalable. 🐘
 *
 * <?tusk> services Component
 * Auto-Inclusion: [tusk-component-services]
 * Themes: default, dark, minimal, gradient, neon, corporate, warm, cool
 */

$theme = isset($theme) ? $theme : 'default';
$layout = isset($layout) ? $layout : 'grid'; // grid, list, cards
$show_pricing = isset($show_pricing) ? $show_pricing : true;

$services = isset($services) ? $services : [
    [
        'id' => 'web-development',
        'title' => 'Web Development',
        'description' => 'Custom websites and web applications built with modern technologies and best practices.',
        'icon' => 'code',
        'features' => ['Responsive Design', 'SEO Optimized', 'Fast Loading', 'Secure'],
        'price' => 2500,
        'duration' => '2-4 weeks',
        'image' => 'https://via.placeholder.com/400x300/3498db/ffffff?text=Web+Dev'
    ],
    [
        'id' => 'mobile-apps',
        'title' => 'Mobile App Development',
        'description' => 'Native and cross-platform mobile applications for iOS and Android devices.',
        'icon' => 'smartphone',
        'features' => ['Native Performance', 'Cross-Platform', 'App Store Ready', 'Push Notifications'],
        'price' => 5000,
        'duration' => '3-6 weeks',
        'image' => 'https://via.placeholder.com/400x300/e74c3c/ffffff?text=Mobile+Apps'
    ],
    [
        'id' => 'ui-ux-design',
        'title' => 'UI/UX Design',
        'description' => 'User-centered design solutions that create engaging and intuitive experiences.',
        'icon' => 'palette',
        'features' => ['User Research', 'Wireframing', 'Prototyping', 'Design Systems'],
        'price' => 1800,
        'duration' => '1-3 weeks',
        'image' => 'https://via.placeholder.com/400x300/2ecc71/ffffff?text=UI/UX+Design'
    ],
    [
        'id' => 'digital-marketing',
        'title' => 'Digital Marketing',
        'description' => 'Comprehensive digital marketing strategies to grow your online presence.',
        'icon' => 'trending-up',
        'features' => ['SEO/SEM', 'Social Media', 'Content Strategy', 'Analytics'],
        'price' => 1200,
        'duration' => 'Ongoing',
        'image' => 'https://via.placeholder.com/400x300/f39c12/ffffff?text=Digital+Marketing'
    ],
    [
        'id' => 'consulting',
        'title' => 'Technology Consulting',
        'description' => 'Strategic technology guidance to help your business make informed decisions.',
        'icon' => 'users',
        'features' => ['Strategy Planning', 'Technology Audit', 'Implementation', 'Training'],
        'price' => 150,
        'duration' => 'Per hour',
        'image' => 'https://via.placeholder.com/400x300/9b59b6/ffffff?text=Consulting'
    ],
    [
        'id' => 'maintenance',
        'title' => 'Maintenance & Support',
        'description' => '24/7 technical support and maintenance services for your digital assets.',
        'icon' => 'shield',
        'features' => ['24/7 Monitoring', 'Regular Updates', 'Bug Fixes', 'Performance Optimization'],
        'price' => 300,
        'duration' => 'Monthly',
        'image' => 'https://via.placeholder.com/400x300/1abc9c/ffffff?text=Maintenance'
    ]
];
?>

<section class="tusk-services tusk-services--<?php echo $theme; ?> tusk-services--<?php echo $layout; ?>" 
         role="region" 
         aria-label="Our Services">
    <div class="services-container">
        <div class="services-header">
            <h2 class="services-title">Our Services</h2>
            <p class="services-subtitle">Comprehensive solutions to meet all your digital needs</p>
        </div>
        
        <div class="services-grid">
            <?php foreach ($services as $index => $service): ?>
            <div class="service-card" 
                 data-service="<?php echo $service['id']; ?>"
                 data-index="<?php echo $index; ?>">
                
                <div class="service-image">
                    <img src="<?php echo htmlspecialchars($service['image']); ?>" 
                         alt="<?php echo htmlspecialchars($service['title']); ?>"
                         loading="lazy">
                    <div class="service-icon">
                        <?php echo $this->getServiceIcon($service['icon']); ?>
                    </div>
                </div>
                
                <div class="service-content">
                    <h3 class="service-title"><?php echo htmlspecialchars($service['title']); ?></h3>
                    <p class="service-description"><?php echo htmlspecialchars($service['description']); ?></p>
                    
                    <div class="service-features">
                        <?php foreach ($service['features'] as $feature): ?>
                        <span class="feature-tag"><?php echo htmlspecialchars($feature); ?></span>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="service-meta">
                        <div class="meta-item">
                            <span class="meta-label">Duration:</span>
                            <span class="meta-value"><?php echo htmlspecialchars($service['duration']); ?></span>
                        </div>
                        <?php if ($show_pricing): ?>
                        <div class="meta-item">
                            <span class="meta-label">Starting at:</span>
                            <span class="meta-value price">$<?php echo number_format($service['price']); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="service-actions">
                        <button class="btn-primary" data-service="<?php echo $service['id']; ?>">
                            Learn More
                        </button>
                        <button class="btn-secondary" data-service="<?php echo $service['id']; ?>">
                            Get Quote
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="services-cta">
            <h3>Need a Custom Solution?</h3>
            <p>We specialize in creating tailored solutions for unique business requirements</p>
            <button class="cta-button">Contact Us Today</button>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const serviceCards = document.querySelectorAll('.service-card');
    const actionBtns = document.querySelectorAll('.btn-primary, .btn-secondary');
    const ctaBtn = document.querySelector('.services-cta .cta-button');
    
    serviceCards.forEach(card => {
        card.addEventListener('click', () => {
            const serviceId = card.dataset.service;
            console.log('Service card clicked:', serviceId);
        });
    });
    
    actionBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const serviceId = btn.dataset.service;
            const action = btn.textContent.trim();
            console.log(`${action} clicked for service:`, serviceId);
            
            if (window.TuskToast) {
                window.TuskToast.info(action, `${action} for ${serviceId}`);
            }
        });
    });
    
    if (ctaBtn) {
        ctaBtn.addEventListener('click', () => {
            console.log('Services CTA clicked');
            if (window.TuskToast) {
                window.TuskToast.success('Contact', 'Redirecting to contact form...');
            }
        });
    }
});
</script>

<?php
function getServiceIcon($icon) {
    $icons = [
        'code' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16,18 22,12 16,6"/><polyline points="8,6 2,12 8,18"/></svg>',
        'smartphone' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>',
        'palette' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="13.5" cy="6.5" r=".5"/><circle cx="17.5" cy="10.5" r=".5"/><circle cx="8.5" cy="7.5" r=".5"/><circle cx="6.5" cy="12.5" r=".5"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>',
        'trending-up' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23,6 13.5,15.5 8.5,10.5 1,18"/><polyline points="17,6 23,6 23,12"/></svg>',
        'users' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        'shield' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>'
    ];
    return isset($icons[$icon]) ? $icons[$icon] : $icons['code'];
}

$this = new class {
    public function getServiceIcon($icon) {
        return getServiceIcon($icon);
    }
};
?>