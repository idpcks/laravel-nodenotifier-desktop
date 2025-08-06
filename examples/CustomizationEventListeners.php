<?php

namespace LaravelNodeNotifierDesktop\Examples;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Database\Events\TransactionCommitted;
use Illuminate\Database\Events\TransactionRolledBack;
use Illuminate\Cache\Events\CacheHit;
use Illuminate\Cache\Events\CacheMissed;
use Illuminate\Cache\Events\KeyForgotten;
use Illuminate\Cache\Events\KeyWritten;
use LaravelNodeNotifierDesktop\Facades\DesktopNotifier;

/**
 * Authentication Event Listeners
 */
class AuthEventListeners
{
    /**
     * Handle user login event
     */
    public function handleUserLogin(Login $event): void
    {
        $user = $event->user;
        $title = 'User Logged In';
        $message = "User {$user->name} ({$user->email}) has logged in";

        DesktopNotifier::success($title, $message, [
            'ui_theme' => 'modern',
            'position' => 'top-right',
            'animation' => 'slide',
            'timeout' => 3000
        ]);
    }

    /**
     * Handle user logout event
     */
    public function handleUserLogout(Logout $event): void
    {
        $user = $event->user;
        $title = 'User Logged Out';
        $message = "User {$user->name} ({$user->email}) has logged out";

        DesktopNotifier::info($title, $message, [
            'ui_theme' => 'light',
            'position' => 'bottom-right',
            'animation' => 'fade',
            'timeout' => 2000
        ]);
    }

    /**
     * Handle failed login event
     */
    public function handleFailedLogin(Failed $event): void
    {
        $credentials = $event->credentials;
        $email = $credentials['email'] ?? 'Unknown';
        $title = 'Failed Login Attempt';
        $message = "Failed login attempt for email: {$email}";

        DesktopNotifier::error($title, $message, [
            'ui_theme' => 'dark',
            'position' => 'top-center',
            'animation' => 'bounce',
            'size' => 'large',
            'timeout' => 4000
        ]);
    }

    /**
     * Handle password reset event
     */
    public function handlePasswordReset(PasswordReset $event): void
    {
        $user = $event->user;
        $title = 'Password Reset';
        $message = "Password has been reset for user: {$user->email}";

        DesktopNotifier::success($title, $message, [
            'ui_theme' => 'modern',
            'position' => 'top-right',
            'animation' => 'slide',
            'timeout' => 3000
        ]);
    }

    /**
     * Handle user registration event
     */
    public function handleUserRegistered(Registered $event): void
    {
        $user = $event->user;
        $title = 'New User Registered';
        $message = "New user registered: {$user->name} ({$user->email})";

        DesktopNotifier::success($title, $message, [
            'ui_theme' => 'modern',
            'position' => 'top-right',
            'animation' => 'bounce',
            'timeout' => 4000
        ]);
    }
}

/**
 * Mail Event Listeners
 */
class MailEventListeners
{
    /**
     * Handle message sending event
     */
    public function handleMessageSending(MessageSending $event): void
    {
        $message = $event->message;
        $to = $message->getTo();
        $subject = $message->getSubject();
        
        $recipient = is_array($to) ? array_keys($to)[0] : $to;
        
        $title = 'Sending Email';
        $emailMessage = "Sending email to: {$recipient}";

        DesktopNotifier::notify($title, $emailMessage, [
            'ui_theme' => 'light',
            'position' => 'bottom-left',
            'animation' => 'slide',
            'size' => 'small',
            'timeout' => 2000
        ]);
    }

    /**
     * Handle message sent event
     */
    public function handleMessageSent(MessageSent $event): void
    {
        $message = $event->message;
        $to = $message->getTo();
        $subject = $message->getSubject();
        
        $recipient = is_array($to) ? array_keys($to)[0] : $to;
        
        $title = 'Email Sent';
        $emailMessage = "Email sent to: {$recipient}";

        DesktopNotifier::success($title, $emailMessage, [
            'ui_theme' => 'modern',
            'position' => 'top-right',
            'animation' => 'slide',
            'timeout' => 3000
        ]);
    }
}

