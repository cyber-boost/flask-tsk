<?php
/**
 * Testimonials Alternative 1 - Video Testimonials
 * ============================================
 * Interactive video testimonials with play/pause functionality
 * Perfect for showcasing authentic customer stories
 */

$theme = $_SESSION['theme'] ?? $config['theme'] ?? 'tusk_modern';
$testimonials = $testimonials ?? [
    [
        'name' => 'Sarah Johnson',
        'title' => 'CEO, TechStart Inc.',
        'company' => 'TechStart Inc.',
        'avatar' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=150&h=150&fit=crop&crop=face',
        'video_poster' => 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=400&h=300&fit=crop',
        'video_url' => '#video1',
        'testimonial' => 'This platform transformed our business operations completely. We saw a 300% increase in productivity within the first month. The team support is exceptional.',
        'rating' => 5,
        'featured' => true
    ],
    [
        'name' => 'Michael Chen',
        'title' => 'Head of Marketing',
        'company' => 'Growth Labs',
        'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face',
        'video_poster' => 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=400&h=300&fit=crop',
        'video_url' => '#video2',
        'testimonial' => 'The analytics and insights we get are incredible. It\'s like having a crystal ball for our marketing campaigns. ROI improved by 150%.',
        'rating' => 5,
        'featured' => false
    ],
    [
        'name' => 'Emily Rodriguez',
        'title' => 'Product Manager',
        'company' => 'InnovateCorp',
        'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop&crop=face',
        'video_poster' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=400&h=300&fit=crop',
        'video_url' => '#video3',
        'testimonial' => 'Implementation was seamless, and the learning curve was surprisingly gentle. Our entire team was productive from day one.',
        'rating' => 5,
        'featured' => false
    ],
    [
        'name' => 'David Kim',
        'title' => 'CTO',
        'company' => 'DataFlow Systems',
        'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face',
        'video_poster' => 'https://images.unsplash.com/photo-1559136555-9303baea8ebd?w=400&h=300&fit=crop',
        'video_url' => '#video4',
        'testimonial' => 'Security and reliability are top-notch. We\'ve had zero downtime in 18 months. The API integration was flawless.',
        'rating' => 5,
        'featured' => false
    ]
];
?>

