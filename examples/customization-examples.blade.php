<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Node Notifier Desktop - Customization Examples</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 2.5em;
            font-weight: 300;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 1.1em;
        }
        .content {
            padding: 30px;
        }
        .section {
            margin-bottom: 40px;
            padding: 25px;
            border-radius: 10px;
            background: #f8f9fa;
            border-left: 4px solid #667eea;
        }
        .section h2 {
            margin: 0 0 20px 0;
            color: #333;
            font-size: 1.5em;
        }
        .demo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .demo-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
        }
        .demo-card h3 {
            margin: 0 0 15px 0;
            color: #495057;
            font-size: 1.2em;
        }
        .demo-card p {
            margin: 0 0 15px 0;
            color: #6c757d;
            font-size: 0.9em;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 0.9em;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background: #5a6fd8;
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: #6c757d;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .btn-success {
            background: #28a745;
        }
        .btn-success:hover {
            background: #218838;
        }
        .btn-warning {
            background: #ffc107;
            color: #212529;
        }
        .btn-warning:hover {
            background: #e0a800;
        }
        .btn-danger {
            background: #dc3545;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        .btn-info {
            background: #17a2b8;
        }
        .btn-info:hover {
            background: #138496;
        }
        .code-block {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 5px;
            padding: 15px;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
            font-size: 0.85em;
            overflow-x: auto;
        }
        .feature-list {
            list-style: none;
            padding: 0;
        }
        .feature-list li {
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .feature-list li:last-child {
            border-bottom: none;
        }
        .feature-list li::before {
            content: "✅ ";
            margin-right: 10px;
        }
        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 8px;
        }
        .status-online {
            background: #28a745;
        }
        .status-offline {
            background: #dc3545;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            border-top: 1px solid #e9ecef;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Customization Examples</h1>
            <p>Laravel Node Notifier Desktop - Version 1.2.0</p>
        </div>

        <div class="content">
            <!-- Position Examples -->
            <div class="section">
                <h2>📍 Position Customization</h2>
                <p>Test different notification positions on your screen.</p>
                
                <div class="demo-grid">
                    <div class="demo-card">
                        <h3>Top Right</h3>
                        <p>Notification appears in the top-right corner</p>
                        <button class="btn" onclick="testPosition('top-right')">Test Top Right</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Top Left</h3>
                        <p>Notification appears in the top-left corner</p>
                        <button class="btn" onclick="testPosition('top-left')">Test Top Left</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Bottom Right (Default)</h3>
                        <p>Notification appears in the bottom-right corner</p>
                        <button class="btn" onclick="testPosition('bottom-right')">Test Bottom Right</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Bottom Left</h3>
                        <p>Notification appears in the bottom-left corner</p>
                        <button class="btn" onclick="testPosition('bottom-left')">Test Bottom Left</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Top Center</h3>
                        <p>Notification appears at the top center</p>
                        <button class="btn" onclick="testPosition('top-center')">Test Top Center</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Bottom Center</h3>
                        <p>Notification appears at the bottom center</p>
                        <button class="btn" onclick="testPosition('bottom-center')">Test Bottom Center</button>
                    </div>
                </div>
            </div>

            <!-- Theme Examples -->
            <div class="section">
                <h2>🎨 UI Theme Examples</h2>
                <p>Test different visual themes for notifications.</p>
                
                <div class="demo-grid">
                    <div class="demo-card">
                        <h3>Default Theme</h3>
                        <p>Clean and simple default appearance</p>
                        <button class="btn" onclick="testTheme('default')">Test Default</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Modern Theme</h3>
                        <p>Contemporary design with shadows</p>
                        <button class="btn" onclick="testTheme('modern')">Test Modern</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Dark Theme</h3>
                        <p>Dark mode for better visibility</p>
                        <button class="btn" onclick="testTheme('dark')">Test Dark</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Light Theme</h3>
                        <p>Light and airy appearance</p>
                        <button class="btn" onclick="testTheme('light')">Test Light</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Minimal Theme</h3>
                        <p>Minimalist design without distractions</p>
                        <button class="btn" onclick="testTheme('minimal')">Test Minimal</button>
                    </div>
                </div>
            </div>

            <!-- Animation Examples -->
            <div class="section">
                <h2>✨ Animation Examples</h2>
                <p>Test different animation effects for notifications.</p>
                
                <div class="demo-grid">
                    <div class="demo-card">
                        <h3>Slide Animation</h3>
                        <p>Smooth slide-in effect (default)</p>
                        <button class="btn" onclick="testAnimation('slide')">Test Slide</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Fade Animation</h3>
                        <p>Gentle fade-in effect</p>
                        <button class="btn" onclick="testAnimation('fade')">Test Fade</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Bounce Animation</h3>
                        <p>Playful bounce effect</p>
                        <button class="btn" onclick="testAnimation('bounce')">Test Bounce</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Zoom Animation</h3>
                        <p>Zoom-in effect for attention</p>
                        <button class="btn" onclick="testAnimation('zoom')">Test Zoom</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>No Animation</h3>
                        <p>Instant appearance without animation</p>
                        <button class="btn" onclick="testAnimation('none')">Test None</button>
                    </div>
                </div>
            </div>

            <!-- Size Examples -->
            <div class="section">
                <h2>📏 Size Examples</h2>
                <p>Test different notification sizes.</p>
                
                <div class="demo-grid">
                    <div class="demo-card">
                        <h3>Small Size</h3>
                        <p>Compact notification (280x80px)</p>
                        <button class="btn" onclick="testSize('small')">Test Small</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Medium Size</h3>
                        <p>Standard notification (350x100px)</p>
                        <button class="btn" onclick="testSize('medium')">Test Medium</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Large Size</h3>
                        <p>Large notification (420x120px)</p>
                        <button class="btn" onclick="testSize('large')">Test Large</button>
                    </div>
                </div>
            </div>

            <!-- Sound Examples -->
            <div class="section">
                <h2>🔊 Sound Examples</h2>
                <p>Test different sound options for notifications.</p>
                
                <div class="demo-grid">
                    <div class="demo-card">
                        <h3>Default Sound</h3>
                        <p>System default notification sound</p>
                        <button class="btn" onclick="testSound('default')">Test Default Sound</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Silent Notification</h3>
                        <p>Notification without any sound</p>
                        <button class="btn" onclick="testSound('silent')">Test Silent</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Custom Sound</h3>
                        <p>Custom sound file (if available)</p>
                        <button class="btn" onclick="testSound('custom')">Test Custom Sound</button>
                    </div>
                </div>
            </div>

            <!-- Combination Examples -->
            <div class="section">
                <h2>🎛️ Combination Examples</h2>
                <p>Test combinations of different customization features.</p>
                
                <div class="demo-grid">
                    <div class="demo-card">
                        <h3>Modern + Bounce + Top Right</h3>
                        <p>Modern theme with bounce animation</p>
                        <button class="btn" onclick="testCombination('modern-bounce')">Test Combination</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Dark + Fade + Top Center</h3>
                        <p>Dark theme with fade animation</p>
                        <button class="btn" onclick="testCombination('dark-fade')">Test Combination</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Light + Slide + Bottom Left</h3>
                        <p>Light theme with slide animation</p>
                        <button class="btn" onclick="testCombination('light-slide')">Test Combination</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Minimal + None + Bottom Center</h3>
                        <p>Minimal theme without animation</p>
                        <button class="btn" onclick="testCombination('minimal-none')">Test Combination</button>
                    </div>
                </div>
            </div>

            <!-- Notification Type Examples -->
            <div class="section">
                <h2>📝 Notification Type Examples</h2>
                <p>Test different notification types with customization.</p>
                
                <div class="demo-grid">
                    <div class="demo-card">
                        <h3>Success Notification</h3>
                        <p>Green success notification with modern theme</p>
                        <button class="btn btn-success" onclick="testNotificationType('success')">Test Success</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Error Notification</h3>
                        <p>Red error notification with dark theme</p>
                        <button class="btn btn-danger" onclick="testNotificationType('error')">Test Error</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Warning Notification</h3>
                        <p>Yellow warning notification with light theme</p>
                        <button class="btn btn-warning" onclick="testNotificationType('warning')">Test Warning</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Info Notification</h3>
                        <p>Blue info notification with minimal theme</p>
                        <button class="btn btn-info" onclick="testNotificationType('info')">Test Info</button>
                    </div>
                </div>
            </div>

            <!-- Real-time Examples -->
            <div class="section">
                <h2>⚡ Real-time Examples</h2>
                <p>Simulate real-world notification scenarios.</p>
                
                <div class="demo-grid">
                    <div class="demo-card">
                        <h3>Chat Message</h3>
                        <p>Simulate incoming chat message</p>
                        <button class="btn" onclick="simulateChat()">Simulate Chat</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Email Notification</h3>
                        <p>Simulate new email arrival</p>
                        <button class="btn" onclick="simulateEmail()">Simulate Email</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>System Update</h3>
                        <p>Simulate system update notification</p>
                        <button class="btn" onclick="simulateSystemUpdate()">Simulate Update</button>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Security Alert</h3>
                        <p>Simulate security alert notification</p>
                        <button class="btn btn-danger" onclick="simulateSecurityAlert()">Simulate Alert</button>
                    </div>
                </div>
            </div>

            <!-- Code Examples -->
            <div class="section">
                <h2>💻 Code Examples</h2>
                <p>Copy and paste these code examples into your Laravel application.</p>
                
                <div class="demo-grid">
                    <div class="demo-card">
                        <h3>Basic Usage</h3>
                        <div class="code-block">
// Basic notification
DesktopNotifier::notify('Title', 'Message');

// With customization
DesktopNotifier::notify('Title', 'Message', [
    'ui_theme' => 'modern',
    'position' => 'top-right',
    'animation' => 'bounce'
]);
                        </div>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Method Chaining</h3>
                        <div class="code-block">
// Position method
DesktopNotifier::notifyAtPosition('Title', 'Message', 'top-right');

// Theme method
DesktopNotifier::notifyWithTheme('Title', 'Message', 'dark');

// Animation method
DesktopNotifier::notifyWithAnimation('Title', 'Message', 'bounce');
                        </div>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Notification Types</h3>
                        <div class="code-block">
// Success notification
DesktopNotifier::success('Success!', 'Operation completed');

// Error notification
DesktopNotifier::error('Error!', 'Something went wrong');

// Warning notification
DesktopNotifier::warning('Warning!', 'Please check this');

// Info notification
DesktopNotifier::info('Info', 'Important information');
                        </div>
                    </div>
                    
                    <div class="demo-card">
                        <h3>Advanced Customization</h3>
                        <div class="code-block">
DesktopNotifier::notify('Title', 'Message', [
    'ui_theme' => 'dark',
    'position' => 'top-center',
    'animation' => 'bounce',
    'animation_duration' => 500,
    'size' => 'large',
    'custom_sound_file' => '/path/to/sound.wav',
    'timeout' => 5000
]);
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>&copy; 2024 Laravel Node Notifier Desktop. All rights reserved.</p>
            <p>Version 1.2.0 - Customization Release</p>
        </div>
    </div>

    <script>
        // Function to make AJAX calls to test notifications
        function makeNotificationRequest(data) {
            fetch('/test-notification', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                console.log('Notification sent:', data);
            })
            .catch(error => {
                console.error('Error sending notification:', error);
            });
        }

        // Position test functions
        function testPosition(position) {
            makeNotificationRequest({
                title: 'Position Test',
                message: `Testing ${position} position`,
                position: position,
                ui_theme: 'default',
                animation: 'slide',
                size: 'medium'
            });
        }

        // Theme test functions
        function testTheme(theme) {
            makeNotificationRequest({
                title: 'Theme Test',
                message: `Testing ${theme} theme`,
                position: 'bottom-right',
                ui_theme: theme,
                animation: 'slide',
                size: 'medium'
            });
        }

        // Animation test functions
        function testAnimation(animation) {
            makeNotificationRequest({
                title: 'Animation Test',
                message: `Testing ${animation} animation`,
                position: 'bottom-right',
                ui_theme: 'default',
                animation: animation,
                size: 'medium'
            });
        }

        // Size test functions
        function testSize(size) {
            makeNotificationRequest({
                title: 'Size Test',
                message: `Testing ${size} size`,
                position: 'bottom-right',
                ui_theme: 'default',
                animation: 'slide',
                size: size
            });
        }

        // Sound test functions
        function testSound(sound) {
            let data = {
                title: 'Sound Test',
                message: `Testing ${sound} sound`,
                position: 'bottom-right',
                ui_theme: 'default',
                animation: 'slide',
                size: 'medium'
            };

            if (sound === 'silent') {
                data.sound = false;
            } else if (sound === 'custom') {
                data.custom_sound_file = '/path/to/custom-sound.wav';
            }

            makeNotificationRequest(data);
        }

        // Combination test functions
        function testCombination(combination) {
            let data = {
                title: 'Combination Test',
                message: `Testing ${combination} combination`,
                size: 'medium'
            };

            switch (combination) {
                case 'modern-bounce':
                    data.ui_theme = 'modern';
                    data.animation = 'bounce';
                    data.position = 'top-right';
                    break;
                case 'dark-fade':
                    data.ui_theme = 'dark';
                    data.animation = 'fade';
                    data.position = 'top-center';
                    break;
                case 'light-slide':
                    data.ui_theme = 'light';
                    data.animation = 'slide';
                    data.position = 'bottom-left';
                    break;
                case 'minimal-none':
                    data.ui_theme = 'minimal';
                    data.animation = 'none';
                    data.position = 'bottom-center';
                    break;
            }

            makeNotificationRequest(data);
        }

        // Notification type test functions
        function testNotificationType(type) {
            let data = {
                title: `${type.charAt(0).toUpperCase() + type.slice(1)} Test`,
                message: `This is a ${type} notification`,
                position: 'bottom-right',
                animation: 'slide',
                size: 'medium'
            };

            switch (type) {
                case 'success':
                    data.ui_theme = 'modern';
                    break;
                case 'error':
                    data.ui_theme = 'dark';
                    data.position = 'top-center';
                    data.animation = 'bounce';
                    data.size = 'large';
                    break;
                case 'warning':
                    data.ui_theme = 'light';
                    data.position = 'bottom-center';
                    data.size = 'large';
                    break;
                case 'info':
                    data.ui_theme = 'minimal';
                    data.position = 'top-left';
                    data.animation = 'fade';
                    break;
            }

            makeNotificationRequest(data);
        }

        // Real-time simulation functions
        function simulateChat() {
            makeNotificationRequest({
                title: 'New Message from John',
                message: 'Hey! How are you doing?',
                ui_theme: 'modern',
                position: 'top-right',
                animation: 'slide',
                timeout: 3000
            });
        }

        function simulateEmail() {
            makeNotificationRequest({
                title: 'New Email from noreply@example.com',
                message: 'Your order has been confirmed',
                ui_theme: 'light',
                position: 'top-center',
                animation: 'bounce',
                timeout: 4000
            });
        }

        function simulateSystemUpdate() {
            makeNotificationRequest({
                title: 'System Update',
                message: 'System is updating... Please wait',
                ui_theme: 'dark',
                position: 'bottom-right',
                animation: 'fade',
                size: 'small',
                timeout: 2000
            });
        }

        function simulateSecurityAlert() {
            makeNotificationRequest({
                title: 'Security Alert',
                message: 'Suspicious activity detected on your account',
                ui_theme: 'dark',
                position: 'top-center',
                animation: 'bounce',
                size: 'large',
                timeout: 8000
            });
        }
    </script>
</body>
</html> 