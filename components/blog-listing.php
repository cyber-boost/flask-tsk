<?php
/**
 * blog-listing.php
 * Enhanced blog listing with search, filtering, and pagination
 */
?>

<section class="tusk-hero-blog-listing" id="blog">
    <div class="hero-container">
        <h2>📝 Latest Blog Posts</h2>
        <p>Stay updated with the latest news, tutorials, and insights from the TuskPHP community</p>
        
        <div class="blog-controls">
            <div class="search-bar">
                <input type="text" id="blog-search" placeholder="Search articles..." class="form-input">
                <button class="search-btn" onclick="searchBlogs()">🔍</button>
            </div>
            
            <div class="blog-filters">
                <select id="category-filter" onchange="filterBlogs()">
                    <option value="all">All Categories</option>
                    <option value="tutorials">Tutorials</option>
                    <option value="news">News</option>
                    <option value="tips">Tips & Tricks</option>
                    <option value="community">Community</option>
                </select>
                
                <select id="sort-filter" onchange="sortBlogs()">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="popular">Most Popular</option>
                    <option value="trending">Trending</option>
                </select>
            </div>
        </div>
        
        <div class="blog-grid" id="blog-grid">
            <!-- Blog posts will be populated by JavaScript -->
        </div>
        
        <div class="blog-pagination" id="blog-pagination">
            <!-- Pagination will be populated by JavaScript -->
        </div>
        
        <div class="blog-newsletter">
            <div class="newsletter-card">
                <h3>📧 Subscribe to Our Blog</h3>
                <p>Get the latest articles delivered straight to your inbox</p>
                <div class="newsletter-form">
                    <input type="email" placeholder="Enter your email" class="form-input">
                    <button class="btn btn-primary">Subscribe</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
const blogPosts = [
    {
        id: 1,
        title: "Getting Started with TuskPHP: A Complete Guide",
        excerpt: "Learn the fundamentals of TuskPHP and build your first application with our comprehensive beginner's guide.",
        category: "tutorials",
        author: "Sarah Johnson",
        date: "2024-01-15",
        readTime: "8 min read",
        image: "🚀",
        popular: 145,
        trending: true
    },
    {
        id: 2,
        title: "Advanced Security Features in TuskPHP 2.0",
        excerpt: "Explore the enhanced security capabilities that make TuskPHP the most secure PHP framework available.",
        category: "news",
        author: "Mike Chen",
        date: "2024-01-12",
        readTime: "6 min read",
        image: "🔒",
        popular: 98,
        trending: true
    },
    {
        id: 3,
        title: "10 Performance Tips for Lightning-Fast Applications",
        excerpt: "Optimize your TuskPHP applications with these proven performance enhancement techniques.",
        category: "tips",
        author: "Alex Rodriguez",
        date: "2024-01-10",
        readTime: "12 min read",
        image: "⚡",
        popular: 203,
        trending: false
    },
    {
        id: 4,
        title: "Community Spotlight: Amazing Projects Built with TuskPHP",
        excerpt: "Discover incredible projects created by our talented community members and get inspired.",
        category: "community",
        author: "Lisa Wang",
        date: "2024-01-08",
        readTime: "5 min read",
        image: "🌟",
        popular: 76,
        trending: false
    },
    {
        id: 5,
        title: "Building RESTful APIs with TuskPHP",
        excerpt: "Master the art of creating robust and scalable APIs using TuskPHP's powerful features.",
        category: "tutorials",
        author: "David Kim",
        date: "2024-01-05",
        readTime: "15 min read",
        image: "🔌",
        popular: 167,
        trending: true
    },
    {
        id: 6,
        title: "TuskPHP vs Other Frameworks: A Detailed Comparison",
        excerpt: "See how TuskPHP stacks up against popular PHP frameworks in performance, security, and ease of use.",
        category: "news",
        author: "Emma Thompson",
        date: "2024-01-03",
        readTime: "10 min read",
        image: "📊",
        popular: 189,
        trending: false
    }
];

let filteredPosts = [...blogPosts];
let currentPage = 1;
const postsPerPage = 4;

