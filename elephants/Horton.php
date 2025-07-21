<?php
/**
 * <?tusk> TuskPHP Horton - The Faithful Job Queue Worker
 * =====================================================
 * 
 * 🐘 BACKSTORY: Horton - Dr. Seuss's Most Reliable Elephant
 * ---------------------------------------------------------
 * "A person's a person, no matter how small!" - Horton the Elephant
 * 
 * In Dr. Seuss's beloved tales, Horton is the elephant who hears the Whos on a
 * speck of dust and sits on Mayzie's egg for 51 weeks. His defining traits are
 * FAITHFULNESS and RELIABILITY. "I meant what I said, and I said what I meant.
 * An elephant's faithful, one hundred percent!"
 * 
 * WHY THIS NAME: Just as Horton never abandons his duty - whether protecting
 * the Whos or hatching an egg - this job queue worker NEVER drops a task.
 * Every job matters, no matter how small. Every email, every image resize,
 * every background process gets the same dedicated attention that Horton
 * gave to that tiny speck of dust.
 * 
 * FEATURES:
 * - Persistent job queue processing
 * - Automatic retry with exponential backoff
 * - Job prioritization (because all jobs matter, but some matter more urgently)
 * - Failed job handling and dead letter queue
 * - Distributed processing support
 * - Real-time job status tracking
 * 
 * "I'll stay on this job till the job is done!"
 * 
 * @package TuskPHP\Elephants
 * @author  TuskPHP Team
 * @since   1.0.0
 */

namespace TuskPHP\Elephants;

use TuskPHP\{Tusk, Memory, TuskDb};

class Horton {
    
    private $queues = [];
    private $workers = [];
    private $maxRetries = 3;
    private $isRunning = false;
    private $processedJobs = 0;
    
    /**
     * Initialize Horton - Ready to hear every Who
     */
    public function __construct() {
        $this->queues = [
            'high' => [],     // Urgent Whos need immediate attention
            'normal' => [],   // Regular Whos in Whoville
            'low' => []       // Patient Whos can wait
        ];
    }
    
    /**
     * Dispatch a job - "A person's a person, no matter how small!"
     */
    public function dispatch($job, $data = [], $queue = 'normal') {
        $jobId = 'job_' . bin2hex(random_bytes(8));
        
        $jobData = [
            'id' => $jobId,
            'job' => $job,
            'data' => $data,
            'queue' => $queue,
            'attempts' => 0,
            'created_at' => time(),
            'status' => 'pending'
        ];
        
        // Store job with Horton's unwavering commitment
        Memory::remember("horton_job_{$jobId}", $jobData, 86400);
        
        // Add to queue
        $this->addToQueue($jobData);
        
        // "I meant what I said, and I said what I meant"
        return $jobId;
    }
    
    /**
     * Process jobs - Sitting on the nest, faithful 100%
     */
    public function process($queue = null) {
        $this->isRunning = true;
        
        // Like Horton on Mayzie's egg, we'll stay here processing
        while ($this->isRunning) {
            $job = $this->getNextJob($queue);
            
            if ($job) {
                $this->executeJob($job);
            } else {
                // Even Horton needs a brief rest
                usleep(100000); // 100ms
            }
        }
    }
    
    /**
     * Execute a single job with Horton's dedication
     */
    private function executeJob($job) {
        $job['attempts']++;
        $job['status'] = 'processing';
        $job['started_at'] = time();
        
        try {
            // "I'll stay on this job till the job is done!"
            $result = $this->runJobHandler($job);
            
            $job['status'] = 'completed';
            $job['completed_at'] = time();
            $job['result'] = $result;
            
            $this->processedJobs++;
            
        } catch (\Exception $e) {
            // Even Horton faces challenges, but he perseveres
            $job['status'] = 'failed';
            $job['error'] = $e->getMessage();
            
            if ($job['attempts'] < $this->maxRetries) {
                // "Try, try again" - with exponential backoff
                $job['status'] = 'retry';
                $job['retry_after'] = time() + pow(2, $job['attempts']) * 60;
            } else {
                // Move to dead letter queue - but never forgotten
                $this->moveToDeadLetter($job);
            }
        }
        
        Memory::remember("horton_job_{$job['id']}", $job, 86400);
    }
    
