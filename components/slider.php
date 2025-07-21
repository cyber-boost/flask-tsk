<?php
/**
 * <?tusk> Enhanced Slider Component
 * Created: 2025-06-26
 * Strong. Secure. Scalable. 🐘
 *
 * <?tusk> slider Component
 * Auto-Inclusion: [tusk-component-slider]
 * Themes: default, dark, minimal, gradient, neon, corporate, warm, cool
 */

$theme = isset($theme) ? $theme : 'default';
$autoplay = isset($autoplay) ? $autoplay : true;
$autoplay_delay = isset($autoplay_delay) ? $autoplay_delay : 5000;
$show_dots = isset($show_dots) ? $show_dots : true;
$show_arrows = isset($show_arrows) ? $show_arrows : true;
$infinite_loop = isset($infinite_loop) ? $infinite_loop : true;

$slides = isset($slides) ? $slides : [
    [
        'id' => 'slide-1',
        'title' => 'Innovation at Its Best',
        'subtitle' => 'Transform Your Business',
        'description' => 'Discover cutting-edge solutions that drive growth and efficiency in the digital age.',
        'image' => 'https://via.placeholder.com/1200x600/3498db/ffffff?text=Innovation',
        'cta_text' => 'Get Started',
        'cta_url' => '#',
        'background_color' => '#3498db'
    ],
    [
        'id' => 'slide-2',
        'title' => 'Expert Team',
        'subtitle' => 'Professional Excellence',
        'description' => 'Work with industry experts who understand your challenges and deliver exceptional results.',
        'image' => 'https://via.placeholder.com/1200x600/e74c3c/ffffff?text=Expert+Team',
        'cta_text' => 'Meet Our Team',
        'cta_url' => '#',
        'background_color' => '#e74c3c'
    ],
    [
        'id' => 'slide-3',
        'title' => 'Global Reach',
        'subtitle' => 'Worldwide Solutions',
        'description' => 'Connect with customers worldwide through our comprehensive global platform and services.',
        'image' => 'https://via.placeholder.com/1200x600/2ecc71/ffffff?text=Global+Reach',
        'cta_text' => 'Explore Services',
        'cta_url' => '#',
        'background_color' => '#2ecc71'
    ],
    [
        'id' => 'slide-4',
        'title' => '24/7 Support',
        'subtitle' => 'Always Available',
        'description' => 'Get round-the-clock support from our dedicated team to ensure your success.',
        'image' => 'https://via.placeholder.com/1200x600/f39c12/ffffff?text=24/7+Support',
        'cta_text' => 'Contact Support',
        'cta_url' => '#',
        'background_color' => '#f39c12'
    ]
];
?>