/**
 * Queue Event Listeners
 */
class QueueEventListeners
{
    /**
     * Handle job processing event
     */
    public function handleJobProcessing(JobProcessing $event): void
    {
        $jobName = class_basename($event->job->resolveName());
        $title = 'Job Processing';
        $message = "Processing job: {$jobName}";

        DesktopNotifier::notify($title, $message, [
            'ui_theme' => 'light',
            'position' => 'bottom-left',
            'animation' => 'fade',
            'size' => 'small',
            'timeout' => 2000
        ]);
    }

    /**
     * Handle job processed event
     */
    public function handleJobProcessed(JobProcessed $event): void
    {
        $jobName = class_basename($event->job->resolveName());
        $title = 'Job Completed';
        $message = "Job completed: {$jobName}";

        DesktopNotifier::success($title, $message, [
            'ui_theme' => 'modern',
            'position' => 'bottom-right',
            'animation' => 'slide',
            'timeout' => 3000
        ]);
    }

    /**
     * Handle job failed event
     */
    public function handleJobFailed(JobFailed $event): void
    {
        $jobName = class_basename($event->job->resolveName());
        $exception = $event->exception;
        $title = 'Job Failed';
        $message = "Job failed: {$jobName} - {$exception->getMessage()}";

        DesktopNotifier::error($title, $message, [
            'ui_theme' => 'dark',
            'position' => 'top-center',
            'animation' => 'bounce',
            'size' => 'large',
            'timeout' => 5000
        ]);
    }
}

/**
 * Database Event Listeners
 */
class DatabaseEventListeners
{
    /**
     * Handle query executed event
     */
    public function handleQueryExecuted(QueryExecuted $event): void
    {
        $sql = $event->sql;
        $time = $event->time;
        
        // Only notify for slow queries
        if ($time > 1000) { // More than 1 second
            $title = 'Slow Query Detected';
            $message = "Query took {$time}ms to execute";

            DesktopNotifier::warning($title, $message, [
                'ui_theme' => 'light',
                'position' => 'bottom-right',
                'animation' => 'fade',
                'size' => 'medium',
                'timeout' => 3000
            ]);
        }
    }

    /**
     * Handle transaction beginning event
     */
    public function handleTransactionBeginning(TransactionBeginning $event): void
    {
        $title = 'Database Transaction Started';
        $message = 'A new database transaction has begun';

        DesktopNotifier::notify($title, $message, [
            'ui_theme' => 'light',
            'position' => 'bottom-left',
            'animation' => 'slide',
            'size' => 'small',
            'timeout' => 2000
        ]);
    }

    /**
     * Handle transaction committed event
     */
    public function handleTransactionCommitted(TransactionCommitted $event): void
    {
        $title = 'Database Transaction Committed';
        $message = 'Database transaction has been committed successfully';

        DesktopNotifier::success($title, $message, [
            'ui_theme' => 'modern',
            'position' => 'bottom-right',
            'animation' => 'slide',
            'timeout' => 3000
        ]);
    }

    /**
     * Handle transaction rolled back event
     */
    public function handleTransactionRolledBack(TransactionRolledBack $event): void
    {
        $title = 'Database Transaction Rolled Back';
        $message = 'Database transaction has been rolled back';

        DesktopNotifier::error($title, $message, [
            'ui_theme' => 'dark',
            'position' => 'top-center',
            'animation' => 'bounce',
            'size' => 'medium',
            'timeout' => 4000
        ]);
    }
}

/**
 * Cache Event Listeners
 */
