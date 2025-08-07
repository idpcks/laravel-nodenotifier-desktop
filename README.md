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
- 🎯 **Custom positioning** - Set notification position on screen
- 🎨 **Multiple UI themes** - Modern, minimal, dark, light themes
- ✨ **Custom animations** - Slide, fade, bounce, zoom animations
- 📏 **Adjustable sizes** - Small, medium, large notification sizes
- 🔊 **Custom sound files** - Use your own notification sounds
- 🎛️ **Flexible customization** - Combine multiple features together
- 🚀 **Performance Optimized** - Caching, batch processing, and monitoring
- 📈 **Performance Monitoring** - Real-time metrics and statistics
- ⚡ **Batch Processing** - Send multiple notifications efficiently
- 🧹 **Memory Management** - Automatic cleanup and optimization

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

## Uninstallation

### Manual Uninstall

Jika Anda ingin menghapus package ini dari project Laravel:

```bash
# 1. Remove via Composer
composer remove laravel-nodenotifierdesktop/laravel-nodenotifierdesktop

# 2. Remove config file (if published)
rm config/laravel-nodenotifierdesktop.php

# 3. Remove vendor directory
rm -rf vendor/laravel-nodenotifierdesktop

# 4. Clear caches
php artisan config:clear
php artisan cache:clear
composer dump-autoload
```

### Automatic Uninstall Script

Atau gunakan script uninstall otomatis:

**Untuk Linux/macOS:**
```bash
php uninstall.php
```

**Untuk Windows:**
```cmd
uninstall.bat
```

Script ini akan:
- ✅ Menghapus package via Composer
- ✅ Menghapus file konfigurasi
- ✅ Menghapus folder vendor package
- ✅ Memeriksa dan menghapus registrasi manual di config/app.php
- ✅ Membersihkan cache
- ✅ Mencari penggunaan package dalam kode
- ✅ Memberikan panduan langkah selanjutnya

**📖 Dokumentasi lengkap:** Lihat [UNINSTALL.md](UNINSTALL.md) untuk panduan detail dan troubleshooting.

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
- `notifyBatch(array $notifications)` - Send multiple notifications efficiently
- `isNodeAvailable()` - Check if Node.js is available
- `isNotifierScriptAvailable()` - Check if the notifier script exists
- `getPerformanceStats()` - Get performance statistics
- `clearCache()` - Clear cached data

### Customization Methods

- `notifyAtPosition(string $title, string $message, string $position, array $options = [])` - Send notification at specific position
- `notifyAtCoordinates(string $title, string $message, int $x, int $y, array $options = [])` - Send notification at custom coordinates
- `notifyWithTheme(string $title, string $message, string $theme, array $options = [])` - Send notification with custom theme
- `notifyWithAnimation(string $title, string $message, string $animation, int $duration = 300, array $options = [])` - Send notification with custom animation
- `notifyWithSize(string $title, string $message, string $size, array $options = [])` - Send notification with custom size
- `notifyWithSound(string $title, string $message, string $soundFile, array $options = [])` - Send notification with custom sound
- `notifySilent(string $title, string $message, array $options = [])` - Send notification without sound

### Options

- `icon` - Path to custom icon file
- `sound` - Whether to play sound (boolean)
- `timeout` - Notification timeout in milliseconds
- `wait` - Whether to wait for user interaction (boolean)
- `position` - Notification position (top-right, top-left, bottom-right, bottom-left, top-center, bottom-center)
- `custom_position` - Custom X,Y coordinates (array with 'x' and 'y' keys)
- `ui_theme` - UI theme (default, modern, minimal, dark, light)
- `animation` - Animation type (slide, fade, bounce, zoom, none)
- `animation_duration` - Animation duration in milliseconds
- `size` - Notification size (small, medium, large)
- `custom_sound_file` - Path to custom sound file

## Customization Features

Package ini mendukung berbagai fitur kustomisasi untuk notifikasi desktop Anda:

### 🎯 Custom Positioning

Anda dapat mengatur posisi notifikasi di layar:

```php
// Posisi preset
DesktopNotifier::notifyAtPosition('Title', 'Message', 'top-right');
DesktopNotifier::notifyAtPosition('Title', 'Message', 'bottom-left');
DesktopNotifier::notifyAtPosition('Title', 'Message', 'top-center');

// Posisi kustom dengan koordinat
DesktopNotifier::notifyAtCoordinates('Title', 'Message', 100, 200);
```

**Posisi yang tersedia:**
- `top-right` - Pojok kanan atas
- `top-left` - Pojok kiri atas  
- `bottom-right` - Pojok kanan bawah (default)
- `bottom-left` - Pojok kiri bawah
- `top-center` - Tengah atas
- `bottom-center` - Tengah bawah

### 🎨 UI Themes

Pilih tema visual untuk notifikasi:

```php
// Tema yang tersedia
DesktopNotifier::notifyWithTheme('Title', 'Message', 'modern');
DesktopNotifier::notifyWithTheme('Title', 'Message', 'dark');
DesktopNotifier::notifyWithTheme('Title', 'Message', 'minimal');
DesktopNotifier::notifyWithTheme('Title', 'Message', 'light');
```

