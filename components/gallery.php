<?php
/**
 * gallery.php
 * Enhanced image gallery with lightbox and filtering
 */
?>

<section class="tusk-interactive-gallery" id="gallery">
    <div class="interactive-container">
        <h2>🖼️ Image Gallery</h2>
        <p>Explore our stunning collection of images with advanced filtering and lightbox features.</p>
        
        <div class="gallery-filters">
            <button class="filter-btn active" data-filter="*">All</button>
            <button class="filter-btn" data-filter=".nature">Nature</button>
            <button class="filter-btn" data-filter=".architecture">Architecture</button>
            <button class="filter-btn" data-filter=".technology">Technology</button>
        </div>
        
        <div class="gallery-grid" id="gallery-grid">
            <div class="gallery-item nature" data-src="https://via.placeholder.com/400x300/4CAF50/white?text=Nature+1">
                <div class="gallery-image" style="background: linear-gradient(45deg, #4CAF50, #8BC34A);">🌿</div>
                <div class="gallery-overlay">
                    <h4>Beautiful Forest</h4>
                    <p>Nature Photography</p>
                </div>
            </div>
            
            <div class="gallery-item architecture" data-src="https://via.placeholder.com/400x300/2196F3/white?text=Architecture+1">
                <div class="gallery-image" style="background: linear-gradient(45deg, #2196F3, #03A9F4);">🏢</div>
                <div class="gallery-overlay">
                    <h4>Modern Building</h4>
                    <p>Architecture</p>
                </div>
            </div>
            
            <div class="gallery-item technology" data-src="https://via.placeholder.com/400x300/9C27B0/white?text=Technology+1">
                <div class="gallery-image" style="background: linear-gradient(45deg, #9C27B0, #E91E63);">💻</div>
                <div class="gallery-overlay">
                    <h4>Tech Innovation</h4>
                    <p>Technology</p>
                </div>
            </div>
            
            <div class="gallery-item nature" data-src="https://via.placeholder.com/400x300/FF9800/white?text=Nature+2">
                <div class="gallery-image" style="background: linear-gradient(45deg, #FF9800, #FFC107);">🌅</div>
                <div class="gallery-overlay">
                    <h4>Golden Sunset</h4>
                    <p>Landscape</p>
                </div>
            </div>
            
            <div class="gallery-item architecture" data-src="https://via.placeholder.com/400x300/607D8B/white?text=Architecture+2">
                <div class="gallery-image" style="background: linear-gradient(45deg, #607D8B, #90A4AE);">🏛️</div>
                <div class="gallery-overlay">
                    <h4>Classical Design</h4>
                    <p>Historic Architecture</p>
                </div>
            </div>
            
            <div class="gallery-item technology" data-src="https://via.placeholder.com/400x300/795548/white?text=Technology+2">
                <div class="gallery-image" style="background: linear-gradient(45deg, #795548, #A1887F);">🚀</div>
                <div class="gallery-overlay">
                    <h4>Space Technology</h4>
                    <p>Innovation</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Lightbox -->
<div id="lightbox" class="modal-overlay">
    <div class="lightbox-content">
        <button class="modal-close" onclick="closeLightbox()">&times;</button>
        <div class="lightbox-image">
            <div id="lightbox-display"></div>
        </div>
        <div class="lightbox-nav">
            <button class="lightbox-prev" onclick="prevImage()">‹</button>
            <button class="lightbox-next" onclick="nextImage()">›</button>
        </div>
        <div class="lightbox-info">
            <h3 id="lightbox-title"></h3>
            <p id="lightbox-desc"></p>
        </div>
    </div>
</div>

<script>
let currentImageIndex = 0;
let galleryImages = [];

// Gallery filtering
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Update active button
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        // Filter items
        const filter = this.getAttribute('data-filter');
        const items = document.querySelectorAll('.gallery-item');
        
        items.forEach(item => {
            if (filter === '*' || item.classList.contains(filter.substring(1))) {
                item.style.display = 'block';
                item.style.animation = 'fadeIn 0.5s ease';
            } else {
                item.style.display = 'none';
            }
        });
    });
});

// Gallery item click handlers
document.querySelectorAll('.gallery-item').forEach((item, index) => {
    item.addEventListener('click', function() {
        const title = this.querySelector('h4').textContent;
        const desc = this.querySelector('p').textContent;
        const bgStyle = this.querySelector('.gallery-image').style.background;
        
        openLightbox(title, desc, bgStyle, index);
    });
});

function openLightbox(title, desc, bgStyle, index) {
    currentImageIndex = index;
    document.getElementById('lightbox-title').textContent = title;
    document.getElementById('lightbox-desc').textContent = desc;
    document.getElementById('lightbox-display').style.background = bgStyle;
    document.getElementById('lightbox').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').classList.remove('active');
    document.body.style.overflow = '';
}

function nextImage() {
    const visibleItems = Array.from(document.querySelectorAll('.gallery-item')).filter(item => 
        item.style.display !== 'none'
    );
    currentImageIndex = (currentImageIndex + 1) % visibleItems.length;
    const nextItem = visibleItems[currentImageIndex];
    const title = nextItem.querySelector('h4').textContent;
    const desc = nextItem.querySelector('p').textContent;
    const bgStyle = nextItem.querySelector('.gallery-image').style.background;
    
    document.getElementById('lightbox-title').textContent = title;
    document.getElementById('lightbox-desc').textContent = desc;
    document.getElementById('lightbox-display').style.background = bgStyle;
}

function prevImage() {
    const visibleItems = Array.from(document.querySelectorAll('.gallery-item')).filter(item => 
        item.style.display !== 'none'
    );
    currentImageIndex = currentImageIndex === 0 ? visibleItems.length - 1 : currentImageIndex - 1;
    const prevItem = visibleItems[currentImageIndex];
    const title = prevItem.querySelector('h4').textContent;
    const desc = prevItem.querySelector('p').textContent;
    const bgStyle = prevItem.querySelector('.gallery-image').style.background;
    
    document.getElementById('lightbox-title').textContent = title;
    document.getElementById('lightbox-desc').textContent = desc;
    document.getElementById('lightbox-display').style.background = bgStyle;
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (document.getElementById('lightbox').classList.contains('active')) {
        if (e.key === 'ArrowRight') nextImage();
        if (e.key === 'ArrowLeft') prevImage();
        if (e.key === 'Escape') closeLightbox();
    }
});
</script>