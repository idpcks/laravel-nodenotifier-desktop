<?php

namespace LaravelNodeNotifierDesktop\Examples;

use Illuminate\Console\Command;
use LaravelNodeNotifierDesktop\Facades\DesktopNotifier;

class CustomizationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customization:demo 
                            {--position= : Position for notifications (top-right, top-left, bottom-right, bottom-left, top-center, bottom-center)}
                            {--theme= : Theme for notifications (default, modern, minimal, dark, light)}
                            {--animation= : Animation for notifications (slide, fade, bounce, zoom, none)}
                            {--size= : Size for notifications (small, medium, large)}
                            {--sound= : Custom sound file path}
                            {--silent : Send notifications without sound}
                            {--all : Show all customization examples}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Demonstrate customization features of Laravel Node Notifier Desktop';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🎉 Laravel Node Notifier Desktop - Customization Demo');
        $this->newLine();

        if ($this->option('all')) {
            $this->showAllExamples();
        } else {
            $this->showCustomExample();
        }

        $this->info('✅ Customization demo completed!');
        return Command::SUCCESS;
    }

    /**
     * Show all customization examples
     */
    protected function showAllExamples(): void
    {
        $this->info('📋 Showing all customization examples...');
        $this->newLine();

        // Position examples
        $this->showPositionExamples();

        // Theme examples
        $this->showThemeExamples();

        // Animation examples
        $this->showAnimationExamples();

        // Size examples
        $this->showSizeExamples();

        // Sound examples
        $this->showSoundExamples();

        // Combination examples
        $this->showCombinationExamples();
    }

    /**
     * Show custom example based on options
     */
    protected function showCustomExample(): void
    {
        $this->info('🎯 Showing custom example...');
        $this->newLine();

        $options = [];

        // Get position
        if ($position = $this->option('position')) {
            $options['position'] = $position;
            $this->line("📍 Position: {$position}");
        }

        // Get theme
        if ($theme = $this->option('theme')) {
            $options['ui_theme'] = $theme;
            $this->line("🎨 Theme: {$theme}");
        }

        // Get animation
        if ($animation = $this->option('animation')) {
            $options['animation'] = $animation;
            $this->line("✨ Animation: {$animation}");
        }

        // Get size
        if ($size = $this->option('size')) {
            $options['size'] = $size;
            $this->line("📏 Size: {$size}");
        }

        // Get sound
        if ($sound = $this->option('sound')) {
            $options['custom_sound_file'] = $sound;
            $this->line("🔊 Sound: {$sound}");
        }

        // Check silent
        if ($this->option('silent')) {
            $options['sound'] = false;
            $this->line("🔇 Silent: true");
        }

        $this->newLine();

        // Send notification
        $success = DesktopNotifier::notify(
            'Custom Demo',
            'This is a custom notification with your specified options',
            $options
        );

        if ($success) {
            $this->info('✅ Custom notification sent successfully!');
        } else {
            $this->error('❌ Failed to send custom notification');
        }
    }

    /**
     * Show position examples
     */
    protected function showPositionExamples(): void
    {
        $this->info('📍 Position Examples:');
        
        $positions = [
            'top-right' => 'Top Right',
            'top-left' => 'Top Left',
            'bottom-right' => 'Bottom Right (Default)',
            'bottom-left' => 'Bottom Left',
            'top-center' => 'Top Center',
            'bottom-center' => 'Bottom Center'
        ];

        foreach ($positions as $position => $label) {
            $this->line("  • {$label} ({$position})");
            
            DesktopNotifier::notifyAtPosition(
                "Position Demo",
                "This notification is positioned at {$label}",
                $position
            );

            // Small delay between notifications
            sleep(1);
        }

        $this->newLine();
    }

    /**
     * Show theme examples
     */
    protected function showThemeExamples(): void
    {
        $this->info('🎨 Theme Examples:');
        
        $themes = [
            'default' => 'Default Theme',
            'modern' => 'Modern Theme',
            'minimal' => 'Minimal Theme',
            'dark' => 'Dark Theme',
            'light' => 'Light Theme'
        ];

        foreach ($themes as $theme => $label) {
            $this->line("  • {$label} ({$theme})");
            
            DesktopNotifier::notifyWithTheme(
                "Theme Demo",
                "This notification uses {$label}",
                $theme
            );

            // Small delay between notifications
            sleep(1);
        }

        $this->newLine();
    }

    /**
     * Show animation examples
     */
    protected function showAnimationExamples(): void
    {
        $this->info('✨ Animation Examples:');
        
        $animations = [
            'slide' => 'Slide Animation (Default)',
            'fade' => 'Fade Animation',
            'bounce' => 'Bounce Animation',
            'zoom' => 'Zoom Animation',
            'none' => 'No Animation'
        ];

        foreach ($animations as $animation => $label) {
            $this->line("  • {$label} ({$animation})");
            
            DesktopNotifier::notifyWithAnimation(
                "Animation Demo",
                "This notification uses {$label}",
                $animation
            );

            // Small delay between notifications
            sleep(1);
        }

        $this->newLine();
    }

    /**
     * Show size examples
     */
    protected function showSizeExamples(): void
    {
        $this->info('📏 Size Examples:');
        
        $sizes = [
            'small' => 'Small Size (280x80px)',
            'medium' => 'Medium Size (350x100px) - Default',
            'large' => 'Large Size (420x120px)'
        ];

        foreach ($sizes as $size => $label) {
            $this->line("  • {$label} ({$size})");
            
            DesktopNotifier::notifyWithSize(
                "Size Demo",
                "This notification uses {$label}",
                $size
            );

            // Small delay between notifications
            sleep(1);
        }

        $this->newLine();
    }

    /**
     * Show sound examples
     */
    protected function showSoundExamples(): void
    {
        $this->info('🔊 Sound Examples:');
        
        // Default sound
        $this->line("  • Default Sound");
        DesktopNotifier::notify('Sound Demo', 'This notification uses default system sound');
        sleep(1);

        // Silent notification
        $this->line("  • Silent Notification");
        DesktopNotifier::notifySilent('Sound Demo', 'This notification has no sound');
        sleep(1);

        // Custom sound (if file exists)
        $customSoundPath = storage_path('sounds/notification.wav');
        if (file_exists($customSoundPath)) {
            $this->line("  • Custom Sound");
            DesktopNotifier::notifyWithSound('Sound Demo', 'This notification uses custom sound', $customSoundPath);
        } else {
            $this->line("  • Custom Sound (file not found: {$customSoundPath})");
        }

        $this->newLine();
    }

    /**
     * Show combination examples
     */
    protected function showCombinationExamples(): void
    {
        $this->info('🎛️ Combination Examples:');
        
        // Example 1: Modern theme with bounce animation
        $this->line("  • Modern + Bounce + Top Right");
        DesktopNotifier::notify('Combination Demo', 'Modern theme with bounce animation', [
            'ui_theme' => 'modern',
            'animation' => 'bounce',
            'position' => 'top-right',
            'size' => 'medium'
        ]);
        sleep(1);

        // Example 2: Dark theme with fade animation
        $this->line("  • Dark + Fade + Top Center");
        DesktopNotifier::notify('Combination Demo', 'Dark theme with fade animation', [
            'ui_theme' => 'dark',
            'animation' => 'fade',
            'position' => 'top-center',
            'size' => 'large'
        ]);
        sleep(1);

        // Example 3: Light theme with slide animation
        $this->line("  • Light + Slide + Bottom Left");
        DesktopNotifier::notify('Combination Demo', 'Light theme with slide animation', [
            'ui_theme' => 'light',
            'animation' => 'slide',
            'position' => 'bottom-left',
            'size' => 'small'
        ]);
        sleep(1);

        // Example 4: Minimal theme with no animation
        $this->line("  • Minimal + No Animation + Bottom Center");
        DesktopNotifier::notify('Combination Demo', 'Minimal theme with no animation', [
            'ui_theme' => 'minimal',
            'animation' => 'none',
            'position' => 'bottom-center',
            'size' => 'medium'
        ]);

        $this->newLine();
    }
}

