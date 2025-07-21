<?php
/**
 * accordion.php
 * Enhanced accordion component with smooth animations, keyboard navigation, and nested accordions
 */
?>

<section class="tusk-interactive-accordion" id="accordion-demo">
    <div class="interactive-container">
        <h2>📋 Interactive Accordion</h2>
        <p>Collapsible content panels with smooth animations, keyboard navigation, and accessibility features</p>
        
        <div class="accordion-controls">
            <button class="btn btn-primary" onclick="expandAll()">Expand All</button>
            <button class="btn btn-secondary" onclick="collapseAll()">Collapse All</button>
            <button class="btn btn-secondary" onclick="toggleMode()">
                <span id="mode-text">Switch to Single Mode</span>
            </button>
        </div>
        
        <div class="accordion" id="main-accordion">
            <div class="accordion-item">
                <button class="accordion-header" onclick="toggleAccordion(this)" aria-expanded="false">
                    <span>🚀 Getting Started with TuskPHP</span>
                    <span class="accordion-icon">▼</span>
                </button>
                <div class="accordion-content">
                    <div class="accordion-body">
                        <p><strong>Welcome to TuskPHP!</strong> This powerful PHP framework is designed to make web development fast, secure, and enjoyable.</p>
                        
                        <h4>Quick Setup Steps:</h4>
                        <ol>
                            <li>📥 Download TuskPHP from our official website</li>
                            <li>📂 Extract files to your web server directory</li>
                            <li>⚙️ Run the installation wizard</li>
                            <li>🎉 Start building amazing applications!</li>
                        </ol>
                        
                        <div class="nested-accordion">
                            <div class="accordion-item">
                                <button class="accordion-header" onclick="toggleAccordion(this)" aria-expanded="false">
                                    <span>📋 System Requirements</span>
                                    <span class="accordion-icon">▼</span>
                                </button>
                                <div class="accordion-content">
                                    <div class="accordion-body">
                                        <ul>
                                            <li>PHP 8.0 or higher</li>
                                            <li>MySQL 5.7+ or MariaDB 10.2+</li>
                                            <li>Apache 2.4+ or Nginx 1.15+</li>
                                            <li>Composer for dependency management</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <p><em>Need help? Check out our comprehensive documentation or join our community forum!</em></p>
                    </div>
                </div>
            </div>
            
            <div class="accordion-item">
                <button class="accordion-header" onclick="toggleAccordion(this)" aria-expanded="false">
                    <span>🔒 Security Features</span>
                    <span class="accordion-icon">▼</span>
                </button>
                <div class="accordion-content">
                    <div class="accordion-body">
                        <p>TuskPHP comes with enterprise-grade security features built right in:</p>
                        
                        <div class="feature-grid">
                            <div class="feature-item">
                                <h4>🛡️ SQL Injection Protection</h4>
                                <p>Prepared statements and query parameterization prevent SQL injection attacks.</p>
                            </div>
                            
                            <div class="feature-item">
                                <h4>🔐 CSRF Protection</h4>
                                <p>Cross-Site Request Forgery protection with automatic token generation.</p>
                            </div>
                            
                            <div class="feature-item">
                                <h4>🚫 XSS Prevention</h4>
                                <p>Automatic output escaping and content security policies prevent XSS attacks.</p>
                            </div>
                            
                            <div class="feature-item">
                                <h4>🔑 Secure Authentication</h4>
                                <p>Built-in user authentication with bcrypt password hashing and session management.</p>
                            </div>
                        </div>
                        
                        <div class="security-tip">
                            <strong>💡 Pro Tip:</strong> Enable two-factor authentication for admin accounts to add an extra layer of security!
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="accordion-item">
                <button class="accordion-header" onclick="toggleAccordion(this)" aria-expanded="false">
                    <span>⚡ Performance Optimization</span>
                    <span class="accordion-icon">▼</span>
                </button>
                <div class="accordion-content">
                    <div class="accordion-body">
                        <p>TuskPHP is engineered for speed with multiple performance optimization techniques:</p>
                        
                        <div class="performance-metrics">
                            <div class="metric">
                                <div class="metric-value">⚡ 40%</div>
                                <div class="metric-label">Faster than competitors</div>
                            </div>
                            <div class="metric">
                                <div class="metric-value">📈 99.9%</div>
                                <div class="metric-label">Uptime guarantee</div>
                            </div>
                            <div class="metric">
                                <div class="metric-value">🚀 <250ms</div>
                                <div class="metric-label">Average response time</div>
                            </div>
                        </div>
                        
                        <h4>Optimization Features:</h4>
                        <ul>
                            <li>🗃️ Advanced caching system (Redis, Memcached)</li>
                            <li>📦 Asset bundling and minification</li>
                            <li>🔄 Database query optimization</li>
                            <li>🖼️ Automatic image compression</li>
                            <li>📱 Progressive Web App (PWA) support</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="accordion-item">
                <button class="accordion-header" onclick="toggleAccordion(this)" aria-expanded="false">
                    <span>🛠️ Developer Tools</span>
                    <span class="accordion-icon">▼</span>
                </button>
                <div class="accordion-content">
                    <div class="accordion-body">
                        <p>Comprehensive toolset for modern PHP development:</p>
                        
                        <div class="tools-tabs">
                            <div class="tab-buttons">
                                <button class="tab-btn active" onclick="switchTab('cli')">CLI Tools</button>
                                <button class="tab-btn" onclick="switchTab('debugging')">Debugging</button>
                                <button class="tab-btn" onclick="switchTab('testing')">Testing</button>
                            </div>
                            
                            <div class="tab-content">
                                <div class="tab-panel active" id="cli-tab">
                                    <h4>🖥️ Command Line Interface</h4>
                                    <ul>
                                        <li><code>tusk create:component</code> - Generate new components</li>
                                        <li><code>tusk serve</code> - Start development server</li>
                                        <li><code>tusk migrate</code> - Run database migrations</li>
                                        <li><code>tusk optimize</code> - Optimize application performance</li>
                                    </ul>
                                </div>
                                
                                <div class="tab-panel" id="debugging-tab">
                                    <h4>🐛 Debugging Tools</h4>
                                    <ul>
                                        <li>Interactive debugger with breakpoints</li>
                                        <li>Query profiler and execution timeline</li>
                                        <li>Error tracking and logging system</li>
                                        <li>Real-time performance monitoring</li>
                                    </ul>
                                </div>
                                
                                <div class="tab-panel" id="testing-tab">
                                    <h4>🧪 Testing Framework</h4>
                                    <ul>
                                        <li>Unit testing with PHPUnit integration</li>
                                        <li>Feature testing for end-to-end scenarios</li>
                                        <li>Mock and stub generation</li>
                                        <li>Code coverage reporting</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="accordion-item">
                <button class="accordion-header" onclick="toggleAccordion(this)" aria-expanded="false">
                    <span>📞 Support & Community</span>
                    <span class="accordion-icon">▼</span>
                </button>
                <div class="accordion-content">
                    <div class="accordion-body">
                        <p>Join our thriving community of developers and get the support you need:</p>
                        
                        <div class="support-options">
                            <div class="support-card">
                                <h4>📚 Documentation</h4>
                                <p>Comprehensive guides, tutorials, and API references</p>
                                <a href="#" class="support-link">Browse Docs →</a>
                            </div>
                            
                            <div class="support-card">
                                <h4>💬 Community Forum</h4>
                                <p>Connect with other developers and share knowledge</p>
                                <a href="#" class="support-link">Join Forum →</a>
                            </div>
                            
                            <div class="support-card">
                                <h4>🎥 Video Tutorials</h4>
                                <p>Step-by-step video guides for beginners and experts</p>
                                <a href="#" class="support-link">Watch Videos →</a>
                            </div>
                            
                            <div class="support-card">
                                <h4>🏆 Premium Support</h4>
                                <p>Priority support with guaranteed response times</p>
                                <a href="#" class="support-link">Get Premium →</a>
                            </div>
                        </div>
                        
                        <div class="community-stats">
                            <div class="stat">
                                <strong>15,000+</strong>
                                <span>Active Developers</span>
                            </div>
                            <div class="stat">
                                <strong>500+</strong>
                                <span>Extensions Available</span>
                            </div>
                            <div class="stat">
                                <strong>24/7</strong>
                                <span>Community Support</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
