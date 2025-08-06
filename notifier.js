#!/usr/bin/env node

const notifier = require('node-notifier');
const path = require('path');
const fs = require('fs');

// Get notification data from command line arguments
const notificationData = process.argv[2];

if (!notificationData) {
    console.error('No notification data provided');
    process.exit(1);
}

try {
    const data = JSON.parse(notificationData);
    const { title, message, options = {} } = data;

    // Calculate position based on configuration
    const position = calculatePosition(options.position, options.custom_position);
    
    // Get theme and styling
    const theme = getTheme(options.ui_theme);
    const animation = getAnimation(options.animation, options.animation_duration);
    const size = getSize(options.size);
    
    // Get sound configuration
    const soundConfig = getSoundConfig(options.sound, options.custom_sound_file);

    // Default options
    const defaultOptions = {
        title: title || 'Laravel Notification',
        message: message || '',
        icon: options.icon || path.join(__dirname, 'default-icon.png'),
        sound: soundConfig.enabled,
        timeout: options.timeout || 5000,
        wait: false,
        type: 'info',
        // Custom positioning
        x: position.x,
        y: position.y,
        // Custom styling
        className: `notification-${options.ui_theme || 'default'} notification-${options.size || 'medium'}`,
        // Animation
        animation: animation.type,
        animationDuration: animation.duration,
        // Custom sound file
        soundFile: soundConfig.file
    };

    // Platform-specific options
    if (process.platform === 'win32') {
        defaultOptions.icon = options.icon || path.join(__dirname, 'icons', 'info.png');
        // Windows-specific positioning
        if (position.x !== undefined && position.y !== undefined) {
            defaultOptions.x = position.x;
            defaultOptions.y = position.y;
        }
    } else if (process.platform === 'darwin') {
        defaultOptions.icon = options.icon || path.join(__dirname, 'icons', 'info.png');
        // macOS-specific positioning
        if (position.x !== undefined && position.y !== undefined) {
            defaultOptions.x = position.x;
            defaultOptions.y = position.y;
        }
    } else {
        // Linux
        defaultOptions.icon = options.icon || path.join(__dirname, 'icons', 'info.png');
        // Linux-specific positioning
        if (position.x !== undefined && position.y !== undefined) {
            defaultOptions.x = position.x;
            defaultOptions.y = position.y;
        }
    }

    // Send notification
    notifier.notify(defaultOptions, (err, response) => {
        if (err) {
            console.error('Notification error:', err);
            process.exit(1);
        }
        
        console.log('Notification sent successfully');
        process.exit(0);
    });

    // Handle notification actions
    notifier.on('click', () => {
        console.log('Notification clicked');
        process.exit(0);
    });

    notifier.on('timeout', () => {
        console.log('Notification timeout');
        process.exit(0);
    });

} catch (error) {
    console.error('Error parsing notification data:', error);
    process.exit(1);
}

/**
 * Calculate notification position
 */
function calculatePosition(position, customPosition) {
    // If custom position is provided, use it
    if (customPosition && customPosition.x !== undefined && customPosition.y !== undefined) {
        return { x: customPosition.x, y: customPosition.y };
    }

    // Get screen dimensions (approximate for common resolutions)
    const screenWidth = 1920;
    const screenHeight = 1080;
    const notificationWidth = 350;
    const notificationHeight = 100;
    const margin = 20;

    let x, y;

    switch (position) {
        case 'top-right':
            x = screenWidth - notificationWidth - margin;
            y = margin;
            break;
        case 'top-left':
            x = margin;
            y = margin;
            break;
        case 'bottom-right':
            x = screenWidth - notificationWidth - margin;
            y = screenHeight - notificationHeight - margin;
            break;
        case 'bottom-left':
            x = margin;
            y = screenHeight - notificationHeight - margin;
            break;
        case 'top-center':
            x = (screenWidth - notificationWidth) / 2;
            y = margin;
            break;
        case 'bottom-center':
            x = (screenWidth - notificationWidth) / 2;
            y = screenHeight - notificationHeight - margin;
            break;
        default: // bottom-right
            x = screenWidth - notificationWidth - margin;
            y = screenHeight - notificationHeight - margin;
    }

    return { x: Math.round(x), y: Math.round(y) };
}

/**
 * Get theme configuration
 */
function getTheme(theme) {
    const themes = {
        'default': {
            backgroundColor: '#ffffff',
            textColor: '#333333',
            borderColor: '#e0e0e0',
            shadow: '0 4px 12px rgba(0,0,0,0.15)'
        },
        'modern': {
            backgroundColor: '#f8f9fa',
            textColor: '#212529',
            borderColor: '#dee2e6',
            shadow: '0 8px 25px rgba(0,0,0,0.1)'
        },
        'minimal': {
            backgroundColor: '#ffffff',
            textColor: '#000000',
            borderColor: '#000000',
            shadow: 'none'
        },
        'dark': {
            backgroundColor: '#2d3748',
            textColor: '#ffffff',
            borderColor: '#4a5568',
            shadow: '0 4px 12px rgba(0,0,0,0.3)'
        },
        'light': {
            backgroundColor: '#ffffff',
            textColor: '#2d3748',
            borderColor: '#e2e8f0',
            shadow: '0 2px 8px rgba(0,0,0,0.1)'
        }
    };

    return themes[theme] || themes['default'];
}

/**
 * Get animation configuration
 */
function getAnimation(animation, duration) {
    const animations = {
        'slide': {
            type: 'slide',
            duration: duration || 300
        },
        'fade': {
            type: 'fade',
            duration: duration || 300
        },
        'bounce': {
            type: 'bounce',
            duration: duration || 400
        },
        'zoom': {
            type: 'zoom',
            duration: duration || 300
        },
        'none': {
            type: 'none',
            duration: 0
        }
    };

    return animations[animation] || animations['slide'];
}

/**
 * Get size configuration
 */
function getSize(size) {
    const sizes = {
        'small': {
            width: 280,
            height: 80,
            fontSize: '12px',
            padding: '8px'
        },
        'medium': {
            width: 350,
            height: 100,
            fontSize: '14px',
            padding: '12px'
        },
        'large': {
            width: 420,
            height: 120,
            fontSize: '16px',
            padding: '16px'
        }
    };

    return sizes[size] || sizes['medium'];
}

/**
 * Get sound configuration
 */
function getSoundConfig(sound, customSoundFile) {
    const config = {
        enabled: sound !== false,
        file: null
    };

    // If custom sound file is provided and exists, use it
    if (customSoundFile && fs.existsSync(customSoundFile)) {
        config.file = customSoundFile;
    }

    return config;
} 