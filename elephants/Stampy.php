<?php
/**
 * <?tusk> TuskPHP Stampy - The App Installer
 * ==========================================
 * 
 * 🐘 BACKSTORY: Stampy - The Simpsons' Elephant
 * --------------------------------------------
 * In The Simpsons episode "Bart Gets an Elephant," Bart wins Stampy from a
 * radio contest. Stampy quickly proves to be more than the family can handle -
 * eating enormous amounts of food, destroying fences, and generally causing
 * chaos. Despite the mayhem, Stampy is lovable and eventually finds a home
 * at an animal refuge. His brief stay with the Simpsons was memorable for
 * his size, appetite, and ability to "install" himself anywhere.
 * 
 * WHY THIS NAME: Like Stampy who could break through any barrier and make
 * himself at home anywhere, this installer helps you quickly "stomp" pre-built
 * apps into your project. Stampy was too big to ignore and changed everything
 * when he arrived - just like these powerful app installations that transform
 * your project instantly.
 * 
 * "Stampy! Stampy! Where are you boy?" - Bart Simpson
 * 
 * FEATURES:
 * - One-command app installations
 * - Pre-built application templates
 * - Dependency resolution
 * - Database migration handling
 * - Configuration wizards
 * - Rollback support
 * - App marketplace integration
 * 
 * @package TuskPHP\Elephants
 * @author  TuskPHP Team
 * @since   1.0.0
 */

namespace TuskPHP\Elephants;

use TuskPHP\{Memory, TuskDb, TuskPath};
use TuskPHP\Elephants\Satao;
use TuskPHP\Elephants\Dumbo;
use TuskPHP\Elephants\Peanuts;
use TuskPHP\Elephants\Horton;

class Stampy {
    
    private $availableApps = [];
    private $installedApps = [];
    private $appRepository = 'https://apps.tuskphp.com/';
    private $localCache = '/cache/stampy/';
    private $installPath = '/installed-apps/';
    private $backupPath = '/backups/stampy/';
    private $memory;
    private $db;
    private $dumbo;
    private $peanuts;
    
    /**
     * Initialize Stampy - The elephant enters your project
     */
    public function __construct() {
        $this->memory = new Memory();
        $this->db = new TuskDb();
        $this->dumbo = new Dumbo();
        $this->peanuts = new Peanuts();
        
        // Create necessary directories
        $this->ensureDirectories();
        
        // Load configurations
        $this->loadAppCatalog();
        $this->scanInstalledApps();
    }
    
    /**
     * Ensure all required directories exist
     */
    private function ensureDirectories() {
        $dirs = [
            TuskPath::storage($this->localCache),
            TuskPath::storage($this->installPath),
            TuskPath::storage($this->backupPath),
            TuskPath::storage('/cache/stampy/downloads/'),
            TuskPath::storage('/cache/stampy/temp/')
        ];
        
        foreach ($dirs as $dir) {
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
        }
    }
    
    /**
     * Install an app - Stampy stomps it into place!
     */
    public function install($appName, $options = []) {
        echo "🐘 STAMPY IS INSTALLING: {$appName}\n";
        echo "Stand back! This elephant needs room to work!\n\n";
        
        try {
            // Check if app exists in catalog
            if (!isset($this->availableApps[$appName])) {
                throw new \Exception("D'oh! Stampy can't find '{$appName}' in the catalog!");
            }
            
            // Check if already installed
            if ($this->isInstalled($appName) && !($options['force'] ?? false)) {
                throw new \Exception("Stampy already installed {$appName}! Use --force to reinstall.");
            }
            
            $app = $this->availableApps[$appName];
            
            // Show installation plan
            $this->showInstallationPlan($app);
            
            // Check requirements - Even Stampy has standards
            echo "📋 Checking requirements...\n";
            $this->checkRequirements($app);
            
            // Download app package - Stampy fetches
            echo "\n📦 Downloading package...\n";
            $package = $this->downloadPackage($app);
            
            // Extract and install - Stampy stomps!
            echo "\n🔨 Extracting package...\n";
            $installPath = $this->extractPackage($package, $app);
            
            // Run installation scripts - Stampy's special touch
            echo "\n🚀 Running installation scripts...\n";
            $this->runInstallScripts($app, $installPath);
            
            // Configure the app - Making it feel at home
            echo "\n⚙️  Configuring the app...\n";
            $this->configureApp($app, $options);
            
            // Register as installed - Stampy never forgets
            echo "\n📝 Registering installation...\n";
            $this->registerInstallation($app);
            
            // Clear caches
            $this->memory->flush('stampy_*');
            
            echo "\n✅ Stampy successfully installed {$appName}!\n";
            echo "🎺 *triumphant elephant trumpet*\n\n";
            
            // Show post-install instructions
            $this->showPostInstallInstructions($app);
            
            return true;
            
        } catch (\Exception $e) {
            echo "\n❌ Stampy encountered a problem: " . $e->getMessage() . "\n";
            echo "🐘 *sad elephant noises*\n";
            
            // Attempt rollback
            if (isset($installPath) && is_dir($installPath)) {
                echo "\n🔄 Attempting rollback...\n";
                $this->rollbackInstallation($appName, $installPath);
            }
            
            return false;
        }
    }
    
