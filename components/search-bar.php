<?php
/**
 * <?tusk> Enhanced Search Bar Component
 * Created: 2025-06-26
 * Strong. Secure. Scalable. 🐘
 *
 * <?tusk> search-bar Component
 * Auto-Inclusion: [tusk-component-search-bar]
 * Themes: default, dark, minimal, gradient, neon, corporate, warm, cool
 */

$theme = isset($theme) ? $theme : 'default';
$style = isset($style) ? $style : 'modern'; // modern, classic, minimal
$show_suggestions = isset($show_suggestions) ? $show_suggestions : true;
$show_filters = isset($show_filters) ? $show_filters : true;
$instant_search = isset($instant_search) ? $instant_search : true;

$suggestions = ['Web Development', 'Mobile Apps', 'UI/UX Design', 'Digital Marketing', 'E-commerce Solutions', 'SEO Services'];
$filters = ['All', 'Services', 'Products', 'Blog', 'Team', 'About'];
?>

<section class="tusk-search-bar tusk-search-bar--<?php echo $theme; ?> tusk-search-bar--<?php echo $style; ?>" 
         role="search" 
         aria-label="Site Search">
    <div class="search-container">
        <div class="search-header">
            <h2 class="search-title">Find What You're Looking For</h2>
            <p class="search-subtitle">Search through our content, services, and resources</p>
        </div>
        
        <div class="search-wrapper">
            <form class="search-form" role="search">
                <div class="search-input-group">
                    <div class="search-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="M21 21l-4.35-4.35"/>
                        </svg>
                    </div>
                    
                    <input type="search" 
                           class="search-input" 
                           placeholder="What can we help you find?"
                           aria-label="Search"
                           autocomplete="off"
                           spellcheck="false">
                    
                    <button type="button" class="search-clear" aria-label="Clear search" style="display: none;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                    </button>
                    
                    <button type="submit" class="search-submit" aria-label="Search">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="M21 21l-4.35-4.35"/>
                        </svg>
                    </button>
                </div>
                
                <?php if ($show_filters): ?>
                <div class="search-filters">
                    <?php foreach ($filters as $index => $filter): ?>
                    <button type="button" 
                            class="filter-btn <?php echo $index === 0 ? 'active' : ''; ?>" 
                            data-filter="<?php echo strtolower($filter); ?>"
                            aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                        <?php echo htmlspecialchars($filter); ?>
                    </button>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </form>
            
            <?php if ($show_suggestions): ?>
            <div class="search-suggestions" style="display: none;">
                <div class="suggestions-header">
                    <h4>Popular Searches</h4>
                </div>
                <div class="suggestions-list">
                    <?php foreach ($suggestions as $suggestion): ?>
                    <button type="button" class="suggestion-item" data-suggestion="<?php echo htmlspecialchars($suggestion); ?>">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="M21 21l-4.35-4.35"/>
                        </svg>
                        <?php echo htmlspecialchars($suggestion); ?>
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="search-results" style="display: none;">
                <div class="results-header">
                    <h4>Search Results</h4>
                    <span class="results-count">0 results found</span>
                </div>
                <div class="results-list">
                    <!-- Results will be populated by JavaScript -->
                </div>
                <div class="no-results" style="display: none;">
                    <div class="no-results-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="M21 21l-4.35-4.35"/>
                        </svg>
                    </div>
                    <h4>No results found</h4>
                    <p>Try adjusting your search terms or browse our categories</p>
                </div>
            </div>
        </div>
        
        <div class="search-shortcuts">
            <span class="shortcuts-label">Quick Actions:</span>
            <button class="shortcut-btn" data-action="voice-search">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/>
                    <path d="M19 10v2a7 7 0 0 1-14 0v-2"/>
                    <line x1="12" y1="19" x2="12" y2="23"/>
                    <line x1="8" y1="23" x2="16" y2="23"/>
                </svg>
                Voice Search
            </button>
            <button class="shortcut-btn" data-action="advanced-search">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1 1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                </svg>
                Advanced
            </button>
        </div>
    </div>
