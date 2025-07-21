<?php
/**
 * <?tusk> TuskPHP Herd Registration Service
 * ========================================
 * "New elephants join the herd"
 * User registration with wisdom and security
 * Strong. Secure. Scalable. 🐘
 */

namespace TuskPHP\Herd\Services;

use TuskPHP\{TuskDb, Memory, TuskObject};
use TuskPHP\Herd\Events\{RegistrationEvent, VerificationEvent};
use TuskPHP\App\Class\{Stomp, Trunk};

class Registration
{
    private const PASSWORD_MIN_LENGTH = 8;
    private const EMAIL_VERIFICATION_TIMEOUT = 3600; // 1 hour
    
    /**
     * Register new user
     */
    public function createUser(array $data): array
    {
        // Validate registration data
        $validation = $this->validateRegistrationData($data);
        if (!$validation['valid']) {
            return [
                'success' => false,
                'errors' => $validation['errors']
            ];
        }
        
        // Check if user already exists
        if ($this->userExists($data['email'])) {
            return [
                'success' => false,
                'errors' => ['email' => 'Email already registered']
            ];
        }
        
        // Check for duplicate username if provided
        if (!empty($data['username']) && $this->usernameExists($data['username'])) {
            return [
                'success' => false,
                'errors' => ['username' => 'Username already taken']
            ];
        }
        
        // Hash password
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        
        // Prepare user data
        $userData = [
            'email' => strtolower(trim($data['email'])),
            'username' => $data['username'] ?? null,
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'password_hash' => $hashedPassword,
            'is_active' => true,
            'is_verified' => false,
            'email_verification_token' => $this->generateVerificationToken(),
            'email_verification_expires' => date('Y-m-d H:i:s', time() + self::EMAIL_VERIFICATION_TIMEOUT),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Insert user using TuskDb
        $userId = TuskDb::remember('users', $userData);
        
        if (!$userId) {
            return [
                'success' => false,
                'errors' => ['general' => 'Failed to create user account']
            ];
        }
        
        // Get the created user
        $user = $this->getUserById($userId);
        
        // Send verification email
        $this->sendVerificationEmail($user);
        
        // Log registration
        $this->logRegistration($user);
        
        // Fire registration event
        $this->fireRegistrationEvent($user);
        
        return [
            'success' => true,
            'user_id' => $userId,
            'message' => 'Registration successful. Please check your email to verify your account.'
        ];
    }
    
    /**
     * Verify email with token
     */
    public function verifyEmail(string $token): array
    {
        // Find user by verification token
        $users = TuskDb::recall('users', [
            'email_verification_token' => $token
        ], ['limit' => 1]);
        
        $user = $users[0] ?? null;
        if (!$user) {
            return [
                'success' => false,
                'message' => 'Invalid verification token'
            ];
        }
        
        // Check if token has expired
        if (strtotime($user['email_verification_expires']) < time()) {
            return [
                'success' => false,
                'message' => 'Verification token has expired'
            ];
        }
        
        // Mark user as verified
        TuskDb::remember('users', [
            'is_verified' => true,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'email_verification_token' => null,
            'email_verification_expires' => null,
            'updated_at' => date('Y-m-d H:i:s')
        ], ['id' => $user['id']]);
        
        // Log verification
        $this->logEmailVerification($user);
        
        // Fire verification event
        $this->fireVerificationEvent($user);
        
        return [
            'success' => true,
            'message' => 'Email verified successfully'
        ];
    }
    
    /**
     * Resend verification email
     */
    public function resendVerification(string $email): array
    {
        $user = $this->getUserByEmail($email);
        if (!$user) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }
        
        if ($user['is_verified']) {
            return [
                'success' => false,
                'message' => 'Email is already verified'
            ];
        }
        
        // Generate new token
        $token = $this->generateVerificationToken();
        $expiresAt = date('Y-m-d H:i:s', time() + self::EMAIL_VERIFICATION_TIMEOUT);
        
        // Update user with new token
        TuskDb::remember('users', [
            'email_verification_token' => $token,
            'email_verification_expires' => $expiresAt,
            'updated_at' => date('Y-m-d H:i:s')
        ], ['id' => $user['id']]);
        
        // Get updated user data
        $updatedUser = $this->getUserById($user['id']);
        
        // Send verification email
        $this->sendVerificationEmail($updatedUser);
        
        return [
            'success' => true,
            'message' => 'Verification email sent'
        ];
    }
    
    /**
     * Validate registration data
     */
    private function validateRegistrationData(array $data): array
    {
        $errors = [];
        
        // Email validation
        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }
        
        // Password validation
        if (empty($data['password'])) {
            $errors['password'] = 'Password is required';
        } elseif (strlen($data['password']) < self::PASSWORD_MIN_LENGTH) {
            $errors['password'] = 'Password must be at least ' . self::PASSWORD_MIN_LENGTH . ' characters';
        }
        
        // Password confirmation
        if (!empty($data['password']) && $data['password'] !== ($data['password_confirmation'] ?? '')) {
            $errors['password_confirmation'] = 'Password confirmation does not match';
        }
        
        // Username validation (if provided)
        if (!empty($data['username'])) {
            if (strlen($data['username']) < 3) {
                $errors['username'] = 'Username must be at least 3 characters';
            } elseif (!preg_match('/^[a-zA-Z0-9_-]+$/', $data['username'])) {
                $errors['username'] = 'Username can only contain letters, numbers, hyphens, and underscores';
            }
        }
        
        // First name validation (if provided)
        if (!empty($data['first_name'])) {
            if (strlen($data['first_name']) > 50) {
                $errors['first_name'] = 'First name cannot exceed 50 characters';
            }
        }
        