let accordionMode = 'multiple'; // 'multiple' or 'single'

function toggleAccordion(header) {
    const content = header.nextElementSibling;
    const icon = header.querySelector('.accordion-icon');
    const isExpanded = header.getAttribute('aria-expanded') === 'true';
    
    if (accordionMode === 'single') {
        // Close all other accordions in the same container
        const container = header.closest('.accordion');
        const allHeaders = container.querySelectorAll('.accordion-header');
        const allContents = container.querySelectorAll('.accordion-content');
        
        allHeaders.forEach(h => {
            if (h !== header) {
                h.setAttribute('aria-expanded', 'false');
                h.classList.remove('active');
                h.querySelector('.accordion-icon').style.transform = 'rotate(0deg)';
            }
        });
        
        allContents.forEach(c => {
            if (c !== content) {
                c.classList.remove('active');
            }
        });
    }
    
    // Toggle current accordion
    if (isExpanded) {
        header.setAttribute('aria-expanded', 'false');
        header.classList.remove('active');
        content.classList.remove('active');
        icon.style.transform = 'rotate(0deg)';
    } else {
        header.setAttribute('aria-expanded', 'true');
        header.classList.add('active');
        content.classList.add('active');
        icon.style.transform = 'rotate(180deg)';
    }
}

function expandAll() {
    const headers = document.querySelectorAll('#main-accordion .accordion-header');
    headers.forEach(header => {
        const content = header.nextElementSibling;
        const icon = header.querySelector('.accordion-icon');
        
        header.setAttribute('aria-expanded', 'true');
        header.classList.add('active');
        content.classList.add('active');
        icon.style.transform = 'rotate(180deg)';
    });
}

