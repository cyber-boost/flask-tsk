<?php
/**
 * <?tusk> TuskPHP Herd Manager Service
 * ==================================
 * "The matriarch leads the herd"
 * Central management for herd operations with Eye & Footprint integration
 * Strong. Secure. Scalable. 🐘
 */

namespace TuskPHP\Herd\Services;

use TuskPHP\{TuskDb, Memory, TuskObject};

class HerdManager
{
    private $eye;
    private $footprint;
    
    public function __construct()
    {
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
        if (class_exists('TuskPHP\\Elephants\\Footprint')) {
            $this->footprint = new \TuskPHP\Elephants\Footprint();
        }
    }
    
    /**
     * Get comprehensive herd statistics with real-time analytics
     */
    public function getStats(): array
    {
        return [
            'realtime' => $this->getRealtimeStats(),
            'users' => $this->getUserStats(),
            'sessions' => $this->getSessionStats(),
            'activity' => $this->getActivityStats(),
            'security' => $this->getSecurityStats(),
            'behavior' => $this->getBehaviorStats(),
            'performance' => $this->getPerformanceStats()
        ];
    }
    
    /**
     * Get real-time statistics
     */
    public function getRealtimeStats(): array
    {
        return [
            'currently_online' => $this->getCurrentlyOnline(),
            'active_sessions' => $this->getActiveSessions(),
            'recent_logins' => $this->getRecentLogins(5), // Last 5 minutes
            'failed_attempts' => $this->getRecentFailedAttempts(5),
            'security_events' => $this->getRecentSecurityEvents(5),
            'last_updated' => date('Y-m-d H:i:s')
        ];
    }
    
    /**
     * Get detailed user statistics
     */
    public function getUserStats(): array
    {
        return [
            'total_users' => $this->getTotalUsers(),
            'verified_users' => $this->getVerifiedUsers(),
            'active_users' => [
                'today' => $this->getActiveUsers(1),
                'this_week' => $this->getActiveUsers(7),
                'this_month' => $this->getActiveUsers(30)
            ],
            'new_registrations' => [
                'today' => $this->getNewRegistrations(1),
                'this_week' => $this->getNewRegistrations(7),
                'this_month' => $this->getNewRegistrations(30)
            ],
            'user_growth' => $this->getUserGrowthTrend()
        ];
    }
    
    /**
     * Get session analytics
     */
    public function getSessionStats(): array
    {
        return [
            'total_active' => $this->getTotalActiveSessions(),
            'by_device' => $this->getSessionsByDevice(),
            'by_location' => $this->getSessionsByLocation(),
            'average_duration' => $this->getAverageSessionDuration(),
            'concurrent_peak' => $this->getPeakConcurrentSessions(),
            'remember_token_usage' => $this->getRememberTokenUsage()
        ];
    }
    
    /**
     * Get activity patterns with Footprint integration
     */
    public function getActivityStats(): array
    {
        $stats = [
            'login_patterns' => $this->getLoginPatterns(),
            'popular_times' => $this->getPopularLoginTimes(),
            'geographic_distribution' => $this->getGeographicDistribution(),
            'device_patterns' => $this->getDevicePatterns(),
            'session_patterns' => $this->getSessionPatterns()
        ];
        
        // Enhance with Footprint data if available
        if ($this->footprint) {
            $stats['behavior_insights'] = $this->footprint->getHerdBehaviorInsights();
            $stats['engagement_metrics'] = $this->footprint->getEngagementMetrics();
        }
        
        return $stats;
    }
    
    /**
     * Get security analytics with Eye integration
     */
    public function getSecurityStats(): array
    {
        $stats = [
            'failed_logins' => [
                'last_hour' => $this->getFailedAttempts(1, 'hour'),
                'today' => $this->getFailedAttempts(1, 'day'),
                'this_week' => $this->getFailedAttempts(7, 'day')
            ],
            'locked_accounts' => $this->getLockedAccounts(),
            'suspicious_activity' => $this->getSuspiciousActivity(),
            'password_resets' => [
                'today' => $this->getPasswordResets(1),
                'this_week' => $this->getPasswordResets(7)
            ]
        ];
        
        // Enhance with Eye security monitoring if available
        if ($this->eye) {
            $stats['threat_detection'] = $this->eye->getHerdThreats();
            $stats['security_score'] = $this->eye->calculateHerdSecurityScore();
            $stats['recommendations'] = $this->eye->getSecurityRecommendations();
        }
        
        return $stats;
    }
    
