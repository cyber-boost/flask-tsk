<?php
/**
 * <?tusk> Enhanced Testimonials Slider Component
 * Created: 2025-06-26
 * Strong. Secure. Scalable. 🐘
 *
 * <?tusk> testimonials-slider Component
 * Auto-Inclusion: [tusk-component-testimonials-slider]
 * Themes: default, dark, minimal, gradient, neon, corporate, warm, cool
 */

// Theme and configuration
$theme = isset($theme) ? $theme : 'default';
$autoplay = isset($autoplay) ? $autoplay : true;
$autoplay_delay = isset($autoplay_delay) ? $autoplay_delay : 5000;
$show_dots = isset($show_dots) ? $show_dots : true;
$show_arrows = isset($show_arrows) ? $show_arrows : true;
$slides_per_view = isset($slides_per_view) ? $slides_per_view : 1;
$infinite_loop = isset($infinite_loop) ? $infinite_loop : true;

// Enhanced testimonials data
$testimonials = isset($testimonials) ? $testimonials : [
    [
        'id' => 'testimonial-1',
        'name' => 'Sarah Mitchell',
        'role' => 'CEO & Founder',
        'company' => 'TechVision Inc.',
        'avatar' => 'https://via.placeholder.com/120x120/3498db/ffffff?text=SM',
        'rating' => 5,
        'text' => 'This platform has completely transformed our business operations. The intuitive interface, powerful features, and exceptional support have exceeded all our expectations. Our productivity has increased by 300% since implementation.',
        'featured' => true,
        'video_testimonial' => '#',
        'case_study' => '#',
        'industry' => 'Technology',
        'company_size' => '200+ employees',
        'use_case' => 'Enterprise Automation'
    ],
    [
        'id' => 'testimonial-2',
        'name' => 'Michael Rodriguez',
        'role' => 'Head of Operations',
        'company' => 'Global Logistics Pro',
        'avatar' => 'https://via.placeholder.com/120x120/e74c3c/ffffff?text=MR',
        'rating' => 5,
        'text' => 'Outstanding service and incredible results! The implementation was seamless, and the ROI was visible within the first month. Our team efficiency has improved dramatically, and customer satisfaction scores have reached all-time highs.',
        'featured' => false,
        'video_testimonial' => null,
        'case_study' => '#',
        'industry' => 'Logistics',
        'company_size' => '500+ employees',
        'use_case' => 'Supply Chain Management'
    ],
    [
        'id' => 'testimonial-3',
        'name' => 'Dr. Emily Chen',
        'role' => 'Research Director',
        'company' => 'Medical Innovations Lab',
        'avatar' => 'https://via.placeholder.com/120x120/2ecc71/ffffff?text=EC',
        'rating' => 5,
        'text' => 'The level of customization and flexibility is remarkable. We were able to adapt the platform to our specific research workflows without any compromise. The data insights have been invaluable for our decision-making process.',
        'featured' => true,
        'video_testimonial' => '#',
        'case_study' => null,
        'industry' => 'Healthcare',
        'company_size' => '50-100 employees',
        'use_case' => 'Research Analytics'
    ],
    [
        'id' => 'testimonial-4',
        'name' => 'James Anderson',
        'role' => 'Creative Director',
        'company' => 'Design Studio Collective',
        'avatar' => 'https://via.placeholder.com/120x120/f39c12/ffffff?text=JA',
        'rating' => 5,
        'text' => 'As a creative agency, we needed a solution that could keep up with our fast-paced environment. This platform not only met our needs but exceeded them. The collaboration features are game-changing for our team.',
        'featured' => false,
        'video_testimonial' => null,
        'case_study' => '#',
        'industry' => 'Creative Services',
        'company_size' => '20-50 employees',
        'use_case' => 'Project Collaboration'
    ],
    [
        'id' => 'testimonial-5',
        'name' => 'Anna Kowalski',
        'role' => 'VP of Marketing',
        'company' => 'GrowthHacker Solutions',
        'avatar' => 'https://via.placeholder.com/120x120/9b59b6/ffffff?text=AK',
        'rating' => 5,
        'text' => 'The analytics and reporting capabilities are phenomenal. We can now track campaign performance in real-time and make data-driven decisions instantly. Our marketing ROI has improved by 250% since we started using this platform.',
        'featured' => false,
        'video_testimonial' => '#',
        'case_study' => '#',
        'industry' => 'Marketing',
        'company_size' => '100-200 employees',
        'use_case' => 'Marketing Analytics'
    ],
    [
        'id' => 'testimonial-6',
        'name' => 'Robert Taylor',
        'role' => 'CTO',
        'company' => 'FinTech Innovations',
        'avatar' => 'https://via.placeholder.com/120x120/1abc9c/ffffff?text=RT',
        'rating' => 5,
        'text' => 'Security and compliance were our top priorities, and this platform delivered beyond expectations. The enterprise-grade security features and audit trails give us complete confidence in our operations.',
        'featured' => true,
        'video_testimonial' => null,
        'case_study' => '#',
        'industry' => 'Financial Services',
        'company_size' => '1000+ employees',
        'use_case' => 'Financial Operations'
    ]
];
?>

