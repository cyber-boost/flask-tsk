<?php
/**
 * Testimonials Alternative 2 - Masonry Grid with Filters
 * ===================================================
 * Pinterest-style masonry layout with category filtering
 * Perfect for showcasing diverse testimonial types
 */

$theme = $_SESSION['theme'] ?? $config['theme'] ?? 'tusk_modern';
$testimonials = $testimonials ?? [
    [
        'name' => 'Alex Thompson',
        'title' => 'Startup Founder',
        'company' => 'NextGen AI',
        'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face',
        'testimonial' => 'Revolutionary platform! Increased our conversion rate by 400% in just 2 months.',
        'category' => 'startup',
        'rating' => 5,
        'date' => '2024-01-15',
        'highlight' => '400% conversion increase'
    ],
    [
        'name' => 'Maria Santos',
        'title' => 'Marketing Director',
        'company' => 'Global Corp',
        'avatar' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=100&h=100&fit=crop&crop=face',
        'testimonial' => 'The analytics dashboard gives us insights we never had before. ROI tracking is phenomenal and the automated reports save us 10 hours per week. Customer segmentation features are game-changing.',
        'category' => 'enterprise',
        'rating' => 5,
        'date' => '2024-01-10',
        'highlight' => '10 hours saved weekly'
    ],
    [
        'name' => 'James Wilson',
        'title' => 'E-commerce Owner',
        'company' => 'Wilson Store',
        'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop&crop=face',
        'testimonial' => 'Sales went through the roof! Customer support is amazing.',
        'category' => 'ecommerce',
        'rating' => 5,
        'date' => '2024-01-08',
        'highlight' => 'Sales increased 250%'
    ],
    [
        'name' => 'Dr. Lisa Chen',
        'title' => 'Research Lead',
        'company' => 'BioTech Labs',
        'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop&crop=face',
        'testimonial' => 'Data security is top-notch. HIPAA compliance made easy. The platform integrates seamlessly with our existing research workflows and the collaboration features have improved our team productivity by 60%. Custom reporting capabilities are outstanding.',
        'category' => 'healthcare',
        'rating' => 5,
        'date' => '2024-01-05',
        'highlight' => 'HIPAA compliant'
    ],
    [
        'name' => 'Robert Kim',
        'title' => 'Principal',
        'company' => 'Innovation Academy',
        'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&h=100&fit=crop&crop=face',
        'testimonial' => 'Student engagement improved dramatically. Easy to use interface.',
        'category' => 'education',
        'rating' => 4,
        'date' => '2024-01-03',
        'highlight' => 'Student engagement up'
    ],
    [
        'name' => 'Sarah Johnson',
        'title' => 'Operations Manager',
        'company' => 'LogiFlow',
        'avatar' => 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?w=100&h=100&fit=crop&crop=face',
        'testimonial' => 'Streamlined our entire workflow. The automation features have eliminated manual processes that used to take hours. Real-time tracking and notifications keep everyone aligned.',
        'category' => 'enterprise',
        'rating' => 5,
        'date' => '2023-12-28',
        'highlight' => 'Workflow automated'
    ],
    [
        'name' => 'Mike Rodriguez',
        'title' => 'Product Manager',
        'company' => 'TechStart',
        'avatar' => 'https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?w=100&h=100&fit=crop&crop=face',
        'testimonial' => 'Feature set is exactly what we needed. Customer feedback integration is brilliant.',
        'category' => 'startup',
        'rating' => 5,
        'date' => '2023-12-25',
        'highlight' => 'Perfect feature set'
    ],
    [
        'name' => 'Emily Davis',
        'title' => 'Store Owner',
        'company' => 'Boutique Plus',
        'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=100&h=100&fit=crop&crop=face',
        'testimonial' => 'Inventory management became so much easier. The predictive analytics help us stock the right products at the right time. Mobile app is intuitive and fast.',
        'category' => 'ecommerce',
        'rating' => 4,
        'date' => '2023-12-20',
        'highlight' => 'Inventory optimized'
    ]
];

