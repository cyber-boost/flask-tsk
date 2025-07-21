<?php
/**
 * <?tusk> TuskPHP Herd Password Reset Event
 * ========================================
 * "The herd guides the lost back to the path"
 * Password reset event for Herd authentication system
 * Strong. Secure. Scalable. 🐘
 */

namespace TuskPHP\Herd\Events;

class PasswordResetEvent
{
    public $user;
    public $token;
    public $timestamp;
    
    public function __construct(array $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
        $this->timestamp = time();
    }
} 