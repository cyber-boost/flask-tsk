<?php
/**
 * <?tusk> sidebar-alt-3 Sidebar Component - Modern Cards Variant
 * Auto-Inclusion: [tusk-component-sidebar-alt-3]
 */
?>

<aside class="tusk-sidebar-alt-3" id="tusk-sidebar-alt-3">
    <div class="sidebar-header">
        <div class="brand-section">
            <div class="brand-avatar">
                <span class="brand-emoji">🐘</span>
            </div>
            <div class="brand-details">
                <h2>TuskPHP</h2>
                <span class="brand-tagline">Admin Console</span>
            </div>
        </div>
    </div>
    
    <div class="sidebar-search">
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" placeholder="Search..." class="search-input">
        </div>
    </div>
    
    <nav class="sidebar-nav">
        <div class="nav-section">
            <h3 class="section-title">Main</h3>
            <div class="nav-cards">
                <a href="#" class="nav-card active">
                    <div class="card-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="card-content">
                        <h4>Dashboard</h4>
                        <p>Overview & stats</p>
                    </div>
                    <div class="card-badge">12</div>
                </a>
                
                <a href="#" class="nav-card">
                    <div class="card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-content">
                        <h4>Users</h4>
                        <p>Manage accounts</p>
                    </div>
                    <div class="card-badge">234</div>
                </a>
                
                <a href="#" class="nav-card">
                    <div class="card-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div class="card-content">
                        <h4>Analytics</h4>
                        <p>Data insights</p>
                    </div>
                </a>
            </div>
        </div>
        
        <div class="nav-section">
            <h3 class="section-title">Management</h3>
            <div class="nav-cards">
                <a href="#" class="nav-card">
                    <div class="card-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="card-content">
                        <h4>Settings</h4>
                        <p>System config</p>
                    </div>
                </a>
                
                <a href="#" class="nav-card">
                    <div class="card-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="card-content">
                        <h4>Security</h4>
                        <p>Access control</p>
                    </div>
                    <div class="card-alert"></div>
                </a>
                
                <a href="#" class="nav-card">
                    <div class="card-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <div class="card-content">
                        <h4>Backups</h4>
                        <p>Data protection</p>
                    </div>
                </a>
            </div>
        </div>
    </nav>
    
    <div class="sidebar-footer">
        <div class="status-card">
            <div class="status-indicator online"></div>
            <div class="status-info">
                <h4>System Status</h4>
                <p>All systems operational</p>
            </div>
        </div>
        
        <div class="footer-actions">
            <button class="action-btn" title="Notifications">
                <i class="fas fa-bell"></i>
                <span class="notification-dot"></span>
            </button>
            <button class="action-btn" title="Messages">
                <i class="fas fa-envelope"></i>
            </button>
            <button class="action-btn" title="Profile">
                <i class="fas fa-user-circle"></i>
            </button>
        </div>
    </div>
</aside>

<style>
.tusk-sidebar-alt-3 {
    position: fixed;
    top: 0;
    left: 0;
    width: 320px;
    height: 100vh;
    background: linear-gradient(180deg, #f8fafc 0%, #e2e8f0 100%);
    border-right: 1px solid #cbd5e0;
    display: flex;
    flex-direction: column;
    padding: 1.5rem;
    z-index: 1000;
    overflow-y: auto;
    box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
}

.sidebar-header {
    margin-bottom: 2rem;
}

.brand-section {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border: 1px solid #e2e8f0;
}

.brand-avatar {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.brand-details h2 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a202c;
}

.brand-tagline {
    font-size: 0.75rem;
    color: #718096;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.sidebar-search {
    margin-bottom: 2rem;
}

.search-container {
    position: relative;
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #a0aec0;
    font-size: 1rem;
}

.search-input {
    width: 100%;
    padding: 1rem 1rem 1rem 3rem;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    background: white;
    font-size: 0.875rem;
    color: #2d3748;
    transition: all 0.3s ease;
}

.search-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.search-input::placeholder {
    color: #a0aec0;
}

.sidebar-nav {
    flex: 1;
}

.nav-section {
    margin-bottom: 2rem;
}

.section-title {
    font-size: 0.75rem;
    font-weight: 700;
    color: #718096;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: 0 0 1rem 0;
    padding: 0 0.5rem;
}

.nav-cards {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.nav-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.nav-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: transparent;
    transition: background 0.3s ease;
}

.nav-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    border-color: #cbd5e0;
    text-decoration: none;
    color: inherit;
}

