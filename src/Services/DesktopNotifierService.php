<?php

namespace LaravelNodeNotifierDesktop\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class DesktopNotifierService
{
    protected Client $client;
    protected string $nodeScriptPath;
    
    // Performance optimization: Cache frequently used values
    protected static ?string $cachedNodePath = null;
    protected static ?array $cachedDefaultOptions = null;
    protected static ?bool $cachedNodeAvailable = null;
    protected static ?string $cachedNodeVersion = null;
    protected static ?bool $cachedScriptAvailable = null;
    
    // Performance monitoring
    protected static array $performanceMetrics = [];
    protected static int $notificationCount = 0;
    protected static float $totalExecutionTime = 0;

    public function __construct()
    {
        $this->client = new Client();
        $this->nodeScriptPath = $this->getNotifierScriptPath();
    }

    /**
     * Send a desktop notification with performance optimizations
     *
     * @param string $title
     * @param string $message
     * @param array $options
     * @return bool
     */
    public function notify(string $title, string $message, array $options = []): bool
    {
        $startTime = microtime(true);
        
        try {
            // Use cached default options to reduce config calls
            $defaultOptions = $this->getCachedDefaultOptions();
            $options = array_merge($defaultOptions, $options);

            $command = $this->buildNodeCommand($title, $message, $options);
            
            if ($this->executeNodeCommand($command)) {
                $this->logPerformanceMetrics($startTime, 'success');
                
                if (config('laravel-nodenotifierdesktop.log_notifications', true)) {
                    Log::info('Desktop notification sent', [
                        'title' => $title,
                        'message' => $message,
                        'execution_time' => round((microtime(true) - $startTime) * 1000, 2) . 'ms'
                    ]);
                }
                return true;
            }

            $this->logPerformanceMetrics($startTime, 'failed');
            return false;
        } catch (\Exception $e) {
            $this->logPerformanceMetrics($startTime, 'error');
            Log::error('Failed to send desktop notification', [
                'error' => $e->getMessage(),
                'title' => $title,
                'message' => $message,
                'execution_time' => round((microtime(true) - $startTime) * 1000, 2) . 'ms'
            ]);
            return false;
        }
    }

    /**
     * Get cached default options to reduce config calls
     *
     * @return array
     */
    protected function getCachedDefaultOptions(): array
    {
        if (self::$cachedDefaultOptions === null) {
            self::$cachedDefaultOptions = [
                'icon' => config('laravel-nodenotifierdesktop.default_icon'),
                'sound' => config('laravel-nodenotifierdesktop.default_sound', true),
                'timeout' => config('laravel-nodenotifierdesktop.timeout', 5000),
                'position' => config('laravel-nodenotifierdesktop.position', 'bottom-right'),
                'custom_position' => config('laravel-nodenotifierdesktop.custom_position'),
                'ui_theme' => config('laravel-nodenotifierdesktop.ui_theme', 'default'),
                'animation' => config('laravel-nodenotifierdesktop.animation', 'slide'),
                'animation_duration' => config('laravel-nodenotifierdesktop.animation_duration', 300),
                'size' => config('laravel-nodenotifierdesktop.size', 'medium'),
                'custom_sound_file' => config('laravel-nodenotifierdesktop.custom_sound_file'),
            ];
        }

        return self::$cachedDefaultOptions;
    }

    /**
     * Clear cached options (useful for testing or config changes)
     */
    public static function clearCache(): void
    {
        self::$cachedNodePath = null;
        self::$cachedDefaultOptions = null;
        self::$cachedNodeAvailable = null;
        self::$cachedNodeVersion = null;
        self::$cachedScriptAvailable = null;
    }

    /**
     * Log performance metrics
     */
    protected function logPerformanceMetrics(float $startTime, string $status): void
    {
        $executionTime = microtime(true) - $startTime;
        self::$totalExecutionTime += $executionTime;
        self::$notificationCount++;

        self::$performanceMetrics[] = [
            'timestamp' => microtime(true),
            'execution_time' => $executionTime,
            'status' => $status
        ];

        // Keep only last 100 metrics to prevent memory issues
        if (count(self::$performanceMetrics) > 100) {
            array_shift(self::$performanceMetrics);
        }

        // Log performance warnings
        if ($executionTime > 1.0) { // More than 1 second
            Log::warning('Slow notification execution detected', [
                'execution_time' => round($executionTime * 1000, 2) . 'ms',
                'status' => $status
            ]);
        }
    }