function collapseAll() {
    const headers = document.querySelectorAll('#main-accordion .accordion-header');
    headers.forEach(header => {
        const content = header.nextElementSibling;
        const icon = header.querySelector('.accordion-icon');
        
        header.setAttribute('aria-expanded', 'false');
        header.classList.remove('active');
        content.classList.remove('active');
        icon.style.transform = 'rotate(0deg)';
    });
}

function toggleMode() {
    const modeText = document.getElementById('mode-text');
    
    if (accordionMode === 'multiple') {
        accordionMode = 'single';
        modeText.textContent = 'Switch to Multiple Mode';
        
        // Close all but the first accordion
        const headers = document.querySelectorAll('#main-accordion .accordion-header');
        headers.forEach((header, index) => {
            if (index > 0 && header.getAttribute('aria-expanded') === 'true') {
                toggleAccordion(header);
            }
        });
    } else {
        accordionMode = 'multiple';
        modeText.textContent = 'Switch to Single Mode';
    }
}

function switchTab(tabName) {
    // Remove active class from all tabs
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-panel').forEach(panel => panel.classList.remove('active'));
    
    // Add active class to selected tab
    event.target.classList.add('active');
    document.getElementById(tabName + '-tab').classList.add('active');
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (e.target.classList.contains('accordion-header')) {
        switch(e.key) {
            case 'Enter':
            case ' ':
                e.preventDefault();
                toggleAccordion(e.target);
                break;
            case 'ArrowDown':
                e.preventDefault();
                const nextHeader = getNextAccordionHeader(e.target);
                if (nextHeader) nextHeader.focus();
                break;
            case 'ArrowUp':
                e.preventDefault();
                const prevHeader = getPrevAccordionHeader(e.target);
                if (prevHeader) prevHeader.focus();
                break;
            case 'Home':
                e.preventDefault();
                const firstHeader = document.querySelector('.accordion-header');
                if (firstHeader) firstHeader.focus();
                break;
            case 'End':
                e.preventDefault();
                const headers = document.querySelectorAll('.accordion-header');
                const lastHeader = headers[headers.length - 1];
                if (lastHeader) lastHeader.focus();
                break;
        }
    }
});

function getNextAccordionHeader(currentHeader) {
    const headers = Array.from(document.querySelectorAll('.accordion-header'));
    const currentIndex = headers.indexOf(currentHeader);
    return headers[currentIndex + 1] || headers[0];
}

function getPrevAccordionHeader(currentHeader) {
    const headers = Array.from(document.querySelectorAll('.accordion-header'));
    const currentIndex = headers.indexOf(currentHeader);
    return headers[currentIndex - 1] || headers[headers.length - 1];
}

// Make accordion headers focusable
document.addEventListener('DOMContentLoaded', function() {
    const headers = document.querySelectorAll('.accordion-header');
    headers.forEach(header => {
        header.setAttribute('tabindex', '0');
    });
});
</script>