/**
 * Command untuk testing semua fitur kustomisasi
 */
class TestCustomizationCommand extends Command
{
    protected $signature = 'customization:test {--verbose : Show detailed output}';
    protected $description = 'Test all customization features';

    public function handle(): int
    {
        $this->info('🧪 Testing Customization Features...');
        $this->newLine();

        $tests = [
            'Position Tests' => $this->testPositions(),
            'Theme Tests' => $this->testThemes(),
            'Animation Tests' => $this->testAnimations(),
            'Size Tests' => $this->testSizes(),
            'Sound Tests' => $this->testSounds(),
            'Combination Tests' => $this->testCombinations(),
        ];

        $passed = 0;
        $total = count($tests);

        foreach ($tests as $testName => $result) {
            if ($result) {
                $this->info("✅ {$testName}: PASSED");
                $passed++;
            } else {
                $this->error("❌ {$testName}: FAILED");
            }
        }

        $this->newLine();
        $this->info("📊 Test Results: {$passed}/{$total} tests passed");

        return $passed === $total ? Command::SUCCESS : Command::FAILURE;
    }

    protected function testPositions(): bool
    {
        $positions = ['top-right', 'top-left', 'bottom-right', 'bottom-left', 'top-center', 'bottom-center'];
        
        foreach ($positions as $position) {
            $result = DesktopNotifier::notifyAtPosition('Test', 'Testing position', $position);
            if (!$result) return false;
            sleep(0.5);
        }
        
        return true;
    }

