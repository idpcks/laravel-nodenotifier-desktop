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
- Node.js 12+ (for desktop notifications)
- npm (comes with Node.js)

### Platform Support
- ✅ Windows 10/11
- ✅ macOS (latest versions)
- ✅ Linux (Ubuntu, CentOS, etc.)

## Installation

### 1. Install the package via Composer:

```bash
composer require laravel-nodenotifierdesktop/laravel-nodenotifierdesktop
```

### 2. Publish the configuration file (optional):

```bash
php artisan vendor:publish --tag=laravel-nodenotifierdesktop-config
```

### 3. Install Node.js dependencies:

```bash
php artisan desktop-notifier:install
```

This command will:
- ✅ Check Node.js and npm availability
- ✅ Install `node-notifier` in the vendor directory
- ✅ Copy the notifier script to the correct location
- ✅ Test the installation with a sample notification

### Windows Users - Important Notes

The package includes special handling for Windows:
- ✅ **Automatic Windows detection** - No extra configuration needed
- ✅ **Fixed command line escaping** - Resolves JSON parsing errors
- ✅ **Proper path handling** - Works with Windows file paths
- ✅ **Enhanced error messages** - Clear troubleshooting information

If you encounter issues on Windows:

1. **Ensure Node.js is in your PATH:**
   ```cmd
   node --version
   npm --version
   ```

2. **Run as Administrator** if you get permission errors:
   ```cmd
   # Run your terminal as Administrator, then:
   php artisan desktop-notifier:install --force
   ```

3. **Check Windows notifications are enabled:**
   - Go to Settings > System > Notifications & actions
   - Ensure notifications are enabled for your system

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

### Common Issues

#### 🐛 "SyntaxError: Expected property name or '}' in JSON" (Windows)
**Fixed in v1.0.2!** This was a command line escaping issue on Windows.
- **Solution:** Update to v1.0.2 or later
- **Verification:** Run `php artisan desktop-notifier:install --force`

#### 🐛 "Cannot find module 'node-notifier'"
This means Node.js dependencies weren't installed properly.
- **Solution:** Run `php artisan desktop-notifier:install`
- **Alternative:** Manually install: `npm install node-notifier` in vendor directory

#### 🐛 "node: command not found"
Node.js is not installed or not in your PATH.
- **Solution:** Install Node.js from https://nodejs.org/
- **Windows:** Restart your terminal after installation
- **Linux/macOS:** Add Node.js to your PATH

### Platform-Specific Issues

#### Windows 🪟
- ✅ **Notifications not showing:**
  - Go to Settings > System > Notifications & actions
  - Enable notifications for your system
  - Check focus assist settings

- ✅ **Permission errors:**
  - Run terminal as Administrator
  - Use `--force` flag: `php artisan desktop-notifier:install --force`

- ✅ **Path issues:**
  - Ensure Node.js is in system PATH
  - Restart terminal after Node.js installation

#### macOS 🍎
- Allow notifications for your terminal/IDE
- Check System Preferences > Notifications
- Grant notification permissions when prompted

#### Linux 🐧
- Install notification daemon: `sudo apt-get install libnotify-bin`
- For Ubuntu: `sudo apt-get install notify-osd`
- For CentOS: `sudo yum install notification-daemon`
- Check if your desktop environment supports notifications

### Debug Mode

Enable debug logging in your `.env`:
```env
LOG_LEVEL=debug
```

Then check `storage/logs/laravel.log` for detailed error information.

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests
5. Submit a pull request

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

## Changelog

### Version 1.0.2 (Bug Fix Release)
- 🐛 **FIXED:** Windows command line escaping issue causing JSON parsing errors
- 🐛 **FIXED:** Missing Node.js dependencies in vendor installation
- ✅ **NEW:** Enhanced cross-platform error handling and logging
- ✅ **NEW:** Automatic Windows detection and platform-specific handling
- ✅ **NEW:** Improved installation command with better dependency management
- ✅ **NEW:** Test notification feature in install command
- 📚 **IMPROVED:** Documentation with Windows-specific troubleshooting
- 🔧 **IMPROVED:** Better error messages and debugging information

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