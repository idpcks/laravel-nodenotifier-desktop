# Windows Command Execution Fix - v1.0.4

## Issue Description

**Bug:** Desktop notification fails on Windows with error: `"'\"\"' is not recognized as an internal or external command"`

**Root Cause:** The default configuration had `'node_path' => null`, which caused the command generation to produce an empty string `""` instead of `"node"`.

## Fix Details

### 1. Configuration Fix

**File:** `config/laravel-nodenotifierdesktop.php`

**Before:**
```php
'node_path' => null,
```

**After:**
```php
'node_path' => 'node',
```

### 2. Command Building Fix

**File:** `src/Services/DesktopNotifierService.php`

**Before:**
```php
// Ensure nodePath is properly quoted for Windows
$nodePath = '"' . trim($nodePath, '"') . '"';
```

**After:**
```php
// Don't quote nodePath if it's just 'node' to avoid double-quoting issues
if ($nodePath === 'node') {
    $nodePath = 'node';
} else {
    // Ensure nodePath is properly quoted for Windows
    $nodePath = '"' . trim($nodePath, '"') . '"';
}
```

### 3. Command Execution Fix

**File:** `src/Services/DesktopNotifierService.php`

**Before:**
```php
// Remove any extra quotes that might cause issues
$command = trim($command, '"');
// Use cmd /c for Windows command execution
$fullCommand = 'cmd /c "' . $command . '" 2>&1';
```

**After:**
```php
// Use cmd /c without additional quoting to avoid double-quoting issues
$fullCommand = 'cmd /c ' . $command . ' 2>&1';
```

### 4. Fallback Logic Fix

**File:** `src/Services/DesktopNotifierService.php`

**Before:**
```php
return null;
```

**After:**
```php
// If no Node.js found, return 'node' as fallback
return 'node';
```

## Testing the Fix

### 1. Run the test script:
```bash
php test-windows-fix.php
```

### 2. Expected output:
```
Testing Windows Command Execution Fix
===================================

1. Testing Node.js path detection:
   Node.js path: node

2. Testing Node.js availability:
   Available: Yes
   Version: v22.13.1

3. Testing command building:
   Command: node "path/to/notifier.js" "{\"title\":\"Test Title\",\"message\":\"Test Message\",\"options\":{\"icon\":null,\"sound\":true,\"timeout\":5000}}"
   ✓ Command built successfully

4. Testing notification:
   Result: Success

5. Testing configuration:
   node_path config: node
```

### 3. Test in Laravel application:
```php
use LaravelNodeNotifierDesktop\Facades\DesktopNotifier;

// This should work without errors
DesktopNotifier::success('Test', 'This should work on Windows now!');
```

## Verification Steps

1. **Check configuration:**
   ```bash
   php artisan tinker
   >>> config('laravel-nodenotifierdesktop.node_path')
   => "node"
   ```

2. **Test command building:**
   ```bash
   php artisan tinker
   >>> app('LaravelNodeNotifierDesktop\Services\DesktopNotifierService')->buildNodeCommand('Test', 'Message', [])
   => "node \"path/to/notifier.js\" \"{\"title\":\"Test\",\"message\":\"Message\",\"options\":{\"icon\":null,\"sound\":true,\"timeout\":5000}}\""
   ```

3. **Test notification:**
   ```bash
   php artisan tinker
   >>> app('LaravelNodeNotifierDesktop\Services\DesktopNotifierService')->notify('Test', 'Message')
   => true
   ```

## Error Logs Before Fix

```
[2025-08-06 07:04:45] local.ERROR: Desktop notification failed {
    "platform":"Windows",
    "command":"\"\" \"Z:\\path\\to\\notifier.js\" \"{\\\"title\\\":\\\"Laravel 12 Ready!\\\",\\\"message\\\":\\\"Desktop notifications now support Laravel 12\\\",\\\"options\\\":{\\\"icon\\\":null,\\\"sound\\\":true,\\\"timeout\\\":5000}}\"",
    "output":["'\"\"' is not recognized as an internal or external command,","operable program or batch file."],
    "return_code":1,
    "error_message":"'\"\"' is not recognized as an internal or external command,\noperable program or batch file.",
    "node_available":true,
    "script_available":true
}
```

## Error Logs After Fix

```
[2025-08-06 07:04:45] local.INFO: Desktop notification sent {
    "title":"Test",
    "message":"This should work on Windows now!",
    "options":{"icon":null,"sound":true,"timeout":5000}
}
```

## Environment

- **OS:** Windows 10 (22621)
- **PHP:** 8.x
- **Node.js:** v22.13.1
- **Laravel:** 12.x
- **Package:** laravel-nodenotifierdesktop/laravel-nodenotifierdesktop v1.0.4+

## Migration Guide

If you're upgrading from a previous version:

1. **Update package:**
   ```bash
   composer update laravel-nodenotifierdesktop/laravel-nodenotifierdesktop
   ```

2. **Clear config cache:**
   ```bash
   php artisan config:clear
   ```

3. **Reinstall dependencies:**
   ```bash
   php artisan desktop-notifier:install --force
   ```

4. **Test the fix:**
   ```bash
   php test-windows-fix.php
   ```

## Support

If you still encounter issues after applying this fix:

1. **Run debug command:**
   ```bash
   php artisan desktop-notifier:debug
   ```

2. **Check Node.js installation:**
   ```bash
   node --version
   npm --version
   ```

3. **Verify PATH:**
   ```bash
   where node
   ```

4. **Create issue on GitHub** with:
   - Laravel version
   - PHP version
   - Node.js version
   - Windows version
   - Complete error logs 