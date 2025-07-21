<?php
/**
 * <?tusk> TuskPHP Herd Logout Event
 * ===============================
 * "The herd bids farewell to a departing member"
 * Logout event for Herd authentication system
 * Strong. Secure. Scalable. 🐘
 */

namespace TuskPHP\Herd\Events;

class LogoutEvent
{
    public $user;
    public $timestamp;
    
    public function __construct(array $user)
    {
        $this->user = $user;
        $this->timestamp = time();
    }
} 