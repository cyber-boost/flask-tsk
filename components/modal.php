<?php
/**
 * modal.php
 * Enhanced modal system with multiple modals and animations
 */
?>

<section class="tusk-interactive-modal" id="modals">
    <div class="interactive-container">
        <h2>🎭 Interactive Modals</h2>
        <p>Click the buttons below to see different modal types in action!</p>
        
        <div class="modal-buttons">
            <button class="btn btn-primary" onclick="openModal('demo-modal')">Demo Modal</button>
            <button class="btn btn-secondary" onclick="openModal('image-modal')">Image Gallery</button>
            <button class="btn btn-success" onclick="openModal('form-modal')">Quick Form</button>
        </div>
    </div>
</section>

<!-- Demo Modal -->
<div id="demo-modal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3>🚀 Welcome to TuskPHP</h3>
            <button class="modal-close" onclick="closeModal('demo-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <p>This is a demonstration of our interactive modal system. TuskPHP makes it easy to create engaging user experiences.</p>
            <ul>
                <li>✅ Responsive design</li>
                <li>✅ Smooth animations</li>
                <li>✅ Keyboard navigation</li>
                <li>✅ Accessibility features</li>
            </ul>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('demo-modal')">Close</button>
            <button class="btn btn-primary" onclick="alert('Action performed!')">Take Action</button>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="image-modal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3>🖼️ Image Gallery</h3>
            <button class="modal-close" onclick="closeModal('image-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="image-gallery-modal">
                <div class="gallery-preview">
                    <div class="placeholder-image">🎨 Image Preview</div>
                </div>
                <div class="gallery-thumbnails">
                    <div class="thumbnail active">📸</div>
                    <div class="thumbnail">🌅</div>
                    <div class="thumbnail">🏔️</div>
                    <div class="thumbnail">🌊</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form Modal -->
<div id="form-modal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3>📝 Quick Contact</h3>
            <button class="modal-close" onclick="closeModal('form-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="quick-form">
                <div class="form-group">
                    <input type="text" class="form-input" placeholder="Your Name" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-input" placeholder="Your Email" required>
                </div>
                <div class="form-group">
                    <textarea class="form-input" placeholder="Quick message..." rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary full-width">Send Message</button>
            </form>
        </div>
    </div>
</div>

<script>
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // Focus management for accessibility
        const firstFocusable = modal.querySelector('button, input, textarea, select');
        if (firstFocusable) firstFocusable.focus();
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// Close modal on overlay click
document.querySelectorAll('.modal-overlay').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal(this.id);
        }
    });
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay.active').forEach(modal => {
            closeModal(modal.id);
        });
    }
});

// Quick form submission
document.getElementById('quick-form').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Quick message sent!');
    this.reset();
    closeModal('form-modal');
});
</script>
