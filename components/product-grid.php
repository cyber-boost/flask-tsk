<?php
/**
 * <?tusk> Enhanced Product Grid Component
 * Created: 2025-06-26
 * Strong. Secure. Scalable. 🐘
 *
 * <?tusk> product-grid Component
 * Auto-Inclusion: [tusk-component-product-grid]
 * Themes: default, dark, minimal, gradient, neon, corporate, warm, cool
 */

$theme = isset($theme) ? $theme : 'default';
$layout = isset($layout) ? $layout : 'grid'; // grid, list
$show_filters = isset($show_filters) ? $show_filters : true;
$show_sorting = isset($show_sorting) ? $show_sorting : true;

$products = isset($products) ? $products : [
    [
        'id' => 'wireless-headphones',
        'name' => 'Premium Wireless Headphones',
        'category' => 'electronics',
        'price' => 299.99,
        'sale_price' => 249.99,
        'rating' => 4.8,
        'reviews' => 234,
        'image' => 'https://via.placeholder.com/400x400/3498db/ffffff?text=Headphones',
        'badge' => 'Sale',
        'in_stock' => true,
        'featured' => true
    ],
    [
        'id' => 'smart-watch',
        'name' => 'Smart Fitness Watch',
        'category' => 'electronics',
        'price' => 199.99,
        'sale_price' => null,
        'rating' => 4.6,
        'reviews' => 156,
        'image' => 'https://via.placeholder.com/400x400/e74c3c/ffffff?text=Smart+Watch',
        'badge' => 'New',
        'in_stock' => true,
        'featured' => false
    ],
    [
        'id' => 'laptop-bag',
        'name' => 'Professional Laptop Bag',
        'category' => 'accessories',
        'price' => 89.99,
        'sale_price' => null,
        'rating' => 4.4,
        'reviews' => 89,
        'image' => 'https://via.placeholder.com/400x400/2ecc71/ffffff?text=Laptop+Bag',
        'badge' => null,
        'in_stock' => true,
        'featured' => false
    ],
    [
        'id' => 'gaming-mouse',
        'name' => 'Gaming Mouse RGB',
        'category' => 'electronics',
        'price' => 79.99,
        'sale_price' => 59.99,
        'rating' => 4.7,
        'reviews' => 312,
        'image' => 'https://via.placeholder.com/400x400/f39c12/ffffff?text=Gaming+Mouse',
        'badge' => 'Sale',
        'in_stock' => false,
        'featured' => true
    ],
    [
        'id' => 'phone-case',
        'name' => 'Protective Phone Case',
        'category' => 'accessories',
        'price' => 24.99,
        'sale_price' => null,
        'rating' => 4.2,
        'reviews' => 67,
        'image' => 'https://via.placeholder.com/400x400/9b59b6/ffffff?text=Phone+Case',
        'badge' => null,
        'in_stock' => true,
        'featured' => false
    ],
    [
        'id' => 'bluetooth-speaker',
        'name' => 'Portable Bluetooth Speaker',
        'category' => 'electronics',
        'price' => 149.99,
        'sale_price' => null,
        'rating' => 4.5,
        'reviews' => 203,
        'image' => 'https://via.placeholder.com/400x400/1abc9c/ffffff?text=Speaker',
        'badge' => 'Popular',
        'in_stock' => true,
        'featured' => false
    ]
];

$categories = array_unique(array_column($products, 'category'));
?>

