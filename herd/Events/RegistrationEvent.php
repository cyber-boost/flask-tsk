<?php
/**
 * <?tusk> TuskPHP Herd Registration Event
 * ======================================
 * "A new calf joins the herd"
 * Registration event for Herd authentication system
 * Strong. Secure. Scalable. 🐘
 */

namespace TuskPHP\Herd\Events;

class RegistrationEvent
{
    public $user;
    public $timestamp;
    
    public function __construct(array $user)
    {
        $this->user = $user;
        $this->timestamp = time();
    }
} 