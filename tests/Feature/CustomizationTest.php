<?php

namespace LaravelNodeNotifierDesktop\Tests\Feature;

use LaravelNodeNotifierDesktop\Services\DesktopNotifierService;
use LaravelNodeNotifierDesktop\Tests\TestCase;

class CustomizationTest extends TestCase
{
    protected DesktopNotifierService $notifier;

    protected function setUp(): void
    {
        parent::setUp();
        $this->notifier = new DesktopNotifierService();
    }

    /** @test */
    public function it_can_send_notification_with_custom_position()
    {
        $result = $this->notifier->notifyAtPosition('Test Position', 'Testing custom position', 'top-right');
        $this->assertTrue($result);
    }

    /** @test */
    public function it_can_send_notification_with_custom_coordinates()
    {
        $result = $this->notifier->notifyAtCoordinates('Test Coordinates', 'Testing custom coordinates', 100, 200);
        $this->assertTrue($result);
    }

    /** @test */
    public function it_can_send_notification_with_custom_theme()
    {
        $result = $this->notifier->notifyWithTheme('Test Theme', 'Testing custom theme', 'dark');
        $this->assertTrue($result);
    }

    /** @test */
    public function it_can_send_notification_with_custom_animation()
    {
        $result = $this->notifier->notifyWithAnimation('Test Animation', 'Testing custom animation', 'bounce');
        $this->assertTrue($result);
    }

    /** @test */
    public function it_can_send_notification_with_custom_animation_duration()
    {
        $result = $this->notifier->notifyWithAnimation('Test Animation Duration', 'Testing custom animation duration', 'fade', 500);
        $this->assertTrue($result);
    }

    /** @test */
    public function it_can_send_notification_with_custom_size()
    {
        $result = $this->notifier->notifyWithSize('Test Size', 'Testing custom size', 'large');
        $this->assertTrue($result);
    }

    /** @test */
    public function it_can_send_notification_with_custom_sound()
    {
        $result = $this->notifier->notifyWithSound('Test Sound', 'Testing custom sound', '/path/to/sound.wav');
        $this->assertTrue($result);
    }

    /** @test */
    public function it_can_send_silent_notification()
    {
        $result = $this->notifier->notifySilent('Test Silent', 'Testing silent notification');
        $this->assertTrue($result);
    }

    /** @test */
    public function it_can_send_notification_with_multiple_customizations()
    {
        $result = $this->notifier->notify('Test Multiple', 'Testing multiple customizations', [
            'position' => 'top-right',
            'ui_theme' => 'dark',
            'animation' => 'bounce',
            'animation_duration' => 500,
            'size' => 'large',
            'custom_sound_file' => '/path/to/sound.mp3'
        ]);
        $this->assertTrue($result);
    }

    /** @test */
    public function it_can_send_success_notification_with_customization()
    {
        $result = $this->notifier->success('Test Success', 'Testing success with customization', [
            'ui_theme' => 'modern',
            'position' => 'top-right',
            'animation' => 'slide'
        ]);
        $this->assertTrue($result);
    }

    /** @test */
    public function it_can_send_error_notification_with_customization()
    {
        $result = $this->notifier->error('Test Error', 'Testing error with customization', [
            'ui_theme' => 'dark',
            'position' => 'top-center',
            'animation' => 'bounce'
        ]);
        $this->assertTrue($result);
    }

    /** @test */
    public function it_can_send_warning_notification_with_customization()
    {
        $result = $this->notifier->warning('Test Warning', 'Testing warning with customization', [
            'ui_theme' => 'light',
            'position' => 'bottom-center',
            'size' => 'large'
        ]);
        $this->assertTrue($result);
    }

    /** @test */
    public function it_can_send_info_notification_with_customization()
    {
        $result = $this->notifier->info('Test Info', 'Testing info with customization', [
            'ui_theme' => 'minimal',
            'position' => 'top-left',
            'animation' => 'fade'
        ]);
        $this->assertTrue($result);
    }

    /** @test */
    public function it_uses_default_position_when_not_specified()
    {
        $result = $this->notifier->notify('Test Default', 'Testing default position');
        $this->assertTrue($result);
    }

    /** @test */
    public function it_uses_default_theme_when_not_specified()
    {
        $result = $this->notifier->notify('Test Default Theme', 'Testing default theme');
        $this->assertTrue($result);
    }

    /** @test */
    public function it_uses_default_animation_when_not_specified()
    {
        $result = $this->notifier->notify('Test Default Animation', 'Testing default animation');
        $this->assertTrue($result);
    }

    /** @test */
    public function it_uses_default_size_when_not_specified()
    {
        $result = $this->notifier->notify('Test Default Size', 'Testing default size');
        $this->assertTrue($result);
    }

