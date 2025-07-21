<?php
/**
 * <?tusk> Enhanced Tabs Component
 * Created: 2025-06-26
 * Strong. Secure. Scalable. 🐘
 *
 * <?tusk> tabs Component
 * Auto-Inclusion: [tusk-component-tabs]
 * Themes: default, dark, minimal, gradient, neon, corporate, warm, cool
 */

// Theme and configuration
$theme = isset($theme) ? $theme : 'default';
$orientation = isset($orientation) ? $orientation : 'horizontal'; // horizontal, vertical
$style = isset($style) ? $style : 'modern'; // modern, classic, pills, underline
$animated = isset($animated) ? $animated : true;
$lazy_load = isset($lazy_load) ? $lazy_load : true;

// Tabs data
$tabs_data = isset($tabs_data) ? $tabs_data : [
    [
        'id' => 'overview',
        'title' => 'Overview',
        'icon' => 'home',
        'badge' => null,
        'content' => [
            'title' => 'Product Overview',
            'description' => 'Get a comprehensive view of our platform and its capabilities.',
            'items' => [
                'Intuitive dashboard with real-time analytics',
                'Seamless integration with existing tools',
                'Advanced security and compliance features',
                'Scalable architecture for growing teams'
            ],
            'image' => 'https://via.placeholder.com/600x300/3498db/ffffff?text=Overview',
            'cta' => 'Learn More'
        ]
    ],
    [
        'id' => 'features',
        'title' => 'Features',
        'icon' => 'star',
        'badge' => 'New',
        'content' => [
            'title' => 'Powerful Features',
            'description' => 'Discover the features that make our platform stand out.',
            'items' => [
                'AI-powered automation and workflows',
                'Real-time collaboration tools',
                'Advanced reporting and analytics',
                'Custom integrations and API access',
                'Mobile-first responsive design',
                '24/7 customer support'
            ],
            'image' => 'https://via.placeholder.com/600x300/e74c3c/ffffff?text=Features',
            'cta' => 'Explore Features'
        ]
    ],
    [
        'id' => 'pricing',
        'title' => 'Pricing',
        'icon' => 'dollar-sign',
        'badge' => null,
        'content' => [
            'title' => 'Flexible Pricing Plans',
            'description' => 'Choose the plan that fits your needs and budget.',
            'plans' => [
                ['name' => 'Starter', 'price' => '$9', 'period' => 'month', 'features' => ['5 Projects', '10GB Storage', 'Email Support']],
                ['name' => 'Professional', 'price' => '$29', 'period' => 'month', 'features' => ['Unlimited Projects', '100GB Storage', 'Priority Support', 'Advanced Analytics']],
                ['name' => 'Enterprise', 'price' => '$99', 'period' => 'month', 'features' => ['Everything in Pro', 'Custom Integrations', 'Dedicated Account Manager', 'SLA Guarantee']]
            ],
            'image' => 'https://via.placeholder.com/600x300/2ecc71/ffffff?text=Pricing',
            'cta' => 'Choose Plan'
        ]
    ],
    [
        'id' => 'testimonials',
        'title' => 'Reviews',
        'icon' => 'message-circle',
        'badge' => '4.9',
        'content' => [
            'title' => 'What Our Customers Say',
            'description' => 'Real feedback from real customers who love our platform.',
            'testimonials' => [
                ['name' => 'Sarah Johnson', 'company' => 'TechCorp', 'text' => 'This platform has revolutionized our workflow. Highly recommended!', 'rating' => 5],
                ['name' => 'Michael Chen', 'company' => 'StartupXYZ', 'text' => 'Incredible features and excellent support. Worth every penny.', 'rating' => 5],
                ['name' => 'Emily Davis', 'company' => 'DesignStudio', 'text' => 'The user interface is beautiful and intuitive. Love it!', 'rating' => 5]
            ],
            'image' => 'https://via.placeholder.com/600x300/f39c12/ffffff?text=Reviews',
            'cta' => 'Read More Reviews'
        ]
    ],
    [
        'id' => 'support',
        'title' => 'Support',
        'icon' => 'help-circle',
        'badge' => null,
        'content' => [
            'title' => 'Get Help When You Need It',
            'description' => 'Multiple ways to get support and learn about our platform.',
            'support_options' => [
                ['type' => 'Knowledge Base', 'description' => 'Comprehensive guides and tutorials', 'icon' => 'book'],
                ['type' => 'Live Chat', 'description' => 'Instant help from our support team', 'icon' => 'message-square'],
                ['type' => 'Email Support', 'description' => 'Detailed assistance via email', 'icon' => 'mail'],
                ['type' => 'Video Tutorials', 'description' => 'Step-by-step video guides', 'icon' => 'play']
            ],
            'image' => 'https://via.placeholder.com/600x300/9b59b6/ffffff?text=Support',
            'cta' => 'Contact Support'
        ]
    ]
];
?>

