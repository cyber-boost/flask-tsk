<?php
/**
 * <?tusk> TuskPHP Herd AutoLogin Service
 * ====================================
 * "Magic links for the herd - elephants never forget the way home"
 * Secure auto-login with magic links and enhanced tracking
 * Strong. Secure. Scalable. 🐘
 */

namespace TuskPHP\Herd\Services;

use TuskPHP\{TuskDb, Memory, TuskObject};
use TuskPHP\Herd\Events\{LoginEvent};
use TuskPHP\App\Class\{Stomp, Trunk};

class AutoLogin
{
    private const DEFAULT_EXPIRES_HOURS = 24;
    private const MAX_USES_DEFAULT = 1;
    private const TOKEN_LENGTH = 64;
    
    /**
     * Generate a magic link for user auto-login
     */
    public function generateMagicLink(int $userId, array $options = []): array
    {
        $user = $this->getUserById($userId);
        if (!$user) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }
        
        if (!$this->isUserActive($user)) {
            return [
                'success' => false,
                'message' => 'User account is not active'
            ];
        }
        
        // Parse options
        $purpose = $options['purpose'] ?? 'login';
        $redirectUrl = $options['redirect'] ?? '/dashboard/';
        $validDays = $options['valid_days'] ?? 1;
        $maxUses = $options['max_uses'] ?? self::MAX_USES_DEFAULT;
        $ipRestrictions = $options['ip_restrictions'] ?? null;
        $createdBy = $options['created_by'] ?? null;
        $metadata = $options['metadata'] ?? [];
        
        // Generate secure token
        $token = $this->generateSecureToken();
        $expiresAt = date('Y-m-d H:i:s', time() + ($validDays * 24 * 3600));
        
