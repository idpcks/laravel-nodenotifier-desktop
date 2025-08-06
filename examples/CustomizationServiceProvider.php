<?php

namespace LaravelNodeNotifierDesktop\Examples;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use LaravelNodeNotifierDesktop\Facades\DesktopNotifier;

class CustomizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register customization services
        $this->registerCustomizationServices();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register event listeners
        $this->registerEventListeners();

        // Register custom commands
        $this->registerCommands();

        // Register custom macros
        $this->registerMacros();

        // Register custom notifications
        $this->registerCustomNotifications();
    }

    /**
     * Register customization services
     */
    protected function registerCustomizationServices(): void
    {
        // Register notification theme service
        $this->app->singleton('notification.theme', function ($app) {
            return new NotificationThemeService();
        });

        // Register notification position service
        $this->app->singleton('notification.position', function ($app) {
            return new NotificationPositionService();
        });

        // Register notification animation service
        $this->app->singleton('notification.animation', function ($app) {
            return new NotificationAnimationService();
        });

        // Register notification sound service
        $this->app->singleton('notification.sound', function ($app) {
            return new NotificationSoundService();
        });
    }

    /**
     * Register event listeners
     */
    protected function registerEventListeners(): void
    {
        // Listen for application events
        Event::listen('Illuminate\Foundation\Events\ApplicationStarted', function ($event) {
            DesktopNotifier::notify('Application Started', 'Laravel application has started', [
                'ui_theme' => 'modern',
                'position' => 'top-right',
                'animation' => 'slide',
                'timeout' => 3000
            ]);
        });

        // Listen for maintenance mode events
        Event::listen('Illuminate\Foundation\Events\MaintenanceModeEnabled', function ($event) {
            DesktopNotifier::warning('Maintenance Mode Enabled', 'Application is now in maintenance mode', [
                'ui_theme' => 'light',
                'position' => 'top-center',
                'animation' => 'bounce',
                'size' => 'large',
                'timeout' => 5000
            ]);
        });

        Event::listen('Illuminate\Foundation\Events\MaintenanceModeDisabled', function ($event) {
            DesktopNotifier::success('Maintenance Mode Disabled', 'Application is now available', [
                'ui_theme' => 'modern',
                'position' => 'top-right',
                'animation' => 'slide',
                'timeout' => 3000
            ]);
        });

        // Listen for database events
        Event::listen('Illuminate\Database\Events\QueryExecuted', function ($event) {
            if ($event->time > 1000) { // Slow query
                DesktopNotifier::warning('Slow Query Detected', "Query took {$event->time}ms", [
                    'ui_theme' => 'light',
                    'position' => 'bottom-right',
                    'animation' => 'fade',
                    'size' => 'medium',
                    'timeout' => 3000
                ]);
            }
        });

        // Listen for cache events
        Event::listen('Illuminate\Cache\Events\CacheMissed', function ($event) {
            DesktopNotifier::info('Cache Miss', "Cache miss for key: {$event->key}", [
                'ui_theme' => 'minimal',
                'position' => 'bottom-left',
                'animation' => 'fade',
                'size' => 'small',
                'timeout' => 2000
            ]);
        });

        // Listen for queue events
        Event::listen('Illuminate\Queue\Events\JobFailed', function ($event) {
            $jobName = class_basename($event->job->resolveName());
            DesktopNotifier::error('Job Failed', "Job {$jobName} failed: {$event->exception->getMessage()}", [
                'ui_theme' => 'dark',
                'position' => 'top-center',
                'animation' => 'bounce',
                'size' => 'large',
                'timeout' => 5000
            ]);
        });
    }

    /**
     * Register custom commands
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \LaravelNodeNotifierDesktop\Examples\CustomizationCommand::class,
                \LaravelNodeNotifierDesktop\Examples\TestCustomizationCommand::class,
                \LaravelNodeNotifierDesktop\Examples\BenchmarkCustomizationCommand::class,
            ]);
        }
    }

    /**
     * Register custom macros
     */
    protected function registerMacros(): void
    {
        // Macro for chat notifications
        DesktopNotifier::macro('chat', function ($sender, $message) {
            return DesktopNotifier::notify("New Message from {$sender}", $message, [
                'ui_theme' => 'modern',
                'position' => 'top-right',
                'animation' => 'slide',
                'timeout' => 3000
            ]);
        });

        // Macro for system notifications
        DesktopNotifier::macro('system', function ($title, $message) {
            return DesktopNotifier::notify($title, $message, [
                'ui_theme' => 'dark',
                'position' => 'bottom-right',
                'animation' => 'fade',
                'size' => 'small',
                'timeout' => 2000
            ]);
        });

        // Macro for email notifications
        DesktopNotifier::macro('email', function ($from, $subject) {
            return DesktopNotifier::notify("New Email from {$from}", $subject, [
                'ui_theme' => 'light',
                'position' => 'top-center',
                'animation' => 'bounce',
                'timeout' => 4000
            ]);
        });

        // Macro for urgent notifications
        DesktopNotifier::macro('urgent', function ($title, $message) {
            return DesktopNotifier::notify($title, $message, [
                'ui_theme' => 'dark',
                'position' => 'top-center',
                'animation' => 'bounce',
                'size' => 'large',
                'timeout' => 8000
            ]);
        });

        // Macro for silent notifications
        DesktopNotifier::macro('silent', function ($title, $message) {
            return DesktopNotifier::notify($title, $message, [
                'sound' => false,
                'ui_theme' => 'minimal',
                'position' => 'bottom-left',
                'animation' => 'fade',
                'size' => 'small',
                'timeout' => 2000
            ]);
        });
    }

    /**
     * Register custom notifications
     */
    protected function registerCustomNotifications(): void
    {
        // Register notification presets
        $this->app->singleton('notifications.presets', function ($app) {
            return [
                'chat' => [
                    'ui_theme' => 'modern',
                    'position' => 'top-right',
                    'animation' => 'slide',
                    'timeout' => 3000
                ],
                'system' => [
                    'ui_theme' => 'dark',
                    'position' => 'bottom-right',
                    'animation' => 'fade',
                    'size' => 'small',
                    'timeout' => 2000
                ],
                'email' => [
                    'ui_theme' => 'light',
                    'position' => 'top-center',
                    'animation' => 'bounce',
                    'timeout' => 4000
                ],
                'urgent' => [
                    'ui_theme' => 'dark',
                    'position' => 'top-center',
                    'animation' => 'bounce',
                    'size' => 'large',
                    'timeout' => 8000
                ],
                'silent' => [
                    'sound' => false,
                    'ui_theme' => 'minimal',
                    'position' => 'bottom-left',
                    'animation' => 'fade',
                    'size' => 'small',
                    'timeout' => 2000
                ]
            ];
        });
    }
}

