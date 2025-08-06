@echo off
echo 🗑️  Laravel Node Notifier Desktop - Uninstall Script (Windows)
echo ==================================================
echo.

REM Check if we're in a Laravel project
if not exist "artisan" (
    echo ❌ Error: Script ini harus dijalankan di root directory project Laravel
    echo    Pastikan file 'artisan' ada di direktori saat ini.
    pause
    exit /b 1
)

echo 📋 Langkah-langkah uninstall:
echo.

REM 1. Remove via Composer
echo 1. 🎯 Menghapus package via Composer...
composer remove laravel-nodenotifierdesktop/laravel-nodenotifierdesktop
if %errorlevel% equ 0 (
    echo    ✅ Package berhasil dihapus dari composer.json
) else (
    echo    ⚠️  Package tidak ditemukan atau sudah dihapus
)

REM 2. Remove config file
echo.
echo 2. ⚙️  Menghapus file konfigurasi...
if exist "config\laravel-nodenotifierdesktop.php" (
    del "config\laravel-nodenotifierdesktop.php"
    echo    ✅ File konfigurasi berhasil dihapus
) else (
    echo    ℹ️  File konfigurasi tidak ditemukan (sudah dihapus atau belum dipublish)
)

REM 3. Remove vendor directory
echo.
echo 3. 📁 Menghapus folder vendor package...
if exist "vendor\laravel-nodenotifierdesktop" (
    rmdir /s /q "vendor\laravel-nodenotifierdesktop"
    echo    ✅ Folder vendor package berhasil dihapus
) else (
    echo    ℹ️  Folder vendor package tidak ditemukan
)

REM 4. Clear caches
echo.
echo 4. 🧹 Membersihkan cache...
php artisan config:clear
php artisan cache:clear
composer dump-autoload
echo    ✅ Cache berhasil dibersihkan

REM 5. Search for usage in code
echo.
echo 5. 🔍 Mencari penggunaan package dalam kode...
findstr /s /i "DesktopNotifier::" app\*.* resources\*.* routes\*.* >nul 2>&1
if %errorlevel% equ 0 (
    echo    ⚠️  Ditemukan penggunaan 'DesktopNotifier::' dalam kode
    echo    Silakan hapus kode tersebut secara manual
) else (
    echo    ✅ Tidak ditemukan penggunaan package dalam kode
)

findstr /s /i "LaravelNodeNotifierDesktop" app\*.* resources\*.* routes\*.* >nul 2>&1
if %errorlevel% equ 0 (
    echo    ⚠️  Ditemukan penggunaan 'LaravelNodeNotifierDesktop' dalam kode
    echo    Silakan hapus kode tersebut secara manual
) else (
    echo    ✅ Tidak ditemukan penggunaan package dalam kode
)

echo.
echo 🎉 Uninstall selesai!
echo.
echo 📝 Langkah selanjutnya:
echo    1. Periksa kembali kode Anda untuk memastikan tidak ada referensi ke package
echo    2. Test aplikasi Anda untuk memastikan tidak ada error
echo    3. Commit perubahan ke version control Anda
echo.
echo ✅ Package Laravel Node Notifier Desktop berhasil diuninstall!
echo.
pause 