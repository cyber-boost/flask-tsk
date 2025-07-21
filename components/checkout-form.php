<?php
/**
 * checkout-form.php
 * Enhanced checkout form with validation, payment processing, and order summary
 */
?>

<section class="tusk-ecommerce-checkout-form" id="checkout">
    <div class="ecommerce-container">
        <h2>💳 Secure Checkout</h2>
        <p>Complete your order with our secure payment system</p>
        
        <div class="checkout-container">
            <div class="checkout-main">
                <div class="checkout-steps">
                    <div class="step active" data-step="1">
                        <span class="step-number">1</span>
                        <span class="step-title">Information</span>
                    </div>
                    <div class="step" data-step="2">
                        <span class="step-number">2</span>
                        <span class="step-title">Shipping</span>
                    </div>
                    <div class="step" data-step="3">
                        <span class="step-number">3</span>
                        <span class="step-title">Payment</span>
                    </div>
                    <div class="step" data-step="4">
                        <span class="step-number">4</span>
                        <span class="step-title">Review</span>
                    </div>
                </div>
                
                <form id="checkout-form" class="checkout-form">
                    <!-- Step 1: Customer Information -->
                    <div class="form-step active" id="step-1">
                        <h3>📝 Contact Information</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first-name" class="form-label">First Name *</label>
                                <input type="text" id="first-name" name="firstName" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label for="last-name" class="form-label">Last Name *</label>
                                <input type="text" id="last-name" name="lastName" class="form-input" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" id="email" name="email" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" id="phone" name="phone" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="subscribe" name="subscribe">
                                <span class="checkmark"></span>
                                Subscribe to our newsletter for updates and exclusive offers
                            </label>
                        </div>
                    </div>
                    
                    <!-- Step 2: Shipping Information -->
                    <div class="form-step" id="step-2">
                        <h3>🚚 Shipping Address</h3>
                        
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="same-as-billing" name="sameAsBilling" checked>
                                <span class="checkmark"></span>
                                Use billing address for shipping
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label for="address" class="form-label">Street Address *</label>
                            <input type="text" id="address" name="address" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="address2" class="form-label">Apartment, suite, etc.</label>
                            <input type="text" id="address2" name="address2" class="form-input">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="city" class="form-label">City *</label>
                                <input type="text" id="city" name="city" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label for="state" class="form-label">State/Province *</label>
                                <select id="state" name="state" class="form-input form-select" required>
                                    <option value="">Select state</option>
                                    <option value="CA">California</option>
                                    <option value="NY">New York</option>
                                    <option value="TX">Texas</option>
                                    <option value="FL">Florida</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="zip" class="form-label">ZIP Code *</label>
                                <input type="text" id="zip" name="zip" class="form-input" required>
                            </div>
                        </div>
                        
                        <div class="shipping-options">
                            <h4>Shipping Method</h4>
                            <label class="shipping-option">
                                <input type="radio" name="shipping" value="standard" checked>
                                <span class="shipping-details">
                                    <span class="shipping-name">📦 Standard Shipping</span>
                                    <span class="shipping-time">5-7 business days</span>
                                    <span class="shipping-price">Free</span>
                                </span>
                            </label>
                            <label class="shipping-option">
                                <input type="radio" name="shipping" value="express">
                                <span class="shipping-details">
                                    <span class="shipping-name">🚀 Express Shipping</span>
                                    <span class="shipping-time">2-3 business days</span>
                                    <span class="shipping-price">$15.00</span>
                                </span>
                            </label>
                            <label class="shipping-option">
                                <input type="radio" name="shipping" value="overnight">
                                <span class="shipping-details">
                                    <span class="shipping-name">⚡ Overnight Shipping</span>
                                    <span class="shipping-time">Next business day</span>
                                    <span class="shipping-price">$35.00</span>
                                </span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Step 3: Payment Information -->
                    <div class="form-step" id="step-3">
                        <h3>💳 Payment Information</h3>
                        
                        <div class="payment-methods">
                            <label class="payment-method">
                                <input type="radio" name="payment" value="card" checked>
                                <span class="payment-icon">💳</span>
                                <span>Credit/Debit Card</span>
                            </label>
                            <label class="payment-method">
                                <input type="radio" name="payment" value="paypal">
                                <span class="payment-icon">🅿️</span>
                                <span>PayPal</span>
                            </label>
                            <label class="payment-method">
                                <input type="radio" name="payment" value="apple">
                                <span class="payment-icon">🍎</span>
                                <span>Apple Pay</span>
                            </label>
                        </div>
                        
                        <div id="card-form" class="payment-form">
                            <div class="form-group">
                                <label for="card-number" class="form-label">Card Number *</label>
                                <input type="text" id="card-number" name="cardNumber" class="form-input" 
                                       placeholder="1234 5678 9012 3456" maxlength="19">
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="expiry" class="form-label">Expiry Date *</label>
                                    <input type="text" id="expiry" name="expiry" class="form-input" 
                                           placeholder="MM/YY" maxlength="5">
                                </div>
                                <div class="form-group">
                                    <label for="cvv" class="form-label">CVV *</label>
                                    <input type="text" id="cvv" name="cvv" class="form-input" 
                                           placeholder="123" maxlength="4">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="card-name" class="form-label">Name on Card *</label>
                                <input type="text" id="card-name" name="cardName" class="form-input">
                            </div>
                        </div>
                        
                        <div class="security-info">
                            <div class="security-badge">
                                <span class="security-icon">🔒</span>
                                <span>Your payment information is encrypted and secure</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 4: Review Order -->
                    <div class="form-step" id="step-4">
                        <h3>📋 Review Your Order</h3>
                        
                        <div class="order-review">
                            <div class="review-section">
                                <h4>Contact Information</h4>
                                <div id="review-contact"></div>
                            </div>
                            
                            <div class="review-section">
                                <h4>Shipping Address</h4>
                                <div id="review-shipping"></div>
                            </div>
                            
                            <div class="review-section">
                                <h4>Payment Method</h4>
                                <div id="review-payment"></div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="terms" name="terms" required>
                                <span class="checkmark"></span>
                                I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-navigation">
                        <button type="button" id="prev-btn" class="btn btn-secondary" onclick="previousStep()" style="display: none;">
                            ← Previous
                        </button>
                        <button type="button" id="next-btn" class="btn btn-primary" onclick="nextStep()">
                            Next →
                        </button>
                        <button type="submit" id="submit-btn" class="btn btn-primary" style="display: none;">
                            Complete Order 🎉
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="checkout-sidebar">
                <div class="order-summary">
                    <h3>Order Summary</h3>
                    
                    <div class="summary-items">
                        <div class="summary-item">
                            <span class="item-name">🐘 TuskPHP Pro License</span>
                            <span class="item-price">$99.99</span>
                        </div>
                        <div class="summary-item">
                            <span class="item-name">🛠️ Developer Toolkit</span>
                            <span class="item-price">$49.99</span>
                        </div>
                    </div>
                    
                    <div class="summary-totals">
                        <div class="summary-line">
                            <span>Subtotal:</span>
                            <span>$149.98</span>
                        </div>
                        <div class="summary-line">
                            <span>Shipping:</span>
                            <span id="checkout-shipping">$0.00</span>
                        </div>
                        <div class="summary-line">
                            <span>Tax:</span>
                            <span>$12.00</span>
                        </div>
                        <div class="summary-line total">
                            <span>Total:</span>
                            <span id="checkout-total">$161.98</span>
                        </div>
                    </div>
                </div>
                
                <div class="trust-badges">
                    <h4>Secure Checkout</h4>
                    <div class="badges">
                        <span class="badge">🔒 SSL Secure</span>
                        <span class="badge">✅ Money Back Guarantee</span>
                        <span class="badge">🛡️ PCI Compliant</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
