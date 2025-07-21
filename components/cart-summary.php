<?php
/**
 * cart-summary.php
 * Enhanced shopping cart with dynamic updates and calculations
 */
?>

<section class="tusk-ecommerce-cart-summary" id="cart">
    <div class="ecommerce-container">
        <h2>🛒 Shopping Cart</h2>
        <p>Review your items and proceed to checkout</p>
        
        <div class="cart-content">
            <div class="cart-items" id="cart-items">
                <!-- Cart items will be populated by JavaScript -->
            </div>
            
            <div class="cart-sidebar">
                <div class="cart-summary">
                    <h3>Order Summary</h3>
                    
                    <div class="summary-line">
                        <span>Subtotal:</span>
                        <span id="subtotal">$0.00</span>
                    </div>
                    
                    <div class="summary-line">
                        <span>Shipping:</span>
                        <span id="shipping">$0.00</span>
                    </div>
                    
                    <div class="summary-line">
                        <span>Tax:</span>
                        <span id="tax">$0.00</span>
                    </div>
                    
                    <div class="promo-code">
                        <input type="text" id="promo-input" placeholder="Enter promo code" class="form-input">
                        <button class="btn btn-secondary" onclick="applyPromoCode()">Apply</button>
                    </div>
                    
                    <div class="summary-line discount" id="discount-line" style="display: none;">
                        <span>Discount:</span>
                        <span id="discount">-$0.00</span>
                    </div>
                    
                    <div class="summary-line total">
                        <span>Total:</span>
                        <span id="total">$0.00</span>
                    </div>
                    
                    <button class="btn btn-primary full-width" onclick="proceedToCheckout()">
                        Proceed to Checkout 💳
                    </button>
                    
                    <div class="payment-options">
                        <h4>We Accept:</h4>
                        <div class="payment-methods">
                            <span class="payment-method">💳</span>
                            <span class="payment-method">🅿️</span>
                            <span class="payment-method">🍎</span>
                            <span class="payment-method">🅰️</span>
                        </div>
                    </div>
                </div>
                
                <div class="shipping-calculator">
                    <h4>Shipping Calculator</h4>
                    <select id="shipping-country" onchange="calculateShipping()">
                        <option value="US">United States - Free</option>
                        <option value="CA">Canada - $15.00</option>
                        <option value="UK">United Kingdom - $25.00</option>
                        <option value="EU">Europe - $30.00</option>
                        <option value="INTL">International - $45.00</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="cart-empty" id="cart-empty" style="display: none;">
            <div class="empty-cart-message">
                <div class="empty-icon">🛒</div>
                <h3>Your cart is empty</h3>
                <p>Add some awesome products to get started!</p>
                <button class="btn btn-primary" onclick="addSampleProducts()">Add Sample Products</button>
            </div>
        </div>
    </div>
</section>

<script>
let cartItems = [];
let promoCodes = {
    'SAVE10': { discount: 0.10, description: '10% off' },
    'WELCOME': { discount: 15, description: '$15 off' },
    'FREESHIP': { shipping: 0, description: 'Free shipping' }
};

let appliedPromo = null;

const sampleProducts = [
    { id: 1, name: 'TuskPHP Pro License', price: 99.99, image: '🐘', category: 'Software' },
    { id: 2, name: 'Developer Toolkit', price: 49.99, image: '🛠️', category: 'Tools' },
    { id: 3, name: 'Premium Support', price: 29.99, image: '🎯', category: 'Support' },
    { id: 4, name: 'Custom Theme Pack', price: 19.99, image: '🎨', category: 'Themes' }
];

function addSampleProducts() {
    cartItems = sampleProducts.map(product => ({
        ...product,
        quantity: Math.floor(Math.random() * 3) + 1
    }));
    updateCartDisplay();
}

function updateCartDisplay() {
    const cartItemsContainer = document.getElementById('cart-items');
    const cartEmpty = document.getElementById('cart-empty');
    
    if (cartItems.length === 0) {
        cartItemsContainer.style.display = 'none';
        cartEmpty.style.display = 'block';
        updateSummary();
        return;
    }
    
    cartItemsContainer.style.display = 'block';
    cartEmpty.style.display = 'none';
    
    cartItemsContainer.innerHTML = cartItems.map(item => `
        <div class="cart-item" data-id="${item.id}">
            <div class="item-image">
                <span class="product-icon">${item.image}</span>
            </div>
            
            <div class="item-details">
                <h4 class="item-name">${item.name}</h4>
                <p class="item-category">${item.category}</p>
                <p class="item-price">$${item.price.toFixed(2)}</p>
            </div>
            
            <div class="item-quantity">
                <button class="quantity-btn" onclick="updateQuantity(${item.id}, -1)">-</button>
                <span class="quantity">${item.quantity}</span>
                <button class="quantity-btn" onclick="updateQuantity(${item.id}, 1)">+</button>
            </div>
            
            <div class="item-total">
                <span class="total-price">$${(item.price * item.quantity).toFixed(2)}</span>
                <button class="remove-btn" onclick="removeItem(${item.id})" title="Remove item">
                    🗑️
                </button>
            </div>
        </div>
    `).join('');
    
    updateSummary();
}

