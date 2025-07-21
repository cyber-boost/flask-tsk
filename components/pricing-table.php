<?php
/**
 * <?tusk> Enhanced Pricing Table Component
 * Created: 2025-06-26
 * Strong. Secure. Scalable. 🐘
 *
 * <?tusk> pricing-table Component
 * Auto-Inclusion: [tusk-component-pricing-table]
 * Themes: default, dark, minimal, gradient, neon, corporate, warm, cool
 */

$theme = isset($theme) ? $theme : 'default';
$billing_period = isset($billing_period) ? $billing_period : 'monthly';
$show_annual_discount = isset($show_annual_discount) ? $show_annual_discount : true;

$pricing_plans = [
    [
        'id' => 'starter',
        'name' => 'Starter',
        'description' => 'Perfect for individuals and small projects',
        'monthly_price' => 9,
        'annual_price' => 90,
        'currency' => '$',
        'popular' => false,
        'features' => [
            '5 Projects',
            '10GB Storage',
            'Email Support',
            'Basic Analytics',
            'SSL Certificate',
            'Mobile App Access'
        ],
        'excluded_features' => [
            'Priority Support',
            'Advanced Analytics',
            'Custom Integrations'
        ],
        'cta_text' => 'Start Free Trial',
        'highlight_color' => '#3498db'
    ],
    [
        'id' => 'professional',
        'name' => 'Professional',
        'description' => 'Best for growing businesses and teams',
        'monthly_price' => 29,
        'annual_price' => 290,
        'currency' => '$',
        'popular' => true,
        'features' => [
            'Unlimited Projects',
            '100GB Storage',
            'Priority Support',
            'Advanced Analytics',
            'SSL Certificate',
            'Mobile App Access',
            'Team Collaboration',
            'Custom Branding',
            'API Access'
        ],
        'excluded_features' => [
            'White Label Solution',
            'Dedicated Account Manager'
        ],
        'cta_text' => 'Get Started',
        'highlight_color' => '#2ecc71'
    ],
    [
        'id' => 'enterprise',
        'name' => 'Enterprise',
        'description' => 'For large organizations with advanced needs',
        'monthly_price' => 99,
        'annual_price' => 990,
        'currency' => '$',
        'popular' => false,
        'features' => [
            'Everything in Professional',
            'Unlimited Storage',
            '24/7 Phone Support',
            'White Label Solution',
            'Custom Integrations',
            'Dedicated Account Manager',
            'SLA Guarantee',
            'Advanced Security',
            'Custom Training',
            'Priority Feature Requests'
        ],
        'excluded_features' => [],
        'cta_text' => 'Contact Sales',
        'highlight_color' => '#e74c3c'
    ]
];
?>

