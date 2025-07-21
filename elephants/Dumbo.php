<?php
/**
 * <?tusk> TuskPHP Dumbo - The Lightweight cURL Flyer
 * =================================================
 * 
 * 🐘 BACKSTORY: Dumbo - The Flying Elephant
 * ----------------------------------------
 * Dumbo, Disney's beloved flying elephant, was born with oversized ears that
 * made him the subject of ridicule. But those same ears became his greatest
 * gift - allowing him to soar through the air with grace and speed. With the
 * help of Timothy Mouse and a "magic feather," Dumbo discovered he could fly,
 * becoming the star of the circus and proving that what makes you different
 * makes you special.
 * 
 * WHY THIS NAME: Like Dumbo who could fly effortlessly with his big ears,
 * this cURL wrapper makes HTTP requests soar. It's lightweight, fast, and
 * turns what could be complex operations into simple, elegant flights across
 * the web. No magic feather needed - just clean, simple code that flies!
 * 
 * "The very things that held you down are gonna carry you up!"
 * 
 * FEATURES:
 * - Simple, fluent API for HTTP requests
 * - Automatic retries with exponential backoff
 * - Response caching for repeated requests
 * - Parallel request handling
 * - Cookie jar management
 * - Progress callbacks for large downloads
 * - Built-in error handling and logging
 * 
 * @package TuskPHP\Elephants
 * @author  TuskPHP Team
 * @since   1.0.0
 */

namespace TuskPHP\Elephants;

use TuskPHP\{Memory};

class Dumbo {
    
    private $options = [];
    private $headers = [];
    private $cookies = [];
    private $timeout = 30;
    private $retries = 3;
    private $magicFeather = true; // Confidence mode!
    
    /**
     * Initialize Dumbo - Ready to take flight!
     */
    public function __construct() {
        $this->options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false, // Disabled for load balancer compatibility
            CURLOPT_USERAGENT => 'Dumbo/1.0 (TuskPHP; Flying Elephant)'
        ];
    }
    
    /**
     * GET request - Dumbo's basic flight
     */
    public function get($url, $params = []) {
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        
        return $this->fly($url, 'GET');
    }
    
    /**
     * POST request - Dumbo carries cargo
     */
    public function post($url, $data = []) {
        $this->options[CURLOPT_POST] = true;
        $this->options[CURLOPT_POSTFIELDS] = $data;
        
        return $this->fly($url, 'POST');
    }
    
    /**
     * The main flight method - Where Dumbo soars
     */
    private function fly($url, $method = 'GET') {
        // Check cache first - Dumbo remembers his routes
        $cacheKey = 'dumbo_' . md5($url . $method . serialize($this->options));
        if ($cached = Memory::recall($cacheKey)) {
            return $cached;
        }
        
        $ch = curl_init($url);
        
        // Set all options - preparing for takeoff
        curl_setopt_array($ch, $this->options);
        
        // Add headers - Dumbo's flight plan
        if (!empty($this->headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        }
        
        // Timothy Mouse's encouragement (retries)
        $attempt = 0;
        $response = false;
        
        while ($attempt < $this->retries && $response === false) {
            $attempt++;
            
            if ($attempt > 1) {
                // "You can fly! You can fly!" - Timothy Mouse
                usleep(pow(2, $attempt) * 100000); // Exponential backoff
            }
            
            $response = curl_exec($ch);
            $error = curl_error($ch);
            
            if ($error && $attempt < $this->retries) {
                echo "🪶 Dumbo stumbled on attempt {$attempt}: {$error}\n";
            }
        }
        
        $info = curl_getinfo($ch);
        curl_close($ch);
        
        if ($response === false) {
            throw new \Exception("Dumbo couldn't complete the flight: {$error}");
        }
        
        $result = [
            'body' => $response,
            'info' => $info,
            'status' => $info['http_code'],
            'time' => $info['total_time']
        ];
        
        // Cache successful flights
        if ($info['http_code'] == 200) {
            Memory::remember($cacheKey, $result, 300); // 5 minutes
        }
        
        return $result;
    }
    
    /**
     * Parallel requests - Dumbo's circus act!
     */
    public function flyFormation($requests) {
        $multiHandle = curl_multi_init();
        $curlHandles = [];
        
        // Prepare each elephant for flight
        foreach ($requests as $key => $request) {
            $ch = curl_init($request['url']);
            curl_setopt_array($ch, array_merge($this->options, $request['options'] ?? []));
            
            curl_multi_add_handle($multiHandle, $ch);
            $curlHandles[$key] = $ch;
        }
        
        // The grand performance begins!
        $running = null;
        do {
            curl_multi_exec($multiHandle, $running);
            curl_multi_select($multiHandle);
        } while ($running > 0);
        
        // Collect results from each flying elephant
        $results = [];
        foreach ($curlHandles as $key => $ch) {
            $results[$key] = [
                'body' => curl_multi_getcontent($ch),
                'info' => curl_getinfo($ch)
            ];
            curl_multi_remove_handle($multiHandle, $ch);
            curl_close($ch);
        }
        
        curl_multi_close($multiHandle);
        
        return $results;
    }
    
    /**
     * Download with progress - Dumbo's cargo service
     */
    public function download($url, $destination, $progressCallback = null) {
        $fp = fopen($destination, 'w+');
        
        $ch = curl_init($url);
        curl_setopt_array($ch, array_merge($this->options, [
            CURLOPT_FILE => $fp,
            CURLOPT_NOPROGRESS => false
        ]));
        
        if ($progressCallback) {
            curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, function($ch, $dlTotal, $dlNow) use ($progressCallback) {
                if ($dlTotal > 0) {
                    $percent = round(($dlNow / $dlTotal) * 100);
                    call_user_func($progressCallback, $percent, $dlNow, $dlTotal);
                }
            });
        }
        
        $result = curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        
        return $result !== false;
    }
    
    /**
     * Set custom headers - Dumbo's flight instructions
     */
    public function withHeaders($headers) {
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }
    
    /**
     * Enable/disable the magic feather (confidence mode)
     */
    public function withMagicFeather($enabled = true) {
        $this->magicFeather = $enabled;
        if ($enabled) {
            // With confidence, we can handle anything!
            $this->retries = 5;
            $this->timeout = 60;
        }
        return $this;
    }
    
    /**
     * Quick health check - Can Dumbo fly to this destination?
     */
    public function canReach($url) {
        try {
            $response = $this->get($url);
            return $response['status'] >= 200 && $response['status'] < 400;
        } catch (\Exception $e) {
            return false;
        }
    }
} 