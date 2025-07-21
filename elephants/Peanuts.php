<?php
namespace TuskPHP\Elephants;
use TuskPHP\{Memory, TuskDb};
use TuskPHP\Utils\TuskLang;
class Peanuts
{
 private static $instance = null;
 private $metrics = [];
 private $performance_mode = 'balanced';
 private $last_optimization = 0;
 private $reward_threshold = 0.8; // Performance score threshold for rewards
 private $diet_threshold = 0.4; // Performance score threshold for diet mode
 private $config = []; // Configuration array for .peanuts data
 // Encrypted environment (.peanuts file) handling
 private static $env_cache = [];
 private static $peanuts_file = null;
 private static $encryption_key = null;
 // Performance modes
 const MODE_FEAST = 'feast'; // High performance, all features enabled
 const MODE_BALANCED = 'balanced'; // Standard operation
 const MODE_DIET = 'diet'; // Conservation mode, reduced features
 const MODE_SURVIVAL = 'survival'; // Emergency mode, minimal features only
 private function __construct()
 {
 $this->initializeMetrics();
 $this->startPerformanceMonitoring();
 }
 public static function getInstance(): self
 {
 if (self::$instance === null) {
 self::$instance = new self();
 }
 return self::$instance;
 }
 private function initializeMetrics(): void
 {
 $this->metrics = [
 'response_times' => [],
 'memory_usage' => [],
 'db_query_times' => [],
 'error_rate' => 0,
 'concurrent_users' => 0,
 'cache_hit_rate' => 0,
 'last_updated' => time(),
 'performance_score' => 1.0
 ];
 }
 private function startPerformanceMonitoring(): void
 {
 // Register shutdown function to capture request metrics
 register_shutdown_function([$this, 'captureRequestMetrics']);
 // Set up periodic optimization checks
 if (!defined('PEANUTS_MONITORING_ACTIVE')) {
 define('PEANUTS_MONITORING_ACTIVE', true);
 $this->scheduleOptimizationCheck();
 }
 }
 public function givePeanuts(string $reason = 'good_performance'): void
 {
 $current_score = $this->calculatePerformanceScore();
 if ($current_score >= $this->reward_threshold) {
 $this->enablePerformanceRewards($reason);
 $this->logPeanutReward($reason, $current_score);
 }
 }
 public function startDiet(string $reason = 'poor_performance'): void
 {
 $current_score = $this->calculatePerformanceScore();
 if ($current_score <= $this->diet_threshold) {
 $this->enableConservationMode($reason);
 $this->logDietMode($reason, $current_score);
 }
 }
 public function calculatePerformanceScore(): float
 {
 $factors = [
 'response_time' => $this->scoreResponseTime(),
 'memory_usage' => $this->scoreMemoryUsage(),
 'error_rate' => $this->scoreErrorRate(),
 'db_performance' => $this->scoreDatabasePerformance(),
 'cache_efficiency' => $this->scoreCacheEfficiency()
 ];
 // Weighted average
 $weights = [
 'response_time' => 0.3,
 'memory_usage' => 0.2,
 'error_rate' => 0.2,
 'db_performance' => 0.2,
 'cache_efficiency' => 0.1
 ];
 $score = 0;
 foreach ($factors as $factor => $value) {
 $score += $value * $weights[$factor];
 }
 $this->metrics['performance_score'] = $score;
 return $score;
 }
 public function adaptiveOptimize(): void
 {
 $score = $this->calculatePerformanceScore();
 $current_mode = $this->performance_mode;
 // Determine optimal mode based on performance score
 if ($score >= 0.9) {
 $new_mode = self::MODE_FEAST;
 } elseif ($score >= 0.7) {
 $new_mode = self::MODE_BALANCED;
 } elseif ($score >= 0.4) {
 $new_mode = self::MODE_DIET;
 } else {
 $new_mode = self::MODE_SURVIVAL;
 }
 // Only change mode if necessary
 if ($new_mode !== $current_mode) {
 $this->switchPerformanceMode($new_mode, $score);
 }
 // Apply mode-specific optimizations
 $this->applyModeOptimizations($new_mode);
 }
 private function switchPerformanceMode(string $mode, float $score): void
 {
 $old_mode = $this->performance_mode;
 $this->performance_mode = $mode;
 switch ($mode) {
 case self::MODE_FEAST:
 $this->enableFeastMode();
 break;
 case self::MODE_BALANCED:
 $this->enableBalancedMode();
 break;
 case self::MODE_DIET:
 $this->enableDietMode();
 break;
 case self::MODE_SURVIVAL:
 $this->enableSurvivalMode();
 break;
 }
 $this->logModeSwitch($old_mode, $mode, $score);
 }
 private function enableFeastMode(): void
 {
 // Enable aggressive caching
 if (class_exists('TuskPHP\\Memory')) {
 Memory::setDefaultTTL(7200); // 2 hours
 Memory::enableAggressiveCaching(true);
 }
 // Enable parallel processing where possible
 ini_set('max_execution_time', 300);
 // Optimize database connections
 if (class_exists('TuskPHP\\TuskDb')) {
 TuskDb::enableConnectionPooling(true);
 TuskDb::setQueryCache(true);
 }
 // Enable all elephant services
 $this->enableAllElephantServices();
 }
 private function enableDietMode(): void
 {
 // Reduce cache TTL
 if (class_exists('TuskPHP\\Memory')) {
 Memory::setDefaultTTL(300); // 5 minutes
 Memory::enableAggressiveCaching(false);
 }
 // Limit execution time
 ini_set('max_execution_time', 30);
 // Optimize database for conservation
 if (class_exists('TuskPHP\\TuskDb')) {
 TuskDb::enableConnectionPooling(false);
 TuskDb::limitConcurrentQueries(5);
 }
 // Disable non-essential elephant services
 $this->disableNonEssentialServices();
 }
 private function enableSurvivalMode(): void
 {
 // Minimal caching
 if (class_exists('TuskPHP\\Memory')) {
 Memory::setDefaultTTL(60); // 1 minute
 Memory::enableAggressiveCaching(false);
 }
 // Strict execution limits
 ini_set('max_execution_time', 15);
 ini_set('memory_limit', '32M');
 // Emergency database settings
 if (class_exists('TuskPHP\\TuskDb')) {
 TuskDb::enableEmergencyMode(true);
 TuskDb::limitConcurrentQueries(2);
 }
 // Only essential services
 $this->enableOnlyEssentialServices();
 }
 public function captureRequestMetrics(): void
 {
 $end_time = microtime(true);
 $start_time = $_SERVER['REQUEST_TIME_FLOAT'] ?? $end_time;
 $response_time = $end_time - $start_time;
 // Store metrics
 $this->metrics['response_times'][] = $response_time;
 $this->metrics['memory_usage'][] = memory_get_peak_usage(true);
 $this->metrics['last_updated'] = time();
 // Keep only last 100 entries
 if (count($this->metrics['response_times']) > 100) {
 $this->metrics['response_times'] = array_slice($this->metrics['response_times'], -100);
 $this->metrics['memory_usage'] = array_slice($this->metrics['memory_usage'], -100);
 }
 // Trigger adaptive optimization every 10 requests
 if (count($this->metrics['response_times']) % 10 === 0) {
 $this->adaptiveOptimize();
 }
 }
 public function getPerformanceStatus(): array
 {
 return [
 'mode' => $this->performance_mode,
 'score' => $this->calculatePerformanceScore(),
 'metrics' => $this->metrics,
 'avg_response_time' => $this->getAverageResponseTime(),
 'avg_memory_usage' => $this->getAverageMemoryUsage(),
 'recommendations' => $this->getOptimizationRecommendations()
 ];
 }
 // ========================================
 // ENCRYPTED .PEANUTS ENVIRONMENT HANDLING
 // ========================================
 public static function loadPeanutsEnv(string $file_path = null): bool
 {
 if (!$file_path) {
 $possible_paths = [
 __DIR__ . '/../../config/tusk/.peanuts', // New organized location
 __DIR__ . '/../../.peanuts', // Legacy root location
 __DIR__ . '/../../../.peanuts',
 __DIR__ . '/../../../../.peanuts',
 getcwd() . '/.peanuts'
 ];
 foreach ($possible_paths as $path) {
 if (file_exists($path)) {
 $file_path = $path;
 break;
 }
 }
 }
 if (!$file_path || !file_exists($file_path)) {
 return false;
 }
 self::$peanuts_file = $file_path;
 try {
 $encrypted_content = file_get_contents($file_path);
 $decrypted_content = self::decryptPeanuts($encrypted_content);
 if ($decrypted_content) {
 self::parsePeanutsEnv($decrypted_content);
 return true;
 }
 } catch (Exception $e) {
 if (defined('DEBUG_MODE') && DEBUG_MODE) {
 error_log("🥜 Failed to load .peanuts file: " . $e->getMessage());
 }
 }
 return false;
 }
 public static function savePeanutsEnv(array $env_vars, string $file_path = null): bool
 {
 if (!$file_path) {
 $file_path = self::$peanuts_file ?: (getcwd() . '/.peanuts');
 }
 try {
 $content = self::generatePeanutsContent($env_vars);
 $encrypted_content = self::encryptPeanuts($content);
 if (file_put_contents($file_path, $encrypted_content, LOCK_EX)) {
 self::$peanuts_file = $file_path;
 self::$env_cache = array_merge(self::$env_cache, $env_vars);
 return true;
 }
 } catch (Exception $e) {
 if (defined('DEBUG_MODE') && DEBUG_MODE) {
 error_log("🥜 Failed to save .peanuts file: " . $e->getMessage());
 }
 }
 return false;
 }
 public static function getPeanutsEnv(string $key, $default = null)
 {
 // First try cache
 if (isset(self::$env_cache[$key])) {
 return self::$env_cache[$key];
 }
 // Try to load if not already loaded
 if (empty(self::$env_cache) && self::loadPeanutsEnv()) {
 return self::$env_cache[$key] ?? $default;
 }
 return $default;
 }
 public static function setPeanutsEnv(string $key, $value): bool
 {
 self::$env_cache[$key] = $value;
 // If we have a file loaded, update it
 if (self::$peanuts_file) {
 return self::savePeanutsEnv(self::$env_cache);
 }
 return true; // Cached for now
 }
 private static function encryptPeanuts(string $content): string
 {
 $key = self::getPeanutsEncryptionKey();
 $cipher = 'aes-256-ctr';
 $ivlen = openssl_cipher_iv_length($cipher);
 $iv = openssl_random_pseudo_bytes($ivlen);
 $encrypted = openssl_encrypt($content, $cipher, $key, OPENSSL_RAW_DATA, $iv);
 // Prepend IV to encrypted data and base64 encode
 return base64_encode($iv . $encrypted);
 }
 private static function decryptPeanuts(string $encrypted_content): ?string
 {
 $key = self::getPeanutsEncryptionKey();
 $cipher = 'aes-256-ctr';
 $ivlen = openssl_cipher_iv_length($cipher);
 $data = base64_decode($encrypted_content);
 if (!$data || strlen($data) < $ivlen) {
 return null;
 }
 $iv = substr($data, 0, $ivlen);
 $encrypted = substr($data, $ivlen);
 return openssl_decrypt($encrypted, $cipher, $key, OPENSSL_RAW_DATA, $iv);
 }
 private static function getPeanutsEncryptionKey(): string
 {
 if (self::$encryption_key) {
 return self::$encryption_key;
 }
 // Try various sources for the key
 $key_sources = [
 $_SERVER['PEANUTS_KEY'] ?? null,
 getenv('PEANUTS_KEY'),
 hash('sha256', php_uname() . __FILE__ . 'PeanutsAreDelicious', true)
 ];
 foreach ($key_sources as $source) {
 if ($source) {
 self::$encryption_key = is_string($source) ? hash('sha256', $source, true) : $source;
 return self::$encryption_key;
 }
 }
 // Fallback key (not ideal for production)
 self::$encryption_key = hash('sha256', 'ElephantsPeanutsSecret' . __DIR__, true);
 return self::$encryption_key;
 }
 private static function parsePeanutsEnv(string $content): void
 {
 $lines = explode("\n", $content);
 foreach ($lines as $line) {
 $line = trim($line);
 // Skip empty lines and comments
 if (empty($line) || strpos($line, '#') === 0) {
 continue;
 }
 // Parse KEY=VALUE format
 if (strpos($line, '=') !== false) {
 [$key, $value] = explode('=', $line, 2);
 $key = trim($key);
 $value = trim($value);
 // Remove quotes if present
 if (strlen($value) >= 2 && 
 (($value[0] === '"' && $value[-1] === '"') || 
 ($value[0] === "'" && $value[-1] === "'"))) {
 $value = substr($value, 1, -1);
 }
 self::$env_cache[$key] = $value;
 // Also set as PHP constant if not already defined
 if (!defined($key)) {
 define($key, $value);
 }
 }
 }
 }
 private static function generatePeanutsContent(array $env_vars): string
 {
 $content = "# 🥜 TuskPHP Encrypted Environment Configuration\n";
 $content .= "# Even elephants have trouble finding encrypted peanuts!\n";
 $content .= "# Generated: " . date('Y-m-d H:i:s') . "\n\n";
 foreach ($env_vars as $key => $value) {
 // Escape values that contain special characters
 if (strpos($value, ' ') !== false || strpos($value, '"') !== false) {
 $value = '"' . addslashes($value) . '"';
 }
 $content .= "$key=$value\n";
 }
 return $content;
 }
 private function scoreResponseTime(): float
 {
 if (empty($this->metrics['response_times'])) return 1.0;
 $avg_time = array_sum($this->metrics['response_times']) / count($this->metrics['response_times']);
 // Score based on response time (lower is better)
 if ($avg_time <= 0.1) return 1.0; // Excellent
 if ($avg_time <= 0.5) return 0.8; // Good
 if ($avg_time <= 1.0) return 0.6; // Acceptable
 if ($avg_time <= 2.0) return 0.4; // Poor
 return 0.2; // Very poor
 }
 private function scoreMemoryUsage(): float
 {
 if (empty($this->metrics['memory_usage'])) return 1.0;
 $avg_memory = array_sum($this->metrics['memory_usage']) / count($this->metrics['memory_usage']);
 $memory_limit = $this->parseMemoryLimit();
 if ($memory_limit > 0) {
 $usage_ratio = $avg_memory / $memory_limit;
 return max(0, 1 - $usage_ratio);
 }
 return 0.8; // Default if can't determine limit
 }
 private function logPeanutReward(string $reason, float $score): void
 {
 if (defined('DEBUG_MODE') && DEBUG_MODE) {
 error_log("🥜 Peanuts reward given! Reason: {$reason}, Score: " . round($score, 3));
 }
 }
 private function logDietMode(string $reason, float $score): void
 {
 if (defined('DEBUG_MODE') && DEBUG_MODE) {
 error_log("🥗 Diet mode activated. Reason: {$reason}, Score: " . round($score, 3));
 }
 }
 private function logModeSwitch(string $old_mode, string $new_mode, float $score): void
 {
 if (defined('DEBUG_MODE') && DEBUG_MODE) {
 error_log("🐘 Performance mode switch: {$old_mode} → {$new_mode} (Score: " . round($score, 3) . ")");
 }
 }
 // Helper methods
 private function parseMemoryLimit(): int
 {
 $limit = ini_get('memory_limit');
 if ($limit === '-1') return 0;
 $value = (int) $limit;
 $unit = strtoupper(substr($limit, -1));
 switch ($unit) {
 case 'G': return $value * 1024 * 1024 * 1024;
 case 'M': return $value * 1024 * 1024;
 case 'K': return $value * 1024;
 default: return $value;
 }
 }
 private function getAverageResponseTime(): float
 {
 if (empty($this->metrics['response_times'])) return 0;
 return array_sum($this->metrics['response_times']) / count($this->metrics['response_times']);
 }
 private function getAverageMemoryUsage(): int
 {
 if (empty($this->metrics['memory_usage'])) return 0;
 return (int) (array_sum($this->metrics['memory_usage']) / count($this->metrics['memory_usage']));
 }
 private function getOptimizationRecommendations(): array
 {
 $recommendations = [];
 $score = $this->calculatePerformanceScore();
 if ($score < 0.6) {
 $recommendations[] = "Consider enabling caching for database queries";
 $recommendations[] = "Review slow database queries and add indexes";
 $recommendations[] = "Optimize image sizes and enable compression";
 }
 if ($this->getAverageResponseTime() > 1.0) {
 $recommendations[] = "Response times are high - consider code optimization";
 }
 return $recommendations;
 }
 private function enableAllElephantServices(): void
 {
 $elephantServices = [
 'Satao' => ['security_monitoring' => true, 'threat_detection' => true],
 'Horton' => ['job_processing' => true, 'async_jobs' => true],
 'Jumbo' => ['large_uploads' => true, 'chunked_processing' => true],
 'Tantor' => ['websocket' => true, 'realtime_updates' => true],
 'Heffalump' => ['search_indexing' => true, 'fuzzy_search' => true],
 'Koshik' => ['audio_processing' => true, 'speech_synthesis' => true],
 'Happy' => ['image_processing' => true, 'filters' => true],
 'Tai' => ['video_embedding' => true, 'streaming' => true],
 'Elmer' => ['theme_generation' => true, 'dynamic_styling' => true],
 'Babar' => ['cms_features' => true, 'content_management' => true],
 'Dumbo' => ['http_client' => true, 'parallel_requests' => true],
 'Stampy' => ['app_installation' => true, 'package_management' => true],
 'Kaavan' => ['monitoring' => true, 'analytics' => true, 'backups' => true]
 ];
 foreach ($elephantServices as $elephant => $features) {
 foreach ($features as $feature => $enabled) {
 Memory::remember("elephant_{$elephant}_{$feature}", $enabled, 7200);
 }
 }
 // Enable all background services
 Memory::forget('horton_paused');
 Memory::remember('all_elephants_active', true, 7200);
 if (defined('DEBUG_MODE') && DEBUG_MODE) {
 error_log("🐘 All elephant services enabled for FEAST mode");
 }
 }
 private function disableNonEssentialServices(): void
 {
 // Essential services that remain active
 $essentialServices = [
 'Satao' => ['security_monitoring' => true], // Security is always essential
 'Memory' => ['basic_caching' => true], // Basic caching needed
 'TuskDb' => ['database_access' => true], // Database always needed
 'Herd' => ['authentication' => true] // Auth always needed
 ];
 // Non-essential services to disable
 $nonEssentialServices = [
 'Horton' => ['async_jobs' => false], // Pause background jobs
 'Jumbo' => ['large_uploads' => false], // Disable large uploads
 'Tantor' => ['websocket' => false], // Disable real-time features
 'Heffalump' => ['search_indexing' => false], // Pause search indexing
 'Koshik' => ['audio_processing' => false], // No audio processing
 'Happy' => ['image_processing' => false], // No image filters
 'Tai' => ['video_embedding' => false], // No video features
 'Elmer' => ['theme_generation' => false], // No dynamic themes
 'Stampy' => ['app_installation' => false], // No new installations
 'Kaavan' => ['backups' => false] // Pause backups
 ];
 // Apply essential services
 foreach ($essentialServices as $elephant => $features) {
 foreach ($features as $feature => $enabled) {
 Memory::remember("elephant_{$elephant}_{$feature}", $enabled, 1800);
 }
 }
 // Disable non-essential services
 foreach ($nonEssentialServices as $elephant => $features) {
 foreach ($features as $feature => $enabled) {
 Memory::remember("elephant_{$elephant}_{$feature}", $enabled, 1800);
 }
 }
 // Pause Horton's job processing
 Memory::remember('horton_paused', true, 1800);
 if (defined('DEBUG_MODE') && DEBUG_MODE) {
 error_log("🥗 Non-essential elephant services disabled for DIET mode");
 }
 }
 private function enableOnlyEssentialServices(): void
 {
 // Only the most critical services
 $criticalServices = [
 'Satao' => ['basic_security' => true], // Minimal security
 'Memory' => ['emergency_cache' => true], // Emergency caching only
 'TuskDb' => ['read_only' => true], // Database read-only mode
 'Herd' => ['basic_auth' => true] // Basic auth only
 ];
 // Disable ALL non-critical elephants
 $allElephants = [
 'Horton', 'Jumbo', 'Tantor', 'Heffalump', 'Koshik', 
 'Happy', 'Tai', 'Elmer', 'Babar', 'Dumbo', 'Stampy', 'Kaavan'
 ];
 foreach ($allElephants as $elephant) {
 Memory::remember("elephant_{$elephant}_disabled", true, 300);
 }
 // Apply critical services only
 foreach ($criticalServices as $elephant => $features) {
 foreach ($features as $feature => $enabled) {
 Memory::remember("elephant_{$elephant}_{$feature}", $enabled, 300);
 }
 }
 // Emergency flags
 Memory::remember('emergency_mode_active', true, 300);
 Memory::remember('read_only_mode', true, 300);
 if (defined('DEBUG_MODE') && DEBUG_MODE) {
 error_log("🚨 SURVIVAL MODE: Only critical elephant services active");
 }
 }
 private function scheduleOptimizationCheck(): void
 {
 // Check if we're already scheduled
 $lastCheck = Memory::recall('peanuts_last_optimization_check') ?? 0;
 $checkInterval = 300; // 5 minutes
 if (time() - $lastCheck < $checkInterval) {
 return; // Already checked recently
 }
 // Schedule next check
 Memory::remember('peanuts_last_optimization_check', time(), $checkInterval);
 // If we have Horton (job queue), schedule optimization job
 if (class_exists('TuskPHP\\Elephants\\Horton') && !Memory::recall('horton_paused')) {
 // Create optimization job
 $optimizationJob = [
 'type' => 'peanuts_optimization',
 'handler' => 'TuskPHP\\Elephants\\Peanuts::performScheduledOptimization',
 'priority' => 'low',
 'scheduled_at' => time() + $checkInterval,
 'data' => [
 'current_mode' => $this->performance_mode,
 'current_score' => $this->calculatePerformanceScore()
 ]
 ];
 // Queue the job
 Memory::remember('peanuts_optimization_job', $optimizationJob, $checkInterval);
 } else {
 // Fallback: Use cron-like checking in shutdown function
 register_shutdown_function(function() use ($checkInterval) {
 // Store a flag for next request to check optimization
 Memory::remember('peanuts_check_optimization_next_request', true, $checkInterval);
 });
 }
 if (defined('DEBUG_MODE') && DEBUG_MODE) {
 error_log("🥜 Optimization check scheduled for " . date('Y-m-d H:i:s', time() + $checkInterval));
 }
 }
 public static function performScheduledOptimization(array $data = []): void
 {
 $instance = self::getInstance();
 // Check if optimization is needed
 if (Memory::recall('peanuts_check_optimization_next_request')) {
 Memory::forget('peanuts_check_optimization_next_request');
 $instance->adaptiveOptimize();
 // Schedule next check
 $instance->scheduleOptimizationCheck();
 }
 }
 private function scoreErrorRate(): float 
 {
 // Track errors over the last 100 requests
 $errorCount = Memory::recall('peanuts_error_count') ?? 0;
 $totalRequests = count($this->metrics['response_times']);
 if ($totalRequests === 0) {
 return 1.0; // No requests yet, assume perfect
 }
 // Calculate error rate
 $errorRate = $errorCount / $totalRequests;
 // Convert to score (inverse relationship)
 if ($errorRate <= 0.01) return 1.0; // Less than 1% errors = perfect
 if ($errorRate <= 0.05) return 0.8; // Less than 5% = good
 if ($errorRate <= 0.10) return 0.6; // Less than 10% = acceptable
 if ($errorRate <= 0.20) return 0.4; // Less than 20% = poor
 return 0.2; // More than 20% = critical
 }
 private function scoreDatabasePerformance(): float 
 {
 if (empty($this->metrics['db_query_times'])) {
 // No database queries tracked yet
 return 0.8; // Assume good performance
 }
 $avgQueryTime = array_sum($this->metrics['db_query_times']) / count($this->metrics['db_query_times']);
 // Score based on average query time (in milliseconds)
 if ($avgQueryTime <= 10) return 1.0; // Excellent (< 10ms)
 if ($avgQueryTime <= 50) return 0.8; // Good (< 50ms)
 if ($avgQueryTime <= 100) return 0.6; // Acceptable (< 100ms)
 if ($avgQueryTime <= 500) return 0.4; // Poor (< 500ms)
 return 0.2; // Very poor (> 500ms)
 }
 private function scoreCacheEfficiency(): float 
 {
 // Get cache statistics from Memory
 $cacheHits = Memory::recall('peanuts_cache_hits') ?? 0;
 $cacheMisses = Memory::recall('peanuts_cache_misses') ?? 0;
 $totalAttempts = $cacheHits + $cacheMisses;
 if ($totalAttempts === 0) {
 return 0.8; // No cache usage yet, assume good
 }
 $hitRate = $cacheHits / $totalAttempts;
 $this->metrics['cache_hit_rate'] = $hitRate;
 // Score based on cache hit rate
 if ($hitRate >= 0.90) return 1.0; // 90%+ hit rate = excellent
 if ($hitRate >= 0.75) return 0.8; // 75%+ = good
 if ($hitRate >= 0.60) return 0.6; // 60%+ = acceptable
 if ($hitRate >= 0.40) return 0.4; // 40%+ = poor
 return 0.2; // Less than 40% = needs improvement
 }

