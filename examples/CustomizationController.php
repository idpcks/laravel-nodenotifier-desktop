<?php

namespace LaravelNodeNotifierDesktop\Examples;

use Illuminate\Http\Request;
use LaravelNodeNotifierDesktop\Facades\DesktopNotifier;

class CustomizationController
{
    /**
     * Contoh penggunaan posisi kustom
     */
    public function positionExamples()
    {
        // Posisi default (pojok kanan bawah)
        DesktopNotifier::notify('Default Position', 'Ini adalah notifikasi dengan posisi default');

        // Posisi kustom menggunakan preset
        DesktopNotifier::notifyAtPosition('Top Right', 'Notifikasi di pojok kanan atas', 'top-right');
        DesktopNotifier::notifyAtPosition('Top Left', 'Notifikasi di pojok kiri atas', 'top-left');
        DesktopNotifier::notifyAtPosition('Bottom Left', 'Notifikasi di pojok kiri bawah', 'bottom-left');
        DesktopNotifier::notifyAtPosition('Top Center', 'Notifikasi di tengah atas', 'top-center');
        DesktopNotifier::notifyAtPosition('Bottom Center', 'Notifikasi di tengah bawah', 'bottom-center');

        // Posisi kustom menggunakan koordinat
        DesktopNotifier::notifyAtCoordinates('Custom Position', 'Notifikasi di posisi kustom', 100, 100);
        DesktopNotifier::notifyAtCoordinates('Center Screen', 'Notifikasi di tengah layar', 800, 400);

        return response()->json(['message' => 'Position examples sent']);
    }

    /**
     * Contoh penggunaan tema UI
     */
    public function themeExamples()
    {
        // Tema default
        DesktopNotifier::notifyWithTheme('Default Theme', 'Notifikasi dengan tema default', 'default');

        // Tema modern
        DesktopNotifier::notifyWithTheme('Modern Theme', 'Notifikasi dengan tema modern', 'modern');

        // Tema minimal
        DesktopNotifier::notifyWithTheme('Minimal Theme', 'Notifikasi dengan tema minimal', 'minimal');

        // Tema gelap
        DesktopNotifier::notifyWithTheme('Dark Theme', 'Notifikasi dengan tema gelap', 'dark');

        // Tema terang
        DesktopNotifier::notifyWithTheme('Light Theme', 'Notifikasi dengan tema terang', 'light');

        return response()->json(['message' => 'Theme examples sent']);
    }

    /**
     * Contoh penggunaan animasi
     */
    public function animationExamples()
    {
        // Animasi slide (default)
        DesktopNotifier::notifyWithAnimation('Slide Animation', 'Notifikasi dengan animasi slide', 'slide');

        // Animasi fade
        DesktopNotifier::notifyWithAnimation('Fade Animation', 'Notifikasi dengan animasi fade', 'fade');

        // Animasi bounce
        DesktopNotifier::notifyWithAnimation('Bounce Animation', 'Notifikasi dengan animasi bounce', 'bounce');

        // Animasi zoom
        DesktopNotifier::notifyWithAnimation('Zoom Animation', 'Notifikasi dengan animasi zoom', 'zoom');

        // Tanpa animasi
        DesktopNotifier::notifyWithAnimation('No Animation', 'Notifikasi tanpa animasi', 'none');

        // Animasi dengan durasi kustom
        DesktopNotifier::notifyWithAnimation('Slow Animation', 'Notifikasi dengan animasi lambat', 'slide', 800);
        DesktopNotifier::notifyWithAnimation('Fast Animation', 'Notifikasi dengan animasi cepat', 'fade', 150);

        return response()->json(['message' => 'Animation examples sent']);
    }

    /**
     * Contoh penggunaan ukuran
     */
    public function sizeExamples()
    {
        // Ukuran kecil
        DesktopNotifier::notifyWithSize('Small Size', 'Notifikasi dengan ukuran kecil', 'small');

        // Ukuran sedang (default)
        DesktopNotifier::notifyWithSize('Medium Size', 'Notifikasi dengan ukuran sedang', 'medium');

        // Ukuran besar
        DesktopNotifier::notifyWithSize('Large Size', 'Notifikasi dengan ukuran besar', 'large');

        return response()->json(['message' => 'Size examples sent']);
    }

    /**
     * Contoh penggunaan suara kustom
     */
    public function soundExamples()
    {
        // Suara default
        DesktopNotifier::notify('Default Sound', 'Notifikasi dengan suara default');

        // Suara kustom (jika file ada)
        $customSoundPath = storage_path('sounds/notification.wav');
        if (file_exists($customSoundPath)) {
            DesktopNotifier::notifyWithSound('Custom Sound', 'Notifikasi dengan suara kustom', $customSoundPath);
        }

        // Tanpa suara
        DesktopNotifier::notifySilent('Silent Notification', 'Notifikasi tanpa suara');

        return response()->json(['message' => 'Sound examples sent']);
    }

