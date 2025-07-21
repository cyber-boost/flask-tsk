<?php
/**
 * <?tusk> Enhanced Timeline Component
 * Created: 2025-06-26
 * Strong. Secure. Scalable. 🐘
 *
 * <?tusk> timeline Component
 * Auto-Inclusion: [tusk-component-timeline]
 * Themes: default, dark, minimal, gradient, neon, corporate, warm, cool
 */

// Theme and configuration
$theme = isset($theme) ? $theme : 'default';
$layout = isset($layout) ? $layout : 'vertical'; // vertical, horizontal
$animated = isset($animated) ? $animated : true;
$show_dates = isset($show_dates) ? $show_dates : true;

// Timeline data
$timeline_items = isset($timeline_items) ? $timeline_items : [
    [
        'date' => '2024-01-15',
        'title' => 'Project Kickoff',
        'description' => 'Initial planning and team formation. Defined project scope and objectives.',
        'type' => 'milestone',
        'icon' => 'flag',
        'status' => 'completed'
    ],
    [
        'date' => '2024-02-28',
        'title' => 'Design Phase',
        'description' => 'Created wireframes, mockups, and design system. User research and testing.',
        'type' => 'phase',
        'icon' => 'palette',
        'status' => 'completed'
    ],
    [
        'date' => '2024-04-10',
        'title' => 'Development Sprint 1',
        'description' => 'Backend architecture setup, API development, and database design.',
        'type' => 'development',
        'icon' => 'code',
        'status' => 'completed'
    ],
    [
        'date' => '2024-05-20',
        'title' => 'Frontend Development',
        'description' => 'User interface implementation, responsive design, and component library.',
        'type' => 'development',
        'icon' => 'monitor',
        'status' => 'completed'
    ],
    [
        'date' => '2024-06-15',
        'title' => 'Testing & QA',
        'description' => 'Comprehensive testing, bug fixes, and performance optimization.',
        'type' => 'testing',
        'icon' => 'check-circle',
        'status' => 'in-progress'
    ],
    [
        'date' => '2024-07-01',
        'title' => 'Beta Release',
        'description' => 'Limited release to beta users for feedback and final improvements.',
        'type' => 'milestone',
        'icon' => 'rocket',
        'status' => 'upcoming'
    ],
    [
        'date' => '2024-08-15',
        'title' => 'Launch',
        'description' => 'Official product launch with marketing campaign and user onboarding.',
        'type' => 'milestone',
        'icon' => 'star',
        'status' => 'upcoming'
    ]
];
?>

<section class="tusk-timeline tusk-timeline--<?php echo $theme; ?> tusk-timeline--<?php echo $layout; ?>" 
         role="region" 
         aria-label="Project Timeline">
    <div class="timeline-container">
        <div class="timeline-header">
            <h2 class="timeline-title">Project Timeline</h2>
            <p class="timeline-subtitle">Track our progress from concept to launch</p>
            
            <div class="timeline-legend">
                <div class="legend-item">
                    <div class="legend-dot legend-dot--completed"></div>
                    <span>Completed</span>
                </div>
                <div class="legend-item">
                    <div class="legend-dot legend-dot--in-progress"></div>
                    <span>In Progress</span>
                </div>
                <div class="legend-item">
                    <div class="legend-dot legend-dot--upcoming"></div>
                    <span>Upcoming</span>
                </div>
            </div>
        </div>
        
        <div class="timeline-wrapper<?php echo $animated ? ' animated' : ''; ?>">
            <div class="timeline-line" aria-hidden="true"></div>
            
            <div class="timeline-items">
                <?php foreach ($timeline_items as $index => $item): ?>
                <div class="timeline-item timeline-item--<?php echo $item['status']; ?> timeline-item--<?php echo $item['type']; ?>" 
                     data-index="<?php echo $index; ?>"
                     role="article"
                     aria-label="Timeline event: <?php echo htmlspecialchars($item['title']); ?>">
                    
                    <div class="timeline-marker" aria-hidden="true">
                        <div class="marker-icon">
                            <?php echo $this->getTimelineIcon($item['icon']); ?>
                        </div>
                        <div class="marker-ring"></div>
                        <div class="marker-pulse"></div>
                    </div>
                    
                    <div class="timeline-content">
                        <?php if ($show_dates): ?>
                        <time class="timeline-date" datetime="<?php echo $item['date']; ?>">
                            <?php echo date('M j, Y', strtotime($item['date'])); ?>
                        </time>
                        <?php endif; ?>
                        
                        <div class="timeline-card">
                            <div class="card-header">
                                <h3 class="timeline-item-title"><?php echo htmlspecialchars($item['title']); ?></h3>
                                <span class="timeline-badge timeline-badge--<?php echo $item['type']; ?>">
                                    <?php echo ucfirst($item['type']); ?>
                                </span>
                            </div>
                            
                            <p class="timeline-description"><?php echo htmlspecialchars($item['description']); ?></p>
                            
                            <div class="timeline-footer">
                                <div class="status-indicator status-indicator--<?php echo $item['status']; ?>">
                                    <div class="status-dot"></div>
                                    <span class="status-text"><?php echo ucfirst(str_replace('-', ' ', $item['status'])); ?></span>
                                </div>
                                
                                <?php if ($item['status'] === 'completed'): ?>
                                <div class="completion-check" aria-label="Completed">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="20,6 9,17 4,12"/>
                                    </svg>
                                </div>
                                <?php elseif ($item['status'] === 'in-progress'): ?>
                                <div class="progress-spinner" aria-label="In progress">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="12" y1="2" x2="12" y2="6"/>
                                        <line x1="12" y1="18" x2="12" y2="22"/>
                                        <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"/>
                                        <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"/>
                                        <line x1="2" y1="12" x2="6" y2="12"/>
                                        <line x1="18" y1="12" x2="22" y2="12"/>
                                    </svg>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="timeline-progress">
            <div class="progress-bar">
                <div class="progress-fill" style="width: <?php echo $this->calculateProgress($timeline_items); ?>%"></div>
            </div>
            <div class="progress-text">
                <span><?php echo $this->calculateProgress($timeline_items); ?>% Complete</span>
                <span><?php echo $this->getCompletedCount($timeline_items); ?> of <?php echo count($timeline_items); ?> milestones</span>
            </div>
        </div>
    </div>
