<?php

namespace LaravelNodeNotifierDesktop\Console\Commands;

use Illuminate\Console\Command;
use LaravelNodeNotifierDesktop\Services\DesktopNotifierService;

class DebugNodeNotifierCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'desktop-notifier:debug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug Node.js and desktop notification setup';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🔍 Laravel Node Notifier Desktop - Debug Information');
        $this->info('==================================================');
        $this->info('');

        $service = app(DesktopNotifierService::class);

        // System Information
        $this->info('📋 System Information:');
        $this->info('  Platform: ' . PHP_OS_FAMILY);
        $this->info('  PHP Version: ' . PHP_VERSION);
        $this->info('  Laravel Version: ' . app()->version());
        $this->info('');

        // Node.js Information
        $this->info('🟢 Node.js Information:');
        $nodePath = $service->findNodePath();
        $nodeVersion = $service->getNodeVersion();
        $nodeAvailable = $service->isNodeAvailable();

        if ($nodeAvailable) {
            $this->info('  ✓ Node.js is available');
            $this->info('  Version: ' . ($nodeVersion ?? 'Unknown'));
            $this->info('  Path: ' . ($nodePath ?? 'Using PATH'));
        } else {
            $this->error('  ✗ Node.js is not available');
            $this->info('  Please install Node.js from https://nodejs.org/');
        }
        $this->info('');

        // Script Information
        $this->info('📜 Script Information:');
        $scriptPath = $service->getNotifierScriptPath();
        $scriptAvailable = $service->isNotifierScriptAvailable();

        if ($scriptAvailable) {
            $this->info('  ✓ Notifier script is available');
            $this->info('  Path: ' . $scriptPath);
        } else {
            $this->error('  ✗ Notifier script is not available');
            $this->info('  Run: php artisan desktop-notifier:install');
        }
        $this->info('');

        // Configuration Information
        $this->info('⚙️  Configuration Information:');
        $this->info('  Node Path: ' . (config('laravel-nodenotifierdesktop.node_path') ?? 'null (auto-detect)'));
        $this->info('  Default Sound: ' . (config('laravel-nodenotifierdesktop.default_sound') ? 'true' : 'false'));
        $this->info('  Timeout: ' . config('laravel-nodenotifierdesktop.timeout', 5000) . 'ms');
        $this->info('  Debug Mode: ' . (config('laravel-nodenotifierdesktop.debug_mode', false) ? 'true' : 'false'));
        $this->info('');

        // Test Command Building
        $this->info('🔧 Command Building Test:');
        try {
            $command = $service->buildNodeCommand('Test Title', 'Test Message', []);
            $this->info('  ✓ Command built successfully');
            $this->info('  Command: ' . $command);
        } catch (\Exception $e) {
            $this->error('  ✗ Command building failed: ' . $e->getMessage());
        }
        $this->info('');

        // Test Notification
        if ($this->confirm('Would you like to test a desktop notification?', true)) {
            $this->info('🧪 Testing Desktop Notification:');
            try {
                if ($service->notify('Debug Test', 'This is a test notification from debug command')) {
                    $this->info('  ✓ Test notification sent successfully');
                } else {
                    $this->error('  ✗ Test notification failed');
                    $this->info('  Check Laravel logs for detailed error information');
                }
            } catch (\Exception $e) {
                $this->error('  ✗ Test notification failed: ' . $e->getMessage());
            }
            $this->info('');
        }

        // Recommendations
        $this->info('💡 Recommendations:');
        if (!$nodeAvailable) {
            $this->error('  • Install Node.js from https://nodejs.org/');
        }
        if (!$scriptAvailable) {
            $this->error('  • Run: php artisan desktop-notifier:install');
        }
        if (!$nodeAvailable || !$scriptAvailable) {
            $this->info('  • After fixing issues, run: php artisan desktop-notifier:debug');
        } else {
            $this->info('  • Everything looks good! You can use desktop notifications.');
            $this->info('  • Example: DesktopNotifier::success("Hello", "World!");');
        }

        return 0;
    }
} 