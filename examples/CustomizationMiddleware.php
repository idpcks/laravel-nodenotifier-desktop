<?php

namespace LaravelNodeNotifierDesktop\Examples;

use Closure;
use Illuminate\Http\Request;
use LaravelNodeNotifierDesktop\Facades\DesktopNotifier;

class CustomizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Send notification before processing request
        $this->sendRequestNotification($request);

        $response = $next($request);

        // Send notification after processing request
        $this->sendResponseNotification($request, $response);

        return $response;
    }

    /**
     * Send notification when request starts
     */
    protected function sendRequestNotification(Request $request): void
    {
        $title = 'Request Started';
        $message = "Processing {$request->method()} request to {$request->path()}";

        DesktopNotifier::notify($title, $message, [
            'ui_theme' => 'light',
            'position' => 'top-left',
            'animation' => 'slide',
            'size' => 'small',
            'timeout' => 2000
        ]);
    }

    /**
     * Send notification when request completes
     */
    protected function sendResponseNotification(Request $request, $response): void
    {
        $statusCode = $response->getStatusCode();
        $title = 'Request Completed';
        $message = "{$request->method()} {$request->path()} - Status: {$statusCode}";

        // Choose theme based on status code
        $theme = $this->getThemeByStatusCode($statusCode);
        $position = $this->getPositionByStatusCode($statusCode);
        $animation = $this->getAnimationByStatusCode($statusCode);
        $size = $this->getSizeByStatusCode($statusCode);

        DesktopNotifier::notify($title, $message, [
            'ui_theme' => $theme,
            'position' => $position,
            'animation' => $animation,
            'size' => $size,
            'timeout' => 3000
        ]);
    }

    /**
     * Get theme based on HTTP status code
     */
    protected function getThemeByStatusCode(int $statusCode): string
    {
        if ($statusCode >= 500) {
            return 'dark'; // Error themes for server errors
        } elseif ($statusCode >= 400) {
            return 'dark'; // Error themes for client errors
        } elseif ($statusCode >= 300) {
            return 'light'; // Info themes for redirects
        } else {
            return 'modern'; // Success themes for 2xx responses
        }
    }

    /**
     * Get position based on HTTP status code
     */
    protected function getPositionByStatusCode(int $statusCode): string
    {
        if ($statusCode >= 500) {
            return 'top-center'; // Center for critical errors
        } elseif ($statusCode >= 400) {
            return 'top-right'; // Top right for client errors
        } elseif ($statusCode >= 300) {
            return 'bottom-right'; // Bottom right for redirects
        } else {
            return 'bottom-left'; // Bottom left for success
        }
    }

    /**
     * Get animation based on HTTP status code
     */
    protected function getAnimationByStatusCode(int $statusCode): string
    {
        if ($statusCode >= 500) {
            return 'bounce'; // Bounce for critical errors
        } elseif ($statusCode >= 400) {
            return 'bounce'; // Bounce for client errors
        } elseif ($statusCode >= 300) {
            return 'fade'; // Fade for redirects
        } else {
            return 'slide'; // Slide for success
        }
    }

    /**
     * Get size based on HTTP status code
     */
    protected function getSizeByStatusCode(int $statusCode): string
    {
        if ($statusCode >= 500) {
            return 'large'; // Large for critical errors
        } elseif ($statusCode >= 400) {
            return 'medium'; // Medium for client errors
        } else {
            return 'small'; // Small for success/redirects
        }
    }
}

/**
 * Middleware untuk notifikasi error dengan tema gelap
 */
class ErrorNotificationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (\Exception $e) {
            // Send error notification
            DesktopNotifier::error('Application Error', $e->getMessage(), [
                'ui_theme' => 'dark',
                'position' => 'top-center',
                'animation' => 'bounce',
                'size' => 'large',
                'timeout' => 5000
            ]);

            throw $e;
        }
    }
}

/**
 * Middleware untuk notifikasi maintenance mode
 */
class MaintenanceNotificationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (app()->isDownForMaintenance()) {
            DesktopNotifier::warning('Maintenance Mode', 'Application is currently under maintenance', [
                'ui_theme' => 'light',
                'position' => 'top-center',
                'animation' => 'fade',
                'size' => 'medium',
                'timeout' => 4000
            ]);
        }

        return $next($request);
    }
}

