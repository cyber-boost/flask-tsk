<?php
/**
 * newsletter-signup.php
 * Enhanced with form validation and AJAX submission
 */
?>

<section class="tusk-forms-newsletter-signup" id="newsletter">
    <div class="forms-container">
        <div class="form-card">
            <h2>📧 Stay Updated</h2>
            <p>Subscribe to our newsletter for the latest updates and exclusive content!</p>
            
            <form id="newsletter-form" class="newsletter-signup-form">
                <div class="form-group">
                    <label for="newsletter-email" class="form-label">Email Address</label>
                    <input type="email" id="newsletter-email" name="email" class="form-input" 
                           placeholder="Enter your email address" required>
                    <div class="error-message" id="newsletter-email-error"></div>
                </div>
                
                <div class="form-group">
                    <label for="newsletter-name" class="form-label">Name (Optional)</label>
                    <input type="text" id="newsletter-name" name="name" class="form-input" 
                           placeholder="Your name">
                </div>
                
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" id="newsletter-consent" name="consent" required>
                        <span class="checkmark"></span>
                        I agree to receive marketing emails and understand I can unsubscribe at any time.
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary" id="newsletter-submit">
                    <span class="btn-text">Subscribe Now</span>
                    <span class="btn-loader" style="display: none;">📨 Subscribing...</span>
                </button>
            </form>
            
            <div id="newsletter-success" class="success-message" style="display: none;">
                <h3>🎉 Welcome aboard!</h3>
                <p>Thank you for subscribing! Check your email for confirmation.</p>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('newsletter-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('newsletter-submit');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoader = submitBtn.querySelector('.btn-loader');
    const form = this;
    const successDiv = document.getElementById('newsletter-success');
    
    // Show loading state
    btnText.style.display = 'none';
    btnLoader.style.display = 'inline';
    submitBtn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        form.style.display = 'none';
        successDiv.style.display = 'block';
        
        // Reset form after showing success
        setTimeout(() => {
            form.reset();
            form.style.display = 'block';
            successDiv.style.display = 'none';
            btnText.style.display = 'inline';
            btnLoader.style.display = 'none';
            submitBtn.disabled = false;
        }, 3000);
    }, 1500);
});
</script>