    protected function testThemes(): bool
    {
        $themes = ['default', 'modern', 'minimal', 'dark', 'light'];
        
        foreach ($themes as $theme) {
            $result = DesktopNotifier::notifyWithTheme('Test', 'Testing theme', $theme);
            if (!$result) return false;
            sleep(0.5);
        }
        
        return true;
    }

    protected function testAnimations(): bool
    {
        $animations = ['slide', 'fade', 'bounce', 'zoom', 'none'];
        
        foreach ($animations as $animation) {
            $result = DesktopNotifier::notifyWithAnimation('Test', 'Testing animation', $animation);
            if (!$result) return false;
            sleep(0.5);
        }
        
        return true;
    }

    protected function testSizes(): bool
    {
        $sizes = ['small', 'medium', 'large'];
        
        foreach ($sizes as $size) {
            $result = DesktopNotifier::notifyWithSize('Test', 'Testing size', $size);
            if (!$result) return false;
            sleep(0.5);
        }
        
        return true;
    }

    protected function testSounds(): bool
    {
        // Test default sound
        $result1 = DesktopNotifier::notify('Test', 'Testing default sound');
        
        // Test silent notification
        $result2 = DesktopNotifier::notifySilent('Test', 'Testing silent notification');
        
        return $result1 && $result2;
    }

    protected function testCombinations(): bool
    {
        $result = DesktopNotifier::notify('Test', 'Testing combination', [
            'ui_theme' => 'dark',
            'position' => 'top-right',
            'animation' => 'bounce',
            'size' => 'large',
            'timeout' => 3000
        ]);
        
        return $result;
    }
}

/**
 * Command untuk benchmarking fitur kustomisasi
 */
class BenchmarkCustomizationCommand extends Command
{
    protected $signature = 'customization:benchmark {--iterations=100 : Number of iterations}';
    protected $description = 'Benchmark customization features performance';

    public function handle(): int
    {
        $iterations = (int) $this->option('iterations');
        
        $this->info("🏃‍♂️ Benchmarking Customization Features ({$iterations} iterations)...");
        $this->newLine();

        $benchmarks = [
            'Basic Notification' => $this->benchmarkBasic(),
            'Position Customization' => $this->benchmarkPosition(),
            'Theme Customization' => $this->benchmarkTheme(),
            'Animation Customization' => $this->benchmarkAnimation(),
            'Size Customization' => $this->benchmarkSize(),
            'Combination Customization' => $this->benchmarkCombination(),
        ];

        $this->info('📊 Benchmark Results:');
        $this->newLine();

        foreach ($benchmarks as $name => $time) {
            $this->line("  • {$name}: {$time}ms");
        }

        $this->newLine();
        $this->info('✅ Benchmark completed!');

        return Command::SUCCESS;
    }

    protected function benchmarkBasic(): float
    {
        $start = microtime(true);
        
        for ($i = 0; $i < $this->option('iterations'); $i++) {
            DesktopNotifier::notify('Benchmark', 'Basic notification test');
        }
        
        $end = microtime(true);
        return round(($end - $start) * 1000, 2);
    }

    protected function benchmarkPosition(): float
    {
        $start = microtime(true);
        
        for ($i = 0; $i < $this->option('iterations'); $i++) {
            DesktopNotifier::notifyAtPosition('Benchmark', 'Position test', 'top-right');
        }
        
        $end = microtime(true);
        return round(($end - $start) * 1000, 2);
    }

    protected function benchmarkTheme(): float
    {
        $start = microtime(true);
        
        for ($i = 0; $i < $this->option('iterations'); $i++) {
            DesktopNotifier::notifyWithTheme('Benchmark', 'Theme test', 'modern');
        }
        
        $end = microtime(true);
        return round(($end - $start) * 1000, 2);
    }

    protected function benchmarkAnimation(): float
    {
        $start = microtime(true);
        
        for ($i = 0; $i < $this->option('iterations'); $i++) {
            DesktopNotifier::notifyWithAnimation('Benchmark', 'Animation test', 'bounce');
        }
        
        $end = microtime(true);
        return round(($end - $start) * 1000, 2);
    }

    protected function benchmarkSize(): float
    {
        $start = microtime(true);
        
        for ($i = 0; $i < $this->option('iterations'); $i++) {
            DesktopNotifier::notifyWithSize('Benchmark', 'Size test', 'large');
        }
        
        $end = microtime(true);
        return round(($end - $start) * 1000, 2);
    }

    protected function benchmarkCombination(): float
    {
        $start = microtime(true);
        
        for ($i = 0; $i < $this->option('iterations'); $i++) {
            DesktopNotifier::notify('Benchmark', 'Combination test', [
                'ui_theme' => 'dark',
                'position' => 'top-right',
                'animation' => 'bounce',
                'size' => 'large'
            ]);
        }
        
        $end = microtime(true);
        return round(($end - $start) * 1000, 2);
    }
} 