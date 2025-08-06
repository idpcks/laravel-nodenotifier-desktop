<?php

namespace LaravelNodeNotifierDesktop\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class DesktopNotifierService
{
    protected Client $client;
    protected string $nodeScriptPath;

    public function __construct()
    {
        $this->client = new Client();
        $this->nodeScriptPath = base_path('node_modules/laravel-nodenotifierdesktop/notifier.js');
    }

    /**
     * Send a desktop notification
     *
     * @param string $title
     * @param string $message
     * @param array $options
     * @return bool
     */
    public function notify(string $title, string $message, array $options = []): bool
    {
        try {
            $defaultOptions = [
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

            $options = array_merge($defaultOptions, $options);

            $command = $this->buildNodeCommand($title, $message, $options);
            
            if ($this->executeNodeCommand($command)) {
                Log::info('Desktop notification sent', [
                    'title' => $title,
                    'message' => $message,
                    'options' => $options
                ]);
                return true;
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Failed to send desktop notification', [
                'error' => $e->getMessage(),
                'title' => $title,
                'message' => $message
            ]);
            return false;
        }
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
     * Build the Node.js command
     *
     * @param string $title
     * @param string $message
     * @param array $options
     * @return string
     */
    public function buildNodeCommand(string $title, string $message, array $options): string
    {
        $scriptPath = $this->getNotifierScriptPath();

        $data = json_encode([
            'title' => $title,
            'message' => $message,
            'options' => $options
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        // Get Node.js path with fallback
        $nodePath = config('laravel-nodenotifierdesktop.node_path');
        
        // If node_path is not configured, try to find Node.js automatically
        if (empty($nodePath)) {
            $nodePath = $this->findNodePath();
        }
        
        // Final fallback to 'node' command
        if (empty($nodePath)) {
            $nodePath = 'node';
        }

        // Debug logging if enabled
        if (config('laravel-nodenotifierdesktop.debug_mode', false)) {
            Log::debug('Node.js path found', ['node_path' => $nodePath]);
        }

        // Fix for Windows command line escaping
        if (PHP_OS_FAMILY === 'Windows') {
            // On Windows, we need to properly escape quotes and wrap in double quotes
            $escapedData = '"' . str_replace('"', '\"', $data) . '"';
            
            // Don't quote nodePath if it's just 'node' to avoid double-quoting issues
            if ($nodePath === 'node') {
                $nodePath = 'node';
            } else {
                // Ensure nodePath is properly quoted for Windows
                $nodePath = '"' . trim($nodePath, '"') . '"';
            }
        } else {
            // On Unix-like systems, use escapeshellarg
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
     * Execute the Node.js command
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
            // Use cmd /c without additional quoting to avoid double-quoting issues
            $fullCommand = 'cmd /c ' . $command . ' 2>&1';
        }

        exec($fullCommand, $output, $returnCode);

        if ($returnCode !== 0) {
            $errorMessage = implode("\n", $output);
            
            Log::error('Desktop notification failed', [
                'platform' => PHP_OS_FAMILY,
                'command' => $command,
                'output' => $output,
                'return_code' => $returnCode,
                'error_message' => $errorMessage,
                'node_available' => $this->isNodeAvailable(),
                'script_available' => $this->isNotifierScriptAvailable(),
                'node_version' => $this->getNodeVersion(),
                'node_path' => $this->findNodePath()
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
                'output' => $output
            ]);
        }

        return true;
    }

    /**
     * Check if Node.js is available
     *
     * @return bool
     */
    public function isNodeAvailable(): bool
    {
        $output = [];
        $returnCode = 0;

        // Try to find Node.js path first
        $nodePath = $this->findNodePath();
        
        if ($nodePath && $nodePath !== 'node') {
            // Use the found path
            exec("\"$nodePath\" --version 2>&1", $output, $returnCode);
        } else {
            // Fallback to 'node' command
            exec('node --version 2>&1', $output, $returnCode);
        }

        return $returnCode === 0;
    }

    /**
     * Get Node.js version
     *
     * @return string|null
     */
    public function getNodeVersion(): ?string
    {
        $output = [];
        $returnCode = 0;

        // Try to find Node.js path first
        $nodePath = $this->findNodePath();
        
        if ($nodePath && $nodePath !== 'node') {
            // Use the found path
            exec("\"$nodePath\" --version 2>&1", $output, $returnCode);
        } else {
            // Fallback to 'node' command
            exec('node --version 2>&1', $output, $returnCode);
        }

        if ($returnCode === 0 && !empty($output)) {
            return trim($output[0]);
        }

        return null;
    }

    /**
     * Get the path to the notifier script
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
     * Check if the notifier script exists
     *
     * @return bool
     */
    public function isNotifierScriptAvailable(): bool
    {
        return file_exists($this->getNotifierScriptPath());
    }

    /**
     * Find Node.js executable path
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