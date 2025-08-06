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
]; 