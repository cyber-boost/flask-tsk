<?php
/**
 * counters.php
 * Enhanced animated counters with intersection observer and custom formatting
 */
?>

<section class="tusk-data-counters" id="counters">
    <div class="data-container">
        <h2>📊 Animated Counters</h2>
        <p>Watch our impressive statistics come to life with smooth animations</p>
        
        <div class="counters-grid">
            <div class="counter-item" data-target="15000" data-suffix="+">
                <div class="counter-icon">👥</div>
                <span class="counter-number">0</span>
                <div class="counter-label">Happy Customers</div>
                <div class="counter-description">Worldwide users trust TuskPHP</div>
            </div>
            
            <div class="counter-item" data-target="99.9" data-suffix="%" data-decimals="1">
                <div class="counter-icon">⚡</div>
                <span class="counter-number">0</span>
                <div class="counter-label">Uptime</div>
                <div class="counter-description">Reliable performance 24/7</div>
            </div>
            
            <div class="counter-item" data-target="250" data-suffix="ms" data-prefix="<">
                <div class="counter-icon">🚀</div>
                <span class="counter-number">0</span>
                <div class="counter-label">Response Time</div>
                <div class="counter-description">Lightning fast load times</div>
            </div>
            
            <div class="counter-item" data-target="50" data-suffix="+" data-format="countries">
                <div class="counter-icon">🌍</div>
                <span class="counter-number">0</span>
                <div class="counter-label">Countries</div>
                <div class="counter-description">Global reach and presence</div>
            </div>
            
            <div class="counter-item" data-target="1000000" data-format="large" data-suffix="+">
                <div class="counter-icon">📈</div>
                <span class="counter-number">0</span>
                <div class="counter-label">API Calls/Month</div>
                <div class="counter-description">Handling massive scale</div>
            </div>
            
            <div class="counter-item" data-target="24" data-suffix="/7">
                <div class="counter-icon">🛠️</div>
                <span class="counter-number">0</span>
                <div class="counter-label">Support</div>
                <div class="counter-description">Always here to help</div>
            </div>
        </div>
        
        <div class="counter-controls">
            <button class="btn btn-primary" onclick="resetCounters()">🔄 Reset Animation</button>
            <button class="btn btn-secondary" onclick="toggleCounterDetails()">📋 Show Details</button>
        </div>
        
        <div class="counter-details" id="counter-details" style="display: none;">
            <h3>📈 Statistics Breakdown</h3>
            <div class="details-grid">
                <div class="detail-item">
                    <strong>Growth Rate:</strong> 150% year over year
                </div>
                <div class="detail-item">
                    <strong>Customer Satisfaction:</strong> 4.9/5 stars
                </div>
                <div class="detail-item">
                    <strong>Performance Improvement:</strong> 40% faster than competitors
                </div>
                <div class="detail-item">
                    <strong>Security Score:</strong> A+ rated security
                </div>
            </div>
        </div>
    </div>
</section>

<script>
let countersAnimated = false;

function formatNumber(number, format) {
    if (format === 'large') {
        if (number >= 1000000) {
            return (number / 1000000).toFixed(1) + 'M';
        } else if (number >= 1000) {
            return (number / 1000).toFixed(1) + 'K';
        }
    }
    return number.toLocaleString();
}

function animateCounter(element) {
    const target = parseFloat(element.getAttribute('data-target'));
    const suffix = element.getAttribute('data-suffix') || '';
    const prefix = element.getAttribute('data-prefix') || '';
    const decimals = parseInt(element.getAttribute('data-decimals')) || 0;
    const format = element.getAttribute('data-format');
    const numberElement = element.querySelector('.counter-number');
    
    const duration = 2000; // 2 seconds
    const steps = 60;
    const increment = target / steps;
    let current = 0;
    let step = 0;
    
    const timer = setInterval(() => {
        step++;
        current += increment;
        
        if (step >= steps) {
            current = target;
            clearInterval(timer);
        }
        
        let displayValue = current;
        if (format) {
            displayValue = formatNumber(current, format);
        } else {
            displayValue = decimals > 0 ? current.toFixed(decimals) : Math.round(current);
        }
        
        numberElement.textContent = prefix + displayValue + suffix;
        
        // Add pulse effect on completion
        if (step >= steps) {
            element.classList.add('completed');
            setTimeout(() => element.classList.remove('completed'), 600);
        }
    }, duration / steps);
}

function animateCounters() {
    if (countersAnimated) return;
    
    const counterItems = document.querySelectorAll('.counter-item');
    counterItems.forEach((item, index) => {
        setTimeout(() => {
            item.classList.add('animate');
            animateCounter(item);
        }, index * 200); // Stagger animations
    });
    
    countersAnimated = true;
}

function resetCounters() {
    countersAnimated = false;
    const counterItems = document.querySelectorAll('.counter-item');
    
    counterItems.forEach(item => {
        item.classList.remove('animate', 'completed');
        item.querySelector('.counter-number').textContent = '0';
    });
    
    setTimeout(animateCounters, 500);
}

function toggleCounterDetails() {
    const details = document.getElementById('counter-details');
    const button = event.target;
    
    if (details.style.display === 'none') {
        details.style.display = 'block';
        button.textContent = '📋 Hide Details';
    } else {
        details.style.display = 'none';
        button.textContent = '📋 Show Details';
    }
}

// Intersection Observer for auto-animation
const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && !countersAnimated) {
            animateCounters();
        }
    });
}, { threshold: 0.5 });

// Observe the counters section
document.addEventListener('DOMContentLoaded', function() {
    const countersSection = document.getElementById('counters');
    if (countersSection) {
        counterObserver.observe(countersSection);
    }
});
</script>