<?php
/**
 * <?tusk> TuskPHP Satao - The Security Guardian
 * ============================================
 * 
 * 🐘 BACKSTORY: Satao - The Legendary Tusker
 * ------------------------------------------
 * Satao was one of Kenya's last great "tuskers" - elephants whose tusks were
 * so large they touched the ground. He lived in Tsavo East National Park and
 * was known for his incredible intelligence, often hiding his massive tusks
 * behind bushes when humans approached, aware that they made him a target.
 * Despite constant protection efforts, poachers killed him in 2014 for his ivory.
 * 
 * WHY THIS NAME: Satao spent his life evading poachers, developing an acute
 * awareness of threats and danger. This security system embodies Satao's
 * vigilance - constantly watching for "poachers" (hackers/attackers) trying
 * to steal what's valuable. Like Satao who could sense danger from miles away,
 * this system detects threats before they strike.
 * 
 * Satao's legacy lives on in this guardian that protects your application's
 * "ivory" - your precious data, user information, and system integrity.
 * 
 * FEATURES:
 * - Real-time threat detection and monitoring
 * - Intrusion prevention system (IPS)
 * - DDoS attack mitigation
 * - SQL injection and XSS prevention
 * - Brute force attack protection
 * - Security audit logging
 * - Automated threat response
 * 
 * "In memory of Satao - may his wisdom protect what cannot be replaced"
 * 
 * @package TuskPHP\Elephants
 * @author  TuskPHP Team
 * @since   1.0.0
 */

namespace TuskPHP\Elephants;

use TuskPHP\{Tusk, Memory, TuskDb, TuskSafe};

class Satao {
    
    private $threatLevel = 'low';
    private $detectedThreats = [];
    private $blockedIPs = [];
    private $alertThreshold = 5;
    private $emergencyMode = false;
    
    /**
     * Initialize Satao - The guardian awakens
     */
    public function __construct() {
        $this->loadSecurityConfig();
        $this->initializeThreatDatabase();
    }
    
    /**
     * Load security configuration from .peanuts
     */
    private function loadSecurityConfig() {
        // Try to load from .peanuts file first, then use defaults
        if (class_exists('TuskPHP\Elephants\Peanuts')) {
            $config = \TuskPHP\Elephants\Peanuts::getPeanutsEnv('security', []);
            $this->alertThreshold = $config['alert_threshold'] ?? 5;
            $this->emergencyMode = $config['emergency_mode'] ?? false;
        }
        
        // Fallback configuration for when .peanuts is not available
        if (empty($config)) {
            $this->alertThreshold = 5;
            $this->emergencyMode = false;
        }
    }
    
    /**
     * Initialize threat database
     */
    private function initializeThreatDatabase() {
        // Initialize basic threat patterns and blocked IPs
        $this->detectedThreats = [];
        $this->blockedIPs = Memory::recall('satao_blocked_ips') ?? [];
    }
    
    /**
     * Monitor for threats - Satao's eternal vigilance
     */
    public function monitor() {
        // Like Satao scanning the horizon for danger
        $threats = [
            'sql_injection' => $this->detectSQLInjection(),
            'xss_attempts' => $this->detectXSS(),
            'brute_force' => $this->detectBruteForce(),
            'ddos' => $this->detectDDoS(),
            'file_upload' => $this->detectMaliciousUploads(),
            'suspicious_activity' => $this->detectAnomalies()
        ];
        
        $this->assessThreatLevel($threats);
        $this->respondToThreats($threats);
    }
    
    /**
     * Detect SQL injection attempts - Poachers trying to steal data
     */
    private function detectSQLInjection() {
        $patterns = [
            '/union\s+select/i',
            '/drop\s+table/i',
            '/;\s*delete\s+from/i',
            '/or\s+1\s*=\s*1/i',
            '/\'\s*or\s*\'\s*\'/i'
        ];
        
        // Satao's wisdom: Check all inputs
        return $this->scanForPatterns($patterns);
    }
    
