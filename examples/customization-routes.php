<?php

use Illuminate\Support\Facades\Route;
use LaravelNodeNotifierDesktop\Facades\DesktopNotifier;
use LaravelNodeNotifierDesktop\Examples\CustomizationController;

/*
|--------------------------------------------------------------------------
| Customization Examples Routes
|--------------------------------------------------------------------------
|
| These routes demonstrate the customization features of Laravel Node 
| Notifier Desktop. You can add these routes to your web.php file.
|
*/

// Basic customization examples
Route::prefix('customization')->group(function () {
    
    // Position examples
    Route::get('/position', [CustomizationController::class, 'positionExamples']);
    Route::get('/position/{position}', function ($position) {
        DesktopNotifier::notifyAtPosition('Position Test', "Testing {$position} position", $position);
        return response()->json(['message' => "Position test sent: {$position}"]);
    })->where('position', 'top-right|top-left|bottom-right|bottom-left|top-center|bottom-center');

    // Theme examples
    Route::get('/theme', [CustomizationController::class, 'themeExamples']);
    Route::get('/theme/{theme}', function ($theme) {
        DesktopNotifier::notifyWithTheme('Theme Test', "Testing {$theme} theme", $theme);
        return response()->json(['message' => "Theme test sent: {$theme}"]);
    })->where('theme', 'default|modern|minimal|dark|light');

    // Animation examples
    Route::get('/animation', [CustomizationController::class, 'animationExamples']);
    Route::get('/animation/{animation}', function ($animation) {
        DesktopNotifier::notifyWithAnimation('Animation Test', "Testing {$animation} animation", $animation);
        return response()->json(['message' => "Animation test sent: {$animation}"]);
    })->where('animation', 'slide|fade|bounce|zoom|none');

    // Size examples
    Route::get('/size', [CustomizationController::class, 'sizeExamples']);
    Route::get('/size/{size}', function ($size) {
        DesktopNotifier::notifyWithSize('Size Test', "Testing {$size} size", $size);
        return response()->json(['message' => "Size test sent: {$size}"]);
    })->where('size', 'small|medium|large');

    // Sound examples
    Route::get('/sound', [CustomizationController::class, 'soundExamples']);
    Route::get('/sound/silent', function () {
        DesktopNotifier::notifySilent('Silent Test', 'This notification has no sound');
        return response()->json(['message' => 'Silent notification sent']);
    });

    // Combination examples
    Route::get('/combination', [CustomizationController::class, 'combinationExamples']);
    
    // Notification type examples
    Route::get('/types', [CustomizationController::class, 'notificationTypeExamples']);
    
    // Real-time examples
    Route::get('/realtime', [CustomizationController::class, 'realTimeExamples']);
});

// Custom notification endpoint
Route::post('/test-notification', [CustomizationController::class, 'customNotification']);

// Batch notifications
Route::get('/batch', [CustomizationController::class, 'batchNotifications']);

// Demo routes for different scenarios
Route::prefix('demo')->group(function () {
    
    // Chat application demo
    Route::get('/chat', function () {
        DesktopNotifier::notify('New Message', 'You have a new message from John Doe', [
            'ui_theme' => 'modern',
            'position' => 'top-right',
            'animation' => 'slide',
            'timeout' => 3000
        ]);
        return response()->json(['message' => 'Chat notification sent']);
    });

    // Email application demo
    Route::get('/email', function () {
        DesktopNotifier::notify('New Email', 'Email from noreply@example.com', [
            'ui_theme' => 'light',
            'position' => 'top-center',
            'animation' => 'bounce',
            'timeout' => 4000
        ]);
        return response()->json(['message' => 'Email notification sent']);
    });

    // System notification demo
    Route::get('/system', function () {
        DesktopNotifier::notify('System Update', 'System is updating...', [
            'ui_theme' => 'dark',
            'position' => 'bottom-right',
            'animation' => 'fade',
            'size' => 'small'
        ]);
        return response()->json(['message' => 'System notification sent']);
    });

    // Error notification demo
    Route::get('/error', function () {
        DesktopNotifier::error('Error!', 'Terjadi kesalahan dalam sistem', [
            'ui_theme' => 'dark',
            'position' => 'top-center',
            'animation' => 'bounce',
            'size' => 'large'
        ]);
        return response()->json(['message' => 'Error notification sent']);
    });

    // Success notification demo
    Route::get('/success', function () {
        DesktopNotifier::success('Success!', 'Operasi berhasil diselesaikan', [
            'ui_theme' => 'modern',
            'position' => 'top-right',
            'animation' => 'slide'
        ]);
        return response()->json(['message' => 'Success notification sent']);
    });

    // Warning notification demo
    Route::get('/warning', function () {
        DesktopNotifier::warning('Warning!', 'Perhatian: Ada masalah yang perlu diperhatikan', [
            'ui_theme' => 'light',
            'position' => 'bottom-center',
            'size' => 'large'
        ]);
        return response()->json(['message' => 'Warning notification sent']);
    });

    // Info notification demo
    Route::get('/info', function () {
        DesktopNotifier::info('Info', 'Informasi penting untuk Anda', [
            'ui_theme' => 'minimal',
            'position' => 'top-left',
            'animation' => 'fade'
        ]);
        return response()->json(['message' => 'Info notification sent']);
    });
});