<section class="tusk-slider tusk-slider--<?php echo $theme; ?>" 
         role="region" 
         aria-label="Image Slider">
    <div class="slider-wrapper" 
         data-autoplay="<?php echo $autoplay ? 'true' : 'false'; ?>"
         data-autoplay-delay="<?php echo $autoplay_delay; ?>"
         data-infinite-loop="<?php echo $infinite_loop ? 'true' : 'false'; ?>">
        
        <div class="slider-container">
            <div class="slider-track">
                <?php foreach ($slides as $index => $slide): ?>
                <div class="slider-slide <?php echo $index === 0 ? 'active' : ''; ?>" 
                     data-slide="<?php echo $index; ?>"
                     style="background: linear-gradient(135deg, <?php echo $slide['background_color']; ?>dd, <?php echo $slide['background_color']; ?>aa);">
                    
                    <div class="slide-background">
                        <img src="<?php echo htmlspecialchars($slide['image']); ?>" 
                             alt="<?php echo htmlspecialchars($slide['title']); ?>"
                             loading="lazy">
                        <div class="slide-overlay"></div>
                    </div>
                    
                    <div class="slide-content">
                        <div class="content-wrapper">
                            <div class="slide-subtitle"><?php echo htmlspecialchars($slide['subtitle']); ?></div>
                            <h2 class="slide-title"><?php echo htmlspecialchars($slide['title']); ?></h2>
                            <p class="slide-description"><?php echo htmlspecialchars($slide['description']); ?></p>
                            
                            <div class="slide-actions">
                                <a href="<?php echo htmlspecialchars($slide['cta_url']); ?>" 
                                   class="slide-cta">
                                    <?php echo htmlspecialchars($slide['cta_text']); ?>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="5" y1="12" x2="19" y2="12"/>
                                        <polyline points="12,5 19,12 12,19"/>
                                    </svg>
                                </a>
                                
                                <button class="slide-play" data-slide="<?php echo $index; ?>">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polygon points="5,3 19,12 5,21"/>
                                    </svg>
                                    Watch Video
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <?php if ($show_arrows): ?>
        <button class="slider-arrow slider-arrow--prev" aria-label="Previous slide">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15,18 9,12 15,6"/>
            </svg>
        </button>
        
        <button class="slider-arrow slider-arrow--next" aria-label="Next slide">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9,18 15,12 9,6"/>
            </svg>
        </button>
        <?php endif; ?>
        
        <?php if ($show_dots): ?>
        <div class="slider-dots" role="tablist" aria-label="Slide navigation">
            <?php foreach ($slides as $index => $slide): ?>
            <button class="slider-dot <?php echo $index === 0 ? 'active' : ''; ?>" 
                    role="tab"
                    aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                    aria-label="Go to slide <?php echo $index + 1; ?>"
                    data-slide="<?php echo $index; ?>">
            </button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <div class="slider-controls">
            <button class="control-btn play-pause-btn" aria-label="Play/Pause slideshow">
                <svg class="play-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="5,3 19,12 5,21"/>
                </svg>
                <svg class="pause-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                    <rect x="6" y="4" width="4" height="16"/>
                    <rect x="14" y="4" width="4" height="16"/>
                </svg>
            </button>
            
            <div class="slide-counter">
                <span class="current-slide">1</span>
                <span class="separator">/</span>
                <span class="total-slides"><?php echo count($slides); ?></span>
            </div>
            
            <div class="progress-bar">
                <div class="progress-fill"></div>
            </div>
        </div>
    </div>
</section>

<style>
/* Base Styles */
.tusk-slider {
    position: relative;
    width: 100%;
    height: 100vh;
    min-height: 600px;
    overflow: hidden;
}

.slider-wrapper {
    position: relative;
    width: 100%;
    height: 100%;
}

.slider-container {
    position: relative;
    width: 100%;
    height: 100%;
}

.slider-track {
    position: relative;
    width: 100%;
    height: 100%;
}

/* Slides */
.slider-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    visibility: hidden;
    transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.slider-slide.active {
    opacity: 1;
    visibility: visible;
    z-index: 2;
}

.slide-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.slide-background img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 8s ease-out;
}

.slider-slide.active .slide-background img {
    transform: scale(1.1);
}

.slide-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.2) 100%);
}

.slide-content {
    position: relative;
    z-index: 3;
    width: 100%;
    max-width: 1200px;
    padding: 0 2rem;
    text-align: center;
}

.content-wrapper {
    transform: translateY(30px);
    opacity: 0;
    transition: all 0.8s ease 0.3s;
}

.slider-slide.active .content-wrapper {
    transform: translateY(0);
    opacity: 1;
}

.slide-subtitle {
    font-size: 1.2rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 1rem;
    color: rgba(255, 255, 255, 0.9);
}

.slide-title {
    font-size: clamp(2.5rem, 6vw, 4rem);
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 1.5rem;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.slide-description {
    font-size: 1.3rem;
    line-height: 1.6;
    margin-bottom: 3rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    color: rgba(255, 255, 255, 0.9);
}

.slide-actions {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
}

.slide-cta {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2.5rem;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1.1rem;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
}

.slide-cta:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.slide-play {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2rem;
    background: transparent;
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.5);
    border-radius: 50px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(5px);
}

.slide-play:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: white;
    transform: translateY(-2px);
}

/* Navigation Arrows */
.slider-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
}

.slider-arrow:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.6);
    transform: translateY(-50%) scale(1.1);
}

.slider-arrow--prev {
    left: 2rem;
}

.slider-arrow--next {
    right: 2rem;
}

/* Dots Navigation */
.slider-dots {
    position: absolute;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 1rem;
    z-index: 10;
}

.slider-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.4);
    border: 2px solid rgba(255, 255, 255, 0.6);
    cursor: pointer;
    transition: all 0.3s ease;
}

.slider-dot.active,
.slider-dot:hover {
    background: white;
    transform: scale(1.2);
}

