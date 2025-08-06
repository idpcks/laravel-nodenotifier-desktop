<?php

namespace LaravelNodeNotifierDesktop\Examples;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use LaravelNodeNotifierDesktop\Facades\DesktopNotifier;

class CustomizationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $title;
    protected string $message;
    protected array $options;

    /**
     * Create a new job instance.
     */
    public function __construct(string $title, string $message, array $options = [])
    {
        $this->title = $title;
        $this->message = $message;
        $this->options = $options;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Send notification with customization options
        DesktopNotifier::notify($this->title, $this->message, $this->options);
    }

    /**
     * Contoh job untuk notifikasi chat dengan tema modern
     */
    public static function chatNotification(string $sender, string $message): self
    {
        return new self(
            "New Message from $sender",
            $message,
            [
                'ui_theme' => 'modern',
                'position' => 'top-right',
                'animation' => 'slide',
                'timeout' => 3000,
                'size' => 'medium'
            ]
        );
    }

    /**
     * Contoh job untuk notifikasi sistem dengan tema gelap
     */
    public static function systemNotification(string $title, string $message): self
    {
        return new self(
            $title,
            $message,
            [
                'ui_theme' => 'dark',
                'position' => 'bottom-right',
                'animation' => 'fade',
                'size' => 'small',
                'timeout' => 2000
            ]
        );
    }

    /**
     * Contoh job untuk notifikasi email dengan tema terang
     */
    public static function emailNotification(string $from, string $subject): self
    {
        return new self(
            "New Email from $from",
            $subject,
            [
                'ui_theme' => 'light',
                'position' => 'top-center',
                'animation' => 'bounce',
                'timeout' => 4000,
                'custom_sound_file' => storage_path('sounds/email.wav')
            ]
        );
    }

    /**
     * Contoh job untuk notifikasi error dengan tema gelap
     */
    public static function errorNotification(string $title, string $message): self
    {
        return new self(
            $title,
            $message,
            [
                'ui_theme' => 'dark',
                'position' => 'top-center',
                'animation' => 'bounce',
                'size' => 'large',
                'timeout' => 5000
            ]
        );
    }

    /**
     * Contoh job untuk notifikasi success dengan tema modern
     */
    public static function successNotification(string $title, string $message): self
    {
        return new self(
            $title,
            $message,
            [
                'ui_theme' => 'modern',
                'position' => 'top-right',
                'animation' => 'slide',
                'timeout' => 3000
            ]
        );
    }

    /**
     * Contoh job untuk notifikasi warning dengan tema terang
     */
    public static function warningNotification(string $title, string $message): self
    {
        return new self(
            $title,
            $message,
            [
                'ui_theme' => 'light',
                'position' => 'bottom-center',
                'size' => 'large',
                'animation' => 'fade',
                'timeout' => 4000
            ]
        );
    }

    /**
     * Contoh job untuk notifikasi info dengan tema minimal
     */
    public static function infoNotification(string $title, string $message): self
    {
        return new self(
            $title,
            $message,
            [
                'ui_theme' => 'minimal',
                'position' => 'top-left',
                'animation' => 'fade',
                'timeout' => 4000
            ]
        );
    }

    /**
     * Contoh job untuk notifikasi batch dengan berbagai tema
     */
    public static function batchNotifications(array $notifications): array
    {
        $jobs = [];
        
        foreach ($notifications as $index => $notification) {
            $themes = ['modern', 'dark', 'light', 'minimal', 'default'];
            $positions = ['top-right', 'top-left', 'bottom-right', 'bottom-left', 'top-center'];
            $animations = ['slide', 'fade', 'bounce', 'zoom', 'none'];
            
            $theme = $themes[$index % count($themes)];
            $position = $positions[$index % count($positions)];
            $animation = $animations[$index % count($animations)];
            
            $jobs[] = new self(
                $notification['title'],
                $notification['message'],
                [
                    'ui_theme' => $theme,
                    'position' => $position,
                    'animation' => $animation,
                    'timeout' => 3000 + ($index * 500) // Staggered timeout
                ]
            );
        }
        
        return $jobs;
    }

    /**
     * Contoh job untuk notifikasi dengan posisi kustom
     */
    public static function customPositionNotification(string $title, string $message, int $x, int $y): self
    {
        return new self(
            $title,
            $message,
            [
                'custom_position' => ['x' => $x, 'y' => $y],
                'ui_theme' => 'modern',
                'animation' => 'fade',
                'timeout' => 3000
            ]
        );
    }

    /**
     * Contoh job untuk notifikasi dengan animasi kustom
     */
    public static function customAnimationNotification(string $title, string $message, string $animation, int $duration = 300): self
    {
        return new self(
            $title,
            $message,
            [
                'animation' => $animation,
                'animation_duration' => $duration,
                'ui_theme' => 'default',
                'position' => 'bottom-right',
                'timeout' => 3000
            ]
        );
    }

    /**
     * Contoh job untuk notifikasi dengan ukuran kustom
     */
    public static function customSizeNotification(string $title, string $message, string $size): self
    {
        return new self(
            $title,
            $message,
            [
                'size' => $size,
                'ui_theme' => 'default',
                'position' => 'bottom-right',
                'animation' => 'slide',
                'timeout' => 3000
            ]
        );
    }

    /**
     * Contoh job untuk notifikasi dengan suara kustom
     */
    public static function customSoundNotification(string $title, string $message, string $soundFile): self
    {
        return new self(
            $title,
            $message,
            [
                'custom_sound_file' => $soundFile,
                'ui_theme' => 'default',
                'position' => 'bottom-right',
                'animation' => 'slide',
                'timeout' => 3000
            ]
        );
    }

    /**
     * Contoh job untuk notifikasi silent
     */
    public static function silentNotification(string $title, string $message): self
    {
        return new self(
            $title,
            $message,
            [
                'sound' => false,
                'ui_theme' => 'minimal',
                'position' => 'bottom-right',
                'animation' => 'fade',
                'timeout' => 3000
            ]
        );
    }

    /**
     * Contoh job untuk notifikasi dengan kombinasi fitur lengkap
     */
    public static function fullCustomizationNotification(
        string $title, 
        string $message, 
        string $theme = 'modern',
        string $position = 'top-right',
        string $animation = 'bounce',
        int $duration = 500,
        string $size = 'medium',
        ?string $soundFile = null,
        int $timeout = 5000
    ): self {
        $options = [
            'ui_theme' => $theme,
            'position' => $position,
            'animation' => $animation,
            'animation_duration' => $duration,
            'size' => $size,
            'timeout' => $timeout
        ];

        if ($soundFile) {
            $options['custom_sound_file'] = $soundFile;
        }

        return new self($title, $message, $options);
    }
} 