<?php
/**
 * <?tusk> TuskPHP Herd Lock Event
 * =============================
 * "The herd protects itself from threats"
 * Account lock event for Herd authentication system
 * Strong. Secure. Scalable. 🐘
 */

namespace TuskPHP\Herd\Events;

class LockEvent
{
    public $email;
    public $lockData;
    public $timestamp;
    
    public function __construct(string $email, array $lockData)
    {
        $this->email = $email;
        $this->lockData = $lockData;
        $this->timestamp = time();
    }
} 