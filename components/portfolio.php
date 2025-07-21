<?php
/**
 * <?tusk> Enhanced Portfolio Component
 * Created: 2025-06-26
 * Strong. Secure. Scalable. 🐘
 *
 * <?tusk> portfolio Component
 * Auto-Inclusion: [tusk-component-portfolio]
 * Themes: default, dark, minimal, gradient, neon, corporate, warm, cool
 */

$theme = isset($theme) ? $theme : 'default';
$layout = isset($layout) ? $layout : 'masonry'; // grid, masonry, list
$show_filters = isset($show_filters) ? $show_filters : true;

$portfolio_items = isset($portfolio_items) ? $portfolio_items : [
    [
        'id' => 'ecommerce-platform',
        'title' => 'E-commerce Platform',
        'category' => 'web-development',
        'client' => 'RetailTech Inc.',
        'description' => 'Full-featured e-commerce platform with payment integration and inventory management.',
        'image' => 'https://via.placeholder.com/600x400/3498db/ffffff?text=E-commerce',
        'technologies' => ['React', 'Node.js', 'MongoDB', 'Stripe'],
        'year' => '2024',
        'url' => '#',
        'featured' => true
    ],
    [
        'id' => 'mobile-banking-app',
        'title' => 'Mobile Banking App',
        'category' => 'mobile-development',
        'client' => 'SecureBank',
        'description' => 'Secure mobile banking application with biometric authentication and real-time transactions.',
        'image' => 'https://via.placeholder.com/600x400/e74c3c/ffffff?text=Banking+App',
        'technologies' => ['React Native', 'TypeScript', 'Firebase'],
        'year' => '2024',
        'url' => '#',
        'featured' => false
    ],
    [
        'id' => 'healthcare-dashboard',
        'title' => 'Healthcare Dashboard',
        'category' => 'web-development',
        'client' => 'MedCare Solutions',
        'description' => 'Patient management dashboard with real-time monitoring and reporting capabilities.',
        'image' => 'https://via.placeholder.com/600x400/2ecc71/ffffff?text=Healthcare',
        'technologies' => ['Vue.js', 'Python', 'PostgreSQL'],
        'year' => '2023',
        'url' => '#',
        'featured' => true
    ],
    [
        'id' => 'brand-identity',
        'title' => 'Brand Identity Design',
        'category' => 'design',
        'client' => 'StartupCo',
        'description' => 'Complete brand identity package including logo, typography, and visual guidelines.',
        'image' => 'https://via.placeholder.com/600x400/f39c12/ffffff?text=Brand+Identity',
        'technologies' => ['Figma', 'Illustrator', 'InDesign'],
        'year' => '2023',
        'url' => '#',
        'featured' => false
    ],
    [
        'id' => 'fitness-tracker',
        'title' => 'Fitness Tracking App',
        'category' => 'mobile-development',
        'client' => 'FitLife',
        'description' => 'Comprehensive fitness tracking app with workout plans and nutrition tracking.',
        'image' => 'https://via.placeholder.com/600x400/9b59b6/ffffff?text=Fitness+App',
        'technologies' => ['Flutter', 'Dart', 'Firebase'],
        'year' => '2023',
        'url' => '#',
        'featured' => false
    ],
    [
        'id' => 'learning-platform',
        'title' => 'Online Learning Platform',
        'category' => 'web-development',
        'client' => 'EduTech Pro',
        'description' => 'Interactive online learning platform with video streaming and progress tracking.',
        'image' => 'https://via.placeholder.com/600x400/1abc9c/ffffff?text=Learning+Platform',
        'technologies' => ['Angular', 'Node.js', 'MySQL', 'AWS'],
        'year' => '2024',
        'url' => '#',
        'featured' => true
    ]
];

$categories = array_unique(array_column($portfolio_items, 'category'));
?>