    /**
     * Emergency lockdown - When poachers are at the gates
     */
    public function emergencyLockdown($reason) {
        $this->emergencyMode = true;
        $this->threatLevel = 'critical';
        
        // Satao's final defense - hide everything valuable
        $this->blockAllAccess();
        $this->notifyAdministrators($reason);
        $this->enableMaximumLogging();
        
        Memory::remember('satao_emergency', [
            'time' => time(),
            'reason' => $reason,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ], 3600);
    }
    
    /**
     * Check if IP is trusted - Satao knew friend from foe
     */
    public function isTrusted($ip) {
        // Rangers who protected Satao
        $trustedRangers = $this->getTrustedIPs();
        
        return in_array($ip, $trustedRangers) && !in_array($ip, $this->blockedIPs);
    }
    
    /**
     * Block attacker - Satao's defensive charge
     */
    public function blockAttacker($ip, $reason) {
        $this->blockedIPs[] = $ip;
        
        Memory::remember("satao_blocked_{$ip}", [
            'time' => time(),
            'reason' => $reason,
            'attempts' => $this->getAttemptCount($ip)
        ], 86400);
        
        // Like Satao's trumpet warning the herd
        $this->logSecurityEvent('ip_blocked', $ip, $reason);
    }
    
    /**
     * Security audit - Learning from every encounter
     */
    public function audit() {
        return [
            'threat_level' => $this->threatLevel,
            'active_threats' => count($this->detectedThreats),
            'blocked_ips' => count($this->blockedIPs),
            'emergency_mode' => $this->emergencyMode,
            'last_attack' => $this->getLastAttackTime(),
            'protection_status' => $this->getProtectionStatus()
        ];
    }
    
    /**
     * Assess overall threat level - Satao's intuition
     */
    private function assessThreatLevel($threats) {
        $activeThreats = array_filter($threats);
        $threatCount = count($activeThreats);
        
        if ($threatCount === 0) {
            $this->threatLevel = 'low';
        } elseif ($threatCount <= 2) {
            $this->threatLevel = 'medium';
        } elseif ($threatCount <= 4) {
            $this->threatLevel = 'high';
        } else {
            $this->threatLevel = 'critical';
            // Satao's wisdom: When surrounded, call for help
            $this->emergencyLockdown('Multiple simultaneous threats detected');
        }
    }
    
    /**
     * Get threat intelligence - Shared knowledge saves lives
     */
    public function getThreatIntelligence() {
        // Like rangers sharing poacher movements
        return [
            'known_attackers' => $this->getKnownAttackers(),
            'attack_patterns' => $this->getAttackPatterns(),
            'vulnerabilities' => $this->getKnownVulnerabilities(),
            'recommendations' => $this->getSecurityRecommendations()
        ];
    }
    
    /**
     * Simple scan method for basic security checking
     */
    public function scan($server = [], $get = [], $post = []) {
        // Basic security scan - always return safe for now
        // This can be enhanced later with real threat detection
        return [
            'safe' => true,
            'threat_level' => 'low',
            'threats' => []
        ];
    }
    
    /**
     * Handle security threats
     */
    public static function handleThreat($securityCheck) {
        // Basic threat handling
        if (!$securityCheck['safe']) {
            http_response_code(403);
            echo "Access Denied - Security threat detected";
            exit;
        }
    }
    
    /**
     * Detect XSS attempts - Script injections trying to poison the watering hole
     */
    private function detectXSS() {
        $xssPatterns = [
            '/<script[^>]*>.*?<\/script>/is',
            '/javascript:/i',
            '/on\w+\s*=/i',
            '/<iframe/i',
            '/<embed/i',
            '/<object/i',
            '/document\.(cookie|write)/i',
            '/window\.(location|open)/i',
            '/<svg.*?onload=/is'
        ];
        
        $detected = false;
        $inputs = array_merge($_GET ?? [], $_POST ?? [], $_COOKIE ?? []);
        
        foreach ($inputs as $key => $value) {
            if (is_string($value)) {
                foreach ($xssPatterns as $pattern) {
                    if (preg_match($pattern, $value)) {
                        $this->detectedThreats[] = [
                            'type' => 'xss',
                            'pattern' => $pattern,
                            'input' => $key,
                            'value' => substr($value, 0, 100),
                            'time' => time()
                        ];
                        $detected = true;
                    }
                }
            }
        }
        
        return $detected;
    }
    
