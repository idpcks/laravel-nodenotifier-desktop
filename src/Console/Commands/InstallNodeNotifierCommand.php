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

        // Check if Node.js is available
        if (!$this->isNodeAvailable()) {
            $this->error('Node.js is not installed or not available in PATH.');
            $this->info('Please install Node.js from https://nodejs.org/');
            return 1;
        }

        $this->info('✓ Node.js is available');

        // Check if package.json exists
        $packageJsonPath = base_path('package.json');
        if (!file_exists($packageJsonPath)) {
            $this->warn('package.json not found. Creating one...');
            $this->createPackageJson();
        }

        // Install npm dependencies
        if ($this->installNpmDependencies()) {
            $this->info('✓ NPM dependencies installed successfully');
        } else {
            $this->error('Failed to install NPM dependencies');
            return 1;
        }

        // Copy notifier script
        if ($this->copyNotifierScript()) {
            $this->info('✓ Notifier script copied successfully');
        } else {
            $this->error('Failed to copy notifier script');
            return 1;
        }

        $this->info('Laravel Node Notifier Desktop installed successfully!');
        $this->info('You can now use desktop notifications in your Laravel application.');
        
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
     * Create package.json if it doesn't exist
     */
    protected function createPackageJson(): void
    {
        $packageJson = [
            'name' => basename(base_path()),
            'version' => '1.0.0',
            'description' => 'Laravel application with desktop notifications',
            'main' => 'index.js',
            'scripts' => [
                'test' => 'echo "Error: no test specified" && exit 1'
            ],
            'dependencies' => [
                'node-notifier' => '^10.0.1'
            ],
            'keywords' => ['laravel', 'notification', 'desktop'],
            'author' => '',
            'license' => 'MIT'
        ];

        file_put_contents(base_path('package.json'), json_encode($packageJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    /**
     * Install NPM dependencies
     */
    protected function installNpmDependencies(): bool
    {
        $command = 'npm install';
        
        if ($this->option('force')) {
            $command .= ' --force';
        }

        $this->info('Installing NPM dependencies...');
        
        $output = [];
        $returnCode = 0;

        exec($command . ' 2>&1', $output, $returnCode);

        if ($returnCode !== 0) {
            $this->error('NPM install failed:');
            foreach ($output as $line) {
                $this->error($line);
            }
            return false;
        }

        return true;
    }

    /**
     * Copy notifier script to node_modules
     */
    protected function copyNotifierScript(): bool
    {
        $sourcePath = __DIR__ . '/../../../notifier.js';
        $targetDir = base_path('node_modules/laravel-nodenotifierdesktop');
        $targetPath = $targetDir . '/notifier.js';

        if (!file_exists($sourcePath)) {
            $this->error('Notifier script not found at: ' . $sourcePath);
            return false;
        }

        if (!is_dir($targetDir)) {
            if (!mkdir($targetDir, 0755, true)) {
                $this->error('Failed to create directory: ' . $targetDir);
                return false;
            }
        }

        if (!copy($sourcePath, $targetPath)) {
            $this->error('Failed to copy notifier script');
            return false;
        }

        return true;
    }
} 