$categories = [
    'all' => ['name' => 'All', 'count' => count($testimonials)],
    'startup' => ['name' => 'Startups', 'count' => count(array_filter($testimonials, fn($t) => $t['category'] === 'startup'))],
    'enterprise' => ['name' => 'Enterprise', 'count' => count(array_filter($testimonials, fn($t) => $t['category'] === 'enterprise'))],
    'ecommerce' => ['name' => 'E-commerce', 'count' => count(array_filter($testimonials, fn($t) => $t['category'] === 'ecommerce'))],
    'healthcare' => ['name' => 'Healthcare', 'count' => count(array_filter($testimonials, fn($t) => $t['category'] === 'healthcare'))],
    'education' => ['name' => 'Education', 'count' => count(array_filter($testimonials, fn($t) => $t['category'] === 'education'))]
];
?>

<section class="tusk-testimonials-alt-2" id="tusk-testimonials-alt-2">
    <div class="testimonials-container">
        <!-- Header -->
        <div class="testimonials-header">
            <h2 class="testimonials-title">Success Stories</h2>
            <p class="testimonials-subtitle">See how businesses across industries achieve remarkable results</p>
        </div>

        <!-- Filter Navigation -->
        <div class="filter-navigation">
            <div class="filter-buttons">
                <?php foreach ($categories as $key => $category): ?>
                    <button class="filter-btn <?= $key === 'all' ? 'active' : '' ?>" data-category="<?= $key ?>">
                        <?= htmlspecialchars($category['name']) ?>
                        <span class="filter-count"><?= $category['count'] ?></span>
                    </button>
                <?php endforeach; ?>
            </div>
            <div class="sort-options">
                <select class="sort-select">
                    <option value="date">Latest First</option>
                    <option value="rating">Highest Rated</option>
                    <option value="company">Company A-Z</option>
                </select>
            </div>
        </div>

        <!-- Results Counter -->
        <div class="results-counter">
            <span class="result-count"><?= count($testimonials) ?></span> success stories found
        </div>

        <!-- Testimonials Masonry Grid -->
        <div class="testimonials-masonry" id="testimonialsGrid">
            <?php foreach ($testimonials as $index => $testimonial): ?>
                <div class="testimonial-card" 
                     data-category="<?= $testimonial['category'] ?>" 
                     data-rating="<?= $testimonial['rating'] ?>" 
                     data-date="<?= $testimonial['date'] ?>" 
                     data-company="<?= strtolower($testimonial['company']) ?>">
                    
                    <!-- Card Header -->
                    <div class="card-header">
                        <div class="author-info">
                            <img src="<?= $testimonial['avatar'] ?>" alt="<?= htmlspecialchars($testimonial['name']) ?>" class="author-avatar">
                            <div class="author-details">
                                <h4 class="author-name"><?= htmlspecialchars($testimonial['name']) ?></h4>
                                <p class="author-title"><?= htmlspecialchars($testimonial['title']) ?></p>
                                <p class="author-company"><?= htmlspecialchars($testimonial['company']) ?></p>
                            </div>
                        </div>
                        <div class="category-badge <?= $testimonial['category'] ?>">
                            <?= ucfirst($testimonial['category']) ?>
                        </div>
                    </div>

                    <!-- Rating -->
                    <div class="rating-section">
                        <div class="stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <svg class="star <?= $i <= $testimonial['rating'] ? 'filled' : '' ?>" width="16" height="16" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 2L15.09 8.26L22 9L16 14.74L17.18 21.02L12 18.77L6.82 21.02L8 14.74L2 9L8.91 8.26L12 2Z" fill="currentColor"/>
                                </svg>
                            <?php endfor; ?>
                        </div>
                        <div class="date"><?= date('M j, Y', strtotime($testimonial['date'])) ?></div>
                    </div>

                    <!-- Testimonial Content -->
                    <div class="testimonial-content">
                        <blockquote class="testimonial-text">
                            "<?= htmlspecialchars($testimonial['testimonial']) ?>"
                        </blockquote>
                    </div>

                    <!-- Highlight Badge -->
                    <?php if (!empty($testimonial['highlight'])): ?>
                        <div class="highlight-badge">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M13 2L3 14H12L11 22L21 10H12L13 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <?= htmlspecialchars($testimonial['highlight']) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Card Actions -->
                    <div class="card-actions">
                        <button class="share-btn" data-testimonial="<?= $index ?>">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M4 12V20A2 2 0 0 0 6 22H18A2 2 0 0 0 20 20V12M16 6L12 2L8 6M12 2V15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <button class="like-btn" data-testimonial="<?= $index ?>">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M20.84 4.61A5.5 5.5 0 0 0 7.5 7.5L12 12L16.5 7.5A5.5 5.5 0 0 0 20.84 4.61Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="like-count"><?= rand(5, 50) ?></span>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Load More Button -->
        <div class="load-more-section">
            <button class="load-more-btn">
                Load More Stories
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>

        <!-- CTA Section -->
        <div class="cta-section">
            <div class="cta-content">
                <h3 class="cta-title">Ready to Join Our Success Stories?</h3>
                <p class="cta-description">Start your free trial today and see why thousands of businesses trust us</p>
                <div class="cta-buttons">
                    <button class="cta-primary">Start Free Trial</button>
                    <button class="cta-secondary">Schedule Demo</button>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.tusk-testimonials-alt-2 {
    padding: 4rem 1rem;
    background: var(--bg-primary);
    min-height: 100vh;
}