/**
 * Notification Theme Service
 */
class NotificationThemeService
{
    protected array $themes = [
        'default' => [
            'backgroundColor' => '#ffffff',
            'textColor' => '#333333',
            'borderColor' => '#e0e0e0',
            'shadow' => '0 4px 12px rgba(0,0,0,0.15)'
        ],
        'modern' => [
            'backgroundColor' => '#f8f9fa',
            'textColor' => '#212529',
            'borderColor' => '#dee2e6',
            'shadow' => '0 8px 25px rgba(0,0,0,0.1)'
        ],
        'minimal' => [
            'backgroundColor' => '#ffffff',
            'textColor' => '#000000',
            'borderColor' => '#000000',
            'shadow' => 'none'
        ],
        'dark' => [
            'backgroundColor' => '#2d3748',
            'textColor' => '#ffffff',
            'borderColor' => '#4a5568',
            'shadow' => '0 4px 12px rgba(0,0,0,0.3)'
        ],
        'light' => [
            'backgroundColor' => '#ffffff',
            'textColor' => '#2d3748',
            'borderColor' => '#e2e8f0',
            'shadow' => '0 2px 8px rgba(0,0,0,0.1)'
        ]
    ];

    public function getTheme(string $theme): array
    {
        return $this->themes[$theme] ?? $this->themes['default'];
    }

    public function getAllThemes(): array
    {
        return $this->themes;
    }

    public function addTheme(string $name, array $config): void
    {
        $this->themes[$name] = $config;
    }
}

/**
 * Notification Position Service
 */
class NotificationPositionService
{
    protected array $positions = [
        'top-right' => ['x' => 1570, 'y' => 20],
        'top-left' => ['x' => 20, 'y' => 20],
        'bottom-right' => ['x' => 1570, 'y' => 960],
        'bottom-left' => ['x' => 20, 'y' => 960],
        'top-center' => ['x' => 795, 'y' => 20],
        'bottom-center' => ['x' => 795, 'y' => 960]
    ];

    public function getPosition(string $position): array
    {
        return $this->positions[$position] ?? $this->positions['bottom-right'];
    }

    public function getAllPositions(): array
    {
        return $this->positions;
    }

    public function addPosition(string $name, array $coordinates): void
    {
        $this->positions[$name] = $coordinates;
    }

    public function calculateCustomPosition(int $x, int $y): array
    {
        return ['x' => $x, 'y' => $y];
    }
}

/**
 * Notification Animation Service
 */
class NotificationAnimationService
{
    protected array $animations = [
        'slide' => ['type' => 'slide', 'duration' => 300],
        'fade' => ['type' => 'fade', 'duration' => 300],
        'bounce' => ['type' => 'bounce', 'duration' => 400],
        'zoom' => ['type' => 'zoom', 'duration' => 300],
        'none' => ['type' => 'none', 'duration' => 0]
    ];

    public function getAnimation(string $animation): array
    {
        return $this->animations[$animation] ?? $this->animations['slide'];
    }

    public function getAllAnimations(): array
    {
        return $this->animations;
    }

    public function addAnimation(string $name, array $config): void
    {
        $this->animations[$name] = $config;
    }

    public function getDuration(string $animation): int
    {
        $config = $this->getAnimation($animation);
        return $config['duration'];
    }
}

/**
 * Notification Sound Service
 */
class NotificationSoundService
{
    protected array $sounds = [
        'default' => null,
        'notification' => 'notification.wav',
        'email' => 'email.wav',
        'chat' => 'chat.wav',
        'warning' => 'warning.wav',
        'error' => 'error.wav'
    ];

    public function getSound(string $sound): ?string
    {
        if (!isset($this->sounds[$sound])) {
            return null;
        }

        if ($this->sounds[$sound] === null) {
            return null; // Use system default
        }

        $path = storage_path('sounds/' . $this->sounds[$sound]);
        return file_exists($path) ? $path : null;
    }

    public function getAllSounds(): array
    {
        return $this->sounds;
    }

    public function addSound(string $name, string $filename): void
    {
        $this->sounds[$name] = $filename;
    }

    public function validateSound(string $path): bool
    {
        if (empty($path)) {
            return true; // Allow null/empty for system default
        }

        $allowedExtensions = ['wav', 'mp3', 'ogg'];
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        
        return in_array(strtolower($extension), $allowedExtensions) && file_exists($path);
    }
} 