class CacheEventListeners
{
    /**
     * Handle cache hit event
     */
    public function handleCacheHit(CacheHit $event): void
    {
        $key = $event->key;
        $title = 'Cache Hit';
        $message = "Cache hit for key: {$key}";

        DesktopNotifier::notify($title, $message, [
            'ui_theme' => 'modern',
            'position' => 'bottom-left',
            'animation' => 'fade',
            'size' => 'small',
            'timeout' => 2000
        ]);
    }

    /**
     * Handle cache missed event
     */
    public function handleCacheMissed(CacheMissed $event): void
    {
        $key = $event->key;
        $title = 'Cache Miss';
        $message = "Cache miss for key: {$key}";

        DesktopNotifier::warning($title, $message, [
            'ui_theme' => 'light',
            'position' => 'bottom-right',
            'animation' => 'fade',
            'size' => 'small',
            'timeout' => 2000
        ]);
    }

    /**
     * Handle key forgotten event
     */
    public function handleKeyForgotten(KeyForgotten $event): void
    {
        $key = $event->key;
        $title = 'Cache Key Forgotten';
        $message = "Cache key forgotten: {$key}";

        DesktopNotifier::info($title, $message, [
            'ui_theme' => 'minimal',
            'position' => 'top-left',
            'animation' => 'slide',
            'size' => 'small',
            'timeout' => 2000
        ]);
    }

    /**
     * Handle key written event
     */
    public function handleKeyWritten(KeyWritten $event): void
    {
        $key = $event->key;
        $title = 'Cache Key Written';
        $message = "Cache key written: {$key}";

        DesktopNotifier::success($title, $message, [
            'ui_theme' => 'modern',
            'position' => 'top-right',
            'animation' => 'slide',
            'size' => 'small',
            'timeout' => 2000
        ]);
    }
}

/**
 * Custom Event Listeners
 */
class CustomEventListeners
{
    /**
     * Handle user profile update event
     */
    public function handleUserProfileUpdate($event): void
    {
        $user = $event->user;
        $title = 'Profile Updated';
        $message = "Profile updated for user: {$user->name}";

        DesktopNotifier::success($title, $message, [
            'ui_theme' => 'modern',
            'position' => 'top-right',
            'animation' => 'slide',
            'timeout' => 3000
        ]);
    }

    /**
     * Handle file upload event
     */
    public function handleFileUpload($event): void
    {
        $file = $event->file;
        $user = $event->user;
        $title = 'File Uploaded';
        $message = "File '{$file->name}' uploaded by {$user->name}";

        DesktopNotifier::success($title, $message, [
            'ui_theme' => 'modern',
            'position' => 'top-right',
            'animation' => 'bounce',
            'timeout' => 4000
        ]);
    }

    /**
     * Handle system backup event
     */
    public function handleSystemBackup($event): void
    {
        $backup = $event->backup;
        $title = 'System Backup';
        $message = "System backup completed: {$backup->filename}";

        DesktopNotifier::success($title, $message, [
            'ui_theme' => 'dark',
            'position' => 'bottom-center',
            'animation' => 'fade',
            'size' => 'medium',
            'timeout' => 5000
        ]);
    }

    /**
     * Handle system maintenance event
     */
    public function handleSystemMaintenance($event): void
    {
        $maintenance = $event->maintenance;
        $title = 'System Maintenance';
        $message = "System maintenance: {$maintenance->description}";

        DesktopNotifier::warning($title, $message, [
            'ui_theme' => 'light',
            'position' => 'top-center',
            'animation' => 'bounce',
            'size' => 'large',
            'timeout' => 6000
        ]);
    }

    /**
     * Handle security alert event
     */
    public function handleSecurityAlert($event): void
    {
        $alert = $event->alert;
        $title = 'Security Alert';
        $message = "Security alert: {$alert->description}";

        DesktopNotifier::error($title, $message, [
            'ui_theme' => 'dark',
            'position' => 'top-center',
            'animation' => 'bounce',
            'size' => 'large',
            'timeout' => 8000
        ]);
    }
} 