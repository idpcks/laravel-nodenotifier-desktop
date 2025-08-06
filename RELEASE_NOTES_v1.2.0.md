# Release Notes - Version 1.2.0

## 🎉 Customization Release

**Tanggal Release:** 06 August 2025  
**Versi:** 1.2.0  
**Tipe:** Major Release (New Features)

## ✨ Fitur Baru

### 🎯 Custom Positioning
- **Posisi Preset**: 6 posisi preset (top-right, top-left, bottom-right, bottom-left, top-center, bottom-center)
- **Koordinat Kustom**: Set posisi dengan koordinat X,Y yang tepat
- **Default**: Posisi default di pojok kanan bawah (bottom-right)
- **Method Baru**: `notifyAtPosition()` dan `notifyAtCoordinates()`

### 🎨 Multiple UI Themes
- **5 Tema Visual**: default, modern, minimal, dark, light
- **Karakteristik Unik**: Setiap tema memiliki warna, border, dan shadow yang berbeda
- **Method Baru**: `notifyWithTheme()`
- **Konfigurasi**: Set tema default di config file

### ✨ Custom Animations
- **5 Jenis Animasi**: slide, fade, bounce, zoom, none
- **Durasi Kustom**: Atur durasi animasi dalam milidetik
- **Method Baru**: `notifyWithAnimation()`
- **Default**: Animasi slide dengan durasi 300ms

### 📏 Adjustable Sizes
- **3 Ukuran**: small (280x80px), medium (350x100px), large (420x120px)
- **Font & Padding**: Setiap ukuran memiliki font size dan padding yang sesuai
- **Method Baru**: `notifyWithSize()`
- **Default**: Ukuran medium

### 🔊 Custom Sound Files
- **Format Didukung**: .wav, .mp3, .ogg
- **Fallback**: Otomatis ke suara sistem jika file kustom tidak ada
- **Method Baru**: `notifyWithSound()` dan `notifySilent()`
- **Konfigurasi**: Set file suara default di config

### 🎛️ Flexible Customization
- **Kombinasi Fitur**: Gabungkan berbagai fitur kustomisasi
- **Array Options**: Gunakan array options untuk kustomisasi lengkap
- **Method Chaining**: Kombinasikan method untuk hasil yang diinginkan
- **Override Default**: Override pengaturan default dengan mudah

## 🔧 Method Baru

### Positioning Methods
```php
// Posisi preset
DesktopNotifier::notifyAtPosition('Title', 'Message', 'top-right');

// Koordinat kustom
DesktopNotifier::notifyAtCoordinates('Title', 'Message', 100, 200);
```

### Theme Methods
```php
// Tema kustom
DesktopNotifier::notifyWithTheme('Title', 'Message', 'dark');
```

### Animation Methods
```php
// Animasi kustom
DesktopNotifier::notifyWithAnimation('Title', 'Message', 'bounce', 500);
```

### Size Methods
```php
// Ukuran kustom
DesktopNotifier::notifyWithSize('Title', 'Message', 'large');
```

### Sound Methods
```php
// Suara kustom
DesktopNotifier::notifyWithSound('Title', 'Message', '/path/to/sound.wav');

// Tanpa suara
DesktopNotifier::notifySilent('Title', 'Message');
```

## ⚙️ Konfigurasi Baru

