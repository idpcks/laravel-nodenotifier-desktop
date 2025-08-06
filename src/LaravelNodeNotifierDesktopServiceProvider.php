<?php

namespace LaravelNodeNotifierDesktop;

use Illuminate\Support\ServiceProvider;
use LaravelNodeNotifierDesktop\Services\DesktopNotifierService;
use LaravelNodeNotifierDesktop\Console\Commands\InstallNodeNotifierCommand;
use LaravelNodeNotifierDesktop\Console\Commands\DebugNodeNotifierCommand;

class LaravelNodeNotifierDesktopServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-nodenotifierdesktop.php', 'laravel-nodenotifierdesktop'
        );

        $this->app->singleton(DesktopNotifierService::class, function ($app) {
            return new DesktopNotifierService();
        });

        $this->app->alias(DesktopNotifierService::class, 'desktop-notifier');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/laravel-nodenotifierdesktop.php' => config_path('laravel-nodenotifierdesktop.php'),
            ], 'laravel-nodenotifierdesktop-config');

            $this->commands([
                InstallNodeNotifierCommand::class,
                DebugNodeNotifierCommand::class,
            ]);
        }
    }
} 