    /**
     * Get behavior analytics
     */
    public function getBehaviorStats(): array
    {
        return [
            'login_frequency' => $this->getLoginFrequencyDistribution(),
            'session_duration_patterns' => $this->getSessionDurationPatterns(),
            'feature_usage' => $this->getFeatureUsageStats(),
            'user_journey_patterns' => $this->getUserJourneyPatterns(),
            'retention_metrics' => $this->getRetentionMetrics()
        ];
    }
    
    /**
     * Get performance metrics
     */
    public function getPerformanceStats(): array
    {
        return [
            'authentication_speed' => $this->getAuthenticationPerformance(),
            'session_creation_time' => $this->getSessionCreationPerformance(),
            'database_performance' => $this->getDatabasePerformance(),
            'memory_usage' => Memory::health(),
            'response_times' => $this->getResponseTimeMetrics()
        ];
    }
    
    /**
     * Get currently online users (active in last 5 minutes)
     */
    private function getCurrentlyOnline(): int
    {
        $fiveMinutesAgo = date('Y-m-d H:i:s', strtotime('-5 minutes'));
        $sessions = TuskDb::recall('herd_auth_logs', [
            'type' => 'activity_update',
            'created_at >=' => $fiveMinutesAgo
        ]);
        
        $uniqueUsers = array_unique(array_column($sessions, 'user_id'));
        return count($uniqueUsers);
    }
    
    /**
     * Get total user count
     */
    private function getTotalUsers(): int
    {
        $result = TuskDb::recall('users', [], ['count' => true]);
        return $result[0]['count'] ?? 0;
    }
    
    /**
     * Get verified users count
     */
    private function getVerifiedUsers(): int
    {
        $users = TuskDb::recall('users', ['email_verified_at !=' => null]);
        return count($users);
    }
    
    /**
     * Get active users for a given period
     */
    private function getActiveUsers(int $days): int
    {
        $startDate = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        $logs = TuskDb::recall('herd_auth_logs', [
            'type' => 'login_success',
            'created_at >=' => $startDate
        ]);
        
        $uniqueUsers = array_unique(array_column($logs, 'user_id'));
        return count($uniqueUsers);
    }
    
    /**
     * Get new registrations for a given period
     */
    private function getNewRegistrations(int $days): int
    {
        $startDate = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        $users = TuskDb::recall('users', [
            'created_at >=' => $startDate
        ]);
        return count($users);
    }
    
