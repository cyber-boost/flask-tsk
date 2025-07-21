<?php
/**
 * <?tusk> sidebar-alt-2 Sidebar Component - Tree View Variant
 * Auto-Inclusion: [tusk-component-sidebar-alt-2]
 */
?>

<aside class="tusk-sidebar-alt-2" id="tusk-sidebar-alt-2">
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <span class="brand-logo">🐘</span>
            <div class="brand-info">
                <h3>TuskPHP</h3>
                <p>Admin Panel</p>
            </div>
        </div>
        <button class="sidebar-collapse" id="sidebar-collapse">
            <i class="fas fa-chevron-left"></i>
        </button>
    </div>
    
    <nav class="sidebar-nav">
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="#" class="sidebar-link active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="link-text">Dashboard</span>
                </a>
            </li>
            
            <li class="sidebar-item has-submenu">
                <a href="#" class="sidebar-link" data-toggle="submenu">
                    <i class="fas fa-users"></i>
                    <span class="link-text">User Management</span>
                    <i class="fas fa-chevron-down submenu-arrow"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li><a href="#"><span class="submenu-dot"></span>All Users</a></li>
                    <li><a href="#"><span class="submenu-dot"></span>Add User</a></li>
                    <li><a href="#"><span class="submenu-dot"></span>User Roles</a></li>
                    <li><a href="#"><span class="submenu-dot"></span>Permissions</a></li>
                </ul>
            </li>
            
            <li class="sidebar-item has-submenu">
                <a href="#" class="sidebar-link" data-toggle="submenu">
                    <i class="fas fa-chart-bar"></i>
                    <span class="link-text">Analytics</span>
                    <i class="fas fa-chevron-down submenu-arrow"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li><a href="#"><span class="submenu-dot"></span>Overview</a></li>
                    <li><a href="#"><span class="submenu-dot"></span>Traffic</a></li>
                    <li><a href="#"><span class="submenu-dot"></span>Conversions</a></li>
                    <li><a href="#"><span class="submenu-dot"></span>Reports</a></li>
                </ul>
            </li>
            
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="fas fa-cog"></i>
                    <span class="link-text">Settings</span>
                </a>
            </li>
            
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="fas fa-shield-alt"></i>
                    <span class="link-text">Security</span>
                </a>
            </li>
            
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="fas fa-life-ring"></i>
                    <span class="link-text">Support</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <div class="sidebar-footer">
        <div class="user-profile">
            <div class="user-avatar">A</div>
            <div class="user-info">
                <h4>Admin User</h4>
                <p>administrator</p>
            </div>
        </div>
    </div>
</aside>

<style>
.tusk-sidebar-alt-2 {
    position: fixed;
    top: 0;
    left: 0;
    width: 280px;
    height: 100vh;
    background: linear-gradient(180deg, #1a202c 0%, #2d3748 100%);
    color: white;
    transition: width 0.3s ease;
    z-index: 1000;
    overflow: hidden;
    border-right: 3px solid #4a5568;
}

.tusk-sidebar-alt-2.collapsed {
    width: 80px;
}

.sidebar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid #4a5568;
    min-height: 80px;
}

.sidebar-brand {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.brand-logo {
    font-size: 2rem;
    padding: 0.5rem;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 12px;
    min-width: 48px;
    text-align: center;
}

.brand-info h3 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 700;
    color: #e2e8f0;
}

.brand-info p {
    margin: 0;
    font-size: 0.75rem;
    color: #a0aec0;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.sidebar-collapse {
    background: none;
    border: none;
    color: #a0aec0;
    font-size: 1.25rem;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.sidebar-collapse:hover {
    background: #4a5568;
    color: white;
}

.sidebar-nav {
    flex: 1;
    padding: 1rem 0;
    overflow-y: auto;
}

.sidebar-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-item {
    margin-bottom: 0.25rem;
}

.sidebar-link {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    color: #cbd5e0;
    text-decoration: none;
    transition: all 0.3s ease;
    border-left: 3px solid transparent;
    cursor: pointer;
}

.sidebar-link:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #e2e8f0;
    border-left-color: #667eea;
}

.sidebar-link.active {
    background: linear-gradient(90deg, rgba(102, 126, 234, 0.2), transparent);
    color: #667eea;
    border-left-color: #667eea;
}

.sidebar-link i {
    font-size: 1.25rem;
    min-width: 20px;
}

.link-text {
    font-weight: 500;
    white-space: nowrap;
}

.submenu-arrow {
    margin-left: auto;
    font-size: 0.875rem;
    transition: transform 0.3s ease;
}

.has-submenu.open .submenu-arrow {
    transform: rotate(180deg);
}

.sidebar-submenu {
    list-style: none;
    padding: 0;
    margin: 0;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
    background: rgba(0, 0, 0, 0.2);
}

.has-submenu.open .sidebar-submenu {
    max-height: 200px;
}

.sidebar-submenu li a {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 1.5rem 0.75rem 3rem;
    color: #a0aec0;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.sidebar-submenu li a:hover {
    background: rgba(255, 255, 255, 0.05);
    color: #e2e8f0;
}

.submenu-dot {
    width: 6px;
    height: 6px;
    background: #4a5568;
    border-radius: 50%;
    margin-right: 0.5rem;
}

.sidebar-footer {
    padding: 1.5rem;
    border-top: 1px solid #4a5568;
}

.user-profile {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.user-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.125rem;
}

.user-info h4 {
    margin: 0;
    font-size: 0.875rem;
    font-weight: 600;
    color: #e2e8f0;
}

.user-info p {
    margin: 0;
    font-size: 0.75rem;
    color: #a0aec0;
}

/* Collapsed state */
.tusk-sidebar-alt-2.collapsed .brand-info,
.tusk-sidebar-alt-2.collapsed .link-text,
.tusk-sidebar-alt-2.collapsed .submenu-arrow,
.tusk-sidebar-alt-2.collapsed .user-info {
    opacity: 0;
    pointer-events: none;
}

.tusk-sidebar-alt-2.collapsed .sidebar-submenu {
    display: none;
}

@media (max-width: 768px) {
    .tusk-sidebar-alt-2 {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .tusk-sidebar-alt-2.mobile-open {
        transform: translateX(0);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('tusk-sidebar-alt-2');
    const collapseBtn = document.getElementById('sidebar-collapse');
    const submenuToggles = sidebar.querySelectorAll('[data-toggle="submenu"]');
    
    // Collapse/expand functionality
    collapseBtn.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
        const icon = this.querySelector('i');
        if (sidebar.classList.contains('collapsed')) {
            icon.className = 'fas fa-chevron-right';
        } else {
            icon.className = 'fas fa-chevron-left';
        }
    });
    
    // Submenu toggle functionality
    submenuToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;
            const isOpen = parent.classList.contains('open');
            
            // Close all other submenus
            submenuToggles.forEach(t => {
                t.parentElement.classList.remove('open');
            });
            
            // Toggle current submenu
            if (!isOpen) {
                parent.classList.add('open');
            }
        });
    });
    
    // Auto-collapse on mobile
    function handleResize() {
        if (window.innerWidth <= 768) {
            sidebar.classList.add('collapsed');
        }
    }
    
    window.addEventListener('resize', handleResize);
    handleResize();
});
</script>