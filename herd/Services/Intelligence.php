<?php
/**
 * <?tusk> TuskPHP Herd Intelligence Service
 * ========================================
 * "The elephant's memory and keen observation"
 * Integrates Eye security monitoring & Footprint analytics
 * Strong. Secure. Scalable. 🐘
 */

namespace TuskPHP\Herd\Services;

use TuskPHP\{TuskDb, Memory, TuskObject};

class Intelligence
{
    private $eye;
    private $footprint;
    private $memory;
    private $db;
    
    public function __construct()
    {
        $this->memory = new Memory();
        $this->db = new TuskDb();
        $this->initializeMonitoring();
    }
    
    /**
     * Initialize Eye and Footprint monitoring
     */
    private function initializeMonitoring(): void
    {
        // Initialize Eye for security monitoring
        if (class_exists('TuskPHP\\Elephants\\Eye')) {
            $this->eye = new \TuskPHP\Elephants\Eye();
        }
        
        // Initialize Footprint for behavior tracking
        if (class_exists('TuskPHP\\Commands\\FootprintCommand')) {
            $this->footprint = new \TuskPHP\Commands\FootprintCommand();
        }
    }
    
    /**
     * Get comprehensive intelligence report
     */
    public function getIntelligenceReport(): array
    {
        return [
            'security' => $this->getSecurityIntelligence(),
            'behavior' => $this->getBehaviorIntelligence(),
            'realtime' => $this->getRealtimeMetrics(),
            'insights' => $this->generateInsights(),
            'alerts' => $this->getActiveAlerts()
        ];
    }
    
    /**
     * Get security intelligence from Eye
     */
    public function getSecurityIntelligence(): array
    {
        $cacheKey = 'herd_security_intelligence';
        $cached = $this->memory->recall($cacheKey);
        
        if ($cached) {
            return $cached;
        }
        
        $intelligence = [
            'threat_level' => $this->calculateThreatLevel(),
            'failed_logins' => $this->getFailedLoginAttempts(),
            'suspicious_ips' => $this->getSuspiciousIPs(),
            'device_anomalies' => $this->getDeviceAnomalies(),
            'geographic_anomalies' => $this->getGeographicAnomalies(),
            'security_score' => $this->calculateSecurityScore(),
            'active_threats' => $this->getActiveThreats()
        ];
        
        // Cache for 5 minutes
        $this->memory->remember($cacheKey, $intelligence, 300);
        
        return $intelligence;
    }
    
    /**
     * Get behavior intelligence from Footprint
     */
    public function getBehaviorIntelligence(): array
    {
        $cacheKey = 'herd_behavior_intelligence';
        $cached = $this->memory->recall($cacheKey);
        
        if ($cached) {
            return $cached;
        }
        
        $intelligence = [
            'active_users' => $this->getActiveUsers(),
            'session_patterns' => $this->getSessionPatterns(),
            'page_analytics' => $this->getPageAnalytics(),
            'user_journey' => $this->getUserJourneyData(),
            'engagement_metrics' => $this->getEngagementMetrics(),
            'conversion_funnel' => $this->getConversionFunnel(),
            'device_usage' => $this->getDeviceUsage()
        ];
        
        // Cache for 2 minutes
        $this->memory->remember($cacheKey, $intelligence, 120);
        
        return $intelligence;
    }
    
    /**
     * Get real-time metrics
     */
    public function getRealtimeMetrics(): array
    {
        $now = time();
        $lastHour = $now - 3600;
        $last5Minutes = $now - 300;
        
        return [
            'active_users_now' => $this->getActiveUsers(),
            'logins_last_hour' => $this->getRecentLogins($lastHour),
            'page_views_per_minute' => $this->getPageViewsPerMinute(),
            'sessions_started' => $this->getNewSessionsCount(),
            'bounce_rate' => $this->calculateCurrentBounceRate(),
            'avg_session_duration' => $this->getAverageSessionDuration(),
            'security_alerts' => $this->getRecentSecurityAlerts()
        ];
    }
    
