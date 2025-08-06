<?php

namespace LaravelNodeNotifierDesktop\Examples;

use LaravelNodeNotifierDesktop\Services\DesktopNotifierService;

class CustomizationExamples
{
    protected DesktopNotifierService $notifier;

    public function __construct()
    {
        $this->notifier = new DesktopNotifierService();
    }

    /**
     * Contoh penggunaan posisi kustom
     */
    public function positionExamples()
    {
        // Posisi default (pojok kanan bawah)
        $this->notifier->notify('Default Position', 'Ini adalah notifikasi dengan posisi default');

        // Posisi kustom menggunakan preset
        $this->notifier->notifyAtPosition('Top Right', 'Notifikasi di pojok kanan atas', 'top-right');
        $this->notifier->notifyAtPosition('Top Left', 'Notifikasi di pojok kiri atas', 'top-left');
        $this->notifier->notifyAtPosition('Bottom Left', 'Notifikasi di pojok kiri bawah', 'bottom-left');
        $this->notifier->notifyAtPosition('Top Center', 'Notifikasi di tengah atas', 'top-center');
        $this->notifier->notifyAtPosition('Bottom Center', 'Notifikasi di tengah bawah', 'bottom-center');

        // Posisi kustom menggunakan koordinat
        $this->notifier->notifyAtCoordinates('Custom Position', 'Notifikasi di posisi kustom', 100, 100);
        $this->notifier->notifyAtCoordinates('Center Screen', 'Notifikasi di tengah layar', 800, 400);
    }

    /**
     * Contoh penggunaan tema UI
     */
    public function themeExamples()
    {
        // Tema default
        $this->notifier->notifyWithTheme('Default Theme', 'Notifikasi dengan tema default', 'default');

        // Tema modern
        $this->notifier->notifyWithTheme('Modern Theme', 'Notifikasi dengan tema modern', 'modern');

        // Tema minimal
        $this->notifier->notifyWithTheme('Minimal Theme', 'Notifikasi dengan tema minimal', 'minimal');

        // Tema gelap
        $this->notifier->notifyWithTheme('Dark Theme', 'Notifikasi dengan tema gelap', 'dark');

        // Tema terang
        $this->notifier->notifyWithTheme('Light Theme', 'Notifikasi dengan tema terang', 'light');
    }

    /**
     * Contoh penggunaan animasi
     */
    public function animationExamples()
    {
        // Animasi slide (default)
        $this->notifier->notifyWithAnimation('Slide Animation', 'Notifikasi dengan animasi slide', 'slide');

        // Animasi fade
        $this->notifier->notifyWithAnimation('Fade Animation', 'Notifikasi dengan animasi fade', 'fade');

        // Animasi bounce
        $this->notifier->notifyWithAnimation('Bounce Animation', 'Notifikasi dengan animasi bounce', 'bounce');

        // Animasi zoom
        $this->notifier->notifyWithAnimation('Zoom Animation', 'Notifikasi dengan animasi zoom', 'zoom');

        // Tanpa animasi
        $this->notifier->notifyWithAnimation('No Animation', 'Notifikasi tanpa animasi', 'none');

        // Animasi dengan durasi kustom
        $this->notifier->notifyWithAnimation('Slow Animation', 'Notifikasi dengan animasi lambat', 'slide', 800);
        $this->notifier->notifyWithAnimation('Fast Animation', 'Notifikasi dengan animasi cepat', 'fade', 150);
    }

    /**
     * Contoh penggunaan ukuran
     */
    public function sizeExamples()
    {
        // Ukuran kecil
        $this->notifier->notifyWithSize('Small Size', 'Notifikasi dengan ukuran kecil', 'small');

        // Ukuran sedang (default)
        $this->notifier->notifyWithSize('Medium Size', 'Notifikasi dengan ukuran sedang', 'medium');

        // Ukuran besar
        $this->notifier->notifyWithSize('Large Size', 'Notifikasi dengan ukuran besar', 'large');
    }

