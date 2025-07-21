<?php
/**
 * <?tusk> Enhanced Scroll to Top Component
 * Created: 2025-06-26
 * Strong. Secure. Scalable. 🐘
 *
 * <?tusk> scroll-to-top Component
 * Auto-Inclusion: [tusk-component-scroll-to-top]
 * Themes: default, dark, minimal, gradient, neon, corporate, warm, cool
 */

$theme = isset($theme) ? $theme : 'default';
$style = isset($style) ? $style : 'circle'; // circle, square, minimal, fab
$position = isset($position) ? $position : 'bottom-right'; // bottom-right, bottom-left
$show_progress = isset($show_progress) ? $show_progress : true;
$show_percentage = isset($show_percentage) ? $show_percentage : false;
$smooth_scroll = isset($smooth_scroll) ? $smooth_scroll : true;
?>

<div class="tusk-scroll-to-top tusk-scroll-to-top--<?php echo $theme; ?> tusk-scroll-to-top--<?php echo $style; ?> tusk-scroll-to-top--<?php echo $position; ?>" 
     id="scroll-to-top"
     role="button"
     tabindex="0"
     aria-label="Scroll to top of page"
     style="opacity: 0; visibility: hidden;">
    
    <?php if ($show_progress): ?>
    <div class="scroll-progress" aria-hidden="true">
        <svg class="progress-ring" width="60" height="60">
            <circle class="progress-ring-circle" 
                    cx="30" 
                    cy="30" 
                    r="26" 
                    stroke-width="4" 
                    fill="transparent"/>
        </svg>
    </div>
    <?php endif; ?>
    
    <div class="scroll-icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="18,15 12,9 6,15"/>
        </svg>
    </div>
    
    <?php if ($show_percentage): ?>
    <div class="scroll-percentage">0%</div>
    <?php endif; ?>
    
    <div class="scroll-tooltip">Back to Top</div>
</div>

<style>
/* Base Styles */
.tusk-scroll-to-top {
    position: fixed;
    z-index: 9999;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    user-select: none;
    outline: none;
}

/* Position Variants */
.tusk-scroll-to-top--bottom-right {
    bottom: 2rem;
    right: 2rem;
}

.tusk-scroll-to-top--bottom-left {
    bottom: 2rem;
    left: 2rem;
}

