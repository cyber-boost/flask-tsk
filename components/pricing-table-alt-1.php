<?php
/**
 * Pricing Table Alternative 1 - Premium Cards
 * =========================================
 * Modern card-based pricing with gradient backgrounds and enhanced features
 * Perfect for SaaS products and subscription services
 */

$theme = $_SESSION['theme'] ?? $config['theme'] ?? 'tusk_modern';
$plans = $plans ?? [
    [
        'name' => 'Starter',
        'price' => '$9',
        'period' => '/month',
        'description' => 'Perfect for individuals and small teams',
        'features' => [
            '5 Projects',
            '10GB Storage',
            'Email Support',
            'Basic Analytics',
            '24/7 Uptime'
        ],
        'popular' => false,
        'cta' => 'Get Started',
        'color' => 'blue'
    ],
    [
        'name' => 'Professional',
        'price' => '$29',
        'period' => '/month',
        'description' => 'Best for growing businesses and teams',
        'features' => [
            'Unlimited Projects',
            '100GB Storage',
            'Priority Support',
            'Advanced Analytics',
            'Custom Integrations',
            'Team Collaboration',
            'API Access'
        ],
        'popular' => true,
        'cta' => 'Start Free Trial',
        'color' => 'purple'
    ],
    [
        'name' => 'Enterprise',
        'price' => '$99',
        'period' => '/month',
        'description' => 'Advanced features for large organizations',
        'features' => [
            'Everything in Pro',
            'Unlimited Storage',
            'Dedicated Support',
            'Custom Reports',
            'SSO Integration',
            'Advanced Security',
            'Custom Training'
        ],
        'popular' => false,
        'cta' => 'Contact Sales',
        'color' => 'gold'
    ]
];
?>

<section class="tusk-pricing-alt-1" id="tusk-pricing-alt-1">
    <div class="pricing-container">
        <!-- Header -->
        <div class="pricing-header">
            <h2 class="pricing-title">Choose Your Plan</h2>
            <p class="pricing-subtitle">Scale with confidence. Upgrade or downgrade at any time.</p>
            
            <!-- Billing Toggle -->
            <div class="billing-toggle">
                <span class="toggle-label">Monthly</span>
                <label class="toggle-switch">
                    <input type="checkbox" id="billing-toggle">
                    <span class="toggle-slider"></span>
                </label>
                <span class="toggle-label">Yearly <span class="discount-badge">Save 20%</span></span>
            </div>
        </div>

        <!-- Pricing Cards -->
        <div class="pricing-grid">
            <?php foreach ($plans as $index => $plan): ?>
                <div class="pricing-card <?= $plan['popular'] ? 'popular' : '' ?>" data-plan="<?= strtolower($plan['name']) ?>">
                    <?php if ($plan['popular']): ?>
                        <div class="popular-badge">
                            <span>Most Popular</span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-header">
                        <div class="plan-icon">
                            <?php if ($plan['name'] === 'Starter'): ?>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 2L13.09 8.26L20 9L13.09 9.74L12 16L10.91 9.74L4 9L10.91 8.26L12 2Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                </svg>
                            <?php elseif ($plan['name'] === 'Professional'): ?>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 2L15.09 8.26L22 9L15.09 9.74L12 16L8.91 9.74L2 9L8.91 8.26L12 2Z" fill="currentColor"/>
                                </svg>
                            <?php else: ?>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 2L15.09 8.26L22 9L15.09 9.74L12 16L8.91 9.74L2 9L8.91 8.26L12 2Z" fill="url(#goldGradient)"/>
                                    <defs>
                                        <linearGradient id="goldGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" style="stop-color:#ffd700;stop-opacity:1" />
                                            <stop offset="100%" style="stop-color:#ffb300;stop-opacity:1" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                            <?php endif; ?>
                        </div>
                        <h3 class="plan-name"><?= htmlspecialchars($plan['name']) ?></h3>
                        <p class="plan-description"><?= htmlspecialchars($plan['description']) ?></p>
                    </div>

                    <div class="card-pricing">
                        <div class="price-wrapper">
                            <span class="price-currency">$</span>
                            <span class="price-amount" data-monthly="<?= str_replace('$', '', $plan['price']) ?>" data-yearly="<?= round(str_replace('$', '', $plan['price']) * 10) ?>"><?= str_replace('$', '', $plan['price']) ?></span>
                            <span class="price-period"><?= htmlspecialchars($plan['period']) ?></span>
                        </div>
                        <div class="yearly-savings" style="display: none;">Save $<?= round(str_replace('$', '', $plan['price']) * 2.4) ?> per year</div>
                    </div>

                    <div class="card-features">
                        <ul class="features-list">
                            <?php foreach ($plan['features'] as $feature): ?>
                                <li class="feature-item">
                                    <svg class="feature-check" width="16" height="16" viewBox="0 0 24 24" fill="none">
                                        <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span><?= htmlspecialchars($feature) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="card-footer">
                        <button class="cta-button <?= $plan['popular'] ? 'primary' : 'secondary' ?>">
                            <?= htmlspecialchars($plan['cta']) ?>
                            <svg class="button-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <p class="trial-info">14-day free trial • No credit card required</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Money Back Guarantee -->
        <div class="guarantee-section">
            <div class="guarantee-content">
                <svg class="guarantee-icon" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2"/>
                    <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <div class="guarantee-text">
                    <h4>30-Day Money Back Guarantee</h4>
                    <p>Try risk-free. If you're not satisfied, get a full refund within 30 days.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.tusk-pricing-alt-1 {
    padding: 4rem 1rem;
    background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary, #f8fafc) 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
}