    /**
     * Contoh kombinasi fitur kustomisasi
     */
    public function combinationExamples()
    {
        // Kombinasi tema gelap + animasi bounce + posisi kustom
        DesktopNotifier::notify('Combined Features', 'Notifikasi dengan kombinasi fitur', [
            'ui_theme' => 'dark',
            'animation' => 'bounce',
            'animation_duration' => 500,
            'position' => 'top-right',
            'size' => 'large'
        ]);

        // Kombinasi tema modern + animasi fade + koordinat kustom
        DesktopNotifier::notify('Modern Custom', 'Notifikasi modern dengan posisi kustom', [
            'ui_theme' => 'modern',
            'animation' => 'fade',
            'custom_position' => ['x' => 200, 'y' => 200],
            'size' => 'medium'
        ]);

        // Kombinasi tema minimal + tanpa animasi + suara kustom
        $customSoundPath = storage_path('sounds/chime.mp3');
        DesktopNotifier::notify('Minimal Silent', 'Notifikasi minimal tanpa animasi', [
            'ui_theme' => 'minimal',
            'animation' => 'none',
            'custom_sound_file' => file_exists($customSoundPath) ? $customSoundPath : null,
            'position' => 'bottom-left'
        ]);

        return response()->json(['message' => 'Combination examples sent']);
    }

    /**
     * Contoh penggunaan untuk berbagai jenis notifikasi
     */
    public function notificationTypeExamples()
    {
        // Success notification dengan tema modern
        DesktopNotifier::success('Success!', 'Operasi berhasil diselesaikan', [
            'ui_theme' => 'modern',
            'position' => 'top-right',
            'animation' => 'slide'
        ]);

        // Error notification dengan tema gelap
        DesktopNotifier::error('Error!', 'Terjadi kesalahan dalam sistem', [
            'ui_theme' => 'dark',
            'position' => 'top-center',
            'animation' => 'bounce'
        ]);

        // Warning notification dengan tema terang
        DesktopNotifier::warning('Warning!', 'Perhatian: Ada masalah yang perlu diperhatikan', [
            'ui_theme' => 'light',
            'position' => 'bottom-center',
            'size' => 'large'
        ]);

        // Info notification dengan tema minimal
        DesktopNotifier::info('Info', 'Informasi penting untuk Anda', [
            'ui_theme' => 'minimal',
            'position' => 'top-left',
            'animation' => 'fade'
        ]);

        return response()->json(['message' => 'Notification type examples sent']);
    }

    /**
     * Contoh penggunaan untuk aplikasi real-time
     */
    public function realTimeExamples()
    {
        // Notifikasi chat dengan tema modern
        DesktopNotifier::notify('New Message', 'Anda memiliki pesan baru dari John Doe', [
            'ui_theme' => 'modern',
            'position' => 'top-right',
            'animation' => 'slide',
            'timeout' => 3000
        ]);

        // Notifikasi sistem dengan tema gelap
        DesktopNotifier::notify('System Update', 'Sistem sedang diperbarui...', [
            'ui_theme' => 'dark',
            'position' => 'bottom-right',
            'animation' => 'fade',
            'size' => 'small'
        ]);

        // Notifikasi email dengan tema terang
        DesktopNotifier::notify('New Email', 'Email baru dari noreply@example.com', [
            'ui_theme' => 'light',
            'position' => 'top-center',
            'animation' => 'bounce',
            'timeout' => 4000
        ]);

        return response()->json(['message' => 'Real-time examples sent']);
    }

    /**
     * Contoh penggunaan berdasarkan request dari user
     */
    public function customNotification(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'message' => 'required|string|max:500',
            'position' => 'nullable|string|in:top-right,top-left,bottom-right,bottom-left,top-center,bottom-center',
            'theme' => 'nullable|string|in:default,modern,minimal,dark,light',
            'animation' => 'nullable|string|in:slide,fade,bounce,zoom,none',
            'size' => 'nullable|string|in:small,medium,large',
            'sound' => 'nullable|boolean',
            'timeout' => 'nullable|integer|min:1000|max:10000'
        ]);

        $options = [];

        // Set position
        if ($request->has('position')) {
            $options['position'] = $request->position;
        }

        // Set theme
        if ($request->has('theme')) {
            $options['ui_theme'] = $request->theme;
        }

        // Set animation
        if ($request->has('animation')) {
            $options['animation'] = $request->animation;
        }

        // Set size
        if ($request->has('size')) {
            $options['size'] = $request->size;
        }

        // Set sound
        if ($request->has('sound')) {
            $options['sound'] = $request->sound;
        }

        // Set timeout
        if ($request->has('timeout')) {
            $options['timeout'] = $request->timeout;
        }

        // Send notification
        $success = DesktopNotifier::notify($request->title, $request->message, $options);

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Notification sent successfully' : 'Failed to send notification',
            'options' => $options
        ]);
    }

    /**
     * Contoh penggunaan untuk notifikasi batch
     */
    public function batchNotifications()
    {
        $notifications = [
            [
                'title' => 'Task 1 Complete',
                'message' => 'Background task 1 has been completed',
                'options' => ['ui_theme' => 'modern', 'position' => 'top-right']
            ],
            [
                'title' => 'Task 2 Complete', 
                'message' => 'Background task 2 has been completed',
                'options' => ['ui_theme' => 'dark', 'position' => 'top-left']
            ],
            [
                'title' => 'Task 3 Complete',
                'message' => 'Background task 3 has been completed', 
                'options' => ['ui_theme' => 'light', 'position' => 'bottom-right']
            ]
        ];

        $results = [];
        foreach ($notifications as $notification) {
            $success = DesktopNotifier::notify(
                $notification['title'],
                $notification['message'],
                $notification['options']
            );
            
            $results[] = [
                'title' => $notification['title'],
                'success' => $success
            ];

            // Delay between notifications
            sleep(1);
        }

        return response()->json([
            'message' => 'Batch notifications sent',
            'results' => $results
        ]);
    }
} 