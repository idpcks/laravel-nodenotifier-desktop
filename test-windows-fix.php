<?php

require_once __DIR__ . '/vendor/autoload.php';

use LaravelNodeNotifierDesktop\Services\DesktopNotifierService;

echo "Testing Windows Command Execution Fix\n";
echo "===================================\n\n";

$service = new DesktopNotifierService();

// Test 1: Check Node.js path detection
echo "1. Testing Node.js path detection:\n";
$nodePath = $service->findNodePath();
echo "   Node.js path: " . ($nodePath ?? 'null') . "\n";

// Test 2: Check Node.js availability
echo "\n2. Testing Node.js availability:\n";
$nodeAvailable = $service->isNodeAvailable();
$nodeVersion = $service->getNodeVersion();
echo "   Available: " . ($nodeAvailable ? 'Yes' : 'No') . "\n";
echo "   Version: " . ($nodeVersion ?? 'Unknown') . "\n";

// Test 3: Test command building
echo "\n3. Testing command building:\n";
try {
    $command = $service->buildNodeCommand('Test Title', 'Test Message', []);
    echo "   Command: $command\n";
    echo "   ✓ Command built successfully\n";
} catch (Exception $e) {
    echo "   ✗ Command building failed: " . $e->getMessage() . "\n";
}

// Test 4: Test notification (if Node.js is available)
echo "\n4. Testing notification:\n";
if ($nodeAvailable) {
    try {
        $result = $service->notify('Test Notification', 'This is a test notification from Windows fix test');
        echo "   Result: " . ($result ? 'Success' : 'Failed') . "\n";
    } catch (Exception $e) {
        echo "   ✗ Notification failed: " . $e->getMessage() . "\n";
    }
} else {
    echo "   ⚠️  Skipping notification test - Node.js not available\n";
}

// Test 5: Check configuration
echo "\n5. Testing configuration:\n";
$config = config('laravel-nodenotifierdesktop.node_path');
echo "   node_path config: " . ($config ?? 'null') . "\n";

echo "\nTest completed!\n";
echo "\nExpected behavior:\n";
echo "- Node.js path should not be null or empty\n";
echo "- Command should not contain double quotes around 'node'\n";
echo "- Notification should work without command execution errors\n"; 