    /**
     * Check if all requirements are met
     */
    private function checkRequirements($app) {
        $missing = [];
        $warnings = [];
        
        // Check PHP version
        if (isset($app['requirements']['php'])) {
            $required = $app['requirements']['php'];
            if (version_compare(PHP_VERSION, $required, '<')) {
                $missing[] = "PHP {$required} or higher (current: " . PHP_VERSION . ")";
            }
        }
        
        // Check PHP extensions
        $extensions = $app['requirements']['extensions'] ?? [];
        foreach ($extensions as $ext) {
            if (!extension_loaded($ext)) {
                $missing[] = "PHP extension: {$ext}";
            }
        }
        
        // Check database requirements
        if ($app['requirements']['mysql'] ?? false) {
            try {
                $this->db->query("SELECT 1");
            } catch (\Exception $e) {
                $missing[] = "MySQL database connection";
            }
        }
        
        if ($app['requirements']['redis'] ?? false) {
            if (!$this->memory->isRedisAvailable()) {
                $warnings[] = "Redis recommended for optimal performance";
            }
        }
        
        // Check disk space (Stampy needs room!)
        $requiredSpace = $this->parseSize($app['requirements']['disk_space'] ?? '100MB');
        $freeSpace = disk_free_space(TuskPath::storage());
        if ($freeSpace < $requiredSpace) {
            $missing[] = sprintf(
                "Disk space: %s required, %s available",
                $this->formatBytes($requiredSpace),
                $this->formatBytes($freeSpace)
            );
        }
        
        // Check for specific files/commands
        if (isset($app['requirements']['commands'])) {
            foreach ($app['requirements']['commands'] as $cmd) {
                if (!$this->commandExists($cmd)) {
                    $missing[] = "Command: {$cmd}";
                }
            }
        }
        
        // Check API keys if needed
        if ($app['requirements']['api_key'] ?? false) {
            $apiConfig = $this->peanuts->get('api_keys', []);
            if (empty($apiConfig)) {
                $warnings[] = "API keys may need to be configured";
            }
        }
        
        // Report results
        if (!empty($missing)) {
            echo "❌ Missing requirements:\n";
            foreach ($missing as $req) {
                echo "   - {$req}\n";
            }
            throw new \Exception("Requirements not met. Stampy can't proceed!");
        }
        
        if (!empty($warnings)) {
            echo "⚠️  Warnings:\n";
            foreach ($warnings as $warn) {
                echo "   - {$warn}\n";
            }
        }
        
        echo "✅ All requirements satisfied! Stampy is happy!\n";
    }
    
    /**
     * Download the app package
     */
    private function downloadPackage($app) {
        $packageUrl = $this->appRepository . $app['package'] ?? $app['name'] . '.zip';
        $downloadPath = TuskPath::storage($this->localCache . 'downloads/');
        $fileName = basename($packageUrl);
        $fullPath = $downloadPath . $fileName;
        
        // Check cache first
        $cacheKey = 'stampy_package_' . md5($packageUrl);
        $cachedPath = $this->memory->get($cacheKey);
        
        if ($cachedPath && file_exists($cachedPath)) {
            $cacheAge = time() - filemtime($cachedPath);
            if ($cacheAge < 3600) { // 1 hour cache
                echo "📦 Using cached package (saved " . round($cacheAge/60) . " minutes ago)\n";
                return $cachedPath;
            }
        }
        
        // Download with progress
        echo "🌐 Downloading from: {$packageUrl}\n";
        
        $response = $this->dumbo->download($packageUrl, $fullPath, [
            'progress' => function($dlTotal, $dlNow) {
                if ($dlTotal > 0) {
                    $percent = round(($dlNow / $dlTotal) * 100);
                    echo "\r📥 Progress: [{$this->makeProgressBar($percent)}] {$percent}%";
                }
            }
        ]);
        
        echo "\n";
        
        if (!$response->isSuccess()) {
            throw new \Exception("Failed to download package: " . $response->getError());
        }
        
        // Verify download
        if (!file_exists($fullPath) || filesize($fullPath) < 100) {
            throw new \Exception("Downloaded package appears to be invalid");
        }
        
        // Verify package integrity if hash provided
        if (isset($app['hash'])) {
            $actualHash = hash_file('sha256', $fullPath);
            if ($actualHash !== $app['hash']) {
                unlink($fullPath);
                throw new \Exception("Package integrity check failed! Stampy detected tampering!");
            }
            echo "🔒 Package integrity verified\n";
        }
        
        // Cache the download path
        $this->memory->set($cacheKey, $fullPath, 3600);
        
        echo "✅ Package downloaded successfully (" . $this->formatBytes(filesize($fullPath)) . ")\n";
        
        return $fullPath;
    }
    
    /**
     * Extract the package to installation directory
     */
    private function extractPackage($package, $app) {
        $tempDir = TuskPath::storage($this->localCache . 'temp/' . uniqid('stampy_'));
        $finalDir = TuskPath::app($this->installPath . $app['name']);
        
        // Create temp extraction directory
        if (!mkdir($tempDir, 0755, true)) {
            throw new \Exception("Failed to create extraction directory");
        }
        
        try {
            // Determine package type and extract
            $extension = pathinfo($package, PATHINFO_EXTENSION);
            
            switch ($extension) {
                case 'zip':
                    $this->extractZip($package, $tempDir);
                    break;
                case 'tar':
                case 'gz':
                case 'tgz':
                    $this->extractTar($package, $tempDir);
                    break;
                default:
                    throw new \Exception("Unsupported package format: {$extension}");
            }
            
            // Find the app root (might be in a subdirectory)
            $appRoot = $this->findAppRoot($tempDir);
            
            // Move to final location
            if (is_dir($finalDir)) {
                // Backup existing installation
                $backupName = $app['name'] . '_' . date('Y-m-d_His');
                $backupDir = TuskPath::storage($this->backupPath . $backupName);
                rename($finalDir, $backupDir);
                echo "📦 Backed up existing installation to: {$backupName}\n";
            }
            
            // Move extracted files to final location
            if (!rename($appRoot, $finalDir)) {
                throw new \Exception("Failed to move app to installation directory");
            }
            
            // Set proper permissions
            $this->setPermissions($finalDir);
            
            // Clean up temp directory
            $this->recursiveRemove($tempDir);
            
            echo "✅ Package extracted to: {$finalDir}\n";
            
            return $finalDir;
            
        } catch (\Exception $e) {
            // Clean up on failure
            if (is_dir($tempDir)) {
                $this->recursiveRemove($tempDir);
            }
            throw $e;
        }
    }
    
