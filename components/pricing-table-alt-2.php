<?php
/**
 * Pricing Table Alternative 2 - Comparison Table
 * ============================================
 * Feature-rich comparison table with detailed breakdown
 * Perfect for complex products with many features to compare
 */

$theme = $_SESSION['theme'] ?? $config['theme'] ?? 'tusk_modern';
$plans = $plans ?? [
    [
        'name' => 'Basic',
        'price' => '$19',
        'period' => '/month',
        'description' => 'Essential features for getting started',
        'color' => '#6b7280',
        'features' => [
            'users' => '5 Users',
            'storage' => '10GB Storage',
            'projects' => '10 Projects',
            'support' => 'Email Support',
            'analytics' => 'Basic Analytics',
            'integrations' => '5 Integrations',
            'api' => false,
            'sso' => false,
            'backup' => 'Weekly Backup',
            'uptime' => '99.9% SLA'
        ]
    ],
    [
        'name' => 'Professional',
        'price' => '$49',
        'period' => '/month',
        'description' => 'Advanced features for growing teams',
        'color' => '#7c3aed',
        'popular' => true,
        'features' => [
            'users' => '25 Users',
            'storage' => '100GB Storage',
            'projects' => 'Unlimited Projects',
            'support' => 'Priority Support',
            'analytics' => 'Advanced Analytics',
            'integrations' => '50 Integrations',
            'api' => 'Full API Access',
            'sso' => false,
            'backup' => 'Daily Backup',
            'uptime' => '99.95% SLA'
        ]
    ],
    [
        'name' => 'Enterprise',
        'price' => '$99',
        'period' => '/month',
        'description' => 'Everything you need for enterprise scale',
        'color' => '#059669',
        'features' => [
            'users' => 'Unlimited Users',
            'storage' => 'Unlimited Storage',
            'projects' => 'Unlimited Projects',
            'support' => 'Dedicated Support',
            'analytics' => 'Custom Analytics',
            'integrations' => 'Unlimited Integrations',
            'api' => 'Full API Access',
            'sso' => 'SSO Integration',
            'backup' => 'Real-time Backup',
            'uptime' => '99.99% SLA'
        ]
    ]
];

$featureCategories = [
    'Core Features' => [
        'users' => 'Team Members',
        'storage' => 'Storage Space',
        'projects' => 'Active Projects'
    ],
    'Support & Service' => [
        'support' => 'Customer Support',
        'uptime' => 'Uptime Guarantee'
    ],
    'Analytics & Insights' => [
        'analytics' => 'Analytics Dashboard'
    ],
    'Integrations' => [
        'integrations' => 'Third-party Integrations',
        'api' => 'API Access'
    ],
    'Security & Backup' => [
        'sso' => 'Single Sign-On',
        'backup' => 'Data Backup'
    ]
];
?>