<section class="tusk-testimonials-alt-1" id="tusk-testimonials-alt-1">
    <div class="testimonials-container">
        <!-- Header -->
        <div class="testimonials-header">
            <h2 class="testimonials-title">What Our Customers Say</h2>
            <p class="testimonials-subtitle">Real stories from real customers who transformed their business</p>
        </div>

        <!-- Featured Testimonial -->
        <?php $featured = array_filter($testimonials, fn($t) => $t['featured'])[0] ?? $testimonials[0]; ?>
        <div class="featured-testimonial">
            <div class="featured-content">
                <div class="video-section">
                    <div class="video-container">
                        <img src="<?= $featured['video_poster'] ?>" alt="Video testimonial" class="video-poster">
                        <button class="play-button" data-video="<?= $featured['video_url'] ?>">
                            <svg class="play-icon" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M8 5V19L19 12L8 5Z" fill="currentColor"/>
                            </svg>
                        </button>
                        <div class="video-overlay">
                            <div class="video-length">2:15</div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-content">
                    <div class="quote-mark">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none">
                            <path d="M14.017 21V14.391C14.017 11.485 15.658 9.583 18.598 9.583C21.143 9.583 23 11.507 23 14.391V21H14.017ZM0 21V14.391C0 11.485 1.641 9.583 4.581 9.583C7.126 9.583 8.983 11.507 8.983 14.391V21H0Z" fill="currentColor"/>
                        </svg>
                    </div>
                    <blockquote class="testimonial-text">
                        <?= htmlspecialchars($featured['testimonial']) ?>
                    </blockquote>
                    <div class="testimonial-author">
                        <img src="<?= $featured['avatar'] ?>" alt="<?= htmlspecialchars($featured['name']) ?>" class="author-avatar">
                        <div class="author-info">
                            <h4 class="author-name"><?= htmlspecialchars($featured['name']) ?></h4>
                            <p class="author-title"><?= htmlspecialchars($featured['title']) ?></p>
                            <p class="author-company"><?= htmlspecialchars($featured['company']) ?></p>
                            <div class="rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <svg class="star <?= $i <= $featured['rating'] ? 'filled' : '' ?>" width="16" height="16" viewBox="0 0 24 24" fill="none">
                                        <path d="M12 2L15.09 8.26L22 9L16 14.74L17.18 21.02L12 18.77L6.82 21.02L8 14.74L2 9L8.91 8.26L12 2Z" fill="currentColor"/>
                                    </svg>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testimonial Grid -->
        <div class="testimonials-grid">
            <?php foreach ($testimonials as $index => $testimonial): ?>
                <?php if ($testimonial['featured']) continue; ?>
                <div class="testimonial-card" data-index="<?= $index ?>">
                    <div class="card-header">
                        <div class="video-preview">
                            <img src="<?= $testimonial['video_poster'] ?>" alt="Video preview" class="preview-image">
                            <button class="mini-play-button" data-video="<?= $testimonial['video_url'] ?>">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                    <path d="M8 5V19L19 12L8 5Z" fill="currentColor"/>
                                </svg>
                            </button>
                        </div>
                        <div class="card-author">
                            <img src="<?= $testimonial['avatar'] ?>" alt="<?= htmlspecialchars($testimonial['name']) ?>" class="card-avatar">
                            <div class="card-author-info">
                                <h4 class="card-author-name"><?= htmlspecialchars($testimonial['name']) ?></h4>
                                <p class="card-author-title"><?= htmlspecialchars($testimonial['title']) ?></p>
                                <div class="card-rating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <svg class="star <?= $i <= $testimonial['rating'] ? 'filled' : '' ?>" width="12" height="12" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 2L15.09 8.26L22 9L16 14.74L17.18 21.02L12 18.77L6.82 21.02L8 14.74L2 9L8.91 8.26L12 2Z" fill="currentColor"/>
                                        </svg>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <p class="card-testimonial">
                            <?= strlen($testimonial['testimonial']) > 120 ? 
                                htmlspecialchars(substr($testimonial['testimonial'], 0, 120)) . '...' : 
                                htmlspecialchars($testimonial['testimonial']) ?>
                        </p>
                        <button class="read-more-btn">Read Full Story</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Stats Section -->
        <div class="stats-section">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">10,000+</div>
                    <div class="stat-label">Happy Customers</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">4.9/5</div>
                    <div class="stat-label">Average Rating</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">99.9%</div>
                    <div class="stat-label">Uptime</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Support</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Video Modal -->
    <div class="video-modal" id="videoModal" style="display: none;">
        <div class="modal-backdrop"></div>
        <div class="modal-content">
            <button class="modal-close">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
            <div class="modal-video">
                <iframe src="" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</section>

<style>
.tusk-testimonials-alt-1 {
    padding: 4rem 1rem;
    background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary, #f8fafc) 100%);
    min-height: 100vh;
}

.testimonials-container {
    max-width: 1200px;
    margin: 0 auto;
    width: 100%;
}

.testimonials-header {
    text-align: center;
    margin-bottom: 4rem;
}

.testimonials-title {
    font-size: 3rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 1rem;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.testimonials-subtitle {
    font-size: 1.2rem;
    color: var(--text-secondary);
    margin-bottom: 2rem;
}

.featured-testimonial {
    background: var(--bg-primary);
    border-radius: 20px;
    padding: 3rem;
    margin-bottom: 4rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border: 1px solid var(--border-color);
}

.featured-content {
    display: grid;
    grid-template-columns: 1fr 1.5fr;
    gap: 3rem;
    align-items: center;
}

.video-section {
    position: relative;
}

.video-container {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    aspect-ratio: 16/9;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.video-poster {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.video-container:hover .video-poster {
    transform: scale(1.05);
}

.play-button {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border: none;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
}

.play-button:hover {
    transform: translate(-50%, -50%) scale(1.1);
    box-shadow: 0 6px 20px rgba(0,0,0,0.4);
}

.play-icon {
    margin-left: 4px;
}

.video-overlay {
    position: absolute;
    bottom: 1rem;
    right: 1rem;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    font-size: 0.875rem;
}

.testimonial-content {
    position: relative;
}

.quote-mark {
    color: var(--primary-color);
    opacity: 0.3;
    margin-bottom: 1rem;
}

.testimonial-text {
    font-size: 1.5rem;
    line-height: 1.6;
    color: var(--text-primary);
    font-style: italic;
    margin-bottom: 2rem;
    quotes: none;
}

.testimonial-author {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.author-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--primary-color);
}

.author-name {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.author-title,
.author-company {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.rating {
    display: flex;
    gap: 0.25rem;
    margin-top: 0.5rem;
}

.star {
    color: var(--border-color);
}

.star.filled {
    color: #fbbf24;
}

.testimonials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 4rem;
}

.testimonial-card {
    background: var(--bg-primary);
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    cursor: pointer;
}

.testimonial-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    border-color: var(--primary-color);
}

.card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.video-preview {
    position: relative;
    width: 80px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
}

.preview-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.mini-play-button {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: rgba(255,255,255,0.9);
    border: none;
    color: var(--primary-color);
    cursor: pointer;
    transition: all 0.3s ease;
}

.mini-play-button:hover {
    background: white;
    transform: translate(-50%, -50%) scale(1.1);
}

.card-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--primary-color);
}