    /**
     * Run installation scripts
     */
    private function runInstallScripts($app, $installPath) {
        $scriptsRun = 0;
        
        // Look for installation scripts
        $scriptPaths = [
            'install.php',
            'setup.php',
            'scripts/install.php',
            'bin/install.php',
            '.stampy/install.php'
        ];
        
        foreach ($scriptPaths as $scriptPath) {
            $fullPath = $installPath . '/' . $scriptPath;
            if (file_exists($fullPath)) {
                echo "🔧 Running installation script: {$scriptPath}\n";
                
                try {
                    // Create isolated scope for script
                    $stampyInstaller = $this;
                    $appConfig = $app;
                    $appPath = $installPath;
                    
                    // Execute script
                    $result = include $fullPath;
                    
                    if ($result === false) {
                        throw new \Exception("Installation script failed");
                    }
                    
                    $scriptsRun++;
                    
                } catch (\Exception $e) {
                    throw new \Exception("Installation script error: " . $e->getMessage());
                }
            }
        }
        
        // Run database migrations if present
        $migrationDir = $installPath . '/migrations';
        if (is_dir($migrationDir)) {
            echo "🗄️  Running database migrations...\n";
            $this->runMigrations($migrationDir, $app['name']);
        }
        
        // Install dependencies if composer.json exists
        $composerFile = $installPath . '/composer.json';
        if (file_exists($composerFile)) {
            echo "📚 Installing dependencies...\n";
            $this->installDependencies($installPath);
        }
        
        // Create required directories
        $this->createAppDirectories($installPath, $app);
        
        // Initialize database tables if schema exists
        $schemaFile = $installPath . '/schema.sql';
        if (file_exists($schemaFile)) {
            echo "🗄️  Initializing database schema...\n";
            $this->initializeDatabase($schemaFile, $app['name']);
        }
        
        if ($scriptsRun > 0) {
            echo "✅ Installation scripts completed successfully\n";
        }
    }
    
    /**
     * Configure the installed app
     */
    private function configureApp($app, $options) {
        $configPath = TuskPath::app($this->installPath . $app['name'] . '/.peanuts');
        $config = [];
        
        // Load default configuration
        $defaultConfigPath = TuskPath::app($this->installPath . $app['name'] . '/.peanuts.default');
        if (file_exists($defaultConfigPath)) {
            $config = $this->peanuts->parseFile($defaultConfigPath);
        }
        
        // Interactive configuration if not in quick mode
        if (!($options['quick'] ?? false)) {
            echo "\n🎯 Let's configure {$app['name']}:\n";
            
            // App-specific configuration
            if (isset($app['config_prompts'])) {
                foreach ($app['config_prompts'] as $key => $prompt) {
                    $default = $config[$key] ?? $prompt['default'] ?? '';
                    $value = $this->prompt($prompt['question'], $default);
                    $config[$key] = $value;
                }
            }
            
            // Database configuration if needed
            if ($app['requirements']['mysql'] ?? false) {
                if ($this->prompt("Use default database settings?", 'yes') === 'no') {
                    $config['database'] = [
                        'host' => $this->prompt("Database host:", 'localhost'),
                        'port' => $this->prompt("Database port:", '3306'),
                        'name' => $this->prompt("Database name:", $app['name'] . '_db'),
                        'user' => $this->prompt("Database user:", 'root'),
                        'pass' => $this->promptPassword("Database password:")
                    ];
                }
            }
        }
        
        // Add app metadata
        $config['_stampy'] = [
            'app_name' => $app['name'],
            'version' => $app['version'] ?? '1.0.0',
            'installed_at' => date('Y-m-d H:i:s'),
            'installed_by' => get_current_user()
        ];
        
        // Save configuration in TuskLang format
        $this->peanuts->saveFile($configPath, $config);
        
        // Create symbolic links if needed
        $this->createSymlinks($app);
        
        // Set up routing if needed
        $this->setupRouting($app);
        
        echo "✅ Configuration saved to .peanuts file\n";
    }
    
    /**
     * Register the app as installed
     */
    private function registerInstallation($app) {
        // Update installed apps registry
        $this->installedApps[$app['name']] = [
            'name' => $app['name'],
            'version' => $app['version'] ?? '1.0.0',
            'path' => TuskPath::app($this->installPath . $app['name']),
            'installed_at' => time(),
            'size' => $app['size'],
            'features' => $app['features']
        ];
        
        // Save to persistent storage
        $registryFile = TuskPath::storage('/stampy/registry.peanuts');
        $this->peanuts->saveFile($registryFile, $this->installedApps);
        
        // Update memory cache
        $this->memory->set('stampy_installed_' . $app['name'], true);
        $this->memory->set('stampy_registry', $this->installedApps);
        
        // Log installation
        $this->logInstallation($app);
        
        // Trigger post-install event
        if (class_exists('\TuskPHP\Events\Dispatcher')) {
            \TuskPHP\Events\Dispatcher::fire('stampy.installed', [$app]);
        }
    }
    