/* Controls */
.slider-controls {
    position: absolute;
    top: 2rem;
    right: 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    background: rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(10px);
    border-radius: 25px;
    padding: 0.75rem 1.5rem;
    z-index: 10;
}

.control-btn {
    width: 32px;
    height: 32px;
    background: transparent;
    border: none;
    color: white;
    cursor: pointer;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.control-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: scale(1.1);
}

.slide-counter {
    color: white;
    font-size: 0.9rem;
    font-weight: 500;
}

.separator {
    color: rgba(255, 255, 255, 0.6);
    margin: 0 0.25rem;
}

.progress-bar {
    width: 60px;
    height: 4px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 2px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: white;
    border-radius: 2px;
    transition: width 0.3s ease;
    width: 0%;
}

/* Theme Variants */
.tusk-slider--default {
    background: #f8f9fa;
}

.tusk-slider--dark .slider-controls {
    background: rgba(255, 255, 255, 0.1);
}

.tusk-slider--minimal .slide-overlay {
    background: linear-gradient(45deg, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.1) 100%);
}

.tusk-slider--gradient .slide-overlay {
    background: linear-gradient(45deg, rgba(102, 126, 234, 0.3) 0%, rgba(118, 75, 162, 0.3) 100%);
}

.tusk-slider--neon .slide-overlay {
    background: linear-gradient(45deg, rgba(0, 255, 136, 0.2) 0%, rgba(0, 212, 255, 0.2) 100%);
}

.tusk-slider--neon .slider-arrow,
.tusk-slider--neon .slider-controls {
    border-color: #00ff88;
    box-shadow: 0 0 20px rgba(0, 255, 136, 0.3);
}

.tusk-slider--corporate .slide-overlay {
    background: linear-gradient(45deg, rgba(30, 60, 114, 0.4) 0%, rgba(42, 82, 152, 0.4) 100%);
}

.tusk-slider--warm .slide-overlay {
    background: linear-gradient(45deg, rgba(255, 154, 86, 0.3) 0%, rgba(255, 173, 86, 0.3) 100%);
}

.tusk-slider--cool .slide-overlay {
    background: linear-gradient(45deg, rgba(116, 185, 255, 0.3) 0%, rgba(9, 132, 227, 0.3) 100%);
}

/* Responsive Design */
@media (max-width: 968px) {
    .tusk-slider {
        min-height: 500px;
    }
    
    .slide-content {
        padding: 0 1.5rem;
    }
    
    .slide-actions {
        flex-direction: column;
        gap: 1rem;
    }
    
    .slider-arrow {
        width: 50px;
        height: 50px;
    }
    
    .slider-arrow--prev {
        left: 1rem;
    }
    
    .slider-arrow--next {
        right: 1rem;
    }
}

@media (max-width: 768px) {
    .tusk-slider {
        min-height: 400px;
    }
    
    .slide-content {
        padding: 0 1rem;
    }
    
    .slide-subtitle {
        font-size: 1rem;
    }
    
    .slide-description {
        font-size: 1.1rem;
        margin-bottom: 2rem;
    }
    
    .slider-controls {
        top: 1rem;
        right: 1rem;
        padding: 0.5rem 1rem;
    }
    
    .slider-dots {
        bottom: 1rem;
        gap: 0.75rem;
    }
    
    .slider-dot {
        width: 10px;
        height: 10px;
    }
}

@media (max-width: 480px) {
    .slide-cta,
    .slide-play {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
    }
    
    .slider-arrow {
        width: 40px;
        height: 40px;
    }
    
    .slider-controls {
        flex-direction: column;
        gap: 0.5rem;
        align-items: center;
    }
    
    .progress-bar {
        width: 40px;
    }
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
    .slider-slide,
    .content-wrapper,
    .slide-background img,
    .slider-arrow,
    .slider-dot,
    .control-btn {
        transition: none;
        animation: none;
    }
}