<section class="tusk-portfolio tusk-portfolio--<?php echo $theme; ?> tusk-portfolio--<?php echo $layout; ?>" 
         role="region" 
         aria-label="Portfolio">
    <div class="portfolio-container">
        <div class="portfolio-header">
            <h2 class="portfolio-title">Our Work</h2>
            <p class="portfolio-subtitle">Showcasing our latest projects and successful collaborations</p>
            
            <?php if ($show_filters): ?>
            <div class="portfolio-filters">
                <button class="filter-btn active" data-filter="all">All Projects</button>
                <?php foreach ($categories as $category): ?>
                <button class="filter-btn" data-filter="<?php echo $category; ?>">
                    <?php echo ucwords(str_replace('-', ' ', $category)); ?>
                </button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="portfolio-grid">
            <?php foreach ($portfolio_items as $index => $item): ?>
            <div class="portfolio-item <?php echo $item['featured'] ? 'featured' : ''; ?>" 
                 data-category="<?php echo $item['category']; ?>"
                 data-index="<?php echo $index; ?>">
                
                <div class="portfolio-card">
                    <div class="portfolio-image">
                        <img src="<?php echo htmlspecialchars($item['image']); ?>" 
                             alt="<?php echo htmlspecialchars($item['title']); ?>"
                             loading="lazy">
                        <div class="portfolio-overlay">
                            <div class="overlay-content">
                                <button class="view-btn" data-item="<?php echo $item['id']; ?>">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    View Project
                                </button>
                                <a href="<?php echo htmlspecialchars($item['url']); ?>" class="live-btn">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                                        <polyline points="15,3 21,3 21,9"/>
                                        <line x1="10" y1="14" x2="21" y2="3"/>
                                    </svg>
                                    Live Site
                                </a>
                            </div>
                        </div>
                        <?php if ($item['featured']): ?>
                        <div class="featured-badge">Featured</div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="portfolio-content">
                        <div class="portfolio-meta">
                            <span class="portfolio-category"><?php echo ucwords(str_replace('-', ' ', $item['category'])); ?></span>
                            <span class="portfolio-year"><?php echo $item['year']; ?></span>
                        </div>
                        
                        <h3 class="portfolio-title"><?php echo htmlspecialchars($item['title']); ?></h3>
                        <p class="portfolio-client">Client: <?php echo htmlspecialchars($item['client']); ?></p>
                        <p class="portfolio-description"><?php echo htmlspecialchars($item['description']); ?></p>
                        
                        <div class="portfolio-technologies">
                            <?php foreach ($item['technologies'] as $tech): ?>
                            <span class="tech-tag"><?php echo htmlspecialchars($tech); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="portfolio-cta">
            <h3>Like What You See?</h3>
            <p>Let's discuss your next project and bring your vision to life</p>
            <button class="cta-button">Start Your Project</button>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const portfolioItems = document.querySelectorAll('.portfolio-item');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const viewBtns = document.querySelectorAll('.view-btn');
    const liveBtns = document.querySelectorAll('.live-btn');
    const ctaBtn = document.querySelector('.portfolio-cta .cta-button');
    
    // Initialize filtering
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.dataset.filter;
            
            // Update active filter
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            // Filter items
            portfolioItems.forEach(item => {
                const category = item.dataset.category;
                if (filter === 'all' || category === filter) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, 50);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
            
            console.log('Portfolio filtered by:', filter);
        });
    });
    
    // View project buttons
    viewBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const itemId = btn.dataset.item;
            console.log('View project clicked:', itemId);
            
            if (window.TuskToast) {
                window.TuskToast.info('Project Details', `Viewing details for ${itemId}`);
            }
        });
    });
    
    // Live site buttons
    liveBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            console.log('Live site clicked:', btn.href);
        });
    });
    
    // Portfolio item clicks
    portfolioItems.forEach(item => {
        item.addEventListener('click', () => {
            const index = item.dataset.index;
            console.log('Portfolio item clicked:', index);
        });
    });
    
    // CTA button
    if (ctaBtn) {
        ctaBtn.addEventListener('click', () => {
            console.log('Portfolio CTA clicked');
            if (window.TuskToast) {
                window.TuskToast.success('Let\'s Talk', 'Redirecting to contact form...');
            }
        });
    }
    
    // Masonry layout adjustment
    function adjustMasonryLayout() {
        if (document.querySelector('.tusk-portfolio--masonry')) {
            // Simulate masonry layout with CSS Grid
            const grid = document.querySelector('.portfolio-grid');
            if (grid) {
                grid.style.display = 'grid';
                grid.style.gridTemplateColumns = 'repeat(auto-fit, minmax(350px, 1fr))';
                grid.style.gridAutoRows = 'masonry'; // Future CSS feature
            }
        }
    }
    
    window.addEventListener('resize', adjustMasonryLayout);
    adjustMasonryLayout();
});
</script>