    /**
     * Scan for already installed apps
     */
    private function scanInstalledApps() {
        // Load from registry file
        $registryFile = TuskPath::storage('/stampy/registry.peanuts');
        if (file_exists($registryFile)) {
            $this->installedApps = $this->peanuts->parseFile($registryFile);
        }
        
        // Verify installations still exist
        foreach ($this->installedApps as $name => $info) {
            if (!is_dir($info['path'])) {
                unset($this->installedApps[$name]);
            }
        }
        
        // Cache the registry
        $this->memory->set('stampy_registry', $this->installedApps);
    }
    
    /**
     * Run uninstall scripts
     */
    private function runUninstallScripts($appName) {
        if (!isset($this->installedApps[$appName])) {
            return;
        }
        
        $app = $this->installedApps[$appName];
        $installPath = $app['path'];
        
        // Look for uninstall scripts
        $scriptPaths = [
            'uninstall.php',
            'remove.php',
            'scripts/uninstall.php',
            '.stampy/uninstall.php'
        ];
        
        foreach ($scriptPaths as $scriptPath) {
            $fullPath = $installPath . '/' . $scriptPath;
            if (file_exists($fullPath)) {
                echo "🔧 Running uninstall script: {$scriptPath}\n";
                
                try {
                    include $fullPath;
                } catch (\Exception $e) {
                    echo "⚠️  Uninstall script warning: " . $e->getMessage() . "\n";
                }
            }
        }
        
        // Remove database tables if schema exists
        $dropFile = $installPath . '/drop.sql';
        if (file_exists($dropFile)) {
            echo "🗄️  Removing database tables...\n";
            try {
                $sql = file_get_contents($dropFile);
                $this->db->exec($sql);
            } catch (\Exception $e) {
                echo "⚠️  Database cleanup warning: " . $e->getMessage() . "\n";
            }
        }
    }
    
    /**
     * Remove app files
     */
    private function removeAppFiles($appName) {
        if (!isset($this->installedApps[$appName])) {
            return;
        }
        
        $app = $this->installedApps[$appName];
        $installPath = $app['path'];
        
        // Create backup before removal
        $backupName = $appName . '_final_' . date('Y-m-d_His');
        $backupDir = TuskPath::storage($this->backupPath . $backupName);
        
        if (rename($installPath, $backupDir)) {
            echo "📦 Final backup created: {$backupName}\n";
            echo "   (Can be restored from: {$backupDir})\n";
        } else {
            // If backup fails, just remove
            $this->recursiveRemove($installPath);
        }
        
        // Remove symlinks
        $this->removeSymlinks($appName);
        
        // Clean cache
        $this->memory->flush('stampy_' . $appName . '_*');
    }
    
    /**
     * Backup an app before updating
     */
    private function backupApp($appName) {
        if (!isset($this->installedApps[$appName])) {
            throw new \Exception("Can't backup - app not installed");
        }
        
        $app = $this->installedApps[$appName];
        $sourcePath = $app['path'];
        $backupName = $appName . '_v' . $app['version'] . '_' . date('Y-m-d_His');
        $backupPath = TuskPath::storage($this->backupPath . $backupName);
        
        echo "📦 Creating backup: {$backupName}\n";
        
        // Create backup directory
        if (!mkdir($backupPath, 0755, true)) {
            throw new \Exception("Failed to create backup directory");
        }
        
        // Copy files
        $this->recursiveCopy($sourcePath, $backupPath);
        
        // Backup database if applicable
        if (file_exists($sourcePath . '/schema.sql')) {
            $this->backupDatabase($appName, $backupPath);
        }
        
        // Create backup manifest
        $manifest = [
            'app_name' => $appName,
            'version' => $app['version'],
            'backup_date' => date('Y-m-d H:i:s'),
            'source_path' => $sourcePath,
            'files_count' => $this->countFiles($backupPath),
            'total_size' => $this->getDirectorySize($backupPath)
        ];
        
        $this->peanuts->saveFile($backupPath . '/.backup-manifest.peanuts', $manifest);
        
        echo "✅ Backup completed successfully\n";
        
        return $backupPath;
    }
    
    // ═══════════════════════════════════════════
    // HELPER METHODS
    // ═══════════════════════════════════════════
    
    /**
     * Show installation plan before proceeding
     */
    private function showInstallationPlan($app) {
        echo "\n📋 INSTALLATION PLAN\n";
        echo "═══════════════════════════════\n";
        echo "App: {$app['name']}\n";
        echo "Description: {$app['description']}\n";
        echo "Size: {$app['size']} (" . $this->getElephantSize($app['size']) . ")\n";
        echo "Features: " . implode(', ', $app['features']) . "\n";
        
        if (isset($app['requirements'])) {
            echo "\nRequirements:\n";
            foreach ($app['requirements'] as $key => $value) {
                if (is_bool($value)) {
                    echo "  - {$key}: " . ($value ? 'Required' : 'Optional') . "\n";
                } else {
                    echo "  - {$key}: {$value}\n";
                }
            }
        }
        
        echo "\n";
    }
    
