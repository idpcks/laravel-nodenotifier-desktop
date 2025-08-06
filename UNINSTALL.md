# Cara Uninstall Laravel Node Notifier Desktop

Dokumen ini menjelaskan cara menghapus package Laravel Node Notifier Desktop dari project Laravel Anda.

## Metode Uninstall

### 1. Menggunakan Script Otomatis (Direkomendasikan)

Package ini menyediakan script uninstall otomatis yang akan menghapus semua komponen package:

**Untuk Linux/macOS:**
```bash
php uninstall.php
```

**Untuk Windows:**
```cmd
uninstall.bat
```

Script ini akan:
- ✅ Menghapus package dari `composer.json`
- ✅ Menghapus file konfigurasi
- ✅ Menghapus folder vendor package
- ✅ Memeriksa dan menghapus registrasi manual
- ✅ Membersihkan cache
- ✅ Mencari penggunaan package dalam kode
- ✅ Memberikan panduan langkah selanjutnya

### 2. Uninstall Manual

Jika Anda lebih suka menghapus package secara manual:

#### Langkah 1: Hapus via Composer

```bash
composer remove laravel-nodenotifierdesktop/laravel-nodenotifierdesktop
```

#### Langkah 2: Hapus File Konfigurasi

```bash
# Jika Anda sudah menjalankan vendor:publish
rm config/laravel-nodenotifierdesktop.php
```

#### Langkah 3: Hapus Folder Vendor

```bash
# Hapus folder vendor package
rm -rf vendor/laravel-nodenotifierdesktop
```

#### Langkah 4: Periksa Registrasi Manual

Jika Anda menambahkan service provider secara manual di `config/app.php`, hapus baris berikut:

**Dari array `providers`:**
```php
// Hapus baris ini:
LaravelNodeNotifierDesktop\LaravelNodeNotifierDesktopServiceProvider::class,
```

**Dari array `aliases`:**
```php
// Hapus baris ini:
'DesktopNotifier' => LaravelNodeNotifierDesktop\Facades\DesktopNotifier::class,
```

#### Langkah 5: Hapus Kode yang Menggunakan Package

Cari dan hapus semua kode yang menggunakan package ini:

```bash
# Cari penggunaan package dalam kode
grep -r "DesktopNotifier::" app/ resources/ routes/
grep -r "LaravelNodeNotifierDesktop" app/ resources/ routes/
```

**Contoh kode yang perlu dihapus:**

```php
// Hapus import statements
use LaravelNodeNotifierDesktop\Facades\DesktopNotifier;
use LaravelNodeNotifierDesktop\Services\DesktopNotifierService;

// Hapus penggunaan facade
DesktopNotifier::success('Title', 'Message');
DesktopNotifier::error('Title', 'Message');
DesktopNotifier::notify('Title', 'Message');

// Hapus dependency injection
public function someMethod(DesktopNotifierService $notifier)
{
    $notifier->success('Title', 'Message');
}
```

#### Langkah 6: Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
composer dump-autoload
```

## Verifikasi Uninstall

Setelah uninstall, pastikan:

1. **Package tidak ada di composer.json:**
   ```bash
   composer show laravel-nodenotifierdesktop
   # Seharusnya: Package laravel-nodenotifierdesktop not found
   ```

2. **Tidak ada error saat menjalankan aplikasi:**
   ```bash
   php artisan serve
   # Aplikasi harus berjalan tanpa error
   ```

3. **Tidak ada referensi ke package dalam kode:**
   ```bash
   grep -r "DesktopNotifier" app/ resources/ routes/
   # Seharusnya tidak ada hasil
   ```

## Troubleshooting Uninstall

### Error: "Package not found"

Jika Anda mendapat error "Package not found" saat menjalankan `composer remove`:

```bash
# Package sudah dihapus atau tidak terinstall
# Langsung hapus file dan folder yang tersisa
rm -rf vendor/laravel-nodenotifierdesktop
rm -f config/laravel-nodenotifierdesktop.php
```

### Error: "Cannot delete directory"

Jika tidak bisa menghapus folder vendor:

```bash
# Di Windows, gunakan:
rmdir /s /q vendor\laravel-nodenotifierdesktop

# Di Linux/macOS, gunakan:
sudo rm -rf vendor/laravel-nodenotifierdesktop
```

**Atau gunakan script uninstall yang sesuai:**
- Windows: `uninstall.bat`
- Linux/macOS: `php uninstall.php`

### Error setelah uninstall

Jika aplikasi error setelah uninstall:

1. **Periksa file yang masih menggunakan package:**
   ```bash
   grep -r "DesktopNotifier" app/ resources/ routes/
   ```

2. **Hapus atau ganti kode yang menggunakan package**

3. **Clear cache lagi:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   composer dump-autoload
   ```

## Reinstall Package

Jika Anda ingin menginstall ulang package:

```bash
# Install package
composer require laravel-nodenotifierdesktop/laravel-nodenotifierdesktop

# Publish config (opsional)
php artisan vendor:publish --tag=laravel-nodenotifierdesktop-config

# Install dependencies
php artisan desktop-notifier:install
```

## Support

Jika Anda mengalami masalah saat uninstall, silakan:

1. Jalankan script uninstall otomatis:
   - Linux/macOS: `php uninstall.php`
   - Windows: `uninstall.bat`
2. Periksa output untuk informasi detail
3. Ikuti panduan yang diberikan oleh script
4. Jika masih ada masalah, buat issue di GitHub repository

## Catatan Penting

- **Backup project** sebelum melakukan uninstall
- **Test aplikasi** setelah uninstall untuk memastikan tidak ada error
- **Commit perubahan** ke version control setelah uninstall berhasil
- **Dokumentasikan** jika ada kode custom yang perlu diganti 