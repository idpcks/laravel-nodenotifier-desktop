# Customization Guide

Panduan lengkap untuk menggunakan fitur kustomisasi notifikasi desktop di Laravel Node Notifier Desktop.

## Daftar Isi

1. [Posisi Kustom](#posisi-kustom)
2. [Tema UI](#tema-ui)
3. [Animasi](#animasi)
4. [Ukuran](#ukuran)
5. [Suara Kustom](#suara-kustom)
6. [Kombinasi Fitur](#kombinasi-fitur)
7. [Konfigurasi](#konfigurasi)
8. [Contoh Penggunaan](#contoh-penggunaan)

## Posisi Kustom

### Posisi Preset

Anda dapat menggunakan posisi preset yang sudah ditentukan:

```php
// Posisi yang tersedia
DesktopNotifier::notifyAtPosition('Title', 'Message', 'top-right');
DesktopNotifier::notifyAtPosition('Title', 'Message', 'top-left');
DesktopNotifier::notifyAtPosition('Title', 'Message', 'bottom-right'); // default
DesktopNotifier::notifyAtPosition('Title', 'Message', 'bottom-left');
DesktopNotifier::notifyAtPosition('Title', 'Message', 'top-center');
DesktopNotifier::notifyAtPosition('Title', 'Message', 'bottom-center');
```

### Posisi Kustom dengan Koordinat

Untuk posisi yang lebih spesifik, gunakan koordinat X,Y:

```php
// Posisi kustom dengan koordinat
DesktopNotifier::notifyAtCoordinates('Title', 'Message', 100, 100); // x=100, y=100
DesktopNotifier::notifyAtCoordinates('Title', 'Message', 800, 400); // tengah layar
DesktopNotifier::notifyAtCoordinates('Title', 'Message', 0, 0);     // pojok kiri atas
```

### Posisi dalam Array Options

```php
DesktopNotifier::notify('Title', 'Message', [
    'position' => 'top-right',
    // atau
    'custom_position' => ['x' => 200, 'y' => 200]
]);
```

## Tema UI

### Tema yang Tersedia

```php
// Tema default
DesktopNotifier::notifyWithTheme('Title', 'Message', 'default');

// Tema modern dengan shadow
DesktopNotifier::notifyWithTheme('Title', 'Message', 'modern');

// Tema gelap
DesktopNotifier::notifyWithTheme('Title', 'Message', 'dark');

// Tema terang
DesktopNotifier::notifyWithTheme('Title', 'Message', 'light');

// Tema minimalis
DesktopNotifier::notifyWithTheme('Title', 'Message', 'minimal');
```

### Karakteristik Tema

| Tema | Background | Text Color | Border | Shadow |
|------|------------|------------|--------|--------|
| `default` | #ffffff | #333333 | #e0e0e0 | 0 4px 12px rgba(0,0,0,0.15) |
| `modern` | #f8f9fa | #212529 | #dee2e6 | 0 8px 25px rgba(0,0,0,0.1) |
| `dark` | #2d3748 | #ffffff | #4a5568 | 0 4px 12px rgba(0,0,0,0.3) |
| `light` | #ffffff | #2d3748 | #e2e8f0 | 0 2px 8px rgba(0,0,0,0.1) |
| `minimal` | #ffffff | #000000 | #000000 | none |

### Tema dalam Array Options

```php
DesktopNotifier::notify('Title', 'Message', [
    'ui_theme' => 'dark'
]);
```

## Animasi

### Jenis Animasi

```php
// Animasi slide (default)
DesktopNotifier::notifyWithAnimation('Title', 'Message', 'slide');

// Animasi fade
DesktopNotifier::notifyWithAnimation('Title', 'Message', 'fade');

// Animasi bounce
DesktopNotifier::notifyWithAnimation('Title', 'Message', 'bounce');

// Animasi zoom
DesktopNotifier::notifyWithAnimation('Title', 'Message', 'zoom');

// Tanpa animasi
DesktopNotifier::notifyWithAnimation('Title', 'Message', 'none');
```

### Durasi Animasi Kustom

```php
// Animasi dengan durasi kustom (dalam milidetik)
DesktopNotifier::notifyWithAnimation('Title', 'Message', 'slide', 500);  // 500ms
DesktopNotifier::notifyWithAnimation('Title', 'Message', 'fade', 1000); // 1 detik
DesktopNotifier::notifyWithAnimation('Title', 'Message', 'bounce', 800); // 800ms
```

### Animasi dalam Array Options

```php
DesktopNotifier::notify('Title', 'Message', [
    'animation' => 'bounce',
    'animation_duration' => 500
]);
```

## Ukuran

### Ukuran yang Tersedia

```php
// Ukuran kecil (280x80px)
DesktopNotifier::notifyWithSize('Title', 'Message', 'small');

// Ukuran sedang (350x100px) - default
DesktopNotifier::notifyWithSize('Title', 'Message', 'medium');

// Ukuran besar (420x120px)
DesktopNotifier::notifyWithSize('Title', 'Message', 'large');
```

### Spesifikasi Ukuran

| Ukuran | Width | Height | Font Size | Padding |
|--------|-------|--------|-----------|---------|
| `small` | 280px | 80px | 12px | 8px |
| `medium` | 350px | 100px | 14px | 12px |
| `large` | 420px | 120px | 16px | 16px |

### Ukuran dalam Array Options

```php
DesktopNotifier::notify('Title', 'Message', [
    'size' => 'large'
]);
```

## Suara Kustom

### Suara Default

```php
// Suara default sistem
DesktopNotifier::notify('Title', 'Message');
```

### Suara Kustom

```php
// Suara kustom dari file
DesktopNotifier::notifyWithSound('Title', 'Message', '/path/to/sound.wav');
DesktopNotifier::notifyWithSound('Title', 'Message', '/path/to/sound.mp3');
DesktopNotifier::notifyWithSound('Title', 'Message', '/path/to/sound.ogg');
```

### Tanpa Suara

```php
// Notifikasi tanpa suara
DesktopNotifier::notifySilent('Title', 'Message');
```

### Format Suara yang Didukung

- `.wav` - Waveform Audio File Format
- `.mp3` - MPEG Audio Layer III
- `.ogg` - Ogg Vorbis

### Suara dalam Array Options

```php
DesktopNotifier::notify('Title', 'Message', [
    'custom_sound_file' => '/path/to/sound.mp3',
    // atau
    'sound' => false // untuk tanpa suara
]);
```

## Kombinasi Fitur

### Menggunakan Method Khusus

```php
// Kombinasi tema dan posisi
DesktopNotifier::notifyWithTheme('Title', 'Message', 'dark', [
    'position' => 'top-right',
    'animation' => 'bounce'
]);

// Kombinasi animasi dan ukuran
DesktopNotifier::notifyWithAnimation('Title', 'Message', 'fade', 500, [
    'size' => 'large',
    'ui_theme' => 'modern'
]);
```

### Menggunakan Array Options Lengkap

```php
DesktopNotifier::notify('Title', 'Message', [
    // Posisi
    'position' => 'top-right',
    // atau 'custom_position' => ['x' => 200, 'y' => 200],
    
    // Tema
    'ui_theme' => 'dark',
    
    // Animasi
    'animation' => 'bounce',
    'animation_duration' => 500,
    
    // Ukuran
    'size' => 'large',
    
    // Suara
    'custom_sound_file' => '/path/to/sound.mp3',
    // atau 'sound' => false,
    
    // Opsi lainnya
    'timeout' => 5000,
    'icon' => '/path/to/icon.png'
]);
```

## Konfigurasi

### Pengaturan Default

Atur pengaturan default di file `config/laravel-nodenotifierdesktop.php`:

```php
return [
    // Posisi default
    'position' => 'bottom-right',
    'custom_position' => null,
    
    // Tema default
    'ui_theme' => 'default',
    
    // Animasi default
    'animation' => 'slide',
    'animation_duration' => 300,
    
    // Ukuran default
    'size' => 'medium',
    
    // Suara default
    'custom_sound_file' => null,
    'default_sound' => true,
    
    // Opsi lainnya
    'timeout' => 5000,
    'default_icon' => null,
];
```

### Override Pengaturan

Pengaturan dalam method akan mengoverride pengaturan default:

```php
// Menggunakan pengaturan default
DesktopNotifier::notify('Title', 'Message');

// Override beberapa pengaturan
DesktopNotifier::notify('Title', 'Message', [
    'position' => 'top-right',  // Override posisi default
    'ui_theme' => 'dark'        // Override tema default
]);
```

## Contoh Penggunaan

### Notifikasi Chat

```php
DesktopNotifier::notify('New Message', 'You have a new message from John Doe', [
    'ui_theme' => 'modern',
    'position' => 'top-right',
    'animation' => 'slide',
    'timeout' => 3000,
    'size' => 'medium'
]);
```

### Notifikasi Sistem

```php
DesktopNotifier::notify('System Update', 'System is updating...', [
    'ui_theme' => 'dark',
    'position' => 'bottom-right',
    'animation' => 'fade',
    'size' => 'small',
    'timeout' => 2000
]);
```

### Notifikasi Email

```php
DesktopNotifier::notify('New Email', 'Email from noreply@example.com', [
    'ui_theme' => 'light',
    'position' => 'top-center',
    'animation' => 'bounce',
    'timeout' => 4000,
    'custom_sound_file' => storage_path('sounds/email.wav')
]);
```

### Notifikasi Error

```php
DesktopNotifier::error('Error!', 'Terjadi kesalahan dalam sistem', [
    'ui_theme' => 'dark',
    'position' => 'top-center',
    'animation' => 'bounce',
    'size' => 'large',
    'timeout' => 5000
]);
```

### Notifikasi Success

```php
DesktopNotifier::success('Success!', 'Operasi berhasil diselesaikan', [
    'ui_theme' => 'modern',
    'position' => 'top-right',
    'animation' => 'slide',
    'timeout' => 3000
]);
```

### Notifikasi Warning

```php
DesktopNotifier::warning('Warning!', 'Perhatian: Ada masalah yang perlu diperhatikan', [
    'ui_theme' => 'light',
    'position' => 'bottom-center',
    'size' => 'large',
    'animation' => 'fade'
]);
```

### Notifikasi Info

```php
DesktopNotifier::info('Info', 'Informasi penting untuk Anda', [
    'ui_theme' => 'minimal',
    'position' => 'top-left',
    'animation' => 'fade',
    'timeout' => 4000
]);
```

## Tips dan Best Practices

### 1. Pilih Posisi yang Tepat

- **`top-right`** - Untuk notifikasi penting yang perlu segera diperhatikan
- **`bottom-right`** - Untuk notifikasi informasi umum (default)
- **`top-center`** - Untuk notifikasi sistem yang penting
- **`bottom-center`** - Untuk notifikasi yang tidak terlalu urgent

### 2. Gunakan Tema yang Sesuai

- **`modern`** - Untuk aplikasi modern dan profesional
- **`dark`** - Untuk mode gelap atau notifikasi error
- **`light`** - Untuk mode terang atau notifikasi info
- **`minimal`** - Untuk notifikasi yang tidak mengganggu

### 3. Pilih Animasi yang Tepat

- **`slide`** - Untuk notifikasi umum (default)
- **`fade`** - Untuk notifikasi yang halus
- **`bounce`** - Untuk notifikasi penting atau error
- **`zoom`** - Untuk notifikasi yang menarik perhatian
- **`none`** - Untuk notifikasi yang tidak mengganggu

### 4. Atur Timeout yang Sesuai

- **1000-2000ms** - Untuk notifikasi singkat
- **3000-5000ms** - Untuk notifikasi umum (default)
- **5000-10000ms** - Untuk notifikasi penting

### 5. Gunakan Ukuran yang Tepat

- **`small`** - Untuk notifikasi yang tidak penting
- **`medium`** - Untuk notifikasi umum (default)
- **`large`** - Untuk notifikasi penting atau error

### 6. Kombinasikan Fitur dengan Bijak

```php
// Contoh kombinasi yang baik
DesktopNotifier::notify('Important Update', 'System will restart in 5 minutes', [
    'ui_theme' => 'dark',           // Tema gelap untuk peringatan
    'position' => 'top-center',     // Posisi tengah untuk perhatian
    'animation' => 'bounce',        // Animasi bounce untuk penting
    'size' => 'large',              // Ukuran besar untuk visibility
    'timeout' => 8000,              // Timeout lama untuk dibaca
    'custom_sound_file' => storage_path('sounds/warning.wav') // Suara peringatan
]);
```

## Troubleshooting

### Masalah Umum

1. **Notifikasi tidak muncul di posisi yang diinginkan**
   - Pastikan koordinat tidak melebihi resolusi layar
   - Gunakan posisi preset untuk hasil yang lebih konsisten

2. **Suara kustom tidak berfungsi**
   - Pastikan file suara ada dan dapat diakses
   - Periksa format file (.wav, .mp3, .ogg)
   - Pastikan path file benar

3. **Animasi tidak berfungsi**
   - Pastikan nilai `animation` valid
   - Periksa `animation_duration` (harus > 0)

4. **Tema tidak berubah**
   - Pastikan nilai `ui_theme` valid
   - Periksa apakah ada konflik dengan pengaturan lain

### Debug Mode

Aktifkan debug mode untuk troubleshooting:

```php
// Di config/laravel-nodenotifierdesktop.php
'debug_mode' => true,
```

Kemudian cek log di `storage/logs/laravel.log` untuk informasi detail.

## Referensi

- [README.md](README.md) - Dokumentasi utama
- [examples/CustomizationExamples.php](examples/CustomizationExamples.php) - Contoh lengkap
- [examples/CustomizationController.php](examples/CustomizationController.php) - Contoh controller
- [config/laravel-nodenotifierdesktop.php](config/laravel-nodenotifierdesktop.php) - File konfigurasi 