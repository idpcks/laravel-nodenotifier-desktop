# Changelog

All notable changes to `laravel-nodenotifierdesktop` will be documented in this file.

## [1.0.2] - 2024-12-19 - Bug Fix Release

### 🐛 Bug Fixes
- **CRITICAL FIX:** Resolved Windows command line escaping issue causing JSON parsing errors
- **DEPENDENCY FIX:** Fixed missing Node.js dependencies in vendor installation
- **PATH FIX:** Improved script path resolution for different installation scenarios

### ✨ New Features
- Enhanced cross-platform error handling and logging
- Automatic Windows detection and platform-specific command execution
- Test notification feature in installation command
- Debug mode configuration option
- Better error messages with actionable troubleshooting steps

### 🔧 Improvements
- Improved installation command with proper dependency management
- Enhanced logging with platform detection and detailed error information
- Better path handling for vendor directory installations
- Added executable permissions for Unix-like systems

### 📚 Documentation
- Added comprehensive Windows-specific troubleshooting guide
- Updated installation instructions with detailed steps
- Added platform support matrix
- Improved error troubleshooting documentation

### 🧪 Testing
- Added tests for Windows JSON escaping fix
- Added tests for special character handling
- Enhanced test coverage for error scenarios

### 💔 Breaking Changes
None - This is a backward-compatible bug fix release.

### 🔄 Migration Guide
To update from v1.0.1 or earlier:

1. Update the package:
   ```bash
   composer update laravel-nodenotifierdesktop/laravel-nodenotifierdesktop
   ```

2. Reinstall Node.js dependencies:
   ```bash
   php artisan desktop-notifier:install --force
   ```

3. Test with a notification:
   ```bash
   php artisan tinker
   DesktopNotifier::success('Update Complete', 'Version 1.0.2 is working!')
   ```

---

## [1.1.0] - 2024-12-19

### ✨ New Features
- Added Laravel 12 support
- Enhanced type declarations for better IDE support

### 🔧 Improvements
- Updated minimum PHP requirement to 8.1
- Updated testing dependencies for Laravel 12 compatibility
- Added modern PHP features and type safety

---

## [1.0.0] - 2024-12-18

### 🎉 Initial Release
- Cross-platform desktop notifications (Windows, macOS, Linux)
- Multiple notification types (success, error, warning, info)
- Customizable notification icons and sounds
- Easy configuration system
- Artisan command for installation
- Comprehensive logging support
- Laravel service provider integration
- Facade support for easy usage