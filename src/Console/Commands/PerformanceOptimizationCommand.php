<?php

namespace LaravelNodeNotifierDesktop\Console\Commands;

use Illuminate\Console\Command;
use LaravelNodeNotifierDesktop\Services\DesktopNotifierService;
use Illuminate\Support\Facades\Log;

class PerformanceOptimizationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'desktop-notifier:performance 
                            {action : Action to perform (stats|optimize|test|monitor|cleanup)}
                            {--iterations=10 : Number of test iterations for performance testing}
                            {--batch-size=5 : Batch size for batch processing tests}
                            {--duration=60 : Duration in seconds for monitoring mode}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Performance optimization and monitoring for Laravel Node Notifier Desktop';

    /**
     * The desktop notifier service instance.
     *
     * @var DesktopNotifierService
     */
    protected DesktopNotifierService $notifier;

    /**
     * Create a new command instance.
     *
     * @param DesktopNotifierService $notifier
     * @return void
     */
    public function __construct(DesktopNotifierService $notifier)
    {
        parent::__construct();
        $this->notifier = $notifier;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'stats':
                return $this->showPerformanceStats();
            case 'optimize':
                return $this->optimizePerformance();
            case 'test':
                return $this->runPerformanceTests();
            case 'monitor':
                return $this->monitorPerformance();
            case 'cleanup':
                return $this->cleanupPerformanceData();
            default:
                $this->error("Unknown action: {$action}");
                $this->info('Available actions: stats, optimize, test, monitor, cleanup');
                return 1;
        }
    }

    /**
     * Show current performance statistics.
     *
     * @return int
     */
    protected function showPerformanceStats(): int
    {
        $this->info('📊 Desktop Notifier Performance Statistics');
        $this->line('');

        $stats = DesktopNotifierService::getPerformanceStats();

        if ($stats['total_notifications'] === 0) {
            $this->warn('No notifications have been sent yet.');
            return 0;
        }

        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Notifications', $stats['total_notifications']],
                ['Average Execution Time', $stats['average_execution_time']],
                ['Min Execution Time', $stats['min_execution_time']],
                ['Max Execution Time', $stats['max_execution_time']],
                ['Success Rate', $stats['success_rate']],
            ]
        );

        // System information
        $this->line('');
        $this->info('🔧 System Information');
        
        $systemInfo = [
            ['Node.js Available', $this->notifier->isNodeAvailable() ? '✅ Yes' : '❌ No'],
            ['Node.js Version', $this->notifier->getNodeVersion() ?? 'Unknown'],
            ['Script Available', $this->notifier->isNotifierScriptAvailable() ? '✅ Yes' : '❌ No'],
            ['Platform', PHP_OS_FAMILY],
            ['PHP Version', PHP_VERSION],
            ['Memory Usage', $this->formatBytes(memory_get_usage(true))],
            ['Peak Memory', $this->formatBytes(memory_get_peak_usage(true))],
        ];

        $this->table(['Property', 'Value'], $systemInfo);

        return 0;
    }

    /**
     * Optimize performance settings.
     *
     * @return int
     */
    protected function optimizePerformance(): int
    {
        $this->info('⚡ Performance Optimization');
        $this->line('');

        // Clear cache
        $this->line('🔄 Clearing cache...');
        DesktopNotifierService::clearCache();
        $this->info('Cache cleared successfully.');

        // Check configuration
        $this->line('');
        $this->info('📋 Configuration Analysis');

        $config = config('laravel-nodenotifierdesktop');
        $optimizations = [];

        // Check caching settings
        if (!$config['enable_caching']) {
            $optimizations[] = ['Enable Caching', 'Set enable_caching to true for better performance'];
        }

        if ($config['cache_duration'] < 300) {
            $optimizations[] = ['Cache Duration', 'Increase cache_duration to at least 300 seconds'];
        }

        // Check batch processing
        if (!$config['enable_batch_processing']) {
            $optimizations[] = ['Batch Processing', 'Set enable_batch_processing to true for multiple notifications'];
        }

        if ($config['batch_size'] < 5) {
            $optimizations[] = ['Batch Size', 'Increase batch_size to at least 5 for better efficiency'];
        }

        // Check performance monitoring
        if (!$config['enable_performance_monitoring']) {
            $optimizations[] = ['Performance Monitoring', 'Set enable_performance_monitoring to true for insights'];
        }

        // Check JSON optimization
        if (!$config['enable_json_optimization']) {
            $optimizations[] = ['JSON Optimization', 'Set enable_json_optimization to true for faster encoding'];
        }

        // Check file system caching
        if (!$config['enable_filesystem_caching']) {
            $optimizations[] = ['File System Caching', 'Set enable_filesystem_caching to true to reduce I/O'];
        }

        if (empty($optimizations)) {
            $this->info('✅ Configuration is already optimized!');
        } else {
            $this->warn('⚠️  Recommended optimizations:');
            $this->table(['Setting', 'Recommendation'], $optimizations);
        }

        // Performance tips
        $this->line('');
        $this->info('💡 Performance Tips:');
        $tips = [
            'Use batch processing for multiple notifications',
            'Enable caching to reduce repeated operations',
            'Monitor performance metrics regularly',
            'Use appropriate batch sizes (5-10 notifications)',
            'Enable JSON optimization for faster data transfer',
            'Consider async processing for high-volume scenarios',
        ];

        foreach ($tips as $tip) {
            $this->line("  • {$tip}");
        }

        return 0;
    }

    /**
     * Run performance tests.
     *
     * @return int
     */
    protected function runPerformanceTests(): int
    {
        $iterations = (int) $this->option('iterations');
        $batchSize = (int) $this->option('batch-size');

        $this->info("🧪 Running Performance Tests ({$iterations} iterations)");
        $this->line('');

        // Test single notifications
        $this->line('📤 Testing single notifications...');
        $singleResults = $this->testSingleNotifications($iterations);

        // Test batch notifications
        $this->line('📦 Testing batch notifications...');
        $batchResults = $this->testBatchNotifications($iterations, $batchSize);

        // Display results
        $this->line('');
        $this->info('📊 Test Results');

        $this->table(
            ['Test Type', 'Total Time', 'Average Time', 'Success Rate'],
            [
                [
                    'Single Notifications',
                    $singleResults['total_time'] . 'ms',
                    $singleResults['average_time'] . 'ms',
                    $singleResults['success_rate'] . '%'
                ],
                [
                    'Batch Notifications',
                    $batchResults['total_time'] . 'ms',
                    $batchResults['average_time'] . 'ms',
                    $batchResults['success_rate'] . '%'
                ]
            ]
        );

        // Performance comparison
        $this->line('');
        $this->info('📈 Performance Comparison');

        $singlePerNotification = $singleResults['total_time'] / $iterations;
        $batchPerNotification = $batchResults['total_time'] / ($iterations * $batchSize);
        $improvement = (($singlePerNotification - $batchPerNotification) / $singlePerNotification) * 100;

        $this->line("Single notification average: {$singlePerNotification}ms");
        $this->line("Batch notification average: {$batchPerNotification}ms");
        $this->line("Performance improvement: {$improvement}%");

        if ($improvement > 0) {
            $this->info("✅ Batch processing is {$improvement}% faster!");
        } else {
            $this->warn("⚠️  Batch processing is not showing improvement. Consider adjusting batch size.");
        }

        return 0;
    }

    /**
     * Test single notifications.
     *
     * @param int $iterations
     * @return array
     */
    protected function testSingleNotifications(int $iterations): array
    {
        $startTime = microtime(true);
        $successCount = 0;

        for ($i = 0; $i < $iterations; $i++) {
            $notificationStart = microtime(true);
            $success = $this->notifier->info(
                "Test Notification {$i}",
                "This is a performance test notification #{$i}",
                ['timeout' => 1000]
            );
            
            if ($success) {
                $successCount++;
            }

            // Small delay to prevent overwhelming the system
            usleep(100000); // 100ms
        }

        $totalTime = (microtime(true) - $startTime) * 1000;
        $averageTime = $totalTime / $iterations;
        $successRate = ($successCount / $iterations) * 100;

        return [
            'total_time' => round($totalTime, 2),
            'average_time' => round($averageTime, 2),
            'success_rate' => round($successRate, 2)
        ];
    }

    /**
     * Test batch notifications.
     *
     * @param int $iterations
     * @param int $batchSize
     * @return array
     */
    protected function testBatchNotifications(int $iterations, int $batchSize): array
    {
        $startTime = microtime(true);
        $totalSuccessCount = 0;
        $totalNotifications = 0;

        for ($i = 0; $i < $iterations; $i++) {
            $batch = [];
            for ($j = 0; $j < $batchSize; $j++) {
                $batch[] = [
                    'title' => "Batch Test {$i}-{$j}",
                    'message' => "Batch performance test notification #{$i}-{$j}",
                    'options' => ['timeout' => 1000]
                ];
            }

            $results = $this->notifier->notifyBatch($batch);
            $totalNotifications += count($batch);
            
            foreach ($results as $result) {
                if ($result['success']) {
                    $totalSuccessCount++;
                }
            }

            // Small delay between batches
            usleep(200000); // 200ms
        }

        $totalTime = (microtime(true) - $startTime) * 1000;
        $averageTime = $totalTime / $iterations;
        $successRate = ($totalSuccessCount / $totalNotifications) * 100;

        return [
            'total_time' => round($totalTime, 2),
            'average_time' => round($averageTime, 2),
            'success_rate' => round($successRate, 2)
        ];
    }

    /**
     * Monitor performance in real-time.
     *
     * @return int
     */
    protected function monitorPerformance(): int
    {
        $duration = (int) $this->option('duration');
        
        $this->info("📊 Performance Monitoring (Duration: {$duration} seconds)");
        $this->line('Press Ctrl+C to stop monitoring');
        $this->line('');

        $startTime = time();
        $notificationCount = 0;
        $successCount = 0;
        $totalExecutionTime = 0;

        // Display header
        $this->table(
            ['Time', 'Notifications/min', 'Avg Time', 'Success Rate', 'Memory'],
            []
        );

        while ((time() - $startTime) < $duration) {
            $periodStart = time();
            $periodNotifications = 0;
            $periodSuccess = 0;
            $periodExecutionTime = 0;

            // Send test notifications for 1 minute
            while ((time() - $periodStart) < 60 && (time() - $startTime) < $duration) {
                $notificationStart = microtime(true);
                
                $success = $this->notifier->info(
                    'Monitor Test',
                    'Performance monitoring notification',
                    ['timeout' => 1000]
                );

                $executionTime = (microtime(true) - $notificationStart) * 1000;
                
                $periodNotifications++;
                $periodExecutionTime += $executionTime;
                
                if ($success) {
                    $periodSuccess++;
                }

                $notificationCount++;
                $totalExecutionTime += $executionTime;
                
                if ($success) {
                    $successCount++;
                }

                // Send notification every 5 seconds
                sleep(5);
            }

            // Calculate metrics
            $notificationsPerMinute = $periodNotifications;
            $avgTime = $periodNotifications > 0 ? $periodExecutionTime / $periodNotifications : 0;
            $successRate = $periodNotifications > 0 ? ($periodSuccess / $periodNotifications) * 100 : 0;
            $memoryUsage = $this->formatBytes(memory_get_usage(true));

            // Display metrics
            $this->table(
                ['Time', 'Notifications/min', 'Avg Time', 'Success Rate', 'Memory'],
                [
                    [
                        date('H:i:s'),
                        $notificationsPerMinute,
                        round($avgTime, 2) . 'ms',
                        round($successRate, 1) . '%',
                        $memoryUsage
                    ]
                ]
            );

            // Check if we should continue
            if ((time() - $startTime) >= $duration) {
                break;
            }
        }

        // Final summary
        $this->line('');
        $this->info('📈 Monitoring Summary');
        
        $totalTime = time() - $startTime;
        $overallAvgTime = $notificationCount > 0 ? $totalExecutionTime / $notificationCount : 0;
        $overallSuccessRate = $notificationCount > 0 ? ($successCount / $notificationCount) * 100 : 0;

        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Time', $totalTime . ' seconds'],
                ['Total Notifications', $notificationCount],
                ['Average Execution Time', round($overallAvgTime, 2) . 'ms'],
                ['Overall Success Rate', round($overallSuccessRate, 2) . '%'],
                ['Notifications per Minute', round($notificationCount / ($totalTime / 60), 2)],
            ]
        );

        return 0;
    }

    /**
     * Cleanup performance data.
     *
     * @return int
     */
    protected function cleanupPerformanceData(): int
    {
        $this->info('🧹 Performance Data Cleanup');
        $this->line('');

        // Clear service cache
        $this->line('🔄 Clearing service cache...');
        DesktopNotifierService::clearCache();
        $this->info('Service cache cleared.');

        // Clear Laravel cache if available
        if (function_exists('cache')) {
            $this->line('🗑️  Clearing Laravel cache...');
            cache()->flush();
            $this->info('Laravel cache cleared.');
        }

        // Force garbage collection
        $this->line('♻️  Running garbage collection...');
        gc_collect_cycles();
        $this->info('Garbage collection completed.');

        // Memory usage before and after
        $memoryBefore = memory_get_usage(true);
        $peakMemory = memory_get_peak_usage(true);

        $this->line('');
        $this->info('📊 Memory Usage');
        $this->table(
            ['Metric', 'Value'],
            [
                ['Current Memory', $this->formatBytes($memoryBefore)],
                ['Peak Memory', $this->formatBytes($peakMemory)],
            ]
        );

        $this->info('✅ Cleanup completed successfully!');

        return 0;
    }

    /**
     * Format bytes to human readable format.
     *
     * @param int $bytes
     * @return string
     */
    protected function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
