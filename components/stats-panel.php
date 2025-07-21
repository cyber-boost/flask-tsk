<?php
/**
 * <?tusk> Enhanced Stats Panel Component
 * Created: 2025-06-26
 * Strong. Secure. Scalable. 🐘
 *
 * <?tusk> stats-panel Component
 * Auto-Inclusion: [tusk-component-stats-panel]
 * Themes: default, dark, minimal, gradient, neon, corporate, warm, cool
 */

// Theme and configuration
$theme = isset($theme) ? $theme : 'default';
$layout = isset($layout) ? $layout : 'grid'; // grid, horizontal, vertical
$animated = isset($animated) ? $animated : true;
$show_icons = isset($show_icons) ? $show_icons : true;
$show_trends = isset($show_trends) ? $show_trends : true;

// Stats data
$stats = isset($stats) ? $stats : [
    [
        'id' => 'revenue',
        'title' => 'Total Revenue',
        'value' => 2847293,
        'format' => 'currency',
        'trend' => 12.5,
        'trend_direction' => 'up',
        'icon' => 'dollar-sign',
        'color' => '#2ecc71',
        'description' => 'Monthly recurring revenue',
        'target' => 3000000,
        'period' => 'This Month'
    ],
    [
        'id' => 'users',
        'title' => 'Active Users',
        'value' => 45821,
        'format' => 'number',
        'trend' => 8.3,
        'trend_direction' => 'up',
        'icon' => 'users',
        'color' => '#3498db',
        'description' => 'Daily active users',
        'target' => 50000,
        'period' => 'Last 24h'
    ],
    [
        'id' => 'conversion',
        'title' => 'Conversion Rate',
        'value' => 3.47,
        'format' => 'percentage',
        'trend' => -0.8,
        'trend_direction' => 'down',
        'icon' => 'trending-up',
        'color' => '#f39c12',
        'description' => 'Visitor to customer conversion',
        'target' => 4.0,
        'period' => 'This Week'
    ],
    [
        'id' => 'satisfaction',
        'title' => 'Customer Satisfaction',
        'value' => 4.8,
        'format' => 'rating',
        'trend' => 2.1,
        'trend_direction' => 'up',
        'icon' => 'star',
        'color' => '#e74c3c',
        'description' => 'Average customer rating',
        'target' => 5.0,
        'period' => 'All Time'
    ],
    [
        'id' => 'growth',
        'title' => 'Monthly Growth',
        'value' => 23.4,
        'format' => 'percentage',
        'trend' => 5.2,
        'trend_direction' => 'up',
        'icon' => 'bar-chart',
        'color' => '#9b59b6',
        'description' => 'Month over month growth',
        'target' => 25.0,
        'period' => 'This Quarter'
    ],
    [
        'id' => 'response',
        'title' => 'Avg Response Time',
        'value' => 2.3,
        'format' => 'time',
        'trend' => -15.6,
        'trend_direction' => 'up',
        'icon' => 'clock',
        'color' => '#1abc9c',
        'description' => 'Average support response time',
        'target' => 2.0,
        'period' => 'This Month'
    ]
];
?>