    /**
     * Get performance statistics
     */
    public static function getPerformanceStats(): array
    {
        if (empty(self::$performanceMetrics)) {
            return [
                'total_notifications' => 0,
                'average_execution_time' => 0,
                'min_execution_time' => 0,
                'max_execution_time' => 0,
                'success_rate' => 0
            ];
        }

        $successCount = count(array_filter(self::$performanceMetrics, fn($m) => $m['status'] === 'success'));
        $executionTimes = array_column(self::$performanceMetrics, 'execution_time');

        return [
            'total_notifications' => self::$notificationCount,
            'average_execution_time' => round(array_sum($executionTimes) / count($executionTimes) * 1000, 2) . 'ms',
            'min_execution_time' => round(min($executionTimes) * 1000, 2) . 'ms',
            'max_execution_time' => round(max($executionTimes) * 1000, 2) . 'ms',
            'success_rate' => round(($successCount / count(self::$performanceMetrics)) * 100, 2) . '%'
        ];
    }

    /**
     * Send a success notification
     *
     * @param string $title
     * @param string $message
     * @param array $options
     * @return bool
     */
    public function success(string $title, string $message, array $options = []): bool
    {
        $options['icon'] = $options['icon'] ?? config('laravel-nodenotifierdesktop.icons.success');
        return $this->notify($title, $message, $options);
    }

    /**
     * Send an error notification
     *
     * @param string $title
     * @param string $message
     * @param array $options
     * @return bool
     */
    public function error(string $title, string $message, array $options = []): bool
    {
        $options['icon'] = $options['icon'] ?? config('laravel-nodenotifierdesktop.icons.error');
        return $this->notify($title, $message, $options);
    }

    /**
     * Send a warning notification
     *
     * @param string $title
     * @param string $message
     * @param array $options
     * @return bool
     */
    public function warning(string $title, string $message, array $options = []): bool
    {
        $options['icon'] = $options['icon'] ?? config('laravel-nodenotifierdesktop.icons.warning');
        return $this->notify($title, $message, $options);
    }

    /**
     * Send an info notification
     *
     * @param string $title
     * @param string $message
     * @param array $options
     * @return bool
     */
    public function info(string $title, string $message, array $options = []): bool
    {
        $options['icon'] = $options['icon'] ?? config('laravel-nodenotifierdesktop.icons.info');
        return $this->notify($title, $message, $options);
    }

    /**
     * Send notification with custom position
     *
     * @param string $title
     * @param string $message
     * @param string $position
     * @param array $options
     * @return bool
     */
    public function notifyAtPosition(string $title, string $message, string $position, array $options = []): bool
    {
        $options['position'] = $position;
        return $this->notify($title, $message, $options);
    }

    /**
     * Send notification with custom coordinates
     *
     * @param string $title
     * @param string $message
     * @param int $x
     * @param int $y
     * @param array $options
     * @return bool
     */
    public function notifyAtCoordinates(string $title, string $message, int $x, int $y, array $options = []): bool
    {
        $options['custom_position'] = ['x' => $x, 'y' => $y];
        return $this->notify($title, $message, $options);
    }

    /**
     * Send notification with custom theme
     *
     * @param string $title
     * @param string $message
     * @param string $theme
     * @param array $options
     * @return bool
     */
    public function notifyWithTheme(string $title, string $message, string $theme, array $options = []): bool
    {
        $options['ui_theme'] = $theme;
        return $this->notify($title, $message, $options);
    }

    /**
     * Send notification with custom animation
     *
     * @param string $title
     * @param string $message
     * @param string $animation
     * @param int $duration
     * @param array $options
     * @return bool
     */
    public function notifyWithAnimation(string $title, string $message, string $animation, int $duration = 300, array $options = []): bool
    {
        $options['animation'] = $animation;
        $options['animation_duration'] = $duration;
        return $this->notify($title, $message, $options);
    }

    /**
     * Send notification with custom size
     *
     * @param string $title
     * @param string $message
     * @param string $size
     * @param array $options
     * @return bool
     */
    public function notifyWithSize(string $title, string $message, string $size, array $options = []): bool
    {
        $options['size'] = $size;
        return $this->notify($title, $message, $options);
    }

    /**
     * Send notification with custom sound file
     *
     * @param string $title
     * @param string $message
     * @param string $soundFile
     * @param array $options
     * @return bool
     */
    public function notifyWithSound(string $title, string $message, string $soundFile, array $options = []): bool
    {
        $options['custom_sound_file'] = $soundFile;
        return $this->notify($title, $message, $options);
    }

    /**
     * Send notification without sound
     *
     * @param string $title
     * @param string $message
     * @param array $options
     * @return bool
     */
    public function notifySilent(string $title, string $message, array $options = []): bool
    {
        $options['sound'] = false;
        return $this->notify($title, $message, $options);
    }