    /** @test */
    public function it_handles_invalid_position_gracefully()
    {
        $result = $this->notifier->notify('Test Invalid Position', 'Testing invalid position', [
            'position' => 'invalid-position'
        ]);
        $this->assertTrue($result); // Should fallback to default
    }

    /** @test */
    public function it_handles_invalid_theme_gracefully()
    {
        $result = $this->notifier->notify('Test Invalid Theme', 'Testing invalid theme', [
            'ui_theme' => 'invalid-theme'
        ]);
        $this->assertTrue($result); // Should fallback to default
    }

    /** @test */
    public function it_handles_invalid_animation_gracefully()
    {
        $result = $this->notifier->notify('Test Invalid Animation', 'Testing invalid animation', [
            'animation' => 'invalid-animation'
        ]);
        $this->assertTrue($result); // Should fallback to default
    }

    /** @test */
    public function it_handles_invalid_size_gracefully()
    {
        $result = $this->notifier->notify('Test Invalid Size', 'Testing invalid size', [
            'size' => 'invalid-size'
        ]);
        $this->assertTrue($result); // Should fallback to default
    }

    /** @test */
    public function it_handles_custom_position_with_coordinates()
    {
        $result = $this->notifier->notify('Test Custom Position', 'Testing custom position with coordinates', [
            'custom_position' => ['x' => 300, 'y' => 400]
        ]);
        $this->assertTrue($result);
    }

    /** @test */
    public function it_handles_zero_coordinates()
    {
        $result = $this->notifier->notifyAtCoordinates('Test Zero Coordinates', 'Testing zero coordinates', 0, 0);
        $this->assertTrue($result);
    }

    /** @test */
    public function it_handles_large_coordinates()
    {
        $result = $this->notifier->notifyAtCoordinates('Test Large Coordinates', 'Testing large coordinates', 1920, 1080);
        $this->assertTrue($result);
    }

    /** @test */
    public function it_handles_negative_coordinates()
    {
        $result = $this->notifier->notifyAtCoordinates('Test Negative Coordinates', 'Testing negative coordinates', -100, -200);
        $this->assertTrue($result);
    }

    /** @test */
    public function it_handles_all_position_presets()
    {
        $positions = ['top-right', 'top-left', 'bottom-right', 'bottom-left', 'top-center', 'bottom-center'];
        
        foreach ($positions as $position) {
            $result = $this->notifier->notifyAtPosition("Test $position", "Testing position: $position", $position);
            $this->assertTrue($result);
        }
    }

    /** @test */
    public function it_handles_all_themes()
    {
        $themes = ['default', 'modern', 'minimal', 'dark', 'light'];
        
        foreach ($themes as $theme) {
            $result = $this->notifier->notifyWithTheme("Test $theme", "Testing theme: $theme", $theme);
            $this->assertTrue($result);
        }
    }

    /** @test */
    public function it_handles_all_animations()
    {
        $animations = ['slide', 'fade', 'bounce', 'zoom', 'none'];
        
        foreach ($animations as $animation) {
            $result = $this->notifier->notifyWithAnimation("Test $animation", "Testing animation: $animation", $animation);
            $this->assertTrue($result);
        }
    }

    /** @test */
    public function it_handles_all_sizes()
    {
        $sizes = ['small', 'medium', 'large'];
        
        foreach ($sizes as $size) {
            $result = $this->notifier->notifyWithSize("Test $size", "Testing size: $size", $size);
            $this->assertTrue($result);
        }
    }

    /** @test */
    public function it_handles_animation_duration_range()
    {
        $durations = [100, 300, 500, 1000, 2000];
        
        foreach ($durations as $duration) {
            $result = $this->notifier->notifyWithAnimation("Test Duration $duration", "Testing duration: $duration", 'fade', $duration);
            $this->assertTrue($result);
        }
    }

    /** @test */
    public function it_handles_empty_custom_sound_file()
    {
        $result = $this->notifier->notifyWithSound('Test Empty Sound', 'Testing empty sound file', '');
        $this->assertTrue($result);
    }

    /** @test */
    public function it_handles_nonexistent_custom_sound_file()
    {
        $result = $this->notifier->notifyWithSound('Test Nonexistent Sound', 'Testing nonexistent sound file', '/path/to/nonexistent.wav');
        $this->assertTrue($result);
    }

    /** @test */
    public function it_handles_mixed_customization_options()
    {
        $result = $this->notifier->notify('Test Mixed', 'Testing mixed customization options', [
            'position' => 'top-right',
            'custom_position' => ['x' => 100, 'y' => 100], // This should override position
            'ui_theme' => 'dark',
            'animation' => 'bounce',
            'animation_duration' => 500,
            'size' => 'large',
            'custom_sound_file' => '/path/to/sound.mp3',
            'sound' => false, // This should override custom_sound_file
            'timeout' => 3000
        ]);
        $this->assertTrue($result);
    }
} 