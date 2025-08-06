<?php

namespace LaravelNodeNotifierDesktop\Examples;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use LaravelNodeNotifierDesktop\Facades\DesktopNotifier;

class ExampleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $taskName;
    protected $userId;

    /**
     * Create a new job instance.
     */
    public function __construct(string $taskName, int $userId = null)
    {
        $this->taskName = $taskName;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Simulate some work
        sleep(2);
        
        // Send notification when job starts
        DesktopNotifier::info('Job Started', "Task '{$this->taskName}' has started processing");
        
        // Simulate more work
        sleep(3);
        
        // Send notification when job completes
        DesktopNotifier::success('Job Completed', "Task '{$this->taskName}' has been completed successfully");
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        // Send error notification when job fails
        DesktopNotifier::error('Job Failed', "Task '{$this->taskName}' failed: " . $exception->getMessage());
    }
} 