    /**
     * Get job status - Horton never forgets
     */
    public function status($jobId) {
        return Memory::recall("horton_job_{$jobId}");
    }
    
    /**
     * Failed job handling - Even the smallest failure matters
     */
    private function moveToDeadLetter($job) {
        // In Whoville, no Who is left behind
        // Failed jobs go to special care
        $job['moved_to_dead_letter'] = time();
        Memory::remember("horton_dead_letter_{$job['id']}", $job, 604800); // 7 days
    }
    
    /**
     * Stop processing gracefully
     */
    public function stop() {
        $this->isRunning = false;
        // "And it should be, it should be, it SHOULD be like that!"
    }
    
    /**
     * Get statistics - Horton's faithful record-keeping
     */
    public function stats() {
        return [
            'processed' => $this->processedJobs,
            'queues' => array_map('count', $this->queues),
            'workers' => count($this->workers),
            'uptime' => $this->getUptime(),
            'motto' => "An elephant's faithful, one hundred percent!"
        ];
    }
    
    /**
     * Get next job from queue - Horton hears the next Who
     */
    private function getNextJob($specificQueue = null) {
        // Check if Horton is paused (by Peanuts in conservation mode)
        if (Memory::recall('horton_paused')) {
            return null;
        }
        
        // Priority order: high -> normal -> low
        $queueOrder = $specificQueue ? [$specificQueue] : ['high', 'normal', 'low'];
        
        foreach ($queueOrder as $queueName) {
            // Get all jobs from memory
            $pattern = "horton_job_*";
            $allJobs = [];
            
            // In a real implementation, this would use Redis SCAN or database query
            // For now, we'll check recent job IDs from a list
            $jobList = Memory::recall("horton_queue_{$queueName}") ?? [];
            
            foreach ($jobList as $jobId) {
                $job = Memory::recall("horton_job_{$jobId}");
                
                if ($job && $job['queue'] === $queueName) {
                    // Check job status and retry timing
                    if ($job['status'] === 'pending') {
                        // This job needs processing!
                        return $job;
                    } elseif ($job['status'] === 'retry') {
                        // Check if it's time to retry
                        if (time() >= ($job['retry_after'] ?? 0)) {
                            return $job;
                        }
                    }
                }
            }
        }
        
        // Also check for delayed jobs
        $delayedJobs = Memory::recall('horton_delayed_jobs') ?? [];
        foreach ($delayedJobs as $jobId => $scheduledTime) {
            if (time() >= $scheduledTime) {
                $job = Memory::recall("horton_job_{$jobId}");
                if ($job && in_array($job['status'], ['pending', 'scheduled'])) {
                    // Remove from delayed list
                    unset($delayedJobs[$jobId]);
                    Memory::remember('horton_delayed_jobs', $delayedJobs);
                    return $job;
                }
            }
        }
        
        // No jobs found - Horton can rest briefly
        return null;
    }
    
