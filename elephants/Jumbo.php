<?php
/**
 * <?tusk> TuskPHP Jumbo - The Massive File Handler
 * ===============================================
 * 
 * 🐘 BACKSTORY: Jumbo - The Original "Jumbo-Sized" Elephant
 * --------------------------------------------------------
 * Jumbo was an African elephant who lived at London Zoo from 1865 to 1882.
 * Standing 13 feet tall and weighing 7 tons, he was a sensation. P.T. Barnum
 * purchased him for his circus, where Jumbo became the most famous elephant
 * in history. His name literally became synonymous with "huge" - entering
 * dictionaries worldwide as meaning "extraordinarily large."
 * 
 * WHY THIS NAME: Just as Jumbo redefined what "large" meant, this uploader
 * handles files of extraordinary size that would make regular uploaders
 * tremble. When your users need to upload massive CSVs, huge video files,
 * or enormous datasets, Jumbo steps up. No file is too large for the
 * elephant who gave us the very word for "huge."
 * 
 * Jumbo's legacy: Making the impossible possible through sheer size and strength.
 * 
 * FEATURES:
 * - Chunked file uploads (no timeout issues)
 * - Resume interrupted uploads
 * - Progress tracking for massive files
 * - Multi-part upload support
 * - Automatic chunk verification
 * - Support for files larger than PHP memory limit
 * - CSV stream processing for huge datasets
 * 
 * "The bigger they are, the better Jumbo handles them!"
 * 
 * @package TuskPHP\Elephants
 * @author  TuskPHP Team
 * @since   1.0.0
 */

namespace TuskPHP\Elephants;

use TuskPHP\{Tusk, Memory, TuskDb};

class Jumbo {
    
    private $chunkSize = 5242880; // 5MB chunks - Jumbo-sized but manageable
    private $uploadPath = '/uploads/jumbo/';
    private $maxFileSize = 5368709120; // 5GB - Truly jumbo!
    private $activeUploads = [];
    
    /**
     * Initialize Jumbo - The giant awakens
     */
    public function __construct() {
        $this->ensureUploadDirectory();
        $this->loadActiveUploads();
    }
    
    /**
     * Start a jumbo upload - No file too large!
     */
    public function startUpload($filename, $totalSize, $metadata = []) {
        if ($totalSize > $this->maxFileSize) {
            throw new \Exception("Even Jumbo has limits! Max file size: " . $this->formatBytes($this->maxFileSize));
        }
        
        $uploadId = 'jumbo_' . bin2hex(random_bytes(16));
        
        $uploadData = [
            'id' => $uploadId,
            'filename' => $filename,
            'total_size' => $totalSize,
            'chunks_expected' => ceil($totalSize / $this->chunkSize),
            'chunks_received' => 0,
            'started_at' => time(),
            'status' => 'active',
            'metadata' => $metadata
        ];
        
        $this->activeUploads[$uploadId] = $uploadData;
        Memory::remember("jumbo_upload_{$uploadId}", $uploadData, 86400);
        
        // Like Jumbo entering the circus ring - a spectacle begins!
        return [
            'upload_id' => $uploadId,
            'chunk_size' => $this->chunkSize,
            'total_chunks' => $uploadData['chunks_expected']
        ];
    }
    
    /**
     * Upload a chunk - Piece by piece, like Jumbo's daily meals
     */
    public function uploadChunk($uploadId, $chunkNumber, $chunkData) {
        $upload = $this->activeUploads[$uploadId] ?? Memory::recall("jumbo_upload_{$uploadId}");
        
        if (!$upload) {
            throw new \Exception("Upload not found - did Jumbo forget?");
        }
        
        // Save chunk with Jumbo's reliability
        $chunkPath = $this->uploadPath . $uploadId . '/chunk_' . $chunkNumber;
        $this->saveChunk($chunkPath, $chunkData);
        
        $upload['chunks_received']++;
        $upload['last_chunk_at'] = time();
        
        // Update progress - Jumbo never loses track
        Memory::remember("jumbo_upload_{$uploadId}", $upload, 86400);
        
        // Check if all chunks received
        if ($upload['chunks_received'] >= $upload['chunks_expected']) {
            return $this->assembleFile($uploadId);
        }
        
        return [
            'status' => 'uploading',
            'progress' => round(($upload['chunks_received'] / $upload['chunks_expected']) * 100, 2)
        ];
    }
    