    /**
     * Contoh penggunaan suara kustom
     */
    public function soundExamples()
    {
        // Suara default
        $this->notifier->notify('Default Sound', 'Notifikasi dengan suara default');

        // Suara kustom (jika file ada)
        $customSoundPath = storage_path('sounds/notification.wav');
        if (file_exists($customSoundPath)) {
            $this->notifier->notifyWithSound('Custom Sound', 'Notifikasi dengan suara kustom', $customSoundPath);
        }

        // Tanpa suara
        $this->notifier->notifySilent('Silent Notification', 'Notifikasi tanpa suara');
    }

    /**
     * Contoh kombinasi fitur kustomisasi
     */
    public function combinationExamples()
    {
        // Kombinasi tema gelap + animasi bounce + posisi kustom
        $this->notifier->notify('Combined Features', 'Notifikasi dengan kombinasi fitur', [
            'ui_theme' => 'dark',
            'animation' => 'bounce',
            'animation_duration' => 500,
            'position' => 'top-right',
            'size' => 'large'
        ]);

        // Kombinasi tema modern + animasi fade + koordinat kustom
        $this->notifier->notify('Modern Custom', 'Notifikasi modern dengan posisi kustom', [
            'ui_theme' => 'modern',
            'animation' => 'fade',
            'custom_position' => ['x' => 200, 'y' => 200],
            'size' => 'medium'
        ]);

        // Kombinasi tema minimal + tanpa animasi + suara kustom
        $customSoundPath = storage_path('sounds/chime.mp3');
        $this->notifier->notify('Minimal Silent', 'Notifikasi minimal tanpa animasi', [
            'ui_theme' => 'minimal',
            'animation' => 'none',
            'custom_sound_file' => file_exists($customSoundPath) ? $customSoundPath : null,
            'position' => 'bottom-left'
        ]);
    }

    /**
     * Contoh penggunaan untuk berbagai jenis notifikasi
     */
    public function notificationTypeExamples()
    {
        // Success notification dengan tema modern
        $this->notifier->success('Success!', 'Operasi berhasil diselesaikan', [
            'ui_theme' => 'modern',
            'position' => 'top-right',
            'animation' => 'slide'
        ]);

        // Error notification dengan tema gelap
        $this->notifier->error('Error!', 'Terjadi kesalahan dalam sistem', [
            'ui_theme' => 'dark',
            'position' => 'top-center',
            'animation' => 'bounce'
        ]);

        // Warning notification dengan tema terang
        $this->notifier->warning('Warning!', 'Perhatian: Ada masalah yang perlu diperhatikan', [
            'ui_theme' => 'light',
            'position' => 'bottom-center',
            'size' => 'large'
        ]);

        // Info notification dengan tema minimal
        $this->notifier->info('Info', 'Informasi penting untuk Anda', [
            'ui_theme' => 'minimal',
            'position' => 'top-left',
            'animation' => 'fade'
        ]);
    }

    /**
     * Contoh penggunaan untuk aplikasi real-time
     */
    public function realTimeExamples()
    {
        // Notifikasi chat dengan tema modern
        $this->notifier->notify('New Message', 'Anda memiliki pesan baru dari John Doe', [
            'ui_theme' => 'modern',
            'position' => 'top-right',
            'animation' => 'slide',
            'timeout' => 3000
        ]);

        // Notifikasi sistem dengan tema gelap
        $this->notifier->notify('System Update', 'Sistem sedang diperbarui...', [
            'ui_theme' => 'dark',
            'position' => 'bottom-right',
            'animation' => 'fade',
            'size' => 'small'
        ]);

        // Notifikasi email dengan tema terang
        $this->notifier->notify('New Email', 'Email baru dari noreply@example.com', [
            'ui_theme' => 'light',
            'position' => 'top-center',
            'animation' => 'bounce',
            'timeout' => 4000
        ]);
    }
} 