.nav-card:hover::before {
    background: linear-gradient(180deg, #667eea, #764ba2);
}

.nav-card.active {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-color: #667eea;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.nav-card.active::before {
    background: white;
}

.card-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: #f7fafc;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.125rem;
    color: #4a5568;
}

.nav-card.active .card-icon {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.card-content {
    flex: 1;
}

.card-content h4 {
    margin: 0 0 0.25rem 0;
    font-size: 0.875rem;
    font-weight: 600;
    color: #2d3748;
}

.nav-card.active .card-content h4 {
    color: white;
}

.card-content p {
    margin: 0;
    font-size: 0.75rem;
    color: #718096;
}

.nav-card.active .card-content p {
    color: rgba(255, 255, 255, 0.8);
}

.card-badge {
    background: #edf2f7;
    color: #4a5568;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    min-width: 24px;
    text-align: center;
}

.nav-card.active .card-badge {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.card-alert {
    width: 8px;
    height: 8px;
    background: #f56565;
    border-radius: 50%;
    border: 2px solid white;
}

.sidebar-footer {
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
}

.status-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    margin-bottom: 1rem;
}

.status-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #48bb78;
    position: relative;
}

.status-indicator.online::before {
    content: '';
    position: absolute;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #48bb78;
    animation: statusPulse 2s infinite;
}

@keyframes statusPulse {
    0% { transform: scale(1); opacity: 1; }
    100% { transform: scale(2); opacity: 0; }
}

.status-info h4 {
    margin: 0;
    font-size: 0.875rem;
    font-weight: 600;
    color: #2d3748;
}

.status-info p {
    margin: 0;
    font-size: 0.75rem;
    color: #718096;
}

.footer-actions {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.action-btn {
    width: 40px;
    height: 40px;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.action-btn:hover {
    background: #f7fafc;
    border-color: #cbd5e0;
    transform: translateY(-1px);
}

.action-btn i {
    font-size: 1rem;
    color: #4a5568;
}

.notification-dot {
    position: absolute;
    top: 8px;
    right: 8px;
    width: 6px;
    height: 6px;
    background: #f56565;
    border-radius: 50%;
    border: 1px solid white;
}

@media (max-width: 768px) {
    .tusk-sidebar-alt-3 {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .tusk-sidebar-alt-3.mobile-open {
        transform: translateX(0);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('tusk-sidebar-alt-3');
    const searchInput = sidebar.querySelector('.search-input');
    const navCards = sidebar.querySelectorAll('.nav-card');
    
    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        navCards.forEach(card => {
            const title = card.querySelector('h4').textContent.toLowerCase();
            const description = card.querySelector('p').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || description.includes(searchTerm)) {
                card.style.display = 'flex';
            } else {
                card.style.display = searchTerm ? 'none' : 'flex';
            }
        });
    });
    
    // Add click analytics
    navCards.forEach(card => {
        card.addEventListener('click', function(e) {
            // Remove active class from all cards
            navCards.forEach(c => c.classList.remove('active'));
            // Add active class to clicked card
            this.classList.add('active');
            
            // Add click effect
            const ripple = document.createElement('span');
            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.6);
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            `;
            
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
            ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
            
            this.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        });
    });
    
    // Add CSS for ripple animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to { transform: scale(4); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
});
</script>