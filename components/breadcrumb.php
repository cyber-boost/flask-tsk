<?php
/**
 * breadcrumb.php
 * Enhanced breadcrumb navigation with dynamic generation and JSON-LD structure
 */
?>

<nav class="tusk-breadcrumb" aria-label="Breadcrumb" id="breadcrumb-nav">
    <div class="breadcrumb-container">
        <ol class="breadcrumb-list" id="breadcrumb-list">
            <!-- Breadcrumbs will be dynamically generated -->
        </ol>
        
        <div class="breadcrumb-controls">
            <button class="breadcrumb-btn" onclick="goBack()" title="Go Back">
                ← Back
            </button>
            <button class="breadcrumb-btn" onclick="showBreadcrumbMenu()" title="Page Menu">
                ☰ Menu
            </button>
        </div>
    </div>
</nav>

<!-- Breadcrumb Menu -->
<div id="breadcrumb-menu" class="breadcrumb-menu">
    <div class="menu-content">
        <h3>🧭 Site Navigation</h3>
        <div class="menu-sections">
            <div class="menu-section">
                <h4>Main Pages</h4>
                <ul class="menu-links">
                    <li><a href="#home" onclick="navigateTo('home', 'Home')">🏠 Home</a></li>
                    <li><a href="#about" onclick="navigateTo('about', 'About')">👥 About</a></li>
                    <li><a href="#services" onclick="navigateTo('services', 'Services')">🛠️ Services</a></li>
                    <li><a href="#contact" onclick="navigateTo('contact', 'Contact')">📞 Contact</a></li>
                </ul>
            </div>
            
            <div class="menu-section">
                <h4>Components</h4>
                <ul class="menu-links">
                    <li><a href="#components" onclick="navigateTo('components', 'Components')">🧩 All Components</a></li>
                    <li><a href="#forms" onclick="navigateTo('components/forms', 'Forms')">📝 Forms</a></li>
                    <li><a href="#interactive" onclick="navigateTo('components/interactive', 'Interactive')">⚡ Interactive</a></li>
                    <li><a href="#utilities" onclick="navigateTo('components/utilities', 'Utilities')">🔧 Utilities</a></li>
                </ul>
            </div>
            
            <div class="menu-section">
                <h4>Documentation</h4>
                <ul class="menu-links">
                    <li><a href="#docs" onclick="navigateTo('docs', 'Documentation')">📚 Docs</a></li>
                    <li><a href="#getting-started" onclick="navigateTo('docs/getting-started', 'Getting Started')">🚀 Getting Started</a></li>
                    <li><a href="#api" onclick="navigateTo('docs/api', 'API Reference')">🔌 API</a></li>
                    <li><a href="#examples" onclick="navigateTo('docs/examples', 'Examples')">💡 Examples</a></li>
                </ul>
            </div>
        </div>
        
        <button class="btn btn-secondary" onclick="closeBreadcrumbMenu()">Close Menu</button>
    </div>
</div>

<script>
let breadcrumbHistory = [];
let currentPath = ['home'];

const pageStructure = {
    'home': { title: 'Home', icon: '🏠' },
    'about': { title: 'About', icon: '👥' },
    'services': { title: 'Services', icon: '🛠️' },
    'contact': { title: 'Contact', icon: '📞' },
    'components': { title: 'Components', icon: '🧩' },
    'components/forms': { title: 'Forms', icon: '📝', parent: 'components' },
    'components/interactive': { title: 'Interactive', icon: '⚡', parent: 'components' },
    'components/utilities': { title: 'Utilities', icon: '🔧', parent: 'components' },
    'docs': { title: 'Documentation', icon: '📚' },
    'docs/getting-started': { title: 'Getting Started', icon: '🚀', parent: 'docs' },
    'docs/api': { title: 'API Reference', icon: '🔌', parent: 'docs' },
    'docs/examples': { title: 'Examples', icon: '💡', parent: 'docs' }
};

function buildBreadcrumbPath(targetPath) {
    const pathArray = [];
    let currentPageKey = targetPath;
    
    // Build path from target back to root
    while (currentPageKey) {
        const pageInfo = pageStructure[currentPageKey];
        if (pageInfo) {
            pathArray.unshift({
                key: currentPageKey,
                title: pageInfo.title,
                icon: pageInfo.icon
            });
            currentPageKey = pageInfo.parent;
        } else {
            break;
        }
    }
    
    // Always start with home if not already there
    if (pathArray.length === 0 || pathArray[0].key !== 'home') {
        pathArray.unshift({
            key: 'home',
            title: 'Home',
            icon: '🏠'
        });
    }
    
    return pathArray;
}