    /**
     * Get user growth trend (last 30 days)
     */
    private function getUserGrowthTrend(): array
    {
        $trend = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $startDate = $date . ' 00:00:00';
            $endDate = $date . ' 23:59:59';
            
            $newUsers = TuskDb::recall('users', [
                'created_at >=' => $startDate,
                'created_at <=' => $endDate
            ]);
            
            $trend[] = [
                'date' => $date,
                'new_users' => count($newUsers)
            ];
        }
        return $trend;
    }
    
    /**
     * Get recent logins (last X minutes)
     */
    private function getRecentLogins(int $minutes): int
    {
        $timeAgo = date('Y-m-d H:i:s', strtotime("-{$minutes} minutes"));
        $logs = TuskDb::recall('herd_auth_logs', [
            'type' => 'login_success',
            'created_at >=' => $timeAgo
        ]);
        return count($logs);
    }
    
    /**
     * Get recent failed attempts
     */
    private function getRecentFailedAttempts(int $minutes): int
    {
        $timeAgo = date('Y-m-d H:i:s', strtotime("-{$minutes} minutes"));
        $logs = TuskDb::recall('herd_auth_logs', [
            'type' => 'login_failed',
            'created_at >=' => $timeAgo
        ]);
        return count($logs);
    }
    
    /**
     * Get recent security events
     */
    private function getRecentSecurityEvents(int $minutes): int
    {
        $timeAgo = date('Y-m-d H:i:s', strtotime("-{$minutes} minutes"));
        $logs = TuskDb::recall('herd_auth_logs', [
            'type' => 'security_event',
            'created_at >=' => $timeAgo
        ]);
        return count($logs);
    }
    
    /**
     * Get total active sessions
     */
    private function getTotalActiveSessions(): int
    {
        return Memory::recall('active_sessions_count') ?? 0;
    }
    
    /**
     * Get sessions by device type
     */
    private function getSessionsByDevice(): array
    {
        $logs = TuskDb::recall('herd_auth_logs', [
            'type' => 'login_success'
        ], ['limit' => 1000]);
        
        $devices = ['desktop' => 0, 'mobile' => 0, 'tablet' => 0, 'unknown' => 0];
        
        foreach ($logs as $log) {
            $userAgent = $log['user_agent'] ?? '';
            $deviceType = $this->detectDeviceType($userAgent);
            $devices[$deviceType]++;
        }
        
        return $devices;
    }
    
    /**
     * Get login patterns by hour
     */
    private function getLoginPatterns(): array
    {
        $patterns = array_fill(0, 24, 0);
        
        $logs = TuskDb::recall('herd_auth_logs', [
            'type' => 'login_success'
        ], ['limit' => 5000]);
        
        foreach ($logs as $log) {
            $hour = (int)date('H', strtotime($log['created_at']));
            $patterns[$hour]++;
        }
        
        return $patterns;
    }
    
    /**
     * Get popular login times
     */
    private function getPopularLoginTimes(): array
    {
        $patterns = $this->getLoginPatterns();
        $maxLogins = max($patterns);
        $peakHour = array_search($maxLogins, $patterns);
        
        return [
            'peak_hour' => $peakHour,
            'peak_logins' => $maxLogins,
            'quiet_hours' => array_keys($patterns, min($patterns)),
            'hourly_distribution' => $patterns
        ];
    }
    
    /**
     * Detect device type from user agent
     */
    private function detectDeviceType(string $userAgent): string
    {
        if (preg_match('/Mobile|Android|iPhone|iPad/', $userAgent)) {
            if (preg_match('/iPad/', $userAgent)) return 'tablet';
            return 'mobile';
        }
        if (preg_match('/Windows|Mac|Linux/', $userAgent)) {
            return 'desktop';
        }
        return 'unknown';
    }
    
    /**
     * Track user login for analytics
     */
    public function trackLogin(array $user, array $context = []): void
    {
        // Track in Herd logs
        $this->logAuthEvent('login_success', $user['id'], array_merge($context, [
            'email' => $user['email'],
            'timestamp' => date('Y-m-d H:i:s')
        ]));
        
        // Track with Footprint if available
        if ($this->footprint) {
            $this->footprint->trackUserLogin($user['id'], $context);
        }
        
        // Update real-time statistics
        $this->updateRealtimeStats('login', $user['id']);
    }
    
    /**
     * Track security event
     */
    public function trackSecurityEvent(string $type, array $data): void
    {
        $this->logAuthEvent('security_event', $data['user_id'] ?? null, [
            'event_type' => $type,
            'data' => $data,
            'timestamp' => date('Y-m-d H:i:s')
        ]);
        
        // Alert Eye if available
        if ($this->eye) {
            $this->eye->processSecurityEvent($type, $data);
        }
    }
    
    /**
     * Update real-time statistics
     */
    private function updateRealtimeStats(string $event, ?int $userId): void
    {
        $key = "herd_realtime_{$event}";
        $current = Memory::recall($key) ?? 0;
        Memory::remember($key, $current + 1, 300); // 5 minutes TTL
        
        // Update user activity timestamp
        if ($userId) {
            Memory::remember("user_last_activity_{$userId}", time(), 3600);
        }
    }
    
    /**
     * Log authentication event
     */
    private function logAuthEvent(string $type, ?int $userId, array $data): void
    {
        TuskDb::remember('herd_auth_logs', [
            'type' => $type,
            'user_id' => $userId,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'data' => json_encode($data),
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * Get comprehensive herd intelligence report
     */
    public function getIntelligenceReport(): array
    {
        return [
            'summary' => [
                'total_users' => $this->getTotalUsers(),
                'currently_online' => $this->getCurrentlyOnline(),
                'active_this_week' => $this->getActiveUsers(7),
                'security_score' => $this->calculateSecurityScore()
            ],
            'trends' => [
                'user_growth' => $this->getUserGrowthTrend(),
                'login_patterns' => $this->getLoginPatterns(),
                'device_trends' => $this->getSessionsByDevice()
            ],
            'insights' => $this->generateHerdInsights(),
            'recommendations' => $this->generateRecommendations(),
            'generated_at' => date('Y-m-d H:i:s')
        ];
    }
    
    /**
     * Generate herd insights
     */
    private function generateHerdInsights(): array
    {
        $insights = [];
        
        // User activity insights
        $currentOnline = $this->getCurrentlyOnline();
        $weeklyActive = $this->getActiveUsers(7);
        
        if ($weeklyActive > 0) {
            $engagementRate = ($currentOnline / $weeklyActive) * 100;
            $insights[] = [
                'type' => 'engagement',
                'message' => "Current engagement rate: {$engagementRate}% of weekly active users are online",
                'metric' => $engagementRate
            ];
        }
        
        // Growth insights
        $todayRegistrations = $this->getNewRegistrations(1);
        $weekRegistrations = $this->getNewRegistrations(7);
        
        if ($weekRegistrations > 0) {
            $dailyAverage = $weekRegistrations / 7;
            $growthTrend = $todayRegistrations > $dailyAverage ? 'growing' : 'stable';
            $insights[] = [
                'type' => 'growth',
                'message' => "Herd is {$growthTrend}. Today: {$todayRegistrations} new members, weekly average: " . round($dailyAverage, 1),
                'trend' => $growthTrend
            ];
        }
        
        return $insights;
    }
    
    /**
     * Generate recommendations
     */
    private function generateRecommendations(): array
    {
        $recommendations = [];
        
        // Security recommendations
        $failedAttempts = $this->getRecentFailedAttempts(60); // Last hour
        if ($failedAttempts > 10) {
            $recommendations[] = [
                'type' => 'security',
                'priority' => 'high',
                'message' => "High number of failed login attempts ({$failedAttempts}) in the last hour. Consider reviewing security measures."
            ];
        }
        
        // Performance recommendations
        $currentOnline = $this->getCurrentlyOnline();
        if ($currentOnline > 100) {
            $recommendations[] = [
                'type' => 'performance',
                'priority' => 'medium',
                'message' => "High concurrent users ({$currentOnline}). Monitor server performance and consider scaling."
            ];
        }
        
        return $recommendations;
    }
    
    /**
     * Calculate overall security score
     */
    private function calculateSecurityScore(): int
    {
        $score = 100;
        
        // Deduct points for recent security events
        $recentFailed = $this->getRecentFailedAttempts(60);
        $score -= min($recentFailed * 2, 30); // Max 30 point deduction
        
        // Deduct points for locked accounts
        $lockedAccounts = count($this->getLockedAccounts());
        $score -= min($lockedAccounts * 5, 20); // Max 20 point deduction
        
        return max($score, 0);
    }
    
    // Placeholder methods that would be implemented based on specific requirements
    private function getActiveSessions(): int { return $this->getTotalActiveSessions(); }
    private function getSessionsByLocation(): array { return []; }
    private function getAverageSessionDuration(): float { return 0.0; }
    private function getPeakConcurrentSessions(): int { return 0; }
    private function getRememberTokenUsage(): array { return []; }
    private function getGeographicDistribution(): array { return []; }
    private function getDevicePatterns(): array { return []; }
    private function getSessionPatterns(): array { return []; }
    private function getFailedAttempts(int $count, string $unit): int { return 0; }
    private function getLockedAccounts(): array { return []; }
    private function getSuspiciousActivity(): array { return []; }
    private function getPasswordResets(int $days): int { return 0; }
    private function getLoginFrequencyDistribution(): array { return []; }
    private function getSessionDurationPatterns(): array { return []; }
    private function getFeatureUsageStats(): array { return []; }
    private function getUserJourneyPatterns(): array { return []; }
    private function getRetentionMetrics(): array { return []; }
    private function getAuthenticationPerformance(): array { return []; }
    private function getSessionCreationPerformance(): array { return []; }
    private function getDatabasePerformance(): array { return []; }
    private function getResponseTimeMetrics(): array { return []; }
} 