let currentStep = 1;
const totalSteps = 4;

function nextStep() {
    if (validateCurrentStep()) {
        if (currentStep < totalSteps) {
            showStep(currentStep + 1);
        }
    }
}

function previousStep() {
    if (currentStep > 1) {
        showStep(currentStep - 1);
    }
}

function showStep(step) {
    // Hide all steps
    document.querySelectorAll('.form-step').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
    
    // Show current step
    document.getElementById(`step-${step}`).classList.add('active');
    document.querySelector(`[data-step="${step}"]`).classList.add('active');
    
    currentStep = step;
    
    // Update navigation buttons
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const submitBtn = document.getElementById('submit-btn');
    
    prevBtn.style.display = step > 1 ? 'block' : 'none';
    
    if (step < totalSteps) {
        nextBtn.style.display = 'block';
        submitBtn.style.display = 'none';
    } else {
        nextBtn.style.display = 'none';
        submitBtn.style.display = 'block';
        updateReviewSection();
    }
}

function validateCurrentStep() {
    const currentStepElement = document.getElementById(`step-${currentStep}`);
    const requiredFields = currentStepElement.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.style.borderColor = '#f44336';
            isValid = false;
        } else {
            field.style.borderColor = '';
        }
    });
    
    // Additional validation for specific steps
    if (currentStep === 3) {
        const cardNumber = document.getElementById('card-number').value.replace(/\s/g, '');
        if (cardNumber && cardNumber.length < 13) {
            document.getElementById('card-number').style.borderColor = '#f44336';
            isValid = false;
        }
    }
    
    if (!isValid) {
        alert('Please fill in all required fields correctly.');
    }
    
    return isValid;
}

