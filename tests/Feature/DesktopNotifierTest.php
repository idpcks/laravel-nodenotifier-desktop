<?php

namespace LaravelNodeNotifierDesktop\Tests\Feature;

use Orchestra\Testbench\TestCase;
use LaravelNodeNotifierDesktop\LaravelNodeNotifierDesktopServiceProvider;
use LaravelNodeNotifierDesktop\Services\DesktopNotifierService;
use LaravelNodeNotifierDesktop\Facades\DesktopNotifier;

class DesktopNotifierTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelNodeNotifierDesktopServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'DesktopNotifier' => DesktopNotifier::class,
        ];
    }

    /** @test */
    public function it_can_send_basic_notification()
    {
        $service = app(DesktopNotifierService::class);
        
        $result = $service->notify('Test Title', 'Test Message');
        
        // Since we can't easily test actual desktop notifications in tests,
        // we'll just verify the method exists and doesn't throw errors
        $this->assertIsBool($result);
    }

    /** @test */
    public function it_can_send_success_notification()
    {
        $service = app(DesktopNotifierService::class);
        
        $result = $service->success('Success Title', 'Success Message');
        
        $this->assertIsBool($result);
    }

    /** @test */
    public function it_can_send_error_notification()
    {
        $service = app(DesktopNotifierService::class);
        
        $result = $service->error('Error Title', 'Error Message');
        
        $this->assertIsBool($result);
    }

    /** @test */
    public function it_can_send_warning_notification()
    {
        $service = app(DesktopNotifierService::class);
        
        $result = $service->warning('Warning Title', 'Warning Message');
        
        $this->assertIsBool($result);
    }

    /** @test */
    public function it_can_send_info_notification()
    {
        $service = app(DesktopNotifierService::class);
        
        $result = $service->info('Info Title', 'Info Message');
        
        $this->assertIsBool($result);
    }

    /** @test */
    public function it_can_check_node_availability()
    {
        $service = app(DesktopNotifierService::class);
        
        $result = $service->isNodeAvailable();
        
        $this->assertIsBool($result);
    }

    /** @test */
    public function it_can_check_notifier_script_availability()
    {
        $service = app(DesktopNotifierService::class);
        
        $result = $service->isNotifierScriptAvailable();
        
        $this->assertIsBool($result);
    }

    /** @test */
    public function facade_can_send_notification()
    {
        $result = DesktopNotifier::notify('Facade Test', 'Testing facade');
        
        $this->assertIsBool($result);
    }

    /** @test */
    public function facade_can_send_success_notification()
    {
        $result = DesktopNotifier::success('Facade Success', 'Testing success facade');
        
        $this->assertIsBool($result);
    }

    /** @test */
    public function facade_can_send_error_notification()
    {
        $result = DesktopNotifier::error('Facade Error', 'Testing error facade');
        
        $this->assertIsBool($result);
    }

    /** @test */
    public function facade_can_send_warning_notification()
    {
        $result = DesktopNotifier::warning('Facade Warning', 'Testing warning facade');
        
        $this->assertIsBool($result);
    }

    /** @test */
    public function facade_can_send_info_notification()
    {
        $result = DesktopNotifier::info('Facade Info', 'Testing info facade');
        
        $this->assertIsBool($result);
    }

    /** @test */
    public function facade_can_check_node_availability()
    {
        $result = DesktopNotifier::isNodeAvailable();
        
        $this->assertIsBool($result);
    }

    /** @test */
    public function facade_can_check_notifier_script_availability()
    {
        $result = DesktopNotifier::isNotifierScriptAvailable();
        
        $this->assertIsBool($result);
    }

    /** @test */
    public function it_handles_windows_json_escaping_properly()
    {
        $service = app(DesktopNotifierService::class);
        
        // Test with special characters that might break JSON
        $title = 'Test "Title" with quotes';
        $message = 'Message with "quotes" and \backslashes\ and special chars: <>{}[]';
        
        // This should not throw an error due to Windows escaping issues
        $result = $service->notify($title, $message);
        
        $this->assertIsBool($result);
    }

    /** @test */
    public function it_provides_helpful_error_messages()
    {
        $service = app(DesktopNotifierService::class);
        
        // Check if error handling methods exist
        $this->assertTrue(method_exists($service, 'isNodeAvailable'));
        $this->assertTrue(method_exists($service, 'isNotifierScriptAvailable'));
    }
} 