.card-author-name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.card-author-title {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
}

.card-rating {
    display: flex;
    gap: 0.125rem;
}

.card-testimonial {
    color: var(--text-primary);
    line-height: 1.6;
    margin-bottom: 1rem;
}

.read-more-btn {
    background: none;
    border: none;
    color: var(--primary-color);
    cursor: pointer;
    font-weight: 500;
    font-size: 0.875rem;
    transition: color 0.3s ease;
}

.read-more-btn:hover {
    color: var(--secondary-color);
}

.stats-section {
    background: var(--bg-primary);
    border-radius: 16px;
    padding: 3rem;
    border: 1px solid var(--border-color);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    text-align: center;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

.stat-label {
    color: var(--text-secondary);
    font-weight: 500;
}

.video-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1000;
}

.modal-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.8);
    backdrop-filter: blur(4px);
}

.modal-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 90%;
    max-width: 800px;
    aspect-ratio: 16/9;
    background: black;
    border-radius: 12px;
    overflow: hidden;
}

.modal-close {
    position: absolute;
    top: -40px;
    right: 0;
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 50%;
    transition: background-color 0.3s ease;
}

.modal-close:hover {
    background: rgba(255,255,255,0.1);
}

.modal-video {
    width: 100%;
    height: 100%;
}

.modal-video iframe {
    width: 100%;
    height: 100%;
}

@media (max-width: 768px) {
    .testimonials-title {
        font-size: 2rem;
    }
    
    .featured-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .featured-testimonial {
        padding: 2rem;
    }
    
    .testimonial-text {
        font-size: 1.2rem;
    }
    
    .testimonials-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .modal-content {
        width: 95%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('videoModal');
    const modalIframe = modal.querySelector('iframe');
    const modalClose = modal.querySelector('.modal-close');
    const modalBackdrop = modal.querySelector('.modal-backdrop');
    
    // Play button handlers
    document.querySelectorAll('.play-button, .mini-play-button').forEach(button => {
        button.addEventListener('click', function() {
            const videoUrl = this.dataset.video;
            // In a real implementation, you would use actual video URLs
            // For demo purposes, we'll use a placeholder
            modalIframe.src = 'https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1';
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        });
    });
    
    // Close modal handlers
    function closeModal() {
        modal.style.display = 'none';
        modalIframe.src = '';
        document.body.style.overflow = 'auto';
    }
    
    modalClose.addEventListener('click', closeModal);
    modalBackdrop.addEventListener('click', closeModal);
    
    // Escape key to close
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display === 'block') {
            closeModal();
        }
    });
    
    // Read more functionality
    document.querySelectorAll('.read-more-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const card = this.closest('.testimonial-card');
            const index = card.dataset.index;
            // In a real implementation, you would show a modal with full testimonial
            alert('Show full testimonial for customer ' + (parseInt(index) + 1));
        });
    });
    
    // Card click handlers
    document.querySelectorAll('.testimonial-card').forEach(card => {
        card.addEventListener('click', function() {
            const playButton = this.querySelector('.mini-play-button');
            if (playButton) {
                playButton.click();
            }
        });
    });
    
    // Stats animation on scroll
    const observerOptions = {
        threshold: 0.5,
        once: true
    };
    
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const statNumbers = entry.target.querySelectorAll('.stat-number');
                statNumbers.forEach(stat => {
                    stat.style.opacity = '0';
                    stat.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        stat.style.transition = 'all 0.6s ease';
                        stat.style.opacity = '1';
                        stat.style.transform = 'translateY(0)';
                    }, Math.random() * 200);
                });
            }
        });
    }, observerOptions);
    
    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        statsObserver.observe(statsSection);
    }
});
</script>