    /**
     * Show post-installation instructions
     */
    private function showPostInstallInstructions($app) {
        $installPath = TuskPath::app($this->installPath . $app['name']);
        
        echo "📚 POST-INSTALLATION INSTRUCTIONS\n";
        echo "═══════════════════════════════════\n";
        echo "✅ {$app['name']} has been installed to:\n";
        echo "   {$installPath}\n\n";
        
        // Check for README
        $readmePaths = ['README.md', 'readme.md', 'README.txt', 'docs/README.md'];
        foreach ($readmePaths as $readmePath) {
            if (file_exists($installPath . '/' . $readmePath)) {
                echo "📖 Documentation available at:\n";
                echo "   {$installPath}/{$readmePath}\n\n";
                break;
            }
        }
        
        // App-specific instructions
        if (isset($app['post_install'])) {
            echo $app['post_install'] . "\n\n";
        }
        
        // Default instructions based on app type
        echo "🚀 Next steps:\n";
        echo "   1. Review the configuration in .peanuts\n";
        echo "   2. Set up your web server to point to the app\n";
        echo "   3. Run any pending migrations\n";
        echo "   4. Clear your cache if needed\n\n";
        
        echo "Need help? Run: tusk help {$app['name']}\n";
    }
    
    /**
     * Extract ZIP archives
     */
    private function extractZip($zipFile, $destination) {
        $zip = new \ZipArchive();
        if ($zip->open($zipFile) !== true) {
            throw new \Exception("Failed to open ZIP file");
        }
        
        if (!$zip->extractTo($destination)) {
            $zip->close();
            throw new \Exception("Failed to extract ZIP file");
        }
        
        $zip->close();
    }
    
    /**
     * Extract TAR archives
     */
    private function extractTar($tarFile, $destination) {
        $command = "tar -xf " . escapeshellarg($tarFile) . " -C " . escapeshellarg($destination);
        exec($command . " 2>&1", $output, $returnCode);
        
        if ($returnCode !== 0) {
            throw new \Exception("Failed to extract TAR file: " . implode("\n", $output));
        }
    }
    
    /**
     * Find the app root directory in extracted files
     */
    private function findAppRoot($extractDir) {
        // Check if files are directly in extract dir
        if (file_exists($extractDir . '/composer.json') || 
            file_exists($extractDir . '/.peanuts') ||
            file_exists($extractDir . '/index.php')) {
            return $extractDir;
        }
        
        // Check first level subdirectories
        $dirs = glob($extractDir . '/*', GLOB_ONLYDIR);
        if (count($dirs) === 1) {
            // Single directory - probably the app root
            return $dirs[0];
        }
        
        // Look for directory with app files
        foreach ($dirs as $dir) {
            if (file_exists($dir . '/composer.json') || 
                file_exists($dir . '/.peanuts') ||
                file_exists($dir . '/index.php')) {
                return $dir;
            }
        }
        
        // Default to extract directory
        return $extractDir;
    }
    
    /**
     * Set proper permissions on app directory
     */
    private function setPermissions($dir) {
        // Set directory permissions
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        
        foreach ($iterator as $item) {
            if ($item->isDir()) {
                chmod($item, 0755);
            } else {
                chmod($item, 0644);
            }
        }
        
        // Make specific directories writable
        $writableDirs = ['storage', 'cache', 'logs', 'uploads'];
        foreach ($writableDirs as $writeDir) {
            $fullPath = $dir . '/' . $writeDir;
            if (is_dir($fullPath)) {
                chmod($fullPath, 0777);
            }
        }
        
        // Make scripts executable
        $scripts = glob($dir . '/bin/*');
        foreach ($scripts as $script) {
            if (is_file($script)) {
                chmod($script, 0755);
            }
        }
    }
    
    /**
     * Recursively remove a directory
     */
    private function recursiveRemove($dir) {
        if (!is_dir($dir)) {
            return;
        }
        
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        
        foreach ($iterator as $item) {
            if ($item->isDir()) {
                rmdir($item);
            } else {
                unlink($item);
            }
        }
        
        rmdir($dir);
    }
    
    /**
     * Recursively copy a directory
     */
    private function recursiveCopy($src, $dst) {
        $dir = opendir($src);
        @mkdir($dst);
        
        while (($file = readdir($dir)) !== false) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->recursiveCopy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        
        closedir($dir);
    }
    