    /**
     * Assemble chunks into final file - Jumbo's grand finale
     */
    private function assembleFile($uploadId) {
        $upload = Memory::recall("jumbo_upload_{$uploadId}");
        $finalPath = $this->uploadPath . 'completed/' . $upload['filename'];
        
        // Like P.T. Barnum assembling the greatest show
        $this->mergeChunks($uploadId, $finalPath);
        
        $upload['status'] = 'completed';
        $upload['completed_at'] = time();
        $upload['final_path'] = $finalPath;
        
        Memory::remember("jumbo_upload_{$uploadId}", $upload, 86400);
        
        // Clean up chunks - Jumbo is tidy despite his size
        $this->cleanupChunks($uploadId);
        
        return [
            'status' => 'completed',
            'path' => $finalPath,
            'size' => $upload['total_size'],
            'duration' => $upload['completed_at'] - $upload['started_at']
        ];
    }
    
    /**
     * Stream process large CSV - Jumbo's specialty act
     */
    public function streamCSV($filepath, $callback, $chunkSize = 1000) {
        $handle = fopen($filepath, 'r');
        $header = fgetcsv($handle);
        $rowCount = 0;
        $chunk = [];
        
        // Process CSV in Jumbo-sized chunks
        while (($row = fgetcsv($handle)) !== false) {
            $chunk[] = array_combine($header, $row);
            $rowCount++;
            
            if (count($chunk) >= $chunkSize) {
                // Process chunk with callback
                call_user_func($callback, $chunk, $rowCount);
                $chunk = [];
            }
        }
        
        // Process remaining rows
        if (!empty($chunk)) {
            call_user_func($callback, $chunk, $rowCount);
        }
        
        fclose($handle);
        
        return $rowCount;
    }
    
    /**
     * Get upload status - Jumbo's memory is legendary
     */
    public function getStatus($uploadId) {
        $upload = Memory::recall("jumbo_upload_{$uploadId}");
        
        if (!$upload) {
            return ['status' => 'not_found'];
        }
        
        return [
            'status' => $upload['status'],
            'progress' => round(($upload['chunks_received'] / $upload['chunks_expected']) * 100, 2),
            'size_uploaded' => $upload['chunks_received'] * $this->chunkSize,
            'time_remaining' => $this->estimateTimeRemaining($upload)
        ];
    }
    
