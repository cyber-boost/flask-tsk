<?php
/**
 * <?tusk> TuskPHP Herd Guard Service
 * ================================
 * "Different herds for different lands"
 * Guard switching for web, api, admin authentication
 * Strong. Secure. Scalable. 🐘
 */

namespace TuskPHP\Herd\Services;

use TuskPHP\{TuskDb, Memory, TuskObject};
use TuskPHP\App\Class\{Stomp, Trunk};

class Guard
{
    private $currentGuard = 'web';
    private $guards = [];
    
    public function __construct()
    {
        $this->initializeGuards();
    }
    
    /**
     * Switch to a different guard
     */
    public function switchGuard(string $guardName): void
    {
        if (!isset($this->guards[$guardName])) {
            throw new \InvalidArgumentException("Guard '{$guardName}' is not configured");
        }
        
        $this->currentGuard = $guardName;
        
        // Log guard switch
        $this->logGuardSwitch($guardName);
    }
    
    /**
     * Get current guard name
     */
    public function getCurrentGuard(): string
    {
        return $this->currentGuard;
    }
    
    /**
     * Get guard configuration
     */
    public function getGuardConfig(string $guardName): array
    {
        return $this->guards[$guardName] ?? [];
    }
    
    /**
     * Check if guard exists
     */
    public function hasGuard(string $guardName): bool
    {
        return isset($this->guards[$guardName]);
    }
    
    /**
     * Get all available guards
     */
    public function getGuards(): array
    {
        return array_keys($this->guards);
    }
    
    /**
     * Initialize guard configurations
     */
    private function initializeGuards(): void
    {
        $this->guards = [
            'web' => [
                'driver' => 'session',
                'provider' => 'users',
                'session_key' => 'herd_user_id',
                'remember_key' => 'herd_remember',
                'timeout' => 7200, // 2 hours
            ],
            'api' => [
                'driver' => 'token',
                'provider' => 'users',
                'token_key' => 'api_token',
                'timeout' => 86400, // 24 hours
            ],
            'admin' => [
                'driver' => 'session',
                'provider' => 'admins',
                'session_key' => 'herd_admin_id',
                'remember_key' => 'herd_admin_remember',
                'timeout' => 3600, // 1 hour
                'require_2fa' => true,
            ]
        ];
    }
    
    /**
     * Log guard switch
     */
    private function logGuardSwitch(string $guardName): void
    {
        TuskDb::remember('herd_auth_logs', [
            'type' => 'guard_switched',
            'user_id' => null,
            'data' => json_encode([
                'guard' => $guardName,
                'previous_guard' => $this->currentGuard
            ]),
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
} 