    /**
     * Available apps catalog - Stampy's menu
     */
    private function loadAppCatalog() {
        // First try to load from remote catalog
        try {
            $catalogUrl = $this->appRepository . 'catalog.json';
            $response = $this->dumbo->get($catalogUrl);
            
            if ($response->isSuccess()) {
                $remoteCatalog = json_decode($response->getBody(), true);
                if (is_array($remoteCatalog)) {
                    $this->availableApps = array_merge($this->availableApps, $remoteCatalog);
                }
            }
        } catch (\Exception $e) {
            // Fall back to local catalog
        }
        
        // Load built-in catalog
        $this->availableApps = array_merge($this->availableApps, [
            'reddit' => [
                'name' => 'Reddit Clone',
                'description' => 'Full-featured Reddit-style community platform',
                'size' => 'XXL', // Stampy-sized!
                'features' => ['voting', 'comments', 'subreddits', 'karma'],
                'requirements' => ['php' => '8.0', 'mysql' => true],
                'version' => '2.0.0',
                'package' => 'reddit-clone-v2.zip',
                'hash' => 'a7b9c2d4e5f6789012345678901234567890abcdef1234567890abcdef123456'
            ],
            'facebook' => [
                'name' => 'Social Network',
                'description' => 'Facebook-inspired social platform',
                'size' => 'XXXL', // Even bigger than Stampy!
                'features' => ['profiles', 'friends', 'posts', 'messages', 'groups'],
                'requirements' => ['php' => '8.0', 'mysql' => true, 'redis' => true],
                'version' => '3.0.0',
                'package' => 'social-network-v3.zip'
            ],
            'claude' => [
                'name' => 'AI Chat Interface',
                'description' => 'Claude-style AI assistant interface',
                'size' => 'L',
                'features' => ['chat', 'history', 'api-integration'],
                'requirements' => ['php' => '8.0', 'api_key' => true],
                'version' => '1.5.0',
                'package' => 'ai-chat-v1.5.zip',
                'config_prompts' => [
                    'api_key' => [
                        'question' => 'Enter your Claude API key:',
                        'default' => ''
                    ],
                    'model' => [
                        'question' => 'Select Claude model (claude-3-opus, claude-3-sonnet):',
                        'default' => 'claude-3-opus'
                    ]
                ]
            ],
            'instagram' => [
                'name' => 'Photo Sharing App',
                'description' => 'Instagram-like photo sharing platform',
                'size' => 'XL',
                'features' => ['photos', 'filters', 'stories', 'followers'],
                'requirements' => [
                    'php' => '8.0', 
                    'mysql' => true, 
                    'extensions' => ['gd', 'imagick'],
                    'disk_space' => '500MB'
                ],
                'version' => '2.1.0',
                'package' => 'photo-sharing-v2.1.zip'
            ],
            'blog' => [
                'name' => 'Blog Platform',
                'description' => 'Simple but powerful blogging system',
                'size' => 'M',
                'features' => ['posts', 'categories', 'comments', 'rss'],
                'requirements' => ['php' => '7.4'],
                'version' => '1.0.0',
                'package' => 'blog-platform-v1.zip',
                'post_install' => "Your blog is ready! Visit /admin to start writing."
            ],
            'shop' => [
                'name' => 'E-commerce Platform',
                'description' => 'Full shopping cart system',
                'size' => 'XL',
                'features' => ['products', 'cart', 'checkout', 'payments'],
                'requirements' => [
                    'php' => '8.0', 
                    'mysql' => true,
                    'extensions' => ['curl', 'openssl']
                ],
                'version' => '2.5.0',
                'package' => 'ecommerce-v2.5.zip',
                'config_prompts' => [
                    'stripe_key' => [
                        'question' => 'Enter your Stripe publishable key (optional):',
                        'default' => ''
                    ],
                    'currency' => [
                        'question' => 'Default currency (USD, EUR, GBP):',
                        'default' => 'USD'
                    ]
                ]
            ]
        ]);
    }
    
    /**
     * Quick install command - Stampy's rampage mode
     */
    public function stomp($appName) {
        // Simpsons reference: "Stampy, NO!"
        echo "🐘 STAMPY STOMP MODE ACTIVATED!\n";
        echo "Installing {$appName} with maximum elephant force!\n\n";
        
        return $this->install($appName, ['quick' => true, 'force' => true]);
    }
    
    /**
     * List available apps - What can Stampy install?
     */
    public function catalog() {
        echo "🐘 STAMPY'S APP CATALOG\n";
        echo "======================\n\n";
        
        foreach ($this->availableApps as $key => $app) {
            // Check if installed
            $installed = $this->isInstalled($key);
            $status = $installed ? " ✅ INSTALLED" : "";
            
            echo "📦 stampy->{$key}{$status}\n";
            echo "   Name: {$app['name']} v{$app['version']}\n";
            echo "   Size: {$app['size']} (";
            echo $this->getElephantSize($app['size']);
            echo ")\n";
            echo "   Description: {$app['description']}\n";
            echo "   Features: " . implode(', ', $app['features']) . "\n";
            
            if ($installed && isset($this->installedApps[$key])) {
                $info = $this->installedApps[$key];
                echo "   Installed: " . date('Y-m-d H:i', $info['installed_at']) . "\n";
            }
            
            echo "\n";
        }
        
        echo "Use: stampy->install('app-name') to install!\n";
        echo "Use: stampy->stomp('app-name') for quick install!\n";
    }
    
    /**
     * Uninstall an app - Sometimes Stampy must leave
     */
    public function uninstall($appName) {
        if (!isset($this->installedApps[$appName])) {
            throw new \Exception("Stampy hasn't installed {$appName} yet!");
        }
        
        echo "🐘 Stampy is sadly removing {$appName}...\n";
        
        // Confirm uninstallation
        if ($this->prompt("Are you sure you want to uninstall {$appName}?", 'no') !== 'yes') {
            echo "Uninstallation cancelled. Stampy is relieved!\n";
            return false;
        }
        
        try {
            // Run uninstall scripts
            $this->runUninstallScripts($appName);
            
            // Remove files - Stampy cleans up
            $this->removeAppFiles($appName);
            
            // Update registry
            unset($this->installedApps[$appName]);
            $this->memory->forget("stampy_installed_{$appName}");
            
            // Save updated registry
            $registryFile = TuskPath::storage('/stampy/registry.peanuts');
            $this->peanuts->saveFile($registryFile, $this->installedApps);
            
            // Clear related cache
            $this->memory->flush('stampy_' . $appName . '_*');
            
            echo "😢 {$appName} has been uninstalled. Stampy will miss it.\n";
            
            return true;
            
        } catch (\Exception $e) {
            echo "❌ Uninstall failed: " . $e->getMessage() . "\n";
            return false;
        }
    }
    
    /**
     * Get elephant-sized descriptions
     */
    private function getElephantSize($size) {
        $sizes = [
            'M' => 'Baby elephant - quick and easy',
            'L' => 'Young elephant - moderate setup',
            'XL' => 'Adult elephant - substantial app',
            'XXL' => 'Stampy-sized - big installation!',
            'XXXL' => 'Bigger than Stampy! Massive platform'
        ];
        
        return $sizes[$size] ?? 'Unknown size';
    }
    
