<?php
/**
 * <?tusk> TuskPHP Heffalump - The Fuzzy Search Expert
 * ==================================================
 * 
 * 🐘 BACKSTORY: Heffalump - The Mysterious Elephant
 * ------------------------------------------------
 * In A.A. Milne's Winnie-the-Pooh stories, Heffalumps are mysterious
 * elephant-like creatures that exist mostly in imagination. Pooh and Piglet
 * are both fascinated and frightened by them, setting elaborate traps that
 * never quite work. Heffalumps are elusive, hard to define precisely, and
 * everyone seems to have a slightly different idea of what they look like.
 * The beauty is in their ambiguity - they might be scary, or friendly, big
 * or small, real or imagined.
 * 
 * WHY THIS NAME: Like the elusive Heffalump that's hard to pin down exactly,
 * this fuzzy search system finds matches even when you're not quite sure what
 * you're looking for. It handles misspellings, partial matches, and "sounds
 * like" searches - perfect for when users are hunting for something as
 * mysterious as a Heffalump.
 * 
 * "A Heffalump or Horrible Heffalump is a creature mentioned in the Winnie-the-Pooh stories"
 * 
 * FEATURES:
 * - Levenshtein distance matching
 * - Phonetic matching (Soundex/Metaphone)
 * - N-gram similarity
 * - Fuzzy autocomplete
 * - Typo correction
 * - "Did you mean?" suggestions
 * - Weighted multi-field search
 * 
 * @package TuskPHP\Elephants
 * @author  TuskPHP Team
 * @since   1.0.0
 */

namespace TuskPHP\Elephants;

use TuskPHP\{Memory, TuskDb};
use TuskPHP\Herd\Services\Intelligence;
use Exception;

class Heffalump {
    
    private $searchIndex = [];
    private $tolerance = 2;        // How fuzzy? (Like how blurry is a Heffalump?)
    private $minSimilarity = 0.7;  // Minimum match threshold
    private $soundexEnabled = true;
    
    // Enhanced properties for Elasticsearch and multi-instance support
    private $elasticClient = null;
    private $intelligence = null;
    private $db = null;
    private $instanceId = null;
    private $config = [];
    private $analytics = [];
    
    /**
     * Initialize Heffalump - The search begins
     */
    public function __construct($instanceId = 'default', $config = []) {
        $this->instanceId = $instanceId;
        $this->config = $this->loadConfiguration($instanceId, $config);
        
        // Initialize dependencies
        $this->db = new TuskDb();
        $this->intelligence = new Intelligence();
        
        // Load search index and prepare
        $this->loadSearchIndex();
        $this->prepareHunting();
        $this->initializeElasticsearch();
    }
    
    /**
     * Fuzzy search - Looking for Heffalumps in the woods
     */
    public function hunt($query, $searchIn = []) {
        $query = strtolower(trim($query));
        $results = [];
        
        // First, check if it's exactly what we're looking for
        if ($exact = $this->exactMatch($query, $searchIn)) {
            return $exact;
        }
        
        // No exact match? Time for fuzzy hunting!
        echo "🔍 Heffalump hunting for something like '{$query}'...\n";
        
        // Try different hunting techniques
        $results = array_merge(
            $this->levenshteinHunt($query, $searchIn),
            $this->soundexHunt($query, $searchIn),
            $this->ngramHunt($query, $searchIn)
        );
        
        // Remove duplicate catches
        $results = $this->deduplicateResults($results);
        
        // Sort by relevance - closest Heffalumps first
        usort($results, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });
        