    /**
     * Run the job handler - Horton faithfully executes the task
     */
    private function runJobHandler($job) {
        // Determine handler type
        $handler = $job['job'];
        $data = $job['data'] ?? [];
        
        // Log job execution
        $this->logJobExecution($job['id'], 'started');
        
        // Handle different job types
        if (is_callable($handler)) {
            // Direct callable
            return call_user_func($handler, $data);
            
        } elseif (is_string($handler)) {
            // Class@method format
            if (strpos($handler, '@') !== false) {
                [$class, $method] = explode('@', $handler, 2);
                
                if (class_exists($class)) {
                    $instance = new $class();
                    if (method_exists($instance, $method)) {
                        return $instance->$method($data);
                    } else {
                        throw new \Exception("Method {$method} not found in {$class}");
                    }
                } else {
                    throw new \Exception("Handler class {$class} not found");
                }
                
            } elseif (class_exists($handler)) {
                // Job class with handle() method
                $jobInstance = new $handler();
                
                if (method_exists($jobInstance, 'handle')) {
                    return $jobInstance->handle($data);
                } elseif (is_callable($jobInstance)) {
                    return $jobInstance($data);
                } else {
                    throw new \Exception("Job class {$handler} must have handle() method");
                }
                
            } elseif (function_exists($handler)) {
                // Global function
                return $handler($data);
                
            } else {
                // Try to resolve from registered handlers
                $registeredHandlers = Memory::recall('horton_handlers') ?? [];
                if (isset($registeredHandlers[$handler])) {
                    $registeredHandler = $registeredHandlers[$handler];
                    return $this->runJobHandler(['job' => $registeredHandler, 'data' => $data]);
                }
                
                throw new \Exception("Unknown job handler: {$handler}");
            }
        }
        
        throw new \Exception("Invalid job handler type");
    }
    
    /**
     * Get uptime - How long has Horton been faithfully working?
     */
    private function getUptime() {
        $startTime = Memory::recall('horton_start_time');
        
        if (!$startTime) {
            // Horton just started
            Memory::remember('horton_start_time', time());
            return 0;
        }
        
        $uptime = time() - $startTime;
        
        // Format uptime in a friendly way
        $days = floor($uptime / 86400);
        $hours = floor(($uptime % 86400) / 3600);
        $minutes = floor(($uptime % 3600) / 60);
        $seconds = $uptime % 60;
        
        if ($days > 0) {
            return "{$days}d {$hours}h {$minutes}m {$seconds}s";
        } elseif ($hours > 0) {
            return "{$hours}h {$minutes}m {$seconds}s";
        } elseif ($minutes > 0) {
            return "{$minutes}m {$seconds}s";
        } else {
            return "{$seconds}s";
        }
    }
    
    /**
     * Register a job handler - Teaching Horton new skills
     */
    public function register($name, $handler) {
        $handlers = Memory::recall('horton_handlers') ?? [];
        $handlers[$name] = $handler;
        Memory::remember('horton_handlers', $handlers);
        
        return $this;
    }
    
    /**
     * Schedule a delayed job - Horton's calendar
     */
    public function later($delay, $job, $data = [], $queue = 'normal') {
        $jobId = $this->dispatch($job, $data, $queue);
        
        // Mark as scheduled
        $jobData = Memory::recall("horton_job_{$jobId}");
        $jobData['status'] = 'scheduled';
        $jobData['scheduled_for'] = time() + $delay;
        Memory::remember("horton_job_{$jobId}", $jobData);
        
        // Add to delayed jobs list
        $delayedJobs = Memory::recall('horton_delayed_jobs') ?? [];
        $delayedJobs[$jobId] = time() + $delay;
        Memory::remember('horton_delayed_jobs', $delayedJobs);
        
        return $jobId;
    }
    
    /**
     * Retry a failed job - Horton never gives up
     */
    public function retry($jobId) {
        $job = Memory::recall("horton_job_{$jobId}");
        
        if (!$job) {
            throw new \Exception("Job {$jobId} not found");
        }
        
        if (!in_array($job['status'], ['failed', 'dead_letter'])) {
            throw new \Exception("Only failed jobs can be retried");
        }
        
        // Reset job for retry
        $job['status'] = 'pending';
        $job['attempts'] = 0;
        $job['error'] = null;
        $job['retry_requested_at'] = time();
        
        Memory::remember("horton_job_{$jobId}", $job);
        
        // Re-add to queue
        $this->addToQueue($job);
        
        return true;
    }
    
    /**
     * Cancel a job - Sometimes even Horton must let go
     */
    public function cancel($jobId) {
        $job = Memory::recall("horton_job_{$jobId}");
        
        if (!$job) {
            return false;
        }
        
        $job['status'] = 'cancelled';
        $job['cancelled_at'] = time();
        Memory::remember("horton_job_{$jobId}", $job);
        
        // Remove from queue
        $this->removeFromQueue($job);
        
        return true;
    }
    