<section class="tusk-tabs tusk-tabs--<?php echo $theme; ?> tusk-tabs--<?php echo $orientation; ?> tusk-tabs--<?php echo $style; ?>" 
         role="region" 
         aria-label="Tabbed Content">
    <div class="tabs-container">
        <div class="tabs-header">
            <h2 class="tabs-title">Explore Our Platform</h2>
            <p class="tabs-subtitle">Navigate through different aspects of our solution</p>
        </div>
        
        <div class="tabs-wrapper">
            <!-- Tab Navigation -->
            <div class="tab-nav" role="tablist" aria-label="Platform sections">
                <div class="tab-nav-inner">
                    <?php foreach ($tabs_data as $index => $tab): ?>
                    <button class="tab-button <?php echo $index === 0 ? 'active' : ''; ?>" 
                            role="tab"
                            aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                            aria-controls="tab-panel-<?php echo $tab['id']; ?>"
                            id="tab-<?php echo $tab['id']; ?>"
                            data-tab="<?php echo $tab['id']; ?>">
                        <div class="tab-icon">
                            <?php echo $this->getTabIcon($tab['icon']); ?>
                        </div>
                        <span class="tab-title"><?php echo htmlspecialchars($tab['title']); ?></span>
                        <?php if ($tab['badge']): ?>
                        <span class="tab-badge"><?php echo htmlspecialchars($tab['badge']); ?></span>
                        <?php endif; ?>
                        <div class="tab-indicator"></div>
                    </button>
                    <?php endforeach; ?>
                </div>
                <div class="tab-nav-highlight"></div>
            </div>
            
            <!-- Tab Content -->
            <div class="tab-content">
                <?php foreach ($tabs_data as $index => $tab): ?>
                <div class="tab-panel <?php echo $index === 0 ? 'active' : ''; ?><?php echo $animated ? ' animated' : ''; ?>" 
                     role="tabpanel"
                     aria-labelledby="tab-<?php echo $tab['id']; ?>"
                     id="tab-panel-<?php echo $tab['id']; ?>"
                     data-panel="<?php echo $tab['id']; ?>"
                     <?php echo $lazy_load && $index > 0 ? 'data-lazy="true"' : ''; ?>>
                    
                    <div class="panel-content">
                        <div class="content-main">
                            <h3 class="content-title"><?php echo htmlspecialchars($tab['content']['title']); ?></h3>
                            <p class="content-description"><?php echo htmlspecialchars($tab['content']['description']); ?></p>
                            
                            <!-- Overview Tab Content -->
                            <?php if ($tab['id'] === 'overview' && isset($tab['content']['items'])): ?>
                            <ul class="feature-list">
                                <?php foreach ($tab['content']['items'] as $item): ?>
                                <li class="feature-item">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="20,6 9,17 4,12"/>
                                    </svg>
                                    <?php echo htmlspecialchars($item); ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                            
                            <!-- Features Tab Content -->
                            <?php if ($tab['id'] === 'features' && isset($tab['content']['items'])): ?>
                            <div class="features-grid">
                                <?php foreach ($tab['content']['items'] as $feature): ?>
                                <div class="feature-card">
                                    <div class="feature-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20,6 9,17 4,12"/>
                                        </svg>
                                    </div>
                                    <span><?php echo htmlspecialchars($feature); ?></span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Pricing Tab Content -->
                            <?php if ($tab['id'] === 'pricing' && isset($tab['content']['plans'])): ?>
                            <div class="pricing-cards">
                                <?php foreach ($tab['content']['plans'] as $plan): ?>
                                <div class="pricing-card">
                                    <h4 class="plan-name"><?php echo htmlspecialchars($plan['name']); ?></h4>
                                    <div class="plan-price">
                                        <span class="price"><?php echo htmlspecialchars($plan['price']); ?></span>
                                        <span class="period">/<?php echo htmlspecialchars($plan['period']); ?></span>
                                    </div>
                                    <ul class="plan-features">
                                        <?php foreach ($plan['features'] as $feature): ?>
                                        <li><?php echo htmlspecialchars($feature); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Testimonials Tab Content -->
                            <?php if ($tab['id'] === 'testimonials' && isset($tab['content']['testimonials'])): ?>
                            <div class="testimonials-list">
                                <?php foreach ($tab['content']['testimonials'] as $testimonial): ?>
                                <div class="testimonial-item">
                                    <div class="testimonial-text">"<?php echo htmlspecialchars($testimonial['text']); ?>"</div>
                                    <div class="testimonial-author">
                                        <strong><?php echo htmlspecialchars($testimonial['name']); ?></strong>
                                        <span><?php echo htmlspecialchars($testimonial['company']); ?></span>
                                    </div>
                                    <div class="testimonial-rating">
                                        <?php for($i = 0; $i < $testimonial['rating']; $i++): ?>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                            <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                                        </svg>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Support Tab Content -->
                            <?php if ($tab['id'] === 'support' && isset($tab['content']['support_options'])): ?>
                            <div class="support-options">
                                <?php foreach ($tab['content']['support_options'] as $option): ?>
                                <div class="support-option">
                                    <div class="support-icon">
                                        <?php echo $this->getTabIcon($option['icon']); ?>
                                    </div>
                                    <div class="support-info">
                                        <h5><?php echo htmlspecialchars($option['type']); ?></h5>
                                        <p><?php echo htmlspecialchars($option['description']); ?></p>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                            
                            <button class="content-cta"><?php echo htmlspecialchars($tab['content']['cta']); ?></button>
                        </div>
                        
                        <div class="content-visual">
                            <img src="<?php echo htmlspecialchars($tab['content']['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($tab['content']['title']); ?>"
                                 loading="lazy"
                                 class="content-image">
                            <div class="image-overlay"></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<style>