<section class="tusk-stats-panel tusk-stats-panel--<?php echo $theme; ?> tusk-stats-panel--<?php echo $layout; ?>" 
         role="region" 
         aria-label="Statistics Dashboard">
    <div class="stats-container">
        <div class="stats-header">
            <h2 class="stats-title">Performance Dashboard</h2>
            <p class="stats-subtitle">Real-time insights into your business metrics</p>
            
            <div class="stats-filters">
                <button class="filter-btn active" data-period="all">All Metrics</button>
                <button class="filter-btn" data-period="positive">Trending Up</button>
                <button class="filter-btn" data-period="negative">Needs Attention</button>
            </div>
        </div>
        
        <div class="stats-grid<?php echo $animated ? ' animated' : ''; ?>">
            <?php foreach ($stats as $index => $stat): ?>
            <div class="stat-card" 
                 data-index="<?php echo $index; ?>"
                 data-trend="<?php echo $stat['trend_direction']; ?>"
                 data-value="<?php echo $stat['value']; ?>"
                 role="article"
                 aria-label="<?php echo htmlspecialchars($stat['title']); ?> statistic">
                
                <div class="stat-header">
                    <?php if ($show_icons): ?>
                    <div class="stat-icon" style="background-color: <?php echo $stat['color']; ?>;">
                        <?php echo $this->getStatIcon($stat['icon']); ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="stat-meta">
                        <h3 class="stat-title"><?php echo htmlspecialchars($stat['title']); ?></h3>
                        <span class="stat-period"><?php echo htmlspecialchars($stat['period']); ?></span>
                    </div>
                    
                    <?php if ($show_trends): ?>
                    <div class="stat-trend trend--<?php echo $stat['trend_direction']; ?>">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <?php if ($stat['trend_direction'] === 'up'): ?>
                            <polyline points="23,6 13.5,15.5 8.5,10.5 1,18"/>
                            <polyline points="17,6 23,6 23,12"/>
                            <?php else: ?>
                            <polyline points="23,18 13.5,8.5 8.5,13.5 1,6"/>
                            <polyline points="17,18 23,18 23,12"/>
                            <?php endif; ?>
                        </svg>
                        <span><?php echo abs($stat['trend']); ?>%</span>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="stat-value">
                    <span class="value-number" data-value="<?php echo $stat['value']; ?>" data-format="<?php echo $stat['format']; ?>">
                        <?php echo $this->formatStatValue($stat['value'], $stat['format']); ?>
                    </span>
                </div>
                
                <div class="stat-description">
                    <?php echo htmlspecialchars($stat['description']); ?>
                </div>
                
                <div class="stat-progress">
                    <div class="progress-bar">
                        <div class="progress-fill" 
                             style="width: <?php echo min(($stat['value'] / $stat['target']) * 100, 100); ?>%; background-color: <?php echo $stat['color']; ?>;"></div>
                    </div>
                    <div class="progress-label">
                        <span>Target: <?php echo $this->formatStatValue($stat['target'], $stat['format']); ?></span>
                        <span><?php echo round(($stat['value'] / $stat['target']) * 100); ?>%</span>
                    </div>
                </div>
                
                <div class="stat-actions">
                    <button class="action-btn details-btn" data-stat="<?php echo $stat['id']; ?>">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="16" x2="12" y2="12"/>
                            <line x1="12" y1="8" x2="12.01" y2="8"/>
                        </svg>
                        Details
                    </button>
                    <button class="action-btn export-btn" data-stat="<?php echo $stat['id']; ?>">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7,10 12,15 17,10"/>
                            <line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                        Export
                    </button>
                </div>
                
                <div class="stat-glow"></div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="stats-summary">
            <div class="summary-card">
                <h3>Overall Performance</h3>
                <div class="summary-metrics">
                    <div class="summary-item">
                        <span class="summary-label">Metrics Improving</span>
                        <span class="summary-value positive"><?php echo count(array_filter($stats, function($s) { return $s['trend_direction'] === 'up'; })); ?></span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Need Attention</span>
                        <span class="summary-value negative"><?php echo count(array_filter($stats, function($s) { return $s['trend_direction'] === 'down'; })); ?></span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Targets Met</span>
                        <span class="summary-value"><?php echo count(array_filter($stats, function($s) { return $s['value'] >= $s['target']; })); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Base Styles */
.tusk-stats-panel {
    padding: 5rem 0;
    position: relative;
    overflow: hidden;
}

.stats-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
}

.stats-header {
    text-align: center;
    margin-bottom: 4rem;
}

.stats-title {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 800;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stats-subtitle {
    font-size: 1.2rem;
    opacity: 0.8;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.stats-filters {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.filter-btn {
    padding: 0.75rem 1.5rem;
    border: 2px solid transparent;
    border-radius: 25px;
    background: rgba(255, 255, 255, 0.1);
    color: #7f8c8d;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.filter-btn.active,
.filter-btn:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    gap: 2rem;
    margin-bottom: 4rem;
}

.tusk-stats-panel--grid .stats-grid {
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
}

.tusk-stats-panel--horizontal .stats-grid {
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}

.tusk-stats-panel--vertical .stats-grid {
    grid-template-columns: 1fr;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

/* Stat Cards */
.stat-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    padding: 2rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    overflow: hidden;
    position: relative;
    cursor: pointer;
}

.stat-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
}

.stat-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
    flex-shrink: 0;
}

.stat-card:hover .stat-icon {
    transform: scale(1.1) rotate(10deg);
}

.stat-icon svg {
    width: 28px;
    height: 28px;
}

.stat-meta {
    flex: 1;
}

.stat-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0 0 0.25rem 0;
    line-height: 1.2;
}

.stat-period {
    font-size: 0.85rem;
    color: #7f8c8d;
    font-weight: 500;
}

.stat-trend {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.9rem;
    font-weight: 600;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    flex-shrink: 0;
}

.trend--up {
    color: #2ecc71;
    background: rgba(46, 204, 113, 0.1);
}

.trend--down {
    color: #e74c3c;
    background: rgba(231, 76, 60, 0.1);
}