<section class="tusk-testimonials-slider tusk-testimonials-slider--<?php echo $theme; ?>" 
         role="region" 
         aria-label="Customer Testimonials Slider">
    <div class="slider-container">
        <div class="slider-header">
            <h2 class="slider-title">What Our Customers Say</h2>
            <p class="slider-subtitle">Real stories from real customers who trust our platform</p>
            
            <div class="testimonial-stats">
                <div class="stat-item">
                    <div class="stat-icon">⭐</div>
                    <div class="stat-content">
                        <span class="stat-number">4.9</span>
                        <span class="stat-label">Average Rating</span>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">👥</div>
                    <div class="stat-content">
                        <span class="stat-number"><?php echo count($testimonials); ?>K+</span>
                        <span class="stat-label">Happy Customers</span>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">🏆</div>
                    <div class="stat-content">
                        <span class="stat-number">99%</span>
                        <span class="stat-label">Satisfaction Rate</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="testimonials-slider-wrapper" 
             data-autoplay="<?php echo $autoplay ? 'true' : 'false'; ?>"
             data-autoplay-delay="<?php echo $autoplay_delay; ?>"
             data-slides-per-view="<?php echo $slides_per_view; ?>"
             data-infinite-loop="<?php echo $infinite_loop ? 'true' : 'false'; ?>">
            
            <div class="slider-track">
                <?php foreach ($testimonials as $index => $testimonial): ?>
                <div class="testimonial-slide <?php echo $testimonial['featured'] ? 'featured' : ''; ?>" 
                     data-slide="<?php echo $index; ?>"
                     role="article"
                     aria-label="Testimonial from <?php echo htmlspecialchars($testimonial['name']); ?>">
                    
                    <div class="testimonial-card">
                        <?php if ($testimonial['featured']): ?>
                        <div class="featured-badge" aria-label="Featured testimonial">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                            </svg>
                            Featured
                        </div>
                        <?php endif; ?>
                        
                        <div class="quote-section">
                            <div class="quote-mark" aria-hidden="true">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor" opacity="0.1">
                                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z"/>
                                </svg>
                            </div>
                            
                            <div class="testimonial-rating" aria-label="Rating: <?php echo $testimonial['rating']; ?> out of 5 stars">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                <svg width="20" height="20" viewBox="0 0 24 24" class="star <?php echo $i <= $testimonial['rating'] ? 'filled' : ''; ?>">
                                    <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                                </svg>
                                <?php endfor; ?>
                            </div>
                            
                            <blockquote class="testimonial-text">
                                "<?php echo htmlspecialchars($testimonial['text']); ?>"
                            </blockquote>
                        </div>
                        
                        <div class="author-section">
                            <div class="author-avatar">
                                <img src="<?php echo htmlspecialchars($testimonial['avatar']); ?>" 
                                     alt="Profile picture of <?php echo htmlspecialchars($testimonial['name']); ?>"
                                     loading="lazy">
                                <div class="avatar-ring"></div>
                            </div>
                            
                            <div class="author-info">
                                <h4 class="author-name"><?php echo htmlspecialchars($testimonial['name']); ?></h4>
                                <p class="author-role"><?php echo htmlspecialchars($testimonial['role']); ?></p>
                                <p class="author-company"><?php echo htmlspecialchars($testimonial['company']); ?></p>
                            </div>
                            
                            <div class="verification-badge" aria-label="Verified customer">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                    <polyline points="22,4 12,14.01 9,11.01"/>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="testimonial-meta">
                            <div class="meta-item">
                                <span class="meta-label">Industry:</span>
                                <span class="meta-value"><?php echo htmlspecialchars($testimonial['industry']); ?></span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Company Size:</span>
                                <span class="meta-value"><?php echo htmlspecialchars($testimonial['company_size']); ?></span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Use Case:</span>
                                <span class="meta-value"><?php echo htmlspecialchars($testimonial['use_case']); ?></span>
                            </div>
                        </div>
                        
                        <div class="testimonial-actions">
                            <?php if ($testimonial['video_testimonial']): ?>
                            <button class="action-btn video-btn" data-video="<?php echo htmlspecialchars($testimonial['video_testimonial']); ?>">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polygon points="5,3 19,12 5,21"/>
                                </svg>
                                Watch Video
                            </button>
                            <?php endif; ?>
                            
                            <?php if ($testimonial['case_study']): ?>
                            <button class="action-btn case-study-btn" data-case-study="<?php echo htmlspecialchars($testimonial['case_study']); ?>">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14,2 14,8 20,8"/>
                                    <line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/>
                                    <polyline points="10,9 9,9 8,9"/>
                                </svg>
                                Case Study
                            </button>
                            <?php endif; ?>
                        </div>
                        
                        <div class="card-glow"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <?php if ($show_arrows): ?>
            <button class="slider-arrow slider-arrow--prev" aria-label="Previous testimonial">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15,18 9,12 15,6"/>
                </svg>
            </button>
            
            <button class="slider-arrow slider-arrow--next" aria-label="Next testimonial">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9,18 15,12 9,6"/>
                </svg>
            </button>
            <?php endif; ?>
            
            <?php if ($show_dots): ?>
            <div class="slider-dots" role="tablist" aria-label="Testimonial navigation">
                <?php foreach ($testimonials as $index => $testimonial): ?>
                <button class="dot <?php echo $index === 0 ? 'active' : ''; ?>" 
                        role="tab"
                        aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                        aria-label="Go to testimonial <?php echo $index + 1; ?>"
                        data-slide="<?php echo $index; ?>">
                </button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="slider-controls">
            <button class="control-btn play-pause-btn" aria-label="Play/Pause slideshow">
                <svg class="play-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="5,3 19,12 5,21"/>
                </svg>
                <svg class="pause-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                    <rect x="6" y="4" width="4" height="16"/>
                    <rect x="14" y="4" width="4" height="16"/>
                </svg>
            </button>
            
            <div class="progress-bar">
                <div class="progress-fill"></div>
            </div>
            
            <div class="slide-counter">
                <span class="current-slide">1</span>
                <span class="separator">/</span>
                <span class="total-slides"><?php echo count($testimonials); ?></span>
            </div>
        </div>
    </div>
