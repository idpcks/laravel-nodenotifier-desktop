<?php

namespace LaravelNodeNotifierDesktop\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool notify(string $title, string $message, array $options = [])
 * @method static bool success(string $title, string $message, array $options = [])
 * @method static bool error(string $title, string $message, array $options = [])
 * @method static bool warning(string $title, string $message, array $options = [])
 * @method static bool info(string $title, string $message, array $options = [])
 * @method static bool isNodeAvailable()
 * @method static bool isNotifierScriptAvailable()
 *
 * @see \LaravelNodeNotifierDesktop\Services\DesktopNotifierService
 */
class DesktopNotifier extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'desktop-notifier';
    }
} 