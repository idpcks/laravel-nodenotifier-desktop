<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Icon
    |--------------------------------------------------------------------------
    |
    | The default icon to use for notifications when no specific icon is provided.
    | This should be a path to an image file (PNG, ICO, etc.).
    |
    */
    'default_icon' => null,

    /*
    |--------------------------------------------------------------------------
    | Default Sound
    |--------------------------------------------------------------------------
    |
    | Whether to play a sound when showing notifications by default.
    |
    */
    'default_sound' => true,

    /*
    |--------------------------------------------------------------------------
    | Custom Sound File
    |--------------------------------------------------------------------------
    |
    | Path to custom sound file for notifications.
    | Supported formats: .wav, .mp3, .ogg
    | Leave null to use system default sound.
    |
    */
    'custom_sound_file' => null,

    /*
    |--------------------------------------------------------------------------
    | Notification Position
    |--------------------------------------------------------------------------
    |
    | Position where notifications will appear on screen.
    | Options: 'top-right', 'top-left', 'bottom-right', 'bottom-left', 'top-center', 'bottom-center'
    | Default: 'bottom-right'
    |
    */
    'position' => 'bottom-right',

    /*
    |--------------------------------------------------------------------------
    | Custom Position
    |--------------------------------------------------------------------------
    |
    | Custom X and Y coordinates for notification position.
    | Set to null to use predefined position above.
    | Format: ['x' => 100, 'y' => 100]
    |
    */
    'custom_position' => null,

    /*
    |--------------------------------------------------------------------------
    | UI Theme
    |--------------------------------------------------------------------------
    |
    | Visual theme for notifications.
    | Options: 'default', 'modern', 'minimal', 'dark', 'light'
    | Default: 'default'
    |
    */
    'ui_theme' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Animation/Transition
    |--------------------------------------------------------------------------
    |
    | Animation type for notification appearance.
    | Options: 'slide', 'fade', 'bounce', 'zoom', 'none'
    | Default: 'slide'
    |
    */
    'animation' => 'slide',

    /*
    |--------------------------------------------------------------------------
    | Animation Duration
    |--------------------------------------------------------------------------
    |
    | Duration of animation in milliseconds.
    | Default: 300
    |
    */
    'animation_duration' => 300,

    /*
    |--------------------------------------------------------------------------
    | Notification Size
    |--------------------------------------------------------------------------
    |
    | Size of notification window.
    | Options: 'small', 'medium', 'large'
    | Default: 'medium'
    |
    */
    'size' => 'medium',

    /*
    |--------------------------------------------------------------------------
    | Custom CSS
    |--------------------------------------------------------------------------
    |
    | Custom CSS styles to apply to notifications.
    | This will override default styles.
    |
    */
    'custom_css' => null,

    /*
    |--------------------------------------------------------------------------
    | Timeout
    |--------------------------------------------------------------------------
    |
    | The default timeout for notifications in milliseconds.
    |
    */
    'timeout' => 5000,

    /*
    |--------------------------------------------------------------------------
    | Icons
    |--------------------------------------------------------------------------
    |
    | Default icons for different notification types.
    |
    */
    'icons' => [
        'success' => null,
        'error' => null,
        'warning' => null,
        'info' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Node.js Path
    |--------------------------------------------------------------------------
    |
    | Custom path to Node.js executable if it's not in your system PATH.
    | Leave null to use the default 'node' command.
    |
    */
    'node_path' => 'node',

    /*
    |--------------------------------------------------------------------------
    | Log Notifications
    |--------------------------------------------------------------------------
    |
    | Whether to log notification attempts to Laravel's log system.
    |
    */
    'log_notifications' => true,

    /*
    |--------------------------------------------------------------------------
    | Debug Mode
    |--------------------------------------------------------------------------
    |
    | Enable detailed debug logging for troubleshooting.
    | Set to true when experiencing issues.
    |
    */
    'debug_mode' => false,

    /*
    |--------------------------------------------------------------------------
    | Fallback to Browser Notifications
    |--------------------------------------------------------------------------
    |
    | If desktop notifications fail, whether to fall back to browser notifications
    | (requires JavaScript and browser support).
    |
    */
    'fallback_to_browser' => false,

    /*
    |--------------------------------------------------------------------------
    | Performance Optimization Settings
    |--------------------------------------------------------------------------
    |
    | Settings to optimize the performance of desktop notifications.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Enable Caching
    |--------------------------------------------------------------------------
    |
    | Enable caching of frequently used values like Node.js path, configuration,
    | and script paths to improve performance.
    |
    */
    'enable_caching' => true,

    /*
    |--------------------------------------------------------------------------
    | Cache Duration
    |--------------------------------------------------------------------------
    |
    | How long to cache values in seconds. Set to 0 to disable cache expiration.
    | Default: 3600 (1 hour)
    |
    */
    'cache_duration' => 3600,

    /*
    |--------------------------------------------------------------------------
    | Batch Processing
    |--------------------------------------------------------------------------
    |
    | Enable batch processing for multiple notifications to improve performance
    | when sending many notifications at once.
    |
    */
    'enable_batch_processing' => true,

    /*
    |--------------------------------------------------------------------------
    | Batch Size
    |--------------------------------------------------------------------------
    |
    | Maximum number of notifications to process in a single batch.
    | Default: 10
    |
    */
    'batch_size' => 10,

    /*
    |--------------------------------------------------------------------------
    | Batch Delay
    |--------------------------------------------------------------------------
    |
    | Delay between batches in milliseconds to prevent overwhelming the system.
    | Default: 100
    |
    */
    'batch_delay' => 100,

    /*
    |--------------------------------------------------------------------------
    | Performance Monitoring
    |--------------------------------------------------------------------------
    |
    | Enable performance monitoring to track notification execution times
    | and success rates.
    |
    */
    'enable_performance_monitoring' => true,

    /*
    |--------------------------------------------------------------------------
    | Performance Metrics Retention
    |--------------------------------------------------------------------------
    |
    | Number of performance metrics to keep in memory for monitoring.
    | Default: 100
    |
    */
    'performance_metrics_retention' => 100,

    /*
    |--------------------------------------------------------------------------
    | Slow Execution Threshold
    |--------------------------------------------------------------------------
    |
    | Threshold in milliseconds to log warnings for slow notification execution.
    | Default: 1000 (1 second)
    |
    */
    'slow_execution_threshold' => 1000,

    /*
    |--------------------------------------------------------------------------
    | Async Processing
    |--------------------------------------------------------------------------
    |
    | Enable asynchronous processing for notifications to prevent blocking
    | the main application thread.
    |
    */
    'enable_async_processing' => false,

    /*
    |--------------------------------------------------------------------------
    | Process Pool Size
    |--------------------------------------------------------------------------
    |
    | Maximum number of concurrent Node.js processes for notifications.
    | Only applies when async processing is enabled.
    | Default: 5
    |
    */
    'process_pool_size' => 5,

    /*
    |--------------------------------------------------------------------------
    | Memory Optimization
    |--------------------------------------------------------------------------
    |
    | Enable memory optimization features like garbage collection hints
    | and memory usage monitoring.
    |
    */
    'enable_memory_optimization' => true,

    /*
    |--------------------------------------------------------------------------
    | JSON Optimization
    |--------------------------------------------------------------------------
    |
    | Enable JSON optimization flags for faster encoding/decoding.
    | Uses JSON_PARTIAL_OUTPUT_ON_ERROR for better performance.
    |
    */
    'enable_json_optimization' => true,

    /*
    |--------------------------------------------------------------------------
    | File System Caching
    |--------------------------------------------------------------------------
    |
    | Cache file system operations like path resolution and file existence checks.
    | Improves performance by reducing repeated file system calls.
    |
    */
    'enable_filesystem_caching' => true,

    /*
    |--------------------------------------------------------------------------
    | Node.js Process Optimization
    |--------------------------------------------------------------------------
    |
    | Enable Node.js process optimizations like faster startup and reduced
    | memory footprint.
    |
    */
    'enable_node_optimization' => true,

    /*
    |--------------------------------------------------------------------------
    | Connection Pooling
    |--------------------------------------------------------------------------
    |
    | Enable connection pooling for Node.js processes to reduce startup overhead.
    | Experimental feature - may not work on all systems.
    |
    */
    'enable_connection_pooling' => false,

    /*
    |--------------------------------------------------------------------------
    | Pool Timeout
    |--------------------------------------------------------------------------
    |
    | Timeout in seconds for pooled connections before they are closed.
    | Default: 300 (5 minutes)
    |
    */
    'pool_timeout' => 300,

    /*
    |--------------------------------------------------------------------------
    | Performance Alerts
    |--------------------------------------------------------------------------
    |
    | Enable performance alerts for monitoring system health and detecting
    | performance degradation.
    |
    */
    'enable_performance_alerts' => true,

    /*
    |--------------------------------------------------------------------------
    | Alert Thresholds
    |--------------------------------------------------------------------------
    |
    | Thresholds for performance alerts.
    |
    */
    'alert_thresholds' => [
        'execution_time' => 2000, // 2 seconds
        'memory_usage' => 100 * 1024 * 1024, // 100 MB
        'error_rate' => 0.1, // 10%
        'queue_size' => 50, // 50 notifications
    ],

    /*
    |--------------------------------------------------------------------------
    | Auto Cleanup
    |--------------------------------------------------------------------------
    |
    | Enable automatic cleanup of old performance metrics and cached data
    | to prevent memory leaks.
    |
    */
    'enable_auto_cleanup' => true,

    /*
    |--------------------------------------------------------------------------
    | Cleanup Interval
    |--------------------------------------------------------------------------
    |
    | Interval in seconds for automatic cleanup operations.
    | Default: 3600 (1 hour)
    |
    */
    'cleanup_interval' => 3600,
]; 