function updateQuantity(itemId, change) {
    const item = cartItems.find(item => item.id === itemId);
    if (item) {
        item.quantity = Math.max(1, item.quantity + change);
        updateCartDisplay();
    }
}

function removeItem(itemId) {
    cartItems = cartItems.filter(item => item.id !== itemId);
    updateCartDisplay();
    
    // Show removal animation
    const removedElement = document.querySelector(`[data-id="${itemId}"]`);
    if (removedElement) {
        removedElement.style.animation = 'fadeOut 0.3s ease';
    }
}

function calculateShipping() {
    const country = document.getElementById('shipping-country').value;
    const shippingRates = {
        'US': 0,
        'CA': 15,
        'UK': 25,
        'EU': 30,
        'INTL': 45
    };
    
    const shippingCost = appliedPromo && appliedPromo.shipping !== undefined 
        ? appliedPromo.shipping 
        : shippingRates[country] || 0;
    
    document.getElementById('shipping').textContent = `$${shippingCost.toFixed(2)}`;
    updateSummary();
}

function applyPromoCode() {
    const promoInput = document.getElementById('promo-input');
    const code = promoInput.value.toUpperCase().trim();
    
    if (promoCodes[code]) {
        appliedPromo = promoCodes[code];
        promoInput.value = '';
        promoInput.style.borderColor = '#4CAF50';
        
        // Show success message
        showPromoMessage(`✅ Promo code applied: ${appliedPromo.description}`, 'success');
        
        updateSummary();
        calculateShipping(); // Recalculate shipping if promo affects it
    } else {
        promoInput.style.borderColor = '#f44336';
        showPromoMessage('❌ Invalid promo code', 'error');
        
        setTimeout(() => {
            promoInput.style.borderColor = '';
        }, 2000);
    }
}

function showPromoMessage(message, type) {
    const existingMessage = document.querySelector('.promo-message');
    if (existingMessage) {
        existingMessage.remove();
    }
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `promo-message ${type}`;
    messageDiv.textContent = message;
    
    const promoCode = document.querySelector('.promo-code');
    promoCode.appendChild(messageDiv);
    
    setTimeout(() => {
        if (messageDiv.parentNode) {
            messageDiv.remove();
        }
    }, 3000);
}

function updateSummary() {
    const subtotal = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const shippingText = document.getElementById('shipping').textContent;
    const shipping = parseFloat(shippingText.replace(', '')) || 0;
    const taxRate = 0.08; // 8% tax
    const tax = subtotal * taxRate;
    
    let discount = 0;
    if (appliedPromo) {
        if (appliedPromo.discount < 1) {
            // Percentage discount
            discount = subtotal * appliedPromo.discount;
        } else {
            // Fixed amount discount
            discount = Math.min(appliedPromo.discount, subtotal);
        }
    }
    
    const total = subtotal + shipping + tax - discount;
    
    document.getElementById('subtotal').textContent = `${subtotal.toFixed(2)}`;
    document.getElementById('tax').textContent = `${tax.toFixed(2)}`;
    document.getElementById('total').textContent = `${Math.max(0, total).toFixed(2)}`;
    
    // Show/hide discount line
    const discountLine = document.getElementById('discount-line');
    if (discount > 0) {
        discountLine.style.display = 'flex';
        document.getElementById('discount').textContent = `-${discount.toFixed(2)}`;
    } else {
        discountLine.style.display = 'none';
    }
}

function proceedToCheckout() {
    if (cartItems.length === 0) {
        alert('Your cart is empty! Add some products first.');
        return;
    }
    
    // Simulate checkout process
    const total = document.getElementById('total').textContent;
    const itemCount = cartItems.reduce((sum, item) => sum + item.quantity, 0);
    
    if (confirm(`Proceed to checkout with ${itemCount} items for ${total}?`)) {
        // In a real application, this would redirect to checkout
        alert('Redirecting to secure checkout...');
        
        // Simulate order processing
        setTimeout(() => {
            alert('Order placed successfully! 🎉');
            cartItems = [];
            appliedPromo = null;
            updateCartDisplay();
        }, 2000);
    }
}

// Initialize cart on page load
document.addEventListener('DOMContentLoaded', function() {
    calculateShipping();
    updateCartDisplay();
});
</script>