</section>

<style>
/* Base Styles */
.tusk-timeline {
    padding: 5rem 0;
    position: relative;
    overflow: hidden;
}

.timeline-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 2rem;
}

.timeline-header {
    text-align: center;
    margin-bottom: 4rem;
}

.timeline-title {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 800;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.timeline-subtitle {
    font-size: 1.2rem;
    opacity: 0.8;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.timeline-legend {
    display: flex;
    justify-content: center;
    gap: 2rem;
    flex-wrap: wrap;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    font-weight: 500;
}

.legend-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.legend-dot--completed { background: #2ecc71; }
.legend-dot--in-progress { background: #f39c12; animation: pulse 2s infinite; }
.legend-dot--upcoming { background: #95a5a6; }

/* Timeline Wrapper */
.timeline-wrapper {
    position: relative;
    padding: 2rem 0;
}

.timeline-line {
    position: absolute;
    left: 50%;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(to bottom, #e9ecef 0%, #3498db 50%, #e9ecef 100%);
    border-radius: 2px;
    transform: translateX(-50%);
    z-index: 1;
}

.tusk-timeline--horizontal .timeline-line {
    left: 0;
    right: 0;
    top: 50%;
    width: 100%;
    height: 4px;
    transform: translateY(-50%);
    background: linear-gradient(to right, #e9ecef 0%, #3498db 50%, #e9ecef 100%);
}

/* Timeline Items */
.timeline-items {
    position: relative;
    z-index: 2;
}

.tusk-timeline--horizontal .timeline-items {
    display: flex;
    gap: 2rem;
    overflow-x: auto;
    padding-bottom: 1rem;
}

.timeline-item {
    position: relative;
    margin-bottom: 3rem;
    opacity: 0.6;
    transition: opacity 0.3s ease;
}

.timeline-item--completed,
.timeline-item--in-progress {
    opacity: 1;
}

.tusk-timeline--horizontal .timeline-item {
    flex: 0 0 300px;
    margin-bottom: 0;
}

/* Timeline Marker */
.timeline-marker {
    position: absolute;
    left: 50%;
    top: 20px;
    transform: translateX(-50%);
    z-index: 3;
}

.tusk-timeline--horizontal .timeline-marker {
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
}

.marker-icon {
    position: relative;
    width: 60px;
    height: 60px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 4px solid #e9ecef;
    transition: all 0.3s ease;
    z-index: 2;
}

.timeline-item--completed .marker-icon {
    background: #2ecc71;
    border-color: #2ecc71;
    color: white;
    box-shadow: 0 0 20px rgba(46, 204, 113, 0.3);
}

.timeline-item--in-progress .marker-icon {
    background: #f39c12;
    border-color: #f39c12;
    color: white;
    box-shadow: 0 0 20px rgba(243, 156, 18, 0.3);
}

.timeline-item--upcoming .marker-icon {
    background: #95a5a6;
    border-color: #95a5a6;
    color: white;
}

.marker-icon svg {
    width: 24px;
    height: 24px;
}

.marker-ring {
    position: absolute;
    top: -4px;
    left: -4px;
    right: -4px;
    bottom: -4px;
    border: 2px solid transparent;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.timeline-item--in-progress .marker-ring {
    border-color: #f39c12;
    animation: rotate 2s linear infinite;
}

.marker-pulse {
    position: absolute;
    top: -8px;
    left: -8px;
    right: -8px;
    bottom: -8px;
    border: 2px solid transparent;
    border-radius: 50%;
    opacity: 0;
}

.timeline-item--in-progress .marker-pulse {
    border-color: #f39c12;
    animation: pulse 2s infinite;
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes pulse {
    0% { transform: scale(1); opacity: 0; }
    50% { transform: scale(1.2); opacity: 0.5; }
    100% { transform: scale(1.4); opacity: 0; }
}

/* Timeline Content */
.timeline-content {
    margin-left: calc(50% + 50px);
    max-width: 400px;
}

.timeline-item:nth-child(even) .timeline-content {
    margin-left: 0;
    margin-right: calc(50% + 50px);
    text-align: right;
}

.tusk-timeline--horizontal .timeline-content {
    margin-left: 0;
    margin-right: 0;
    margin-top: calc(50% + 50px);
    max-width: none;
    text-align: left;
}

.timeline-date {
    display: block;
    font-size: 0.9rem;
    font-weight: 600;
    color: #7f8c8d;
    margin-bottom: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.timeline-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.timeline-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #3498db, #e74c3c, #f39c12, #2ecc71);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.timeline-item:hover .timeline-card::before {
    transform: scaleX(1);
}

.timeline-item:hover .timeline-card {
    transform: translateY(-5px);
    box-shadow: 0 16px 48px rgba(0, 0, 0, 0.15);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
    gap: 1rem;
}

.timeline-item-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
    line-height: 1.3;
}

.timeline-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    flex-shrink: 0;
}

.timeline-badge--milestone {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
}

.timeline-badge--phase {
    background: linear-gradient(135deg, #9b59b6, #8e44ad);
    color: white;
}

.timeline-badge--development {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
}

.timeline-badge--testing {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
}

.timeline-description {
    color: #7f8c8d;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    font-size: 0.95rem;
}

.timeline-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.status-indicator {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    font-weight: 500;
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.status-indicator--completed .status-dot {
    background: #2ecc71;
}

.status-indicator--in-progress .status-dot {
    background: #f39c12;
    animation: pulse 2s infinite;
}

.status-indicator--upcoming .status-dot {
    background: #95a5a6;
}

.completion-check {
    color: #2ecc71;
}

.progress-spinner {
    color: #f39c12;
}

.progress-spinner svg {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Animated entrance */
.timeline-wrapper.animated .timeline-item {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.6s ease forwards;
}

.timeline-wrapper.animated .timeline-item:nth-child(1) { animation-delay: 0.1s; }
.timeline-wrapper.animated .timeline-item:nth-child(2) { animation-delay: 0.2s; }
.timeline-wrapper.animated .timeline-item:nth-child(3) { animation-delay: 0.3s; }
.timeline-wrapper.animated .timeline-item:nth-child(4) { animation-delay: 0.4s; }
.timeline-wrapper.animated .timeline-item:nth-child(5) { animation-delay: 0.5s; }
.timeline-wrapper.animated .timeline-item:nth-child(6) { animation-delay: 0.6s; }
.timeline-wrapper.animated .timeline-item:nth-child(7) { animation-delay: 0.7s; }

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Progress Bar */
.timeline-progress {
    margin-top: 3rem;
    text-align: center;
}

.progress-bar {
    height: 8px;
    background: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 1rem;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #2ecc71, #3498db);
    border-radius: 4px;
    transition: width 1s ease;
}

.progress-text {
    display: flex;
    justify-content: space-between;
    font-size: 0.9rem;
    color: #7f8c8d;
    font-weight: 500;
}

/* Theme Variants */
.tusk-timeline--default {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    color: #2c3e50;
}

.tusk-timeline--dark {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    color: white;
}

.tusk-timeline--dark .timeline-card {
    background: rgba(45, 45, 45, 0.95);
    border-color: rgba(255, 255, 255, 0.1);
}

.tusk-timeline--dark .timeline-item-title {
    color: white;
}

.tusk-timeline--dark .timeline-title {
    background: linear-gradient(135deg, #00ff88 0%, #00d4ff 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.tusk-timeline--minimal {
    background: #ffffff;
    color: #333333;
}

.tusk-timeline--minimal .timeline-card {
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
}

.tusk-timeline--gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.tusk-timeline--gradient .timeline-card {
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.2);
}

.tusk-timeline--gradient .timeline-item-title {
    color: white;
}

.tusk-timeline--neon {
    background: #0a0a0a;
    color: #00ff88;
}

.tusk-timeline--neon .timeline-card {
    background: rgba(0, 20, 40, 0.9);
    border: 1px solid #00ff88;
    box-shadow: 0 0 30px rgba(0, 255, 136, 0.2);
}

.tusk-timeline--neon .timeline-line {
    background: linear-gradient(to bottom, #00ff88 0%, #00d4ff 50%, #00ff88 100%);
    box-shadow: 0 0 20px rgba(0, 255, 136, 0.3);
}

.tusk-timeline--corporate {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: white;
}

.tusk-timeline--corporate .timeline-card {
    background: rgba(255, 255, 255, 0.1);
}

.tusk-timeline--corporate .timeline-item-title {
    color: white;
}

.tusk-timeline--warm {
    background: linear-gradient(135deg, #ff9a56 0%, #ffad56 100%);
    color: #2c3e50;
}

.tusk-timeline--cool {
    background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
    color: white;
}

.tusk-timeline--cool .timeline-card {
    background: rgba(255, 255, 255, 0.15);
}

.tusk-timeline--cool .timeline-item-title {
    color: white;
}

/* Responsive Design */
@media (max-width: 968px) {
    .timeline-container {
        padding: 0 1.5rem;
    }
    
    .timeline-legend {
        gap: 1rem;
    }
}

@media (max-width: 768px) {
    .tusk-timeline {
        padding: 3rem 0;
    }
    
    .timeline-header {
        margin-bottom: 2.5rem;
    }
    
    .timeline-line {
        left: 30px;
        transform: none;
    }
    
    .timeline-marker {
        left: 30px;
        transform: translateX(-50%);
    }
    
    .timeline-content {
        margin-left: 80px;
        max-width: none;
    }
    
    .timeline-item:nth-child(even) .timeline-content {
        margin-left: 80px;
        margin-right: 0;
        text-align: left;
    }
    
    .timeline-card {
        padding: 1.5rem;
    }
    
    .card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .marker-icon {
        width: 40px;
        height: 40px;
    }
    
    .marker-icon svg {
        width: 18px;
        height: 18px;
    }
}

@media (max-width: 480px) {
    .timeline-container {
        padding: 0 1rem;
    }
    
    .timeline-card {
        padding: 1rem;
    }
    
    .timeline-item-title {
        font-size: 1.2rem;
    }
    
    .timeline-legend {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .progress-text {
        flex-direction: column;
        gap: 0.5rem;
    }
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
    .timeline-item,
    .timeline-card,
    .marker-ring,
    .marker-pulse,
    .progress-spinner svg,
    .legend-dot--in-progress {
        animation: none;
        transition: none;
    }
    
    .timeline-wrapper.animated .timeline-item {
        animation: none;
        opacity: 1;
        transform: none;
    }
}

/* High contrast mode */
@media (prefers-contrast: high) {
    .timeline-card {
        border: 2px solid black;
    }
    
    .marker-icon {
        border-width: 3px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const timelines = document.querySelectorAll('.tusk-timeline');
    
    timelines.forEach(timeline => {
        const items = timeline.querySelectorAll('.timeline-item');
        const progressFill = timeline.querySelector('.progress-fill');
        
        // Animate progress bar on scroll
        const observerOptions = {
            threshold: 0.3,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Add entrance animations if not already animated
                    const wrapper = timeline.querySelector('.timeline-wrapper');
                    if (!wrapper.classList.contains('animated')) {
                        wrapper.classList.add('animated');
                    }
                    
                    // Animate progress bar
                    setTimeout(() => {
                        if (progressFill) {
                            const targetWidth = progressFill.style.width;
                            progressFill.style.width = '0%';
                            setTimeout(() => {
                                progressFill.style.width = targetWidth;
                            }, 100);
                        }
                    }, 500);
                }
            });
        }, observerOptions);
        
        observer.observe(timeline);
        
        // Add click handlers to timeline items
        items.forEach((item, index) => {
            item.addEventListener('click', () => {
                // Add click effect
                const card = item.querySelector('.timeline-card');
                card.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    card.style.transform = '';
                }, 150);
                
                // Trigger item interaction
                handleTimelineItemClick(item, index);
            });
            
            // Add keyboard support
            item.setAttribute('tabindex', '0');
            item.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    item.click();
                }
            });
            
            // Add hover effects
            item.addEventListener('mouseenter', () => {
                const marker = item.querySelector('.marker-icon');
                marker.style.transform = 'scale(1.1)';
            });
            
            item.addEventListener('mouseleave', () => {
                const marker = item.querySelector('.marker-icon');
                marker.style.transform = 'scale(1)';
            });
        });
        
        // Add scroll spy for horizontal timelines
        if (timeline.classList.contains('tusk-timeline--horizontal')) {
            const timelineItems = timeline.querySelector('.timeline-items');
            if (timelineItems) {
                timelineItems.addEventListener('scroll', handleHorizontalScroll);
            }
        }
    });
    
    function handleTimelineItemClick(item, index) {
        const title = item.querySelector('.timeline-item-title')?.textContent || 'Timeline Item';
        const description = item.querySelector('.timeline-description')?.textContent || '';
        const date = item.querySelector('.timeline-date')?.textContent || '';
        
        // Log interaction (replace with your analytics)
        console.log(`Timeline item clicked: ${index} - ${title}`);
        
        // Show detailed information
        if (window.TuskToast) {
            window.TuskToast.info(title, `${date}: ${description}`);
        } else {
            showTimelineModal(item, index);
        }
    }
    
    function handleHorizontalScroll(e) {
        const container = e.target;
        const items = container.querySelectorAll('.timeline-item');
        const containerRect = container.getBoundingClientRect();
        
        items.forEach(item => {
            const itemRect = item.getBoundingClientRect();
            const isVisible = itemRect.left >= containerRect.left && 
                             itemRect.right <= containerRect.right;
            
            if (isVisible) {
                item.style.opacity = '1';
                item.style.transform = 'scale(1)';
            } else {
                item.style.opacity = '0.7';
                item.style.transform = 'scale(0.95)';
            }
        });
    }
    
    function showTimelineModal(item, index) {
        // Simple modal implementation for demo
        const modal = document.createElement('div');
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            opacity: 0;
            transition: opacity 0.3s ease;
        `;
        
        const content = document.createElement('div');
        content.style.cssText = `
            background: white;
            padding: 2rem;
            border-radius: 12px;
            max-width: 500px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        `;
        
        const title = item.querySelector('.timeline-item-title')?.textContent || 'Timeline Item';
        const description = item.querySelector('.timeline-description')?.textContent || '';
        const date = item.querySelector('.timeline-date')?.textContent || '';
        const badge = item.querySelector('.timeline-badge')?.textContent || '';
        
        content.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <h3 style="margin: 0; color: #2c3e50; font-size: 1.5rem;">${title}</h3>
                <button onclick="this.closest('[style*=fixed]').remove()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #7f8c8d;">×</button>
            </div>
            <div style="margin-bottom: 1rem;">
                <span style="background: #3498db; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">${badge}</span>
            </div>
            <p style="color: #7f8c8d; margin-bottom: 1rem; font-weight: 500;">${date}</p>
            <p style="color: #5a6c7d; line-height: 1.6; margin: 0;">${description}</p>
        `;
        
        modal.appendChild(content);
        document.body.appendChild(modal);
        
        // Trigger animations
        requestAnimationFrame(() => {
            modal.style.opacity = '1';
            content.style.transform = 'scale(1)';
        });
        
        // Close on backdrop click
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.remove();
            }
        });
        
        // Close on escape key
        const handleEscape = (e) => {
            if (e.key === 'Escape') {
                modal.remove();
                document.removeEventListener('keydown', handleEscape);
            }
        };
        document.addEventListener('keydown', handleEscape);
    }
    
    // Auto-update progress based on completed items
    function updateTimelineProgress() {
        const timelines = document.querySelectorAll('.tusk-timeline');
        
        timelines.forEach(timeline => {
            const items = timeline.querySelectorAll('.timeline-item');
            const completedItems = timeline.querySelectorAll('.timeline-item--completed');
            const inProgressItems = timeline.querySelectorAll('.timeline-item--in-progress');
            const progressFill = timeline.querySelector('.progress-fill');
            const progressText = timeline.querySelector('.progress-text');
            
            if (progressFill && items.length > 0) {
                const completedCount = completedItems.length;
                const inProgressCount = inProgressItems.length;
                const totalCount = items.length;
                
                // Calculate progress (completed items + 50% for in-progress)
                const progress = ((completedCount + (inProgressCount * 0.5)) / totalCount) * 100;
                
                progressFill.style.width = progress + '%';
                
                if (progressText) {
                    const progressSpans = progressText.querySelectorAll('span');
                    if (progressSpans.length >= 2) {
                        progressSpans[0].textContent = Math.round(progress) + '% Complete';
                        progressSpans[1].textContent = completedCount + ' of ' + totalCount + ' milestones';
                    }
                }
            }
        });
    }
    
    // Initialize progress
    updateTimelineProgress();
    
    // Smooth scroll for horizontal timelines
    const horizontalTimelines = document.querySelectorAll('.tusk-timeline--horizontal .timeline-items');
    horizontalTimelines.forEach(container => {
        let isScrolling = false;
        
        container.addEventListener('wheel', (e) => {
            if (Math.abs(e.deltaX) > Math.abs(e.deltaY)) return;
            
            e.preventDefault();
            container.scrollLeft += e.deltaY;
        });
        
        // Add scroll indicators
        addScrollIndicators(container);
    });
    
    function addScrollIndicators(container) {
        const timeline = container.closest('.tusk-timeline');
        const wrapper = container.parentElement;
        
        // Left arrow
        const leftArrow = document.createElement('button');
        leftArrow.innerHTML = '‹';
        leftArrow.style.cssText = `
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            z-index: 10;
        `;
        
        // Right arrow
        const rightArrow = document.createElement('button');
        rightArrow.innerHTML = '›';
        rightArrow.style.cssText = leftArrow.style.cssText.replace('left: 10px', 'right: 10px');
        
        wrapper.style.position = 'relative';
        wrapper.appendChild(leftArrow);
        wrapper.appendChild(rightArrow);
        
        leftArrow.addEventListener('click', () => {
            container.scrollBy({ left: -300, behavior: 'smooth' });
        });
        
        rightArrow.addEventListener('click', () => {
            container.scrollBy({ left: 300, behavior: 'smooth' });
        });
        
        // Update arrow visibility
        function updateArrows() {
            leftArrow.style.opacity = container.scrollLeft > 0 ? '1' : '0.5';
            rightArrow.style.opacity = 
                container.scrollLeft < container.scrollWidth - container.clientWidth ? '1' : '0.5';
        }
        
        container.addEventListener('scroll', updateArrows);
        updateArrows();
    }
});
</script>

<?php
// Helper methods for timeline functionality
function getTimelineIcon($icon) {
    $icons = [
        'flag' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="2"/></svg>',
        'palette' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="13.5" cy="6.5" r=".5"/><circle cx="17.5" cy="10.5" r=".5"/><circle cx="8.5" cy="7.5" r=".5"/><circle cx="6.5" cy="12.5" r=".5"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>',
        'code' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16,18 22,12 16,6"/><polyline points="8,6 2,12 8,18"/></svg>',
        'monitor' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>',
        'check-circle' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>',
        'rocket' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="M12 15l-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/></svg>',
        'star' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>'
    ];
    
    return isset($icons[$icon]) ? $icons[$icon] : $icons['flag'];
}

function calculateProgress($items) {
    $completed = 0;
    $inProgress = 0;
    $total = count($items);
    
    foreach ($items as $item) {
        if ($item['status'] === 'completed') {
            $completed++;
        } elseif ($item['status'] === 'in-progress') {
            $inProgress++;
        }
    }
    
    // Calculate progress (completed + 50% for in-progress)
    $progress = (($completed + ($inProgress * 0.5)) / $total) * 100;
    return round($progress);
}

function getCompletedCount($items) {
    $completed = 0;
    foreach ($items as $item) {
        if ($item['status'] === 'completed') {
            $completed++;
        }
    }
    return $completed;
}

// Make helper methods accessible to the template
$this = new class {
    public function getTimelineIcon($icon) {
        return getTimelineIcon($icon);
    }
    
    public function calculateProgress($items) {
        return calculateProgress($items);
    }
    
    public function getCompletedCount($items) {
        return getCompletedCount($items);
    }
};
?>