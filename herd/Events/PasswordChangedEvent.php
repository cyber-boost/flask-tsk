<?php
/**
 * <?tusk> TuskPHP Herd Password Changed Event
 * ==========================================
 * "The herd strengthens its defenses"
 * Password changed event for Herd authentication system
 * Strong. Secure. Scalable. 🐘
 */

namespace TuskPHP\Herd\Events;

class PasswordChangedEvent
{
    public $user;
    public $method;
    public $timestamp;
    
    public function __construct(array $user, string $method)
    {
        $this->user = $user;
        $this->method = $method; // 'reset', 'update', etc.
        $this->timestamp = time();
    }
} 