<section class="tusk-pricing-table tusk-pricing-table--<?php echo $theme; ?>" role="region" aria-label="Pricing Plans">
    <div class="pricing-container">
        <div class="pricing-header">
            <h2 class="pricing-title">Choose Your Plan</h2>
            <p class="pricing-subtitle">Simple, transparent pricing that grows with you</p>
            
            <?php if ($show_annual_discount): ?>
            <div class="billing-toggle">
                <span class="billing-label <?php echo $billing_period === 'monthly' ? 'active' : ''; ?>">Monthly</span>
                <button class="toggle-switch <?php echo $billing_period === 'annual' ? 'active' : ''; ?>" 
                        data-period="<?php echo $billing_period; ?>"
                        aria-label="Toggle billing period">
                    <div class="toggle-slider"></div>
                </button>
                <span class="billing-label <?php echo $billing_period === 'annual' ? 'active' : ''; ?>">
                    Annual
                    <span class="discount-badge">Save 17%</span>
                </span>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="pricing-grid">
            <?php foreach ($pricing_plans as $index => $plan): ?>
            <div class="pricing-card <?php echo $plan['popular'] ? 'popular' : ''; ?>" 
                 data-plan="<?php echo $plan['id']; ?>"
                 role="article"
                 aria-label="<?php echo $plan['name']; ?> pricing plan">
                
                <?php if ($plan['popular']): ?>
                <div class="popular-badge">Most Popular</div>
                <?php endif; ?>
                
                <div class="plan-header">
                    <h3 class="plan-name"><?php echo htmlspecialchars($plan['name']); ?></h3>
                    <p class="plan-description"><?php echo htmlspecialchars($plan['description']); ?></p>
                </div>
                
                <div class="plan-pricing">
                    <div class="price-display">
                        <span class="currency"><?php echo $plan['currency']; ?></span>
                        <span class="price-amount" data-monthly="<?php echo $plan['monthly_price']; ?>" data-annual="<?php echo $plan['annual_price']; ?>">
                            <?php echo $billing_period === 'annual' ? $plan['annual_price'] : $plan['monthly_price']; ?>
                        </span>
                        <span class="price-period">/<?php echo $billing_period === 'annual' ? 'year' : 'month'; ?></span>
                    </div>
                    
                    <?php if ($billing_period === 'annual'): ?>
                    <div class="price-note">
                        <span class="monthly-equivalent">$<?php echo number_format($plan['annual_price'] / 12, 2); ?> per month</span>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="plan-features">
                    <h4>What's included:</h4>
                    <ul class="features-list">
                        <?php foreach ($plan['features'] as $feature): ?>
                        <li class="feature-item included">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20,6 9,17 4,12"/>
                            </svg>
                            <?php echo htmlspecialchars($feature); ?>
                        </li>
                        <?php endforeach; ?>
                        
                        <?php foreach ($plan['excluded_features'] as $feature): ?>
                        <li class="feature-item excluded">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"/>
                                <line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                            <?php echo htmlspecialchars($feature); ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="plan-cta">
                    <button class="cta-button" 
                            data-plan="<?php echo $plan['id']; ?>"
                            style="background-color: <?php echo $plan['highlight_color']; ?>">
                        <?php echo htmlspecialchars($plan['cta_text']); ?>
                    </button>
                    
                    <div class="guarantee-text">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                        30-day money-back guarantee
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="pricing-footer">
            <div class="faq-section">
                <h3>Frequently Asked Questions</h3>
                <div class="faq-grid">
                    <div class="faq-item">
                        <h4>Can I change plans anytime?</h4>
                        <p>Yes, you can upgrade or downgrade your plan at any time. Changes take effect immediately.</p>
                    </div>
                    <div class="faq-item">
                        <h4>What payment methods do you accept?</h4>
                        <p>We accept all major credit cards, PayPal, and bank transfers for annual plans.</p>
                    </div>
                    <div class="faq-item">
                        <h4>Is there a free trial?</h4>
                        <p>Yes! All plans come with a 14-day free trial. No credit card required to start.</p>
                    </div>
                    <div class="faq-item">
                        <h4>Do you offer refunds?</h4>
                        <p>We offer a 30-day money-back guarantee on all plans, no questions asked.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pricingTables = document.querySelectorAll('.tusk-pricing-table');
    
    pricingTables.forEach(table => {
        const toggleSwitch = table.querySelector('.toggle-switch');
        const priceAmounts = table.querySelectorAll('.price-amount');
        const pricePeriods = table.querySelectorAll('.price-period');
        const monthlyEquivalents = table.querySelectorAll('.monthly-equivalent');
        const ctaButtons = table.querySelectorAll('.cta-button');
        const pricingCards = table.querySelectorAll('.pricing-card');
        
        let currentPeriod = toggleSwitch ? toggleSwitch.dataset.period : 'monthly';
        
        // Initialize billing toggle
        if (toggleSwitch) {
            initializeBillingToggle();
        }
        
        // Initialize CTA buttons
        initializeCTAButtons();
        
        // Initialize card interactions
        initializeCardInteractions();
        
        function initializeBillingToggle() {
            toggleSwitch.addEventListener('click', () => {
                currentPeriod = currentPeriod === 'monthly' ? 'annual' : 'monthly';
                toggleSwitch.dataset.period = currentPeriod;
                toggleSwitch.classList.toggle('active');
                
                updatePricing();
                updateLabels();
                logBillingToggle();
            });
        }
        
        function updatePricing() {
            priceAmounts.forEach(amount => {
                const monthlyPrice = parseInt(amount.dataset.monthly);
                const annualPrice = parseInt(amount.dataset.annual);
                const newPrice = currentPeriod === 'annual' ? annualPrice : monthlyPrice;
                
                // Animate price change
                amount.style.transform = 'scale(0.8)';
                amount.style.opacity = '0.5';
                
                setTimeout(() => {
                    amount.textContent = newPrice;
                    amount.style.transform = 'scale(1)';
                    amount.style.opacity = '1';
                }, 150);
            });
            
            // Update period labels
            pricePeriods.forEach(period => {
                period.textContent = '/' + (currentPeriod === 'annual' ? 'year' : 'month');
            });
            
            // Show/hide monthly equivalents
            monthlyEquivalents.forEach(equiv => {
                if (currentPeriod === 'annual') {
                    equiv.style.display = 'block';
                    equiv.style.opacity = '0';
                    setTimeout(() => {
                        equiv.style.opacity = '1';
                    }, 200);
                } else {
                    equiv.style.opacity = '0';
                    setTimeout(() => {
                        equiv.style.display = 'none';
                    }, 200);
                }
            });
        }
        
        function updateLabels() {
            const billingLabels = table.querySelectorAll('.billing-label');
            billingLabels.forEach(label => {
                label.classList.remove('active');
                if ((label.textContent.includes('Monthly') && currentPeriod === 'monthly') ||
                    (label.textContent.includes('Annual') && currentPeriod === 'annual')) {
                    label.classList.add('active');
                }
            });
        }
        
        function initializeCTAButtons() {
            ctaButtons.forEach(button => {
                button.addEventListener('click', () => {
                    handleCTAClick(button);
                });
            });
        }
        
        function initializeCardInteractions() {
            pricingCards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-10px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0) scale(1)';
                });
                
                card.addEventListener('click', () => {
                    const ctaButton = card.querySelector('.cta-button');
                    if (ctaButton) {
                        ctaButton.click();
                    }
                });
            });
        }
        
        function handleCTAClick(button) {
            const planId = button.dataset.plan;
            const planName = button.closest('.pricing-card').querySelector('.plan-name').textContent;
            
            // Add click effect
            button.style.transform = 'scale(0.95)';
            setTimeout(() => {
                button.style.transform = 'scale(1)';
            }, 150);
            
            // Log interaction
            console.log(`Plan selected: ${planName} (${planId}) - ${currentPeriod}`);
            
            // Show feedback
            if (window.TuskToast) {
                if (button.textContent.includes('Contact')) {
                    window.TuskToast.info('Contact Sales', 'Redirecting to sales team...');
                } else {
                    window.TuskToast.success('Plan Selected', `Starting ${planName} ${currentPeriod} plan setup...`);
                }
            }
            
            // Send analytics
            if (typeof gtag !== 'undefined') {
                gtag('event', 'select_plan', {
                    'plan_name': planName,
                    'plan_id': planId,
                    'billing_period': currentPeriod,
                    'currency': 'USD'
                });
            }
        }
        
        function logBillingToggle() {
            console.log(`Billing period changed to: ${currentPeriod}`);
            
            if (typeof gtag !== 'undefined') {
                gtag('event', 'billing_toggle', {
                    'billing_period': currentPeriod
                });
            }
        }
    });
});
</script>