/* Style Variants */
.tusk-scroll-to-top--circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.tusk-scroll-to-top--square {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.tusk-scroll-to-top--minimal {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.tusk-scroll-to-top--fab {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

/* Progress Ring */
.scroll-progress {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.progress-ring {
    position: absolute;
    top: 0;
    left: 0;
    transform: rotate(-90deg);
}

.progress-ring-circle {
    stroke-dasharray: 163.36; /* 2 * π * 26 */
    stroke-dashoffset: 163.36;
    transition: stroke-dashoffset 0.1s ease;
}

/* Scroll Icon */
.scroll-icon {
    position: relative;
    z-index: 2;
    transition: transform 0.3s ease;
}

.tusk-scroll-to-top:hover .scroll-icon {
    transform: translateY(-2px);
}

/* Scroll Percentage */
.scroll-percentage {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 0.7rem;
    font-weight: 700;
    z-index: 3;
    pointer-events: none;
}

/* Tooltip */
.scroll-tooltip {
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    font-size: 0.8rem;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    margin-bottom: 0.5rem;
    pointer-events: none;
}

.scroll-tooltip::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    border: 4px solid transparent;
    border-top-color: rgba(0, 0, 0, 0.8);
}

.tusk-scroll-to-top:hover .scroll-tooltip {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(-4px);
}

/* Left position tooltip */
.tusk-scroll-to-top--bottom-left .scroll-tooltip {
    left: 100%;
    bottom: 50%;
    transform: translateY(50%);
    margin-left: 0.5rem;
    margin-bottom: 0;
}

.tusk-scroll-to-top--bottom-left .scroll-tooltip::after {
    top: 50%;
    left: 0;
    transform: translateX(-100%) translateY(-50%);
    border-top-color: transparent;
    border-right-color: rgba(0, 0, 0, 0.8);
}

.tusk-scroll-to-top--bottom-left:hover .scroll-tooltip {
    transform: translateY(50%) translateX(4px);
}

/* Animation States */
.tusk-scroll-to-top.show {
    opacity: 1 !important;
    visibility: visible !important;
    transform: scale(1);
}

.tusk-scroll-to-top.hide {
    opacity: 0 !important;
    visibility: hidden !important;
    transform: scale(0.8);
}

.tusk-scroll-to-top:active {
    transform: scale(0.95);
}

/* Theme Variants */
.tusk-scroll-to-top--default {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    box-shadow: 0 4px 20px rgba(52, 152, 219, 0.3);
}

.tusk-scroll-to-top--default:hover {
    background: linear-gradient(135deg, #2980b9, #3498db);
    box-shadow: 0 8px 30px rgba(52, 152, 219, 0.4);
    transform: translateY(-2px);
}

.tusk-scroll-to-top--default .progress-ring-circle {
    stroke: rgba(255, 255, 255, 0.3);
}

.tusk-scroll-to-top--dark {
    background: linear-gradient(135deg, #2c3e50, #34495e);
    color: #00ff88;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
}

.tusk-scroll-to-top--dark:hover {
    background: linear-gradient(135deg, #34495e, #2c3e50);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
    transform: translateY(-2px);
}

.tusk-scroll-to-top--dark .progress-ring-circle {
    stroke: rgba(0, 255, 136, 0.3);
}

.tusk-scroll-to-top--minimal {
    background: rgba(255, 255, 255, 0.9);
    color: #2c3e50;
    border: 1px solid #e9ecef;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.tusk-scroll-to-top--minimal:hover {
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
}

.tusk-scroll-to-top--minimal .progress-ring-circle {
    stroke: rgba(52, 152, 219, 0.3);
}

.tusk-scroll-to-top--gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
}

.tusk-scroll-to-top--gradient:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    box-shadow: 0 8px 30px rgba(102, 126, 234, 0.4);
    transform: translateY(-2px);
}

.tusk-scroll-to-top--gradient .progress-ring-circle {
    stroke: rgba(255, 255, 255, 0.3);
}

.tusk-scroll-to-top--neon {
    background: rgba(0, 20, 40, 0.9);
    color: #00ff88;
    border: 2px solid #00ff88;
    box-shadow: 0 0 20px rgba(0, 255, 136, 0.5);
}

.tusk-scroll-to-top--neon:hover {
    background: rgba(0, 255, 136, 0.1);
    box-shadow: 0 0 30px rgba(0, 255, 136, 0.7);
    transform: translateY(-2px);
}

.tusk-scroll-to-top--neon .progress-ring-circle {
    stroke: rgba(0, 255, 136, 0.5);
}

.tusk-scroll-to-top--corporate {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: #f39c12;
    box-shadow: 0 4px 20px rgba(30, 60, 114, 0.3);
}

.tusk-scroll-to-top--corporate:hover {
    background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);
    box-shadow: 0 8px 30px rgba(30, 60, 114, 0.4);
    transform: translateY(-2px);
}

.tusk-scroll-to-top--corporate .progress-ring-circle {
    stroke: rgba(243, 156, 18, 0.3);
}

.tusk-scroll-to-top--warm {
    background: linear-gradient(135deg, #ff9a56 0%, #ffad56 100%);
    color: white;
    box-shadow: 0 4px 20px rgba(255, 154, 86, 0.3);
}

.tusk-scroll-to-top--warm:hover {
    background: linear-gradient(135deg, #ffad56 0%, #ff9a56 100%);
    box-shadow: 0 8px 30px rgba(255, 154, 86, 0.4);
    transform: translateY(-2px);
}

.tusk-scroll-to-top--warm .progress-ring-circle {
    stroke: rgba(255, 255, 255, 0.3);
}

.tusk-scroll-to-top--cool {
    background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
    color: white;
    box-shadow: 0 4px 20px rgba(116, 185, 255, 0.3);
}

.tusk-scroll-to-top--cool:hover {
    background: linear-gradient(135deg, #0984e3 0%, #74b9ff 100%);
    box-shadow: 0 8px 30px rgba(116, 185, 255, 0.4);
    transform: translateY(-2px);
}

.tusk-scroll-to-top--cool .progress-ring-circle {
    stroke: rgba(255, 255, 255, 0.3);
}

/* Responsive Design */
@media (max-width: 768px) {
    .tusk-scroll-to-top--bottom-right {
        bottom: 1.5rem;
        right: 1.5rem;
    }
    
    .tusk-scroll-to-top--bottom-left {
        bottom: 1.5rem;
        left: 1.5rem;
    }
    
    .tusk-scroll-to-top--circle {
        width: 50px;
        height: 50px;
    }
    
    .tusk-scroll-to-top--fab {
        width: 48px;
        height: 48px;
    }
    
    .progress-ring {
        width: 50px;
        height: 50px;
    }
    
    .progress-ring-circle {
        cx: 25;
        cy: 25;
        r: 21;
        stroke-dasharray: 131.95; /* 2 * π * 21 */
        stroke-dashoffset: 131.95;
    }
    
    .scroll-icon svg {
        width: 18px;
        height: 18px;
    }
}

@media (max-width: 480px) {
    .tusk-scroll-to-top--bottom-right {
        bottom: 1rem;
        right: 1rem;
    }
    
    .tusk-scroll-to-top--bottom-left {
        bottom: 1rem;
        left: 1rem;
    }
    
    .scroll-tooltip {
        display: none;
    }
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
    .tusk-scroll-to-top {
        transition: opacity 0.3s ease;
    }
    
    .scroll-icon,
    .scroll-tooltip,
    .progress-ring-circle {
        transition: none;
    }
}

/* High contrast mode */
@media (prefers-contrast: high) {
    .tusk-scroll-to-top {
        border: 2px solid black;
    }
}

/* Print styles */
@media print {
    .tusk-scroll-to-top {
        display: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const scrollToTop = document.getElementById('scroll-to-top');
    const progressRingCircle = scrollToTop?.querySelector('.progress-ring-circle');
    const scrollPercentage = scrollToTop?.querySelector('.scroll-percentage');
    
    if (!scrollToTop) return;
    
    let isScrolling = false;
    let showThreshold = 300; // Show button after 300px scroll
    let ticking = false;
    
    // Configuration
    const smoothScroll = <?php echo $smooth_scroll ? 'true' : 'false'; ?>;
    const showProgress = <?php echo $show_progress ? 'true' : 'false'; ?>;
    const showPercentageText = <?php echo $show_percentage ? 'true' : 'false'; ?>;
    
    // Initialize
    initializeScrollToTop();
    
    function initializeScrollToTop() {
        // Scroll event listener
        window.addEventListener('scroll', handleScroll, { passive: true });
        
        // Click event listener
        scrollToTop.addEventListener('click', handleClick);
        
        // Keyboard event listener
        scrollToTop.addEventListener('keydown', handleKeydown);
        
        // Touch events for mobile
        scrollToTop.addEventListener('touchstart', handleTouchStart, { passive: true });
        
        // Initial state
        updateScrollProgress();
        updateVisibility();
    }
    
    function handleScroll() {
        if (!ticking) {
            requestAnimationFrame(() => {
                updateScrollProgress();
                updateVisibility();
                ticking = false;
            });
            ticking = true;
        }
    }
    
    function handleClick(e) {
        e.preventDefault();
        scrollToTopOfPage();
        
        // Analytics
        logScrollToTopInteraction('click');
    }
    
    function handleKeydown(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            scrollToTopOfPage();
            logScrollToTopInteraction('keyboard');
        }
    }
    
    function handleTouchStart() {
        // Add touch feedback
        scrollToTop.style.transform = 'scale(0.95)';
        
        setTimeout(() => {
            scrollToTop.style.transform = '';
        }, 150);
    }
    
    function updateScrollProgress() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrollPercentageValue = Math.min((scrollTop / scrollHeight) * 100, 100);
        
        // Update progress ring
        if (showProgress && progressRingCircle) {
            const circumference = 2 * Math.PI * 26; // r = 26 for desktop, 21 for mobile
            const strokeDashoffset = circumference - (scrollPercentageValue / 100) * circumference;
            progressRingCircle.style.strokeDashoffset = strokeDashoffset;
        }
        
        // Update percentage text
        if (showPercentageText && scrollPercentage) {
            scrollPercentage.textContent = Math.round(scrollPercentageValue) + '%';
        }
    }
    
    function updateVisibility() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > showThreshold) {
            if (!scrollToTop.classList.contains('show')) {
                scrollToTop.classList.add('show');
                scrollToTop.classList.remove('hide');
            }
        } else {
            if (scrollToTop.classList.contains('show')) {
                scrollToTop.classList.remove('show');
                scrollToTop.classList.add('hide');
            }
        }
    }
    
    function scrollToTopOfPage() {
        if (isScrolling) return;
        
        isScrolling = true;
        
        if (smoothScroll && 'scrollBehavior' in document.documentElement.style) {
            // Native smooth scroll
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            
            // Reset flag after animation
            setTimeout(() => {
                isScrolling = false;
            }, 1000);
        } else {
            // Custom smooth scroll for better browser support
            animateScrollToTop();
        }
    }
    
    function animateScrollToTop() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > 0) {
            const scrollStep = Math.PI / (500 / 15); // 500ms duration
            const cosParameter = scrollTop / 2;
            let scrollCount = 0;
            let scrollMargin;
            
            const scrollInterval = setInterval(() => {
                if (window.pageYOffset !== 0) {
                    scrollCount += 1;
                    scrollMargin = cosParameter - cosParameter * Math.cos(scrollCount * scrollStep);
                    window.scrollTo(0, (scrollTop - scrollMargin));
                } else {
                    clearInterval(scrollInterval);
                    isScrolling = false;
                }
            }, 15);
        } else {
            isScrolling = false;
        }
    }
    
    function logScrollToTopInteraction(method) {
        console.log(`Scroll to top triggered via: ${method}`);
        
        // Send analytics event
        if (typeof gtag !== 'undefined') {
            gtag('event', 'scroll_to_top', {
                'method': method,
                'scroll_depth': Math.round((window.pageYOffset / (document.documentElement.scrollHeight - document.documentElement.clientHeight)) * 100)
            });
        }
        
        // Custom event
        scrollToTop.dispatchEvent(new CustomEvent('scrollToTop', {
            detail: { method, timestamp: Date.now() }
        }));
    }
    
    // Update progress ring circumference for mobile
    function updateProgressRingForMobile() {
        if (window.innerWidth <= 768 && progressRingCircle) {
            const circumference = 2 * Math.PI * 21; // Mobile radius
            progressRingCircle.style.strokeDasharray = circumference;
            progressRingCircle.style.strokeDashoffset = circumference;
        }
    }
    
    // Handle window resize
    window.addEventListener('resize', () => {
        updateProgressRingForMobile();
        updateScrollProgress();
    });
    
    // Initial mobile check
    updateProgressRingForMobile();
    
    // Page visibility change handler
    document.addEventListener('visibilitychange', () => {
        if (!document.hidden) {
            updateScrollProgress();
            updateVisibility();
        }
    });
    
    // Intersection Observer for performance optimization
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // User scrolled back to top, hide button faster
                if (scrollToTop.classList.contains('show')) {
                    scrollToTop.classList.remove('show');
                    scrollToTop.classList.add('hide');
                }
            }
        });
    }, { threshold: 0.1 });
    
    // Observe the header or first section
    const header = document.querySelector('header') || document.querySelector('section');
    if (header) {
        observer.observe(header);
    }
    
    // Expose methods globally for external use
    window.TuskScrollToTop = {
        scrollToTop: scrollToTopOfPage,
        show: () => {
            scrollToTop.classList.add('show');
            scrollToTop.classList.remove('hide');
        },
        hide: () => {
            scrollToTop.classList.remove('show');
            scrollToTop.classList.add('hide');
        },
        setThreshold: (threshold) => {
            showThreshold = threshold;
            updateVisibility();
        }
    };
});
</script>