// API routes for customization
Route::prefix('api/customization')->group(function () {
    
    // Get available options
    Route::get('/options', function () {
        return response()->json([
            'positions' => [
                'top-right', 'top-left', 'bottom-right', 'bottom-left', 
                'top-center', 'bottom-center'
            ],
            'themes' => [
                'default', 'modern', 'minimal', 'dark', 'light'
            ],
            'animations' => [
                'slide', 'fade', 'bounce', 'zoom', 'none'
            ],
            'sizes' => [
                'small', 'medium', 'large'
            ]
        ]);
    });

    // Send notification with custom options
    Route::post('/notify', function (Request $request) {
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

        if ($request->has('position')) {
            $options['position'] = $request->position;
        }

        if ($request->has('theme')) {
            $options['ui_theme'] = $request->theme;
        }

        if ($request->has('animation')) {
            $options['animation'] = $request->animation;
        }

        if ($request->has('size')) {
            $options['size'] = $request->size;
        }

        if ($request->has('sound')) {
            $options['sound'] = $request->sound;
        }

        if ($request->has('timeout')) {
            $options['timeout'] = $request->timeout;
        }

        $success = DesktopNotifier::notify($request->title, $request->message, $options);

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Notification sent successfully' : 'Failed to send notification',
            'options' => $options
        ]);
    });

    // Send notification with custom coordinates
    Route::post('/notify/coordinates', function (Request $request) {
        $request->validate([
            'title' => 'required|string|max:100',
            'message' => 'required|string|max:500',
            'x' => 'required|integer|min:0|max:3000',
            'y' => 'required|integer|min:0|max:2000'
        ]);

        $success = DesktopNotifier::notifyAtCoordinates(
            $request->title, 
            $request->message, 
            $request->x, 
            $request->y
        );

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Notification sent successfully' : 'Failed to send notification',
            'coordinates' => ['x' => $request->x, 'y' => $request->y]
        ]);
    });

    // Send notification with custom sound
    Route::post('/notify/sound', function (Request $request) {
        $request->validate([
            'title' => 'required|string|max:100',
            'message' => 'required|string|max:500',
            'sound_file' => 'required|string'
        ]);

        $success = DesktopNotifier::notifyWithSound(
            $request->title, 
            $request->message, 
            $request->sound_file
        );

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Notification sent successfully' : 'Failed to send notification',
            'sound_file' => $request->sound_file
        ]);
    });

    // Send silent notification
    Route::post('/notify/silent', function (Request $request) {
        $request->validate([
            'title' => 'required|string|max:100',
            'message' => 'required|string|max:500'
        ]);

        $success = DesktopNotifier::notifySilent($request->title, $request->message);

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Silent notification sent successfully' : 'Failed to send notification'
        ]);
    });
});

// Webhook routes for external integrations
Route::prefix('webhook')->group(function () {
    
    // GitHub webhook for notifications
    Route::post('/github', function (Request $request) {
        $event = $request->header('X-GitHub-Event');
        
        switch ($event) {
            case 'push':
                DesktopNotifier::notify('GitHub Push', 'New code pushed to repository', [
                    'ui_theme' => 'modern',
                    'position' => 'top-right',
                    'animation' => 'slide'
                ]);
                break;
                
            case 'pull_request':
                DesktopNotifier::notify('GitHub PR', 'New pull request created', [
                    'ui_theme' => 'light',
                    'position' => 'top-center',
                    'animation' => 'bounce'
                ]);
                break;
                
            case 'issues':
                DesktopNotifier::notify('GitHub Issue', 'New issue created', [
                    'ui_theme' => 'dark',
                    'position' => 'bottom-right',
                    'animation' => 'fade'
                ]);
                break;
        }
        
        return response()->json(['message' => 'Webhook processed']);
    });

    // Slack webhook for notifications
    Route::post('/slack', function (Request $request) {
        $data = $request->all();
        
        if (isset($data['text'])) {
            DesktopNotifier::notify('Slack Message', $data['text'], [
                'ui_theme' => 'modern',
                'position' => 'top-right',
                'animation' => 'slide',
                'timeout' => 3000
            ]);
        }
        
        return response()->json(['message' => 'Slack webhook processed']);
    });

    // Discord webhook for notifications
    Route::post('/discord', function (Request $request) {
        $data = $request->all();
        
        if (isset($data['content'])) {
            DesktopNotifier::notify('Discord Message', $data['content'], [
                'ui_theme' => 'dark',
                'position' => 'bottom-right',
                'animation' => 'fade',
                'timeout' => 4000
            ]);
        }
        
        return response()->json(['message' => 'Discord webhook processed']);
    });
});

