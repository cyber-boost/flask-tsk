<?php
/**
 * <?tusk> TuskPHP Herd Password Service
 * ===================================
 * "The herd remembers the way home"
 * Password reset and management with elephant wisdom
 * Strong. Secure. Scalable. 🐘
 */

namespace TuskPHP\Herd\Services;

use TuskPHP\{TuskDb, Memory, TuskObject};
use TuskPHP\Herd\Events\{PasswordResetEvent, PasswordChangedEvent};
use TuskPHP\App\Class\{Stomp, Trunk};

class Password
{
    private const RESET_TOKEN_LIFETIME = 3600; // 1 hour
    private const PASSWORD_HISTORY_LIMIT = 5; // Remember last 5 passwords
    private const PASSWORD_MIN_LENGTH = 8;
    
    /**
     * Request password reset
     */
    public function requestReset(string $email): array
    {
        $user = $this->getUserByEmail($email);
        if (!$user) {
            // Return success even if user doesn't exist (security)
            return [
                'success' => true,
                'message' => 'If the email exists, a reset link has been sent.'
            ];
        }
        
        // Check if user is active
        if (!$this->isUserActive($user)) {
            return [
                'success' => false,
                'message' => 'Account is not active'
            ];
        }
        
        // Generate reset token
        $token = $this->generateResetToken();
        $expiresAt = date('Y-m-d H:i:s', time() + self::RESET_TOKEN_LIFETIME);
        
        // Store token in database
        TuskDb::remember('password_reset_tokens', [
            'user_id' => $user['id'],
            'token' => hash('sha256', $token),
            'expires_at' => $expiresAt,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        // Send reset email
        $this->sendResetEmail($user, $token);
        
        // Log reset request
        $this->logPasswordResetRequest($user);
        
        // Fire password reset event
        $this->firePasswordResetEvent($user, $token);
        
        return [
            'success' => true,
            'message' => 'If the email exists, a reset link has been sent.'
        ];
    }
    
    /**
     * Validate reset token
     */
    public function validateResetToken(string $token): array
    {
        $hashedToken = hash('sha256', $token);
        
        // Find token in database
        $tokens = TuskDb::recall('password_reset_tokens', [
            'token' => $hashedToken
        ], ['limit' => 1]);
        
        $tokenData = $tokens[0] ?? null;
        if (!$tokenData) {
            return [
                'valid' => false,
                'message' => 'Invalid reset token'
            ];
        }
        
        // Check if token has expired
        if (strtotime($tokenData['expires_at']) < time()) {
            // Clean up expired token
            TuskDb::forget('password_reset_tokens', ['id' => $tokenData['id']]);
            
            return [
                'valid' => false,
                'message' => 'Reset token has expired'
            ];
        }
        
        // Get user data
        $user = $this->getUserById($tokenData['user_id']);
        if (!$user || !$this->isUserActive($user)) {
            return [
                'valid' => false,
                'message' => 'Invalid user account'
            ];
        }
        
        return [
            'valid' => true,
            'user_id' => $tokenData['user_id'],
            'email' => $user['email']
        ];
    }
    
    /**
     * Reset password with token
     */
    public function resetPassword(string $token, string $newPassword): array
    {
        // Validate token first
        $tokenValidation = $this->validateResetToken($token);
        if (!$tokenValidation['valid']) {
            return [
                'success' => false,
                'message' => $tokenValidation['message']
            ];
        }
        
        $userId = $tokenValidation['user_id'];
        
        // Validate new password
        $passwordValidation = $this->validatePassword($newPassword);
        if (!$passwordValidation['valid']) {
            return [
                'success' => false,
                'errors' => ['password' => $passwordValidation['message']]
            ];
        }
        
        // Check password history
        if ($this->isPasswordInHistory($userId, $newPassword)) {
            return [
                'success' => false,
                'errors' => ['password' => 'Cannot reuse a recent password']
            ];
        }
        
        // Hash new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        // Update user password
        TuskDb::remember('users', [
            'password_hash' => $hashedPassword,
            'password_changed_at' => date('Y-m-d H:i:s'),
            'force_password_change' => false,
            'updated_at' => date('Y-m-d H:i:s')
        ], ['id' => $userId]);
        
        // Store in password history
        $this->addToPasswordHistory($userId, $hashedPassword);
        
        // Clean up all reset tokens for this user
        TuskDb::forget('password_reset_tokens', ['user_id' => $userId]);
        
        // Get user data for logging
        $user = $this->getUserById($userId);
        
        // Log password change
        $this->logPasswordChange($user, 'reset');
        
        // Fire password changed event
        $this->firePasswordChangedEvent($user, 'reset');
        
        return [
            'success' => true,
            'message' => 'Password has been reset successfully'
        ];
    }
    
    /**
     * Update password for logged-in user
     */
    public function updatePassword(int $userId, string $currentPassword, string $newPassword): array
    {
        $user = $this->getUserById($userId);
        if (!$user) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }
        
        // Verify current password
        if (!password_verify($currentPassword, $user['password_hash'])) {
            return [
                'success' => false,
                'errors' => ['current_password' => 'Current password is incorrect']
            ];
        }
        
        // Validate new password
        $passwordValidation = $this->validatePassword($newPassword);
        if (!$passwordValidation['valid']) {
            return [
                'success' => false,
                'errors' => ['new_password' => $passwordValidation['message']]
            ];
        }
        
        // Check if new password is same as current
        if (password_verify($newPassword, $user['password_hash'])) {
            return [
                'success' => false,
                'errors' => ['new_password' => 'New password must be different from current password']
            ];
        }
        
        // Check password history
        if ($this->isPasswordInHistory($userId, $newPassword)) {
            return [
                'success' => false,
                'errors' => ['new_password' => 'Cannot reuse a recent password']
            ];
        }
        
        // Hash new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        // Update user password
        TuskDb::remember('users', [
            'password_hash' => $hashedPassword,
            'password_changed_at' => date('Y-m-d H:i:s'),
            'force_password_change' => false,
            'updated_at' => date('Y-m-d H:i:s')
        ], ['id' => $userId]);
        
        // Store in password history
        $this->addToPasswordHistory($userId, $hashedPassword);
        
        // Log password change
        $this->logPasswordChange($user, 'update');
        
        // Fire password changed event
        $this->firePasswordChangedEvent($user, 'update');
        
        return [
            'success' => true,
            'message' => 'Password updated successfully'
        ];
    }
    
    /**
     * Force password change on next login
     */
    public function forcePasswordChange(int $userId): array
    {
        $user = $this->getUserById($userId);
        if (!$user) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }
        
        // Set force password change flag
        TuskDb::remember('users', [
            'force_password_change' => true,
            'force_password_change_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ], ['id' => $userId]);
        
        // Log action
        $this->logPasswordForce($user);
        
        return [
            'success' => true,
            'message' => 'User will be required to change password on next login'
        ];
    }
    
    /**
     * Check if user must change password
     */
    public function mustChangePassword(int $userId): bool
    {
        $user = $this->getUserById($userId);
        return $user ? (bool)($user['force_password_change'] ?? false) : false;
    }
    
    /**
     * Validate password strength
     */
    private function validatePassword(string $password): array
    {
        if (strlen($password) < self::PASSWORD_MIN_LENGTH) {
            return [
                'valid' => false,
                'message' => 'Password must be at least ' . self::PASSWORD_MIN_LENGTH . ' characters'
            ];
        }
        
        $checks = [
            'uppercase' => preg_match('/[A-Z]/', $password),
            'lowercase' => preg_match('/[a-z]/', $password),
            'digit' => preg_match('/\d/', $password),
            'special' => preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)
        ];
        
        $passedChecks = array_sum($checks);
        
        if ($passedChecks < 3) {
            return [
                'valid' => false,
                'message' => 'Password must contain at least 3 of: uppercase letters, lowercase letters, numbers, special characters'
            ];
        }
        
        return ['valid' => true];
    }
    
    /**
     * Check if password is in user's history
     */
    private function isPasswordInHistory(int $userId, string $password): bool
    {
        $history = TuskDb::recall('password_history', [
            'user_id' => $userId
        ], [
            'order' => 'created_at DESC',
            'limit' => self::PASSWORD_HISTORY_LIMIT
        ]);
        
        foreach ($history as $entry) {
            if (password_verify($password, $entry['password_hash'])) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Add password to history
     */
    private function addToPasswordHistory(int $userId, string $hashedPassword): void
    {
        // Add new entry
        TuskDb::remember('password_history', [
            'user_id' => $userId,
            'password_hash' => $hashedPassword,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        // Clean up old entries (keep only recent ones)
        $allHistory = TuskDb::recall('password_history', [
            'user_id' => $userId
        ], ['order' => 'created_at DESC']);
        
        if (count($allHistory) > self::PASSWORD_HISTORY_LIMIT) {
            $toDelete = array_slice($allHistory, self::PASSWORD_HISTORY_LIMIT);
            foreach ($toDelete as $entry) {
                TuskDb::forget('password_history', ['id' => $entry['id']]);
            }
        }
    }
    
    /**
     * Generate reset token
     */
    private function generateResetToken(): string
    {
        return bin2hex(random_bytes(32));
    }
    
    /**
     * Get user by email
     */
    private function getUserByEmail(string $email): ?array
    {
        $users = TuskDb::recall('users', ['email' => strtolower(trim($email))], ['limit' => 1]);
        return $users[0] ?? null;
    }
    
    /**
     * Get user by ID
     */
    private function getUserById(int $id): ?array
    {
        $users = TuskDb::recall('users', ['id' => $id], ['limit' => 1]);
        return $users[0] ?? null;
    }
    
    /**
     * Check if user is active
     */
    private function isUserActive(array $user): bool
    {
        return ($user['is_active'] ?? true) && 
               ($user['deleted_at'] ?? null) === null;
    }
    
    /**
     * Send password reset email using TuskMail
     */
    private function sendResetEmail(array $user, string $token): void
    {
        try {
            // Load TuskMail
            require_once __DIR__ . '/../../Mail/TuskMailHelper.php';
            
            $resetUrl = $this->buildResetUrl($token);
            $subject = '🔐 Reset Your Password - Herd Security';
            $expiresIn = '24 hours';
            
            $body = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;'>
                <h2 style='color: #333; border-bottom: 3px solid #007cba; padding-bottom: 10px;'>
                    🔐 Password Reset Request
                </h2>
                <p>Hello {$user['name']},</p>
                <p>We received a request to reset your password. If you made this request, click the button below to set a new password:</p>
                
                <div style='text-align: center; margin: 30px 0;'>
                    <a href='{$resetUrl}' style='background: #007cba; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; display: inline-block; font-weight: bold; font-size: 16px;'>
                        🔐 Reset Your Password
                    </a>
                </div>
                
                <div style='background: #fff3cd; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #ffc107;'>
                    <h3 style='margin-top: 0; color: #856404;'>Security Information:</h3>
                    <ul style='color: #856404; margin: 0;'>
                        <li>This link will expire in <strong>{$expiresIn}</strong></li>
                        <li>The link can only be used once</li>
                        <li>If you didn't request this, you can safely ignore this email</li>
                    </ul>
                </div>
                
                <p>Or copy and paste this URL into your browser:</p>
                <p style='word-break: break-all; background: #f8f9fa; padding: 10px; border-radius: 4px; font-family: monospace; font-size: 14px;'>
                    {$resetUrl}
                </p>
                
                <div style='margin: 30px 0; padding: 20px; background: #d1ecf1; border-radius: 8px; border-left: 4px solid #17a2b8;'>
                    <p style='margin: 0; color: #0c5460;'>
                        <strong>🛡️ Security Reminder:</strong> The herd never forgets to protect its own. Always use strong passwords and keep your account secure.
                    </p>
                </div>
                
                <p style='color: #6c757d; font-size: 14px; margin-top: 30px;'>
                    If you're having trouble clicking the button, copy and paste the URL above into your browser.<br><br>
                    This email was sent by the Herd authentication system.<br>
                    Powered by TuskPHP 🐘 - Strong. Secure. Scalable.
                </p>
            </div>";
            
            \TuskMailHelper::send(
                $user['email'],
                $subject,
                $body,
                $user['name'],
                'password_reset'
            );
            
            // Log email sent
            $this->logEmailSent($user['id'], 'password_reset');
            
        } catch (Exception $e) {
            error_log("Password reset email failed: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Build password reset URL
     */
    private function buildResetUrl(string $token): string
    {
        $baseUrl = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $protocol = 'https'; // Force HTTPS for load balancer setup
        
        return "{$protocol}://{$baseUrl}/reset-password?token={$token}";
    }
    
    /**
     * Fire password reset event
     */
    private function firePasswordResetEvent(array $user, string $token): void
    {
        $event = new PasswordResetEvent($user, $token);
        
        // Notify via Trunk if available
        if (class_exists('TuskPHP\App\Class\Trunk')) {
            $trunk = new Trunk();
            $trunk->send([
                'event' => 'password_reset_requested',
                'user_id' => $user['id'],
                'email' => $user['email'],
                'timestamp' => time()
            ], 'herd_security');
        }
    }
    
    /**
     * Fire password changed event
     */
    private function firePasswordChangedEvent(array $user, string $method): void
    {
        $event = new PasswordChangedEvent($user, $method);
        
        // Notify via Trunk if available
        if (class_exists('TuskPHP\App\Class\Trunk')) {
            $trunk = new Trunk();
            $trunk->send([
                'event' => 'password_changed',
                'user_id' => $user['id'],
                'email' => $user['email'],
                'method' => $method,
                'timestamp' => time()
            ], 'herd_security');
        }
    }
    
    /**
     * Log password reset request
     */
    private function logPasswordResetRequest(array $user): void
    {
        TuskDb::remember('herd_auth_logs', [
            'type' => 'password_reset_requested',
            'user_id' => $user['id'],
            'data' => json_encode([
                'email' => $user['email']
            ]),
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * Log password change
     */
    private function logPasswordChange(array $user, string $method): void
    {
        TuskDb::remember('herd_auth_logs', [
            'type' => 'password_changed',
            'user_id' => $user['id'],
            'data' => json_encode([
                'email' => $user['email'],
                'method' => $method
            ]),
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * Log password force change
     */
    private function logPasswordForce(array $user): void
    {
        TuskDb::remember('herd_auth_logs', [
            'type' => 'password_force_change',
            'user_id' => $user['id'],
            'data' => json_encode([
                'email' => $user['email']
            ]),
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * Log email sent
     */
    private function logEmailSent(int $userId, string $type): void
    {
        TuskDb::remember('herd_email_logs', [
            'user_id' => $userId,
            'type' => $type,
            'status' => 'sent',
            'sent_at' => date('Y-m-d H:i:s')
        ]);
    }
} 