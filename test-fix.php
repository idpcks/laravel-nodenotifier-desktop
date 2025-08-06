<?php

require_once __DIR__ . '/vendor/autoload.php';

use LaravelNodeNotifierDesktop\Services\DesktopNotifierService;

echo "Testing Laravel Node Notifier Desktop Fix\n";
echo "========================================\n\n";

$service = new DesktopNotifierService();

// Test Node.js path detection
echo "1. Testing Node.js path detection:\n";
$nodePath = $service->findNodePath();
if ($nodePath) {
    echo "   ✓ Node.js found at: $nodePath\n";
} else {
    echo "   ✗ Node.js not found\n";
}

// Test Node.js availability
echo "\n2. Testing Node.js availability:\n";
if ($service->isNodeAvailable()) {
    $version = $service->getNodeVersion();
    echo "   ✓ Node.js is available (version: $version)\n";
} else {
    echo "   ✗ Node.js is not available\n";
}

// Test script availability
echo "\n3. Testing notifier script availability:\n";
$scriptPath = $service->getNotifierScriptPath();
if ($service->isNotifierScriptAvailable()) {
    echo "   ✓ Notifier script found at: $scriptPath\n";
} else {
    echo "   ✗ Notifier script not found\n";
}

// Test command building
echo "\n4. Testing command building:\n";
try {
    $command = $service->buildNodeCommand('Test Title', 'Test Message', []);
    echo "   ✓ Command built successfully\n";
    echo "   Command: $command\n";
} catch (Exception $e) {
    echo "   ✗ Command building failed: " . $e->getMessage() . "\n";
}

echo "\nTest completed!\n"; 