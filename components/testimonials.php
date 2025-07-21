<?php
/**
 * <?tusk> Enhanced Testimonials Component
 * Created: 2025-06-26
 * Strong. Secure. Scalable. 🐘
 *
 * <?tusk> testimonials Component
 * Auto-Inclusion: [tusk-component-testimonials]
 * Themes: default, dark, minimal, gradient, neon, corporate, warm, cool
 */

// Theme and configuration
$theme = isset($theme) ? $theme : 'default';
$layout = isset($layout) ? $layout : 'grid'; // grid, masonry, slider
$show_ratings = isset($show_ratings) ? $show_ratings : true;
$show_avatars = isset($show_avatars) ? $show_avatars : true;
$animated = isset($animated) ? $animated : true;

// Testimonials data
$testimonials = isset($testimonials) ? $testimonials : [
    [
        'name' => 'Sarah Johnson',
        'role' => 'CEO, TechStart Inc.',
        'company' => 'TechStart Inc.',
        'avatar' => 'https://via.placeholder.com/80x80/3498db/ffffff?text=SJ',
        'rating' => 5,
        'text' => 'This platform has completely transformed how we manage our projects. The intuitive interface and powerful features have increased our team productivity by 40%. Highly recommended!',
        'featured' => true
    ],
    [
        'name' => 'Michael Chen',
        'role' => 'Lead Developer',
        'company' => 'CodeCraft Solutions',
        'avatar' => 'https://via.placeholder.com/80x80/e74c3c/ffffff?text=MC',
        'rating' => 5,
        'text' => 'Outstanding service and support. The development tools are top-notch and the documentation is comprehensive. Our development cycle has never been smoother.',
        'featured' => false
    ],
    [
        'name' => 'Emily Rodriguez',
        'role' => 'Marketing Director',
        'company' => 'Growth Marketing Co.',
        'avatar' => 'https://via.placeholder.com/80x80/2ecc71/ffffff?text=ER',
        'rating' => 5,
        'text' => 'The analytics and reporting features are incredible. We can now track our campaigns in real-time and make data-driven decisions faster than ever before.',
        'featured' => false
    ],
    [
        'name' => 'David Thompson',
        'role' => 'Product Manager',
        'company' => 'InnovateLab',
        'avatar' => 'https://via.placeholder.com/80x80/f39c12/ffffff?text=DT',
        'rating' => 5,
        'text' => 'Exceptional product with excellent customer support. The team is always responsive and helpful. This tool has become essential to our daily workflow.',
        'featured' => false
    ],
    [
        'name' => 'Lisa Wang',
        'role' => 'UX Designer',
        'company' => 'DesignHub Studio',
        'avatar' => 'https://via.placeholder.com/80x80/9b59b6/ffffff?text=LW',
        'rating' => 5,
        'text' => 'The user experience is phenomenal. Every detail has been carefully thought out. Our clients love the interface and our conversion rates have improved significantly.',
        'featured' => true
    ],
    [
        'name' => 'James Miller',
        'role' => 'Operations Manager',
        'company' => 'Streamline Ops',
        'avatar' => 'https://via.placeholder.com/80x80/1abc9c/ffffff?text=JM',
        'rating' => 4,
        'text' => 'Great platform that has streamlined our operations. The automation features save us hours every day. Minor room for improvement in mobile responsiveness.',
        'featured' => false
    ]
];
?>