function renderBreadcrumb() {
    const breadcrumbList = document.getElementById('breadcrumb-list');
    const pathArray = buildBreadcrumbPath(currentPath[currentPath.length - 1]);
    
    breadcrumbList.innerHTML = pathArray.map((item, index) => {
        const isLast = index === pathArray.length - 1;
        const isFirst = index === 0;
        
        if (isLast) {
            return `
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="breadcrumb-current">
                        ${item.icon} ${item.title}
                    </span>
                </li>
            `;
        } else {
            return `
                <li class="breadcrumb-item">
                    <a href="#${item.key}" class="breadcrumb-link" onclick="navigateTo('${item.key}', '${item.title}')">
                        ${item.icon} ${item.title}
                    </a>
                </li>
            `;
        }
    }).join('');
    
    // Update JSON-LD structured data
    updateStructuredData(pathArray);
}

function navigateTo(path, title) {
    // Add current path to history if it's different
    if (currentPath[currentPath.length - 1] !== path) {
        breadcrumbHistory.push(currentPath[currentPath.length - 1]);
    }
    
    currentPath = [path];
    renderBreadcrumb();
    closeBreadcrumbMenu();
    
    // Simulate page navigation
    showNavigationFeedback(title);
    
    // Scroll to target section if it exists
    const targetElement = document.getElementById(path.split('/').pop());
    if (targetElement) {
        targetElement.scrollIntoView({ behavior: 'smooth' });
    }
}

function goBack() {
    if (breadcrumbHistory.length > 0) {
        const previousPath = breadcrumbHistory.pop();
        const pageInfo = pageStructure[previousPath];
        
        if (pageInfo) {
            currentPath = [previousPath];
            renderBreadcrumb();
            showNavigationFeedback(`Navigated back to ${pageInfo.title}`);
        }
    } else {
        // Go to home if no history
        navigateTo('home', 'Home');
    }
}

function showBreadcrumbMenu() {
    document.getElementById('breadcrumb-menu').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeBreadcrumbMenu() {
    document.getElementById('breadcrumb-menu').classList.remove('active');
    document.body.style.overflow = '';
}

function showNavigationFeedback(title) {
    // Create temporary feedback element
    const feedback = document.createElement('div');
    feedback.className = 'navigation-feedback';
    feedback.innerHTML = `
        <div class="feedback-content">
            <span class="feedback-icon">🧭</span>
            <span>Navigated to: ${title}</span>
        </div>
    `;
    
    document.body.appendChild(feedback);
    
    setTimeout(() => {
        feedback.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        feedback.classList.remove('show');
        setTimeout(() => {
            if (feedback.parentNode) {
                feedback.parentNode.removeChild(feedback);
            }
        }, 300);
    }, 2000);
}

function updateStructuredData(pathArray) {
    // Remove existing breadcrumb JSON-LD
    const existingScript = document.querySelector('script[type="application/ld+json"]');
    if (existingScript) {
        existingScript.remove();
    }
    
    // Create new JSON-LD structured data
    const jsonLd = {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": pathArray.map((item, index) => ({
            "@type": "ListItem",
            "position": index + 1,
            "name": item.title,
            "item": window.location.origin + window.location.pathname + '#' + item.key
        }))
    };
    
    const script = document.createElement('script');
    script.type = 'application/ld+json';
    script.textContent = JSON.stringify(jsonLd);
    document.head.appendChild(script);
}

// Close menu when clicking outside
document.addEventListener('click', function(e) {
    const menu = document.getElementById('breadcrumb-menu');
    const menuButton = e.target.closest('.breadcrumb-btn');
    
    if (!e.target.closest('#breadcrumb-menu') && !menuButton && menu.classList.contains('active')) {
        closeBreadcrumbMenu();
    }
});

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeBreadcrumbMenu();
    }
    
    // Alt + B for breadcrumb menu
    if (e.altKey && e.key === 'b') {
        e.preventDefault();
        showBreadcrumbMenu();
    }
    
    // Alt + Backspace for go back
    if (e.altKey && e.key === 'Backspace') {
        e.preventDefault();
        goBack();
    }
});

// Initialize breadcrumb
document.addEventListener('DOMContentLoaded', function() {
    // Detect current page from URL hash or default to home
    const hash = window.location.hash.substring(1);
    const initialPath = hash && pageStructure[hash] ? hash : 'home';
    
    currentPath = [initialPath];
    renderBreadcrumb();
});

// Handle hash changes
window.addEventListener('hashchange', function() {
    const hash = window.location.hash.substring(1);
    if (hash && pageStructure[hash]) {
        navigateTo(hash, pageStructure[hash].title);
    }
});
</script>