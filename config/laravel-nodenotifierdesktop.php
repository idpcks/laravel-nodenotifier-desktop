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
]; 