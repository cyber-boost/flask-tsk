<?php
/**
 * <?tusk> TuskPHP Babar - The Royal CMS (Rebuilt)
 * ===============================================
 * 
 * 🐘 BACKSTORY: Babar - The Elephant King
 * --------------------------------------
 * Babar, created by Jean de Brunhoff in 1931, is perhaps the most famous
 * fictional elephant. After his mother was killed by hunters, young Babar
 * fled to the city where he was educated by the Old Lady. He returned to
 * the elephant kingdom wearing a green suit, bringing civilization and
 * modern ideas. He became king, built the city of Celesteville, and ruled
 * with wisdom and compassion, always balancing tradition with progress.
 * 
 * WHY THIS NAME: Like King Babar who brought order and civilization to
 * the elephant kingdom, this CMS brings structure and elegance to content
 * management. Babar transformed a jungle into a functioning society with
 * rules, roles, and culture - exactly what this CMS does for your content.
 * Role-based access, organized hierarchies, and civilized content management.
 * 
 * "In the great forest, a little elephant is born. His name is Babar."
 * 
 * FEATURES:
 * - Hierarchical content organization (like Celesteville)
 * - Integration with Herd role-based access control
 * - Multi-language support (Babar spoke French!)
 * - Version control and content history
 * - Workflow management with approvals
 * - Rich media management
 * - SEO-friendly URLs and metadata
 * - Component-based page builder
 * - Theme integration with all 13 TuskPHP themes
 * 
 * @package TuskPHP\Elephants
 * @author  TuskPHP Team
 * @since   2.0.0
 */

namespace TuskPHP\Elephants;

use TuskPHP\{TuskDb, Memory, TuskSafe};
use TuskPHP\Herd\Herd;
use TuskPHP\App\Utils\PermissionHelper;

class Babar {
    
    private $permissionHelper;
    private $currentUser = null;
    private $defaultLanguage = 'en';
    private $languages = ['en', 'fr', 'es', 'de']; // Babar was international!
    
    // CMS-specific capabilities
    private $cmsCapabilities = [
        'cms.view' => 'View CMS interface',
        'cms.create' => 'Create content',
        'cms.edit' => 'Edit content',
        'cms.edit_others' => 'Edit others\' content',
        'cms.publish' => 'Publish content',
        'cms.delete' => 'Delete content',
        'cms.manage_media' => 'Manage media library',
        'cms.manage_settings' => 'Manage CMS settings',
        'cms.view_analytics' => 'View content analytics',
        'cms.manage_themes' => 'Manage themes',
        'cms.export' => 'Export content'
    ];
    
    /**
     * Initialize Babar - The kingdom awakens
     */
    public function __construct() {
        $this->currentUser = Herd::user();
        $this->permissionHelper = new PermissionHelper($this->getDbConnection());
        $this->initializeCmsCapabilities();
        $this->ensureCmsTables();
    }
    
    /**
     * Check if user has permission for CMS action
     */
    private function hasPermission(string $capability): bool {
        if (!$this->currentUser) {
            return false;
        }
        
        // Super admin can do everything
        if ($this->permissionHelper->userHasCapability($this->currentUser['id'], 'all')) {
            return true;
        }
        
        return $this->permissionHelper->userHasCapability($this->currentUser['id'], $capability);
    }
    