.testimonials-container {
    max-width: 1200px;
    margin: 0 auto;
    width: 100%;
}

.testimonials-header {
    text-align: center;
    margin-bottom: 3rem;
}

.testimonials-title {
    font-size: 3rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.testimonials-subtitle {
    font-size: 1.2rem;
    color: var(--text-secondary);
    margin-bottom: 2rem;
}

.filter-navigation {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: var(--bg-secondary, #f8fafc);
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

.filter-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.filter-btn {
    padding: 0.5rem 1rem;
    border: 2px solid var(--border-color);
    background: var(--bg-primary);
    color: var(--text-primary);
    border-radius: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.filter-btn:hover {
    border-color: var(--primary-color);
    background: var(--primary-color);
    color: white;
}

.filter-btn.active {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

.filter-count {
    background: rgba(255,255,255,0.2);
    padding: 0.125rem 0.5rem;
    border-radius: 10px;
    font-size: 0.75rem;
    font-weight: 600;
}

.filter-btn:not(.active) .filter-count {
    background: var(--border-color);
    color: var(--text-secondary);
}

.sort-select {
    padding: 0.5rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    background: var(--bg-primary);
    color: var(--text-primary);
    cursor: pointer;
    font-weight: 500;
}

.results-counter {
    margin-bottom: 2rem;
    color: var(--text-secondary);
    font-weight: 500;
}

.result-count {
    color: var(--primary-color);
    font-weight: 700;
}

.testimonials-masonry {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    grid-gap: 1.5rem;
    margin-bottom: 3rem;
}

.testimonial-card {
    background: var(--bg-primary);
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    break-inside: avoid;
    position: relative;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.testimonial-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    border-color: var(--primary-color);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.author-info {
    display: flex;
    gap: 0.75rem;
}

.author-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--primary-color);
    flex-shrink: 0;
}

.author-name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.author-title,
.author-company {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: 0.125rem;
}

.category-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.category-badge.startup {
    background: #fef3c7;
    color: #92400e;
}

.category-badge.enterprise {
    background: #dbeafe;
    color: #1e40af;
}

.category-badge.ecommerce {
    background: #dcfce7;
    color: #166534;
}

.category-badge.healthcare {
    background: #fce7f3;
    color: #be185d;
}

.category-badge.education {
    background: #e0e7ff;
    color: #3730a3;
}

.rating-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.stars {
    display: flex;
    gap: 0.125rem;
}

.star {
    color: var(--border-color);
}

.star.filled {
    color: #fbbf24;
}

.date {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.testimonial-content {
    margin-bottom: 1rem;
}

.testimonial-text {
    color: var(--text-primary);
    line-height: 1.6;
    font-style: italic;
    margin: 0;
    quotes: none;
}

.highlight-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 0.5rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.card-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid var(--border-light, #f1f5f9);
}

.share-btn,
.like-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: none;
    border: none;
    color: var(--text-secondary);
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.share-btn:hover,
.like-btn:hover {
    background: var(--bg-secondary, #f8fafc);
    color: var(--primary-color);
}

.like-btn.liked {
    color: #ef4444;
}

.like-count {
    font-size: 0.875rem;
    font-weight: 500;
}

.load-more-section {
    text-align: center;
    margin-bottom: 4rem;
}

.load-more-btn {
    padding: 1rem 2rem;
    background: var(--bg-secondary, #f8fafc);
    border: 2px solid var(--border-color);
    color: var(--text-primary);
    border-radius: 12px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.load-more-btn:hover {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}

.cta-section {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 20px;
    padding: 3rem;
    text-align: center;
    color: white;
}

.cta-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.cta-description {
    font-size: 1.1rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.cta-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.cta-primary,
.cta-secondary {
    padding: 1rem 2rem;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.cta-primary {
    background: white;
    color: var(--primary-color);
}

.cta-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255,255,255,0.3);
}

.cta-secondary {
    background: rgba(255,255,255,0.1);
    color: white;
    border: 2px solid rgba(255,255,255,0.3);
}

.cta-secondary:hover {
    background: rgba(255,255,255,0.2);
    border-color: rgba(255,255,255,0.5);
}

@media (max-width: 768px) {
    .testimonials-title {
        font-size: 2rem;
    }
    
    .filter-navigation {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .filter-buttons {
        justify-content: center;
    }
    
    .testimonials-masonry {
        grid-template-columns: 1fr;
    }
    
    .cta-title {
        font-size: 1.5rem;
    }
    
    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .cta-primary,
    .cta-secondary {
        width: 100%;
        max-width: 250px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const testimonialCards = document.querySelectorAll('.testimonial-card');
    const sortSelect = document.querySelector('.sort-select');
    const resultCount = document.querySelector('.result-count');
    const likeButtons = document.querySelectorAll('.like-btn');
    const shareButtons = document.querySelectorAll('.share-btn');
    const loadMoreBtn = document.querySelector('.load-more-btn');
    
    let currentFilter = 'all';
    let currentSort = 'date';
    
    // Filter functionality
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            currentFilter = this.dataset.category;
            filterAndSort();
        });
    });
    
    // Sort functionality
    sortSelect.addEventListener('change', function() {
        currentSort = this.value;
        filterAndSort();
    });
    
    function filterAndSort() {
        let visibleCards = Array.from(testimonialCards);
        
        // Filter
        if (currentFilter !== 'all') {
            visibleCards = visibleCards.filter(card => {
                return card.dataset.category === currentFilter;
            });
        }
        
        // Sort
        visibleCards.sort((a, b) => {
            switch (currentSort) {
                case 'date':
                    return new Date(b.dataset.date) - new Date(a.dataset.date);
                case 'rating':
                    return parseInt(b.dataset.rating) - parseInt(a.dataset.rating);
                case 'company':
                    return a.dataset.company.localeCompare(b.dataset.company);
                default:
                    return 0;
            }
        });
        
        // Hide all cards
        testimonialCards.forEach(card => {
            card.style.display = 'none';
            card.style.opacity = '0';
        });
        
        // Show and reorder visible cards
        visibleCards.forEach((card, index) => {
            card.style.display = 'block';
            card.style.order = index;
            setTimeout(() => {
                card.style.opacity = '1';
            }, index * 50);
        });
        
        // Update result count
        resultCount.textContent = visibleCards.length;
    }
    
    // Like functionality
    likeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            this.classList.toggle('liked');
            
            const countElement = this.querySelector('.like-count');
            const currentCount = parseInt(countElement.textContent);
            
            if (this.classList.contains('liked')) {
                countElement.textContent = currentCount + 1;
                // Add animation
                this.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 200);
            } else {
                countElement.textContent = currentCount - 1;
            }
        });
    });
    
    // Share functionality
    shareButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const testimonialIndex = this.dataset.testimonial;
            
            // In a real app, you would implement actual sharing
            if (navigator.share) {
                navigator.share({
                    title: 'Customer Testimonial',
                    text: 'Check out this amazing customer story!',
                    url: window.location.href + '#testimonial-' + testimonialIndex
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(window.location.href + '#testimonial-' + testimonialIndex)
                    .then(() => {
                        // Show temporary feedback
                        this.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                        setTimeout(() => {
                            this.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M4 12V20A2 2 0 0 0 6 22H18A2 2 0 0 0 20 20V12M16 6L12 2L8 6M12 2V15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                        }, 2000);
                    });
            }
        });
    });
    
    // Load more functionality
    loadMoreBtn.addEventListener('click', function() {
        // In a real app, you would load more testimonials from an API
        this.innerHTML = 'Loading...';
        
        setTimeout(() => {
            this.innerHTML = 'Load More Stories <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
            alert('In a real application, this would load more testimonials from your API.');
        }, 1000);
    });
    
    // Initialize masonry layout on load
    setTimeout(() => {
        filterAndSort();
    }, 100);
    
    // Add entrance animation
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const cardObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
                cardObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    testimonialCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        cardObserver.observe(card);
    });
});
</script>