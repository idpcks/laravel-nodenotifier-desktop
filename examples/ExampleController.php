<?php

namespace LaravelNodeNotifierDesktop\Examples;

use Illuminate\Http\Request;
use LaravelNodeNotifierDesktop\Facades\DesktopNotifier;

class ExampleController
{
    /**
     * Send a basic notification
     */
    public function sendBasicNotification()
    {
        DesktopNotifier::notify('Hello', 'This is a basic notification');
        
        return response()->json(['message' => 'Basic notification sent']);
    }

    /**
     * Send a success notification
     */
    public function sendSuccessNotification()
    {
        DesktopNotifier::success('Success!', 'Operation completed successfully');
        
        return response()->json(['message' => 'Success notification sent']);
    }

    /**
     * Send an error notification
     */
    public function sendErrorNotification()
    {
        DesktopNotifier::error('Error!', 'Something went wrong');
        
        return response()->json(['message' => 'Error notification sent']);
    }

    /**
     * Send a warning notification
     */
    public function sendWarningNotification()
    {
        DesktopNotifier::warning('Warning!', 'Please check your input');
        
        return response()->json(['message' => 'Warning notification sent']);
    }

    /**
     * Send an info notification
     */
    public function sendInfoNotification()
    {
        DesktopNotifier::info('Info', 'Here is some information');
        
        return response()->json(['message' => 'Info notification sent']);
    }

    /**
     * Send a custom notification with options
     */
    public function sendCustomNotification(Request $request)
    {
        $title = $request->input('title', 'Custom Notification');
        $message = $request->input('message', 'This is a custom notification');
        $icon = $request->input('icon');
        $sound = $request->input('sound', true);
        $timeout = $request->input('timeout', 5000);

        $options = [];
        
        if ($icon) {
            $options['icon'] = $icon;
        }
        
        $options['sound'] = $sound;
        $options['timeout'] = $timeout;

        DesktopNotifier::notify($title, $message, $options);
        
        return response()->json(['message' => 'Custom notification sent']);
    }

    /**
     * Check system requirements
     */
    public function checkRequirements()
    {
        $nodeAvailable = DesktopNotifier::isNodeAvailable();
        $scriptAvailable = DesktopNotifier::isNotifierScriptAvailable();
        
        return response()->json([
            'node_available' => $nodeAvailable,
            'script_available' => $scriptAvailable,
            'ready' => $nodeAvailable && $scriptAvailable
        ]);
    }
} 