<section class="tusk-testimonials tusk-testimonials--<?php echo $theme; ?> tusk-testimonials--<?php echo $layout; ?>" 
         role="region" 
         aria-label="Customer Testimonials">
    <div class="testimonials-container">
        <div class="testimonials-header">
            <h2 class="testimonials-title">What Our Customers Say</h2>
            <p class="testimonials-subtitle">Join thousands of satisfied customers who trust our platform</p>
            
            <div class="testimonials-stats">
                <div class="stat-item">
                    <div class="stat-number">4.9</div>
                    <div class="stat-stars">
                        <?php for($i = 0; $i < 5; $i++): ?>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                        </svg>
                        <?php endfor; ?>
                    </div>
                    <div class="stat-label">Average Rating</div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-number"><?php echo count($testimonials); ?>+</div>
                    <div class="stat-label">Happy Customers</div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-number">99%</div>
                    <div class="stat-label">Satisfaction Rate</div>
                </div>
            </div>
        </div>
        
        <div class="testimonials-grid<?php echo $animated ? ' animated' : ''; ?>">
            <?php foreach ($testimonials as $index => $testimonial): ?>
            <div class="testimonial-card <?php echo $testimonial['featured'] ? 'featured' : ''; ?>" 
                 data-index="<?php echo $index; ?>"
                 role="article"
                 aria-label="Testimonial from <?php echo htmlspecialchars($testimonial['name']); ?>">
                
                <?php if ($testimonial['featured']): ?>
                <div class="featured-badge" aria-label="Featured testimonial">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                    </svg>
                    Featured
                </div>
                <?php endif; ?>
                
                <div class="testimonial-content">
                    <div class="quote-icon" aria-hidden="true">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor" opacity="0.1">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z"/>
                        </svg>
                    </div>
                    
                    <?php if ($show_ratings): ?>
                    <div class="testimonial-rating" aria-label="Rating: <?php echo $testimonial['rating']; ?> out of 5 stars">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                        <svg width="16" height="16" viewBox="0 0 24 24" class="star <?php echo $i <= $testimonial['rating'] ? 'filled' : ''; ?>">
                            <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                        </svg>
                        <?php endfor; ?>
                    </div>
                    <?php endif; ?>
                    
                    <blockquote class="testimonial-text">
                        "<?php echo htmlspecialchars($testimonial['text']); ?>"
                    </blockquote>
                </div>
                
                <div class="testimonial-author">
                    <?php if ($show_avatars): ?>
                    <div class="author-avatar">
                        <img src="<?php echo htmlspecialchars($testimonial['avatar']); ?>" 
                             alt="Profile picture of <?php echo htmlspecialchars($testimonial['name']); ?>"
                             loading="lazy">
                        <div class="avatar-border"></div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="author-info">
                        <h4 class="author-name"><?php echo htmlspecialchars($testimonial['name']); ?></h4>
                        <p class="author-role"><?php echo htmlspecialchars($testimonial['role']); ?></p>
                        <p class="author-company"><?php echo htmlspecialchars($testimonial['company']); ?></p>
                    </div>
                    
                    <div class="verified-badge" aria-label="Verified customer">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22,4 12,14.01 9,11.01"/>
                        </svg>
                    </div>
                </div>
                
                <div class="card-glow"></div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="testimonials-cta">
            <h3>Ready to Join Them?</h3>
            <p>Start your journey with thousands of satisfied customers</p>
            <button class="cta-button">Get Started Today</button>
        </div>
    </div>
</section>