/* High contrast mode */
@media (prefers-contrast: high) {
    .slider-arrow,
    .slider-controls {
        border: 2px solid black;
        background: white;
        color: black;
    }
    
    .slider-dot {
        border: 2px solid black;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sliders = document.querySelectorAll('.tusk-slider');
    
    sliders.forEach(slider => {
        const wrapper = slider.querySelector('.slider-wrapper');
        const slides = slider.querySelectorAll('.slider-slide');
        const dots = slider.querySelectorAll('.slider-dot');
        const prevBtn = slider.querySelector('.slider-arrow--prev');
        const nextBtn = slider.querySelector('.slider-arrow--next');
        const playPauseBtn = slider.querySelector('.play-pause-btn');
        const progressFill = slider.querySelector('.progress-fill');
        const currentSlideSpan = slider.querySelector('.current-slide');
        const totalSlidesSpan = slider.querySelector('.total-slides');
        const playBtns = slider.querySelectorAll('.slide-play');
        const ctaBtns = slider.querySelectorAll('.slide-cta');
        
        // Configuration
        const autoplay = wrapper.dataset.autoplay === 'true';
        const autoplayDelay = parseInt(wrapper.dataset.autoplayDelay) || 5000;
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
            updateSlider();
            updateCounter();
            
            // Set up autoplay
            if (isPlaying) {
                startAutoplay();
            }
            
            // Event listeners
            setupEventListeners();
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
            
            // Play buttons
            playBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    handlePlayClick(btn);
                });
            });
            
            // CTA buttons
            ctaBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    handleCTAClick(btn, e);
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
            
            slider.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                startY = e.touches[0].clientY;
                isDragging = true;
                pauseAutoplay();
            });
            
            slider.addEventListener('touchmove', (e) => {
                if (!isDragging) return;
                e.preventDefault();
            });
            
            slider.addEventListener('touchend', (e) => {
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
            slider.addEventListener('mouseenter', () => {
                pauseAutoplay();
            });
            
            slider.addEventListener('mouseleave', () => {
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
            // Update slides
            slides.forEach((slide, index) => {
                slide.classList.toggle('active', index === currentSlide);
            });
            
            // Update dots
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide);
                dot.setAttribute('aria-selected', index === currentSlide ? 'true' : 'false');
            });
            
            updateCounter();
            resetProgress();
        }
        
        function updateCounter() {
            if (currentSlideSpan) {
                currentSlideSpan.textContent = currentSlide + 1;
            }
            if (totalSlidesSpan) {
                totalSlidesSpan.textContent = slides.length;
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
        
        function handlePlayClick(btn) {
            const slideIndex = parseInt(btn.dataset.slide);
            
            // Add click effect
            btn.style.transform = 'scale(0.95)';
            setTimeout(() => {
                btn.style.transform = '';
            }, 150);
            
            // Log interaction
            console.log(`Play button clicked for slide: ${slideIndex}`);
            
            // Show video modal or play action
            if (window.TuskToast) {
                window.TuskToast.info('Video', 'Playing video content...');
            } else {
                alert('Playing video content...');
            }
        }
        
        function handleCTAClick(btn, e) {
            // Log interaction
            const slideIndex = currentSlide;
            const ctaText = btn.textContent.trim();
            
            console.log(`CTA clicked: "${ctaText}" on slide ${slideIndex}`);
            
            // Send analytics event
            if (typeof gtag !== 'undefined') {
                gtag('event', 'slider_cta_click', {
                    'slide_index': slideIndex,
                    'cta_text': ctaText,
                    'slide_title': slides[slideIndex].querySelector('.slide-title')?.textContent || ''
                });
            }
        }
        
        function logSlideChange(method) {
            console.log(`Slide changed (${method}): ${currentSlide + 1}/${slides.length}`);
            
            // Send analytics event
            if (typeof gtag !== 'undefined') {
                gtag('event', 'slider_slide_change', {
                    'slide_index': currentSlide,
                    'method': method,
                    'slide_title': slides[currentSlide].querySelector('.slide-title')?.textContent || ''
                });
            }
            
            // Trigger custom event
            slider.dispatchEvent(new CustomEvent('slideChange', {
                detail: {
                    currentSlide,
                    totalSlides: slides.length,
                    method
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
        
        // Preload next images for performance
        function preloadImages() {
            slides.forEach((slide, index) => {
                if (index !== currentSlide) {
                    const img = slide.querySelector('img');
                    if (img && !img.complete) {
                        const preloadImg = new Image();
                        preloadImg.src = img.src;
                    }
                }
            });
        }
        
        preloadImages();
        
        // Intersection Observer for performance
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    if (!isPlaying && autoplay) {
                        isPlaying = true;
                        startAutoplay();
                    }
                } else {
                    if (isPlaying) {
                        pauseAutoplay();
                    }
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(slider);
    });
});
</script>