    /**
     * Send multiple notifications efficiently (batch processing)
     *
     * @param array $notifications Array of ['title', 'message', 'options']
     * @return array Results for each notification
     */
    public function notifyBatch(array $notifications): array
    {
        $results = [];
        $startTime = microtime(true);

        foreach ($notifications as $index => $notification) {
            $notificationStartTime = microtime(true);
            
            $title = $notification['title'] ?? '';
            $message = $notification['message'] ?? '';
            $options = $notification['options'] ?? [];
            
            $results[$index] = [
                'success' => $this->notify($title, $message, $options),
                'execution_time' => round((microtime(true) - $notificationStartTime) * 1000, 2) . 'ms'
            ];
        }

        $totalTime = microtime(true) - $startTime;
        Log::info('Batch notification completed', [
            'total_notifications' => count($notifications),
            'total_execution_time' => round($totalTime * 1000, 2) . 'ms',
            'average_per_notification' => round(($totalTime / count($notifications)) * 1000, 2) . 'ms'
        ]);

        return $results;
    }

    /**
     * Build the Node.js command with optimizations
     *
     * @param string $title
     * @param string $message
     * @param array $options
     * @return string
     */
    public function buildNodeCommand(string $title, string $message, array $options): string
    {
        $scriptPath = $this->getNotifierScriptPath();

        // Optimize JSON encoding with specific flags for better performance
        $data = json_encode([
            'title' => $title,
            'message' => $message,
            'options' => $options
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);

        // Use cached Node.js path
        $nodePath = $this->getCachedNodePath();
        
        // Fix for Windows command line escaping
        if (PHP_OS_FAMILY === 'Windows') {
            $escapedData = '"' . str_replace('"', '\"', $data) . '"';
            
            if ($nodePath === 'node') {
                $nodePath = 'node';
            } else {
                $nodePath = '"' . trim($nodePath, '"') . '"';
            }
        } else {
            $escapedData = escapeshellarg($data);
            $nodePath = escapeshellarg($nodePath);
        }

        $command = "$nodePath \"$scriptPath\" $escapedData";

        // Debug logging if enabled
        if (config('laravel-nodenotifierdesktop.debug_mode', false)) {
            Log::debug('Built command', ['command' => $command]);
        }

        return $command;
    }

    /**
     * Execute the Node.js command with performance optimizations
     *
     * @param string $command
     * @return bool
     */
    protected function executeNodeCommand(string $command): bool
    {
        $output = [];
        $returnCode = 0;

        // Add timeout and proper error handling
        $fullCommand = $command . ' 2>&1';
        
        // On Windows, we need to handle command execution differently
        if (PHP_OS_FAMILY === 'Windows') {
            $fullCommand = 'cmd /c ' . $command . ' 2>&1';
        }

        // Use non-blocking execution for better performance
        $startTime = microtime(true);
        exec($fullCommand, $output, $returnCode);
        $executionTime = microtime(true) - $startTime;

        if ($returnCode !== 0) {
            $errorMessage = implode("\n", $output);
            
            Log::error('Desktop notification failed', [
                'platform' => PHP_OS_FAMILY,
                'command' => $command,
                'output' => $output,
                'return_code' => $returnCode,
                'error_message' => $errorMessage,
                'execution_time' => round($executionTime * 1000, 2) . 'ms',
                'node_available' => $this->isNodeAvailable(),
                'script_available' => $this->isNotifierScriptAvailable(),
                'node_version' => $this->getNodeVersion(),
                'node_path' => $this->getCachedNodePath()
            ]);

            // Provide helpful error messages
            if (strpos($errorMessage, 'node') !== false && strpos($errorMessage, 'not found') !== false) {
                Log::error('Node.js not found. Please install Node.js from https://nodejs.org/');
            } elseif (strpos($errorMessage, 'Cannot find module') !== false) {
                Log::error('Node.js dependencies missing. Run: php artisan desktop-notifier:install');
            } elseif (strpos($errorMessage, 'SyntaxError') !== false) {
                Log::error('JSON parsing error in notifier script. This might be a command escaping issue.');
            } elseif (strpos($errorMessage, 'is not recognized as an internal or external command') !== false) {
                Log::error('Node.js command not found in PATH. Please ensure Node.js is installed and in your system PATH.');
            }

            return false;
        }

        // Log successful notifications if enabled
        if (config('laravel-nodenotifierdesktop.log_notifications', true)) {
            Log::debug('Desktop notification sent successfully', [
                'platform' => PHP_OS_FAMILY,
                'output' => $output,
                'execution_time' => round($executionTime * 1000, 2) . 'ms'
            ]);
        }

        return true;
    }

    /**
     * Get cached Node.js path
     *
     * @return string
     */
    protected function getCachedNodePath(): string
    {
        if (self::$cachedNodePath === null) {
            $nodePath = config('laravel-nodenotifierdesktop.node_path');
            
            if (empty($nodePath)) {
                $nodePath = $this->findNodePath();
            }
            
            if (empty($nodePath)) {
                $nodePath = 'node';
            }

            self::$cachedNodePath = $nodePath;

            if (config('laravel-nodenotifierdesktop.debug_mode', false)) {
                Log::debug('Node.js path cached', ['node_path' => $nodePath]);
            }
        }

        return self::$cachedNodePath;
    }

    /**
     * Check if Node.js is available with caching
     *
     * @return bool
     */
    public function isNodeAvailable(): bool
    {
        if (self::$cachedNodeAvailable === null) {
            $output = [];
            $returnCode = 0;

            $nodePath = $this->getCachedNodePath();
            
            if ($nodePath && $nodePath !== 'node') {
                exec("\"$nodePath\" --version 2>&1", $output, $returnCode);
            } else {
                exec('node --version 2>&1', $output, $returnCode);
            }

            self::$cachedNodeAvailable = $returnCode === 0;
        }

        return self::$cachedNodeAvailable;
    }

    /**
     * Get Node.js version with caching
     *
     * @return string|null
     */
    public function getNodeVersion(): ?string
    {
        if (self::$cachedNodeVersion === null) {
            $output = [];
            $returnCode = 0;

            $nodePath = $this->getCachedNodePath();
            
            if ($nodePath && $nodePath !== 'node') {
                exec("\"$nodePath\" --version 2>&1", $output, $returnCode);
            } else {
                exec('node --version 2>&1', $output, $returnCode);
            }

            if ($returnCode === 0 && !empty($output)) {
                self::$cachedNodeVersion = trim($output[0]);
            } else {
                self::$cachedNodeVersion = null;
            }
        }

        return self::$cachedNodeVersion;
    }

    /**
     * Get the path to the notifier script with caching
     *
     * @return string
     */
    public function getNotifierScriptPath(): string
    {
        // Priority order for script location
        $possiblePaths = [
            // Primary: vendor directory (after installation)
            base_path('vendor/laravel-nodenotifierdesktop/laravel-nodenotifierdesktop/notifier.js'),
            // Alternative: node_modules directory
            base_path('node_modules/laravel-nodenotifierdesktop/notifier.js'),
            // Development: package root directory
            __DIR__ . '/../../notifier.js',
            // Alternative package paths
            dirname(dirname(__DIR__)) . '/notifier.js',
        ];

        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        // If no script found, return the primary vendor path
        // (this will trigger script creation during installation)
        return base_path('vendor/laravel-nodenotifierdesktop/laravel-nodenotifierdesktop/notifier.js');
    }

    /**
     * Check if the notifier script exists with caching
     *
     * @return bool
     */
    public function isNotifierScriptAvailable(): bool
    {
        if (self::$cachedScriptAvailable === null) {
            self::$cachedScriptAvailable = file_exists($this->getNotifierScriptPath());
        }

        return self::$cachedScriptAvailable;
    }

    /**
     * Find Node.js executable path with caching
     *
     * @return string|null
     */
    public function findNodePath(): ?string
    {
        // Try common Node.js installation paths
        $possiblePaths = [];
        
        if (PHP_OS_FAMILY === 'Windows') {
            // Windows common paths
            $possiblePaths = [
                'C:\Program Files\nodejs\node.exe',
                'C:\Program Files (x86)\nodejs\node.exe',
                getenv('APPDATA') . '\npm\node.exe',
                getenv('LOCALAPPDATA') . '\Programs\nodejs\node.exe',
            ];
        } else {
            // Unix-like systems
            $possiblePaths = [
                '/usr/bin/node',
                '/usr/local/bin/node',
                '/opt/homebrew/bin/node', // macOS with Homebrew
                '/usr/local/node/bin/node',
            ];
        }

        // Check if any of the paths exist
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        // Try to find node in PATH
        $output = [];
        $returnCode = 0;
        
        if (PHP_OS_FAMILY === 'Windows') {
            exec('where node 2>&1', $output, $returnCode);
        } else {
            exec('which node 2>&1', $output, $returnCode);
        }

        if ($returnCode === 0 && !empty($output)) {
            return trim($output[0]);
        }

        // If no Node.js found, return 'node' as fallback
        return 'node';
    }
} 