/**
 * Middleware untuk notifikasi rate limiting
 */
class RateLimitNotificationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Check if rate limited
        if ($response->getStatusCode() === 429) {
            DesktopNotifier::warning('Rate Limited', 'Too many requests. Please slow down.', [
                'ui_theme' => 'light',
                'position' => 'top-right',
                'animation' => 'bounce',
                'size' => 'medium',
                'timeout' => 3000
            ]);
        }

        return $response;
    }
}

/**
 * Middleware untuk notifikasi authentication
 */
class AuthNotificationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Check if unauthorized
        if ($response->getStatusCode() === 401) {
            DesktopNotifier::error('Authentication Required', 'Please log in to continue', [
                'ui_theme' => 'dark',
                'position' => 'top-center',
                'animation' => 'bounce',
                'size' => 'large',
                'timeout' => 4000
            ]);
        }

        // Check if forbidden
        if ($response->getStatusCode() === 403) {
            DesktopNotifier::error('Access Denied', 'You do not have permission to access this resource', [
                'ui_theme' => 'dark',
                'position' => 'top-center',
                'animation' => 'bounce',
                'size' => 'large',
                'timeout' => 4000
            ]);
        }

        return $response;
    }
}

/**
 * Middleware untuk notifikasi database operations
 */
class DatabaseNotificationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $startTime = microtime(true);
        
        $response = $next($request);
        
        $endTime = microtime(true);
        $duration = round(($endTime - $startTime) * 1000, 2);

        // Send notification for slow queries
        if ($duration > 1000) { // More than 1 second
            DesktopNotifier::warning('Slow Query Detected', "Database query took {$duration}ms", [
                'ui_theme' => 'light',
                'position' => 'bottom-right',
                'animation' => 'fade',
                'size' => 'medium',
                'timeout' => 3000
            ]);
        }

        return $response;
    }
}

/**
 * Middleware untuk notifikasi file uploads
 */
class FileUploadNotificationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Check if file was uploaded
        if ($request->hasFile('file') && $response->getStatusCode() === 200) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $fileSize = $this->formatBytes($file->getSize());

            DesktopNotifier::success('File Uploaded', "File '{$fileName}' ({$fileSize}) uploaded successfully", [
                'ui_theme' => 'modern',
                'position' => 'top-right',
                'animation' => 'slide',
                'size' => 'medium',
                'timeout' => 3000
            ]);
        }

        return $response;
    }

    /**
     * Format bytes to human readable format
     */
    protected function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}

/**
 * Middleware untuk notifikasi API responses
 */
class ApiNotificationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only for API routes
        if ($request->is('api/*')) {
            $statusCode = $response->getStatusCode();
            $method = $request->method();
            $endpoint = $request->path();

            $title = "API {$method}";
            $message = "{$endpoint} - Status: {$statusCode}";

            $theme = $this->getApiTheme($statusCode);
            $position = $this->getApiPosition($method);
            $animation = $this->getApiAnimation($statusCode);

            DesktopNotifier::notify($title, $message, [
                'ui_theme' => $theme,
                'position' => $position,
                'animation' => $animation,
                'size' => 'small',
                'timeout' => 2000
            ]);
        }

        return $response;
    }

    /**
     * Get theme for API responses
     */
    protected function getApiTheme(int $statusCode): string
    {
        if ($statusCode >= 400) {
            return 'dark';
        } elseif ($statusCode >= 300) {
            return 'light';
        } else {
            return 'modern';
        }
    }

    /**
     * Get position for API methods
     */
    protected function getApiPosition(string $method): string
    {
        $positions = [
            'GET' => 'bottom-left',
            'POST' => 'bottom-right',
            'PUT' => 'top-left',
            'PATCH' => 'top-left',
            'DELETE' => 'top-right'
        ];

        return $positions[$method] ?? 'bottom-right';
    }

    /**
     * Get animation for API status codes
     */
    protected function getApiAnimation(int $statusCode): string
    {
        if ($statusCode >= 400) {
            return 'bounce';
        } elseif ($statusCode >= 300) {
            return 'fade';
        } else {
            return 'slide';
        }
    }
} 