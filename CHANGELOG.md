# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.2.0] - 2024-12-19

### Added
- **Custom Positioning**: Set notification position on screen with preset positions or custom coordinates
  - Preset positions: `top-right`, `top-left`, `bottom-right`, `bottom-left`, `top-center`, `bottom-center`
  - Custom coordinates: Set exact X,Y coordinates on screen
  - Default position: `bottom-right` (pojok kanan bawah)

- **Multiple UI Themes**: Choose from different visual themes
  - `default` - Tema default
  - `modern` - Tema modern dengan shadow
  - `dark` - Tema gelap
  - `light` - Tema terang  
  - `minimal` - Tema minimalis

- **Custom Animations**: Control notification appearance animations
  - `slide` - Slide in/out (default)
  - `fade` - Fade in/out
  - `bounce` - Bounce effect
  - `zoom` - Zoom in/out
  - `none` - Tanpa animasi
  - Customizable animation duration

- **Adjustable Sizes**: Choose notification size
  - `small` - 280x80px
  - `medium` - 350x100px (default)
  - `large` - 420x120px

- **Custom Sound Files**: Use your own notification sounds
  - Supported formats: `.wav`, `.mp3`, `.ogg`
  - Fallback to system default if custom file not found
  - Option to disable sound completely

- **New Methods**: Easy-to-use methods for each customization feature
  - `notifyAtPosition()` - Set notification position
  - `notifyAtCoordinates()` - Set custom coordinates
  - `notifyWithTheme()` - Apply UI theme
  - `notifyWithAnimation()` - Set animation type and duration
  - `notifyWithSize()` - Set notification size
  - `notifyWithSound()` - Use custom sound file
  - `notifySilent()` - Send notification without sound

- **Configuration Options**: Set defaults in config file
  - `position` - Default notification position
  - `ui_theme` - Default UI theme
  - `animation` - Default animation type
  - `animation_duration` - Default animation duration
  - `size` - Default notification size
  - `custom_sound_file` - Default custom sound file
  - `custom_position` - Default custom coordinates

- **Comprehensive Examples**: Complete usage examples in `examples/CustomizationExamples.php`

### Changed
- Enhanced configuration structure with new customization options
- Improved documentation with detailed customization guide
- Better integration between PHP service and Node.js notifier script

### Documentation
- Added comprehensive customization documentation
- Created detailed usage examples
- Updated README with new features and methods
- Added configuration examples

## [1.0.4] - 2024-12-18

### Fixed
- Windows command execution issue with empty Node.js path causing `"'\"\"' is not recognized as an internal or external command"`
- Double-quoting issues in Windows command execution
- Default configuration now uses 'node' instead of null for node_path

### Added
- Improved Windows command line handling without additional quoting
- Better fallback logic for Node.js path detection
- More robust command building for Windows systems

## [1.0.3] - 2024-12-17

### Fixed
- Windows command execution issue with empty Node.js path
- "is not recognized as an internal or external command" error

### Added
- Automatic Node.js path detection for Windows and Unix systems
- Debug command (`php artisan desktop-notifier:debug`) for troubleshooting
- Enhanced error logging with Node.js path and version information
- Better Windows command line handling and escaping
- Uninstall scripts (PHP + Windows batch) and documentation for easy package removal

### Improved
- More robust Node.js availability checking
- Comprehensive troubleshooting and uninstall documentation

## [1.0.2] - 2024-12-16

### Fixed
- Windows command line escaping issue causing JSON parsing errors
- Missing Node.js dependencies in vendor installation

### Added
- Enhanced cross-platform error handling and logging
- Automatic Windows detection and platform-specific handling
- Improved installation command with better dependency management
- Test notification feature in install command

### Improved
- Documentation with Windows-specific troubleshooting
- Better error messages and debugging information

## [1.1.0] - 2024-12-15

### Added
- Laravel 12 support
- Updated minimum PHP requirement to 8.1
- Enhanced type declarations for better IDE support
- Updated testing dependencies

## [1.0.0] - 2024-12-14

### Added
- Initial release
- Cross-platform desktop notifications (Windows, macOS, Linux)
- Multiple notification types (success, error, warning, info)
- Artisan command for easy installation
- Basic configuration options
- Logging support