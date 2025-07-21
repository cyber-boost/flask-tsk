<?php
/**
 * <?tusk> TuskPHP Herd Login Event
 * ==============================
 * "The herd celebrates a new member's arrival"
 * Login event for Herd authentication system
 * Strong. Secure. Scalable. 🐘
 */

namespace TuskPHP\Herd\Events;

class LoginEvent
{
    public $user;
    public $timestamp;
    
    public function __construct(array $user)
    {
        $this->user = $user;
        $this->timestamp = time();
    }
} 