</section>

<style>
/* Base Styles */
.tusk-testimonials-slider {
    padding: 5rem 0;
    position: relative;
    overflow: hidden;
}

.slider-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

.slider-header {
    text-align: center;
    margin-bottom: 4rem;
}

.slider-title {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 800;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.slider-subtitle {
    font-size: 1.2rem;
    opacity: 0.8;
    margin-bottom: 3rem;
    line-height: 1.6;
}

.testimonial-stats {
    display: flex;
    justify-content: center;
    gap: 3rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-icon {
    font-size: 2rem;
    filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
}

.stat-number {
    font-size: 2rem;
    font-weight: 800;
    color: #2c3e50;
    line-height: 1;
    margin-bottom: 0.25rem;
    display: block;
}

.stat-label {
    font-size: 0.9rem;
    color: #7f8c8d;
    font-weight: 500;
    display: block;
}

/* Slider Wrapper */
.testimonials-slider-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 24px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
}

.slider-track {
    display: flex;
    transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.testimonial-slide {
    flex: 0 0 100%;
    padding: 3rem;
}

/* Testimonial Cards */
.testimonial-card {
    position: relative;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 20px;
    padding: 3rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    overflow: hidden;
    transition: all 0.4s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.testimonial-slide.featured .testimonial-card {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border: 2px solid rgba(102, 126, 234, 0.3);
}

.featured-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 12px rgba(243, 156, 18, 0.3);
    animation: featuredPulse 2s infinite;
}

@keyframes featuredPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.quote-section {
    margin-bottom: 2.5rem;
    position: relative;
}

.quote-mark {
    position: absolute;
    top: -20px;
    left: -10px;
    z-index: 1;
}

.testimonial-rating {
    display: flex;
    gap: 4px;
    margin-bottom: 1.5rem;
    justify-content: center;
    z-index: 2;
    position: relative;
}

.star {
    color: #e9ecef;
    transition: all 0.3s ease;
}

.star.filled {
    color: #f39c12;
    transform: scale(1.1);
}

.testimonial-text {
    font-size: 1.3rem;
    line-height: 1.7;
    color: #2c3e50;
    font-style: italic;
    text-align: center;
    margin: 0;
    position: relative;
    z-index: 2;
    font-weight: 500;
}

.author-section {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: rgba(255, 255, 255, 0.5);
    border-radius: 16px;
    backdrop-filter: blur(5px);
}

.author-avatar {
    position: relative;
    flex-shrink: 0;
}

.author-avatar img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid white;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.testimonial-card:hover .author-avatar img {
    transform: scale(1.1);
}

.avatar-ring {
    position: absolute;
    top: -4px;
    left: -4px;
    right: -4px;
    bottom: -4px;
    border: 3px solid transparent;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    mask-composite: exclude;
    opacity: 0;
    transition: opacity 0.3s ease;
    animation: rotate 3s linear infinite;
}

.testimonial-card:hover .avatar-ring {
    opacity: 1;
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.author-info {
    flex: 1;
}

.author-name {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0 0 0.5rem 0;
}

.author-role {
    font-size: 1rem;
    color: #3498db;
    font-weight: 600;
    margin: 0 0 0.25rem 0;
}

.author-company {
    font-size: 0.9rem;
    color: #7f8c8d;
    margin: 0;
}

.verification-badge {
    flex-shrink: 0;
    color: #2ecc71;
    background: rgba(46, 204, 113, 0.1);
    padding: 12px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: verifiedPulse 2s infinite;
}

@keyframes verifiedPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.testimonial-meta {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: rgba(52, 152, 219, 0.05);
    border-radius: 12px;
    border: 1px solid rgba(52, 152, 219, 0.1);
}

.meta-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.meta-label {
    font-size: 0.8rem;
    color: #7f8c8d;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.meta-value {
    font-size: 0.95rem;
    color: #2c3e50;
    font-weight: 500;
}

.testimonial-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: 2px solid transparent;
    border-radius: 25px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    font-size: 0.9rem;
}

.video-btn {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    border-color: transparent;
}

.video-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(231, 76, 60, 0.3);
}

.case-study-btn {
    background: transparent;
    color: #3498db;
    border-color: #3498db;
}

.case-study-btn:hover {
    background: #3498db;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(52, 152, 219, 0.3);
}

.card-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
    border-radius: 50%;
    transform: translate(-50%, -50%) scale(0);
    transition: transform 0.4s ease;
    pointer-events: none;
}