.pricing-container {
    max-width: 1200px;
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
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.pricing-subtitle {
    font-size: 1.2rem;
    color: var(--text-secondary);
    margin-bottom: 2rem;
}

.billing-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.toggle-label {
    font-weight: 500;
    color: var(--text-primary);
}

.toggle-switch {
    position: relative;
    width: 60px;
    height: 30px;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: var(--border-color);
    border-radius: 30px;
    transition: all 0.3s ease;
}

.toggle-slider:before {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    left: 4px;
    bottom: 4px;
    background: white;
    border-radius: 50%;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

input:checked + .toggle-slider {
    background: var(--primary-color);
}

input:checked + .toggle-slider:before {
    transform: translateX(30px);
}

.discount-badge {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-left: 0.5rem;
}

.pricing-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.pricing-card {
    background: var(--bg-primary);
    border-radius: 20px;
    padding: 2rem;
    position: relative;
    border: 2px solid var(--border-color);
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.pricing-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    border-color: var(--primary-color);
}

.pricing-card.popular {
    border: 2px solid var(--primary-color);
    transform: scale(1.05);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.pricing-card.popular:hover {
    transform: scale(1.05) translateY(-8px);
}

.popular-badge {
    position: absolute;
    top: -12px;
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 0.5rem 1.5rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.card-header {
    text-align: center;
    margin-bottom: 2rem;
}

.plan-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 1rem;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.plan-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.plan-description {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.card-pricing {
    text-align: center;
    margin-bottom: 2rem;
    padding: 1.5rem 0;
    border-bottom: 2px solid var(--border-color);
}

.price-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.25rem;
    margin-bottom: 0.5rem;
}

.price-currency {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-secondary);
    align-self: flex-start;
    margin-top: 0.5rem;
}

.price-amount {
    font-size: 4rem;
    font-weight: 800;
    color: var(--text-primary);
    line-height: 1;
}

.price-period {
    font-size: 1rem;
    color: var(--text-secondary);
    align-self: flex-end;
    margin-bottom: 0.5rem;
}

.yearly-savings {
    color: var(--success-color, #10b981);
    font-size: 0.875rem;
    font-weight: 600;
    background: var(--success-bg, #ecfdf5);
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    display: inline-block;
    margin-top: 0.5rem;
}

.features-list {
    list-style: none;
    padding: 0;
    margin-bottom: 2rem;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 0;
    color: var(--text-primary);
    border-bottom: 1px solid var(--border-light, #f1f5f9);
}

.feature-item:last-child {
    border-bottom: none;
}

.feature-check {
    color: var(--success-color, #10b981);
    background: var(--success-bg, #ecfdf5);
    padding: 0.25rem;
    border-radius: 50%;
    flex-shrink: 0;
}

.cta-button {
    width: 100%;
    padding: 1rem 1.5rem;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.cta-button.primary {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.cta-button.primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
}

.cta-button.secondary {
    background: var(--bg-primary);
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
}

.cta-button.secondary:hover {
    background: var(--primary-color);
    color: white;
}

.button-arrow {
    transition: transform 0.3s ease;
}

.cta-button:hover .button-arrow {
    transform: translateX(4px);
}

.trial-info {
    font-size: 0.875rem;
    color: var(--text-secondary);
    text-align: center;
    margin: 0;
}

.guarantee-section {
    text-align: center;
    padding: 2rem;
    background: var(--bg-secondary, #f8fafc);
    border-radius: 16px;
    border: 2px dashed var(--border-color);
}

.guarantee-content {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    max-width: 500px;
    margin: 0 auto;
}

.guarantee-icon {
    color: var(--success-color, #10b981);
    flex-shrink: 0;
}

.guarantee-text h4 {
    margin: 0 0 0.5rem 0;
    color: var(--text-primary);
    font-weight: 600;
}

.guarantee-text p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .pricing-title {
        font-size: 2rem;
    }
    
    .pricing-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .pricing-card.popular {
        transform: none;
    }
    
    .pricing-card.popular:hover {
        transform: translateY(-8px);
    }
    
    .guarantee-content {
        flex-direction: column;
        text-align: center;
    }
    
    .billing-toggle {
        flex-wrap: wrap;
    }
}
</style>

<script>
// Billing toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const billingToggle = document.getElementById('billing-toggle');
    const priceAmounts = document.querySelectorAll('.price-amount');
    const yearlySavings = document.querySelectorAll('.yearly-savings');
    
    billingToggle.addEventListener('change', function() {
        const isYearly = this.checked;
        
        priceAmounts.forEach(priceElement => {
            const monthlyPrice = priceElement.dataset.monthly;
            const yearlyPrice = priceElement.dataset.yearly;
            
            if (isYearly) {
                priceElement.textContent = yearlyPrice;
                priceElement.parentNode.querySelector('.price-period').textContent = '/year';
            } else {
                priceElement.textContent = monthlyPrice;
                priceElement.parentNode.querySelector('.price-period').textContent = '/month';
            }
        });
        
        yearlySavings.forEach(savingsElement => {
            savingsElement.style.display = isYearly ? 'inline-block' : 'none';
        });
    });
    
    // Add click handlers for CTA buttons
    document.querySelectorAll('.cta-button').forEach(button => {
        button.addEventListener('click', function() {
            const planName = this.closest('.pricing-card').dataset.plan;
            const isYearly = billingToggle.checked;
            
            // Track the selection
            console.log(`Selected plan: ${planName}, billing: ${isYearly ? 'yearly' : 'monthly'}`);
            
            // Here you would typically redirect to checkout or open a modal
            // For demo purposes, we'll just show an alert
            alert(`You selected the ${planName} plan with ${isYearly ? 'yearly' : 'monthly'} billing!`);
        });
    });
});
</script>