/* Base Styles */
.tusk-tabs {
    padding: 5rem 0;
    position: relative;
    overflow: hidden;
}

.tabs-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

.tabs-header {
    text-align: center;
    margin-bottom: 4rem;
}

.tabs-title {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 800;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.tabs-subtitle {
    font-size: 1.2rem;
    opacity: 0.8;
    line-height: 1.6;
}

.tabs-wrapper {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 24px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
}

/* Tab Navigation */
.tab-nav {
    position: relative;
    background: rgba(255, 255, 255, 0.5);
    backdrop-filter: blur(10px);
}

.tab-nav-inner {
    display: flex;
    overflow-x: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.tab-nav-inner::-webkit-scrollbar {
    display: none;
}

.tab-button {
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1.5rem 2rem;
    border: none;
    background: transparent;
    color: #7f8c8d;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
    flex-shrink: 0;
    z-index: 2;
}

.tab-button:hover {
    color: #3498db;
    background: rgba(52, 152, 219, 0.05);
}

.tab-button.active {
    color: #2c3e50;
    background: transparent;
}

.tab-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    transition: transform 0.3s ease;
}

.tab-button:hover .tab-icon,
.tab-button.active .tab-icon {
    transform: scale(1.1);
}

.tab-title {
    font-size: 1rem;
}

.tab-badge {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    padding: 0.25rem 0.6rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    animation: badgePulse 2s infinite;
}

@keyframes badgePulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.tab-indicator {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #3498db, #e74c3c);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.tab-button.active .tab-indicator {
    transform: scaleX(1);
}

.tab-nav-highlight {
    position: absolute;
    bottom: 0;
    height: 3px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 2px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1;
}

/* Tab Content */
.tab-content {
    position: relative;
    min-height: 500px;
}

.tab-panel {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    opacity: 0;
    visibility: hidden;
    transform: translateY(20px);
    transition: all 0.4s ease;
    padding: 3rem;
}

.tab-panel.active {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
    position: relative;
}

.tab-panel.animated {
    animation: slideInUp 0.6s ease forwards;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.panel-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    align-items: center;
}

.content-main {
    order: 1;
}

.content-visual {
    order: 2;
    position: relative;
}

.content-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.content-description {
    font-size: 1.1rem;
    color: #7f8c8d;
    line-height: 1.6;
    margin-bottom: 2rem;
}

.content-image {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-radius: 16px;
    box-shadow: 0 16px 40px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.content-image:hover {
    transform: scale(1.02);
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-radius: 16px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.content-visual:hover .image-overlay {
    opacity: 1;
}

/* Feature List */
.feature-list {
    list-style: none;
    padding: 0;
    margin: 0 0 2rem 0;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 0;
    color: #5a6c7d;
    font-size: 1rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.feature-item:last-child {
    border-bottom: none;
}

.feature-item svg {
    color: #2ecc71;
    flex-shrink: 0;
}

/* Features Grid */
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.feature-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: rgba(52, 152, 219, 0.05);
    border-radius: 12px;
    border: 1px solid rgba(52, 152, 219, 0.1);
    transition: all 0.3s ease;
}

.feature-card:hover {
    background: rgba(52, 152, 219, 0.1);
    transform: translateY(-2px);
}

.feature-icon {
    width: 40px;
    height: 40px;
    background: #3498db;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}

/* Pricing Cards */
.pricing-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.pricing-card {
    padding: 1.5rem;
    background: white;
    border-radius: 16px;
    border: 2px solid #e9ecef;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.pricing-card:hover {
    border-color: #3498db;
    transform: translateY(-5px);
    box-shadow: 0 16px 40px rgba(52, 152, 219, 0.15);
}

.pricing-card:nth-child(2) {
    border-color: #3498db;
    transform: scale(1.05);
}

.pricing-card:nth-child(2)::before {
    content: 'Most Popular';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    background: #3498db;
    color: white;
    padding: 0.5rem;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.plan-name {
    font-size: 1.2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.plan-price {
    margin-bottom: 1.5rem;
}

.price {
    font-size: 2.5rem;
    font-weight: 800;
    color: #3498db;
}

.period {
    font-size: 1rem;
    color: #7f8c8d;
}

.plan-features {
    list-style: none;
    padding: 0;
    margin: 0;
}

.plan-features li {
    padding: 0.5rem 0;
    color: #5a6c7d;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.plan-features li:last-child {
    border-bottom: none;
}

/* Testimonials */
.testimonials-list {
    display: grid;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.testimonial-item {
    padding: 1.5rem;
    background: rgba(52, 152, 219, 0.05);
    border-radius: 12px;
    border-left: 4px solid #3498db;
}

.testimonial-text {
    font-style: italic;
    color: #5a6c7d;
    margin-bottom: 1rem;
    font-size: 1.1rem;
    line-height: 1.6;
}

.testimonial-author {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.testimonial-author strong {
    color: #2c3e50;
}

.testimonial-author span {
    color: #7f8c8d;
    font-size: 0.9rem;
}

.testimonial-rating {
    display: flex;
    gap: 2px;
    color: #f39c12;
}

/* Support Options */
.support-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.support-option {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    background: white;
    border-radius: 12px;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.support-option:hover {
    border-color: #3498db;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(52, 152, 219, 0.1);
}

.support-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}

.support-info h5 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0 0 0.5rem 0;
}

.support-info p {
    color: #7f8c8d;
    margin: 0;
    font-size: 0.9rem;
    line-height: 1.4;
}

/* CTA Button */
.content-cta {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 1rem 2.5rem;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.content-cta:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
}

/* Vertical Orientation */
.tusk-tabs--vertical .tabs-wrapper {
    display: grid;
    grid-template-columns: 300px 1fr;
}

.tusk-tabs--vertical .tab-nav {
    background: rgba(255, 255, 255, 0.8);
}

.tusk-tabs--vertical .tab-nav-inner {
    flex-direction: column;
    overflow-y: auto;
    overflow-x: visible;
}

.tusk-tabs--vertical .tab-button {
    justify-content: flex-start;
    text-align: left;
    border-radius: 0;
}

.tusk-tabs--vertical .tab-indicator {
    width: 3px;
    height: 100%;
    right: 0;
    left: auto;
    top: 0;
    bottom: auto;
}

.tusk-tabs--vertical .tab-nav-highlight {
    width: 3px;
    height: auto;
    right: 0;
    left: auto;
}

/* Style Variants */
.tusk-tabs--pills .tab-button {
    margin: 0.25rem;
    border-radius: 25px;
    background: rgba(255, 255, 255, 0.8);
}

.tusk-tabs--pills .tab-button.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.tusk-tabs--underline .tab-nav {
    background: transparent;
    border-bottom: 2px solid rgba(0, 0, 0, 0.1);
}

.tusk-tabs--underline .tab-button {
    border-radius: 0;
    background: transparent;
}

.tusk-tabs--classic .tabs-wrapper {
    border-radius: 8px;
    border: 2px solid #e9ecef;
}

.tusk-tabs--classic .tab-nav {
    background: #f8f9fa;
    border-bottom: 2px solid #e9ecef;
}

.tusk-tabs--classic .tab-button {
    border-radius: 0;
    border-right: 1px solid #e9ecef;
}

.tusk-tabs--classic .tab-button:last-child {
    border-right: none;
}

/* Theme Variants */
.tusk-tabs--default {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    color: #2c3e50;
}

.tusk-tabs--dark {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    color: white;
}

.tusk-tabs--dark .tabs-wrapper {
    background: rgba(45, 45, 45, 0.95);
    border-color: rgba(255, 255, 255, 0.1);
}

.tusk-tabs--dark .tab-nav {
    background: rgba(30, 30, 30, 0.8);
}

.tusk-tabs--dark .content-title {
    color: white;
}

.tusk-tabs--dark .tabs-title {
    background: linear-gradient(135deg, #00ff88 0%, #00d4ff 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.tusk-tabs--minimal {
    background: #ffffff;
    color: #333333;
}

.tusk-tabs--minimal .tabs-wrapper {
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
}

.tusk-tabs--gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.tusk-tabs--gradient .tabs-wrapper {
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.2);
}

.tusk-tabs--gradient .content-title {
    color: white;
}

.tusk-tabs--neon {
    background: #0a0a0a;
    color: #00ff88;
}

.tusk-tabs--neon .tabs-wrapper {
    background: rgba(0, 20, 40, 0.9);
    border: 1px solid #00ff88;
    box-shadow: 0 0 30px rgba(0, 255, 136, 0.2);
}

.tusk-tabs--neon .tab-nav {
    background: rgba(0, 10, 20, 0.8);
}

.tusk-tabs--corporate {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: white;
}

.tusk-tabs--corporate .tabs-wrapper {
    background: rgba(255, 255, 255, 0.1);
}

.tusk-tabs--corporate .content-title {
    color: white;
}

.tusk-tabs--warm {
    background: linear-gradient(135deg, #ff9a56 0%, #ffad56 100%);
    color: #2c3e50;
}

.tusk-tabs--cool {
    background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
    color: white;
}

.tusk-tabs--cool .tabs-wrapper {
    background: rgba(255, 255, 255, 0.15);
}

.tusk-tabs--cool .content-title {
    color: white;
}

/* Responsive Design */
@media (max-width: 968px) {
    .tabs-container {
        padding: 0 1.5rem;
    }
    
    .panel-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .content-visual {
        order: 1;
    }
    
    .content-main {
        order: 2;
    }
    
    .tusk-tabs--vertical .tabs-wrapper {
        grid-template-columns: 1fr;
    }
    
    .tusk-tabs--vertical .tab-nav-inner {
        flex-direction: row;
        overflow-x: auto;
    }
}

@media (max-width: 768px) {
    .tusk-tabs {
        padding: 3rem 0;
    }
    
    .tabs-header {
        margin-bottom: 2.5rem;
    }
    
    .tab-button {
        padding: 1rem 1.5rem;
        font-size: 0.9rem;
    }
    
    .tab-panel {
        padding: 2rem;
    }
    
    .content-title {
        font-size: 1.8rem;
    }
    
    .features-grid,
    .pricing-cards,
    .support-options {
        grid-template-columns: 1fr;
    }
    
    .content-image {
        height: 200px;
    }
}

@media (max-width: 480px) {
    .tabs-container {
        padding: 0 1rem;
    }
    
    .tab-button {
        padding: 0.75rem 1rem;
        gap: 0.5rem;
    }
    
    .tab-title {
        font-size: 0.9rem;
    }
    
    .tab-panel {
        padding: 1.5rem;
    }
    
    .content-title {
        font-size: 1.5rem;
    }
    
    .pricing-card:nth-child(2) {
        transform: none;
    }
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
    .tab-button,
    .tab-panel,
    .content-image,
    .content-cta,
    .tab-badge {
        animation: none;
        transition: none;
    }
    
    .tab-panel.animated {
        animation: none;
    }
}

/* High contrast mode */
@media (prefers-contrast: high) {
    .tabs-wrapper {
        border: 2px solid black;
    }
    
    .tab-button {
        border: 1px solid black;
    }
    
    .content-cta {
        border: 2px solid black;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabsSections = document.querySelectorAll('.tusk-tabs');
    
    tabsSections.forEach(section => {
        const tabButtons = section.querySelectorAll('.tab-button');
        const tabPanels = section.querySelectorAll('.tab-panel');
        const navHighlight = section.querySelector('.tab-nav-highlight');
        const ctaButtons = section.querySelectorAll('.content-cta');
        
        // Initialize tabs
        initializeTabs(tabButtons, tabPanels, navHighlight, section);
        
        // Handle CTA button clicks
        ctaButtons.forEach(button => {
            button.addEventListener('click', () => {
                handleCTAClick(button);
            });
        });
        
        // Lazy load content
        if (section.dataset.lazyLoad !== 'false') {
            initializeLazyLoading(tabPanels);
        }
        
        // Auto-cycle tabs (optional)
        if (section.dataset.autoCycle === 'true') {
            initializeAutoCycle(tabButtons, tabPanels, navHighlight, section);
        }
        
        // Keyboard navigation
        initializeKeyboardNavigation(tabButtons, tabPanels, navHighlight, section);
    });
    
    function initializeTabs(tabButtons, tabPanels, navHighlight, section) {
        tabButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                activateTab(index, tabButtons, tabPanels, navHighlight, section);
            });
        });
        
        // Set initial highlight position
        updateNavHighlight(0, tabButtons, navHighlight, section);
    }
    
    function activateTab(index, tabButtons, tabPanels, navHighlight, section) {
        // Update buttons
        tabButtons.forEach((btn, i) => {
            btn.classList.toggle('active', i === index);
            btn.setAttribute('aria-selected', i === index ? 'true' : 'false');
        });
        
        // Update panels
        tabPanels.forEach((panel, i) => {
            panel.classList.toggle('active', i === index);
            
            if (i === index) {
                // Trigger animations
                if (panel.classList.contains('animated')) {
                    panel.style.animation = 'none';
                    panel.offsetHeight; // Trigger reflow
                    panel.style.animation = 'slideInUp 0.6s ease forwards';
                }
                
                // Load lazy content
                loadTabContent(panel);
            }
        });
        
        // Update highlight
        updateNavHighlight(index, tabButtons, navHighlight, section);
        
        // Log interaction
        const tabId = tabButtons[index].dataset.tab;
        console.log(`Tab activated: ${tabId}`);
        
        // Trigger custom event
        section.dispatchEvent(new CustomEvent('tabChange', {
            detail: { tabId, tabIndex: index }
        }));
    }
    
    function updateNavHighlight(index, tabButtons, navHighlight, section) {
        if (!navHighlight || !tabButtons[index]) return;
        
        const activeButton = tabButtons[index];
        const isVertical = section.classList.contains('tusk-tabs--vertical');
        
        if (isVertical) {
            navHighlight.style.top = activeButton.offsetTop + 'px';
            navHighlight.style.height = activeButton.offsetHeight + 'px';
            navHighlight.style.width = '3px';
            navHighlight.style.left = 'auto';
            navHighlight.style.right = '0';
        } else {
            navHighlight.style.left = activeButton.offsetLeft + 'px';
            navHighlight.style.width = activeButton.offsetWidth + 'px';
            navHighlight.style.height = '3px';
            navHighlight.style.top = 'auto';
            navHighlight.style.bottom = '0';
        }
    }
    
    function initializeKeyboardNavigation(tabButtons, tabPanels, navHighlight, section) {
        tabButtons.forEach((button, index) => {
            button.addEventListener('keydown', (e) => {
                let newIndex = index;
                
                switch (e.key) {
                    case 'ArrowLeft':
                    case 'ArrowUp':
                        e.preventDefault();
                        newIndex = index > 0 ? index - 1 : tabButtons.length - 1;
                        break;
                    case 'ArrowRight':
                    case 'ArrowDown':
                        e.preventDefault();
                        newIndex = index < tabButtons.length - 1 ? index + 1 : 0;
                        break;
                    case 'Home':
                        e.preventDefault();
                        newIndex = 0;
                        break;
                    case 'End':
                        e.preventDefault();
                        newIndex = tabButtons.length - 1;
                        break;
                    default:
                        return;
                }
                
                tabButtons[newIndex].focus();
                activateTab(newIndex, tabButtons, tabPanels, navHighlight, section);
            });
        });
    }
    
    function initializeLazyLoading(tabPanels) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    loadTabContent(entry.target);
                }
            });
        }, { threshold: 0.1 });
        
        tabPanels.forEach(panel => {
            if (panel.dataset.lazy === 'true') {
                observer.observe(panel);
            }
        });
    }
    
    function loadTabContent(panel) {
        if (panel.dataset.loaded === 'true') return;
        
        // Simulate content loading
        const images = panel.querySelectorAll('img[data-src]');
        images.forEach(img => {
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
        });
        
        // Mark as loaded
        panel.dataset.loaded = 'true';
        
        // Add loaded animation
        const elements = panel.querySelectorAll('.feature-item, .feature-card, .pricing-card, .testimonial-item, .support-option');
        elements.forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'all 0.6s ease';
            
            setTimeout(() => {
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }
    
    function initializeAutoCycle(tabButtons, tabPanels, navHighlight, section) {
        let currentIndex = 0;
        let isHovered = false;
        
        section.addEventListener('mouseenter', () => isHovered = true);
        section.addEventListener('mouseleave', () => isHovered = false);
        
        setInterval(() => {
            if (!isHovered && !document.hidden) {
                currentIndex = (currentIndex + 1) % tabButtons.length;
                activateTab(currentIndex, tabButtons, tabPanels, navHighlight, section);
            }
        }, 5000);
    }
    
    function handleCTAClick(button) {
        const text = button.textContent.trim();
        
        // Add ripple effect
        const ripple = document.createElement('div');
        ripple.style.cssText = `
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        `;
        
        const rect = button.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = '50%';
        ripple.style.top = '50%';
        ripple.style.marginLeft = ripple.style.marginTop = -(size / 2) + 'px';
        
        button.style.position = 'relative';
        button.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
        
        // Log interaction
        console.log(`CTA clicked: ${text}`);
        
        // Show feedback
        if (window.TuskToast) {
            switch (text) {
                case 'Learn More':
                    window.TuskToast.info('Learn More', 'Redirecting to detailed documentation...');
                    break;
                case 'Explore Features':
                    window.TuskToast.success('Features', 'Discover all our amazing features!');
                    break;
                case 'Choose Plan':
                    window.TuskToast.info('Pricing', 'Let\'s find the perfect plan for you.');
                    break;
                case 'Read More Reviews':
                    window.TuskToast.info('Reviews', 'See what our customers are saying.');
                    break;
                case 'Contact Support':
                    window.TuskToast.success('Support', 'Our team is here to help you!');
                    break;
                default:
                    window.TuskToast.info('Action', `You clicked: ${text}`);
            }
        }
    }
    
    // Handle window resize for responsive highlight positioning
    window.addEventListener('resize', () => {
        tabsSections.forEach(section => {
            const tabButtons = section.querySelectorAll('.tab-button');
            const navHighlight = section.querySelector('.tab-nav-highlight');
            const activeIndex = Array.from(tabButtons).findIndex(btn => btn.classList.contains('active'));
            
            if (activeIndex !== -1) {
                updateNavHighlight(activeIndex, tabButtons, navHighlight, section);
            }
        });
    });
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
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
// Helper function to get tab icons
function getTabIcon($icon) {
    $icons = [
        'home' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg>',
        'star' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>',
        'dollar-sign' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
        'message-circle' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>',
        'help-circle' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
        'book' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
        'message-square' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>',
        'mail' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>',
        'play' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5,3 19,12 5,21"/></svg>'
    ];
    
    return isset($icons[$icon]) ? $icons[$icon] : $icons['home'];
}

// Make the function accessible to the template
$this = new class {
    public function getTabIcon($icon) {
        return getTabIcon($icon);
    }
};
?>