    /**
     * Create content - Building Celesteville, one page at a time
     */
    public function createStory(array $data): array {
        if (!$this->hasPermission('cms.create')) {
            throw new \Exception("You need royal permission to create content in Celesteville!");
        }
        
        $story = [
            'id' => $this->generateId(),
            'title' => $data['title'] ?? 'Untitled Story',
            'slug' => $this->generateSlug($data['title'] ?? 'untitled-story'),
            'content' => $data['content'] ?? '',
            'excerpt' => $data['excerpt'] ?? $this->generateExcerpt($data['content'] ?? ''),
            'type' => $data['type'] ?? 'page',
            'status' => 'draft',
            'author_id' => $this->currentUser['id'],
            'created_at' => time(),
            'updated_at' => time(),
            'published_at' => null,
            'version' => 1,
            'language' => $data['language'] ?? $this->defaultLanguage,
            'parent_id' => $data['parent_id'] ?? null,
            'template' => $data['template'] ?? 'default',
            'theme' => $data['theme'] ?? 'tusk_modern',
            'meta_title' => $data['meta_title'] ?? $data['title'] ?? '',
            'meta_description' => $data['meta_description'] ?? '',
            'meta_keywords' => $data['meta_keywords'] ?? '',
            'featured_image' => $data['featured_image'] ?? null,
            'components' => json_encode($data['components'] ?? []),
            'settings' => json_encode($data['settings'] ?? [])
        ];
        
        // Store in the royal archives
        $result = TuskDb::table('babar_content')->insert($story);
        
        if ($result) {
            // Cache the story for quick access
            Memory::remember("babar_story_{$story['id']}", $story, 3600);
            
            // Create initial version
            $this->createVersion($story, 'Initial creation');
            
            // Track activity
            Herd::track('cms_content_created', [
                'content_id' => $story['id'],
                'title' => $story['title'],
                'type' => $story['type']
            ]);
            
            return ['success' => true, 'data' => $story];
        }
        
        return ['success' => false, 'error' => 'Failed to create content'];
    }
    
    /**
     * Update existing content
     */
    public function updateStory(string $storyId, array $data): array {
        $story = $this->getStory($storyId);
        
        if (!$story) {
            return ['success' => false, 'error' => 'Content not found'];
        }
        
        // Check permissions
        $canEdit = $this->hasPermission('cms.edit') || 
                  ($this->hasPermission('cms.edit_others') && $story['author_id'] != $this->currentUser['id']) ||
                  ($story['author_id'] == $this->currentUser['id']);
                  
        if (!$canEdit) {
            throw new \Exception("You don't have permission to edit this royal decree!");
        }
        
        // Update data
        $updateData = [
            'title' => $data['title'] ?? $story['title'],
            'content' => $data['content'] ?? $story['content'],
            'excerpt' => $data['excerpt'] ?? $story['excerpt'],
            'type' => $data['type'] ?? $story['type'],
            'updated_at' => time(),
            'version' => $story['version'] + 1,
            'language' => $data['language'] ?? $story['language'],
            'parent_id' => $data['parent_id'] ?? $story['parent_id'],
            'template' => $data['template'] ?? $story['template'],
            'theme' => $data['theme'] ?? $story['theme'],
            'meta_title' => $data['meta_title'] ?? $story['meta_title'],
            'meta_description' => $data['meta_description'] ?? $story['meta_description'],
            'meta_keywords' => $data['meta_keywords'] ?? $story['meta_keywords'],
            'featured_image' => $data['featured_image'] ?? $story['featured_image'],
            'components' => json_encode($data['components'] ?? json_decode($story['components'], true)),
            'settings' => json_encode($data['settings'] ?? json_decode($story['settings'], true))
        ];
        
        // Update slug if title changed
        if ($data['title'] && $data['title'] !== $story['title']) {
            $updateData['slug'] = $this->generateSlug($data['title']);
        }
        
        $result = TuskDb::table('babar_content')
                       ->where('id', $storyId)
                       ->update($updateData);
        
        if ($result) {
            // Create version history
            $this->createVersion(array_merge($story, $updateData), 'Content updated');
            
            // Clear cache
            Memory::forget("babar_story_{$storyId}");
            
            // Track activity
            Herd::track('cms_content_updated', [
                'content_id' => $storyId,
                'title' => $updateData['title'],
                'version' => $updateData['version']
            ]);
            
            return ['success' => true, 'data' => $updateData];
        }
        
        return ['success' => false, 'error' => 'Failed to update content'];
    }
    
