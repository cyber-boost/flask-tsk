<?php
/**
 * <?tusk> sidebar-alt-1 Sidebar Component - Minimalist Variant
 * Auto-Inclusion: [tusk-component-sidebar-alt-1]
 */
?>

<aside class="tusk-sidebar-alt-1" id="tusk-sidebar-alt-1">
    <div class="sidebar-brand">
        <span class="brand-icon">🐘</span>
        <span class="brand-text">Tusk</span>
    </div>
    
    <nav class="sidebar-nav">
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="#" class="sidebar-link active" title="Dashboard">
                    <i class="fas fa-home"></i>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link" title="Users">
                    <i class="fas fa-users"></i>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link" title="Analytics">
                    <i class="fas fa-chart-line"></i>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link" title="Settings">
                    <i class="fas fa-cog"></i>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link" title="Help">
                    <i class="fas fa-question-circle"></i>
                </a>
            </li>
        </ul>
    </nav>
    
    <div class="sidebar-footer">
        <a href="#" class="sidebar-link" title="Logout">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </div>
</aside>

<style>
.tusk-sidebar-alt-1 {
    position: fixed;
    top: 0;
    left: 0;
    width: 80px;
    height: 100vh;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-right: 1px solid rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1rem 0;
    z-index: 1000;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
}

.sidebar-brand {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 2rem;
    padding: 1rem 0;
}

.brand-icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.brand-text {
    font-size: 0.75rem;
    font-weight: 700;
    color: #374151;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.sidebar-nav {
    flex: 1;
    width: 100%;
}

.sidebar-menu {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.sidebar-item {
    width: 100%;
    display: flex;
    justify-content: center;
}

.sidebar-link {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6b7280;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
}

.sidebar-link:hover {
    background: rgba(99, 102, 241, 0.1);
    color: #6366f1;
    transform: scale(1.1);
}

.sidebar-link.active {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
}

.sidebar-link i {
    font-size: 1.25rem;
}

.sidebar-footer {
    width: 100%;
    display: flex;
    justify-content: center;
    padding-top: 1rem;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
}

.sidebar-footer .sidebar-link {
    color: #ef4444;
}

.sidebar-footer .sidebar-link:hover {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

@media (max-width: 768px) {
    .tusk-sidebar-alt-1 {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .tusk-sidebar-alt-1.mobile-open {
        transform: translateX(0);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('tusk-sidebar-alt-1');
    const sidebarLinks = sidebar.querySelectorAll('.sidebar-link');
    
    // Add hover tooltips for better UX
    sidebarLinks.forEach(link => {
        const title = link.getAttribute('title');
        if (title) {
            link.addEventListener('mouseenter', function(e) {
                const tooltip = document.createElement('div');
                tooltip.className = 'sidebar-tooltip';
                tooltip.textContent = title;
                tooltip.style.cssText = `
                    position: fixed;
                    left: 90px;
                    top: ${e.target.getBoundingClientRect().top + 12}px;
                    background: #374151;
                    color: white;
                    padding: 0.5rem 0.75rem;
                    border-radius: 6px;
                    font-size: 0.875rem;
                    z-index: 1001;
                    pointer-events: none;
                    opacity: 0;
                    transition: opacity 0.3s ease;
                `;
                document.body.appendChild(tooltip);
                
                setTimeout(() => tooltip.style.opacity = '1', 10);
                
                link.addEventListener('mouseleave', function() {
                    tooltip.remove();
                }, { once: true });
            });
        }
    });
});
</script>