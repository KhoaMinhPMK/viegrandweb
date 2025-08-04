<?php
/**
 * VieGrand Database Setup Wizard
 * 
 * This file helps you configure your database settings for both local and live environments
 */

// Check if this is a POST request to save settings
if ($_POST && isset($_POST['action']) && $_POST['action'] === 'save_config') {
    $success = false;
    $message = '';
    
    try {
        // Get the submitted values
        $local_host = $_POST['local_host'] ?? 'localhost';
        $live_host = $_POST['live_host'] ?? 'viegrand.site';
        $database = $_POST['database'] ?? 'viegrand_admin';
        $username = $_POST['username'] ?? 'root';
        $password = $_POST['password'] ?? '';
        
        // Test the connection first
        $currentHost = (in_array($_SERVER['SERVER_NAME'] ?? 'localhost', ['localhost', '127.0.0.1', '::1'])) ? $local_host : $live_host;
        
        $dsn = "mysql:host=$currentHost;dbname=$database;charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        
        // Connection successful, now update the config file
        $configContent = file_get_contents('config.php');
        
        // Update the getHost method to use submitted hosts
        $newGetHost = "    public static function getHost() {
        // Check if we're running locally
        \$serverName = \$_SERVER['SERVER_NAME'] ?? \$_SERVER['HTTP_HOST'] ?? 'localhost';
        
        if (in_array(\$serverName, ['localhost', '127.0.0.1', '::1']) || 
            strpos(\$serverName, 'localhost') !== false) {
            return '$local_host'; // Local development
        } else {
            return '$live_host'; // Live server
        }
    }";
        
        // Replace database settings
        $configContent = preg_replace(
            '/public static \$database = \'[^\']*\';/',
            "public static \$database = '$database';",
            $configContent
        );
        
        $configContent = preg_replace(
            '/public static \$username = \'[^\']*\';/',
            "public static \$username = '$username';",
            $configContent
        );
        
        $configContent = preg_replace(
            '/public static \$password = \'[^\']*\';/',
            "public static \$password = '$password';",
            $configContent
        );
        
        // Write back to file
        file_put_contents('config.php', $configContent);
        
        $success = true;
        $message = "Cấu hình đã được lưu thành công!";
        
    } catch (Exception $e) {
        $message = "Lỗi: " . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VieGrand - Database Setup</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #004aad 0%, #0066ff 100%);
            min-height: 100vh;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        h1 {
            color: #004aad;
            margin-bottom: 10px;
        }
        
        .info-box {
            background: #e8f4fd;
            border: 1px solid #004aad;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .info-box h3 {
            margin-top: 0;
            color: #004aad;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }
        
        input, select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        input:focus, select:focus {
            outline: none;
            border-color: #004aad;
        }
        
        .btn {
            background: linear-gradient(135deg, #004aad 0%, #0066ff 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            margin: 5px;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .btn.secondary {
            background: #6c757d;
        }
        
        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
        }
        
        .result.success {
            background: #f0fff4;
            border: 2px solid #22c55e;
            color: #065f46;
        }
        
        .result.error {
            background: #fef2f2;
            border: 2px solid #ef4444;
            color: #991b1b;
        }
        
        .current-config {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            font-family: monospace;
        }
        
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }
        
        .actions {
            text-align: center;
            margin-top: 30px;
        }
        
        .actions a {
            color: #004aad;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 500;
        }
        
        .actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔧 VieGrand Database Setup</h1>
            <p>Cấu hình kết nối database cho môi trường local và live</p>
        </div>
        
        <?php if (isset($success) && isset($message)): ?>
            <div class="result <?= $success ? 'success' : 'error' ?>">
                <?= $success ? '✅' : '❌' ?> <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        
        <div class="info-box">
            <h3>📍 Thông tin hiện tại</h3>
            <div class="current-config">
Environment: <?= (in_array($_SERVER['SERVER_NAME'] ?? 'localhost', ['localhost', '127.0.0.1', '::1'])) ? 'LOCAL' : 'LIVE' ?><br>
Server: <?= $_SERVER['SERVER_NAME'] ?? 'unknown' ?><br>
Document Root: <?= $_SERVER['DOCUMENT_ROOT'] ?? 'unknown' ?><br>
Current Path: <?= __DIR__ ?>
            </div>
        </div>
        
        <form method="POST" id="configForm">
            <input type="hidden" name="action" value="save_config">
            
            <div class="grid">
                <div>
                    <h3>🏠 Môi trường Local (localhost)</h3>
                    <div class="form-group">
                        <label for="local_host">Database Host (Local):</label>
                        <input type="text" id="local_host" name="local_host" value="localhost" required>
                    </div>
                </div>
                
                <div>
                    <h3>🌐 Môi trường Live (viegrand.site)</h3>
                    <div class="form-group">
                        <label for="live_host">Database Host (Live):</label>
                        <input type="text" id="live_host" name="live_host" value="viegrand.site" required>
                    </div>
                </div>
            </div>
            
            <div class="grid">
                <div class="form-group">
                    <label for="database">Database Name:</label>
                    <input type="text" id="database" name="database" value="viegrand_admin" required>
                </div>
                
                <div class="form-group">
                    <label for="username">Database Username:</label>
                    <input type="text" id="username" name="username" value="root" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="password">Database Password:</label>
                <input type="password" id="password" name="password" value="" placeholder="Để trống nếu không có password">
            </div>
            
            <div style="text-align: center;">
                <button type="button" onclick="testConnection()" class="btn secondary">🧪 Test Connection</button>
                <button type="submit" class="btn">💾 Lưu Cấu Hình</button>
            </div>
        </form>
        
        <div id="testResult" class="result" style="display: none;"></div>
        
        <div class="actions">
            <a href="status.php">📊 System Status</a>
            <a href="quick_test.php">🚀 Quick Test</a>
            <a href="admin.php">👨‍💼 Admin Panel</a>
        </div>
    </div>

    <script>
        async function testConnection() {
            const resultDiv = document.getElementById('testResult');
            const formData = new FormData(document.getElementById('configForm'));
            formData.set('action', 'test_connection');
            
            resultDiv.style.display = 'block';
            resultDiv.className = 'result';
            resultDiv.innerHTML = '⏳ Đang test kết nối...';
            
            try {
                const response = await fetch('config_test.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    resultDiv.className = 'result success';
                    resultDiv.innerHTML = `✅ Kết nối thành công!<br><small>${result.message}</small>`;
                } else {
                    resultDiv.className = 'result error';
                    resultDiv.innerHTML = `❌ Kết nối thất bại!<br><small>${result.message}</small>`;
                }
            } catch (error) {
                resultDiv.className = 'result error';
                resultDiv.innerHTML = `💥 Lỗi: ${error.message}`;
            }
        }
    </script>
</body>
</html>