    /**
     * Check if Stampy has already installed an app
     */
    public function isInstalled($appName) {
        return isset($this->installedApps[$appName]);
    }
    
    /**
     * Update an installed app - Stampy learns new tricks
     */
    public function update($appName) {
        if (!$this->isInstalled($appName)) {
            throw new \Exception("Can't update what Stampy hasn't installed!");
        }
        
        echo "🐘 Stampy is updating {$appName}...\n";
        
        try {
            // Check for newer version
            if (!isset($this->availableApps[$appName])) {
                throw new \Exception("No update available for {$appName}");
            }
            
            $currentVersion = $this->installedApps[$appName]['version'] ?? '0.0.0';
            $newVersion = $this->availableApps[$appName]['version'] ?? '0.0.0';
            
            if (version_compare($newVersion, $currentVersion, '<=')) {
                echo "✅ {$appName} is already up to date (v{$currentVersion})\n";
                return true;
            }
            
            echo "📦 Updating from v{$currentVersion} to v{$newVersion}\n";
            
            // Backup current version - Stampy is careful
            $this->backupApp($appName);
            
            // Install new version
            $result = $this->install($appName, ['update' => true, 'force' => true]);
            
            if ($result) {
                echo "✅ Update complete! Stampy learned new {$appName} tricks!\n";
            }
            
            return $result;
            
        } catch (\Exception $e) {
            echo "❌ Update failed: " . $e->getMessage() . "\n";
            echo "Your previous version is still intact.\n";
            return false;
        }
    }
    
    /**
     * Get information about an installed app
     */
    public function info($appName) {
        if (!$this->isInstalled($appName)) {
            echo "❌ {$appName} is not installed\n";
            return;
        }
        
        $app = $this->installedApps[$appName];
        
        echo "🐘 APP INFORMATION: {$appName}\n";
        echo "═══════════════════════════════\n";
        echo "Version: {$app['version']}\n";
        echo "Path: {$app['path']}\n";
        echo "Installed: " . date('Y-m-d H:i:s', $app['installed_at']) . "\n";
        echo "Size: {$app['size']}\n";
        echo "Features: " . implode(', ', $app['features']) . "\n";
        
        // Check directory size
        if (is_dir($app['path'])) {
            $dirSize = $this->getDirectorySize($app['path']);
            echo "Disk usage: " . $this->formatBytes($dirSize) . "\n";
        }
        
        // Check for updates
        if (isset($this->availableApps[$appName])) {
            $availableVersion = $this->availableApps[$appName]['version'] ?? '0.0.0';
            if (version_compare($availableVersion, $app['version'], '>')) {
                echo "\n⚠️  Update available: v{$availableVersion}\n";
                echo "Run: stampy->update('{$appName}') to update\n";
            }
        }
    }
    
    // ═══════════════════════════════════════════
    // UTILITY METHODS
    // ═══════════════════════════════════════════
    
    /**
     * Parse size string to bytes
     */
    private function parseSize($size) {
        $units = ['B' => 1, 'KB' => 1024, 'MB' => 1048576, 'GB' => 1073741824];
        preg_match('/^(\d+(?:\.\d+)?)\s*([KMGT]?B)?$/i', $size, $matches);
        
        $number = (float) $matches[1];
        $unit = strtoupper($matches[2] ?? 'B');
        
        return $number * ($units[$unit] ?? 1);
    }
    
    /**
     * Format bytes to human readable
     */
    private function formatBytes($bytes, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
    
    /**
     * Check if a command exists
     */
    private function commandExists($cmd) {
        $return = shell_exec(sprintf("which %s 2>/dev/null", escapeshellarg($cmd)));
        return !empty($return);
    }
    
    /**
     * Make a progress bar
     */
    private function makeProgressBar($percent) {
        $width = 40;
        $complete = round(($percent / 100) * $width);
        $incomplete = $width - $complete;
        
        return str_repeat('█', $complete) . str_repeat('░', $incomplete);
    }
    
    /**
     * Simple prompt for user input
     */
    private function prompt($question, $default = '') {
        $defaultText = $default ? " [{$default}]" : '';
        echo "{$question}{$defaultText}: ";
        
        $input = trim(fgets(STDIN));
        return $input ?: $default;
    }
    
    /**
     * Prompt for password (hidden input)
     */
    private function promptPassword($question) {
        echo "{$question}: ";
        system('stty -echo');
        $password = trim(fgets(STDIN));
        system('stty echo');
        echo "\n";
        return $password;
    }
    
    /**
     * Get directory size
     */
    private function getDirectorySize($dir) {
        $size = 0;
        
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS)
        );
        
        foreach ($iterator as $file) {
            $size += $file->getSize();
        }
        