function updateReviewSection() {
    // Update contact info
    const firstName = document.getElementById('first-name').value;
    const lastName = document.getElementById('last-name').value;
    const email = document.getElementById('email').value;
    document.getElementById('review-contact').innerHTML = `
        <p>${firstName} ${lastName}</p>
        <p>${email}</p>
    `;
    
    // Update shipping info
    const address = document.getElementById('address').value;
    const city = document.getElementById('city').value;
    const state = document.getElementById('state').value;
    const zip = document.getElementById('zip').value;
    document.getElementById('review-shipping').innerHTML = `
        <p>${address}</p>
        <p>${city}, ${state} ${zip}</p>
    `;
    
    // Update payment info
    const paymentMethod = document.querySelector('input[name="payment"]:checked').value;
    const cardNumber = document.getElementById('card-number').value;
    const maskedCard = cardNumber ? `**** **** **** ${cardNumber.slice(-4)}` : '';
    document.getElementById('review-payment').innerHTML = `
        <p>${paymentMethod === 'card' ? `Credit Card ${maskedCard}` : paymentMethod}</p>
    `;
}

// Format card number input
document.getElementById('card-number').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\s/g, '');
    let formattedValue = value.replace(/(.{4})/g, '$1 ').trim();
    e.target.value = formattedValue;
});

// Format expiry date input
document.getElementById('expiry').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length >= 2) {
        value = value.substring(0, 2) + '/' + value.substring(2, 4);
    }
    e.target.value = value;
});

// Update shipping cost based on selection
document.querySelectorAll('input[name="shipping"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const shippingCosts = {
            'standard': 0,
            'express': 15,
            'overnight': 35
        };
        
        const cost = shippingCosts[this.value];
        document.getElementById('checkout-shipping').textContent = `${cost.toFixed(2)}`;
        
        // Update total
        const subtotal = 149.98;
        const tax = 12.00;
        const total = subtotal + cost + tax;
        document.getElementById('checkout-total').textContent = `${total.toFixed(2)}`;
    });
});

// Form submission
document.getElementById('checkout-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (validateCurrentStep()) {
        // Simulate order processing
        const submitBtn = document.getElementById('submit-btn');
        submitBtn.textContent = 'Processing... ⏳';
        submitBtn.disabled = true;
        
        setTimeout(() => {
            alert('🎉 Order completed successfully! You will receive a confirmation email shortly.');
            // In a real app, redirect to success page
            submitBtn.textContent = 'Complete Order 🎉';
            submitBtn.disabled = false;
        }, 3000);
    }
});

// Initialize checkout
document.addEventListener('DOMContentLoaded', function() {
    showStep(1);
});
</script>