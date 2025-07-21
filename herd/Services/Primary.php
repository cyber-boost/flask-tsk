<?php
/**
 * <?tusk> TuskPHP Herd Primary Authentication Service
 * ==================================================
 * "The alpha elephant leads the herd"
 * Core login/logout functionality with elephant wisdom
 * Strong. Secure. Scalable. 🐘
 */

namespace TuskPHP\Herd\Services;

use TuskPHP\{TuskDb, Memory, TuskObject};
use TuskPHP\Herd\Events\{LoginEvent, LogoutEvent, LockEvent};
use TuskPHP\App\Class\{Stomp, Trunk};

class Primary
{
    private const MAX_LOGIN_ATTEMPTS = 5;
    private const LOCKOUT_DURATION = 900; // 15 minutes
    private const REMEMBER_DURATION = 2592000; // 30 days
    
    /**
     * Attempt login with credentials
     */
    public function attemptLogin(string $email, string $password, bool $remember = false): bool
    {
        // Check if account is locked
        if ($this->isAccountLocked($email)) {
            $this->logFailedAttempt($email, 'Account locked');
            return false;
        }
        
        // Get user from database using TuskDb
        $user = $this->getUserByEmail($email);
        if (!$user) {
            $this->logFailedAttempt($email, 'User not found');
            $this->incrementFailedAttempts($email);
            return false;
        }
        
        // Verify password
        if (!$this->verifyPassword($password, $user['password_hash'])) {
            $this->logFailedAttempt($email, 'Invalid password');
            $this->incrementFailedAttempts($email);
            return false;
        }
        
        // Check if user is active
        if (!$this->isUserActive($user)) {
            $this->logFailedAttempt($email, 'User inactive');
            return false;
        }
        
        // Successful login - reset failed attempts
        $this->resetFailedAttempts($email);
        
        // Create session
        $this->createUserSession($user, $remember);
        
        // Log successful login
        $this->logSuccessfulLogin($user);
        
        // Send login notification email
        $this->sendLoginNotification($user);
        
        // Fire login event
        $this->fireLoginEvent($user);
        
        // Update last login time using TuskDb
        TuskDb::remember('users', [
            'last_login_at' => date('Y-m-d H:i:s'),
            'last_login_ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ], ['id' => $user['id']]);
        
        return true;
    }
    
    /**
     * One-time authentication without session
     */
    public function attemptOnce(array $credentials): bool
    {
        $email = $credentials['email'] ?? '';
        $password = $credentials['password'] ?? '';
        
        if (!$email || !$password) {
            return false;
        }
        
        $user = $this->getUserByEmail($email);
        if (!$user || !$this->verifyPassword($password, $user['password_hash'])) {
            return false;
        }
        
        // Don't create session, just verify credentials
        return $this->isUserActive($user);
    }
    
    /**
     * Perform logout
     */
    public function performLogout(): bool
    {
        $user = $this->getCurrentUser();
        
        if (!$user) {
            return false;
        }
        
        // Log logout event
        $this->logSuccessfulLogout($user);
        
        // Fire logout event
        $this->fireLogoutEvent($user);
        
        // Destroy session data
        $this->destroyUserSession();
        
        // Clear remember token if exists
        $this->clearRememberToken($user['id']);
        
        return true;
    }
    
    /**
     * Get current authenticated user
     */
    public function getCurrentUser(): ?array
    {
        // Check Memory cache first
        $cachedUser = Memory::recall('herd_current_user');
        if ($cachedUser) {
            return $cachedUser;
        }
        
        // Check session
        $userId = $_SESSION['herd_user_id'] ?? null;
        if (!$userId) {
            // Check remember token
            $userId = $this->getUserFromRememberToken();
        }
        
        if (!$userId) {
            return null;
        }
        
        // Get user from database
        $user = $this->getUserById($userId);
        if ($user && $this->isUserActive($user)) {
            // Cache in Memory
            Memory::remember('herd_current_user', $user, 1800);
            return $user;
        }
        
        return null;
    }
    
    /**
     * Get user by email using TuskDb
     */
    private function getUserByEmail(string $email): ?array
    {
        $users = TuskDb::recall('users', ['email' => $email], ['limit' => 1]);
        return $users[0] ?? null;
    }
    
    /**
     * Get user by ID using TuskDb
     */
    private function getUserById(int $id): ?array
    {
        $users = TuskDb::recall('users', ['id' => $id], ['limit' => 1]);
        return $users[0] ?? null;
    }
    
    /**
     * Verify password hash
     */
    private function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
    
    /**
     * Check if user is active
     */
    private function isUserActive(array $user): bool
    {
        return ($user['is_active'] ?? true) && 
               ($user['deleted_at'] ?? null) === null &&
               ($user['is_verified'] ?? false);
    }
    
    /**
     * Check if account is locked
     */
    private function isAccountLocked(string $email): bool
    {
        $lockKey = "herd_lock_{$email}";
        $lockData = Memory::recall($lockKey);
        
        if (!$lockData) {
            return false;
        }
        
        // Check if lock has expired
        if (time() > $lockData['expires_at']) {
            Memory::forget($lockKey);
            return false;
        }
        
        return true;
    }
    
    /**
     * Increment failed login attempts
     */
    private function incrementFailedAttempts(string $email): void
    {
        $attemptKey = "herd_attempts_{$email}";
        $attempts = Memory::recall($attemptKey) ?? 0;
        $attempts++;
        
        Memory::remember($attemptKey, $attempts, 3600); // 1 hour
        
        // Lock account if max attempts reached
        if ($attempts >= self::MAX_LOGIN_ATTEMPTS) {
            $this->lockAccount($email);
        }
    }
    
    /**
     * Reset failed login attempts
     */
    private function resetFailedAttempts(string $email): void
    {
        $attemptKey = "herd_attempts_{$email}";
        Memory::forget($attemptKey);
        
        $lockKey = "herd_lock_{$email}";
        Memory::forget($lockKey);
    }
    
    /**
     * Lock user account
     */
    private function lockAccount(string $email): void
    {
        $lockKey = "herd_lock_{$email}";
        $lockData = [
            'locked_at' => time(),
            'expires_at' => time() + self::LOCKOUT_DURATION,
            'reason' => 'Too many failed login attempts'
        ];
        
        Memory::remember($lockKey, $lockData, self::LOCKOUT_DURATION);
        
        // Fire lock event
        $this->fireLockEvent($email, $lockData);
        
        // Log lock event
        $this->logAccountLock($email);
    }
    
    /**
     * Create user session and track with analytics
     */
    private function createUserSession(array $user, bool $remember = false): void
    {
        session_regenerate_id(true);
        
        $_SESSION['herd_authenticated'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['login_time'] = time();
        $_SESSION['session_id'] = session_id();
        
        // Track login with HerdManager for detailed analytics
        $herdManager = new HerdManager();
        $herdManager->trackLogin($user, [
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'remember_me' => $remember,
            'session_id' => session_id(),
            'login_method' => 'standard'
        ]);
        
        if ($remember) {
            $this->createRememberToken($user['id']);
        }
        
        $this->incrementActiveSessionCount();
        
        // Store user in Memory for quick access
        Memory::remember("herd_user_{$user['id']}", $user, 1800);
    }
    
    /**
     * Destroy user session
     */
    private function destroyUserSession(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            // Clear herd-specific session data
            unset($_SESSION['herd_user_id']);
            unset($_SESSION['herd_guard']);
            unset($_SESSION['herd_login_time']);
            
            // Destroy session if no other data exists
            if (empty($_SESSION)) {
                session_destroy();
            }
        }
        
        // Decrement active session count
        $this->decrementActiveSessionCount();
    }
    
    /**
     * Create remember token
     */
    private function createRememberToken(int $userId): void
    {
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', time() + self::REMEMBER_DURATION);
        
        // Store in database using TuskDb
        TuskDb::remember('user_remember_tokens', [
            'user_id' => $userId,
            'token' => hash('sha256', $token),
            'expires_at' => $expiresAt,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        // Set cookie
        setcookie('herd_remember', $token, time() + self::REMEMBER_DURATION, '/', '', false, true);
    }
    
    /**
     * Clear remember token
     */
    private function clearRememberToken(int $userId): void
    {
        // Remove from database
        TuskDb::forget('user_remember_tokens', ['user_id' => $userId]);
        
        // Clear cookie
        setcookie('herd_remember', '', time() - 3600, '/', '', false, true);
    }
    
    /**
     * Get user from remember token
     */
    private function getUserFromRememberToken(): ?int
    {
        $token = $_COOKIE['herd_remember'] ?? null;
        if (!$token) {
            return null;
        }
        
        $hashedToken = hash('sha256', $token);
        
        // Find token in database
        $tokens = TuskDb::recall('user_remember_tokens', [
            'token' => $hashedToken
        ], ['limit' => 1]);
        
        $tokenData = $tokens[0] ?? null;
        if (!$tokenData) {
            return null;
        }
        
        // Check if token is expired
        if (strtotime($tokenData['expires_at']) < time()) {
            TuskDb::forget('user_remember_tokens', ['id' => $tokenData['id']]);
            return null;
        }
        
        return $tokenData['user_id'];
    }
    
    /**
     * Fire login event
     */
    private function fireLoginEvent(array $user): void
    {
        $event = new LoginEvent($user);
        
        // Notify via Trunk if available
        if (class_exists('TuskPHP\App\Class\Trunk')) {
            $trunk = new Trunk();
            $trunk->send([
                'event' => 'user_login',
                'user_id' => $user['id'],
                'timestamp' => time()
            ], 'herd_events');
        }
    }
    
    /**
     * Fire logout event
     */
    private function fireLogoutEvent(array $user): void
    {
        $event = new LogoutEvent($user);
        
        // Notify via Trunk if available
        if (class_exists('TuskPHP\App\Class\Trunk')) {
            $trunk = new Trunk();
            $trunk->send([
                'event' => 'user_logout',
                'user_id' => $user['id'],
                'timestamp' => time()
            ], 'herd_events');
        }
    }
    
    /**
     * Fire lock event
     */
    private function fireLockEvent(string $email, array $lockData): void
    {
        $event = new LockEvent($email, $lockData);
        
        // Notify via Trunk if available
        if (class_exists('TuskPHP\App\Class\Trunk')) {
            $trunk = new Trunk();
            $trunk->send([
                'event' => 'account_locked',
                'email' => $email,
                'lock_data' => $lockData,
                'timestamp' => time()
            ], 'herd_security');
        }
    }
    
    /**
     * Track active session count
     */
    private function incrementActiveSessionCount(): void
    {
        $count = Memory::recall('active_sessions_count') ?? 0;
        Memory::remember('active_sessions_count', $count + 1, 3600);
    }
    
    /**
     * Decrement active session count
     */
    private function decrementActiveSessionCount(): void
    {
        $count = Memory::recall('active_sessions_count') ?? 0;
        $count = max(0, $count - 1);
        Memory::remember('active_sessions_count', $count, 3600);
    }
    
    /**
     * Log successful login
     */
    private function logSuccessfulLogin(array $user): void
    {
        $this->logAuthEvent('login_success', $user['id'], [
            'email' => $user['email'],
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
        ]);
    }
    
    /**
     * Log successful logout
     */
    private function logSuccessfulLogout(array $user): void
    {
        $this->logAuthEvent('logout_success', $user['id'], [
            'email' => $user['email'],
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ]);
    }
    
    /**
     * Log failed login attempt
     */
    private function logFailedAttempt(string $email, string $reason): void
    {
        $this->logAuthEvent('login_failed', null, [
            'email' => $email,
            'reason' => $reason,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
        ]);
    }
    
    /**
     * Log account lock
     */
    private function logAccountLock(string $email): void
    {
        $this->logAuthEvent('account_locked', null, [
            'email' => $email,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ]);
    }
    
    /**
     * Log authentication event
     */
    private function logAuthEvent(string $type, ?int $userId, array $data): void
    {
        TuskDb::remember('herd_auth_logs', [
            'type' => $type,
            'user_id' => $userId,
            'data' => json_encode($data),
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * Send login notification email using TuskMail
     */
    private function sendLoginNotification(array $user): void
    {
        try {
            // Load TuskMail
            require_once __DIR__ . '/../../Mail/TuskMailHelper.php';
            
            $subject = '🐘 New Login to Your Account';
            $loginTime = date('F j, Y \a\t g:i A T');
            $ipAddress = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
            $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
            
            $body = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;'>
                <h2 style='color: #333; border-bottom: 3px solid #007cba; padding-bottom: 10px;'>
                    🐘 Herd Login Notification
                </h2>
                <p>Hello {$user['name']},</p>
                <p>We wanted to let you know that your account was accessed on <strong>{$loginTime}</strong>.</p>
                
                <div style='background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 20px 0;'>
                    <h3 style='margin-top: 0; color: #495057;'>Login Details:</h3>
                    <ul style='list-style: none; padding: 0;'>
                        <li style='margin: 8px 0;'><strong>Time:</strong> {$loginTime}</li>
                        <li style='margin: 8px 0;'><strong>IP Address:</strong> {$ipAddress}</li>
                        <li style='margin: 8px 0;'><strong>Device:</strong> " . $this->parseUserAgent($userAgent) . "</li>
                    </ul>
                </div>
                
                <p>If this was you, no further action is needed. If you don't recognize this login, please secure your account immediately.</p>
                
                <div style='margin: 30px 0; padding: 20px; background: #d4edda; border-radius: 8px; border-left: 4px solid #28a745;'>
                    <p style='margin: 0; color: #155724;'>
                        <strong>🛡️ Security Tip:</strong> The herd protects its own. Always use strong, unique passwords and enable two-factor authentication when available.
                    </p>
                </div>
                
                <p style='color: #6c757d; font-size: 14px; margin-top: 30px;'>
                    This notification was sent by the Herd authentication system.<br>
                    Powered by TuskPHP 🐘 - Strong. Secure. Scalable.
                </p>
            </div>";
            
            \TuskMailHelper::send(
                $user['email'],
                $subject,
                $body,
                $user['name'],
                'security_notification'
            );
            
        } catch (Exception $e) {
            error_log("Herd login notification failed: " . $e->getMessage());
        }
    }
    
    /**
     * Parse user agent for friendly display
     */
    private function parseUserAgent(string $userAgent): string
    {
        if (strpos($userAgent, 'Chrome') !== false) {
            return 'Chrome Browser';
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            return 'Firefox Browser';
        } elseif (strpos($userAgent, 'Safari') !== false) {
            return 'Safari Browser';
        } elseif (strpos($userAgent, 'Edge') !== false) {
            return 'Microsoft Edge';
        } else {
            return 'Unknown Browser';
        }
    }
} 