// Admin routes for notification management
Route::prefix('admin/notifications')->middleware(['auth', 'admin'])->group(function () {
    
    // Send system-wide notification
    Route::post('/broadcast', function (Request $request) {
        $request->validate([
            'title' => 'required|string|max:100',
            'message' => 'required|string|max:500',
            'type' => 'required|string|in:info,warning,error,success'
        ]);

        $options = [
            'ui_theme' => $request->type === 'error' ? 'dark' : 'modern',
            'position' => 'top-center',
            'animation' => $request->type === 'error' ? 'bounce' : 'slide',
            'size' => 'large',
            'timeout' => 5000
        ];

        switch ($request->type) {
            case 'success':
                DesktopNotifier::success($request->title, $request->message, $options);
                break;
            case 'error':
                DesktopNotifier::error($request->title, $request->message, $options);
                break;
            case 'warning':
                DesktopNotifier::warning($request->title, $request->message, $options);
                break;
            case 'info':
                DesktopNotifier::info($request->title, $request->message, $options);
                break;
        }

        return response()->json([
            'success' => true,
            'message' => 'Broadcast notification sent'
        ]);
    });

    // Test notification system
    Route::post('/test', function (Request $request) {
        $request->validate([
            'type' => 'required|string|in:position,theme,animation,size,sound,combination'
        ]);

        switch ($request->type) {
            case 'position':
                DesktopNotifier::notifyAtPosition('Test', 'Position test', 'top-right');
                break;
            case 'theme':
                DesktopNotifier::notifyWithTheme('Test', 'Theme test', 'modern');
                break;
            case 'animation':
                DesktopNotifier::notifyWithAnimation('Test', 'Animation test', 'bounce');
                break;
            case 'size':
                DesktopNotifier::notifyWithSize('Test', 'Size test', 'large');
                break;
            case 'sound':
                DesktopNotifier::notifySilent('Test', 'Sound test');
                break;
            case 'combination':
                DesktopNotifier::notify('Test', 'Combination test', [
                    'ui_theme' => 'dark',
                    'position' => 'top-center',
                    'animation' => 'bounce',
                    'size' => 'large'
                ]);
                break;
        }

        return response()->json([
            'success' => true,
            'message' => "Test notification sent: {$request->type}"
        ]);
    });
});

// Health check route for notification system
Route::get('/health/notifications', function () {
    $nodeAvailable = DesktopNotifier::isNodeAvailable();
    $scriptAvailable = DesktopNotifier::isNotifierScriptAvailable();
    
    return response()->json([
        'status' => $nodeAvailable && $scriptAvailable ? 'healthy' : 'unhealthy',
        'node_available' => $nodeAvailable,
        'script_available' => $scriptAvailable,
        'timestamp' => now()->toISOString()
    ]);
});

// Documentation route
Route::get('/docs/customization', function () {
    return view('customization-examples');
})->name('customization.docs');

// Example route for testing all features
Route::get('/test-all', function () {
    $tests = [
        'Position Tests' => function() {
            $positions = ['top-right', 'top-left', 'bottom-right', 'bottom-left', 'top-center', 'bottom-center'];
            foreach ($positions as $position) {
                DesktopNotifier::notifyAtPosition('Test', "Testing {$position}", $position);
                sleep(1);
            }
        },
        'Theme Tests' => function() {
            $themes = ['default', 'modern', 'minimal', 'dark', 'light'];
            foreach ($themes as $theme) {
                DesktopNotifier::notifyWithTheme('Test', "Testing {$theme} theme", $theme);
                sleep(1);
            }
        },
        'Animation Tests' => function() {
            $animations = ['slide', 'fade', 'bounce', 'zoom', 'none'];
            foreach ($animations as $animation) {
                DesktopNotifier::notifyWithAnimation('Test', "Testing {$animation} animation", $animation);
                sleep(1);
            }
        },
        'Size Tests' => function() {
            $sizes = ['small', 'medium', 'large'];
            foreach ($sizes as $size) {
                DesktopNotifier::notifyWithSize('Test', "Testing {$size} size", $size);
                sleep(1);
            }
        }
    ];

    foreach ($tests as $name => $test) {
        $test();
    }

    return response()->json([
        'message' => 'All tests completed',
        'tests' => array_keys($tests)
    ]);
}); 