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
     * Build the Node.js command
     *
     * @param string $title
     * @param string $message
     * @param array $options
     * @return string
     */
    protected function buildNodeCommand(string $title, string $message, array $options): string
    {
        $scriptPath = $this->getNotifierScriptPath();

        $data = json_encode([
            'title' => $title,
            'message' => $message,
            'options' => $options
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        // Fix for Windows command line escaping
        if (PHP_OS_FAMILY === 'Windows') {
            // On Windows, we need to properly escape quotes and wrap in double quotes
            $escapedData = '"' . str_replace('"', '\"', $data) . '"';
        } else {
            // On Unix-like systems, use escapeshellarg
            $escapedData = escapeshellarg($data);
        }

        $nodePath = config('laravel-nodenotifierdesktop.node_path', 'node');
        
        return "\"$nodePath\" \"$scriptPath\" $escapedData";
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
        
        // On Windows, we might need to use different command execution
        if (PHP_OS_FAMILY === 'Windows') {
            // Use start /wait on Windows for better process handling
            $fullCommand = 'cmd /c "' . $command . '" 2>&1';
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
                'script_available' => $this->isNotifierScriptAvailable()
            ]);

            // Provide helpful error messages
            if (strpos($errorMessage, 'node') !== false && strpos($errorMessage, 'not found') !== false) {
                Log::error('Node.js not found. Please install Node.js from https://nodejs.org/');
            } elseif (strpos($errorMessage, 'Cannot find module') !== false) {
                Log::error('Node.js dependencies missing. Run: php artisan desktop-notifier:install');
            } elseif (strpos($errorMessage, 'SyntaxError') !== false) {
                Log::error('JSON parsing error in notifier script. This might be a command escaping issue.');
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

        exec('node --version 2>&1', $output, $returnCode);

        return $returnCode === 0;
    }

    /**
     * Get the path to the notifier script
     *
     * @return string
     */
    protected function getNotifierScriptPath(): string
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
} 