    /**
     * Format bytes to human readable - Even Jumbo needs translation
     */
    private function formatBytes($bytes) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.2f", $bytes / pow(1024, $factor)) . ' ' . $units[$factor];
    }
    
    /**
     * Save chunk to filesystem - Jumbo's careful storage
     */
    private function saveChunk($chunkPath, $chunkData) {
        $dir = dirname($chunkPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Decode base64 if needed
        if (is_string($chunkData) && base64_decode($chunkData, true) !== false) {
            $chunkData = base64_decode($chunkData);
        }
        
        // Write chunk with exclusive lock - Jumbo protects his treasures
        $written = file_put_contents($chunkPath, $chunkData, LOCK_EX);
        
        if ($written === false) {
            throw new \Exception("Failed to save chunk - Jumbo stumbled!");
        }
        
        // Verify chunk integrity
        $hash = hash_file('sha256', $chunkPath);
        file_put_contents($chunkPath . '.hash', $hash);
        
        return $written;
    }
    
    /**
     * Merge chunks into final file - The grand assembly
     */
    private function mergeChunks($uploadId, $finalPath) {
        $upload = Memory::recall("jumbo_upload_{$uploadId}");
        $chunkDir = $this->uploadPath . $uploadId . '/';
        
        // Ensure output directory exists
        $finalDir = dirname($finalPath);
        if (!is_dir($finalDir)) {
            mkdir($finalDir, 0755, true);
        }
        
        // Open output file for writing
        $outputHandle = fopen($finalPath, 'wb');
        if (!$outputHandle) {
            throw new \Exception("Cannot create final file - Jumbo needs more space!");
        }
        
        // Merge chunks in order - Like Jumbo's circus parade
        for ($i = 0; $i < $upload['chunks_expected']; $i++) {
            $chunkPath = $chunkDir . 'chunk_' . $i;
            
            if (!file_exists($chunkPath)) {
                fclose($outputHandle);
                unlink($finalPath);
                throw new \Exception("Missing chunk {$i} - Jumbo's puzzle incomplete!");
            }
            
            // Verify chunk integrity if hash exists
            if (file_exists($chunkPath . '.hash')) {
                $expectedHash = file_get_contents($chunkPath . '.hash');
                $actualHash = hash_file('sha256', $chunkPath);
                if ($expectedHash !== $actualHash) {
                    fclose($outputHandle);
                    unlink($finalPath);
                    throw new \Exception("Corrupted chunk {$i} - Jumbo detects tampering!");
                }
            }
            
            // Stream chunk to output file
            $chunkHandle = fopen($chunkPath, 'rb');
            stream_copy_to_stream($chunkHandle, $outputHandle);
            fclose($chunkHandle);
        }
        
        fclose($outputHandle);
        
        // Verify final file size
        $actualSize = filesize($finalPath);
        if ($actualSize !== $upload['total_size']) {
            unlink($finalPath);
            throw new \Exception("File size mismatch - Jumbo's math doesn't add up!");
        }
        
        return true;
    }
    
    /**
     * Clean up chunks after assembly - Jumbo keeps a tidy circus
     */
    private function cleanupChunks($uploadId) {
        $chunkDir = $this->uploadPath . $uploadId . '/';
        
        if (!is_dir($chunkDir)) {
            return false;
        }
        
        // Remove all chunks and their hashes
        $files = glob($chunkDir . 'chunk_*');
        foreach ($files as $file) {
            unlink($file);
        }
        
        // Remove the upload directory
        rmdir($chunkDir);
        
        // Clear from memory - Even elephants need to forget sometimes
        Memory::forget("jumbo_upload_{$uploadId}");
        unset($this->activeUploads[$uploadId]);
        
        return true;
    }
    
    /**
     * Ensure upload directories exist - Jumbo prepares his stage
     */
    private function ensureUploadDirectory() {
        $basePath = Tusk::config('app.upload_path', '/var/www/uploads');
        $this->uploadPath = $basePath . '/jumbo/';
        
        $directories = [
            $this->uploadPath,
            $this->uploadPath . 'completed/',
            $this->uploadPath . 'temp/',
            $this->uploadPath . 'abandoned/'
        ];
        
        foreach ($directories as $dir) {
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
        }
        
        // Set permissions for web server
        chmod($this->uploadPath, 0755);
    }
    
    /**
     * Load active uploads from memory - Jumbo remembers everything
     */
    private function loadActiveUploads() {
        $this->activeUploads = [];
        
        // Search for all active upload keys in memory
        $uploadKeys = Memory::search('jumbo_upload_*');
        
        foreach ($uploadKeys as $key) {
            $upload = Memory::recall($key);
            if ($upload && $upload['status'] === 'active') {
                $this->activeUploads[$upload['id']] = $upload;
            }
        }
        
        // Clean up abandoned uploads (older than 24 hours)
        $this->cleanupAbandonedUploads();
    }
    
    /**
     * Estimate time remaining - Jumbo's circus timing
     */
    private function estimateTimeRemaining($upload) {
        if ($upload['chunks_received'] === 0) {
            return null;
        }
        
        $elapsed = time() - $upload['started_at'];
        $avgTimePerChunk = $elapsed / $upload['chunks_received'];
        $chunksRemaining = $upload['chunks_expected'] - $upload['chunks_received'];
        
        $secondsRemaining = $avgTimePerChunk * $chunksRemaining;
        
        // Format time in human readable way
        if ($secondsRemaining < 60) {
            return round($secondsRemaining) . ' seconds';
        } elseif ($secondsRemaining < 3600) {
            return round($secondsRemaining / 60) . ' minutes';
        } else {
            return round($secondsRemaining / 3600, 1) . ' hours';
        }
    }
    
    /**
     * Resume an interrupted upload - Jumbo never gives up
     */
    public function resumeUpload($uploadId) {
        $upload = Memory::recall("jumbo_upload_{$uploadId}");
        
        if (!$upload) {
            throw new \Exception("Upload not found - has Jumbo forgotten?");
        }
        
        if ($upload['status'] !== 'active') {
            throw new \Exception("Upload already " . $upload['status']);
        }
        
        // Check which chunks we already have
        $receivedChunks = [];
        $chunkDir = $this->uploadPath . $uploadId . '/';
        
        for ($i = 0; $i < $upload['chunks_expected']; $i++) {
            if (file_exists($chunkDir . 'chunk_' . $i)) {
                $receivedChunks[] = $i;
            }
        }
        
        // Update chunk count
        $upload['chunks_received'] = count($receivedChunks);
        $upload['resumed_at'] = time();
        Memory::remember("jumbo_upload_{$uploadId}", $upload, 86400);
        
        return [
            'upload_id' => $uploadId,
            'chunks_received' => $receivedChunks,
            'chunks_needed' => array_diff(range(0, $upload['chunks_expected'] - 1), $receivedChunks),
            'progress' => round(($upload['chunks_received'] / $upload['chunks_expected']) * 100, 2)
        ];
    }
    
    /**
     * Verify chunk integrity - Jumbo's quality control
     */
    public function verifyChunk($uploadId, $chunkNumber, $expectedHash = null) {
        $chunkPath = $this->uploadPath . $uploadId . '/chunk_' . $chunkNumber;
        
        if (!file_exists($chunkPath)) {
            return ['valid' => false, 'error' => 'Chunk not found'];
        }
        
        $actualHash = hash_file('sha256', $chunkPath);
        
        if ($expectedHash && $actualHash !== $expectedHash) {
            return ['valid' => false, 'error' => 'Hash mismatch', 'actual' => $actualHash];
        }
        
        // Check stored hash
        if (file_exists($chunkPath . '.hash')) {
            $storedHash = file_get_contents($chunkPath . '.hash');
            if ($storedHash !== $actualHash) {
                return ['valid' => false, 'error' => 'Stored hash mismatch'];
            }
        }
        
        return ['valid' => true, 'hash' => $actualHash];
    }
    
    /**
     * Clean up abandoned uploads - Jumbo's housekeeping
     */
    private function cleanupAbandonedUploads() {
        $cutoffTime = time() - 86400; // 24 hours
        
        foreach ($this->activeUploads as $uploadId => $upload) {
            $lastActivity = $upload['last_chunk_at'] ?? $upload['started_at'];
            
            if ($lastActivity < $cutoffTime && $upload['status'] === 'active') {
                // Move to abandoned directory for potential recovery
                $sourceDir = $this->uploadPath . $uploadId . '/';
                $destDir = $this->uploadPath . 'abandoned/' . $uploadId . '/';
                
                if (is_dir($sourceDir)) {
                    rename($sourceDir, $destDir);
                }
                
                // Update status
                $upload['status'] = 'abandoned';
                $upload['abandoned_at'] = time();
                Memory::remember("jumbo_upload_{$uploadId}", $upload, 604800); // Keep for 7 days
                
                unset($this->activeUploads[$uploadId]);
            }
        }
    }
    
    /**
     * Get upload statistics - Jumbo's performance metrics
     */
    public function getStatistics() {
        $stats = [
            'active_uploads' => count($this->activeUploads),
            'total_active_size' => 0,
            'average_speed' => 0,
            'uploads_today' => 0,
            'uploads_this_week' => 0
        ];
        
        $speeds = [];
        $todayStart = strtotime('today');
        $weekStart = strtotime('monday this week');
        
        foreach ($this->activeUploads as $upload) {
            $stats['total_active_size'] += $upload['chunks_received'] * $this->chunkSize;
            
            // Calculate upload speed
            if ($upload['chunks_received'] > 0) {
                $elapsed = time() - $upload['started_at'];
                $bytesUploaded = $upload['chunks_received'] * $this->chunkSize;
                $speeds[] = $bytesUploaded / $elapsed;
            }
            
            // Count recent uploads
            if ($upload['started_at'] >= $todayStart) {
                $stats['uploads_today']++;
            }
            if ($upload['started_at'] >= $weekStart) {
                $stats['uploads_this_week']++;
            }
        }
        
        if (!empty($speeds)) {
            $stats['average_speed'] = array_sum($speeds) / count($speeds);
        }
        
        return $stats;
    }
    
    /**
     * Cancel an upload - Sometimes even Jumbo needs to stop
     */
    public function cancelUpload($uploadId) {
        $upload = Memory::recall("jumbo_upload_{$uploadId}");
        
        if (!$upload) {
            throw new \Exception("Upload not found");
        }
        
        // Clean up chunks
        $this->cleanupChunks($uploadId);
        
        // Update status
        $upload['status'] = 'cancelled';
        $upload['cancelled_at'] = time();
        Memory::remember("jumbo_upload_{$uploadId}", $upload, 3600); // Keep for 1 hour
        
        return true;
    }
} 