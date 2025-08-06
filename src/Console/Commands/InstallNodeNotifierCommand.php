<?php

namespace LaravelNodeNotifierDesktop\Console\Commands;

use Illuminate\Console\Command;
use LaravelNodeNotifierDesktop\Services\DesktopNotifierService;

class InstallNodeNotifierCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'desktop-notifier:install {--force : Force reinstall}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Node.js dependencies for desktop notifications';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Installing Laravel Node Notifier Desktop dependencies...');
        $this->info('Platform: ' . PHP_OS_FAMILY);

        // Check if Node.js is available
        if (!$this->isNodeAvailable()) {
            $this->error('Node.js is not installed or not available in PATH.');
            $this->info('Please install Node.js from https://nodejs.org/');
            $this->info('After installation, restart your terminal and try again.');
            return 1;
        }

        $nodeVersion = $this->getNodeVersion();
        $this->info("✓ Node.js is available (version: $nodeVersion)");

        // Check npm availability
        if (!$this->isNpmAvailable()) {
            $this->error('npm is not available. Please ensure npm is installed with Node.js.');
            return 1;
        }

        $this->info('✓ npm is available');

        // Setup package.json in vendor directory
        if ($this->setupVendorPackageJson()) {
            $this->info('✓ Package configuration created');
        } else {
            $this->error('Failed to setup package configuration');
            return 1;
        }

        // Install node-notifier in vendor directory
        if ($this->installNodeNotifierInVendor()) {
            $this->info('✓ node-notifier installed successfully');
        } else {
            $this->error('Failed to install node-notifier');
            return 1;
        }

        // Copy notifier script to vendor directory
        if ($this->copyNotifierScriptToVendor()) {
            $this->info('✓ Notifier script installed successfully');
        } else {
            $this->error('Failed to install notifier script');
            return 1;
        }

        // Test notification
        if ($this->option('force') || $this->confirm('Would you like to test the installation with a sample notification?', true)) {
            $this->testNotification();
        }

        $this->info('');
        $this->info('🎉 Laravel Node Notifier Desktop installed successfully!');
        $this->info('You can now use desktop notifications in your Laravel application.');
        $this->info('');
        $this->info('Example usage:');
        $this->info('  DesktopNotifier::success("Hello", "World!");');
        
        return 0;
    }

    /**
     * Check if Node.js is available
     */
    protected function isNodeAvailable(): bool
    {
        $output = [];
        $returnCode = 0;

        exec('node --version 2>&1', $output, $returnCode);

        return $returnCode === 0;
    }

    /**
     * Get Node.js version
     */
    protected function getNodeVersion(): string
    {
        $output = [];
        $returnCode = 0;

        exec('node --version 2>&1', $output, $returnCode);

        return $returnCode === 0 ? trim($output[0] ?? 'unknown') : 'unknown';
    }

    /**
     * Check if npm is available
     */
    protected function isNpmAvailable(): bool
    {
        $output = [];
        $returnCode = 0;

        exec('npm --version 2>&1', $output, $returnCode);

        return $returnCode === 0;
    }

    /**
     * Setup package.json in vendor directory
     */
    protected function setupVendorPackageJson(): bool
    {
        $vendorDir = base_path('vendor/laravel-nodenotifierdesktop/laravel-nodenotifierdesktop');
        
        if (!is_dir($vendorDir)) {
            if (!mkdir($vendorDir, 0755, true)) {
                $this->error('Failed to create vendor directory: ' . $vendorDir);
                return false;
            }
        }

        $packageJson = [
            'name' => 'laravel-nodenotifierdesktop',
            'version' => '1.0.2',
            'description' => 'Laravel package for desktop notifications using node-notifier',
            'main' => 'notifier.js',
            'dependencies' => [
                'node-notifier' => '^10.0.1'
            ],
            'scripts' => [
                'postinstall' => 'echo "Node.js dependencies installed successfully"'
            ],
            'keywords' => ['laravel', 'notification', 'desktop', 'node-notifier'],
            'author' => 'idpcks',
            'license' => 'MIT'
        ];

        $packageJsonPath = $vendorDir . '/package.json';
        
        return file_put_contents($packageJsonPath, json_encode($packageJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) !== false;
    }

    /**
     * Install node-notifier in vendor directory
     */
    protected function installNodeNotifierInVendor(): bool
    {
        $vendorDir = base_path('vendor/laravel-nodenotifierdesktop/laravel-nodenotifierdesktop');
        
        if (!is_dir($vendorDir)) {
            $this->error('Vendor directory not found: ' . $vendorDir);
            return false;
        }

        $originalDir = getcwd();
        chdir($vendorDir);

        $command = 'npm install --production --no-save';
        
        if ($this->option('force')) {
            $command .= ' --force';
        }

        $this->info('Installing node-notifier in vendor directory...');
        
        $output = [];
        $returnCode = 0;

        exec($command . ' 2>&1', $output, $returnCode);

        chdir($originalDir);

        if ($returnCode !== 0) {
            $this->error('npm install failed:');
            foreach ($output as $line) {
                $this->error($line);
            }
            return false;
        }

        return true;
    }

    /**
     * Copy notifier script to vendor directory
     */
    protected function copyNotifierScriptToVendor(): bool
    {
        // Try multiple possible source paths
        $possibleSourcePaths = [
            __DIR__ . '/../../../notifier.js',                    // Package root
            base_path('vendor/laravel-nodenotifierdesktop/laravel-nodenotifierdesktop/notifier.js'), // Already in vendor
            dirname(dirname(dirname(__DIR__))) . '/notifier.js',  // Alternative package root
            __DIR__ . '/../../notifier.js',                       // Alternative path
        ];

        $sourcePath = null;
        foreach ($possibleSourcePaths as $path) {
            if (file_exists($path)) {
                $sourcePath = $path;
                break;
            }
        }

        if (!$sourcePath) {
            $this->error('Notifier script not found in any of these locations:');
            foreach ($possibleSourcePaths as $path) {
                $this->error('  - ' . $path);
            }
            
            // Create the notifier script directly from content
            return $this->createNotifierScriptFromContent();
        }

        $vendorDir = base_path('vendor/laravel-nodenotifierdesktop/laravel-nodenotifierdesktop');
        $targetPath = $vendorDir . '/notifier.js';

        if (!is_dir($vendorDir)) {
            $this->error('Vendor directory not found: ' . $vendorDir);
            return false;
        }

        // Check if target already exists and is the same
        if (file_exists($targetPath)) {
            if (file_get_contents($sourcePath) === file_get_contents($targetPath)) {
                $this->info('Notifier script already exists and is up to date');
                return true;
            }
        }

        if (!copy($sourcePath, $targetPath)) {
            $lastError = error_get_last();
            $this->error('Failed to copy notifier script to vendor directory');
            if ($lastError) {
                $this->error('Error: ' . $lastError['message']);
            }
            return false;
        }

        // Make script executable on Unix-like systems
        if (PHP_OS_FAMILY !== 'Windows') {
            chmod($targetPath, 0755);
        }

        return true;
    }

    /**
     * Create notifier script from embedded content if source file not found
     */
    protected function createNotifierScriptFromContent(): bool
    {
        $vendorDir = base_path('vendor/laravel-nodenotifierdesktop/laravel-nodenotifierdesktop');
        $targetPath = $vendorDir . '/notifier.js';

        if (!is_dir($vendorDir)) {
            $this->error('Vendor directory not found: ' . $vendorDir);
            return false;
        }

        // Embedded notifier script content
        $notifierContent = $this->getNotifierScriptContent();

        if (file_put_contents($targetPath, $notifierContent) === false) {
            $this->error('Failed to create notifier script');
            return false;
        }

        // Make script executable on Unix-like systems
        if (PHP_OS_FAMILY !== 'Windows') {
            chmod($targetPath, 0755);
        }

        $this->info('Notifier script created from embedded content');
        return true;
    }

    /**
     * Get the notifier script content
     */
    protected function getNotifierScriptContent(): string
    {
        return <<<'NOTIFIER_SCRIPT'
#!/usr/bin/env node

const notifier = require('node-notifier');
const path = require('path');

// Get notification data from command line arguments
const notificationData = process.argv[2];

if (!notificationData) {
    console.error('No notification data provided');
    process.exit(1);
}

try {
    const data = JSON.parse(notificationData);
    const { title, message, options = {} } = data;

    // Default options
    const defaultOptions = {
        title: title || 'Laravel Notification',
        message: message || '',
        icon: options.icon || path.join(__dirname, 'default-icon.png'),
        sound: options.sound !== false, // Default to true
        timeout: options.timeout || 5000,
        wait: false,
        type: 'info'
    };

    // Platform-specific options
    if (process.platform === 'win32') {
        defaultOptions.icon = options.icon || path.join(__dirname, 'icons', 'info.png');
    } else if (process.platform === 'darwin') {
        defaultOptions.icon = options.icon || path.join(__dirname, 'icons', 'info.png');
    } else {
        // Linux
        defaultOptions.icon = options.icon || path.join(__dirname, 'icons', 'info.png');
    }

    // Send notification
    notifier.notify(defaultOptions, (err, response) => {
        if (err) {
            console.error('Notification error:', err);
            process.exit(1);
        }
        
        console.log('Notification sent successfully');
        process.exit(0);
    });

    // Handle notification actions
    notifier.on('click', () => {
        console.log('Notification clicked');
        process.exit(0);
    });

    notifier.on('timeout', () => {
        console.log('Notification timeout');
        process.exit(0);
    });

} catch (error) {
    console.error('Error parsing notification data:', error);
    process.exit(1);
}
NOTIFIER_SCRIPT;
    }

    /**
     * Test notification to verify installation
     */
    protected function testNotification(): void
    {
        $this->info('Testing desktop notification...');
        
        try {
            $service = app(DesktopNotifierService::class);
            
            if ($service->notify('Laravel Node Notifier', 'Installation successful! 🎉')) {
                $this->info('✓ Test notification sent successfully');
            } else {
                $this->warn('⚠ Test notification failed. Check logs for details.');
            }
        } catch (\Exception $e) {
            $this->error('✗ Test notification failed: ' . $e->getMessage());
        }
    }
} 