</section>

<style>
/* Base Styles */
.tusk-search-bar {
    padding: 4rem 0;
    position: relative;
    overflow: hidden;
}

.search-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 0 2rem;
}

.search-header {
    text-align: center;
    margin-bottom: 3rem;
}

.search-title {
    font-size: clamp(2rem, 5vw, 2.5rem);
    font-weight: 800;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.search-subtitle {
    font-size: 1.1rem;
    opacity: 0.8;
    line-height: 1.6;
}

/* Search Wrapper */
.search-wrapper {
    position: relative;
}

.search-form {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    padding: 2rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
}

.search-input-group {
    position: relative;
    display: flex;
    align-items: center;
    background: white;
    border-radius: 50px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    overflow: hidden;
}

.search-input-group:focus-within {
    border-color: #3498db;
    box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
}

.search-icon {
    position: absolute;
    left: 1.5rem;
    color: #7f8c8d;
    z-index: 2;
    transition: color 0.3s ease;
}

.search-input-group:focus-within .search-icon {
    color: #3498db;
}

.search-input {
    flex: 1;
    padding: 1.25rem 1.5rem 1.25rem 4rem;
    border: none;
    background: transparent;
    font-size: 1.1rem;
    color: #2c3e50;
    outline: none;
}

.search-input::placeholder {
    color: #95a5a6;
}

.search-clear {
    background: none;
    border: none;
    color: #95a5a6;
    cursor: pointer;
    padding: 0.5rem;
    margin-right: 0.5rem;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.search-clear:hover {
    background: rgba(231, 76, 60, 0.1);
    color: #e74c3c;
}

.search-submit {
    background: linear-gradient(135deg, #3498db, #2980b9);
    border: none;
    color: white;
    padding: 1rem;
    border-radius: 50%;
    cursor: pointer;
    margin: 0.25rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.search-submit:hover {
    background: linear-gradient(135deg, #2980b9, #3498db);
    transform: scale(1.05);
}

/* Search Filters */
.search-filters {
    display: flex;
    gap: 0.75rem;
    margin-top: 1.5rem;
    flex-wrap: wrap;
    justify-content: center;
}

.filter-btn {
    padding: 0.5rem 1rem;
    border: 2px solid transparent;
    border-radius: 25px;
    background: rgba(52, 152, 219, 0.1);
    color: #3498db;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.filter-btn:hover,
.filter-btn.active {
    background: #3498db;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
}

/* Search Suggestions */
.search-suggestions {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    border: 1px solid #e9ecef;
    z-index: 10;
    max-height: 300px;
    overflow-y: auto;
}

.suggestions-header {
    padding: 1rem 1.5rem 0.5rem;
    border-bottom: 1px solid #f1f3f4;
}

.suggestions-header h4 {
    margin: 0;
    color: #7f8c8d;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.suggestions-list {
    padding: 0.5rem 0;
}

.suggestion-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    width: 100%;
    padding: 0.75rem 1.5rem;
    border: none;
    background: none;
    text-align: left;
    color: #2c3e50;
    cursor: pointer;
    transition: background 0.2s ease;
    font-size: 0.95rem;
}

.suggestion-item:hover {
    background: #f8f9fa;
}

.suggestion-item svg {
    color: #95a5a6;
    flex-shrink: 0;
}

/* Search Results */
.search-results {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    border: 1px solid #e9ecef;
    z-index: 10;
    max-height: 400px;
    overflow-y: auto;
}

.results-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #f1f3f4;
}

.results-header h4 {
    margin: 0;
    color: #2c3e50;
    font-size: 1rem;
    font-weight: 600;
}

.results-count {
    color: #7f8c8d;
    font-size: 0.9rem;
}

.results-list {
    padding: 0.5rem 0;
}

.result-item {
    display: block;
    padding: 1rem 1.5rem;
    border: none;
    background: none;
    text-align: left;
    color: #2c3e50;
    cursor: pointer;
    transition: background 0.2s ease;
    width: 100%;
    text-decoration: none;
}

.result-item:hover {
    background: #f8f9fa;
}

.result-title {
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: #2c3e50;
}

.result-description {
    font-size: 0.9rem;
    color: #7f8c8d;
    line-height: 1.4;
}

.result-url {
    font-size: 0.8rem;
    color: #3498db;
    margin-top: 0.25rem;
}

/* No Results */
.no-results {
    text-align: center;
    padding: 3rem 2rem;
    color: #7f8c8d;
}

.no-results-icon {
    margin-bottom: 1rem;
    opacity: 0.5;
}

.no-results h4 {
    margin: 0 0 0.5rem 0;
    color: #5a6c7d;
    font-size: 1.2rem;
}

.no-results p {
    margin: 0;
    font-size: 0.95rem;
}

/* Search Shortcuts */
.search-shortcuts {
    display: flex;
    align-items: center;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.shortcuts-label {
    font-size: 0.9rem;
    color: #7f8c8d;
    font-weight: 500;
}

.shortcut-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    color: #7f8c8d;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(5px);
}

.shortcut-btn:hover {
    background: rgba(52, 152, 219, 0.1);
    border-color: #3498db;
    color: #3498db;
    transform: translateY(-1px);
}

/* Theme Variants */
.tusk-search-bar--default {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    color: #2c3e50;
}

.tusk-search-bar--dark {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    color: white;
}

.tusk-search-bar--dark .search-form {
    background: rgba(45, 45, 45, 0.95);
    border-color: rgba(255, 255, 255, 0.1);
}

.tusk-search-bar--dark .search-input-group {
    background: rgba(30, 30, 30, 0.8);
    border-color: rgba(255, 255, 255, 0.2);
}

.tusk-search-bar--dark .search-input {
    color: white;
}

.tusk-search-bar--dark .search-suggestions,
.tusk-search-bar--dark .search-results {
    background: rgba(45, 45, 45, 0.95);
    border-color: rgba(255, 255, 255, 0.1);
}

.tusk-search-bar--dark .search-title {
    background: linear-gradient(135deg, #00ff88 0%, #00d4ff 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.tusk-search-bar--minimal {
    background: #ffffff;
    color: #333333;
}

.tusk-search-bar--minimal .search-form {
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
}

.tusk-search-bar--gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.tusk-search-bar--gradient .search-form {
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.2);
}

.tusk-search-bar--neon {
    background: #0a0a0a;
    color: #00ff88;
}

.tusk-search-bar--neon .search-form {
    background: rgba(0, 20, 40, 0.9);
    border: 1px solid #00ff88;
    box-shadow: 0 0 30px rgba(0, 255, 136, 0.2);
}

.tusk-search-bar--neon .search-input-group {
    border-color: rgba(0, 255, 136, 0.3);
}

.tusk-search-bar--corporate {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: white;
}

.tusk-search-bar--corporate .search-form {
    background: rgba(255, 255, 255, 0.1);
}

.tusk-search-bar--warm {
    background: linear-gradient(135deg, #ff9a56 0%, #ffad56 100%);
    color: #2c3e50;
}

.tusk-search-bar--cool {
    background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
    color: white;
}

.tusk-search-bar--cool .search-form {
    background: rgba(255, 255, 255, 0.15);
}

/* Style Variants */
.tusk-search-bar--classic .search-form {
    border-radius: 8px;
}

.tusk-search-bar--classic .search-input-group {
    border-radius: 8px;
}

.tusk-search-bar--minimal .search-form {
    background: transparent;
    box-shadow: none;
    border: none;
    padding: 1rem 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .tusk-search-bar {
        padding: 3rem 0;
    }
    
    .search-container {
        padding: 0 1.5rem;
    }
    
    .search-header {
        margin-bottom: 2rem;
    }
    
    .search-form {
        padding: 1.5rem;
    }
    
    .search-input {
        font-size: 1rem;
        padding: 1rem 1rem 1rem 3.5rem;
    }
    
    .search-filters {
        gap: 0.5rem;
    }
    
    .filter-btn {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
    }
    
    .search-shortcuts {
        flex-direction: column;
        gap: 0.75rem;
    }
}

@media (max-width: 480px) {
    .search-container {
        padding: 0 1rem;
    }
    
    .search-form {
        padding: 1rem;
    }
    
    .search-input {
        padding: 0.875rem 0.875rem 0.875rem 3rem;
    }
    
    .search-icon {
        left: 1rem;
    }
    
    .search-filters {
        justify-content: center;
    }
    
    .filter-btn {
        flex: 1;
        min-width: 0;
        max-width: 120px;
    }
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
    .search-input-group,
    .search-submit,
    .filter-btn,
    .shortcut-btn,
    .suggestion-item,
    .result-item {
        transition: none;
    }
}

/* High contrast mode */
@media (prefers-contrast: high) {
    .search-form {
        border: 2px solid black;
    }
    
    .search-input-group {
        border: 2px solid black;
    }
    
    .filter-btn,
    .shortcut-btn {
        border: 2px solid black;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchBars = document.querySelectorAll('.tusk-search-bar');
    
    searchBars.forEach(searchBar => {
        const searchInput = searchBar.querySelector('.search-input');
        const searchClear = searchBar.querySelector('.search-clear');
        const searchForm = searchBar.querySelector('.search-form');
        const searchSuggestions = searchBar.querySelector('.search-suggestions');
        const searchResults = searchBar.querySelector('.search-results');
        const filterBtns = searchBar.querySelectorAll('.filter-btn');
        const suggestionItems = searchBar.querySelectorAll('.suggestion-item');
        const shortcutBtns = searchBar.querySelectorAll('.shortcut-btn');
        
        let searchTimeout;
        let currentFilter = 'all';
        
        // Initialize search functionality
        initializeSearch();
        
        function initializeSearch() {
            // Search input events
            searchInput.addEventListener('input', handleSearchInput);
            searchInput.addEventListener('focus', handleSearchFocus);
            searchInput.addEventListener('blur', handleSearchBlur);
            searchInput.addEventListener('keydown', handleSearchKeydown);
            
            // Clear button
            searchClear.addEventListener('click', clearSearch);
            
            // Form submission
            searchForm.addEventListener('submit', handleSearchSubmit);
            
            // Filter buttons
            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => handleFilterClick(btn));
            });
            
            // Suggestion items
            suggestionItems.forEach(item => {
                item.addEventListener('click', () => handleSuggestionClick(item));
            });
            
            // Shortcut buttons
            shortcutBtns.forEach(btn => {
                btn.addEventListener('click', () => handleShortcutClick(btn));
            });
            
            // Click outside to close
            document.addEventListener('click', (e) => {
                if (!searchBar.contains(e.target)) {
                    hideSuggestions();
                    hideResults();
                }
            });
        }
        
        function handleSearchInput(e) {
            const query = e.target.value.trim();
            
            // Show/hide clear button
            searchClear.style.display = query ? 'block' : 'none';
            
            // Clear previous timeout
            clearTimeout(searchTimeout);
            
            if (query.length === 0) {
                showSuggestions();
                hideResults();
                return;
            }
            
            if (query.length < 2) {
                hideSuggestions();
                hideResults();
                return;
            }
            
            // Debounce search
            searchTimeout = setTimeout(() => {
                performSearch(query);
            }, 300);
        }
        
        function handleSearchFocus() {
            if (searchInput.value.trim().length === 0) {
                showSuggestions();
            } else {
                performSearch(searchInput.value.trim());
            }
        }
        
        function handleSearchBlur() {
            // Delay hiding to allow clicks on suggestions/results
            setTimeout(() => {
                if (!searchBar.querySelector(':hover')) {
                    hideSuggestions();
                    hideResults();
                }
            }, 200);
        }
        
        function handleSearchKeydown(e) {
            if (e.key === 'Escape') {
                searchInput.blur();
                hideSuggestions();
                hideResults();
            } else if (e.key === 'Enter') {
                e.preventDefault();
                performSearch(searchInput.value.trim());
            }
        }
        
        function handleSearchSubmit(e) {
            e.preventDefault();
            const query = searchInput.value.trim();
            if (query) {
                performSearch(query);
                logSearchQuery(query);
            }
        }
        
        function clearSearch() {
            searchInput.value = '';
            searchInput.focus();
            searchClear.style.display = 'none';
            showSuggestions();
            hideResults();
        }
        
        function handleFilterClick(btn) {
            // Update active state
            filterBtns.forEach(b => {
                b.classList.remove('active');
                b.setAttribute('aria-pressed', 'false');
            });
            btn.classList.add('active');
            btn.setAttribute('aria-pressed', 'true');
            
            currentFilter = btn.dataset.filter;
            
            // Re-perform search if there's a query
            const query = searchInput.value.trim();
            if (query) {
                performSearch(query);
            }
        }
        
        function handleSuggestionClick(item) {
            const suggestion = item.dataset.suggestion;
            searchInput.value = suggestion;
            performSearch(suggestion);
            hideSuggestions();
            logSearchQuery(suggestion, 'suggestion');
        }
        
        function handleShortcutClick(btn) {
            const action = btn.dataset.action;
            
            switch (action) {
                case 'voice-search':
                    startVoiceSearch();
                    break;
                case 'advanced-search':
                    showAdvancedSearch();
                    break;
            }
        }
        
        function showSuggestions() {
            if (searchSuggestions) {
                searchSuggestions.style.display = 'block';
                hideResults();
            }
        }
        
        function hideSuggestions() {
            if (searchSuggestions) {
                searchSuggestions.style.display = 'none';
            }
        }
        
        function showResults() {
            if (searchResults) {
                searchResults.style.display = 'block';
                hideSuggestions();
            }
        }
        
        function hideResults() {
            if (searchResults) {
                searchResults.style.display = 'none';
            }
        }
        
        function performSearch(query) {
            showResults();
            
            // Simulate search API call
            setTimeout(() => {
                const results = getSearchResults(query, currentFilter);
                displayResults(results, query);
            }, 500);
        }
        
        function getSearchResults(query, filter) {
            // Mock search results
            const allResults = [
                {
                    title: 'Web Development Services',
                    description: 'Professional web development with modern technologies and best practices.',
                    url: '/services/web-development',
                    category: 'services'
                },
                {
                    title: 'Mobile App Development',
                    description: 'Native and cross-platform mobile applications for iOS and Android.',
                    url: '/services/mobile-apps',
                    category: 'services'
                },
                {
                    title: 'UI/UX Design Process',
                    description: 'Our comprehensive approach to creating user-centered designs.',
                    url: '/blog/ui-ux-design-process',
                    category: 'blog'
                },
                {
                    title: 'E-commerce Platform',
                    description: 'Complete e-commerce solution with payment integration.',
                    url: '/products/ecommerce-platform',
                    category: 'products'
                },
                {
                    title: 'Digital Marketing Strategy',
                    description: 'Comprehensive digital marketing services to grow your business.',
                    url: '/services/digital-marketing',
                    category: 'services'
                },
                {
                    title: 'Our Team',
                    description: 'Meet the talented professionals behind our success.',
                    url: '/team',
                    category: 'team'
                }
            ];
            
            // Filter by query
            let results = allResults.filter(result => 
                result.title.toLowerCase().includes(query.toLowerCase()) ||
                result.description.toLowerCase().includes(query.toLowerCase())
            );
            
            // Filter by category
            if (filter !== 'all') {
                results = results.filter(result => result.category === filter);
            }
            
            return results;
        }
        
        function displayResults(results, query) {
            const resultsList = searchResults.querySelector('.results-list');
            const resultsCount = searchResults.querySelector('.results-count');
            const noResults = searchResults.querySelector('.no-results');
            
            // Update count
            resultsCount.textContent = `${results.length} result${results.length !== 1 ? 's' : ''} found`;
            
            if (results.length === 0) {
                resultsList.style.display = 'none';
                noResults.style.display = 'block';
            } else {
                resultsList.style.display = 'block';
                noResults.style.display = 'none';
                
                // Clear previous results
                resultsList.innerHTML = '';
                
                // Add new results
                results.forEach(result => {
                    const resultElement = createResultElement(result, query);
                    resultsList.appendChild(resultElement);
                });
            }
        }
        
        function createResultElement(result, query) {
            const div = document.createElement('a');
            div.className = 'result-item';
            div.href = result.url;
            
            // Highlight search terms
            const highlightedTitle = highlightSearchTerms(result.title, query);
            const highlightedDescription = highlightSearchTerms(result.description, query);
            
            div.innerHTML = `
                <div class="result-title">${highlightedTitle}</div>
                <div class="result-description">${highlightedDescription}</div>
                <div class="result-url">${result.url}</div>
            `;
            
            div.addEventListener('click', (e) => {
                e.preventDefault();
                logSearchResult(result, query);
                window.location.href = result.url;
            });
            
            return div;
        }
        
        function highlightSearchTerms(text, query) {
            const regex = new RegExp(`(${query})`, 'gi');
            return text.replace(regex, '<mark style="background: #fff3cd; padding: 0 2px;">$1</mark>');
        }
        
        function startVoiceSearch() {
            if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
                const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                const recognition = new SpeechRecognition();
                
                recognition.continuous = false;
                recognition.interimResults = false;
                recognition.lang = 'en-US';
                
                recognition.onstart = () => {
                    searchInput.placeholder = 'Listening...';
                    searchInput.style.background = 'linear-gradient(90deg, #e74c3c, #c0392b)';
                    searchInput.style.color = 'white';
                };
                
                recognition.onresult = (event) => {
                    const transcript = event.results[0][0].transcript;
                    searchInput.value = transcript;
                    performSearch(transcript);
                    logSearchQuery(transcript, 'voice');
                };
                
                recognition.onerror = () => {
                    if (window.TuskToast) {
                        window.TuskToast.error('Voice Search', 'Could not access microphone');
                    }
                };
                
                recognition.onend = () => {
                    searchInput.placeholder = 'What can we help you find?';
                    searchInput.style.background = '';
                    searchInput.style.color = '';
                };
                
                recognition.start();
            } else {
                if (window.TuskToast) {
                    window.TuskToast.warning('Voice Search', 'Voice search is not supported in this browser');
                } else {
                    alert('Voice search is not supported in this browser');
                }
            }
        }
        
        function showAdvancedSearch() {
            if (window.TuskToast) {
                window.TuskToast.info('Advanced Search', 'Advanced search options coming soon!');
            } else {
                alert('Advanced search options coming soon!');
            }
        }
        
        function logSearchQuery(query, method = 'text') {
            console.log(`Search performed: "${query}" via ${method}`);
            
            // Send analytics event
            if (typeof gtag !== 'undefined') {
                gtag('event', 'search', {
                    'search_term': query,
                    'search_method': method,
                    'search_filter': currentFilter
                });
            }
        }
        
        function logSearchResult(result, query) {
            console.log(`Search result clicked: "${result.title}" for query "${query}"`);
            
            // Send analytics event
            if (typeof gtag !== 'undefined') {
                gtag('event', 'select_content', {
                    'content_type': 'search_result',
                    'content_id': result.url,
                    'search_term': query
                });
            }
        }
    });
});
</script>