        return $size;
    }
    
    /**
     * Count files in directory
     */
    private function countFiles($dir) {
        $count = 0;
        
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS)
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $count++;
            }
        }
        
        return $count;
    }
    
    /**
     * Run database migrations
     */
    private function runMigrations($migrationDir, $appName) {
        $migrations = glob($migrationDir . '/*.sql');
        sort($migrations);
        
        foreach ($migrations as $migration) {
            $name = basename($migration);
            echo "  Running migration: {$name}\n";
            
            try {
                $sql = file_get_contents($migration);
                $this->db->exec($sql);
            } catch (\Exception $e) {
                throw new \Exception("Migration {$name} failed: " . $e->getMessage());
            }
        }
    }
    
    /**
     * Install composer dependencies
     */
    private function installDependencies($installPath) {
        if (!$this->commandExists('composer')) {
            echo "  ⚠️  Composer not found - skipping dependency installation\n";
            return;
        }
        
        $originalDir = getcwd();
        chdir($installPath);
        
        $command = "composer install --no-dev --optimize-autoloader 2>&1";
        exec($command, $output, $returnCode);
        
        chdir($originalDir);
        
        if ($returnCode !== 0) {
            throw new \Exception("Dependency installation failed: " . implode("\n", $output));
        }
    }
    
    /**
     * Create required app directories
     */
    private function createAppDirectories($installPath, $app) {
        $directories = [
            'storage',
            'storage/cache',
            'storage/logs',
            'storage/uploads',
            'storage/temp',
            'public/uploads',
            'public/assets'
        ];
        
        // Add app-specific directories
        if (isset($app['directories'])) {
            $directories = array_merge($directories, $app['directories']);
        }
        
        foreach ($directories as $dir) {
            $fullPath = $installPath . '/' . $dir;
            if (!is_dir($fullPath)) {
                mkdir($fullPath, 0755, true);
            }
        }
    }
    
    /**
     * Initialize database schema
     */
    private function initializeDatabase($schemaFile, $appName) {
        try {
            $sql = file_get_contents($schemaFile);
            
            // Replace placeholders
            $sql = str_replace('{{app_name}}', $appName, $sql);
            $sql = str_replace('{{prefix}}', $appName . '_', $sql);
            
            $this->db->exec($sql);
        } catch (\Exception $e) {
            throw new \Exception("Database initialization failed: " . $e->getMessage());
        }
    }
    
    /**
     * Create symbolic links for the app
     */
    private function createSymlinks($app) {
        $appPath = TuskPath::app($this->installPath . $app['name']);
        
        // Create public symlink if needed
        $publicLink = TuskPath::public($app['name']);
        $publicDir = $appPath . '/public';
        
        if (is_dir($publicDir) && !is_link($publicLink)) {
            symlink($publicDir, $publicLink);
            echo "  Created public symlink: /{$app['name']}\n";
        }
        
        // Create CLI symlink if needed
        $binFile = $appPath . '/bin/' . $app['name'];
        if (file_exists($binFile)) {
            $cliLink = '/usr/local/bin/' . $app['name'];
            if (!is_link($cliLink)) {
                symlink($binFile, $cliLink);
                echo "  Created CLI command: {$app['name']}\n";
            }
        }
    }
    
    /**
     * Remove symbolic links
     */
    private function removeSymlinks($appName) {
        // Remove public symlink
        $publicLink = TuskPath::public($appName);
        if (is_link($publicLink)) {
            unlink($publicLink);
        }
        
        // Remove CLI symlink
        $cliLink = '/usr/local/bin/' . $appName;
        if (is_link($cliLink)) {
            unlink($cliLink);
        }
    }
    
    /**
     * Setup routing for the app
     */
    private function setupRouting($app) {
        // Add to TuskPHP router if needed
        $routeFile = TuskPath::config('routes/' . $app['name'] . '.peanuts');
        
        if (isset($app['routes'])) {
            $routes = [
                '_meta' => [
                    'app' => $app['name'],
                    'prefix' => '/' . $app['name']
                ],
                'routes' => $app['routes']
            ];
            
            $this->peanuts->saveFile($routeFile, $routes);
            echo "  Created routing configuration\n";
        }
    }
    
    /**
     * Rollback a failed installation
     */
    private function rollbackInstallation($appName, $installPath) {
        try {
            // Remove installation directory
            if (is_dir($installPath)) {
                $this->recursiveRemove($installPath);
            }
            
            // Remove from registry
            unset($this->installedApps[$appName]);
            $this->memory->forget("stampy_installed_{$appName}");
            
            // Remove any created symlinks
            $this->removeSymlinks($appName);
            
            echo "✅ Rollback completed\n";
            
        } catch (\Exception $e) {
            echo "⚠️  Rollback warning: " . $e->getMessage() . "\n";
        }
    }
    
    /**
     * Log installation for audit trail
     */
    private function logInstallation($app) {
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'action' => 'install',
            'app' => $app['name'],
            'version' => $app['version'] ?? '1.0.0',
            'user' => get_current_user(),
            'php_version' => PHP_VERSION,
            'tusk_version' => TUSK_VERSION ?? '1.0.0'
        ];
        
        $logFile = TuskPath::storage('/logs/stampy.log');
        file_put_contents(
            $logFile,
            json_encode($logEntry) . "\n",
            FILE_APPEND | LOCK_EX
        );
    }
    
    /**
     * Backup database for an app
     */
    private function backupDatabase($appName, $backupPath) {
        try {
            $dumpFile = $backupPath . '/database.sql';
            
            // Get database config for the app
            $appConfig = $this->peanuts->parseFile(
                TuskPath::app($this->installPath . $appName . '/.peanuts')
            );
            
            if (isset($appConfig['database'])) {
                $db = $appConfig['database'];
                $command = sprintf(
                    'mysqldump -h%s -P%s -u%s -p%s %s > %s 2>&1',
                    escapeshellarg($db['host'] ?? 'localhost'),
                    escapeshellarg($db['port'] ?? '3306'),
                    escapeshellarg($db['user'] ?? 'root'),
                    escapeshellarg($db['pass'] ?? ''),
                    escapeshellarg($db['name'] ?? $appName . '_db'),
                    escapeshellarg($dumpFile)
                );
                
                exec($command, $output, $returnCode);
                
                if ($returnCode === 0) {
                    echo "  Database backed up successfully\n";
                }
            }
        } catch (\Exception $e) {
            echo "  ⚠️  Database backup skipped: " . $e->getMessage() . "\n";
        }
    }
} 