.stat-value {
    margin-bottom: 1rem;
}

.value-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: #2c3e50;
    line-height: 1;
    display: block;
}

.stat-description {
    font-size: 0.95rem;
    color: #7f8c8d;
    margin-bottom: 1.5rem;
    line-height: 1.4;
}

.stat-progress {
    margin-bottom: 1.5rem;
}

.progress-bar {
    height: 8px;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.progress-fill {
    height: 100%;
    border-radius: 4px;
    transition: width 1s ease;
}

.progress-label {
    display: flex;
    justify-content: space-between;
    font-size: 0.85rem;
    color: #7f8c8d;
}

.stat-actions {
    display: flex;
    gap: 0.75rem;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: rgba(52, 152, 219, 0.1);
    border: 1px solid rgba(52, 152, 219, 0.2);
    border-radius: 20px;
    color: #3498db;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.action-btn:hover {
    background: #3498db;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
}

.stat-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
    border-radius: 50%;
    transform: translate(-50%, -50%) scale(0);
    transition: transform 0.4s ease;
    pointer-events: none;
}

.stat-card:hover .stat-glow {
    transform: translate(-50%, -50%) scale(1.5);
}

/* Animated entrance */
.stats-grid.animated .stat-card {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.6s ease forwards;
}

.stats-grid.animated .stat-card:nth-child(1) { animation-delay: 0.1s; }
.stats-grid.animated .stat-card:nth-child(2) { animation-delay: 0.2s; }
.stats-grid.animated .stat-card:nth-child(3) { animation-delay: 0.3s; }
.stats-grid.animated .stat-card:nth-child(4) { animation-delay: 0.4s; }
.stats-grid.animated .stat-card:nth-child(5) { animation-delay: 0.5s; }
.stats-grid.animated .stat-card:nth-child(6) { animation-delay: 0.6s; }

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Summary Section */
.stats-summary {
    text-align: center;
}

.summary-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 2rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.summary-card h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: #2c3e50;
}

.summary-metrics {
    display: flex;
    justify-content: center;
    gap: 3rem;
    flex-wrap: wrap;
}

.summary-item {
    text-align: center;
}

.summary-label {
    display: block;
    font-size: 0.9rem;
    color: #7f8c8d;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.summary-value {
    font-size: 2rem;
    font-weight: 800;
    color: #2c3e50;
}

.summary-value.positive {
    color: #2ecc71;
}

.summary-value.negative {
    color: #e74c3c;
}

/* Theme Variants */
.tusk-stats-panel--default {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    color: #2c3e50;
}

.tusk-stats-panel--dark {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    color: white;
}

.tusk-stats-panel--dark .stat-card {
    background: rgba(45, 45, 45, 0.95);
    border-color: rgba(255, 255, 255, 0.1);
}

.tusk-stats-panel--dark .stat-title,
.tusk-stats-panel--dark .value-number,
.tusk-stats-panel--dark .summary-card h3,
.tusk-stats-panel--dark .summary-value {
    color: white;
}

.tusk-stats-panel--dark .stats-title {
    background: linear-gradient(135deg, #00ff88 0%, #00d4ff 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.tusk-stats-panel--minimal {
    background: #ffffff;
    color: #333333;
}

.tusk-stats-panel--minimal .stat-card {
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
}

.tusk-stats-panel--gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.tusk-stats-panel--gradient .stat-card {
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.2);
}

.tusk-stats-panel--gradient .stat-title,
.tusk-stats-panel--gradient .value-number,
.tusk-stats-panel--gradient .summary-card h3,
.tusk-stats-panel--gradient .summary-value {
    color: white;
}

.tusk-stats-panel--neon {
    background: #0a0a0a;
    color: #00ff88;
}

.tusk-stats-panel--neon .stat-card {
    background: rgba(0, 20, 40, 0.9);
    border: 1px solid #00ff88;
    box-shadow: 0 0 30px rgba(0, 255, 136, 0.2);
}

.tusk-stats-panel--corporate {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: white;
}

.tusk-stats-panel--corporate .stat-card {
    background: rgba(255, 255, 255, 0.1);
}

.tusk-stats-panel--corporate .stat-title,
.tusk-stats-panel--corporate .value-number,
.tusk-stats-panel--corporate .summary-card h3,
.tusk-stats-panel--corporate .summary-value {
    color: white;
}

