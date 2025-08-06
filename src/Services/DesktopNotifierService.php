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
        $scriptPath = __DIR__ . '/../../node_modules/laravel-nodenotifierdesktop/notifier.js';
        
        if (!file_exists($scriptPath)) {
            $scriptPath = __DIR__ . '/../../notifier.js';
        }

        $data = json_encode([
            'title' => $title,
            'message' => $message,
            'options' => $options
        ]);

        return "node \"$scriptPath\" " . escapeshellarg($data);
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

        exec($command . ' 2>&1', $output, $returnCode);

        if ($returnCode !== 0) {
            Log::error('Node command failed', [
                'command' => $command,
                'output' => $output,
                'return_code' => $returnCode
            ]);
            return false;
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
     * Check if the notifier script exists
     *
     * @return bool
     */
    public function isNotifierScriptAvailable(): bool
    {
        $scriptPath = __DIR__ . '/../../node_modules/laravel-nodenotifierdesktop/notifier.js';
        
        if (!file_exists($scriptPath)) {
            $scriptPath = __DIR__ . '/../../notifier.js';
        }

        return file_exists($scriptPath);
    }
} 