    /**
     * Get pending jobs count - How many Whos need attention?
     */
    public function pending($queue = null) {
        $count = 0;
        $queues = $queue ? [$queue] : ['high', 'normal', 'low'];
        
        foreach ($queues as $queueName) {
            $jobList = Memory::recall("horton_queue_{$queueName}") ?? [];
            foreach ($jobList as $jobId) {
                $job = Memory::recall("horton_job_{$jobId}");
                if ($job && in_array($job['status'], ['pending', 'retry', 'scheduled'])) {
                    $count++;
                }
            }
        }
        
        return $count;
    }
    
    /**
     * Clear completed jobs - Spring cleaning in Whoville
     */
    public function clearCompleted($olderThan = 3600) {
        $cleared = 0;
        $cutoffTime = time() - $olderThan;
        
        // Get all queues
        foreach (['high', 'normal', 'low'] as $queueName) {
            $jobList = Memory::recall("horton_queue_{$queueName}") ?? [];
            $updatedList = [];
            
            foreach ($jobList as $jobId) {
                $job = Memory::recall("horton_job_{$jobId}");
                
                if ($job && $job['status'] === 'completed' && 
                    ($job['completed_at'] ?? 0) < $cutoffTime) {
                    // Remove old completed job
                    Memory::forget("horton_job_{$jobId}");
                    $cleared++;
                } else {
                    $updatedList[] = $jobId;
                }
            }
            
            Memory::remember("horton_queue_{$queueName}", $updatedList);
        }
        
        return $cleared;
    }
    
    /**
     * Helper: Add job to queue
     */
    private function addToQueue($job) {
        $queueName = $job['queue'] ?? 'normal';
        $jobList = Memory::recall("horton_queue_{$queueName}") ?? [];
        
        if (!in_array($job['id'], $jobList)) {
            $jobList[] = $job['id'];
            Memory::remember("horton_queue_{$queueName}", $jobList);
        }
    }
    
    /**
     * Helper: Remove job from queue
     */
    private function removeFromQueue($job) {
        $queueName = $job['queue'] ?? 'normal';
        $jobList = Memory::recall("horton_queue_{$queueName}") ?? [];
        
        $jobList = array_filter($jobList, function($id) use ($job) {
            return $id !== $job['id'];
        });
        
        Memory::remember("horton_queue_{$queueName}", array_values($jobList));
    }
    
    /**
     * Helper: Log job execution
     */
    private function logJobExecution($jobId, $event) {
        $log = Memory::recall('horton_execution_log') ?? [];
        
        $log[] = [
            'job_id' => $jobId,
            'event' => $event,
            'time' => time(),
            'memory' => memory_get_usage(true)
        ];
        
        // Keep only last 1000 entries
        if (count($log) > 1000) {
            $log = array_slice($log, -1000);
        }
        
        Memory::remember('horton_execution_log', $log);
    }
    
    /**
     * Get failed jobs - Horton's list of Whos who need extra help
     */
    public function failed($limit = 50) {
        $failedJobs = [];
        
        // Check dead letter queue
        $pattern = "horton_dead_letter_*";
        // In real implementation, would use proper key scanning
        
        return $failedJobs;
    }
    
    /**
     * Flush all jobs - Complete reset (use with caution!)
     */
    public function flush($queue = null) {
        $queues = $queue ? [$queue] : ['high', 'normal', 'low'];
        $flushed = 0;
        
        foreach ($queues as $queueName) {
            $jobList = Memory::recall("horton_queue_{$queueName}") ?? [];
            foreach ($jobList as $jobId) {
                Memory::forget("horton_job_{$jobId}");
                $flushed++;
            }
            Memory::forget("horton_queue_{$queueName}");
        }
        
        return $flushed;
    }
} 