    /**
     * Detect brute force attempts - Relentless poachers trying every path
     */
    private function detectBruteForce() {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $attemptKey = "satao_attempts_{$ip}";
        $timeWindowKey = "satao_window_{$ip}";
        
        // Track login attempts in 5-minute windows
        $attempts = Memory::recall($attemptKey) ?? 0;
        $windowStart = Memory::recall($timeWindowKey) ?? time();
        
        // Reset window if more than 5 minutes passed
        if (time() - $windowStart > 300) {
            $attempts = 0;
            $windowStart = time();
            Memory::remember($timeWindowKey, $windowStart, 300);
        }
        
        // Check for login-related endpoints
        $loginEndpoints = ['/login', '/api/login', '/admin', '/wp-login'];
        $currentPath = $_SERVER['REQUEST_URI'] ?? '';
        
        foreach ($loginEndpoints as $endpoint) {
            if (strpos($currentPath, $endpoint) !== false) {
                $attempts++;
                Memory::remember($attemptKey, $attempts, 300);
                
                // More than 5 attempts in 5 minutes = brute force
                if ($attempts > 5) {
                    $this->detectedThreats[] = [
                        'type' => 'brute_force',
                        'ip' => $ip,
                        'attempts' => $attempts,
                        'endpoint' => $currentPath,
                        'time' => time()
                    ];
                    return true;
                }
            }
        }
        
        return false;
    }
    
    /**
     * Detect DDoS attempts - The stampede attack
     */
    private function detectDDoS() {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $rateKey = "satao_rate_{$ip}";
        
        // Track requests per second
        $requests = Memory::recall($rateKey) ?? [];
        $now = time();
        
        // Add current request
        $requests[] = $now;
        
        // Keep only requests from last 10 seconds
        $requests = array_filter($requests, function($timestamp) use ($now) {
            return ($now - $timestamp) < 10;
        });
        
        Memory::remember($rateKey, $requests, 10);
        
        // More than 50 requests in 10 seconds = potential DDoS
        if (count($requests) > 50) {
            $this->detectedThreats[] = [
                'type' => 'ddos',
                'ip' => $ip,
                'requests_per_10s' => count($requests),
                'time' => $now
            ];
            return true;
        }
        
        return false;
    }
    
    /**
     * Detect malicious file uploads - Trojan elephants at the gates
     */
    private function detectMaliciousUploads() {
        if (empty($_FILES)) {
            return false;
        }
        
        $detected = false;
        $dangerousExtensions = [
            'php', 'php3', 'php4', 'php5', 'phtml', 'phar',
            'exe', 'bat', 'cmd', 'sh', 'cgi', 'htaccess',
            'py', 'pl', 'asp', 'aspx', 'jsp', 'jspx'
        ];
        
        $dangerousMimeTypes = [
            'application/x-httpd-php',
            'application/x-php',
            'application/x-executable',
            'application/x-shellscript'
        ];
        
        foreach ($_FILES as $file) {
            if (!isset($file['name']) || !isset($file['tmp_name'])) {
                continue;
            }
            
            // Check file extension
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (in_array($extension, $dangerousExtensions)) {
                $detected = true;
            }
            
            // Check MIME type
            if (isset($file['type']) && in_array($file['type'], $dangerousMimeTypes)) {
                $detected = true;
            }
            
            // Check file content for PHP tags
            if (file_exists($file['tmp_name'])) {
                $content = file_get_contents($file['tmp_name'], false, null, 0, 1024);
                if (strpos($content, '<?php') !== false || strpos($content, '<?=') !== false) {
                    $detected = true;
                }
            }
            
            if ($detected) {
                $this->detectedThreats[] = [
                    'type' => 'malicious_upload',
                    'filename' => $file['name'],
                    'extension' => $extension,
                    'mime_type' => $file['type'] ?? 'unknown',
                    'time' => time()
                ];
            }
        }
        
        return $detected;
    }
    