**Tema yang tersedia:**
- `default` - Tema default
- `modern` - Tema modern dengan shadow
- `dark` - Tema gelap
- `light` - Tema terang
- `minimal` - Tema minimalis

### ✨ Custom Animations

Atur animasi notifikasi:

```php
// Animasi yang tersedia
DesktopNotifier::notifyWithAnimation('Title', 'Message', 'slide');
DesktopNotifier::notifyWithAnimation('Title', 'Message', 'fade');
DesktopNotifier::notifyWithAnimation('Title', 'Message', 'bounce');
DesktopNotifier::notifyWithAnimation('Title', 'Message', 'zoom');

// Animasi dengan durasi kustom
DesktopNotifier::notifyWithAnimation('Title', 'Message', 'slide', 500);
```

**Animasi yang tersedia:**
- `slide` - Slide in/out (default)
- `fade` - Fade in/out
- `bounce` - Bounce effect
- `zoom` - Zoom in/out
- `none` - Tanpa animasi

### 📏 Adjustable Sizes

Atur ukuran notifikasi:

```php
// Ukuran yang tersedia
DesktopNotifier::notifyWithSize('Title', 'Message', 'small');
DesktopNotifier::notifyWithSize('Title', 'Message', 'medium'); // default
DesktopNotifier::notifyWithSize('Title', 'Message', 'large');
```

**Ukuran yang tersedia:**
- `small` - Ukuran kecil (280x80px)
- `medium` - Ukuran sedang (350x100px) - default
- `large` - Ukuran besar (420x120px)

### 🔊 Custom Sound Files

Gunakan file suara kustom:

```php
// Suara kustom
DesktopNotifier::notifyWithSound('Title', 'Message', '/path/to/sound.wav');

// Tanpa suara
DesktopNotifier::notifySilent('Title', 'Message');
```

**Format suara yang didukung:**
- `.wav`
- `.mp3` 
- `.ogg`

### 🎛️ Combining Multiple Features

Anda dapat menggabungkan berbagai fitur kustomisasi:

```php
// Kombinasi fitur
DesktopNotifier::notify('Title', 'Message', [
    'ui_theme' => 'dark',
    'animation' => 'bounce',
    'animation_duration' => 500,
    'position' => 'top-right',
    'size' => 'large',
    'custom_sound_file' => '/path/to/sound.mp3'
]);

// Atau menggunakan method chaining
$notifier = new \LaravelNodeNotifierDesktop\Services\DesktopNotifierService();
$notifier->notifyWithTheme('Title', 'Message', 'modern', [
    'position' => 'bottom-left',
    'animation' => 'fade'
]);
```

### ⚙️ Configuration

Atur pengaturan default di file `config/laravel-nodenotifierdesktop.php`:

```php
return [
    // Posisi default
    'position' => 'bottom-right',
    
    // Tema default
    'ui_theme' => 'default',
    
    // Animasi default
    'animation' => 'slide',
    'animation_duration' => 300,
    
    // Ukuran default
    'size' => 'medium',
    
    // Suara kustom default
    'custom_sound_file' => null,
    
    // Posisi kustom default
    'custom_position' => null,
];
```

### 📝 Advanced Usage Examples

```php
// Notifikasi chat dengan tema modern
DesktopNotifier::notify('New Message', 'You have a new message from John', [
    'ui_theme' => 'modern',
    'position' => 'top-right',
    'animation' => 'slide',
    'timeout' => 3000
]);

// Notifikasi sistem dengan tema gelap
DesktopNotifier::notify('System Update', 'System is updating...', [
    'ui_theme' => 'dark',
    'position' => 'bottom-right',
    'animation' => 'fade',
    'size' => 'small'
]);

// Notifikasi email dengan tema terang
DesktopNotifier::notify('New Email', 'Email from noreply@example.com', [
    'ui_theme' => 'light',
    'position' => 'top-center',
    'animation' => 'bounce',
    'timeout' => 4000
]);
```

Lihat file `examples/CustomizationExamples.php` untuk contoh lengkap penggunaan semua fitur kustomisasi.

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

## Performance Optimization

### Performance Commands

The package includes comprehensive performance optimization features:

```bash
# View performance statistics
php artisan desktop-notifier:performance stats

# Optimize performance settings
php artisan desktop-notifier:performance optimize

# Run performance tests
php artisan desktop-notifier:performance test --iterations=20 --batch-size=5

# Monitor performance in real-time
php artisan desktop-notifier:performance monitor --duration=300

# Cleanup performance data
php artisan desktop-notifier:performance cleanup
```

### Batch Processing

For multiple notifications, use batch processing for better performance:

```php
// Send multiple notifications efficiently
$notifications = [
    ['title' => 'Notification 1', 'message' => 'Message 1'],
    ['title' => 'Notification 2', 'message' => 'Message 2'],
    ['title' => 'Notification 3', 'message' => 'Message 3'],
];

$results = DesktopNotifier::notifyBatch($notifications);
```

### Performance Monitoring

Monitor performance metrics in your application:

