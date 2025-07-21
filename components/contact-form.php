<?php
/**
 * contact-form.php
 * Enhanced with field validation, character counting, and submission handling
 */
?>

<section class="tusk-forms-contact-form" id="contact">
    <div class="forms-container">
        <div class="form-card">
            <h2>💬 Get In Touch</h2>
            <p>We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
            
            <form id="contact-form" class="contact-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="contact-name" class="form-label">Name *</label>
                        <input type="text" id="contact-name" name="name" class="form-input" 
                               placeholder="Your full name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-email" class="form-label">Email *</label>
                        <input type="email" id="contact-email" name="email" class="form-input" 
                               placeholder="your.email@example.com" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="contact-subject" class="form-label">Subject *</label>
                    <select id="contact-subject" name="subject" class="form-input form-select" required>
                        <option value="">Select a subject</option>
                        <option value="general">General Inquiry</option>
                        <option value="support">Technical Support</option>
                        <option value="sales">Sales Question</option>
                        <option value="partnership">Partnership</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="contact-message" class="form-label">Message *</label>
                    <textarea id="contact-message" name="message" class="form-input form-textarea" 
                              placeholder="Tell us more about your inquiry..." required maxlength="500"></textarea>
                    <div class="character-count">
                        <span id="char-count">0</span>/500 characters
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" id="contact-consent" name="consent" required>
                        <span class="checkmark"></span>
                        I consent to processing of my personal data according to the Privacy Policy
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary full-width">
                    Send Message 📤
                </button>
            </form>
        </div>
    </div>
</section>

<script>
// Character counter
document.getElementById('contact-message').addEventListener('input', function() {
    const charCount = document.getElementById('char-count');
    charCount.textContent = this.value.length;
    
    if (this.value.length > 450) {
        charCount.style.color = '#f44336';
    } else {
        charCount.style.color = '#666';
    }
});

// Form submission
document.getElementById('contact-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    submitBtn.textContent = 'Sending... ⏳';
    submitBtn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        alert('Message sent successfully! We\'ll get back to you soon.');
        this.reset();
        document.getElementById('char-count').textContent = '0';
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    }, 2000);
});
</script>