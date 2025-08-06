#!/usr/bin/env node

const notifier = require('node-notifier');
const path = require('path');

// Get notification data from command line arguments
const notificationData = process.argv[2];

if (!notificationData) {
    console.error('No notification data provided');
    process.exit(1);
}

try {
    const data = JSON.parse(notificationData);
    const { title, message, options = {} } = data;

    // Default options
    const defaultOptions = {
        title: title || 'Laravel Notification',
        message: message || '',
        icon: options.icon || path.join(__dirname, 'default-icon.png'),
        sound: options.sound !== false, // Default to true
        timeout: options.timeout || 5000,
        wait: false,
        type: 'info'
    };

    // Platform-specific options
    if (process.platform === 'win32') {
        defaultOptions.icon = options.icon || path.join(__dirname, 'icons', 'info.png');
    } else if (process.platform === 'darwin') {
        defaultOptions.icon = options.icon || path.join(__dirname, 'icons', 'info.png');
    } else {
        // Linux
        defaultOptions.icon = options.icon || path.join(__dirname, 'icons', 'info.png');
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