    /**
     * Detect anomalies - Satao's sixth sense for danger
     */
    private function detectAnomalies() {
        $anomalies = [];
        
        // Check for suspicious user agents
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $suspiciousAgents = [
            'sqlmap', 'nikto', 'scanner', 'nessus', 'havij',
            'acunetix', 'nmap', 'grab', 'harvest', 'bot'
        ];
        
        foreach ($suspiciousAgents as $agent) {
            if (stripos($userAgent, $agent) !== false) {
                $anomalies[] = 'suspicious_user_agent';
                break;
            }
        }
        
        // Check for missing or suspicious headers
        if (empty($_SERVER['HTTP_USER_AGENT'])) {
            $anomalies[] = 'missing_user_agent';
        }
        
        // Check for direct access to sensitive files
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        $sensitivePatterns = [
            '/\\.env/', '/\\.git/', '/\\.peanuts/', '/\\.shell/',
            '/wp-config/', '/config\\.php/', '/database\\.php/'
        ];
        
        foreach ($sensitivePatterns as $pattern) {
            if (preg_match($pattern, $uri)) {
                $anomalies[] = 'sensitive_file_access';
                break;
            }
        }
        
        // Check for unusual request methods
        $method = $_SERVER['REQUEST_METHOD'] ?? '';
        if (!in_array($method, ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'HEAD', 'OPTIONS'])) {
            $anomalies[] = 'unusual_request_method';
        }
        
        if (!empty($anomalies)) {
            $this->detectedThreats[] = [
                'type' => 'anomaly',
                'anomalies' => $anomalies,
                'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
                'time' => time()
            ];
            return true;
        }
        
