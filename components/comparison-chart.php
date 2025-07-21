<?php
/**
 * comparison-chart.php
 * Enhanced comparison chart with interactive features and animations
 */
?>

<section class="tusk-data-comparison-chart" id="comparison">
    <div class="data-container">
        <h2>📊 Feature Comparison</h2>
        <p>See how TuskPHP stacks up against the competition</p>
        
        <div class="comparison-controls">
            <div class="view-toggle">
                <button class="toggle-btn active" onclick="switchView('table')">📋 Table View</button>
                <button class="toggle-btn" onclick="switchView('cards')">🃏 Card View</button>
            </div>
            
            <div class="comparison-filters">
                <select id="category-filter" onchange="filterByCategory(this.value)">
                    <option value="all">All Features</option>
                    <option value="performance">Performance</option>
                    <option value="security">Security</option>
                    <option value="development">Development</option>
                    <option value="support">Support</option>
                </select>
            </div>
        </div>
        
        <div class="comparison-container">
            <!-- Table View -->
            <div id="table-view" class="comparison-view active">
                <div class="comparison-table">
                    <div class="table-header">
                        <div class="feature-col">Features</div>
                        <div class="product-col tuskphp">
                            <div class="product-logo">🐘</div>
                            <div class="product-name">TuskPHP</div>
                            <div class="product-price">Free</div>
                        </div>
                        <div class="product-col competitor1">
                            <div class="product-logo">🅰️</div>
                            <div class="product-name">Framework A</div>
                            <div class="product-price">$29/mo</div>
                        </div>
                        <div class="product-col competitor2">
                            <div class="product-logo">🅱️</div>
                            <div class="product-name">Framework B</div>
                            <div class="product-price">$49/mo</div>
                        </div>
                    </div>
                    
                    <div class="table-body">
                        <div class="feature-row" data-category="performance">
                            <div class="feature-name">
                                <span class="feature-title">⚡ Lightning Fast Performance</span>
                                <span class="feature-desc">Optimized for speed and efficiency</span>
                            </div>
                            <div class="feature-value tuskphp">✅</div>
                            <div class="feature-value competitor1">⚠️</div>
                            <div class="feature-value competitor2">❌</div>
                        </div>
                        
                        <div class="feature-row" data-category="security">
                            <div class="feature-name">
                                <span class="feature-title">🔒 Advanced Security</span>
                                <span class="feature-desc">Built-in protection against common threats</span>
                            </div>
                            <div class="feature-value tuskphp">✅</div>
                            <div class="feature-value competitor1">✅</div>
                            <div class="feature-value competitor2">⚠️</div>
                        </div>
                        
                        <div class="feature-row" data-category="development">
                            <div class="feature-name">
                                <span class="feature-title">🛠️ Developer Tools</span>
                                <span class="feature-desc">Comprehensive CLI and debugging tools</span>
                            </div>
                            <div class="feature-value tuskphp">✅</div>
                            <div class="feature-value competitor1">⚠️</div>
                            <div class="feature-value competitor2">✅</div>
                        </div>
                        
                        <div class="feature-row" data-category="support">
                            <div class="feature-name">
                                <span class="feature-title">📞 24/7 Support</span>
                                <span class="feature-desc">Round-the-clock assistance</span>
                            </div>
                            <div class="feature-value tuskphp">✅</div>
                            <div class="feature-value competitor1">❌</div>
                            <div class="feature-value competitor2">✅</div>
                        </div>
                        
                        <div class="feature-row" data-category="development">
                            <div class="feature-name">
                                <span class="feature-title">📚 Documentation</span>
                                <span class="feature-desc">Comprehensive guides and examples</span>
                            </div>
                            <div class="feature-value tuskphp">✅</div>
                            <div class="feature-value competitor1">⚠️</div>
                            <div class="feature-value competitor2">⚠️</div>
                        </div>
                        
                        <div class="feature-row" data-category="performance">
                            <div class="feature-name">
                                <span class="feature-title">📈 Auto Scaling</span>
                                <span class="feature-desc">Automatic resource scaling</span>
                            </div>
                            <div class="feature-value tuskphp">✅</div>
                            <div class="feature-value competitor1">❌</div>
                            <div class="feature-value competitor2">⚠️</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Card View -->
            <div id="card-view" class="comparison-view">
                <div class="comparison-cards">
                    <div class="product-card tuskphp featured">
                        <div class="card-header">
                            <div class="product-logo">🐘</div>
                            <h3>TuskPHP</h3>
                            <div class="product-price">Free</div>
                            <div class="featured-badge">🏆 Recommended</div>
                        </div>
                        <div class="card-features">
                            <div class="feature-item">✅ Lightning Fast Performance</div>
                            <div class="feature-item">✅ Advanced Security</div>
                            <div class="feature-item">✅ Developer Tools</div>
                            <div class="feature-item">✅ 24/7 Support</div>
                            <div class="feature-item">✅ Documentation</div>
                            <div class="feature-item">✅ Auto Scaling</div>
                        </div>
                        <button class="btn btn-primary">Choose TuskPHP</button>
                    </div>
                    
                    <div class="product-card competitor1">
                        <div class="card-header">
                            <div class="product-logo">🅰️</div>
                            <h3>Framework A</h3>
                            <div class="product-price">$29/month</div>
                        </div>
                        <div class="card-features">
                            <div class="feature-item">⚠️ Average Performance</div>
                            <div class="feature-item">✅ Advanced Security</div>
                            <div class="feature-item">⚠️ Limited Tools</div>
                            <div class="feature-item">❌ No 24/7 Support</div>
                            <div class="feature-item">⚠️ Basic Documentation</div>
                            <div class="feature-item">❌ No Auto Scaling</div>
                        </div>
                        <button class="btn btn-secondary">Learn More</button>
                    </div>
                    
                    <div class="product-card competitor2">
                        <div class="card-header">
                            <div class="product-logo">🅱️</div>
                            <h3>Framework B</h3>
                            <div class="product-price">$49/month</div>
                        </div>
                        <div class="card-features">
                            <div class="feature-item">❌ Slow Performance</div>
                            <div class="feature-item">⚠️ Basic Security</div>
                            <div class="feature-item">✅ Good Tools</div>
                            <div class="feature-item">✅ 24/7 Support</div>
                            <div class="feature-item">⚠️ Average Documentation</div>
                            <div class="feature-item">⚠️ Manual Scaling</div>
                        </div>
                        <button class="btn btn-secondary">Learn More</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="comparison-summary">
            <div class="summary-stats">
                <div class="stat-item">
                    <div class="stat-number">6/6</div>
                    <div class="stat-label">TuskPHP Features</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">2/6</div>
                    <div class="stat-label">Framework A Features</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">3/6</div>
                    <div class="stat-label">Framework B Features</div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function switchView(viewType) {
    const tableView = document.getElementById('table-view');
    const cardView = document.getElementById('card-view');
    const buttons = document.querySelectorAll('.toggle-btn');
    
    // Remove active class from all buttons and views
    buttons.forEach(btn => btn.classList.remove('active'));
    tableView.classList.remove('active');
    cardView.classList.remove('active');
    
    // Add active class to selected view and button
    if (viewType === 'table') {
        tableView.classList.add('active');
        buttons[0].classList.add('active');
    } else {
        cardView.classList.add('active');
        buttons[1].classList.add('active');
    }
}