<!-- CSS styles moved to components/components.css -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const testimonialsSection = document.querySelectorAll('.tusk-testimonials');
    
    testimonialsSection.forEach(section => {
        const cards = section.querySelectorAll('.testimonial-card');
        const ctaButton = section.querySelector('.cta-button');
        const statNumbers = section.querySelectorAll('.stat-number');
        
        // Animate stats on scroll
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Add entrance animations if not already animated
                    const grid = section.querySelector('.testimonials-grid');
                    if (!grid.classList.contains('animated')) {
                        grid.classList.add('animated');
                    }
                    
                    // Animate stat numbers
                    statNumbers.forEach(stat => {
                        animateStatNumber(stat);
                    });
                }
            });
        }, observerOptions);
        
        observer.observe(section);
        
        // Add click handlers to testimonial cards
        cards.forEach((card, index) => {
            card.addEventListener('click', () => {
                handleTestimonialClick(card, index);
            });
            
            // Add keyboard support
            card.setAttribute('tabindex', '0');
            card.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    card.click();
                }
            });
            
            // Add interactive star rating on hover
            const stars = card.querySelectorAll('.star');
            stars.forEach((star, starIndex) => {
                star.addEventListener('mouseenter', () => {
                    highlightStars(stars, starIndex + 1);
                });
            });
            
            card.addEventListener('mouseleave', () => {
                resetStars(stars);
            });
        });
        
        // CTA button interaction
        if (ctaButton) {
            ctaButton.addEventListener('click', () => {
                // Add click ripple effect
                const ripple = document.createElement('div');
                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.6);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    pointer-events: none;
                `;
                
                const rect = ctaButton.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = '50%';
                ripple.style.top = '50%';
                ripple.style.marginLeft = ripple.style.marginTop = -(size / 2) + 'px';
                
                ctaButton.style.position = 'relative';
                ctaButton.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
                
                // Trigger CTA action
                handleCTAClick();
            });
        }
        
        // Auto-cycle featured testimonials
        cycleFeaturedTestimonials(section);
    });
    
    function handleTestimonialClick(card, index) {
        const name = card.querySelector('.author-name')?.textContent || 'Customer';
        const text = card.querySelector('.testimonial-text')?.textContent || '';
        const company = card.querySelector('.author-company')?.textContent || '';
        
        // Add pulse effect
        card.style.animation = 'testimonialPulse 0.6s ease';
        
        setTimeout(() => {
            card.style.animation = '';
        }, 600);
        
        // Log interaction (replace with your analytics)
        console.log(`Testimonial clicked: ${index} - ${name}`);
        
        // Show expanded testimonial
        if (window.TuskToast) {
            window.TuskToast.info(`${name} from ${company}`, text.replace(/"/g, ''));
        } else {
            showTestimonialModal(card, index);
        }
    }
    
    function animateStatNumber(element) {
        const text = element.textContent;
        const hasDecimal = text.includes('.');
        const hasPercent = text.includes('%');
        const hasPlus = text.includes('+');
        
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
            
            element.textContent = displayValue;
        }, 33);
    }
    
    function highlightStars(stars, rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.style.color = '#f39c12';
                star.style.transform = 'scale(1.1)';
            } else {
                star.style.color = '#e9ecef';
                star.style.transform = 'scale(1)';
            }
        });
    }
    
    function resetStars(stars) {
        stars.forEach(star => {
            star.style.transform = 'scale(1)';
            // Reset to original state based on filled class
            if (star.classList.contains('filled')) {
                star.style.color = '#f39c12';
            } else {
                star.style.color = '#e9ecef';
            }
        });
    }
    
    function handleCTAClick() {
        console.log('CTA clicked - Get Started Today');
        
        if (window.TuskToast) {
            window.TuskToast.success('Welcome!', 'Thank you for your interest! A team member will contact you soon.');
        } else {
            alert('Thank you for your interest! A team member will contact you soon.');
        }
    }
    
    function cycleFeaturedTestimonials(section) {
        const cards = section.querySelectorAll('.testimonial-card');
        let currentFeatured = 0;
        
        setInterval(() => {
            // Remove featured class from all cards
            cards.forEach(card => card.classList.remove('featured'));
            
            // Add featured class to next card
            currentFeatured = (currentFeatured + 1) % cards.length;
            cards[currentFeatured].classList.add('featured');
        }, 8000); // Change every 8 seconds
    }
    
    function showTestimonialModal(card, index) {
        // Implementation similar to timeline modal
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
            border-radius: 16px;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        `;
        
        const name = card.querySelector('.author-name')?.textContent || 'Customer';
        const role = card.querySelector('.author-role')?.textContent || '';
        const company = card.querySelector('.author-company')?.textContent || '';
        const text = card.querySelector('.testimonial-text')?.textContent || '';
        const avatar = card.querySelector('.author-avatar img')?.src || '';
        const rating = card.querySelectorAll('.star.filled').length;
        
        content.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <img src="${avatar}" alt="${name}" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                    <div>
                        <h3 style="margin: 0; color: #2c3e50; font-size: 1.3rem;">${name}</h3>
                        <p style="margin: 0; color: #7f8c8d; font-size: 0.9rem;">${role}</p>
                        <p style="margin: 0; color: #95a5a6; font-size: 0.85rem;">${company}</p>
                    </div>
                </div>
                <button onclick="this.closest('[style*=fixed]').remove()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #7f8c8d;">×</button>
            </div>
            <div style="display: flex; gap: 4px; margin-bottom: 1.5rem;">
                ${Array.from({length: 5}, (_, i) => `
                    <svg width="20" height="20" viewBox="0 0 24 24" style="color: ${i < rating ? '#f39c12' : '#e9ecef'};">
                        <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26" fill="currentColor"/>
                    </svg>
                `).join('')}
            </div>
            <blockquote style="font-size: 1.1rem; line-height: 1.7; color: #2c3e50; font-style: italic; margin: 0; border-left: 4px solid #3498db; padding-left: 1rem;">
                ${text}
            </blockquote>
        `;
        
        modal.appendChild(content);
        document.body.appendChild(modal);
        
        // Trigger animations
        requestAnimationFrame(() => {
            modal.style.opacity = '1';
            content.style.transform = 'scale(1)';
        });
        
        // Close handlers
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.remove();
            }
        });
        
        const handleEscape = (e) => {
            if (e.key === 'Escape') {
                modal.remove();
                document.removeEventListener('keydown', handleEscape);
            }
        };
        document.addEventListener('keydown', handleEscape);
    }
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
@keyframes testimonialPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.02); }
    100% { transform: scale(1); }
}

@keyframes ripple {
    to {
        transform: scale(4);
        opacity: 0;
    }
}
`;
document.head.appendChild(style);
</script>