        return $results;
    }
    
    /**
     * Levenshtein hunt - How many steps to catch the Heffalump?
     */
    private function levenshteinHunt($query, $haystack) {
        $catches = [];
        
        foreach ($haystack as $item) {
            $distance = levenshtein($query, strtolower($item));
            
            // Is this close enough to be our Heffalump?
            if ($distance <= $this->tolerance) {
                $catches[] = [
                    'match' => $item,
                    'distance' => $distance,
                    'score' => 1 - ($distance / max(strlen($query), strlen($item))),
                    'method' => 'levenshtein',
                    'confidence' => $this->getConfidence($distance)
                ];
            }
        }
        
        return $catches;
    }
    
    /**
     * Soundex hunt - Does it sound like a Heffalump?
     */
    private function soundexHunt($query, $haystack) {
        if (!$this->soundexEnabled) {
            return [];
        }
        
        $catches = [];
        $querySoundex = soundex($query);
        
        foreach ($haystack as $item) {
            if (soundex($item) === $querySoundex) {
                // Sounds like a Heffalump!
                $catches[] = [
                    'match' => $item,
                    'distance' => $this->calculatePhoneticDistance($query, $item),
                    'score' => 0.8, // Soundex matches are pretty good
                    'method' => 'soundex',
                    'confidence' => 'sounds_similar'
                ];
            }
        }
        
        return $catches;
    }
    
    /**
     * N-gram hunt - Looking for Heffalump footprints
     */
    private function ngramHunt($query, $haystack, $n = 2) {
        $catches = [];
        $queryGrams = $this->getNgrams($query, $n);
        
        foreach ($haystack as $item) {
            $itemGrams = $this->getNgrams(strtolower($item), $n);
            $similarity = $this->calculateNgramSimilarity($queryGrams, $itemGrams);
            
            if ($similarity >= $this->minSimilarity) {
                $catches[] = [
                    'match' => $item,
                    'distance' => 1 - $similarity,
                    'score' => $similarity,
                    'method' => 'ngram',
                    'confidence' => $this->getSimilarityConfidence($similarity)
                ];
            }
        }
        
        return $catches;
    }
    
    /**
     * Did you mean? - When the Heffalump trap catches something unexpected
     */
    public function didYouMean($query, $context = []) {
        $suggestions = $this->hunt($query, $context);
        
        if (empty($suggestions)) {
            return null;
        }
        
        // Get the best match
        $best = $suggestions[0];
        
        // Only suggest if we're reasonably confident
        if ($best['score'] >= 0.6) {
            return [
                'suggestion' => $best['match'],
                'confidence' => $best['score'],
                'message' => "Did you mean '{$best['match']}'? (Like hunting for Heffalumps!)"
            ];
        }
        
        return null;
    }
    
    /**
     * Autocomplete - Heffalump tracks lead the way
     */
    public function trackSuggestions($partial, $limit = 5) {
        $partial = strtolower(trim($partial));
        $suggestions = [];
        
        // Look for Heffalump tracks (partial matches)
        foreach ($this->searchIndex as $item) {
            if (strpos(strtolower($item), $partial) === 0) {
                $suggestions[] = [
                    'value' => $item,
                    'label' => $item,
                    'score' => 1.0 // Perfect prefix match
                ];
            } elseif (strpos(strtolower($item), $partial) !== false) {
                $suggestions[] = [
                    'value' => $item,
                    'label' => $item,
                    'score' => 0.7 // Contains match
                ];
            }
        }
        
        // Also check fuzzy matches for short queries
        if (strlen($partial) >= 3) {
            $fuzzyMatches = $this->hunt($partial, $this->searchIndex);
            foreach ($fuzzyMatches as $match) {
                if ($match['score'] >= 0.6) {
                    $suggestions[] = [
                        'value' => $match['match'],
                        'label' => $match['match'] . ' (fuzzy)',
                        'score' => $match['score'] * 0.8
                    ];
                }
            }
        }
        
        // Sort and limit
        usort($suggestions, fn($a, $b) => $b['score'] <=> $a['score']);
        
        return array_slice($suggestions, 0, $limit);
    }
    
    /**
     * Get N-grams - Breaking words into Heffalump-sized pieces
     */
    private function getNgrams($string, $n = 2) {
        $ngrams = [];
        $string = str_pad($string, strlen($string) + $n - 1, ' ');
        
        for ($i = 0; $i < strlen($string) - $n + 1; $i++) {
            $ngrams[] = substr($string, $i, $n);
        }
        
        return $ngrams;
    }
    
    /**
     * Calculate N-gram similarity - How Heffalump-like is it?
     */
    private function calculateNgramSimilarity($ngrams1, $ngrams2) {
        $intersection = count(array_intersect($ngrams1, $ngrams2));
        $union = count(array_unique(array_merge($ngrams1, $ngrams2)));
        
        return $union > 0 ? $intersection / $union : 0;
    }
    
    /**
     * Get confidence level - How sure are we it's a Heffalump?
     */
    private function getConfidence($distance) {
        if ($distance == 0) return 'exact_heffalump';
        if ($distance == 1) return 'almost_heffalump';
        if ($distance == 2) return 'possibly_heffalump';
        return 'might_be_heffalump';
    }
    
    /**
     * Prepare for Heffalump hunting
     */
    private function prepareHunting() {
        // Set traps (configure search parameters)
        $this->tolerance = $this->config['tolerance'] ?? Memory::recall("heffalump_{$this->instanceId}_tolerance") ?? 2;
        $this->minSimilarity = $this->config['min_similarity'] ?? Memory::recall("heffalump_{$this->instanceId}_similarity") ?? 0.7;
        $this->soundexEnabled = $this->config['soundex_enabled'] ?? true;
        
        // Pooh's honey pot (cache warming)
        Memory::remember("heffalump_{$this->instanceId}_ready", true, 3600);
    }
    
    /**
     * Load configuration for this Heffalump instance
     */
    private function loadConfiguration($instanceId, $customConfig = []) {
        // Try to load from TuskLang config file
        $configFile = __DIR__ . "/../../config/heffalumps/{$instanceId}.tsk";
        $config = [];
        
        if (file_exists($configFile)) {
            $config = $this->parseTuskLangConfig($configFile);
        }
        
        // Merge with custom config
        $config = array_merge($config, $customConfig);
        
        // Set defaults
        $defaults = [
            'name' => ucfirst($instanceId) . ' Search',
            'description' => 'Fuzzy search instance',
            'elasticsearch_enabled' => true,
            'index_name' => "heffalump_{$instanceId}",
            'search_fields' => ['*'],
            'boost_fields' => [],
            'filters' => [],
            'max_results' => 50,
            'min_score' => 0.1,
            'highlight' => true,
            'track_searches' => true,
            'cache_ttl' => 300,
            'stop_words' => ['the', 'a', 'an', 'and', 'or', 'but'],
            'synonyms' => []
        ];
        
        return array_merge($defaults, $config);
    }
    
    /**
     * Parse TuskLang configuration file
     */
    private function parseTuskLangConfig($file) {
        $content = file_get_contents($file);
        $config = [];
        
        // Simple TuskLang parser (key = value format)
        $lines = explode("\n", $content);
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || strpos($line, '#') === 0) continue;
            
            if (preg_match('/^([a-zA-Z0-9_\.]+)\s*=\s*(.+)$/', $line, $matches)) {
                $key = $matches[1];
                $value = trim($matches[2], '"\'');
                
                // Handle nested keys
                $keys = explode('.', $key);
                $current = &$config;
                foreach ($keys as $k) {
                    if (!isset($current[$k])) {
                        $current[$k] = [];
                    }
                    $current = &$current[$k];
                }
                $current = $this->parseValue($value);
            }
        }
        
        return $config;
    }
    
    /**
     * Parse TuskLang value
     */
    private function parseValue($value) {
        // Boolean
        if ($value === 'true') return true;
        if ($value === 'false') return false;
        
        // Number
        if (is_numeric($value)) {
            return strpos($value, '.') !== false ? (float)$value : (int)$value;
        }
        
        // Array
        if (strpos($value, '[') === 0 && strpos($value, ']') === strlen($value) - 1) {
            $items = explode(',', trim($value, '[]'));
            return array_map('trim', $items);
        }
        
        return $value;
    }
    
    /**
     * Initialize Elasticsearch client if enabled
     */
    private function initializeElasticsearch() {
        if (!$this->config['elasticsearch_enabled']) {
            return;
        }
        
        try {
            // Check if Elasticsearch client class exists
            if (class_exists('TuskPHP\\Search\\ElasticsearchClient')) {
                $this->elasticClient = new \TuskPHP\Search\ElasticsearchClient();
                
                // Create index if it doesn't exist
                if (!$this->elasticClient->indexExists($this->config['index_name'])) {
                    $this->createSearchIndex();
                }
            }
        } catch (Exception $e) {
            // Log error but continue - fallback to fuzzy search
            error_log("Heffalump: Failed to initialize Elasticsearch - " . $e->getMessage());
        }
    }
    
    /**
     * Create Elasticsearch index for this Heffalump
     */
    private function createSearchIndex() {
        if (!$this->elasticClient) return;
        
        $mapping = [
            'properties' => []
        ];
        
        // Create mapping based on configuration
        foreach ($this->config['search_fields'] as $field) {
            if ($field === '*') continue;
            
            $fieldConfig = [
                'type' => 'text',
                'analyzer' => 'standard'
            ];
            
            // Apply boost if configured
            if (isset($this->config['boost_fields'][$field])) {
                $fieldConfig['boost'] = $this->config['boost_fields'][$field];
            }
            
            $mapping['properties'][$field] = $fieldConfig;
        }
        
        try {
            $this->elasticClient->createIndex($this->config['index_name'], $mapping);
        } catch (Exception $e) {
            error_log("Heffalump: Failed to create index - " . $e->getMessage());
        }
    }
    
    /**
     * Load search index from various sources
     */
    private function loadSearchIndex() {
        $cacheKey = "heffalump_{$this->instanceId}_index";
        $cached = Memory::recall($cacheKey);
        
        if ($cached !== null) {
            $this->searchIndex = $cached;
            return;
        }
        
        // Load from database if configured
        if (isset($this->config['data_source'])) {
            $this->loadFromDatabase($this->config['data_source']);
        }
        
        // Load from files if configured
        if (isset($this->config['file_source'])) {
            $this->loadFromFiles($this->config['file_source']);
        }
        
        // Cache the index
        Memory::remember($cacheKey, $this->searchIndex, $this->config['cache_ttl']);
    }
    
    /**
     * Load search data from database
     */
    private function loadFromDatabase($source) {
        try {
            $query = $source['query'] ?? "SELECT * FROM {$source['table']}";
            $results = $this->db->query($query)->fetchAll();
            
            foreach ($results as $row) {
                $searchableText = '';
                foreach ($source['fields'] ?? array_keys($row) as $field) {
                    if (isset($row[$field])) {
                        $searchableText .= ' ' . $row[$field];
                    }
                }
                
                $this->searchIndex[] = [
                    'id' => $row['id'] ?? uniqid(),
                    'text' => trim($searchableText),
                    'data' => $row
                ];
            }
        } catch (Exception $e) {
            error_log("Heffalump: Failed to load from database - " . $e->getMessage());
        }
    }
    
    /**
     * Load search data from files
     */
    private function loadFromFiles($source) {
        $directory = $source['directory'] ?? '';
        $extensions = $source['extensions'] ?? ['txt', 'md', 'html'];
        
        if (!is_dir($directory)) return;
        
        $files = glob($directory . '/*.{' . implode(',', $extensions) . '}', GLOB_BRACE);
        
        foreach ($files as $file) {
            $content = file_get_contents($file);
            $this->searchIndex[] = [
                'id' => basename($file),
                'text' => strip_tags($content),
                'data' => [
                    'file' => $file,
                    'size' => filesize($file),
                    'modified' => filemtime($file)
                ]
            ];
        }
    }
    
    /**
     * Calculate phonetic distance between two words
     */
    private function calculatePhoneticDistance($word1, $word2) {
        $metaphone1 = metaphone($word1);
        $metaphone2 = metaphone($word2);
        
        return levenshtein($metaphone1, $metaphone2);
    }
    
    /**
     * Get similarity confidence level
     */
    private function getSimilarityConfidence($similarity) {
        if ($similarity >= 0.9) return 'exact_match';
        if ($similarity >= 0.8) return 'very_similar';
        if ($similarity >= 0.7) return 'similar';
        return 'somewhat_similar';
    }
    
    /**
     * Exact match check
     */
    private function exactMatch($query, $searchIn) {
        $results = [];
        
        foreach ($searchIn as $item) {
            if (strtolower($item) === $query) {
                $results[] = [
                    'match' => $item,
                    'distance' => 0,
                    'score' => 1.0,
                    'method' => 'exact',
                    'confidence' => 'exact_heffalump'
                ];
            }
        }
        
        return empty($results) ? false : $results;
    }
    
    /**
     * Deduplicate search results
     */
    private function deduplicateResults($results) {
        $seen = [];
        $unique = [];
        
        foreach ($results as $result) {
            $key = strtolower($result['match']);
            if (!isset($seen[$key])) {
                $seen[$key] = true;
                $unique[] = $result;
            }
        }
        
        return $unique;
    }
    
    /**
     * Enhanced hunt method with Elasticsearch integration
     */
    public function huntEnhanced($query, $options = []) {
        // Track search for analytics
        $startTime = microtime(true);
        
        // Clean and prepare query
        $query = $this->prepareQuery($query);
        
        // Try Elasticsearch first if available
        if ($this->elasticClient && $this->config['elasticsearch_enabled']) {
            $results = $this->elasticsearchHunt($query, $options);
            if (!empty($results)) {
                $this->trackSearch($query, $results, microtime(true) - $startTime);
                return $results;
            }
        }
        
        // Fallback to fuzzy search
        $searchIn = $options['search_in'] ?? array_column($this->searchIndex, 'text');
        $results = $this->hunt($query, $searchIn);
        
        // Track search
        $this->trackSearch($query, $results, microtime(true) - $startTime);
        
        return $results;
    }
    
    /**
     * Elasticsearch-powered hunt
     */
    private function elasticsearchHunt($query, $options = []) {
        try {
            $searchOptions = [
                'size' => $options['limit'] ?? $this->config['max_results'],
                'from' => $options['offset'] ?? 0,
                'fields' => $options['fields'] ?? $this->config['search_fields']
            ];
            
            $response = $this->elasticClient->search(
                $query,
                [$this->config['index_name']],
                $searchOptions
            );
            
            return $this->formatElasticsearchResults($response);
            
        } catch (Exception $e) {
            error_log("Heffalump: Elasticsearch search failed - " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Format Elasticsearch results to match Heffalump format
     */
    private function formatElasticsearchResults($response) {
        $results = [];
        
        foreach ($response['hits']['hits'] ?? [] as $hit) {
            $results[] = [
                'match' => $hit['_source']['title'] ?? $hit['_source']['name'] ?? 'Unknown',
                'distance' => 0,
                'score' => $hit['_score'],
                'method' => 'elasticsearch',
                'confidence' => $this->getElasticConfidence($hit['_score']),
                'data' => $hit['_source'],
                'highlight' => $hit['highlight'] ?? null
            ];
        }
        
        return $results;
    }
    
    /**
     * Get confidence level from Elasticsearch score
     */
    private function getElasticConfidence($score) {
        if ($score >= 10) return 'perfect_match';
        if ($score >= 5) return 'excellent_match';
        if ($score >= 2) return 'good_match';
        if ($score >= 1) return 'fair_match';
        return 'weak_match';
    }
    
    /**
     * Prepare query for searching
     */
    private function prepareQuery($query) {
        $query = trim(strtolower($query));
        
        // Remove stop words if configured
        if (!empty($this->config['stop_words'])) {
            $words = explode(' ', $query);
            $words = array_diff($words, $this->config['stop_words']);
            $query = implode(' ', $words);
        }
        
        // Apply synonyms if configured
        if (!empty($this->config['synonyms'])) {
            foreach ($this->config['synonyms'] as $word => $synonyms) {
                if (strpos($query, $word) !== false) {
                    $query = str_replace($word, '(' . $word . ' OR ' . implode(' OR ', $synonyms) . ')', $query);
                }
            }
        }
        
        return $query;
    }
    
    /**
     * Track search for analytics
     */
    private function trackSearch($query, $results, $responseTime) {
        if (!$this->config['track_searches']) return;
        
        try {
            // Track with Intelligence service
            $this->intelligence->trackPageView('search', [
                'query' => $query,
                'results_count' => count($results),
                'response_time' => $responseTime,
                'instance_id' => $this->instanceId
            ]);
            
            // Store in analytics
            $this->analytics[] = [
                'query' => $query,
                'results_count' => count($results),
                'response_time' => $responseTime,
                'timestamp' => time(),
                'user_id' => $_SESSION['user_id'] ?? null
            ];
            
            // Store search analytics in database
            $this->db->insert('heffalump_searches', [
                'instance_id' => $this->instanceId,
                'query' => $query,
                'results_count' => count($results),
                'response_time' => $responseTime,
                'user_id' => $_SESSION['user_id'] ?? null,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
        } catch (Exception $e) {
            error_log("Heffalump: Failed to track search - " . $e->getMessage());
        }
    }
    
    /**
     * Index content for searching
     */
    public function index($id, $content, $metadata = []) {
        // Add to local index
        $this->searchIndex[] = [
            'id' => $id,
            'text' => is_array($content) ? implode(' ', $content) : $content,
            'data' => $metadata
        ];
        
        // Index in Elasticsearch if available
        if ($this->elasticClient && $this->config['elasticsearch_enabled']) {
            try {
                $document = array_merge($metadata, [
                    'content' => $content,
                    'indexed_at' => date('Y-m-d H:i:s')
                ]);
                
                $this->elasticClient->index($this->config['index_name'], $id, $document);
            } catch (Exception $e) {
                error_log("Heffalump: Failed to index in Elasticsearch - " . $e->getMessage());
            }
        }
        
        // Clear cache
        Memory::forget("heffalump_{$this->instanceId}_index");
    }
    
    /**
     * Bulk index multiple items
     */
    public function bulkIndex($items) {
        $documents = [];
        
        foreach ($items as $item) {
            $id = $item['id'] ?? uniqid();
            $content = $item['content'] ?? '';
            $metadata = $item['metadata'] ?? [];
            
            // Add to local index
            $this->searchIndex[] = [
                'id' => $id,
                'text' => is_array($content) ? implode(' ', $content) : $content,
                'data' => $metadata
            ];
            
            // Prepare for Elasticsearch
            if ($this->elasticClient && $this->config['elasticsearch_enabled']) {
                $documents[$id] = array_merge($metadata, [
                    'content' => $content,
                    'indexed_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
        
        // Bulk index in Elasticsearch
        if (!empty($documents) && $this->elasticClient) {
            try {
                $this->elasticClient->bulkIndex($this->config['index_name'], $documents);
            } catch (Exception $e) {
                error_log("Heffalump: Bulk index failed - " . $e->getMessage());
            }
        }
        
        // Clear cache
        Memory::forget("heffalump_{$this->instanceId}_index");
    }
    
    /**
     * Get search analytics for this instance
     */
    public function getAnalytics($days = 30) {
        try {
            $since = date('Y-m-d H:i:s', strtotime("-{$days} days"));
            
            $analytics = $this->db->query("
                SELECT 
                    query,
                    COUNT(*) as search_count,
                    AVG(results_count) as avg_results,
                    AVG(response_time) as avg_response_time,
                    MAX(created_at) as last_searched
                FROM heffalump_searches
                WHERE instance_id = ? AND created_at >= ?
                GROUP BY query
                ORDER BY search_count DESC
                LIMIT 50
            ", [$this->instanceId, $since])->fetchAll();
            
            return [
                'top_queries' => $analytics,
                'total_searches' => array_sum(array_column($analytics, 'search_count')),
                'unique_queries' => count($analytics),
                'avg_response_time' => array_sum(array_column($analytics, 'avg_response_time')) / max(1, count($analytics))
            ];
            
        } catch (Exception $e) {
            error_log("Heffalump: Failed to get analytics - " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Create a new Heffalump instance configuration
     */
    public static function createInstance($instanceId, $config) {
        $configDir = __DIR__ . '/../../config/heffalumps';
        if (!is_dir($configDir)) {
            mkdir($configDir, 0755, true);
        }
        
        // Convert config to TuskLang format
        $tuskLang = "# Heffalump Instance: {$instanceId}\n";
        $tuskLang .= "# Generated: " . date('Y-m-d H:i:s') . "\n\n";
        
        foreach ($config as $key => $value) {
            if (is_array($value)) {
                if (isset($value[0])) {
                    // Indexed array
                    $tuskLang .= "{$key} = [" . implode(', ', $value) . "]\n";
                } else {
                    // Associative array - flatten
                    foreach ($value as $subKey => $subValue) {
                        $tuskLang .= "{$key}.{$subKey} = {$subValue}\n";
                    }
                }
            } elseif (is_bool($value)) {
                $tuskLang .= "{$key} = " . ($value ? 'true' : 'false') . "\n";
            } elseif (is_numeric($value)) {
                $tuskLang .= "{$key} = {$value}\n";
            } else {
                $tuskLang .= "{$key} = \"{$value}\"\n";
            }
        }
        
        file_put_contents("{$configDir}/{$instanceId}.tsk", $tuskLang);
        
        return new self($instanceId, $config);
    }
    
    /**
     * Get all Heffalump instances
     */
    public static function getAllInstances() {
        $configDir = __DIR__ . '/../../config/heffalumps';
        $instances = [];
        
        if (is_dir($configDir)) {
            $files = glob($configDir . '/*.tsk');
            foreach ($files as $file) {
                $instanceId = basename($file, '.tsk');
                $instances[] = [
                    'id' => $instanceId,
                    'name' => ucfirst($instanceId) . ' Search',
                    'config_file' => $file
                ];
            }
        }
        
        return $instances;
    }
} 