<section class="tusk-product-grid tusk-product-grid--<?php echo $theme; ?> tusk-product-grid--<?php echo $layout; ?>" 
         role="region" 
         aria-label="Product Catalog">
    <div class="product-grid-container">
        <div class="product-grid-header">
            <h2 class="grid-title">Our Products</h2>
            <p class="grid-subtitle">Discover our curated selection of premium products</p>
            
            <div class="grid-controls">
                <?php if ($show_filters): ?>
                <div class="filter-controls">
                    <button class="filter-btn active" data-filter="all">All Products</button>
                    <?php foreach ($categories as $category): ?>
                    <button class="filter-btn" data-filter="<?php echo $category; ?>">
                        <?php echo ucfirst($category); ?>
                    </button>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                
                <?php if ($show_sorting): ?>
                <div class="sort-controls">
                    <select class="sort-select" aria-label="Sort products">
                        <option value="featured">Featured</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="rating">Highest Rated</option>
                        <option value="newest">Newest</option>
                    </select>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="products-grid">
            <?php foreach ($products as $index => $product): ?>
            <div class="product-card <?php echo $product['featured'] ? 'featured' : ''; ?> <?php echo !$product['in_stock'] ? 'out-of-stock' : ''; ?>" 
                 data-category="<?php echo $product['category']; ?>"
                 data-price="<?php echo $product['sale_price'] ?: $product['price']; ?>"
                 data-rating="<?php echo $product['rating']; ?>"
                 data-product-id="<?php echo $product['id']; ?>">
                
                <div class="product-image">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                         alt="<?php echo htmlspecialchars($product['name']); ?>"
                         loading="lazy">
                    
                    <?php if ($product['badge']): ?>
                    <div class="product-badge badge-<?php echo strtolower($product['badge']); ?>">
                        <?php echo $product['badge']; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!$product['in_stock']): ?>
                    <div class="stock-overlay">Out of Stock</div>
                    <?php endif; ?>
                    
                    <div class="product-actions">
                        <button class="action-btn wishlist-btn" data-product="<?php echo $product['id']; ?>" aria-label="Add to wishlist">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </button>
                        <button class="action-btn quick-view-btn" data-product="<?php echo $product['id']; ?>" aria-label="Quick view">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <div class="product-content">
                    <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                    
                    <div class="product-rating">
                        <div class="stars">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                            <svg width="14" height="14" viewBox="0 0 24 24" class="star <?php echo $i <= floor($product['rating']) ? 'filled' : ''; ?>">
                                <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                            </svg>
                            <?php endfor; ?>
                        </div>
                        <span class="rating-text"><?php echo $product['rating']; ?> (<?php echo $product['reviews']; ?>)</span>
                    </div>
                    
                    <div class="product-price">
                        <?php if ($product['sale_price']): ?>
                        <span class="sale-price">$<?php echo number_format($product['sale_price'], 2); ?></span>
                        <span class="original-price">$<?php echo number_format($product['price'], 2); ?></span>
                        <span class="discount">Save $<?php echo number_format($product['price'] - $product['sale_price'], 2); ?></span>
                        <?php else: ?>
                        <span class="current-price">$<?php echo number_format($product['price'], 2); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="product-cart">
                        <?php if ($product['in_stock']): ?>
                        <button class="add-to-cart-btn" data-product="<?php echo $product['id']; ?>">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="9" cy="21" r="1"/>
                                <circle cx="20" cy="21" r="1"/>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                            </svg>
                            Add to Cart
                        </button>
                        <?php else: ?>
                        <button class="notify-btn" data-product="<?php echo $product['id']; ?>" disabled>
                            Notify When Available
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="grid-footer">
            <button class="load-more-btn">Load More Products</button>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productCards = document.querySelectorAll('.product-card');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const sortSelect = document.querySelector('.sort-select');
    const addToCartBtns = document.querySelectorAll('.add-to-cart-btn');
    const wishlistBtns = document.querySelectorAll('.wishlist-btn');
    const quickViewBtns = document.querySelectorAll('.quick-view-btn');
    const loadMoreBtn = document.querySelector('.load-more-btn');
    
    let cart = JSON.parse(localStorage.getItem('cart') || '[]');
    let wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
    
    // Initialize filtering
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.dataset.filter;
            
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            productCards.forEach(card => {
                const category = card.dataset.category;
                if (filter === 'all' || category === filter) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
            
            console.log('Products filtered by:', filter);
        });
    });
    
    // Initialize sorting
    if (sortSelect) {
        sortSelect.addEventListener('change', () => {
            const sortBy = sortSelect.value;
            const visibleCards = Array.from(productCards).filter(card => 
                card.style.display !== 'none'
            );
            
            visibleCards.sort((a, b) => {
                switch (sortBy) {
                    case 'price-low':
                        return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                    case 'price-high':
                        return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                    case 'rating':
                        return parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating);
                    case 'featured':
                        return b.classList.contains('featured') - a.classList.contains('featured');
                    default:
                        return 0;
                }
            });
            
            const grid = document.querySelector('.products-grid');
            visibleCards.forEach(card => grid.appendChild(card));
            
            console.log('Products sorted by:', sortBy);
        });
    }
    
    // Add to cart functionality
    addToCartBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const productId = btn.dataset.product;
            
            // Add to cart array
            cart.push(productId);
            localStorage.setItem('cart', JSON.stringify(cart));
            
            // Visual feedback
            btn.textContent = 'Added!';
            btn.style.background = '#2ecc71';
            
            setTimeout(() => {
                btn.innerHTML = `
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"/>
                        <circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    Add to Cart
                `;
                btn.style.background = '';
            }, 2000);
            
            console.log('Added to cart:', productId);
            
            if (window.TuskToast) {
                window.TuskToast.success('Added to Cart', 'Product added successfully!');
            }
        });
    });
    
    // Wishlist functionality
    wishlistBtns.forEach(btn => {
        const productId = btn.dataset.product;
        
        // Set initial state
        if (wishlist.includes(productId)) {
            btn.classList.add('active');
        }
        
        btn.addEventListener('click', () => {
            if (wishlist.includes(productId)) {
                wishlist = wishlist.filter(id => id !== productId);
                btn.classList.remove('active');
            } else {
                wishlist.push(productId);
                btn.classList.add('active');
            }
            
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            console.log('Wishlist updated:', productId);
        });
    });
    
    // Quick view functionality
    quickViewBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const productId = btn.dataset.product;
            console.log('Quick view:', productId);
            
            if (window.TuskToast) {
                window.TuskToast.info('Quick View', `Opening preview for ${productId}`);
            }
        });
    });
    
    // Load more functionality
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', () => {
            console.log('Load more products clicked');
            
            if (window.TuskToast) {
                window.TuskToast.info('Loading', 'Loading more products...');
            }
        });
    }
    
    // Product card clicks
    productCards.forEach(card => {
        card.addEventListener('click', (e) => {
            // Don't trigger if clicking on buttons
            if (!e.target.closest('button')) {
                const productId = card.dataset.productId;
                console.log('Product clicked:', productId);
            }
        });
    });
});
</script>