.tusk-stats-panel--warm {
    background: linear-gradient(135deg, #ff9a56 0%, #ffad56 100%);
    color: #2c3e50;
}

.tusk-stats-panel--cool {
    background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
    color: white;
}

.tusk-stats-panel--cool .stat-card {
    background: rgba(255, 255, 255, 0.15);
}

.tusk-stats-panel--cool .stat-title,
.tusk-stats-panel--cool .value-number,
.tusk-stats-panel--cool .summary-card h3,
.tusk-stats-panel--cool .summary-value {
    color: white;
}

/* Responsive Design */
@media (max-width: 968px) {
    .stats-container {
        padding: 0 1.5rem;
    }
    
    .summary-metrics {
        gap: 2rem;
    }
}

@media (max-width: 768px) {
    .tusk-stats-panel {
        padding: 3rem 0;
    }
    
    .stats-header {
        margin-bottom: 2.5rem;
    }
    
    .tusk-stats-panel--grid .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .stat-card {
        padding: 1.5rem;
    }
    
    .stat-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .stat-icon {
        order: 1;
    }
    
    .stat-meta {
        order: 2;
        text-align: center;
    }
    
    .stat-trend {
        order: 3;
    }
    
    .value-number {
        font-size: 2rem;
    }
    
    .summary-metrics {
        flex-direction: column;
        gap: 1.5rem;
    }
}

@media (max-width: 480px) {
    .stats-container {
        padding: 0 1rem;
    }
    
    .stat-card {
        padding: 1rem;
    }
    
    .stat-actions {
        justify-content: center;
    }
    
    .action-btn {
        flex: 1;
        justify-content: center;
    }
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
    .stat-card,
    .stat-icon,
    .stat-glow,
    .action-btn,
    .filter-btn {
        animation: none;
        transition: none;
    }
    
    .stats-grid.animated .stat-card {
        animation: none;
        opacity: 1;
        transform: none;
    }
}

/* High contrast mode */
@media (prefers-contrast: high) {
    .stat-card {
        border: 2px solid black;
    }
    
    .filter-btn,
    .action-btn {
        border: 2px solid black;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statsPanel = document.querySelectorAll('.tusk-stats-panel');
    
    statsPanel.forEach(panel => {
        const filterBtns = panel.querySelectorAll('.filter-btn');
        const statCards = panel.querySelectorAll('.stat-card');
        const valueNumbers = panel.querySelectorAll('.value-number');
        const actionBtns = panel.querySelectorAll('.action-btn');
        
        // Initialize filtering
        initializeFiltering(filterBtns, statCards);
        
        // Animate values on scroll
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Add entrance animations
                    const grid = panel.querySelector('.stats-grid');
                    if (!grid.classList.contains('animated')) {
                        grid.classList.add('animated');
                    }
                    
                    // Animate stat values
                    valueNumbers.forEach(value => {
                        animateStatValue(value);
                    });
                }
            });
        }, observerOptions);
        
        observer.observe(panel);
        
        // Handle action button clicks
        actionBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                handleActionClick(btn);
            });
        });
        
        // Handle stat card clicks
        statCards.forEach((card, index) => {
            card.addEventListener('click', () => {
                handleStatCardClick(card, index);
            });
            
            // Add keyboard support
            card.setAttribute('tabindex', '0');
            card.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    card.click();
                }
            });
        });
    });
    
    function initializeFiltering(filterBtns, statCards) {
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Update active state
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                const filter = btn.dataset.period;
                
                // Filter stat cards
                statCards.forEach(card => {
                    const trend = card.dataset.trend;
                    
                    let shouldShow = true;
                    if (filter === 'positive' && trend !== 'up') {
                        shouldShow = false;
                    } else if (filter === 'negative' && trend !== 'down') {
                        shouldShow = false;
                    }
                    
                    if (shouldShow) {
                        card.style.display = 'block';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(-20px)';
                        setTimeout(() => {
                            if (card.style.opacity === '0') {
                                card.style.display = 'none';
                            }
                        }, 300);
                    }
                });
            });
        });
    }
    
    function animateStatValue(element) {
        const targetValue = parseFloat(element.dataset.value);
        const format = element.dataset.format;
        
        if (isNaN(targetValue)) return;
        
        let currentValue = 0;
        const increment = targetValue / 60;
        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= targetValue) {
                currentValue = targetValue;
                clearInterval(timer);
            }
            
            element.textContent = formatStatValue(currentValue, format);
        }, 33);
    }
    
    function formatStatValue(value, format) {
        switch (format) {
            case 'currency':
                if (value >= 1000000) {
                    return '$' + (value / 1000000).toFixed(1) + 'M';
                } else if (value >= 1000) {
                    return '$' + (value / 1000).toFixed(1) + 'K';
                }
                return '$' + Math.floor(value).toLocaleString();
            
            case 'number':
                if (value >= 1000000) {
                    return (value / 1000000).toFixed(1) + 'M';
                } else if (value >= 1000) {
                    return (value / 1000).toFixed(1) + 'K';
                }
                return Math.floor(value).toLocaleString();
            
            case 'percentage':
                return value.toFixed(1) + '%';
            
            case 'rating':
                return value.toFixed(1) + '★';
            
            case 'time':
                return value.toFixed(1) + 's';
            
            default:
                return Math.floor(value).toLocaleString();
        }
    }
    
    function handleActionClick(btn) {
        const action = btn.classList.contains('details-btn') ? 'details' : 'export';
        const statId = btn.dataset.stat;
        
        // Add click effect
        btn.style.transform = 'scale(0.95)';
        setTimeout(() => {
            btn.style.transform = '';
        }, 150);
        
        // Log interaction
        console.log(`${action} clicked for stat: ${statId}`);
        
        // Handle action
        if (action === 'details') {
            if (window.TuskToast) {
                window.TuskToast.info('Details', `Opening detailed view for ${statId}`);
            } else {
                alert(`Opening detailed view for ${statId}`);
            }
        } else {
            if (window.TuskToast) {
                window.TuskToast.success('Export', `Exporting data for ${statId}`);
            } else {
                alert(`Exporting data for ${statId}`);
            }
        }
    }
    
    function handleStatCardClick(card, index) {
        // Add pulse effect
        card.style.animation = 'statPulse 0.6s ease';
        
        setTimeout(() => {
            card.style.animation = '';
        }, 600);
        
        // Log interaction
        console.log(`Stat card clicked: ${index}`);
        
        // Trigger custom event
        card.dispatchEvent(new CustomEvent('statCardClick', {
            detail: { index, card }
        }));
    }
    
    // Real-time updates simulation
    function simulateRealTimeUpdates() {
        const valueNumbers = document.querySelectorAll('.value-number');
        
        setInterval(() => {
            valueNumbers.forEach(value => {
                const currentValue = parseFloat(value.dataset.value);
                const format = value.dataset.format;
                const variance = currentValue * (Math.random() * 0.1 - 0.05); // ±5% variance
                const newValue = Math.max(0, currentValue + variance);
                
                value.dataset.value = newValue;
                value.textContent = formatStatValue(newValue, format);
                
                // Update progress bar
                const card = value.closest('.stat-card');
                const progressFill = card.querySelector('.progress-fill');
                if (progressFill) {
                    const target = parseFloat(card.querySelector('.progress-label span').textContent.replace(/[^\d.]/g, ''));
                    const percentage = Math.min((newValue / target) * 100, 100);
                    progressFill.style.width = percentage + '%';
                }
            });
        }, 10000); // Update every 10 seconds
    }
    
    // Start real-time updates
    simulateRealTimeUpdates();
    
    // Make formatStatValue globally accessible
    window.formatStatValue = formatStatValue;
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
@keyframes statPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.02); }
    100% { transform: scale(1); }
}
`;
document.head.appendChild(style);
</script>

<?php
// Helper functions
function getStatIcon($icon) {
    $icons = [
        'dollar-sign' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
        'users' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        'trending-up' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23,6 13.5,15.5 8.5,10.5 1,18"/><polyline points="17,6 23,6 23,12"/></svg>',
        'star' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>',
        'bar-chart' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>',
        'clock' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>'
    ];
    
    return isset($icons[$icon]) ? $icons[$icon] : $icons['bar-chart'];
}

function formatStatValue($value, $format) {
    switch ($format) {
        case 'currency':
            if ($value >= 1000000) {
                return '$' . number_format($value / 1000000, 1) . 'M';
            } else if ($value >= 1000) {
                return '$' . number_format($value / 1000, 1) . 'K';
            }
            return '$' . number_format($value);
        
        case 'number':
            if ($value >= 1000000) {
                return number_format($value / 1000000, 1) . 'M';
            } else if ($value >= 1000) {
                return number_format($value / 1000, 1) . 'K';
            }
            return number_format($value);
        
        case 'percentage':
            return number_format($value, 1) . '%';
        
        case 'rating':
            return number_format($value, 1) . '★';
        
        case 'time':
            return number_format($value, 1) . 's';
        
        default:
            return number_format($value);
    }
}

// Make helper functions accessible to the template
$this = new class {
    public function getStatIcon($icon) {
        return getStatIcon($icon);
    }
    
    public function formatStatValue($value, $format) {
        return formatStatValue($value, $format);
    }
};
?>