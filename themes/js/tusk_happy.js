/**
 * 🐘 TuskPHP Happy Theme JavaScript
 * =================================
 * Delightful interactions and joyful animations
 */

(function() {
    'use strict';
    
    // Happy Theme Namespace
    window.TuskHappy = {
        // Configuration
        config: {
            confettiColors: ['#ff6b9d', '#4ecdc4', '#ffe66d', '#a8e6cf', '#ff9a9e'],
            sparkleEmojis: ['✨', '🌟', '⭐', '💫', '🎉'],
            celebrationEmojis: ['🎉', '🎊', '🥳', '🎈', '🎁', '🍾', '🎆'],
            encouragementPhrases: [
                'You\'re doing great! 🌟',
                'Keep it up! 💪',
                'Awesome work! 🎉',
                'You\'re amazing! ✨',
                'Fantastic! 🚀'
            ]
        },
        
        // Initialize happy theme
        init: function() {
            this.initHappyEffects();
            this.initCelebrations();
            this.initDelightfulFeedback();
            this.initFloatingEmojis();
            this.initHappyAnimations();
            this.initMoodBooster();
            this.addHappyListeners();
            
            console.log('🐘 TuskPHP Happy Theme loaded - Spreading joy! ✨');
            this.showWelcomeMessage();
        },
        
        // Show welcome message
        showWelcomeMessage: function() {
            setTimeout(() => {
                this.createJoyfulNotification('Welcome to TuskPHP! 🎉', 'success', {
                    duration: 4000,
                    showConfetti: true
                });
            }, 1000);
        },
        
        // Initialize happy effects
        initHappyEffects: function() {
            // Add sparkle effects to buttons
            document.querySelectorAll('.btn-happy').forEach(btn => {
                btn.addEventListener('mouseenter', this.addSparkleEffect.bind(this));
                btn.addEventListener('click', this.createButtonCelebration.bind(this));
            });
            
            // Add hover effects to cards
            document.querySelectorAll('.card-happy').forEach(card => {
                card.addEventListener('mouseenter', this.cardHoverEffect.bind(this));
                card.addEventListener('mouseleave', this.cardLeaveEffect.bind(this));
            });
        },
        
        // Add sparkle effect
        addSparkleEffect: function(event) {
            const button = event.target.closest('.btn-happy');
            const sparkles = [];
            
            for (let i = 0; i < 5; i++) {
                const sparkle = document.createElement('span');
                sparkle.textContent = this.config.sparkleEmojis[Math.floor(Math.random() * this.config.sparkleEmojis.length)];
                sparkle.style.cssText = `
                    position: absolute;
                    pointer-events: none;
                    font-size: 12px;
                    z-index: 1000;
                    animation: sparkleFloat 1s ease-out forwards;
                `;
                
                const rect = button.getBoundingClientRect();
                sparkle.style.left = (rect.left + Math.random() * rect.width) + 'px';
                sparkle.style.top = (rect.top + Math.random() * rect.height) + 'px';
                
                document.body.appendChild(sparkle);
                sparkles.push(sparkle);
                
                setTimeout(() => sparkle.remove(), 1000);
            }
        },
        
        // Button celebration effect
        createButtonCelebration: function(event) {
            const button = event.target.closest('.btn-happy');
            this.createConfetti(button, 15);
            
            // Add success message for form submissions
            if (button.type === 'submit') {
                setTimeout(() => {
                    this.createJoyfulNotification('Form submitted successfully! 🎉', 'success');
                }, 500);
            }
        },
        
        // Card hover effect
        cardHoverEffect: function(event) {
            const card = event.target.closest('.card-happy');
            this.addFloatingEmoji(card, '💖');
        },
        
        // Card leave effect
        cardLeaveEffect: function(event) {
            // Gentle animation when leaving
            const card = event.target.closest('.card-happy');
            card.style.transition = 'all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
        },
        
        // Initialize celebrations
        initCelebrations: function() {
            // Celebrate successful form submissions
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', (e) => {
                    if (this.validateForm(form)) {
                        this.celebrateSuccess();
                    }
                });
            });
            
            // Celebrate completed tasks
            document.querySelectorAll('.task-complete').forEach(task => {
                task.addEventListener('change', (e) => {
                    if (e.target.checked) {
                        this.celebrateTaskCompletion(e.target);
                    }
                });
            });
        },
        
        // Celebrate success
        celebrateSuccess: function() {
            this.createFullScreenConfetti();
            this.createJoyfulNotification('🎉 Success! You\'re amazing!', 'success', {
                duration: 3000,
                showConfetti: true
            });
            
            // Play happy sound if available
            this.playHappySound();
        },
        
        // Celebrate task completion
        celebrateTaskCompletion: function(checkbox) {
            const rect = checkbox.getBoundingClientRect();
            this.createConfetti(checkbox, 10);
            
            // Add completion animation
            const task = checkbox.closest('.task-item') || checkbox.closest('li');
            if (task) {
                task.style.animation = 'taskComplete 0.6s ease-out';
            }
            
            this.createJoyfulNotification('Task completed! 🌟', 'success', {
                duration: 2000
            });
        },
        
        // Initialize delightful feedback
        initDelightfulFeedback: function() {
            // Form validation feedback
            document.querySelectorAll('.form-control-happy').forEach(input => {
                input.addEventListener('input', this.handleInputFeedback.bind(this));
                input.addEventListener('focus', this.handleInputFocus.bind(this));
                input.addEventListener('blur', this.handleInputBlur.bind(this));
            });
            
            // Progress bar animations
            document.querySelectorAll('.progress-bar-happy').forEach(bar => {
                this.animateProgressBar(bar);
            });
        },
        
        // Handle input feedback
        handleInputFeedback: function(event) {
            const input = event.target;
            const value = input.value.trim();
            
            if (value.length > 0) {
                this.showInputEncouragement(input);
            }
            
            // Real-time validation feedback
            if (input.checkValidity()) {
                this.showInputSuccess(input);
            }
        },
        
        // Show input encouragement
        showInputEncouragement: function(input) {
            const encouragement = this.config.encouragementPhrases[
                Math.floor(Math.random() * this.config.encouragementPhrases.length)
            ];
            
            // Create temporary encouragement bubble
            const bubble = document.createElement('div');
            bubble.textContent = encouragement;
            bubble.style.cssText = `
                position: absolute;
                background: var(--gradient-joy);
                color: white;
                padding: 4px 8px;
                border-radius: 12px;
                font-size: 12px;
                font-weight: 500;
                z-index: 1000;
                pointer-events: none;
                animation: encouragementPop 2s ease-out forwards;
            `;
            
            const rect = input.getBoundingClientRect();
            bubble.style.left = (rect.right + 10) + 'px';
            bubble.style.top = (rect.top + rect.height / 2) + 'px';
            
            document.body.appendChild(bubble);
            setTimeout(() => bubble.remove(), 2000);
        },
        
        // Show input success
        showInputSuccess: function(input) {
            input.style.borderColor = 'var(--joy-green)';
            input.style.boxShadow = '0 0 0 3px rgba(193, 251, 164, 0.3)';
            
            // Add success icon
            const icon = input.parentNode.querySelector('.form-icon-happy');
            if (icon) {
                icon.textContent = '✅';
                icon.style.animation = 'wiggle 0.6s ease-in-out';
            }
        },
        
        // Initialize floating emojis
        initFloatingEmojis: function() {
            // Add floating emojis to page
            this.createFloatingEmojis();
            
            // Add emojis on scroll milestones
            let lastScrollTop = 0;
            window.addEventListener('scroll', () => {
                const scrollTop = window.pageYOffset;
                
                // Every 500px of scrolling, add a celebration
                if (Math.floor(scrollTop / 500) > Math.floor(lastScrollTop / 500)) {
                    this.addRandomFloatingEmoji();
                }
                
                lastScrollTop = scrollTop;
            });
        },
        
        // Create floating emojis
        createFloatingEmojis: function() {
            const emojis = ['🌟', '✨', '💖', '🦋', '🌈', '🎈'];
            
            for (let i = 0; i < 4; i++) {
                setTimeout(() => {
                    this.addFloatingEmoji(document.body, emojis[i % emojis.length]);
                }, i * 1000);
            }
        },
        
        // Add floating emoji
        addFloatingEmoji: function(container, emoji) {
            const emojiEl = document.createElement('div');
            emojiEl.textContent = emoji;
            emojiEl.className = 'emoji-float';
            emojiEl.style.cssText = `
                position: fixed;
                font-size: 2rem;
                opacity: 0.6;
                pointer-events: none;
                z-index: 100;
                animation: float 3s ease-in-out infinite;
                left: ${Math.random() * window.innerWidth}px;
                top: ${Math.random() * window.innerHeight}px;
            `;
            
            document.body.appendChild(emojiEl);
            
            setTimeout(() => {
                emojiEl.remove();
            }, 5000);
        },
        
        // Add random floating emoji
        addRandomFloatingEmoji: function() {
            const emojis = ['🎉', '⭐', '💫', '🌟', '✨', '🎊'];
            const emoji = emojis[Math.floor(Math.random() * emojis.length)];
            this.addFloatingEmoji(document.body, emoji);
        },
        
        // Initialize happy animations
        initHappyAnimations: function() {
            // Animate elements on scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const element = entry.target;
                        element.style.animation = 'happyFadeIn 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                        
                        // Add celebration for important elements
                        if (element.classList.contains('celebrate-on-view')) {
                            this.createConfetti(element, 8);
                        }
                    }
                });
            }, { threshold: 0.2 });
            
            document.querySelectorAll('.animate-happy').forEach(el => {
                observer.observe(el);
            });
        },
        
        // Initialize mood booster
        initMoodBooster: function() {
            // Random encouragement throughout session
            setInterval(() => {
                if (Math.random() < 0.1) { // 10% chance every interval
                    this.showRandomEncouragement();
                }
            }, 30000); // Every 30 seconds
            
            // Celebrate time spent on site
            setTimeout(() => {
                this.createJoyfulNotification('Thanks for spending time with us! 💖', 'info', {
                    duration: 3000
                });
            }, 60000); // After 1 minute
        },
        
        // Show random encouragement
        showRandomEncouragement: function() {
            const messages = [
                'You\'re doing great! 🌟',
                'Keep up the awesome work! 💪',
                'You brighten our day! ☀️',
                'You\'re amazing! ✨',
                'Thanks for being awesome! 💖'
            ];
            
            const message = messages[Math.floor(Math.random() * messages.length)];
            this.createJoyfulNotification(message, 'info', {
                duration: 2500,
                showSparkles: true
            });
        },
        
        // Add happy event listeners
        addHappyListeners: function() {
            // Easter egg: Konami code for extra celebration
            let konamiCode = [];
            const konamiSequence = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65]; // ↑↑↓↓←→←→BA
            
            document.addEventListener('keydown', (e) => {
                konamiCode.push(e.keyCode);
                if (konamiCode.length > konamiSequence.length) {
                    konamiCode.shift();
                }
                
                if (konamiCode.join(',') === konamiSequence.join(',')) {
                    this.triggerSuperCelebration();
                    konamiCode = [];
                }
            });
            
            // Double-click celebration
            document.addEventListener('dblclick', (e) => {
                if (e.target.classList.contains('celebrate-dblclick')) {
                    this.createConfetti(e.target, 12);
                }
            });
        },
        
        // Trigger super celebration
        triggerSuperCelebration: function() {
            this.createFullScreenConfetti();
            this.createJoyfulNotification('🎉 SUPER CELEBRATION! You found the secret! 🎉', 'success', {
                duration: 5000,
                showConfetti: true
            });
            
            // Rainbow background flash
            document.body.style.animation = 'rainbowFlash 2s ease-in-out';
            setTimeout(() => {
                document.body.style.animation = '';
            }, 2000);
        },
        
        // Utility functions
        createConfetti: function(element, count = 20) {
            const rect = element.getBoundingClientRect();
            const colors = this.config.confettiColors;
            
            for (let i = 0; i < count; i++) {
                const confetti = document.createElement('div');
                confetti.style.cssText = `
                    position: fixed;
                    width: 8px;
                    height: 8px;
                    background: ${colors[Math.floor(Math.random() * colors.length)]};
                    pointer-events: none;
                    z-index: 1000;
                    border-radius: 50%;
                    animation: confettiFall 3s ease-out forwards;
                    left: ${rect.left + Math.random() * rect.width}px;
                    top: ${rect.top}px;
                `;
                
                document.body.appendChild(confetti);
                setTimeout(() => confetti.remove(), 3000);
            }
        },
        
        createFullScreenConfetti: function() {
            for (let i = 0; i < 50; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.textContent = this.config.celebrationEmojis[
                        Math.floor(Math.random() * this.config.celebrationEmojis.length)
                    ];
                    confetti.style.cssText = `
                        position: fixed;
                        font-size: 20px;
                        pointer-events: none;
                        z-index: 1000;
                        animation: confettiFall 4s ease-out forwards;
                        left: ${Math.random() * window.innerWidth}px;
                        top: -50px;
                    `;
                    
                    document.body.appendChild(confetti);
                    setTimeout(() => confetti.remove(), 4000);
                }, i * 100);
            }
        },
        
        createJoyfulNotification: function(message, type = 'info', options = {}) {
            const notification = document.createElement('div');
            notification.className = `toast-happy toast-happy-${type}`;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                animation: happySlideIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            `;
            
            const icon = type === 'success' ? '🎉' : type === 'error' ? '😢' : type === 'warning' ? '⚠️' : 'ℹ️';
            
            notification.innerHTML = `
                <div class="toast-happy-body">
                    <span class="toast-happy-icon">${icon}</span>
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" style="background: none; border: none; font-size: 18px; cursor: pointer; margin-left: auto;">&times;</button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Add confetti if requested
            if (options.showConfetti) {
                this.createConfetti(notification, 10);
            }
            
            // Add sparkles if requested
            if (options.showSparkles) {
                this.addSparkleEffect({ target: notification });
            }
            
            const duration = options.duration || 3000;
            if (duration > 0) {
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.style.animation = 'happySlideOut 0.3s ease-in';
                        setTimeout(() => notification.remove(), 300);
                    }
                }, duration);
            }
        },
        
        validateForm: function(form) {
            // Simple validation - extend as needed
            const requiredInputs = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.style.borderColor = 'var(--joy-pink)';
                    input.style.animation = 'shake 0.5s ease-in-out';
                }
            });
            
            return isValid;
        },
        
        animateProgressBar: function(bar) {
            const targetWidth = bar.style.width || bar.getAttribute('data-width') || '0%';
            bar.style.width = '0%';
            
            setTimeout(() => {
                bar.style.width = targetWidth;
            }, 100);
        },
        
        playHappySound: function() {
            // Create a simple beep using Web Audio API
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
                oscillator.frequency.setValueAtTime(1000, audioContext.currentTime + 0.1);
                
                gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);
                
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.3);
            } catch (e) {
                // Audio not available, that's okay!
                console.log('Audio celebration not available');
            }
        }
    };
    
    // Auto-initialize when DOM is loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', TuskHappy.init.bind(TuskHappy));
    } else {
        TuskHappy.init();
    }
    
    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes sparkleFloat {
            0% { transform: translateY(0) scale(1); opacity: 1; }
            100% { transform: translateY(-50px) scale(0.5); opacity: 0; }
        }
        
        @keyframes confettiFall {
            0% { transform: translateY(0) rotate(0deg); opacity: 1; }
            100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
        }
        
        @keyframes happyFadeIn {
            0% { opacity: 0; transform: translateY(30px) scale(0.9); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        
        @keyframes happySlideIn {
            0% { transform: translateX(100%); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes happySlideOut {
            0% { transform: translateX(0); opacity: 1; }
            100% { transform: translateX(100%); opacity: 0; }
        }
        
        @keyframes taskComplete {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        @keyframes encouragementPop {
            0% { transform: scale(0); opacity: 0; }
            20% { transform: scale(1.1); opacity: 1; }
            100% { transform: scale(1); opacity: 0; }
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        @keyframes rainbowFlash {
            0% { filter: hue-rotate(0deg) brightness(1); }
            50% { filter: hue-rotate(180deg) brightness(1.2); }
            100% { filter: hue-rotate(360deg) brightness(1); }
        }
    `;
    document.head.appendChild(style);
    
})();