        return false;
    }
    
    /**
     * Scan for threat patterns - Satao's pattern recognition
     */
    private function scanForPatterns($patterns) {
        $inputs = array_merge(
            $_GET ?? [],
            $_POST ?? [],
            $_COOKIE ?? [],
            getallheaders() ?: []
        );
        
        $detected = false;
        
        foreach ($inputs as $key => $value) {
            if (!is_string($value)) {
                continue;
            }
            
            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $value)) {
                    $this->detectedThreats[] = [
                        'type' => 'pattern_match',
                        'pattern' => $pattern,
                        'location' => $key,
                        'value' => substr($value, 0, 100),
                        'time' => time()
                    ];
                    $detected = true;
                }
            }
        }
        
        return $detected;
    }
    
    /**
     * Respond to detected threats - Satao's defensive actions
     */
    private function respondToThreats($threats) {
        $activeThreats = array_filter($threats);
        
        if (empty($activeThreats)) {
            return;
        }
        
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        
        // Different responses based on threat type
        foreach ($activeThreats as $threatType => $detected) {
            if (!$detected) continue;
            
            switch ($threatType) {
                case 'sql_injection':
                case 'xss_attempts':
                    // Immediate block for injection attempts
                    $this->blockAttacker($ip, "Detected {$threatType}");
                    break;
                    
                case 'brute_force':
                    // Temporary block with increasing duration
                    $blockDuration = $this->getAttemptCount($ip) * 3600; // 1hr per attempt
                    Memory::remember("satao_tempblock_{$ip}", true, $blockDuration);
                    break;
                    
                case 'ddos':
                    // Rate limiting
                    $this->enableRateLimiting($ip);
                    break;
                    
                case 'file_upload':
                    // Log and reject
                    $this->logSecurityEvent('malicious_upload_blocked', $ip, 'Dangerous file detected');
                    break;
            }
        }
        
        // Alert admins if threat level is high
        if ($this->threatLevel === 'high' || $this->threatLevel === 'critical') {
            $this->notifyAdministrators("High threat level detected: {$this->threatLevel}");
        }
    }
    
    /**
     * Block all access - Emergency shutdown
     */
    private function blockAllAccess() {
        // Set emergency headers
        header('HTTP/1.1 503 Service Unavailable');
        header('Retry-After: 3600');
        
        // Create emergency lockfile
        $lockFile = '/tmp/satao_emergency_lock';
        file_put_contents($lockFile, json_encode([
            'time' => time(),
            'reason' => 'Emergency lockdown activated',
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ]));
        
        // Clear all sessions
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
    
    /**
     * Notify administrators - Sound the alarm
     */
    private function notifyAdministrators($reason) {
        $admins = Memory::recall('satao_admin_contacts') ?? [];
        
        // Log critical security event
        error_log("[SATAO CRITICAL] {$reason}");
        
        // If we have email capability, send alerts
        if (class_exists('TuskPHP\\Mail\\TuskMail')) {
            foreach ($admins as $admin) {
                // Queue email notification
                Memory::remember('satao_notify_queue', [
                    'to' => $admin['email'],
                    'subject' => 'CRITICAL: TuskPHP Security Alert',
                    'message' => $reason,
                    'time' => time()
                ], 3600);
            }
        }
        
        // Also store in database if available
        if (class_exists('TuskPHP\\TuskDb')) {
            TuskDb::table('security_alerts')->insert([
                'level' => 'critical',
                'reason' => $reason,
                'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
    
    /**
     * Enable maximum logging - Record everything
     */
    private function enableMaximumLogging() {
        // Set PHP to log everything
        ini_set('log_errors', '1');
        ini_set('error_reporting', E_ALL);
        
        // Enable detailed request logging
        $logData = [
            'time' => date('Y-m-d H:i:s'),
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'method' => $_SERVER['REQUEST_METHOD'] ?? '',
            'uri' => $_SERVER['REQUEST_URI'] ?? '',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'referrer' => $_SERVER['HTTP_REFERER'] ?? '',
            'post_data' => $_POST,
            'get_data' => $_GET,
            'headers' => getallheaders() ?: []
        ];
        
        $logFile = '/var/log/satao_emergency_' . date('Y-m-d') . '.log';
        file_put_contents($logFile, json_encode($logData) . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
    
    /**
     * Get trusted IPs - The rangers who protect
     */
    private function getTrustedIPs() {
        // Load from configuration or memory
        $trusted = Memory::recall('satao_trusted_ips') ?? [];
        
        // Add localhost and private networks by default
        $defaults = [
            '127.0.0.1',
            '::1',
            '10.0.0.0/8',
            '172.16.0.0/12',
            '192.168.0.0/16'
        ];
        
        return array_merge($defaults, $trusted);
    }
    
    /**
     * Get attempt count for an IP
     */
    private function getAttemptCount($ip) {
        $attempts = Memory::recall("satao_attempts_{$ip}") ?? 0;
        return (int) $attempts;
    }
    
    /**
     * Log security event - Satao's memory never forgets
     */
    private function logSecurityEvent($type, $ip, $reason) {
        $event = [
            'type' => $type,
            'ip' => $ip,
            'reason' => $reason,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'uri' => $_SERVER['REQUEST_URI'] ?? 'unknown',
            'time' => time(),
            'threat_level' => $this->threatLevel
        ];
        
        // Store in memory for quick access
        $events = Memory::recall('satao_security_events') ?? [];
        $events[] = $event;
        
        // Keep only last 1000 events in memory
        if (count($events) > 1000) {
            $events = array_slice($events, -1000);
        }
        
        Memory::remember('satao_security_events', $events, 86400);
        
        // Also log to file
        $logFile = '/var/log/satao_security_' . date('Y-m-d') . '.log';
        file_put_contents($logFile, json_encode($event) . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
    
    /**
     * Get last attack time
     */
    private function getLastAttackTime() {
        $events = Memory::recall('satao_security_events') ?? [];
        if (empty($events)) {
            return null;
        }
        
        $lastEvent = end($events);
        return $lastEvent['time'] ?? null;
    }
    
    /**
     * Get protection status - Satao's current state
     */
    private function getProtectionStatus() {
        if ($this->emergencyMode) {
            return 'emergency_lockdown';
        }
        
        switch ($this->threatLevel) {
            case 'critical':
                return 'maximum_alert';
            case 'high':
                return 'heightened_security';
            case 'medium':
                return 'elevated_watch';
            default:
                return 'active_monitoring';
        }
    }
    
    /**
     * Get known attackers from threat intelligence
     */
    private function getKnownAttackers() {
        $attackers = Memory::recall('satao_known_attackers') ?? [];
        
        // Add recently blocked IPs
        foreach ($this->blockedIPs as $ip) {
            $attackers[$ip] = [
                'ip' => $ip,
                'first_seen' => Memory::recall("satao_first_seen_{$ip}") ?? time(),
                'attacks' => $this->getAttemptCount($ip),
                'status' => 'blocked'
            ];
        }
        
        return $attackers;
    }
    
    /**
     * Get common attack patterns
     */
    private function getAttackPatterns() {
        return [
            'sql_injection' => [
                'patterns' => [
                    'union select', 'drop table', 'or 1=1',
                    'exec xp_', 'INFORMATION_SCHEMA'
                ],
                'severity' => 'critical',
                'response' => 'immediate_block'
            ],
            'xss' => [
                'patterns' => [
                    '<script', 'javascript:', 'onerror=',
                    'onload=', '<iframe'
                ],
                'severity' => 'high',
                'response' => 'sanitize_and_block'
            ],
            'path_traversal' => [
                'patterns' => [
                    '../', '..\\', '%2e%2e/', 
                    '/etc/passwd', 'C:\\Windows'
                ],
                'severity' => 'high',
                'response' => 'block_request'
            ]
        ];
    }
    
    /**
     * Get known vulnerabilities
     */
    private function getKnownVulnerabilities() {
        // Check for common misconfigurations
        $vulnerabilities = [];
        
        // Check if debug mode is on
        if (ini_get('display_errors') == '1') {
            $vulnerabilities[] = [
                'type' => 'configuration',
                'issue' => 'Debug mode enabled in production',
                'severity' => 'medium',
                'fix' => 'Set display_errors = Off in php.ini'
            ];
        }
        
        // Check file permissions
        if (is_writable('/var/www')) {
            $vulnerabilities[] = [
                'type' => 'permissions',
                'issue' => 'Web directory is writable',
                'severity' => 'high',
                'fix' => 'Set proper file permissions (755 for directories, 644 for files)'
            ];
        }
        
        return $vulnerabilities;
    }
    
    /**
     * Get security recommendations - Satao's wisdom
     */
    private function getSecurityRecommendations() {
        $recommendations = [
            'Use HTTPS for all connections',
            'Enable Content Security Policy (CSP) headers',
            'Implement rate limiting on all endpoints',
            'Regular security audits and penetration testing',
            'Keep all software and dependencies updated',
            'Use prepared statements for all database queries',
            'Implement proper session management',
            'Enable two-factor authentication for admin accounts',
            'Regular backup and disaster recovery testing',
            'Monitor and analyze security logs regularly'
        ];
        
        // Add specific recommendations based on current threats
        if ($this->threatLevel === 'high' || $this->threatLevel === 'critical') {
            array_unshift($recommendations, 
                'URGENT: Address current ' . $this->threatLevel . ' threat level',
                'Review recent security events in the audit log',
                'Consider enabling emergency lockdown mode'
            );
        }
        
        return $recommendations;
    }
    
    /**
     * Enable rate limiting for an IP
     */
    private function enableRateLimiting($ip) {
        Memory::remember("satao_ratelimit_{$ip}", [
            'enabled' => true,
            'requests_per_minute' => 10,
            'started' => time()
        ], 3600);
    }
} 