.testimonial-card:hover .card-glow {
    transform: translate(-50%, -50%) scale(1.5);
}

/* Slider Navigation */
.slider-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.9);
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    z-index: 10;
    color: #2c3e50;
}

.slider-arrow:hover {
    background: white;
    border-color: #3498db;
    color: #3498db;
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 8px 25px rgba(52, 152, 219, 0.2);
}

.slider-arrow--prev {
    left: 20px;
}

.slider-arrow--next {
    right: 20px;
}

.slider-dots {
    display: flex;
    justify-content: center;
    gap: 1rem;
    padding: 2rem;
    background: rgba(255, 255, 255, 0.5);
    backdrop-filter: blur(5px);
}

.dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #e9ecef;
    background: transparent;
    cursor: pointer;
    transition: all 0.3s ease;
}

.dot.active,
.dot:hover {
    background: #3498db;
    border-color: #3498db;
    transform: scale(1.2);
}

.slider-controls {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 2rem;
    padding: 1.5rem;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    border-top: 1px solid rgba(255, 255, 255, 0.3);
}

.control-btn {
    width: 40px;
    height: 40px;
    background: transparent;
    border: 2px solid #e9ecef;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #7f8c8d;
}

.control-btn:hover {
    border-color: #3498db;
    color: #3498db;
    transform: scale(1.1);
}

.progress-bar {
    flex: 1;
    height: 6px;
    background: #e9ecef;
    border-radius: 3px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #3498db, #2980b9);
    border-radius: 3px;
    transition: width 0.3s ease;
    width: 0%;
}

.slide-counter {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: #2c3e50;
}