function filterByCategory(category) {
    const rows = document.querySelectorAll('.feature-row');
    
    rows.forEach(row => {
        if (category === 'all' || row.getAttribute('data-category') === category) {
            row.style.display = 'grid';
            row.style.animation = 'fadeIn 0.3s ease';
        } else {
            row.style.display = 'none';
        }
    });
}

// Add hover effects to feature rows
document.querySelectorAll('.feature-row').forEach(row => {
    row.addEventListener('mouseenter', function() {
        this.style.backgroundColor = '#f8f9fa';
        this.style.transform = 'scale(1.02)';
    });
    
    row.addEventListener('mouseleave', function() {
        this.style.backgroundColor = '';
        this.style.transform = 'scale(1)';
    });
});

// Animate comparison on scroll
const comparisonObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const rows = entry.target.querySelectorAll('.feature-row');
            rows.forEach((row, index) => {
                setTimeout(() => {
                    row.style.opacity = '1';
                    row.style.transform = 'translateX(0)';
                }, index * 100);
            });
        }
    });
}, { threshold: 0.3 });

document.addEventListener('DOMContentLoaded', function() {
    const comparisonSection = document.getElementById('comparison');
    if (comparisonSection) {
        comparisonObserver.observe(comparisonSection);
    }
    
    // Set initial opacity for animation
    document.querySelectorAll('.feature-row').forEach(row => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        row.style.transition = 'all 0.3s ease';
    });
});
</script>