<section class="tusk-pricing-alt-2" id="tusk-pricing-alt-2">
    <div class="pricing-container">
        <!-- Header -->
        <div class="pricing-header">
            <h2 class="pricing-title">Compare Our Plans</h2>
            <p class="pricing-subtitle">Find the perfect plan for your team's needs</p>
        </div>

        <!-- Comparison Table -->
        <div class="comparison-wrapper">
            <div class="comparison-table">
                <!-- Table Header -->
                <div class="table-header">
                    <div class="feature-column">
                        <h3>Features</h3>
                    </div>
                    <?php foreach ($plans as $plan): ?>
                        <div class="plan-column <?= isset($plan['popular']) && $plan['popular'] ? 'popular' : '' ?>">
                            <?php if (isset($plan['popular']) && $plan['popular']): ?>
                                <div class="popular-badge">Most Popular</div>
                            <?php endif; ?>
                            <div class="plan-header" style="--plan-color: <?= $plan['color'] ?>">
                                <h3 class="plan-name"><?= htmlspecialchars($plan['name']) ?></h3>
                                <div class="plan-price">
                                    <span class="price"><?= htmlspecialchars($plan['price']) ?></span>
                                    <span class="period"><?= htmlspecialchars($plan['period']) ?></span>
                                </div>
                                <p class="plan-description"><?= htmlspecialchars($plan['description']) ?></p>
                                <button class="cta-button" style="background-color: <?= $plan['color'] ?>">
                                    Get Started
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                        <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Feature Rows -->
                <?php foreach ($featureCategories as $categoryName => $features): ?>
                    <div class="category-section">
                        <div class="category-header">
                            <h4 class="category-name"><?= htmlspecialchars($categoryName) ?></h4>
                            <div class="category-divider"></div>
                            <div class="category-divider"></div>
                            <div class="category-divider"></div>
                        </div>
                        
                        <?php foreach ($features as $featureKey => $featureName): ?>
                            <div class="feature-row">
                                <div class="feature-name">
                                    <span><?= htmlspecialchars($featureName) ?></span>
                                    <div class="feature-tooltip">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                                            <path d="M9,9h6v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            <path d="M12,17h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                        <div class="tooltip-content">
                                            <?= htmlspecialchars("Learn more about " . $featureName) ?>
                                        </div>
                                    </div>
                                </div>
                                <?php foreach ($plans as $plan): ?>
                                    <div class="feature-value">
                                        <?php 
                                        $value = $plan['features'][$featureKey] ?? false;
                                        if ($value === false): 
                                        ?>
                                            <svg class="feature-cross" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                                <path d="M18 6L6 18M6 6L18 18" stroke="#ef4444" stroke-width="2" stroke-linecap="round"/>
                                            </svg>
                                        <?php elseif ($value === true): ?>
                                            <svg class="feature-check" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                                <path d="M20 6L9 17L4 12" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        <?php else: ?>
                                            <span class="feature-text"><?= htmlspecialchars($value) ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="additional-info">
            <div class="info-grid">
                <div class="info-item">
                    <svg class="info-icon" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div>
                        <h4>30-Day Free Trial</h4>
                        <p>Test drive any plan risk-free</p>
                    </div>
                </div>
                <div class="info-item">
                    <svg class="info-icon" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2V6M12 18V22M4.93 4.93L7.76 7.76M16.24 16.24L19.07 19.07M2 12H6M18 12H22M4.93 19.07L7.76 16.24M16.24 7.76L19.07 4.93" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <div>
                        <h4>Instant Setup</h4>
                        <p>Get started in under 5 minutes</p>
                    </div>
                </div>
                <div class="info-item">
                    <svg class="info-icon" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M13 2L3 14H12L11 22L21 10H12L13 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div>
                        <h4>Upgrade Anytime</h4>
                        <p>Scale up or down as you grow</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.tusk-pricing-alt-2 {
    padding: 4rem 1rem;
    background: var(--bg-primary);
    min-height: 100vh;
}

.pricing-container {
    max-width: 1400px;
    margin: 0 auto;
    width: 100%;
}

.pricing-header {
    text-align: center;
    margin-bottom: 3rem;
}

.pricing-title {
    font-size: 3rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.pricing-subtitle {
    font-size: 1.2rem;
    color: var(--text-secondary);
    margin-bottom: 2rem;
}

.comparison-wrapper {
    background: var(--bg-primary);
    border-radius: 16px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    overflow: hidden;
    border: 1px solid var(--border-color);
    margin-bottom: 3rem;
}

.comparison-table {
    display: flex;
    flex-direction: column;
    width: 100%;
}

.table-header {
    display: grid;
    grid-template-columns: 300px repeat(3, 1fr);
    border-bottom: 2px solid var(--border-color);
    background: var(--bg-secondary, #f8fafc);
}

.feature-column {
    padding: 2rem;
    border-right: 1px solid var(--border-color);
    display: flex;
    align-items: center;
}

.feature-column h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
}

.plan-column {
    padding: 2rem;
    border-right: 1px solid var(--border-color);
    position: relative;
}

.plan-column:last-child {
    border-right: none;
}

.plan-column.popular {
    background: linear-gradient(135deg, var(--primary-color)05, var(--secondary-color)05);
    border-left: 3px solid var(--primary-color);
    border-right: 3px solid var(--primary-color);
}

.popular-badge {
    position: absolute;
    top: -12px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--primary-color);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
}

