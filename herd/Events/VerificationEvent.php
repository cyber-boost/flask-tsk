<?php
/**
 * <?tusk> TuskPHP Herd Verification Event
 * ======================================
 * "The herd confirms a member's identity"
 * Email verification event for Herd authentication system
 * Strong. Secure. Scalable. 🐘
 */

namespace TuskPHP\Herd\Events;

class VerificationEvent
{
    public $user;
    public $timestamp;
    
    public function __construct(array $user)
    {
        $this->user = $user;
        $this->timestamp = time();
    }
} 