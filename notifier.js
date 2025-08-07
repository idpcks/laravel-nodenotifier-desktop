#!/usr/bin/env node

const notifier = require('node-notifier');
const path = require('path');
const fs = require('fs');

// Performance optimization: Cache frequently used values
const cache = {
    themes: null,
    animations: null,
    sizes: null,
    screenDimensions: null,
    soundConfigs: new Map()
};

// Performance monitoring
const performanceMetrics = {
    startTime: Date.now(),
    notificationCount: 0,
    totalExecutionTime: 0
};

// Get notification data from command line arguments
const notificationData = process.argv[2];

if (!notificationData) {
    console.error('No notification data provided');
    process.exit(1);
}

try {
    const startTime = process.hrtime.bigint();
    
    const data = JSON.parse(notificationData);
    const { title, message, options = {} } = data;

    // Calculate position based on configuration (with caching)
    const position = calculatePosition(options.position, options.custom_position);
    
    // Get theme and styling (with caching)
    const theme = getTheme(options.ui_theme);
    const animation = getAnimation(options.animation, options.animation_duration);
    const size = getSize(options.size);
    
    // Get sound configuration (with caching)
    const soundConfig = getSoundConfig(options.sound, options.custom_sound_file);

    // Default options with optimized structure
    const defaultOptions = {
        title: title || 'Laravel Notification',
        message: message || '',
        icon: options.icon || getDefaultIcon(),
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

    // Platform-specific optimizations
    applyPlatformSpecificOptions(defaultOptions, options, position);

    // Send notification with performance tracking
    notifier.notify(defaultOptions, (err, response) => {
        const endTime = process.hrtime.bigint();
        const executionTime = Number(endTime - startTime) / 1000000; // Convert to milliseconds
        
        performanceMetrics.notificationCount++;
        performanceMetrics.totalExecutionTime += executionTime;
        
        if (err) {
            console.error('Notification error:', err);
            process.exit(1);
        }
        
        // Log performance metrics if enabled
        if (process.env.DEBUG_NOTIFIER === 'true') {
            console.log(`Notification sent successfully in ${executionTime.toFixed(2)}ms`);
        } else {
            console.log('Notification sent successfully');
        }
        
        process.exit(0);
    });

    // Handle notification actions with timeout
    const actionTimeout = setTimeout(() => {
        process.exit(0);
    }, (options.timeout || 5000) + 1000);

    notifier.on('click', () => {
        clearTimeout(actionTimeout);
        console.log('Notification clicked');
        process.exit(0);
    });

    notifier.on('timeout', () => {
        clearTimeout(actionTimeout);
        console.log('Notification timeout');
        process.exit(0);
    });

} catch (error) {
    console.error('Error parsing notification data:', error);
    process.exit(1);
}

/**
 * Calculate notification position with caching
 */
function calculatePosition(position, customPosition) {
    // If custom position is provided, use it
    if (customPosition && customPosition.x !== undefined && customPosition.y !== undefined) {
        return { x: customPosition.x, y: customPosition.y };
    }

    // Use cached screen dimensions
    if (!cache.screenDimensions) {
        cache.screenDimensions = getScreenDimensions();
    }

    const { screenWidth, screenHeight } = cache.screenDimensions;
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
 * Get screen dimensions with fallback
 */
function getScreenDimensions() {
    // Try to get actual screen dimensions if possible
    try {
        if (process.platform === 'win32') {
            // Windows: Try to get from environment or use defaults
            const width = parseInt(process.env.SCREEN_WIDTH) || 1920;
            const height = parseInt(process.env.SCREEN_HEIGHT) || 1080;
            return { screenWidth: width, screenHeight: height };
        } else if (process.platform === 'darwin') {
            // macOS: Try to get from environment or use defaults
            const width = parseInt(process.env.SCREEN_WIDTH) || 1920;
            const height = parseInt(process.env.SCREEN_HEIGHT) || 1080;
            return { screenWidth: width, screenHeight: height };
        } else {
            // Linux: Try to get from environment or use defaults
            const width = parseInt(process.env.SCREEN_WIDTH) || 1920;
            const height = parseInt(process.env.SCREEN_HEIGHT) || 1080;
            return { screenWidth: width, screenHeight: height };
        }
    } catch (error) {
        // Fallback to common resolution
        return { screenWidth: 1920, screenHeight: 1080 };
    }
}

/**
 * Get theme configuration with caching
 */
function getTheme(theme) {
    if (!cache.themes) {
        cache.themes = {
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
    }

    return cache.themes[theme] || cache.themes['default'];
}

/**
 * Get animation configuration with caching
 */
function getAnimation(animation, duration) {
    if (!cache.animations) {
        cache.animations = {
            'slide': {
                type: 'slide',
                duration: 300
            },
            'fade': {
                type: 'fade',
                duration: 300
            },
            'bounce': {
                type: 'bounce',
                duration: 400
            },
            'zoom': {
                type: 'zoom',
                duration: 300
            },
            'none': {
                type: 'none',
                duration: 0
            }
        };
    }

    const anim = cache.animations[animation] || cache.animations['slide'];
    return {
        type: anim.type,
        duration: duration || anim.duration
    };
}

/**
 * Get size configuration with caching
 */
function getSize(size) {
    if (!cache.sizes) {
        cache.sizes = {
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
    }

    return cache.sizes[size] || cache.sizes['medium'];
}

/**
 * Get sound configuration with caching
 */
function getSoundConfig(sound, customSoundFile) {
    const cacheKey = `${sound}-${customSoundFile}`;
    
    if (cache.soundConfigs.has(cacheKey)) {
        return cache.soundConfigs.get(cacheKey);
    }

    const config = {
        enabled: sound !== false,
        file: null
    };

    // If custom sound file is provided and exists, use it
    if (customSoundFile && fs.existsSync(customSoundFile)) {
        config.file = customSoundFile;
    }

    // Cache the result
    cache.soundConfigs.set(cacheKey, config);
    
    // Limit cache size to prevent memory issues
    if (cache.soundConfigs.size > 50) {
        const firstKey = cache.soundConfigs.keys().next().value;
        cache.soundConfigs.delete(firstKey);
    }

    return config;
}

/**
 * Get default icon with caching
 */
function getDefaultIcon() {
    const iconPath = path.join(__dirname, 'icons', 'info.png');
    
    // Check if icon exists, otherwise use a fallback
    if (fs.existsSync(iconPath)) {
        return iconPath;
    }
    
    // Try alternative paths
    const alternativePaths = [
        path.join(__dirname, 'default-icon.png'),
        path.join(__dirname, 'icon.png'),
        path.join(__dirname, 'icons', 'default.png')
    ];
    
    for (const altPath of alternativePaths) {
        if (fs.existsSync(altPath)) {
            return altPath;
        }
    }
    
    // Return null if no icon found (system will use default)
    return null;
}

/**
 * Apply platform-specific optimizations
 */
function applyPlatformSpecificOptions(defaultOptions, options, position) {
    if (process.platform === 'win32') {
        defaultOptions.icon = options.icon || getDefaultIcon();
        // Windows-specific positioning
        if (position.x !== undefined && position.y !== undefined) {
            defaultOptions.x = position.x;
            defaultOptions.y = position.y;
        }
    } else if (process.platform === 'darwin') {
        defaultOptions.icon = options.icon || getDefaultIcon();
        // macOS-specific positioning
        if (position.x !== undefined && position.y !== undefined) {
            defaultOptions.x = position.x;
            defaultOptions.y = position.y;
        }
    } else {
        // Linux
        defaultOptions.icon = options.icon || getDefaultIcon();
        // Linux-specific positioning
        if (position.x !== undefined && position.y !== undefined) {
            defaultOptions.x = position.x;
            defaultOptions.y = position.y;
        }
    }
}

/**
 * Get performance statistics
 */
function getPerformanceStats() {
    const uptime = Date.now() - performanceMetrics.startTime;
    const avgExecutionTime = performanceMetrics.notificationCount > 0 
        ? performanceMetrics.totalExecutionTime / performanceMetrics.notificationCount 
        : 0;
    
    return {
        uptime: Math.round(uptime / 1000) + 's',
        notificationCount: performanceMetrics.notificationCount,
        averageExecutionTime: avgExecutionTime.toFixed(2) + 'ms',
        totalExecutionTime: performanceMetrics.totalExecutionTime.toFixed(2) + 'ms'
    };
}

// Export performance stats for external access
if (process.env.EXPORT_STATS === 'true') {
    console.log(JSON.stringify(getPerformanceStats()));
} 