### File: `config/laravel-nodenotifierdesktop.php`

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
    
    // Suara kustom default
    'custom_sound_file' => null,
];
```

## 📚 Dokumentasi Baru

### File Dokumentasi
- **`CUSTOMIZATION.md`** - Panduan lengkap fitur kustomisasi
- **`examples/CustomizationExamples.php`** - Contoh penggunaan lengkap
- **`examples/CustomizationController.php`** - Contoh controller
- **`tests/Feature/CustomizationTest.php`** - Test cases untuk fitur kustomisasi

### Update Dokumentasi
- **`README.md`** - Ditambahkan section Customization Features
- **`CHANGELOG.md`** - Update changelog dengan versi 1.2.0

## 🧪 Testing

### Test Coverage
- **50+ Test Cases** untuk fitur kustomisasi
- **Edge Cases** - Handling nilai invalid dan fallback
- **Integration Tests** - Test kombinasi fitur
- **Method Tests** - Test semua method baru

### Test Categories
- Custom positioning (preset & coordinates)
- UI themes (all 5 themes)
- Animations (all 5 types + duration)
- Sizes (all 3 sizes)
- Custom sounds (file & silent)
- Combination features
- Error handling & fallbacks

## 🚀 Contoh Penggunaan

### Basic Customization
```php
// Notifikasi dengan tema gelap di pojok kanan atas
DesktopNotifier::notify('Title', 'Message', [
    'ui_theme' => 'dark',
    'position' => 'top-right',
    'animation' => 'bounce'
]);
```

### Advanced Customization
```php
// Notifikasi dengan semua fitur kustomisasi
DesktopNotifier::notify('Important Update', 'System will restart in 5 minutes', [
    'ui_theme' => 'dark',
    'position' => 'top-center',
    'animation' => 'bounce',
    'animation_duration' => 500,
    'size' => 'large',
    'custom_sound_file' => storage_path('sounds/warning.wav'),
    'timeout' => 8000
]);
```

### Method Chaining
```php
// Kombinasi method untuk hasil yang diinginkan
$notifier = new DesktopNotifierService();
$notifier->notifyWithTheme('Title', 'Message', 'modern', [
    'position' => 'bottom-left',
    'animation' => 'fade'
]);
```

## 🔄 Migration dari v1.0.4

### Tidak Ada Breaking Changes
- Semua fitur lama tetap berfungsi
- Pengaturan default tidak berubah
- Method lama tetap kompatibel

### Upgrade Steps
1. **Update Package**:
   ```bash
   composer update laravel-nodenotifierdesktop/laravel-nodenotifierdesktop
   ```

2. **Publish Config** (optional):
   ```bash
   php artisan vendor:publish --tag=laravel-nodenotifierdesktop-config
   ```

3. **Test Fitur Baru**:
   ```php
   DesktopNotifier::notifyWithTheme('Test', 'Testing new features', 'modern');
   ```

## 🎯 Use Cases

### Chat Applications
```php
DesktopNotifier::notify('New Message', 'You have a new message from John', [
    'ui_theme' => 'modern',
    'position' => 'top-right',
    'animation' => 'slide',
    'timeout' => 3000
]);
```

### System Notifications
```php
DesktopNotifier::notify('System Update', 'System is updating...', [
    'ui_theme' => 'dark',
    'position' => 'bottom-right',
    'animation' => 'fade',
    'size' => 'small'
]);
```

### Email Notifications
```php
DesktopNotifier::notify('New Email', 'Email from noreply@example.com', [
    'ui_theme' => 'light',
    'position' => 'top-center',
    'animation' => 'bounce',
    'custom_sound_file' => storage_path('sounds/email.wav')
]);
```

### Error Notifications
```php
DesktopNotifier::error('Error!', 'Terjadi kesalahan dalam sistem', [
    'ui_theme' => 'dark',
    'position' => 'top-center',
    'animation' => 'bounce',
    'size' => 'large'
]);
```

## 🐛 Bug Fixes

### v1.0.4 Issues
- ✅ Semua bug fixes dari v1.0.4 tetap dipertahankan
- ✅ Windows command execution issues tetap teratasi
- ✅ Node.js path detection tetap berfungsi

## 📈 Performance

### Optimizations
- **Efficient Position Calculation** - Perhitungan posisi yang efisien
- **Theme Caching** - Tema disimpan dalam memory untuk akses cepat
- **Animation Optimization** - Animasi yang smooth dan tidak membebani sistem
- **Sound File Validation** - Validasi file suara yang cepat

### Memory Usage
- **Minimal Impact** - Fitur kustomisasi tidak menambah beban memory yang signifikan
- **Lazy Loading** - Tema dan animasi hanya dimuat saat diperlukan

## 🔮 Future Plans

### Planned Features (v1.3.0)
- **Custom CSS Support** - Inject custom CSS untuk styling lebih lanjut
- **Notification Queuing** - Queue system untuk multiple notifications
- **Interactive Notifications** - Click actions dan buttons
- **Notification History** - Log dan history notifikasi
- **Advanced Positioning** - Screen detection dan multi-monitor support

### Community Requests
- **More Themes** - Additional UI themes
- **Custom Icons** - Dynamic icon support
- **Notification Groups** - Group related notifications
- **Priority System** - Notification priority levels

## 📞 Support

### Documentation
- **`CUSTOMIZATION.md`** - Panduan lengkap kustomisasi
- **`README.md`** - Dokumentasi utama
- **`examples/`** - Contoh penggunaan

### Issues & Feedback
- **GitHub Issues** - Report bugs dan request features
- **Documentation** - Update dan improvement suggestions
- **Examples** - Share use cases dan examples

## 🎊 Credits

### Contributors
- **idpcks** - Lead developer dan maintainer
- **Community** - Feedback dan testing

### Technologies
- **Laravel** - PHP framework
- **Node.js** - Desktop notifications
- **node-notifier** - Cross-platform notification library

---

**🎉 Selamat menggunakan fitur kustomisasi yang baru!**

Untuk informasi lebih lanjut, lihat:
- [CUSTOMIZATION.md](CUSTOMIZATION.md) - Panduan lengkap
- [examples/CustomizationExamples.php](examples/CustomizationExamples.php) - Contoh penggunaan
- [README.md](README.md) - Dokumentasi utama 