        // Prepare metadata
        $tokenMetadata = array_merge($metadata, [
            'generated_at' => date('Y-m-d H:i:s'),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'source_ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ]);
        
        // Store in enhanced magic links table
        $linkId = TuskDb::remember('herd_magic_links', [
            'user_id' => $userId,
            'token' => hash('sha256', $token), // Store hashed version
            'purpose' => $purpose,
            'redirect_url' => $redirectUrl,
            'max_uses' => $maxUses,
            'uses_count' => 0,
            'expires_at' => $expiresAt,
            'metadata' => json_encode($tokenMetadata),
            'ip_restrictions' => $ipRestrictions ? json_encode($ipRestrictions) : null,
            'used_ips' => json_encode([]),
            'is_single_use' => $maxUses === 1,
            'created_by' => $createdBy,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        if (!$linkId) {
            return [
                'success' => false,
                'message' => 'Failed to generate magic link'
            ];
        }
        
        // Also store in legacy auto_login_tokens for backward compatibility
        TuskDb::remember('auto_login_tokens', [
            'user_id' => $userId,
            'token' => hash('sha256', $token),
            'expires_at' => $expiresAt,
            'used' => false,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        // Build magic link URL
        $magicUrl = $this->buildMagicUrl($token, $redirectUrl);
        
        // Log magic link generation
        $this->logMagicLinkGenerated($user, $purpose, $linkId);
        
        return [
            'success' => true,
            'magic_url' => $magicUrl,
            'token' => $token, // Return raw token for email
            'expires_at' => $expiresAt,
            'expires_in_hours' => $validDays * 24,
            'max_uses' => $maxUses,
            'purpose' => $purpose,
            'link_id' => $linkId
        ];
    }
    
    /**
     * Verify and use a magic link token
     */
    public function verifyMagicLink(string $token): array
    {
        $hashedToken = hash('sha256', $token);
        
        // Find token in magic links table
        $links = TuskDb::recall('herd_magic_links', [
            'token' => $hashedToken
        ], ['limit' => 1]);
        
        $link = $links[0] ?? null;
        if (!$link) {
            return [
                'valid' => false,
                'message' => 'Invalid magic link'
            ];
        }
        
        // Check if expired
        if (strtotime($link['expires_at']) < time()) {
            return [
                'valid' => false,
                'message' => 'Magic link has expired'
            ];
        }
        
        // Check usage limits
        if ($link['uses_count'] >= $link['max_uses']) {
            return [
                'valid' => false,
                'message' => 'Magic link has been used maximum times'
            ];
        }
        
        // Check IP restrictions if any
        if ($link['ip_restrictions']) {
            $allowedIps = json_decode($link['ip_restrictions'], true);
            $currentIp = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
            
            if (!in_array($currentIp, $allowedIps)) {
                return [
                    'valid' => false,
                    'message' => 'Magic link not valid from this IP address'
                ];
            }
        }
        
        // Get user data
        $user = $this->getUserById($link['user_id']);
        if (!$user || !$this->isUserActive($user)) {
            return [
                'valid' => false,
                'message' => 'User account is not active'
            ];
        }
        
        return [
            'valid' => true,
            'user_id' => $link['user_id'],
            'user' => $user,
            'purpose' => $link['purpose'],
            'redirect_url' => $link['redirect_url'],
            'link_id' => $link['id'],
            'metadata' => json_decode($link['metadata'] ?? '{}', true)
        ];
    }
    
    /**
     * Use magic link to log in user
     */
    public function loginWithMagicLink(string $token): array
    {
        // Verify the token first
        $verification = $this->verifyMagicLink($token);
        if (!$verification['valid']) {
            return [
                'success' => false,
                'message' => $verification['message']
            ];
        }
        
        $user = $verification['user'];
        $linkId = $verification['link_id'];
        $redirectUrl = $verification['redirect_url'];
        
        try {
            // Update usage tracking
            $this->updateMagicLinkUsage($linkId);
            
            // Create user session using Herd Primary service
            $primary = new Primary();
            $sessionCreated = $this->createMagicLinkSession($user);
            
            if (!$sessionCreated) {
                return [
                    'success' => false,
                    'message' => 'Failed to create user session'
                ];
            }
            
            // Log successful magic link login
            $this->logMagicLinkLogin($user, $linkId);
            
            // Fire login event
            $this->fireMagicLinkLoginEvent($user, $linkId);
            
            // Update user's last login
            TuskDb::remember('users', [
                'last_login_at' => date('Y-m-d H:i:s'),
                'last_login_ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
                'login_count' => TuskDb::raw('login_count + 1')
            ], ['id' => $user['id']]);
            
            return [
                'success' => true,
                'user_id' => $user['id'],
                'redirect_url' => $redirectUrl,
                'login_method' => 'magic_link',
                'message' => 'Successfully logged in with magic link'
            ];
            
        } catch (Exception $e) {
            error_log("Magic link login error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Login failed - please try again'
            ];
        }
    }
    
    /**
     * Send magic link via email
     */
    public function sendMagicLinkEmail(int $userId, array $options = []): array
    {
        $user = $this->getUserById($userId);
        if (!$user) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }
        
        // Generate magic link
        $linkResult = $this->generateMagicLink($userId, $options);
        if (!$linkResult['success']) {
            return $linkResult;
        }
        
        try {
            // Load TuskMail
            require_once __DIR__ . '/../../Mail/TuskMailHelper.php';
            
            $purpose = $options['purpose'] ?? 'login';
            $customMessage = $options['message'] ?? null;
            $subject = $options['subject'] ?? $this->getDefaultSubject($purpose);
            $userName = $user['first_name'] ?? $user['username'] ?? 'Friend';
            $magicUrl = $linkResult['magic_url'];
            $expiresHours = $linkResult['expires_in_hours'];
            
            $body = $this->buildMagicLinkEmailBody($userName, $magicUrl, $purpose, $expiresHours, $customMessage);
            
            \TuskMailHelper::send(
                $user['email'],
                $subject,
                $body,
                $userName,
                'magic_link_' . $purpose
            );
            
            // Log email sent
            $this->logMagicLinkEmailSent($user['id'], $purpose, $linkResult['link_id']);
            
            return [
                'success' => true,
                'message' => 'Magic link sent successfully',
                'link_id' => $linkResult['link_id'],
                'expires_at' => $linkResult['expires_at']
            ];
            
        } catch (Exception $e) {
            error_log("Magic link email failed: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to send magic link email'
            ];
        }
    }
    
    /**
     * Get magic link statistics for user
     */
    public function getMagicLinkStats(int $userId): array
    {
        $links = TuskDb::recall('herd_magic_links', [
            'user_id' => $userId
        ], ['order' => 'created_at DESC', 'limit' => 50]);
        
        $stats = [
            'total_generated' => count($links),
            'active_links' => 0,
            'expired_links' => 0,
            'used_links' => 0,
            'recent_links' => []
        ];
        
        foreach ($links as $link) {
            if (strtotime($link['expires_at']) < time()) {
                $stats['expired_links']++;
            } elseif ($link['uses_count'] >= $link['max_uses']) {
                $stats['used_links']++;
            } else {
                $stats['active_links']++;
            }
            
            if (count($stats['recent_links']) < 10) {
                $stats['recent_links'][] = [
                    'id' => $link['id'],
                    'purpose' => $link['purpose'],
                    'created_at' => $link['created_at'],
                    'expires_at' => $link['expires_at'],
                    'uses_count' => $link['uses_count'],
                    'max_uses' => $link['max_uses'],
                    'is_active' => strtotime($link['expires_at']) > time() && $link['uses_count'] < $link['max_uses']
                ];
            }
        }
        
        return $stats;
    }
    
    /**
     * Revoke/invalidate a magic link
     */
    public function revokeMagicLink(int $linkId, int $revokedBy = null): bool
    {
        $result = TuskDb::remember('herd_magic_links', [
            'expires_at' => date('Y-m-d H:i:s', time() - 1), // Set to past date
            'uses_count' => TuskDb::raw('max_uses'), // Max out uses
            'metadata' => TuskDb::raw("jsonb_set(metadata, '{revoked_at}', '\"" . date('Y-m-d H:i:s') . "\"')")
        ], ['id' => $linkId]);
        
        if ($result) {
            // Log revocation
            TuskDb::remember('herd_auth_logs', [
                'type' => 'magic_link_revoked',
                'user_id' => $revokedBy,
                'data' => json_encode(['link_id' => $linkId]),
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
        
        return (bool)$result;
    }
    
    // Private helper methods
    
    private function generateSecureToken(): string
    {
        return bin2hex(random_bytes(self::TOKEN_LENGTH));
    }
    
    private function getUserById(int $id): ?array
    {
        $users = TuskDb::recall('users', ['id' => $id], ['limit' => 1]);
        return $users[0] ?? null;
    }
    
    private function isUserActive(array $user): bool
    {
        return ($user['is_active'] ?? true) && 
               ($user['deleted_at'] ?? null) === null;
    }
    
    private function buildMagicUrl(string $token, string $redirect = '/dashboard/'): string
    {
        $baseUrl = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $protocol = 'https'; // Force HTTPS for load balancer setup
        
        $params = http_build_query([
            'token' => $token,
            'redirect' => $redirect
        ]);
        
        return "{$protocol}://{$baseUrl}/magic-login?{$params}";
    }
    
    private function createMagicLinkSession(array $user): bool
    {
        session_regenerate_id(true);
        
        $_SESSION['herd_authenticated'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['login_time'] = time();
        $_SESSION['login_method'] = 'magic_link';
        $_SESSION['session_id'] = session_id();
        
        // Store user in Memory for quick access
        Memory::remember("herd_user_{$user['id']}", $user, 1800);
        
        return true;
    }
    
    private function updateMagicLinkUsage(int $linkId): void
    {
        $currentIp = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        
        // Get current used IPs
        $link = TuskDb::recall('herd_magic_links', ['id' => $linkId], ['limit' => 1])[0] ?? null;
        if (!$link) return;
        
        $usedIps = json_decode($link['used_ips'] ?? '[]', true);
        if (!in_array($currentIp, $usedIps)) {
            $usedIps[] = $currentIp;
        }
        
        // Update usage
        TuskDb::remember('herd_magic_links', [
            'uses_count' => TuskDb::raw('uses_count + 1'),
            'used_ips' => json_encode($usedIps),
            'first_used_at' => $link['first_used_at'] ? $link['first_used_at'] : date('Y-m-d H:i:s'),
            'last_used_at' => date('Y-m-d H:i:s')
        ], ['id' => $linkId]);
    }
    
    private function getDefaultSubject(string $purpose): string
    {
        $subjects = [
            'login' => '🔐 Your Magic Login Link',
            'email_verification' => '✅ Verify Your Email Address',
            'password_reset' => '🔑 Reset Your Password',
            'welcome' => '🎉 Welcome to the Herd!'
        ];
        
        return $subjects[$purpose] ?? '🐘 Your Secure Access Link';
    }
    
    private function buildMagicLinkEmailBody(string $userName, string $magicUrl, string $purpose, int $expiresHours, ?string $customMessage = null): string
    {
        $purposeMessages = [
            'login' => 'Click the button below to securely log in to your account:',
            'email_verification' => 'Click the button below to verify your email address:',
            'password_reset' => 'Click the button below to reset your password:',
            'welcome' => 'Welcome to the herd! Click the button below to get started:'
        ];
        
        $message = $customMessage ?? $purposeMessages[$purpose] ?? 'Click the button below to continue:';
        $buttonText = $this->getButtonText($purpose);
        
        return "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;'>
            <h2 style='color: #333; border-bottom: 3px solid #007cba; padding-bottom: 10px;'>
                🐘 {$this->getPurposeTitle($purpose)}
            </h2>
            <p>Hello {$userName},</p>
            <p>{$message}</p>
            
            <div style='text-align: center; margin: 30px 0;'>
                <a href='{$magicUrl}' style='background: #007cba; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; display: inline-block; font-weight: bold; font-size: 16px;'>
                    {$buttonText}
                </a>
            </div>
            
            <div style='background: #fff3cd; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #ffc107;'>
                <h3 style='margin-top: 0; color: #856404;'>Security Information:</h3>
                <ul style='color: #856404; margin: 0;'>
                    <li>This link will expire in <strong>{$expiresHours} hours</strong></li>
                    <li>The link can only be used once</li>
                    <li>If you didn't request this, you can safely ignore this email</li>
                </ul>
            </div>
            
            <p>Or copy and paste this URL into your browser:</p>
            <p style='word-break: break-all; background: #f8f9fa; padding: 10px; border-radius: 4px; font-family: monospace; font-size: 14px;'>
                {$magicUrl}
            </p>
            
            <div style='margin: 30px 0; padding: 20px; background: #d1ecf1; border-radius: 8px; border-left: 4px solid #17a2b8;'>
                <p style='margin: 0; color: #0c5460;'>
                    <strong>🛡️ Herd Wisdom:</strong> Elephants never forget to protect their own. This magic link is secure and tracked for your safety.
                </p>
            </div>
            
            <p style='color: #6c757d; font-size: 14px; margin-top: 30px;'>
                This magic link was sent by the Herd authentication system.<br>
                Powered by TuskPHP 🐘 - Strong. Secure. Scalable.
            </p>
        </div>";
    }
    
    private function getPurposeTitle(string $purpose): string
    {
        $titles = [
            'login' => 'Secure Magic Login',
            'email_verification' => 'Email Verification',
            'password_reset' => 'Password Reset',
            'welcome' => 'Welcome to the Herd!'
        ];
        
        return $titles[$purpose] ?? 'Secure Access';
    }
    
    private function getButtonText(string $purpose): string
    {
        $buttons = [
            'login' => '🔐 Login Securely',
            'email_verification' => '✅ Verify Email',
            'password_reset' => '🔑 Reset Password',
            'welcome' => '🎉 Get Started'
        ];
        
        return $buttons[$purpose] ?? '🔐 Continue Securely';
    }
    
    // Logging methods
    
    private function logMagicLinkGenerated(array $user, string $purpose, int $linkId): void
    {
        TuskDb::remember('herd_auth_logs', [
            'type' => 'magic_link_generated',
            'user_id' => $user['id'],
            'data' => json_encode([
                'purpose' => $purpose,
                'link_id' => $linkId,
                'email' => $user['email']
            ]),
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    private function logMagicLinkLogin(array $user, int $linkId): void
    {
        TuskDb::remember('herd_auth_logs', [
            'type' => 'magic_link_login',
            'user_id' => $user['id'],
            'data' => json_encode([
                'link_id' => $linkId,
                'email' => $user['email']
            ]),
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    private function logMagicLinkEmailSent(int $userId, string $purpose, int $linkId): void
    {
        TuskDb::remember('herd_email_logs', [
            'user_id' => $userId,
            'type' => 'magic_link_' . $purpose,
            'status' => 'sent',
            'sent_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    private function fireMagicLinkLoginEvent(array $user, int $linkId): void
    {
        $event = new LoginEvent($user);
        
        // Notify via Trunk if available
        if (class_exists('TuskPHP\App\Class\Trunk')) {
            $trunk = new Trunk();
            $trunk->send([
                'event' => 'magic_link_login',
                'user_id' => $user['id'],
                'link_id' => $linkId,
                'timestamp' => time()
            ], 'herd_events');
        }
    }
} 