    /**
     * Publish content - Royal decree makes it official
     */
    public function publish(string $storyId): array {
        if (!$this->hasPermission('cms.publish')) {
            throw new \Exception("Only the King and his ministers can publish royal decrees!");
        }
        
        $story = $this->getStory($storyId);
        if (!$story) {
            return ['success' => false, 'error' => 'Content not found'];
        }
        
        $updateData = [
            'status' => 'published',
            'published_at' => time(),
            'updated_at' => time()
        ];
        
        $result = TuskDb::table('babar_content')
                       ->where('id', $storyId)
                       ->update($updateData);
        
        if ($result) {
            // Create version history
            $this->createVersion(array_merge($story, $updateData), 'Content published');
            
            // Clear cache
            Memory::forget("babar_story_{$storyId}");
            
            // Track activity
            Herd::track('cms_content_published', [
                'content_id' => $storyId,
                'title' => $story['title']
            ]);
            
            // Announce to the kingdom (could trigger notifications, cache clearing, etc.)
            $this->announcePublication($story);
            
            return ['success' => true, 'message' => 'Royal decree has been published!'];
        }
        
        return ['success' => false, 'error' => 'Failed to publish content'];
    }
    
    /**
     * Get single story by ID or slug
     */
    public function getStory($identifier): ?array {
        // Try cache first
        if (is_string($identifier) && !is_numeric($identifier)) {
            // It's a slug
            $story = Memory::recall("babar_story_slug_{$identifier}");
            if ($story) return $story;
            
            $story = TuskDb::table('babar_content')
                          ->where('slug', $identifier)
                          ->first();
        } else {
            // It's an ID
            $story = Memory::recall("babar_story_{$identifier}");
            if ($story) return $story;
            
            $story = TuskDb::table('babar_content')
                          ->where('id', $identifier)
                          ->first();
        }
        
        if ($story) {
            // Decode JSON fields
            $story['components'] = json_decode($story['components'] ?? '[]', true);
            $story['settings'] = json_decode($story['settings'] ?? '{}', true);
            
            // Cache it
            Memory::remember("babar_story_{$story['id']}", $story, 3600);
            if ($story['slug']) {
                Memory::remember("babar_story_slug_{$story['slug']}", $story, 3600);
            }
        }
        
        return $story;
    }
    
    /**
     * List content with filters - The royal library
     */
    public function getLibrary(array $filters = []): array {
        $query = TuskDb::table('babar_content');
        
        // Apply filters
        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
        }
        
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        if (isset($filters['language'])) {
            $query->where('language', $filters['language']);
        }
        
        if (isset($filters['author_id'])) {
            $query->where('author_id', $filters['author_id']);
        }
        
        if (isset($filters['parent_id'])) {
            $query->where('parent_id', $filters['parent_id']);
        }
        