function renderBlogPosts() {
    const blogGrid = document.getElementById('blog-grid');
    const startIndex = (currentPage - 1) * postsPerPage;
    const endIndex = startIndex + postsPerPage;
    const postsToShow = filteredPosts.slice(startIndex, endIndex);
    
    blogGrid.innerHTML = postsToShow.map(post => `
        <article class="blog-card" data-category="${post.category}">
            <div class="blog-image">
                <span class="post-icon">${post.image}</span>
                ${post.trending ? '<span class="trending-badge">🔥 Trending</span>' : ''}
            </div>
            
            <div class="blog-content">
                <div class="blog-meta">
                    <span class="category">${post.category}</span>
                    <span class="read-time">${post.readTime}</span>
                </div>
                
                <h3 class="blog-title">${post.title}</h3>
                <p class="blog-excerpt">${post.excerpt}</p>
                
                <div class="blog-footer">
                    <div class="author-info">
                        <span class="author">By ${post.author}</span>
                        <span class="date">${formatDate(post.date)}</span>
                    </div>
                    
                    <div class="post-stats">
                        <span class="popularity">👁️ ${post.popular}</span>
                        <button class="read-more-btn" onclick="readPost(${post.id})">
                            Read More →
                        </button>
                    </div>
                </div>
            </div>
        </article>
    `).join('');
    
    renderPagination();
}

function renderPagination() {
    const totalPages = Math.ceil(filteredPosts.length / postsPerPage);
    const pagination = document.getElementById('blog-pagination');
    
    if (totalPages <= 1) {
        pagination.innerHTML = '';
        return;
    }
    
    let paginationHTML = '';
    
    // Previous button
    if (currentPage > 1) {
        paginationHTML += `<button class="page-btn" onclick="changePage(${currentPage - 1})">← Previous</button>`;
    }
    
    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
        const isActive = i === currentPage ? 'active' : '';
        paginationHTML += `<button class="page-btn ${isActive}" onclick="changePage(${i})">${i}</button>`;
    }
    
    // Next button
    if (currentPage < totalPages) {
        paginationHTML += `<button class="page-btn" onclick="changePage(${currentPage + 1})">Next →</button>`;
    }
    
    pagination.innerHTML = paginationHTML;
}

function changePage(page) {
    currentPage = page;
    renderBlogPosts();
    
    // Scroll to top of blog section
    document.getElementById('blog').scrollIntoView({ behavior: 'smooth' });
}

function searchBlogs() {
    const searchTerm = document.getElementById('blog-search').value.toLowerCase();
    
    filteredPosts = blogPosts.filter(post => 
        post.title.toLowerCase().includes(searchTerm) ||
        post.excerpt.toLowerCase().includes(searchTerm) ||
        post.author.toLowerCase().includes(searchTerm)
    );
    
    currentPage = 1;
    renderBlogPosts();
}

function filterBlogs() {
    const category = document.getElementById('category-filter').value;
    const searchTerm = document.getElementById('blog-search').value.toLowerCase();
    
    filteredPosts = blogPosts.filter(post => {
        const matchesCategory = category === 'all' || post.category === category;
        const matchesSearch = searchTerm === '' || 
            post.title.toLowerCase().includes(searchTerm) ||
            post.excerpt.toLowerCase().includes(searchTerm) ||
            post.author.toLowerCase().includes(searchTerm);
        
        return matchesCategory && matchesSearch;
    });
    
    currentPage = 1;
    renderBlogPosts();
}

function sortBlogs() {
    const sortBy = document.getElementById('sort-filter').value;
    
    switch (sortBy) {
        case 'newest':
            filteredPosts.sort((a, b) => new Date(b.date) - new Date(a.date));
            break;
        case 'oldest':
            filteredPosts.sort((a, b) => new Date(a.date) - new Date(b.date));
            break;
        case 'popular':
            filteredPosts.sort((a, b) => b.popular - a.popular);
            break;
        case 'trending':
            filteredPosts.sort((a, b) => {
                if (a.trending && !b.trending) return -1;
                if (!a.trending && b.trending) return 1;
                return b.popular - a.popular;
            });
            break;
    }
    
    currentPage = 1;
    renderBlogPosts();
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    });
}

function readPost(postId) {
    const post = blogPosts.find(p => p.id === postId);
    if (post) {
        // In a real application, this would navigate to the full post
        alert(`Opening article: "${post.title}"\n\nThis would typically open the full blog post page.`);
    }
}

// Search on Enter key
document.getElementById('blog-search').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        searchBlogs();
    }
});

// Initialize blog on page load
document.addEventListener('DOMContentLoaded', function() {
    renderBlogPosts();
});
</script>