 /**
  * Determine if caching should be used based on route and performance mode
  */
 public static function shouldUseCache(array $route): bool
 {
 $instance = self::getInstance();
 
 // Never cache in survival mode
 if ($instance->performance_mode === self::MODE_SURVIVAL) {
 return false;
 }
 
 // Check if route contains admin or dynamic elements
 $h1 = $route['h1'] ?? '';
 $h2 = $route['h2'] ?? '';
 
 // Don't cache admin pages, API endpoints, or dynamic content
 if (in_array($h1, ['admin', 'api', 'cron', 'logout'])) {
 return false;
 }
 
 // Don't cache pages with query parameters (likely dynamic)
 if (!empty($_GET) && count($_GET) > 0) {
 return false;
 }
 
 // Don't cache POST requests
 if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
 return false;
 }
 
 return true;
 }

 /**
  * Get cache TTL based on current performance mode and content type
  */
 public static function getCacheTTL(string $h1 = ''): int
 {
 $instance = self::getInstance();
 
 // Base TTL by performance mode
 switch ($instance->performance_mode) {
 case self::MODE_FEAST:
 $baseTTL = 7200; // 2 hours
 break;
 case self::MODE_BALANCED:
 $baseTTL = 1800; // 30 minutes
 break;
 case self::MODE_DIET:
 $baseTTL = 300; // 5 minutes
 break;
 case self::MODE_SURVIVAL:
 $baseTTL = 60; // 1 minute
 break;
 default:
 $baseTTL = 1800; // 30 minutes default
 }
 
 // Adjust TTL based on content type
 switch ($h1) {
 case 'home':
 case '':
 return $baseTTL; // Full TTL for home page
 case 'about':
 case 'contact':
 return $baseTTL * 2; // Static pages cache longer
 case 'dashboard':
 case 'profile':
 return min($baseTTL / 2, 300); // Dynamic user pages cache shorter
 default:
 return $baseTTL;
 }
 }

 /**
  * Cleanup method for end-of-request optimizations
  */
 public static function cleanup(): void
 {
 $instance = self::getInstance();
 
 // Capture final metrics
 $instance->captureRequestMetrics();
 
 // Perform any end-of-request optimizations
 if ($instance->performance_mode === self::MODE_FEAST) {
 // In feast mode, we can do more expensive cleanup
 $instance->performScheduledOptimization();
 }
 
 // Clear temporary data
 if (class_exists('TuskPHP\\Memory')) {
 Memory::forget('peanuts_temp_data');
 }
 
 // Log performance summary if debug mode is enabled
 if (defined('DEBUG_MODE') && DEBUG_MODE) {
 $score = $instance->calculatePerformanceScore();
 error_log("🥜 Request completed - Performance score: " . round($score, 3) . " Mode: " . $instance->performance_mode);
 }
 }

 private function enablePerformanceRewards(string $reason): void 
 {
 // Log the reward
 if (defined('DEBUG_MODE') && DEBUG_MODE) {
 error_log("🥜 Performance reward enabled: {$reason}");
 }
 // Increase resource limits as rewards
 ini_set('memory_limit', '512M');
 ini_set('max_execution_time', '300');
 // Enable advanced features
 if (class_exists('TuskPHP\\Memory')) {
 Memory::enableAggressiveCaching(true);
 Memory::setDefaultTTL(7200); // 2 hour cache
 }
 // Enable parallel processing features
 if (class_exists('TuskPHP\\TuskDb')) {
 TuskDb::enableConnectionPooling(true);
 TuskDb::setQueryCache(true);
 TuskDb::setMaxConnections(20);
 }
 // Store reward state
 Memory::remember('peanuts_rewards_active', [
 'reason' => $reason,
 'enabled_at' => time(),
 'features' => ['aggressive_caching', 'connection_pooling', 'extended_execution']
 ], 3600);
 }
 private function enableConservationMode(string $reason): void 
 {
 // Log conservation mode
 if (defined('DEBUG_MODE') && DEBUG_MODE) {
 error_log("🥗 Conservation mode enabled: {$reason}");
 }
 // Reduce resource limits
 ini_set('memory_limit', '128M');
 ini_set('max_execution_time', '30');
 // Disable non-essential features
 if (class_exists('TuskPHP\\Memory')) {
 Memory::enableAggressiveCaching(false);
 Memory::setDefaultTTL(300); // 5 minute cache only
 }
 // Limit database connections
 if (class_exists('TuskPHP\\TuskDb')) {
 TuskDb::enableConnectionPooling(false);
 TuskDb::setQueryCache(false);
 TuskDb::setMaxConnections(5);
 }
 // Disable background jobs
 if (class_exists('TuskPHP\\Elephants\\Horton')) {
 Memory::remember('horton_paused', true, 1800);
 }
 // Store conservation state
 Memory::remember('peanuts_conservation_active', [
 'reason' => $reason,
 'enabled_at' => time(),
 'restrictions' => ['limited_memory', 'no_pooling', 'jobs_paused']
 ], 1800);
 }
 private function enableBalancedMode(): void 
 {
 // Reset to balanced defaults
 ini_set('memory_limit', '256M');
 ini_set('max_execution_time', '60');
 // Standard caching
 if (class_exists('TuskPHP\\Memory')) {
 Memory::enableAggressiveCaching(false);
 Memory::setDefaultTTL(1800); // 30 minute cache
 }
 // Standard database settings
 if (class_exists('TuskPHP\\TuskDb')) {
 TuskDb::enableConnectionPooling(true);
 TuskDb::setQueryCache(true);
 TuskDb::setMaxConnections(10);
 }
 // Resume background jobs if paused
 Memory::forget('horton_paused');
 if (defined('DEBUG_MODE') && DEBUG_MODE) {
 error_log("⚖️ Balanced mode activated");
 }
 }
 private function applyModeOptimizations(string $mode): void 
 {
 switch ($mode) {
 case self::MODE_FEAST:
 // Enable all optimizations
 $this->enableAsyncProcessing();
 $this->enableOutputCompression();
 $this->optimizeAutoloading();
 $this->preloadFrequentlyUsedClasses();
 break;
 case self::MODE_BALANCED:
 // Standard optimizations
 $this->enableOutputCompression();
 $this->optimizeAutoloading();
 break;
 case self::MODE_DIET:
 // Minimal optimizations
 $this->disableNonEssentialAutoloading();
 $this->limitOutputBuffering();
 break;
 case self::MODE_SURVIVAL:
 // Emergency optimizations only
 $this->disableAllNonCritical();
 $this->enableEmergencyMode();
 break;
 }
 // Apply mode-specific PHP optimizations
 $this->applyPHPOptimizations($mode);
 }
 private function enableAsyncProcessing(): void 
 {
 // Enable async features if available
 if (extension_loaded('pcntl')) {
 Memory::remember('peanuts_async_enabled', true);
 }
 }
 private function enableOutputCompression(): void 
 {
 if (!headers_sent() && extension_loaded('zlib')) {
 ob_start('ob_gzhandler');
 }
 }
 private function optimizeAutoloading(): void 
 {
 // Optimize composer autoloader if available
 if (file_exists(__DIR__ . '/../../vendor/autoload.php')) {
 // Enable optimized autoloader
 Memory::remember('peanuts_autoload_optimized', true);
 }
 }
 private function preloadFrequentlyUsedClasses(): void 
 {
 // Preload commonly used classes
 $commonClasses = [
 'TuskPHP\\Memory',
 'TuskPHP\\TuskDb',
 'TuskPHP\\TuskQuery',
 'TuskPHP\\Elephants\\Satao'
 ];
 foreach ($commonClasses as $class) {
 if (!class_exists($class)) {
 // Trigger autoloading
 class_exists($class);
 }
 }
 }
 private function disableNonEssentialAutoloading(): void 
 {
 // Reduce autoloading overhead
 Memory::remember('peanuts_minimal_autoload', true);
 }
 private function limitOutputBuffering(): void 
 {
 // Limit output buffer size to conserve memory
 if (ob_get_level() > 0) {
 ob_end_flush();
 }
 }
 private function disableAllNonCritical(): void 
 {
 // Disable all non-critical features
 Memory::remember('peanuts_critical_only', true);
 }
 private function enableEmergencyMode(): void 
 {
 // Set emergency flags
 Memory::remember('peanuts_emergency', true, 300);
 // Notify administrators
 error_log("🚨 PEANUTS EMERGENCY MODE ACTIVATED");
 }
 private function applyPHPOptimizations(string $mode): void 
 {
 $optimizations = [
 self::MODE_FEAST => [
 'opcache.enable' => '1',
 'opcache.memory_consumption' => '256',
 'opcache.max_accelerated_files' => '10000',
 'realpath_cache_size' => '4M',
 'realpath_cache_ttl' => '600'
 ],
 self::MODE_BALANCED => [
 'opcache.enable' => '1',
 'opcache.memory_consumption' => '128',
 'opcache.max_accelerated_files' => '4000',
 'realpath_cache_size' => '2M',
 'realpath_cache_ttl' => '300'
 ],
 self::MODE_DIET => [
 'opcache.memory_consumption' => '64',
 'opcache.max_accelerated_files' => '2000',
 'realpath_cache_size' => '1M',
 'realpath_cache_ttl' => '120'
 ],
 self::MODE_SURVIVAL => [
 'opcache.memory_consumption' => '32',
 'opcache.max_accelerated_files' => '1000',
 'realpath_cache_size' => '512K',
 'realpath_cache_ttl' => '60'
 ]
 ];
 if (isset($optimizations[$mode])) {
 foreach ($optimizations[$mode] as $key => $value) {
 ini_set($key, $value);
 }
 }
 }
     public static function eat(string $configFile = null): bool
    {
        $instance = self::getInstance();
        
        // PRIORITY ORDER: .pnt → peanu.tsk → .peanuts (legacy) → .shell (legacy)
        if (!$configFile) {
            // Step 1: Check for .pnt first (preferred binary format)
            if (file_exists('.pnt')) {
                $configFile = '.pnt';
            }
            // Step 2: If no .pnt, check for peanu.tsk (source file)
            elseif (file_exists('peanu.tsk')) {
                $configFile = 'peanu.tsk';
            }
            // Step 3: Legacy fallback to .peanuts 
            elseif (file_exists('.peanuts')) {
                $configFile = '.peanuts';
            }
            // Step 4: Legacy fallback to .shell
            elseif (file_exists('.shell')) {
                $configFile = '.shell';
            }
            else {
                // No config file found - this should trigger tusk init
                error_log("🥜 No configuration file found (.pnt, peanu.tsk, .peanuts, .shell) - run 'tusk init'");
                return false;
            }
        }
        
        // Try binary files first (.pnt or .peanuts)
        if (file_exists($configFile) && self::isBinaryFile($configFile)) {
            return $instance->crackBinary($configFile);
        }
        
        // Try source file (peanu.tsk)
        if (file_exists($configFile) && (pathinfo($configFile, PATHINFO_EXTENSION) === 'tsk' || strpos($configFile, 'peanu.tsk') !== false)) {
            return $instance->loadSource($configFile);
        }
        
        // Legacy fallback to .shell
        if (file_exists($configFile) && pathinfo($configFile, PATHINFO_EXTENSION) === 'shell') {
            return $instance->crackShell($configFile);
        }
        
        // If specified file doesn't exist, try fallback sequence
        if (!file_exists($configFile)) {
            // Fall back to source file (peanu.tsk)
            if (file_exists('peanu.tsk')) {
                return $instance->loadSource('peanu.tsk');
            }
            
            // Legacy fallback to .shell
            $shellFile = str_replace(['.pnt', '.peanuts'], '.shell', $configFile);
            if (file_exists($shellFile)) {
                return $instance->crackShell($shellFile);
            }
        }
        
        return false;
    }
     private function crackBinary(string $binaryFile): bool
    {
        try {
            // Load binary file (.pnt or .peanuts)
            $data = file_get_contents($binaryFile);
            $config = unpack('a4magic/Cversion/Vlength', $data);
            if ($config['magic'] !== 'PNUT') {
                error_log("Invalid binary magic header in $binaryFile");
                return false;
            }
            // Extract configuration data from binary file
            $configData = substr($data, 9, $config['length']);
            $decompressed = gzuncompress($configData);
            if ($decompressed === false) {
                error_log("Failed to extract data from binary file $binaryFile");
                return false;
            }
            // Try TuskLang decode first, fallback to JSON decode
            if (class_exists('TuskPHP\\Utils\\TuskLang') && method_exists('TuskPHP\\Utils\\TuskLang', 'decode')) {
                $this->config = TuskLang::decode($decompressed, true);
            } else {
                // Fallback to JSON decode
                $this->config = json_decode($decompressed, true);
                if ($this->config === null) {
                    error_log("Failed to decode binary configuration data from $binaryFile");
                    return false;
                }
            }
            $this->applyConfiguration();
            return true;
        } catch (Exception $e) {
            error_log("Error cracking binary file $binaryFile: " . $e->getMessage());
            return false;
        }
    }

    private function crackShell(string $shellFile): bool
    {
        try {
            // LEGACY: Memory-map the shell file for zero-copy access 
            $data = file_get_contents($shellFile);
            $config = unpack('a4magic/Cversion/Vlength', $data);
            if ($config['magic'] !== 'SHEL') {
                error_log("Invalid .shell magic header");
                return false;
            }
            // Extract configuration data from cracked shell
            $configData = substr($data, 9, $config['length']);
            $decompressed = gzuncompress($configData);
            if ($decompressed === false) {
                error_log("Failed to extract peanuts from .shell");
                return false;
            }
            // Try TuskLang decode first, fallback to JSON decode
            if (class_exists('TuskPHP\\Utils\\TuskLang') && method_exists('TuskPHP\\Utils\\TuskLang', 'decode')) {
                $this->config = TuskLang::decode($decompressed, true);
            } else {
                // Fallback to JSON decode (shell files are likely JSON)
                $this->config = json_decode($decompressed, true);
                if ($this->config === null) {
                    error_log("Failed to decode shell configuration data");
                    return false;
                }
            }
            $this->applyConfiguration();
            return true;
        } catch (Exception $e) {
            error_log("Error cracking .shell: " . $e->getMessage());
            return false;
        }
    }
     private function loadSource(string $sourceFile): bool
    {
        try {
            $content = file_get_contents($sourceFile);
            
            // NEW: Use PHP INI parser for .peanu.tsk files (they're in INI format)
            if (pathinfo($sourceFile, PATHINFO_EXTENSION) === 'tsk' || strpos($sourceFile, 'peanu.tsk') !== false) {
                // Try PHP's built-in INI parser first (since .peanu.tsk files are INI format)
                // Use INI_SCANNER_TYPED if available, fallback to INI_SCANNER_NORMAL for older PHP versions
                $scanner_type = defined('INI_SCANNER_TYPED') ? INI_SCANNER_TYPED : INI_SCANNER_NORMAL;
                $iniConfig = parse_ini_string($content, true, $scanner_type);
                if ($iniConfig !== false) {
                    $this->config = $iniConfig;
                } else {
                    // Fallback to our custom parser
                    $this->config = $this->parsePeanutsFormat($content);
                }
            } else {
                // Legacy .peanuts format (TOML-like but elephant-friendly)  
                $this->config = $this->parsePeanutsFormat($content);
            }
            
            $this->applyConfiguration();
            return true;
        } catch (Exception $e) {
            error_log("Error loading source file {$sourceFile}: " . $e->getMessage());
            return false;
        }
    }
    
    private function parsePeanutsFormat(string $content): array
    {
        $config = [];
        $currentSection = null;
        $lines = explode("\n", $content);
        
        foreach ($lines as $line) {
            $line = trim($line);
            
            // Skip comments and empty lines
            if (empty($line) || $line[0] === '#') {
                continue;
            }
            
            // Section headers [section] or [section.subsection]
            if (preg_match('/^\[([^\]]+)\]$/', $line, $matches)) {
                $currentSection = $matches[1];
                
                // Handle nested sections (e.g., [tuskmail.smtp])
                if (strpos($currentSection, '.') !== false) {
                    $parts = explode('.', $currentSection);
                    $ref = &$config;
                    foreach ($parts as $part) {
                        if (!isset($ref[$part])) {
                            $ref[$part] = [];
                        }
                        $ref = &$ref[$part];
                    }
                } else {
                    // Simple section
                    if (!isset($config[$currentSection])) {
                        $config[$currentSection] = [];
                    }
                }
                continue;
            }
            
            // Key-value pairs
            if (preg_match('/^([^=]+)=(.*)$/', $line, $matches)) {
                $key = trim($matches[1]);
                $value = $this->parseValue(trim($matches[2]));
                
                if ($currentSection) {
                    // Handle nested section assignment
                    if (strpos($currentSection, '.') !== false) {
                        $parts = explode('.', $currentSection);
                        $ref = &$config;
                        foreach ($parts as $part) {
                            if (!isset($ref[$part])) {
                                $ref[$part] = [];
                            }
                            $ref = &$ref[$part];
                        }
                        $ref[$key] = $value;
                    } else {
                        // Simple section assignment
                        $config[$currentSection][$key] = $value;
                    }
                } else {
                    $config[$key] = $value;
                }
            }
        }
        
        return $config;
    }
    private function parseValue(string $value)
    {
        // Remove quotes
        if (preg_match('/^"(.*)"$/', $value, $matches) || preg_match("/^'(.*)'$/", $value, $matches)) {
            return $matches[1];
        }
        
        // Boolean values
        if (in_array(strtolower($value), ['true', 'false'])) {
            return strtolower($value) === 'true';
        }
        
        // Null
        if (strtolower($value) === 'null') {
            return null;
        }
        
        // Numbers
        if (is_numeric($value)) {
            return strpos($value, '.') !== false ? (float)$value : (int)$value;
        }
        
        // Arrays (simple format: [item1,item2,item3])
        if (preg_match('/^\[(.*)\]$/', $value, $matches)) {
            return array_map('trim', explode(',', $matches[1]));
        }
        
        // Default to string
        return $value;
    }
    private function applyConfiguration(): void
    {
        // Set environment variables
        foreach ($this->config as $section => $values) {
            if (is_array($values)) {
                foreach ($values as $key => $value) {
                    $envKey = strtoupper($section . '_' . $key);
                    $_ENV[$envKey] = $value;
                    putenv("$envKey=" . (is_string($value) ? $value : json_encode($value)));
                }
            } else {
                $envKey = strtoupper($section);
                $_ENV[$envKey] = $values;
                putenv("$envKey=" . (is_string($values) ? $values : json_encode($values)));
            }
        }
        
        // Set specific constants for TuskPHP
        $this->setTuskConstants();
    }
    private function setTuskConstants(): void
    {
        $mappings = [
            // Database
            'database.host' => 'DB_HOST',
            'database.name' => 'DB_NAME',
            'database.user' => 'DB_USER',
            'database.password' => 'DB_PASS',
            'database.port' => 'DB_PORT',
            // Application
            'app.name' => 'PROJECT_NAME',
            'app.url' => 'APP_URL',
            'app.env' => 'APP_ENV',
            'app.debug' => 'APP_DEBUG',
            // Mail
            'mail.host' => 'SMTP_SERVER',
            'mail.port' => 'SMTP_PORT',
            'mail.username' => 'SMTP_USERNAME',
            'mail.password' => 'SMTP_PASSWORD',
            'mail.from' => 'MAIL_DEFAULT_SENDER',
            // TuskPHP specific
            'tusk.version' => 'TUSK_VERSION',
            'tusk.elder_path' => 'ELDER_PATH',
            'tusk.api_key' => 'TUSK_API_KEY',
        ];
        
        foreach ($mappings as $configPath => $constantName) {
            $value = $this->getConfigValue($configPath);
            if ($value !== null && !defined($constantName)) {
                define($constantName, $value);
            }
        }
    }
    public function getConfigValue(string $path, $default = null)
    {
        $keys = explode('.', $path);
        $value = $this->config;
        
        foreach ($keys as $key) {
            if (!isset($value[$key])) {
                return $default;
            }
            $value = $value[$key];
        }
        
        return $value;
    }
          public static function compile(string $sourceFile = 'peanu.tsk', string $outputFile = null): bool
    {
        if (!$outputFile) {
            // Default to .pnt (preferred) or .peanuts for backward compatibility
            if (strpos($sourceFile, 'peanu.tsk') !== false) {
                $outputFile = '.pnt';
            } else {
                $outputFile = str_replace('.tsk', '.pnt', $sourceFile);
            }
        }
        
        $instance = self::getInstance();
        if (!$instance->loadSource($sourceFile)) {
            return false;
        }
        
        try {
            // Determine magic header based on extension
            $ext = pathinfo($outputFile, PATHINFO_EXTENSION);
            $magic = ($ext === 'pnt') ? 'PNUT' : 'PNUT'; // Both use PNUT for now
            
            // NEW SYSTEM: Compress config for binary format
            $configJson = json_encode($instance->config, JSON_UNESCAPED_SLASHES);
            $compressed = gzcompress($configJson, 9);
            
            // Create binary header (magic signature)
            $header = pack('a4CV', $magic, 1, strlen($compressed));
            
            // Write binary file
            $success = file_put_contents($outputFile, $header . $compressed);
            if ($success) {
                // Make it read-only for security
                chmod($outputFile, 0644);
                return true;
            }
        } catch (Exception $e) {
            error_log("Error compiling to binary format: " . $e->getMessage());
        }
        
        return false;
    }



    public static function shell(string $sourceFile = '.peanuts', string $outputFile = null): bool
    {
        // LEGACY: Keep shell method for backward compatibility
        if (!$outputFile) {
            $outputFile = str_replace('.peanuts', '.shell', $sourceFile);
        }
        $instance = self::getInstance();
        if (!$instance->loadSource($sourceFile)) {
            return false;
        }
        try {
            // Compress peanuts for the shell
            $configJson = json_encode($instance->config, JSON_UNESCAPED_SLASHES);
            $compressed = gzcompress($configJson, 9);
            // Create shell header (magic signature)
            $header = pack('a4CV', 'SHEL', 1, strlen($compressed));
            // Write shell file (peanuts inside!)
            $success = file_put_contents($outputFile, $header . $compressed);
            if ($success) {
                // Make it read-only for security (hard shell!)
                chmod($outputFile, 0644);
                return true;
            }
        } catch (Exception $e) {
            error_log("Error shelling .peanuts: " . $e->getMessage());
        }
        return false;
    }

     private static function isBinaryFile(string $file): bool
    {
        if (!file_exists($file)) {
            return false;
        }
        
        // Check if it's a binary file (.pnt or .peanuts) by checking magic header
        $handle = fopen($file, 'rb');
        if (!$handle) {
            return false;
        }
        
        $magic = fread($handle, 4);
        fclose($handle);
        
        // If it has 'PNUT' or 'SHEL' magic header, it's a binary file
        return in_array($magic, ['PNUT', 'SHEL']);
    }

    private static function isShellNewer(string $sourceFile, string $shellFile): bool
    {
        if (!file_exists($sourceFile) || !file_exists($shellFile)) {
            return false;
        }
        return filemtime($shellFile) >= filemtime($sourceFile);
    }
 public static function needsRecompilation(string $peanutsFile): bool
 {
 $shellFile = str_replace('.peanuts', '.shell', $peanutsFile);
 return !self::isShellNewer($peanutsFile, $shellFile);
 }
 public function getConfig(): array
 {
 return $this->config ?? [];
 }
 public function setConfig(string $path, mixed $value): void
 {
 $keys = explode('.', $path);
 $config = &$this->config;
 foreach ($keys as $key) {
 if (!isset($config[$key])) {
 $config[$key] = [];
 }
 $config = &$config[$key];
 }
 $config = $value;
 }
}
// Global functions for easy access
if (!function_exists('peanuts')) {
 function peanuts(): Peanuts {
 return Peanuts::getInstance();
 }
}
if (!function_exists('peanuts_env')) {
 function peanuts_env(string $key, $default = null) {
 return Peanuts::getPeanutsEnv($key, $default);
 }
}
if (!function_exists('peanuts_set')) {
    function peanuts_set(string $key, $value): bool {
        return Peanuts::setPeanutsEnv($key, $value);
    }
}

// Memory class replacement - create simple fallback class
if (!class_exists('TuskPHP\Memory')) {
    class_alias('TuskPHP\Elephants\PeanutsMemoryFallback', 'TuskPHP\Memory');
}

// Fallback Memory class implementation
class PeanutsMemoryFallback {
    private static $storage = [];
    
    public static function remember(string $key, $value, int $ttl = 3600): void { 
        self::$storage[$key] = $value; 
    }
    
    public static function recall(string $key, $default = null) { 
        return self::$storage[$key] ?? $default; 
    }
    
    public static function forget(string $key): void { 
        unset(self::$storage[$key]); 
    }
    
    public static function setDefaultTTL(int $ttl): void { 
        /* no-op */ 
    }
    
    public static function enableAggressiveCaching(bool $enabled): void { 
        /* no-op */ 
    }
} 