        // Search functionality
        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%")
                  ->orWhere('excerpt', 'LIKE', "%{$search}%");
            });
        }
        
        // Pagination
        $page = $filters['page'] ?? 1;
        $perPage = $filters['per_page'] ?? 20;
        $offset = ($page - 1) * $perPage;
        
        // Order
        $orderBy = $filters['order_by'] ?? 'updated_at';
        $orderDir = $filters['order_dir'] ?? 'desc';
        
        $stories = $query->orderBy($orderBy, $orderDir)
                        ->limit($perPage)
                        ->offset($offset)
                        ->get();
        
        // Get total count for pagination
        $totalQuery = TuskDb::table('babar_content');
        if (isset($filters['type'])) $totalQuery->where('type', $filters['type']);
        if (isset($filters['status'])) $totalQuery->where('status', $filters['status']);
        if (isset($filters['language'])) $totalQuery->where('language', $filters['language']);
        if (isset($filters['author_id'])) $totalQuery->where('author_id', $filters['author_id']);
        
        $total = $totalQuery->count();
        
        // Decode JSON fields for each story
        foreach ($stories as &$story) {
            $story['components'] = json_decode($story['components'] ?? '[]', true);
            $story['settings'] = json_decode($story['settings'] ?? '{}', true);
        }
        
        return [
            'data' => $stories,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'total_pages' => ceil($total / $perPage)
            ]
        ];
    }
    
    /**
     * Delete content (soft delete)
     */
    public function deleteStory(string $storyId): array {
        if (!$this->hasPermission('cms.delete')) {
            throw new \Exception("You don't have permission to banish stories from Celesteville!");
        }
        
        $story = $this->getStory($storyId);
        if (!$story) {
            return ['success' => false, 'error' => 'Content not found'];
        }
        
        $result = TuskDb::table('babar_content')
                       ->where('id', $storyId)
                       ->update([
                           'status' => 'deleted',
                           'deleted_at' => time(),
                           'updated_at' => time()
                       ]);
        
        if ($result) {
            // Clear cache
            Memory::forget("babar_story_{$storyId}");
            if ($story['slug']) {
                Memory::forget("babar_story_slug_{$story['slug']}");
            }
            
            // Track activity
            Herd::track('cms_content_deleted', [
                'content_id' => $storyId,
                'title' => $story['title']
            ]);
            
            return ['success' => true, 'message' => 'Content has been banished from the kingdom'];
        }
        
        return ['success' => false, 'error' => 'Failed to delete content'];
    }
    
    /**
     * Get content analytics and statistics
     */
    public function getAnalytics(): array {
        if (!$this->hasPermission('cms.view_analytics')) {
            throw new \Exception("You need royal permission to view the kingdom's analytics!");
        }
        
        $totalContent = TuskDb::table('babar_content')->count();
        $publishedContent = TuskDb::table('babar_content')->where('status', 'published')->count();
        $draftContent = TuskDb::table('babar_content')->where('status', 'draft')->count();
        
        $contentByType = TuskDb::query("
            SELECT type, COUNT(*) as count 
            FROM babar_content 
            WHERE status != 'deleted' 
            GROUP BY type
        ");
        
        $recentActivity = TuskDb::query("
            SELECT * FROM babar_content 
            WHERE status != 'deleted' 
            ORDER BY updated_at DESC 
            LIMIT 10
        ");
        
        return [
            'summary' => [
                'total_content' => $totalContent,
                'published' => $publishedContent,
                'drafts' => $draftContent,
                'deleted' => $totalContent - $publishedContent - $draftContent
            ],
            'content_by_type' => $contentByType,
            'recent_activity' => $recentActivity,
            'system_info' => [
                'cms_version' => '2.0.0',
                'themes_available' => 13,
                'components_available' => $this->getAvailableComponentsCount(),
                'languages_supported' => count($this->languages)
            ]
        ];
    }
    
    /**
     * Create version history entry
     */
    private function createVersion(array $story, string $changeNote = ''): void {
        $version = [
            'content_id' => $story['id'],
            'version_number' => $story['version'],
            'title' => $story['title'],
            'content' => $story['content'],
            'components' => is_string($story['components']) ? $story['components'] : json_encode($story['components']),
            'settings' => is_string($story['settings']) ? $story['settings'] : json_encode($story['settings']),
            'changed_by' => $this->currentUser['id'],
            'changed_at' => time(),
            'change_note' => $changeNote ?: "Version {$story['version']} of the royal chronicles"
        ];
        
        TuskDb::table('babar_versions')->insert($version);
    }
    
    /**
     * Get version history for content
     */
    public function getVersionHistory(string $storyId): array {
        if (!$this->hasPermission('cms.view')) {
            return [];
        }
        
        return TuskDb::table('babar_versions')
                    ->where('content_id', $storyId)
                    ->orderBy('version_number', 'desc')
                    ->get();
    }
    
    /**
     * Initialize CMS capabilities in the database
     */
    private function initializeCmsCapabilities(): void {
        foreach ($this->cmsCapabilities as $capability => $description) {
            $existing = TuskDb::table('capabilities')
                             ->where('name', $capability)
                             ->first();
            
            if (!$existing) {
                TuskDb::table('capabilities')->insert([
                    'name' => $capability,
                    'display_name' => ucwords(str_replace(['.', '_'], ' ', $capability)),
                    'description' => $description,
                    'category' => 'cms',
                    'is_system' => false,
                    'created_at' => time()
                ]);
            }
        }
    }
    
    /**
     * Ensure CMS database tables exist
     */
    private function ensureCmsTables(): void {
        // This would normally be handled by migrations, but for demo purposes:
        $tables = [
            'babar_content' => "
                CREATE TABLE IF NOT EXISTS babar_content (
                    id VARCHAR(20) PRIMARY KEY,
                    title VARCHAR(255) NOT NULL,
                    slug VARCHAR(255) UNIQUE,
                    content LONGTEXT,
                    excerpt TEXT,
                    type VARCHAR(50) DEFAULT 'page',
                    status VARCHAR(20) DEFAULT 'draft',
                    author_id INT NOT NULL,
                    created_at INT NOT NULL,
                    updated_at INT NOT NULL,
                    published_at INT NULL,
                    deleted_at INT NULL,
                    version INT DEFAULT 1,
                    language VARCHAR(5) DEFAULT 'en',
                    parent_id VARCHAR(20) NULL,
                    template VARCHAR(50) DEFAULT 'default',
                    theme VARCHAR(50) DEFAULT 'tusk_modern',
                    meta_title VARCHAR(255),
                    meta_description TEXT,
                    meta_keywords TEXT,
                    featured_image VARCHAR(255),
                    components LONGTEXT,
                    settings LONGTEXT,
                    INDEX idx_status (status),
                    INDEX idx_type (type),
                    INDEX idx_author (author_id),
                    INDEX idx_slug (slug),
                    INDEX idx_published (published_at)
                )
            ",
            'babar_versions' => "
                CREATE TABLE IF NOT EXISTS babar_versions (
                    id INT PRIMARY KEY AUTO_INCREMENT,
                    content_id VARCHAR(20) NOT NULL,
                    version_number INT NOT NULL,
                    title VARCHAR(255),
                    content LONGTEXT,
                    components LONGTEXT,
                    settings LONGTEXT,
                    changed_by INT NOT NULL,
                    changed_at INT NOT NULL,
                    change_note VARCHAR(255),
                    INDEX idx_content_version (content_id, version_number)
                )
            "
        ];
        
        foreach ($tables as $tableName => $sql) {
            TuskDb::query($sql);
        }
    }
    
    /**
     * Generate unique ID for content
     */
    private function generateId(): string {
        return 'story_' . bin2hex(random_bytes(8));
    }
    
    /**
     * Generate URL-friendly slug
     */
    private function generateSlug(string $title): string {
        $slug = strtolower($title);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');
        
        // Ensure uniqueness
        $originalSlug = $slug;
        $counter = 1;
        
        while (TuskDb::table('babar_content')->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
    
    /**
     * Generate excerpt from content
     */
    private function generateExcerpt(string $content, int $length = 160): string {
        $text = strip_tags($content);
        if (strlen($text) <= $length) {
            return $text;
        }
        
        return substr($text, 0, $length) . '...';
    }
    
    /**
     * Get database connection for PermissionHelper
     */
    private function getDbConnection() {
        // This should return your PDO connection
        // For now, we'll use TuskDb's connection
        return TuskDb::getConnection();
    }
    
    /**
     * Count available components
     */
    private function getAvailableComponentsCount(): int {
        $componentDir = __DIR__ . '/../../components/';
        if (!is_dir($componentDir)) {
            return 0;
        }
        
        $components = glob($componentDir . '*.php');
        return count($components);
    }
    
    /**
     * Announce publication (could trigger notifications, cache clearing, etc.)
     */
    private function announcePublication(array $story): void {
        // This could trigger various actions:
        // - Send notifications to subscribers
        // - Clear relevant caches
        // - Update search indices
        // - Trigger webhooks
        
        Memory::forget('cms_published_content_cache');
        
        // Log the royal announcement
        error_log("🎺 Royal Herald: '{$story['title']}' has been published in Celesteville!");
    }
}