.plan-header {
    text-align: center;
}

.plan-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.plan-price {
    margin-bottom: 1rem;
}

.price {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--plan-color);
}

.period {
    font-size: 1rem;
    color: var(--text-secondary);
    margin-left: 0.25rem;
}

.plan-description {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
    line-height: 1.5;
}

.cta-button {
    width: 100%;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.cta-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.category-section {
    border-bottom: 1px solid var(--border-light, #f1f5f9);
}

.category-header {
    display: grid;
    grid-template-columns: 300px repeat(3, 1fr);
    background: var(--bg-secondary, #f8fafc);
    border-bottom: 1px solid var(--border-color);
}

.category-name {
    padding: 1rem 2rem;
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
    border-right: 1px solid var(--border-color);
}

.category-divider {
    border-right: 1px solid var(--border-color);
}

.category-divider:last-child {
    border-right: none;
}

.feature-row {
    display: grid;
    grid-template-columns: 300px repeat(3, 1fr);
    border-bottom: 1px solid var(--border-light, #f1f5f9);
    transition: background-color 0.2s ease;
}

.feature-row:hover {
    background: var(--bg-secondary, #f8fafc);
}

.feature-name {
    padding: 1rem 2rem;
    border-right: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    color: var(--text-primary);
}

.feature-tooltip {
    position: relative;
    cursor: help;
    color: var(--text-secondary);
}

.feature-tooltip:hover .tooltip-content {
    opacity: 1;
    visibility: visible;
    transform: translateY(-8px);
}

.tooltip-content {
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%) translateY(-4px);
    background: var(--text-primary);
    color: var(--bg-primary);
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    font-size: 0.75rem;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 10;
}

.feature-value {
    padding: 1rem 2rem;
    border-right: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.feature-value:last-child {
    border-right: none;
}

.feature-text {
    font-weight: 500;
    color: var(--text-primary);
}

.feature-check {
    color: #10b981;
}

.feature-cross {
    color: #ef4444;
}

.additional-info {
    text-align: center;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    max-width: 900px;
    margin: 0 auto;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: var(--bg-secondary, #f8fafc);
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

.info-icon {
    color: var(--primary-color);
    flex-shrink: 0;
}

.info-item h4 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 0.25rem 0;
}

.info-item p {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin: 0;
}

@media (max-width: 1024px) {
    .table-header,
    .category-header,
    .feature-row {
        grid-template-columns: 250px repeat(3, 1fr);
    }
    
    .feature-column,
    .category-name,
    .feature-name,
    .feature-value {
        padding: 1rem;
    }
    
    .plan-column {
        padding: 1.5rem 1rem;
    }
}

@media (max-width: 768px) {
    .pricing-title {
        font-size: 2rem;
    }
    
    .comparison-wrapper {
        overflow-x: auto;
    }
    
    .comparison-table {
        min-width: 800px;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .info-item {
        text-align: left;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click handlers for CTA buttons
    document.querySelectorAll('.cta-button').forEach(button => {
        button.addEventListener('click', function() {
            const planName = this.closest('.plan-column').querySelector('.plan-name').textContent;
            console.log(`Selected plan: ${planName}`);
            alert(`You selected the ${planName} plan!`);
        });
    });
    
    // Add smooth scrolling for comparison table on mobile
    const comparisonWrapper = document.querySelector('.comparison-wrapper');
    let isScrolling = false;
    
    comparisonWrapper.addEventListener('scroll', function() {
        if (!isScrolling) {
            window.requestAnimationFrame(function() {
                // Add any scroll-based animations here
                isScrolling = false;
            });
            isScrolling = true;
        }
    });
});
</script>