    /**
     * Track user login with intelligence
     */
    public function trackLogin(array $user, array $metadata = []): void
    {
        $loginData = [
            'user_id' => $user['id'],
            'email' => $user['email'],
            'ip_address' => $metadata['ip_address'] ?? $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $metadata['user_agent'] ?? $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'device_type' => $this->detectDeviceType($metadata['user_agent'] ?? ''),
            'success' => true,
            'session_id' => $metadata['session_id'] ?? session_id(),
            'remember_me' => $metadata['remember_me'] ?? false,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Store in database
        $this->db->insert('herd_login_attempts', $loginData);
        
        // Update user's last login
        $this->db->update('users', [
            'last_login_at' => date('Y-m-d H:i:s'),
            'last_login_ip' => $loginData['ip_address'],
            'login_count' => $this->db->raw('login_count + 1')
        ], ['id' => $user['id']]);
        
        // Check for security anomalies
        $this->checkSecurityAnomalies($user, $loginData);
        
        // Update real-time stats
        $this->updateRealTimeStats('login', $loginData);
    }
    
    /**
     * Track user logout
     */
    public function trackLogout(int $userId, array $metadata = []): void
    {
        $logoutData = [
            'user_id' => $userId,
            'session_id' => $metadata['session_id'] ?? session_id(),
            'session_duration' => $metadata['session_duration'] ?? 0,
            'pages_viewed' => $metadata['pages_viewed'] ?? 0,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('herd_logout_events', $logoutData);
        
        // Update session record
        $this->db->update('herd_sessions', [
            'ended_at' => date('Y-m-d H:i:s'),
            'duration' => $logoutData['session_duration'],
            'pages_viewed' => $logoutData['pages_viewed']
        ], [
            'user_id' => $userId,
            'session_id' => $logoutData['session_id']
        ]);
        
        // Update real-time stats
        $this->updateRealTimeStats('logout', $logoutData);
    }
    
    /**
     * Track page view with Footprint integration
     */
    public function trackPageView(string $page, array $metadata = []): void
    {
        $pageViewData = [
            'user_id' => $_SESSION['user_id'] ?? null,
            'session_id' => session_id(),
            'page' => $page,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'referrer' => $_SERVER['HTTP_REFERER'] ?? '',
            'time_on_page' => $metadata['time_on_page'] ?? 0,
            'scroll_depth' => $metadata['scroll_depth'] ?? 0,
            'interactions' => $metadata['interactions'] ?? 0,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('herd_page_views', $pageViewData);
        
        // Update session activity
        if (isset($_SESSION['user_id'])) {
            $this->db->update('herd_sessions', [
                'last_activity' => time(),
                'pages_viewed' => $this->db->raw('pages_viewed + 1')
            ], [
                'user_id' => $_SESSION['user_id'],
                'session_id' => session_id()
            ]);
        }
    }
    
    /**
     * Generate insights from combined Eye and Footprint data
     */
    public function generateInsights(): array
    {
        $insights = [];
        
        // Security insights from Eye
        $recentFailures = count($this->getFailedLoginAttempts());
        if ($recentFailures > 10) {
            $insights[] = [
                'type' => 'security',
                'level' => 'warning',
                'message' => "👁️ Eye detected {$recentFailures} failed login attempts in the last 24 hours",
                'action' => 'Review security settings and consider IP blocking'
            ];
        }
        
        // Behavior insights from Footprint
        $activeUsers = $this->getActiveUsers();
        if ($activeUsers > 100) {
            $insights[] = [
                'type' => 'traffic',
                'level' => 'success',
                'message' => "🐾 Footprint tracking shows {$activeUsers} users actively engaged",
                'action' => 'Monitor server performance and user experience'
            ];
        }
        
        // Combined intelligence
        $bounceRate = $this->calculateCurrentBounceRate();
        if ($bounceRate > 60) {
            $insights[] = [
                'type' => 'engagement',
                'level' => 'warning',
                'message' => "🧠 High bounce rate detected: {$bounceRate}% - users leaving quickly",
                'action' => 'Review landing pages and improve user onboarding'
            ];
        }
        
        return $insights;
    }
    
    /**
     * Get active alerts from Eye and Footprint
     */
    public function getActiveAlerts(): array
    {
        $alerts = [];
        
        // Security alerts from Eye
        $suspiciousIPs = $this->getSuspiciousIPs();
        foreach ($suspiciousIPs as $ip) {
            $alerts[] = [
                'type' => 'security',
                'severity' => 'high',
                'source' => 'Eye',
                'message' => "Suspicious activity from IP: {$ip['ip_address']} ({$ip['failure_count']} failures)",
                'timestamp' => time()
            ];
        }
        
        // Behavior alerts from Footprint
        $unusualTraffic = $this->detectUnusualTraffic();
        if ($unusualTraffic) {
            $alerts[] = [
                'type' => 'traffic',
                'severity' => 'medium',
                'source' => 'Footprint',
                'message' => 'Unusual traffic pattern detected - investigate potential bot activity',
                'timestamp' => time()
            ];
        }
        
        return $alerts;
    }
    
    // Private helper methods
    private function isPostgreSQL(): bool
    {
        // Check if we're using PostgreSQL or SQLite fallback using TuskDb wisdom
        try {
            $wisdom = \TuskPHP\TuskDb::wisdom();
            $dbType = $wisdom['database_type'] ?? 'sqlite';
            return $dbType === 'postgresql';
        } catch (Exception $e) {
            return false; // Default to SQLite syntax
        }
    }
    
    private function calculateThreatLevel(): string
    {
        $recentFailures = count($this->getFailedLoginAttempts());
        $suspiciousIPs = count($this->getSuspiciousIPs());
        
        if ($recentFailures > 50 || $suspiciousIPs > 10) {
            return 'high';
        } elseif ($recentFailures > 20 || $suspiciousIPs > 5) {
            return 'medium';
        } else {
            return 'low';
        }
    }
    
    private function calculateSecurityScore(): int
    {
        $score = 100;
        $score -= min(30, count($this->getFailedLoginAttempts()) * 2);
        $score -= min(20, count($this->getSuspiciousIPs()) * 3);
        $score -= min(15, count($this->getDeviceAnomalies()) * 5);
        return max(0, $score);
    }
    
    private function getFailedLoginAttempts(): array
    {
        // Database-agnostic date queries
        $query = $this->isPostgreSQL() 
            ? "SELECT ip_address, email, COUNT(*) as attempts, MAX(created_at) as last_attempt
               FROM herd_login_attempts 
               WHERE success = 0 AND created_at > NOW() - INTERVAL 24 HOUR
               GROUP BY ip_address, email
               ORDER BY attempts DESC
               LIMIT 10"
            : "SELECT ip_address, email, COUNT(*) as attempts, MAX(created_at) as last_attempt
               FROM herd_login_attempts 
               WHERE success = 0 AND created_at > datetime('now', '-24 hours')
               GROUP BY ip_address, email
               ORDER BY attempts DESC
               LIMIT 10";
        
        $result = $this->db->query($query);
        return $result ? $result->fetchAll() : [];
    }
    
    private function getSuspiciousIPs(): array
    {
        $query = $this->isPostgreSQL()
            ? "SELECT ip_address, COUNT(*) as failure_count
               FROM herd_login_attempts 
               WHERE success = 0 AND created_at > NOW() - INTERVAL 6 HOUR
               GROUP BY ip_address
               HAVING failure_count > 5
               ORDER BY failure_count DESC"
            : "SELECT ip_address, COUNT(*) as failure_count
               FROM herd_login_attempts 
               WHERE success = 0 AND created_at > datetime('now', '-6 hours')
               GROUP BY ip_address
               HAVING failure_count > 5
               ORDER BY failure_count DESC";
        
        $result = $this->db->query($query);
        return $result ? $result->fetchAll() : [];
    }
    
    private function getDeviceAnomalies(): array
    {
        $query = $this->isPostgreSQL()
            ? "SELECT user_id, COUNT(DISTINCT user_agent) as device_count
               FROM herd_login_attempts 
               WHERE success = 1 AND created_at > NOW() - INTERVAL 7 DAY
               GROUP BY user_id
               HAVING device_count > 5"
            : "SELECT user_id, COUNT(DISTINCT user_agent) as device_count
               FROM herd_login_attempts 
               WHERE success = 1 AND created_at > datetime('now', '-7 days')
               GROUP BY user_id
               HAVING device_count > 5";
        
        $result = $this->db->query($query);
        return $result ? $result->fetchAll() : [];
    }
    
    private function getGeographicAnomalies(): array
    {
        // This would integrate with a GeoIP service
        return []; // Placeholder
    }
    
    private function getActiveUsers(): int
    {
        return $this->db->query("
            SELECT COUNT(DISTINCT user_id) 
            FROM herd_sessions 
            WHERE last_activity > ?
        ", [time() - 300])->fetchColumn() ?: 0;
    }
    
    private function getRecentLogins(int $since): int
    {
        $query = $this->isPostgreSQL()
            ? "SELECT COUNT(*) 
               FROM herd_login_attempts 
               WHERE success = 1 AND created_at > TO_TIMESTAMP(?)"
            : "SELECT COUNT(*) 
               FROM herd_login_attempts 
               WHERE success = 1 AND created_at > datetime(?, 'unixepoch')";
        
        $result = $this->db->query($query, [$since]);
        return $result ? $result->fetchColumn() : 0;
    }
    
    private function getPageViewsPerMinute(): float
    {
        $query = $this->isPostgreSQL()
            ? "SELECT COUNT(*) 
               FROM herd_page_views 
               WHERE created_at > NOW() - INTERVAL 5 MINUTE"
            : "SELECT COUNT(*) 
               FROM herd_page_views 
               WHERE created_at > datetime('now', '-5 minutes')";
        
        $result = $this->db->query($query);
        $views = $result ? $result->fetchColumn() : 0;
        
        return round($views / 5, 1);
    }
    
    private function getNewSessionsCount(): int
    {
        $query = $this->isPostgreSQL()
            ? "SELECT COUNT(*) 
               FROM herd_sessions 
               WHERE created_at > EXTRACT(EPOCH FROM (NOW() - INTERVAL '5 MINUTE'))"
            : "SELECT COUNT(*) 
               FROM herd_sessions 
               WHERE created_at > strftime('%s', datetime('now', '-5 minutes'))";
        
        $result = $this->db->query($query);
        return $result ? $result->fetchColumn() : 0;
    }
    
    private function calculateCurrentBounceRate(): float
    {
        $totalQuery = $this->isPostgreSQL()
            ? "SELECT COUNT(*) FROM herd_sessions 
               WHERE created_at > EXTRACT(EPOCH FROM (NOW() - INTERVAL '1 HOUR'))"
            : "SELECT COUNT(*) FROM herd_sessions 
               WHERE created_at > strftime('%s', datetime('now', '-1 hour'))";
        
        $bouncedQuery = $this->isPostgreSQL()
            ? "SELECT COUNT(*) FROM herd_sessions 
               WHERE pages_viewed = 1 AND created_at > EXTRACT(EPOCH FROM (NOW() - INTERVAL '1 HOUR'))"
            : "SELECT COUNT(*) FROM herd_sessions 
               WHERE pages_viewed = 1 AND created_at > strftime('%s', datetime('now', '-1 hour'))";
        
        $totalResult = $this->db->query($totalQuery);
        $totalSessions = $totalResult ? $totalResult->fetchColumn() : 1;
        $totalSessions = $totalSessions ?: 1; // Prevent division by zero
        
        $bouncedResult = $this->db->query($bouncedQuery);
        $bouncedSessions = $bouncedResult ? $bouncedResult->fetchColumn() : 0;
        
        return round(($bouncedSessions / $totalSessions) * 100, 1);
    }
    
    private function getAverageSessionDuration(): int
    {
        $query = $this->isPostgreSQL()
            ? "SELECT AVG(duration) 
               FROM herd_sessions 
               WHERE ended_at IS NOT NULL AND created_at > EXTRACT(EPOCH FROM (NOW() - INTERVAL '24 HOUR'))"
            : "SELECT AVG(duration) 
               FROM herd_sessions 
               WHERE ended_at IS NOT NULL AND created_at > strftime('%s', datetime('now', '-24 hours'))";
        
        $result = $this->db->query($query);
        return $result ? (int)$result->fetchColumn() : 0;
    }
    
    private function getRecentSecurityAlerts(): int
    {
        $query = $this->isPostgreSQL()
            ? "SELECT COUNT(*) 
               FROM herd_security_alerts 
               WHERE created_at > NOW() - INTERVAL 1 HOUR"
            : "SELECT COUNT(*) 
               FROM herd_security_alerts 
               WHERE created_at > datetime('now', '-1 hour')";
        
        $result = $this->db->query($query);
        return $result ? $result->fetchColumn() : 0;
    }
    
    private function getSessionPatterns(): array
    {
        $query = $this->isPostgreSQL()
            ? "SELECT 
                EXTRACT(HOUR FROM TO_TIMESTAMP(created_at)) as hour,
                COUNT(*) as sessions
               FROM herd_sessions 
               WHERE created_at > EXTRACT(EPOCH FROM (NOW() - INTERVAL '7 DAY'))
               GROUP BY hour
               ORDER BY hour"
            : "SELECT 
                CAST(strftime('%H', datetime(created_at, 'unixepoch')) AS INTEGER) as hour,
                COUNT(*) as sessions
               FROM herd_sessions 
               WHERE created_at > strftime('%s', datetime('now', '-7 days'))
               GROUP BY hour
               ORDER BY hour";
        
        $result = $this->db->query($query);
        return $result ? $result->fetchAll() : [];
    }
    
    private function getPageAnalytics(): array
    {
        $query = $this->isPostgreSQL()
            ? "SELECT page, COUNT(*) as views, AVG(time_on_page) as avg_time
               FROM herd_page_views 
               WHERE created_at > NOW() - INTERVAL 24 HOUR
               GROUP BY page
               ORDER BY views DESC
               LIMIT 10"
            : "SELECT page, COUNT(*) as views, AVG(time_on_page) as avg_time
               FROM herd_page_views 
               WHERE created_at > datetime('now', '-24 hours')
               GROUP BY page
               ORDER BY views DESC
               LIMIT 10";
        
        $result = $this->db->query($query);
        return $result ? $result->fetchAll() : [];
    }
    
    private function getUserJourneyData(): array
    {
        // Analyze common user paths through the application
        return []; // Complex query - placeholder
    }
    
    private function getEngagementMetrics(): array
    {
        $query = $this->isPostgreSQL()
            ? "SELECT 
                AVG(scroll_depth) as avg_scroll_depth,
                AVG(interactions) as avg_interactions,
                AVG(time_on_page) as avg_time_on_page
               FROM herd_page_views 
               WHERE created_at > NOW() - INTERVAL 24 HOUR"
            : "SELECT 
                AVG(scroll_depth) as avg_scroll_depth,
                AVG(interactions) as avg_interactions,
                AVG(time_on_page) as avg_time_on_page
               FROM herd_page_views 
               WHERE created_at > datetime('now', '-24 hours')";
        
        $result = $this->db->query($query);
        return $result ? $result->fetch() : [];
    }
    
    private function getConversionFunnel(): array
    {
        // Track conversion through key pages
        return []; // Placeholder for complex analysis
    }
    
    private function getDeviceUsage(): array
    {
        $query = $this->isPostgreSQL()
            ? "SELECT device_type, COUNT(*) as count
               FROM herd_login_attempts 
               WHERE success = 1 AND created_at > NOW() - INTERVAL 7 DAY
               GROUP BY device_type"
            : "SELECT device_type, COUNT(*) as count
               FROM herd_login_attempts 
               WHERE success = 1 AND created_at > datetime('now', '-7 days')
               GROUP BY device_type";
        
        $result = $this->db->query($query);
        return $result ? $result->fetchAll() : [];
    }
    
    private function detectDeviceType(string $userAgent): string
    {
        if (stripos($userAgent, 'mobile') !== false) {
            return 'mobile';
        } elseif (stripos($userAgent, 'tablet') !== false) {
            return 'tablet';
        } else {
            return 'desktop';
        }
    }
    
    private function checkSecurityAnomalies(array $user, array $loginData): void
    {
        $query = $this->isPostgreSQL()
            ? "SELECT COUNT(*) FROM herd_login_attempts 
               WHERE user_id = ? AND success = 1 AND created_at > NOW() - INTERVAL 5 MINUTE"
            : "SELECT COUNT(*) FROM herd_login_attempts 
               WHERE user_id = ? AND success = 1 AND created_at > datetime('now', '-5 minutes')";
        
        $result = $this->db->query($query, [$user['id']]);
        $recentLogins = $result ? $result->fetchColumn() : 0;
        
        if ($recentLogins > 3) {
            $this->logSecurityAlert('rapid_login', $user['id'], [
                'recent_login_count' => $recentLogins,
                'ip_address' => $loginData['ip_address']
            ]);
        }
    }
    
    private function logSecurityAlert(string $type, int $userId, array $metadata): void
    {
        $this->db->insert('herd_security_alerts', [
            'type' => $type,
            'user_id' => $userId,
            'metadata' => json_encode($metadata),
            'severity' => $this->getAlertSeverity($type),
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    private function getAlertSeverity(string $type): string
    {
        $severityMap = [
            'rapid_login' => 'medium',
            'brute_force' => 'high',
            'geographic_anomaly' => 'medium',
            'device_anomaly' => 'low'
        ];
        
        return $severityMap[$type] ?? 'low';
    }
    
    private function updateRealTimeStats(string $event, array $data): void
    {
        $statsKey = 'herd_realtime_stats';
        $stats = $this->memory->recall($statsKey) ?: [];
        
        $stats['last_updated'] = time();
        $stats['events'][] = [
            'type' => $event,
            'timestamp' => time(),
            'data' => $data
        ];
        
        // Keep only last 100 events
        if (count($stats['events']) > 100) {
            $stats['events'] = array_slice($stats['events'], -100);
        }
        
        $this->memory->remember($statsKey, $stats, 3600);
    }
    
    private function getActiveThreats(): array
    {
        $query = $this->isPostgreSQL()
            ? "SELECT type, COUNT(*) as count, MAX(created_at) as latest
               FROM herd_security_alerts 
               WHERE created_at > NOW() - INTERVAL 1 HOUR
               GROUP BY type
               ORDER BY count DESC"
            : "SELECT type, COUNT(*) as count, MAX(created_at) as latest
               FROM herd_security_alerts 
               WHERE created_at > datetime('now', '-1 hour')
               GROUP BY type
               ORDER BY count DESC";
        
        $result = $this->db->query($query);
        return $result ? $result->fetchAll() : [];
    }
    
    private function detectUnusualTraffic(): bool
    {
        $currentQuery = $this->isPostgreSQL()
            ? "SELECT COUNT(*) FROM herd_page_views 
               WHERE created_at > NOW() - INTERVAL 1 HOUR"
            : "SELECT COUNT(*) FROM herd_page_views 
               WHERE created_at > datetime('now', '-1 hour')";
        
        $currentResult = $this->db->query($currentQuery);
        $currentHourViews = $currentResult ? $currentResult->fetchColumn() : 0;
        
        $avgQuery = $this->isPostgreSQL()
            ? "SELECT AVG(hourly_views) FROM (
                SELECT COUNT(*) as hourly_views 
                FROM herd_page_views 
                WHERE created_at > NOW() - INTERVAL 24 HOUR
                GROUP BY EXTRACT(HOUR FROM created_at)
               ) as hourly_stats"
            : "SELECT AVG(hourly_views) FROM (
                SELECT COUNT(*) as hourly_views 
                FROM herd_page_views 
                WHERE created_at > datetime('now', '-24 hours')
                GROUP BY strftime('%H', created_at)
               ) as hourly_stats";
        
        $avgResult = $this->db->query($avgQuery);
        $avgHourlyViews = $avgResult ? $avgResult->fetchColumn() : 0;
        
        // Flag if current hour is 300% above average
        return $currentHourViews > ($avgHourlyViews * 3);
    }
} 