        // Last name validation (if provided)
        if (!empty($data['last_name'])) {
            if (strlen($data['last_name']) > 50) {
                $errors['last_name'] = 'Last name cannot exceed 50 characters';
            }
        }
        
        // Password strength validation
        if (!empty($data['password']) && empty($errors['password'])) {
            $strength = $this->validatePasswordStrength($data['password']);
            if (!$strength['valid']) {
                $errors['password'] = $strength['message'];
            }
        }
        
        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }
    
    /**
     * Validate password strength
     */
    private function validatePasswordStrength(string $password): array
    {
        $checks = [
            'length' => strlen($password) >= self::PASSWORD_MIN_LENGTH,
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
     * Check if user exists by email
     */
    private function userExists(string $email): bool
    {
        $users = TuskDb::recall('users', ['email' => strtolower(trim($email))], ['limit' => 1]);
        return !empty($users);
    }
    
    /**
     * Check if username exists
     */
    private function usernameExists(string $username): bool
    {
        $users = TuskDb::recall('users', ['username' => $username], ['limit' => 1]);
        return !empty($users);
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
     * Generate verification token
     */
    private function generateVerificationToken(): string
    {
        return bin2hex(random_bytes(32));
    }
    
    /**
     * Send verification email using TuskMail
     */
    private function sendVerificationEmail(array $user): void
    {
        try {
            // Load TuskMail
            require_once __DIR__ . '/../../Mail/TuskMailHelper.php';
            
            $verificationUrl = $this->buildVerificationUrl($user['email_verification_token']);
            $subject = '🐘 Welcome to the Herd - Verify Your Email';
            $userName = $user['first_name'] ?? $user['username'] ?? 'Friend';
            
            $body = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;'>
                <h2 style='color: #333; border-bottom: 3px solid #007cba; padding-bottom: 10px;'>
                    🐘 Welcome to the Herd!
                </h2>
                <p>Hello {$userName},</p>
                <p>Welcome to our community! We're excited to have you join the herd.</p>
                <p>To complete your registration and activate your account, please verify your email address by clicking the button below:</p>
                
                <div style='text-align: center; margin: 30px 0;'>
                    <a href='{$verificationUrl}' style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; display: inline-block; font-weight: bold; font-size: 16px;'>
                        ✅ Verify My Email
                    </a>
                </div>
                
                <div style='background: #e7f3ff; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #007cba;'>
                    <h3 style='margin-top: 0; color: #004085;'>What's Next?</h3>
                    <p style='color: #004085; margin: 0;'>
                        Once verified, you'll be able to:
                    </p>
                    <ul style='color: #004085;'>
                        <li>Access your personalized dashboard</li>
                        <li>Connect with other herd members</li>
                        <li>Enjoy all the features we have to offer</li>
                    </ul>
                </div>
                
                <p>Or copy and paste this URL into your browser:</p>
                <p style='word-break: break-all; background: #f8f9fa; padding: 10px; border-radius: 4px; font-family: monospace; font-size: 14px;'>
                    {$verificationUrl}
                </p>
                
                <div style='margin: 30px 0; padding: 20px; background: #d4edda; border-radius: 8px; border-left: 4px solid #28a745;'>
                    <p style='margin: 0; color: #155724;'>
                        <strong>🌟 Herd Wisdom:</strong> Elephants never forget, and neither do we! Your account is secure and protected by our elephant-strength security.
                    </p>
                </div>
                
                <p style='color: #6c757d; font-size: 14px; margin-top: 30px;'>
                    If you didn't create this account, you can safely ignore this email.<br><br>
                    Welcome to the family!<br>
                    Powered by TuskPHP 🐘 - Strong. Secure. Scalable.
                </p>
            </div>";
            
            \TuskMailHelper::send(
                $user['email'],
                $subject,
                $body,
                $userName,
                'email_verification'
            );
            
            // Log email sent
            $this->logEmailSent($user['id'], 'verification');
            
        } catch (Exception $e) {
            error_log("Verification email failed: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Build verification URL
     */
    private function buildVerificationUrl(string $token): string
    {
        $baseUrl = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $protocol = 'https'; // Force HTTPS for load balancer setup
        
        return "{$protocol}://{$baseUrl}/verify-email?token={$token}";
    }
    
    /**
     * Fire registration event
     */
    private function fireRegistrationEvent(array $user): void
    {
        $event = new RegistrationEvent($user);
        
        // Notify via Trunk if available
        if (class_exists('TuskPHP\App\Class\Trunk')) {
            $trunk = new Trunk();
            $trunk->send([
                'event' => 'user_registered',
                'user_id' => $user['id'],
                'email' => $user['email'],
                'timestamp' => time()
            ], 'herd_events');
        }
    }
    
    /**
     * Fire verification event
     */
    private function fireVerificationEvent(array $user): void
    {
        $event = new VerificationEvent($user);
        
        // Notify via Trunk if available
        if (class_exists('TuskPHP\App\Class\Trunk')) {
            $trunk = new Trunk();
            $trunk->send([
                'event' => 'email_verified',
                'user_id' => $user['id'],
                'email' => $user['email'],
                'timestamp' => time()
            ], 'herd_events');
        }
    }
    
    /**
     * Log registration
     */
    private function logRegistration(array $user): void
    {
        TuskDb::remember('herd_auth_logs', [
            'type' => 'user_registered',
            'user_id' => $user['id'],
            'data' => json_encode([
                'email' => $user['email'],
                'username' => $user['username']
            ]),
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * Log email verification
     */
    private function logEmailVerification(array $user): void
    {
        TuskDb::remember('herd_auth_logs', [
            'type' => 'email_verified',
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