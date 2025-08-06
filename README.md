# Laravel Node Notifier Desktop

A Laravel package that provides desktop notifications using node-notifier. This package allows you to send desktop notifications from your Laravel application to the user's computer.

## Features

- 🖥️ Cross-platform desktop notifications (Windows, macOS, Linux)
- 🎨 Customizable notification icons and sounds
- 📝 Multiple notification types (success, error, warning, info)
- 🔧 Easy configuration
- 🚀 Simple installation with Artisan command
- 📊 Logging support
- ⚡ Laravel 12 ready with modern PHP features

## Requirements

- PHP 8.1 or higher
- Laravel 9.0, 10.0, 11.0, or 12.0
- Node.js (for desktop notifications)

## Installation

1. Install the package via Composer:

```bash
composer require laravel-nodenotifierdesktop/laravel-nodenotifierdesktop
```

2. Publish the configuration file:

```bash
php artisan vendor:publish --tag=laravel-nodenotifierdesktop-config
```

3. Install Node.js dependencies:

```bash
php artisan desktop-notifier:install
```

## Configuration

The configuration file is located at `config/laravel-nodenotifierdesktop.php`. You can customize:

- Default icons for different notification types
- Default sound settings
- Notification timeout
- Node.js path
- Logging preferences

## Usage

### Basic Usage

```php
use LaravelNodeNotifierDesktop\Facades\DesktopNotifier;

// Send a basic notification
DesktopNotifier::notify('Hello', 'This is a test notification');

// Send different types of notifications
DesktopNotifier::success('Success!', 'Operation completed successfully');
DesktopNotifier::error('Error!', 'Something went wrong');
DesktopNotifier::warning('Warning!', 'Please check your input');
DesktopNotifier::info('Info', 'Here is some information');
```

### Advanced Usage

```php
// With custom options
DesktopNotifier::notify('Custom Notification', 'With custom settings', [
    'icon' => '/path/to/custom/icon.png',
    'sound' => false,
    'timeout' => 10000
]);

// Using dependency injection
public function someMethod(DesktopNotifierService $notifier)
{
    $notifier->success('Success!', 'Operation completed');
}
```

### In Controllers

```php
<?php

namespace App\Http\Controllers;

use LaravelNodeNotifierDesktop\Facades\DesktopNotifier;

class NotificationController extends Controller
{
    public function sendNotification()
    {
        DesktopNotifier::success('Task Completed', 'Your background task has finished');
        
        return response()->json(['message' => 'Notification sent']);
    }
}
```

### In Jobs

```php
<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use LaravelNodeNotifierDesktop\Facades\DesktopNotifier;

class ProcessTask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // Do some work...
        
        // Send notification when done
        DesktopNotifier::success('Task Completed', 'Background task finished successfully');
    }
}
```

## Available Methods

### DesktopNotifier Facade

- `notify(string $title, string $message, array $options = [])` - Send a basic notification
- `success(string $title, string $message, array $options = [])` - Send a success notification
- `error(string $title, string $message, array $options = [])` - Send an error notification
- `warning(string $title, string $message, array $options = [])` - Send a warning notification
- `info(string $title, string $message, array $options = [])` - Send an info notification
- `isNodeAvailable()` - Check if Node.js is available
- `isNotifierScriptAvailable()` - Check if the notifier script exists

### Options

- `icon` - Path to custom icon file
- `sound` - Whether to play sound (boolean)
- `timeout` - Notification timeout in milliseconds
- `wait` - Whether to wait for user interaction (boolean)

## Artisan Commands

### Install Dependencies

```bash
php artisan desktop-notifier:install
```

This command will:
- Check if Node.js is available
- Create package.json if it doesn't exist
- Install node-notifier dependency
- Copy the notifier script to the correct location

### Force Reinstall

```bash
php artisan desktop-notifier:install --force
```

## Troubleshooting

### Node.js Not Found

If you get an error that Node.js is not found:

1. Install Node.js from https://nodejs.org/
2. Make sure Node.js is in your system PATH
3. Restart your terminal/command prompt

### Notifications Not Showing

1. Check if Node.js is available: `node --version`
2. Verify the notifier script exists
3. Check the Laravel logs for any errors
4. Make sure your system allows desktop notifications

### Platform-Specific Issues

#### Windows
- Make sure Windows notifications are enabled
- Check Windows notification settings

#### macOS
- Allow notifications for your terminal/IDE
- Check System Preferences > Notifications

#### Linux
- Install notification daemon (e.g., `notify-osd`, `dunst`)
- Check if your desktop environment supports notifications

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests
5. Submit a pull request

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

## Changelog

### Version 1.1.0
- ✅ Added Laravel 12 support
- 🔧 Updated minimum PHP requirement to 8.1
- ⚡ Enhanced type declarations for better IDE support
- 🧪 Updated testing dependencies

### Version 1.0.0
- 🎉 Initial release
- 🖥️ Cross-platform desktop notifications
- 📝 Multiple notification types
- 🚀 Artisan command for easy installation

## Support

If you encounter any issues or have questions, please open an issue on GitHub. 