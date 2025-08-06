<?php

/**
 * Laravel Node Notifier Desktop - Uninstall Script
 * 
 * Jalankan script ini untuk menghapus package dari project Laravel Anda
 * 
 * Usage: php uninstall.php
 */

echo "🗑️  Laravel Node Notifier Desktop - Uninstall Script\n";
echo "==================================================\n\n";

// Check if we're in a Laravel project
if (!file_exists('artisan')) {
    echo "❌ Error: Script ini harus dijalankan di root directory project Laravel\n";
    echo "   Pastikan file 'artisan' ada di direktori saat ini.\n";
    exit(1);
}

echo "📋 Langkah-langkah uninstall:\n\n";

// 1. Remove via Composer
echo "1. 🎯 Menghapus package via Composer...\n";
$composerRemove = shell_exec('composer remove laravel-nodenotifierdesktop/laravel-nodenotifierdesktop 2>&1');
if (strpos($composerRemove, 'Removing') !== false) {
    echo "   ✅ Package berhasil dihapus dari composer.json\n";
} else {
    echo "   ⚠️  Package tidak ditemukan atau sudah dihapus\n";
}

// 2. Remove config file
echo "\n2. ⚙️  Menghapus file konfigurasi...\n";
$configFile = 'config/laravel-nodenotifierdesktop.php';
if (file_exists($configFile)) {
    if (unlink($configFile)) {
        echo "   ✅ File konfigurasi berhasil dihapus\n";
    } else {
        echo "   ❌ Gagal menghapus file konfigurasi\n";
    }
} else {
    echo "   ℹ️  File konfigurasi tidak ditemukan (sudah dihapus atau belum dipublish)\n";
}

// 3. Remove vendor directory
echo "\n3. 📁 Menghapus folder vendor package...\n";
$vendorDir = 'vendor/laravel-nodenotifierdesktop';
if (is_dir($vendorDir)) {
    if (deleteDirectory($vendorDir)) {
        echo "   ✅ Folder vendor package berhasil dihapus\n";
    } else {
        echo "   ❌ Gagal menghapus folder vendor package\n";
    }
} else {
    echo "   ℹ️  Folder vendor package tidak ditemukan\n";
}

// 4. Check for manual service provider registration
echo "\n4. 🔍 Memeriksa registrasi service provider manual...\n";
$appConfigFile = 'config/app.php';
if (file_exists($appConfigFile)) {
    $appConfig = file_get_contents($appConfigFile);
    
    $providersToRemove = [
        'LaravelNodeNotifierDesktop\\LaravelNodeNotifierDesktopServiceProvider::class,',
        'LaravelNodeNotifierDesktop\LaravelNodeNotifierDesktopServiceProvider::class,'
    ];
    
    $aliasesToRemove = [
        "'DesktopNotifier' => LaravelNodeNotifierDesktop\\Facades\\DesktopNotifier::class,",
        "'DesktopNotifier' => LaravelNodeNotifierDesktop\Facades\DesktopNotifier::class,"
    ];
    
    $modified = false;
    
    foreach ($providersToRemove as $provider) {
        if (strpos($appConfig, $provider) !== false) {
            $appConfig = str_replace($provider, '', $appConfig);
            $modified = true;
            echo "   ⚠️  Service provider ditemukan dan dihapus dari config/app.php\n";
        }
    }
    
    foreach ($aliasesToRemove as $alias) {
        if (strpos($appConfig, $alias) !== false) {
            $appConfig = str_replace($alias, '', $appConfig);
            $modified = true;
            echo "   ⚠️  Facade alias ditemukan dan dihapus dari config/app.php\n";
        }
    }
    
    if ($modified) {
        if (file_put_contents($appConfigFile, $appConfig)) {
            echo "   ✅ config/app.php berhasil diperbarui\n";
        } else {
            echo "   ❌ Gagal memperbarui config/app.php\n";
        }
    } else {
        echo "   ℹ️  Tidak ada registrasi manual yang ditemukan\n";
    }
} else {
    echo "   ℹ️  File config/app.php tidak ditemukan\n";
}

// 5. Clear caches
echo "\n5. 🧹 Membersihkan cache...\n";
$commands = [
    'php artisan config:clear',
    'php artisan cache:clear',
    'composer dump-autoload'
];

foreach ($commands as $command) {
    $output = shell_exec($command . ' 2>&1');
    if (strpos($output, 'error') === false && strpos($output, 'Error') === false) {
        echo "   ✅ " . basename($command) . " berhasil dijalankan\n";
    } else {
        echo "   ⚠️  " . basename($command) . " gagal atau ada warning\n";
    }
}

// 6. Search for usage in code
echo "\n6. 🔍 Mencari penggunaan package dalam kode...\n";
$searchTerms = [
    'DesktopNotifier::',
    'LaravelNodeNotifierDesktop',
    'desktop-notifier:',
    'DesktopNotifierService'
];

$foundUsage = false;
foreach ($searchTerms as $term) {
    $grepCommand = "grep -r \"$term\" app/ resources/ routes/ --exclude-dir=vendor --exclude-dir=node_modules 2>/dev/null";
    $grepOutput = shell_exec($grepCommand);
    
    if (!empty(trim($grepOutput))) {
        echo "   ⚠️  Ditemukan penggunaan '$term' dalam kode:\n";
        $lines = explode("\n", trim($grepOutput));
        foreach (array_slice($lines, 0, 5) as $line) { // Show first 5 matches
            if (!empty(trim($line))) {
                echo "      " . trim($line) . "\n";
            }
        }
        if (count($lines) > 5) {
            echo "      ... dan " . (count($lines) - 5) . " file lainnya\n";
        }
        $foundUsage = true;
    }
}

if (!$foundUsage) {
    echo "   ✅ Tidak ditemukan penggunaan package dalam kode\n";
}

echo "\n🎉 Uninstall selesai!\n\n";

if ($foundUsage) {
    echo "⚠️  PERHATIAN:\n";
    echo "   Ditemukan penggunaan package dalam kode Anda.\n";
    echo "   Silakan hapus atau ganti kode tersebut secara manual.\n";
    echo "   Contoh kode yang perlu dihapus:\n";
    echo "   - DesktopNotifier::success('Title', 'Message');\n";
    echo "   - use LaravelNodeNotifierDesktop\Facades\DesktopNotifier;\n";
    echo "   - use LaravelNodeNotifierDesktop\Services\DesktopNotifierService;\n\n";
}

echo "📝 Langkah selanjutnya:\n";
echo "   1. Periksa kembali kode Anda untuk memastikan tidak ada referensi ke package\n";
echo "   2. Test aplikasi Anda untuk memastikan tidak ada error\n";
echo "   3. Commit perubahan ke version control Anda\n\n";

echo "✅ Package Laravel Node Notifier Desktop berhasil diuninstall!\n";

/**
 * Recursively delete a directory
 */
function deleteDirectory($dir) {
    if (!is_dir($dir)) {
        return false;
    }
    
    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        if (is_dir($path)) {
            deleteDirectory($path);
        } else {
            unlink($path);
        }
    }
    
    return rmdir($dir);
} 