.separator {
    color: #7f8c8d;
}

/* Theme Variants */
.tusk-testimonials-slider--default {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    color: #2c3e50;
}

.tusk-testimonials-slider--dark {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    color: white;
}

.tusk-testimonials-slider--dark .testimonials-slider-wrapper {
    background: rgba(45, 45, 45, 0.95);
    border-color: rgba(255, 255, 255, 0.1);
}

.tusk-testimonials-slider--dark .testimonial-card {
    background: rgba(30, 30, 30, 0.9);
    border-color: rgba(255, 255, 255, 0.1);
}

.tusk-testimonials-slider--dark .testimonial-text,
.tusk-testimonials-slider--dark .author-name,
.tusk-testimonials-slider--dark .stat-number,
.tusk-testimonials-slider--dark .meta-value {
    color: white;
}

.tusk-testimonials-slider--dark .slider-title {
    background: linear-gradient(135deg, #00ff88 0%, #00d4ff 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.tusk-testimonials-slider--minimal {
    background: #ffffff;
    color: #333333;
}

.tusk-testimonials-slider--minimal .testimonials-slider-wrapper {
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
}

.tusk-testimonials-slider--gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.tusk-testimonials-slider--gradient .testimonials-slider-wrapper {
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.2);
}

.tusk-testimonials-slider--gradient .testimonial-card {
    background: rgba(255, 255, 255, 0.1);
}

.tusk-testimonials-slider--gradient .testimonial-text,
.tusk-testimonials-slider--gradient .author-name,
.tusk-testimonials-slider--gradient .stat-number,
.tusk-testimonials-slider--gradient .meta-value {
    color: white;
}

.tusk-testimonials-slider--neon {
    background: #0a0a0a;
    color: #00ff88;
}

.tusk-testimonials-slider--neon .testimonials-slider-wrapper {
    background: rgba(0, 20, 40, 0.9);
    border: 1px solid #00ff88;
    box-shadow: 0 0 40px rgba(0, 255, 136, 0.2);
}

.tusk-testimonials-slider--neon .testimonial-card {
    background: rgba(0, 10, 20, 0.8);
    border: 1px solid rgba(0, 255, 136, 0.3);
}