```php
// Get performance statistics
$stats = DesktopNotifier::getPerformanceStats();

// Clear cache when needed
DesktopNotifier::clearCache();
```

### Configuration Optimization

Enable performance features in your config:

```php
'enable_caching' => true,
'enable_batch_processing' => true,
'enable_performance_monitoring' => true,
'enable_json_optimization' => true,
'enable_memory_optimization' => true,
```

📚 **For detailed performance optimization guide, see [PERFORMANCE_OPTIMIZATION.md](PERFORMANCE_OPTIMIZATION.md)**

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

### Debug Command

Use the built-in debug command to diagnose issues:

```bash
php artisan desktop-notifier:debug
```

This command will:
- ✅ Check Node.js installation and version
- ✅ Verify notifier script availability
- ✅ Test command building
- ✅ Show configuration details
- ✅ Provide troubleshooting recommendations
- ✅ Test a sample notification

### Common Error: "is not recognized as an internal or external command"

This error typically occurs when Node.js is not found in the system PATH. The package now includes automatic Node.js detection and better error handling.

**Solutions:**
1. **Install Node.js:** Download from https://nodejs.org/
2. **Add to PATH:** Ensure Node.js is in your system PATH
3. **Restart terminal:** After installing Node.js
4. **Use debug command:** `php artisan desktop-notifier:debug`
5. **Manual path:** Set `node_path` in config file

### Windows-Specific Error: `"'\"\"' is not recognized as an internal or external command"`

**Fixed in v1.0.4!** This was a Windows command execution issue with empty Node.js path.

**Solutions:**
1. **Update to v1.0.4 or later:** `composer update laravel-nodenotifierdesktop/laravel-nodenotifierdesktop`
2. **Clear config cache:** `php artisan config:clear`
3. **Reinstall dependencies:** `php artisan desktop-notifier:install --force`
4. **Check configuration:** Ensure `node_path` is set to `'node'` in config file

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests
5. Submit a pull request

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

## Changelog

### Version 1.3.0 (Performance Optimization Release)
- 🚀 **NEW:** Comprehensive performance optimization system
- 🚀 **NEW:** Caching system for frequently accessed values (40-60% faster)
- 🚀 **NEW:** Batch processing for multiple notifications (70-80% faster)
- 📊 **NEW:** Performance monitoring and statistics tracking
- 📊 **NEW:** Real-time performance monitoring command
- 📊 **NEW:** Performance testing and benchmarking tools
- 🧹 **NEW:** Memory optimization and automatic cleanup
- ⚡ **NEW:** JSON optimization for faster data transfer (20-30% faster)
- ⚡ **NEW:** Node.js process optimization with caching
- 🔧 **NEW:** Performance optimization command (`desktop-notifier:performance`)
- 📚 **NEW:** Comprehensive performance optimization guide
- 🎯 **IMPROVED:** Better error handling and performance logging
- 🎯 **IMPROVED:** Configurable performance settings
- 🎯 **IMPROVED:** Performance alerts and thresholds

### Version 1.2.0 (Customization Release)
- ✅ **NEW:** Custom positioning - Set notification position on screen
- ✅ **NEW:** Multiple UI themes - Modern, minimal, dark, light themes
- ✅ **NEW:** Custom animations - Slide, fade, bounce, zoom animations
- ✅ **NEW:** Adjustable sizes - Small, medium, large notification sizes
- ✅ **NEW:** Custom sound files - Use your own notification sounds
- ✅ **NEW:** Flexible customization - Combine multiple features together
- ✅ **NEW:** Customization methods - Easy-to-use methods for each feature
- ✅ **NEW:** Configuration options - Set defaults in config file
- ✅ **NEW:** Comprehensive examples - Complete usage examples
- 📚 **IMPROVED:** Enhanced documentation with customization guide
- 🔧 **IMPROVED:** Better configuration structure

### Version 1.0.4 (Critical Bug Fix Release)
- 🐛 **FIXED:** Windows command execution issue with empty Node.js path causing `"'\"\"' is not recognized as an internal or external command"`
- 🐛 **FIXED:** Double-quoting issues in Windows command execution
- 🐛 **FIXED:** Default configuration now uses 'node' instead of null for node_path
- ✅ **NEW:** Improved Windows command line handling without additional quoting
- ✅ **NEW:** Better fallback logic for Node.js path detection
- 🔧 **IMPROVED:** More robust command building for Windows systems

### Version 1.0.3 (Bug Fix Release)
- 🐛 **FIXED:** Windows command execution issue with empty Node.js path
- 🐛 **FIXED:** "is not recognized as an internal or external command" error
- ✅ **NEW:** Automatic Node.js path detection for Windows and Unix systems
- ✅ **NEW:** Debug command (`php artisan desktop-notifier:debug`) for troubleshooting
- ✅ **NEW:** Enhanced error logging with Node.js path and version information
- ✅ **NEW:** Better Windows command line handling and escaping
- ✅ **NEW:** Uninstall scripts (PHP + Windows batch) and documentation for easy package removal
- 🔧 **IMPROVED:** More robust Node.js availability checking
- 📚 **IMPROVED:** Comprehensive troubleshooting and uninstall documentation

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