.tusk-testimonials-slider--neon .featured-badge {
    background: linear-gradient(135deg, #00ff88, #00d4ff);
}

.tusk-testimonials-slider--corporate {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: white;
}

.tusk-testimonials-slider--corporate .testimonials-slider-wrapper {
    background: rgba(255, 255, 255, 0.1);
}

.tusk-testimonials-slider--corporate .testimonial-card {
    background: rgba(255, 255, 255, 0.05);
}

.tusk-testimonials-slider--corporate .testimonial-text,
.tusk-testimonials-slider--corporate .author-name,
.tusk-testimonials-slider--corporate .stat-number,
.tusk-testimonials-slider--corporate .meta-value {
    color: white;
}

.tusk-testimonials-slider--warm {
    background: linear-gradient(135deg, #ff9a56 0%, #ffad56 100%);
    color: #2c3e50;
}

.tusk-testimonials-slider--cool {
    background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
    color: white;
}

.tusk-testimonials-slider--cool .testimonials-slider-wrapper {
    background: rgba(255, 255, 255, 0.15);
}

.tusk-testimonials-slider--cool .testimonial-card {
    background: rgba(255, 255, 255, 0.1);
}

.tusk-testimonials-slider--cool .testimonial-text,
.tusk-testimonials-slider--cool .author-name,
.tusk-testimonials-slider--cool .stat-number,
.tusk-testimonials-slider--cool .meta-value {
    color: white;
}

/* Responsive Design */
@media (max-width: 968px) {
    .slider-container {
        padding: 0 1.5rem;
    }
    
    .testimonial-stats {
        gap: 2rem;
    }
    
    .slider-arrow {
        width: 50px;
        height: 50px;
    }
    
    .slider-arrow--prev {
        left: 10px;
    }
    
    .slider-arrow--next {
        right: 10px;
    }
}

@media (max-width: 768px) {
    .tusk-testimonials-slider {
        padding: 3rem 0;
    }
    
    .slider-header {
        margin-bottom: 2.5rem;
    }
    
    .testimonial-stats {
        flex-direction: column;
        gap: 1.5rem;
        align-items: center;
    }
    
    .stat-number {
        font-size: 1.5rem;
    }
    
    .testimonial-slide {
        padding: 2rem;
    }
    
    .testimonial-card {
        padding: 2rem;
    }
    
    .testimonial-text {
        font-size: 1.1rem;
    }
    
    .author-section {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .author-avatar img {
        width: 60px;
        height: 60px;
    }
    
    .testimonial-meta {
        grid-template-columns: 1fr;
    }
    
    .slider-controls {
        flex-direction: column;
        gap: 1rem;
    }
    
    .progress-bar {
        order: 1;
    }
    
    .control-btn {
        order: 2;
    }
    
    .slide-counter {
        order: 3;
    }
}

@media (max-width: 480px) {
    .slider-container {
        padding: 0 1rem;
    }
    
    .testimonial-slide {
        padding: 1.5rem;
    }
    
    .testimonial-card {
        padding: 1.5rem;
    }
    
    .featured-badge {
        top: 10px;
        right: 10px;
        padding: 0.35rem 0.75rem;
        font-size: 0.7rem;
    }
    
    .testimonial-text {
        font-size: 1rem;
    }
    
    .author-name {
        font-size: 1.1rem;
    }
    
    .action-btn {
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
    }
    
    .slider-arrow {
        display: none;
    }
    
    .slider-dots {
        padding: 1rem;
        gap: 0.5rem;
    }
    
    .dot {
        width: 10px;
        height: 10px;
    }
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
    .slider-track,
    .testimonial-card,
    .author-avatar img,
    .card-glow,
    .slider-arrow,
    .control-btn,
    .featured-badge,
    .avatar-ring,
    .verification-badge {
        animation: none;
        transition: none;
    }
}

/* High contrast mode */
@media (prefers-contrast: high) {
    .testimonials-slider-wrapper {
        border: 2px solid black;
    }
    
    .testimonial-card {
        border: 2px solid black;
    }
    
    .action-btn,
    .slider-arrow,
    .control-btn {
        border: 2px solid black;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sliders = document.querySelectorAll('.tusk-testimonials-slider');
    
    sliders.forEach(slider => {
        const wrapper = slider.querySelector('.testimonials-slider-wrapper');
        const track = slider.querySelector('.slider-track');
        const slides = slider.querySelectorAll('.testimonial-slide');
        const dots = slider.querySelectorAll('.dot');
        const prevBtn = slider.querySelector('.slider-arrow--prev');
        const nextBtn = slider.querySelector('.slider-arrow--next');
        const playPauseBtn = slider.querySelector('.play-pause-btn');
        const progressFill = slider.querySelector('.progress-fill');
        const currentSlideSpan = slider.querySelector('.current-slide');
        const totalSlidesSpan = slider.querySelector('.total-slides');
        const actionBtns = slider.querySelectorAll('.action-btn');
        
        // Configuration
        const autoplay = wrapper.dataset.autoplay === 'true';
        const autoplayDelay = parseInt(wrapper.dataset.autoplayDelay) || 5000;
        const slidesPerView = parseInt(wrapper.dataset.slidesPerView) || 1;
        const infiniteLoop = wrapper.dataset.infiniteLoop === 'true';
        
        // State
        let currentSlide = 0;
        let isPlaying = autoplay;
        let autoplayTimer = null;
        let progressTimer = null;
        
        // Initialize slider
        initializeSlider();
        
        function initializeSlider() {
            // Set initial state
            updateSlidePosition();
            updateDots();
            updateCounter();
            updateButtons();
            
            // Set up autoplay
            if (isPlaying) {
                startAutoplay();
            }
            
            // Event listeners
            setupEventListeners();
            
            // Initialize stats animation
            animateStats();
        }
        
        function setupEventListeners() {
            // Arrow navigation
            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    previousSlide();
                });
            }
            
            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    nextSlide();
                });
            }
            
            // Dot navigation
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    goToSlide(index);
                });
            });
            
            // Play/Pause control
            if (playPauseBtn) {
                playPauseBtn.addEventListener('click', () => {
                    togglePlayPause();
                });
            }
            
            // Action buttons
            actionBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    handleActionClick(btn);
                });
            });
            
            // Keyboard navigation
            slider.addEventListener('keydown', (e) => {
                switch (e.key) {
                    case 'ArrowLeft':
                        e.preventDefault();
                        previousSlide();
                        break;
                    case 'ArrowRight':
                        e.preventDefault();
                        nextSlide();
                        break;
                    case ' ':
                        e.preventDefault();
                        togglePlayPause();
                        break;
                    case 'Home':
                        e.preventDefault();
                        goToSlide(0);
                        break;
                    case 'End':
                        e.preventDefault();
                        goToSlide(slides.length - 1);
                        break;
                }
            });
            
            // Touch/swipe support
            let startX = 0;
            let startY = 0;
            let isDragging = false;
            
            track.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                startY = e.touches[0].clientY;
                isDragging = true;
                pauseAutoplay();
            });
            
            track.addEventListener('touchmove', (e) => {
                if (!isDragging) return;
                e.preventDefault();
            });
            
            track.addEventListener('touchend', (e) => {
                if (!isDragging) return;
                
                const endX = e.changedTouches[0].clientX;
                const endY = e.changedTouches[0].clientY;
                const deltaX = startX - endX;
                const deltaY = startY - endY;
                
                // Only handle horizontal swipes
                if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 50) {
                    if (deltaX > 0) {
                        nextSlide();
                    } else {
                        previousSlide();
                    }
                }
                
                isDragging = false;
                if (isPlaying) {
                    startAutoplay();
                }
            });
            
            // Pause on hover
            wrapper.addEventListener('mouseenter', () => {
                pauseAutoplay();
            });
            
            wrapper.addEventListener('mouseleave', () => {
                if (isPlaying) {
                    startAutoplay();
                }
            });
            
            // Pause when page is not visible
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    pauseAutoplay();
                } else if (isPlaying) {
                    startAutoplay();
                }
            });
        }
        
        function nextSlide() {
            if (currentSlide < slides.length - 1) {
                currentSlide++;
            } else if (infiniteLoop) {
                currentSlide = 0;
            }
            
            updateSlider();
            logSlideChange('next');
        }
        
        function previousSlide() {
            if (currentSlide > 0) {
                currentSlide--;
            } else if (infiniteLoop) {
                currentSlide = slides.length - 1;
            }
            
            updateSlider();
            logSlideChange('previous');
        }
        
        function goToSlide(index) {
            if (index >= 0 && index < slides.length && index !== currentSlide) {
                currentSlide = index;
                updateSlider();
                logSlideChange('direct');
            }
        }
        
        function updateSlider() {
            updateSlidePosition();
            updateDots();
            updateCounter();
            updateButtons();
            resetProgress();
        }
        
        function updateSlidePosition() {
            const translateX = -currentSlide * 100;
            track.style.transform = `translateX(${translateX}%)`;
        }
        
        function updateDots() {
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide);
                dot.setAttribute('aria-selected', index === currentSlide ? 'true' : 'false');
            });
        }
        
        function updateCounter() {
            if (currentSlideSpan) {
                currentSlideSpan.textContent = currentSlide + 1;
            }
            if (totalSlidesSpan) {
                totalSlidesSpan.textContent = slides.length;
            }
        }
        
        function updateButtons() {
            if (prevBtn) {
                prevBtn.style.opacity = (!infiniteLoop && currentSlide === 0) ? '0.5' : '1';
                prevBtn.disabled = !infiniteLoop && currentSlide === 0;
            }
            
            if (nextBtn) {
                nextBtn.style.opacity = (!infiniteLoop && currentSlide === slides.length - 1) ? '0.5' : '1';
                nextBtn.disabled = !infiniteLoop && currentSlide === slides.length - 1;
            }
        }
        
        function startAutoplay() {
            if (!isPlaying) return;
            
            stopAutoplay();
            
            autoplayTimer = setTimeout(() => {
                nextSlide();
                if (isPlaying) {
                    startAutoplay();
                }
            }, autoplayDelay);
            
            startProgress();
        }
        
        function stopAutoplay() {
            if (autoplayTimer) {
                clearTimeout(autoplayTimer);
                autoplayTimer = null;
            }
            stopProgress();
        }
        
        function pauseAutoplay() {
            stopAutoplay();
        }
        
        function togglePlayPause() {
            isPlaying = !isPlaying;
            
            const playIcon = playPauseBtn.querySelector('.play-icon');
            const pauseIcon = playPauseBtn.querySelector('.pause-icon');
            
            if (isPlaying) {
                playIcon.style.display = 'none';
                pauseIcon.style.display = 'block';
                startAutoplay();
            } else {
                playIcon.style.display = 'block';
                pauseIcon.style.display = 'none';
                stopAutoplay();
            }
            
            playPauseBtn.setAttribute('aria-label', isPlaying ? 'Pause slideshow' : 'Play slideshow');
        }
        
        function startProgress() {
            if (!progressFill) return;
            
            progressFill.style.width = '0%';
            progressFill.style.transition = `width ${autoplayDelay}ms linear`;
            
            // Force reflow
            progressFill.offsetWidth;
            
            progressFill.style.width = '100%';
        }
        
        function stopProgress() {
            if (!progressFill) return;
            
            progressFill.style.transition = 'none';
            progressFill.style.width = '0%';
        }
        
        function resetProgress() {
            stopProgress();
            if (isPlaying) {
                setTimeout(() => {
                    startProgress();
                }, 100);
            }
        }
        
        function handleActionClick(btn) {
            const action = btn.classList.contains('video-btn') ? 'video' : 'case-study';
            const slideData = slides[currentSlide];
            const testimonialData = getTestimonialData(slideData);
            
            // Add click effect
            btn.style.transform = 'scale(0.95)';
            setTimeout(() => {
                btn.style.transform = '';
            }, 150);
            
            // Log interaction
            console.log(`${action} clicked for: ${testimonialData.name}`);
            
            // Handle action
            if (action === 'video') {
                if (window.TuskToast) {
                    window.TuskToast.info('Video Testimonial', `Playing video testimonial from ${testimonialData.name}`);
                } else {
                    alert(`Playing video testimonial from ${testimonialData.name}`);
                }
            } else {
                if (window.TuskToast) {
                    window.TuskToast.info('Case Study', `Opening case study for ${testimonialData.company}`);
                } else {
                    alert(`Opening case study for ${testimonialData.company}`);
                }
            }
        }
        
        function getTestimonialData(slideElement) {
            return {
                name: slideElement.querySelector('.author-name')?.textContent || 'Customer',
                company: slideElement.querySelector('.author-company')?.textContent || 'Company',
                role: slideElement.querySelector('.author-role')?.textContent || 'Role'
            };
        }
        
        function animateStats() {
            const statNumbers = slider.querySelectorAll('.stat-number');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        statNumbers.forEach(stat => {
                            animateStatNumber(stat);
                        });
                    }
                });
            }, { threshold: 0.5 });
            
            observer.observe(slider);
        }
        
        function animateStatNumber(element) {
            const text = element.textContent;
            const hasDecimal = text.includes('.');
            const hasPercent = text.includes('%');
            const hasPlus = text.includes('+');
            const hasK = text.includes('K');
            
            let targetValue;
            if (hasDecimal) {
                targetValue = parseFloat(text.replace(/[^\d.]/g, ''));
            } else {
                targetValue = parseInt(text.replace(/[^\d]/g, ''));
            }
            
            if (isNaN(targetValue)) return;
            
            let currentValue = 0;
            const increment = targetValue / 60;
            const timer = setInterval(() => {
                currentValue += increment;
                if (currentValue >= targetValue) {
                    currentValue = targetValue;
                    clearInterval(timer);
                }
                
                let displayValue;
                if (hasDecimal) {
                    displayValue = currentValue.toFixed(1);
                } else {
                    displayValue = Math.floor(currentValue);
                }
                
                if (hasPercent) displayValue += '%';
                if (hasPlus) displayValue += '+';
                if (hasK) displayValue += 'K';
                
                element.textContent = displayValue;
            }, 33);
        }
        
        function logSlideChange(method) {
            const slideData = getTestimonialData(slides[currentSlide]);
            console.log(`Slide changed (${method}): ${currentSlide + 1}/${slides.length} - ${slideData.name}`);
            
            // Trigger custom event
            slider.dispatchEvent(new CustomEvent('slideChange', {
                detail: {
                    currentSlide,
                    totalSlides: slides.length,
                    method,
                    testimonial: slideData
                }
            }));
        }
        
        // Initialize play/pause button state
        if (playPauseBtn) {
            const playIcon = playPauseBtn.querySelector('.play-icon');
            const pauseIcon = playPauseBtn.querySelector('.pause-icon');
            
            if (isPlaying) {
                playIcon.style.display = 'none';
                pauseIcon.style.display = 'block';
            } else {
                playIcon.style.display = 'block';
                pauseIcon.style.display = 'none';
            }
        }
    });
});
</script>