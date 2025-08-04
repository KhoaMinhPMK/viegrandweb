<?php
/**
 * VieGrand Contact Form Status Checker
 * 
 * Check the current status of your contact form system
 */

require_once 'config.php';

header('Content-Type: text/html; charset=UTF-8');

function checkFileExists($file) {
    return file_exists($file) ? '✅' : '❌';
}

function formatBytes($size, $precision = 2) {
    $base = log($size, 1024);
    $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');
    return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VieGrand Contact Form Status</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f5f7fa;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .header {
            background: linear-gradient(135deg, #004aad 0%, #0066ff 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .card h3 {
            margin-top: 0;
            color: #333;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }
        
        .status-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .status-item {
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #ddd;
        }
        
        .status-item.good {
            background: #f0fff4;
            border-color: #22c55e;
        }
        
        .status-item.bad {
            background: #fef2f2;
            border-color: #ef4444;
        }
        
        .status-item.warning {
            background: #fffbeb;
            border-color: #f59e0b;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background: #f8f9fa;
        }
        
        .log-content {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 12px;
            max-height: 300px;
            overflow-y: auto;
            white-space: pre-wrap;
        }
        
        .btn {
            background: #004aad;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
        }
        
        .btn:hover {
            background: #0066ff;
        }
        
        .recent-messages {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔍 VieGrand Contact Form Status</h1>
            <p>Trạng thái hiện tại của hệ thống - <?= date('d/m/Y H:i:s') ?></p>
        </div>
        
        <!-- File Status -->
        <div class="card">
            <h3>📁 Trạng thái File</h3>
            <div class="status-grid">
                <div class="status-item <?= file_exists('config.php') ? 'good' : 'bad' ?>">
                    <?= checkFileExists('config.php') ?> <strong>config.php</strong><br>
                    <small><?= file_exists('config.php') ? formatBytes(filesize('config.php')) : 'Không tồn tại' ?></small>
                </div>
                
                <div class="status-item <?= file_exists('ContactMessage.php') ? 'good' : 'bad' ?>">
                    <?= checkFileExists('ContactMessage.php') ?> <strong>ContactMessage.php</strong><br>
                    <small><?= file_exists('ContactMessage.php') ? formatBytes(filesize('ContactMessage.php')) : 'Không tồn tại' ?></small>
                </div>
                
                <div class="status-item <?= file_exists('contact_form.php') ? 'good' : 'bad' ?>">
                    <?= checkFileExists('contact_form.php') ?> <strong>contact_form.php</strong><br>
                    <small><?= file_exists('contact_form.php') ? formatBytes(filesize('contact_form.php')) : 'Không tồn tại' ?></small>
                </div>
                
                <div class="status-item <?= file_exists('contact_form_debug.php') ? 'good' : 'bad' ?>">
                    <?= checkFileExists('contact_form_debug.php') ?> <strong>contact_form_debug.php</strong><br>
                    <small><?= file_exists('contact_form_debug.php') ? formatBytes(filesize('contact_form_debug.php')) : 'Không tồn tại' ?></small>
                </div>
            </div>
        </div>
        
        <!-- Database Status -->
        <div class="card">
            <h3>🗄️ Trạng thái Database</h3>
            <?php
            try {
                $pdo = Database::connect();
                echo "<div class='status-item good'>";
                echo "✅ <strong>Kết nối database thành công</strong><br>";
                
                // Check table
                $stmt = $pdo->prepare("SHOW TABLES LIKE 'contact_messages'");
                $stmt->execute();
                $tableExists = $stmt->fetch();
                
                if ($tableExists) {
                    echo "✅ Bảng contact_messages tồn tại<br>";
                    
                    // Get table info
                    $stmt = $pdo->query("SELECT COUNT(*) as total FROM contact_messages");
                    $count = $stmt->fetch();
                    
                    $stmt = $pdo->query("SELECT COUNT(*) as unread FROM contact_messages WHERE status = 'unread'");
                    $unread = $stmt->fetch();
                    
                    echo "<small>Tổng tin nhắn: {$count['total']}, Chưa đọc: {$unread['unread']}</small>";
                } else {
                    echo "❌ Bảng contact_messages không tồn tại";
                }
                echo "</div>";
                
            } catch (Exception $e) {
                echo "<div class='status-item bad'>";
                echo "❌ <strong>Lỗi database:</strong> " . htmlspecialchars($e->getMessage());
                echo "</div>";
            }
            ?>
        </div>
        
        <!-- Recent Messages -->
        <div class="card">
            <h3>📧 Tin nhắn gần đây</h3>
            <div class="recent-messages">
                <?php
                try {
                    require_once 'ContactMessage.php';
                    $contactMessage = new ContactMessage();
                    $messages = $contactMessage->getMessages(null, 10, 0);
                    
                    if (empty($messages)) {
                        echo "<p>Chưa có tin nhắn nào.</p>";
                    } else {
                        echo "<table>";
                        echo "<tr><th>ID</th><th>Tên</th><th>Email</th><th>Chủ đề</th><th>Trạng thái</th><th>Thời gian</th></tr>";
                        foreach ($messages as $msg) {
                            $statusColor = $msg['status'] === 'unread' ? '#f59e0b' : 
                                          ($msg['status'] === 'read' ? '#3b82f6' : '#22c55e');
                            echo "<tr>";
                            echo "<td>{$msg['id']}</td>";
                            echo "<td>" . htmlspecialchars($msg['full_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($msg['email']) . "</td>";
                            echo "<td>" . htmlspecialchars(substr($msg['subject'], 0, 30)) . "...</td>";
                            echo "<td style='color: $statusColor'>{$msg['status']}</td>";
                            echo "<td>" . date('d/m H:i', strtotime($msg['created_at'])) . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    }
                } catch (Exception $e) {
                    echo "<p>Lỗi: " . htmlspecialchars($e->getMessage()) . "</p>";
                }
                ?>
            </div>
        </div>
        
        <!-- Debug Log -->
        <div class="card">
            <h3>🐛 Debug Log</h3>
            <?php
            $logFile = 'contact_debug.log';
            if (file_exists($logFile)) {
                $logContent = file_get_contents($logFile);
                $lines = explode("\n", $logContent);
                $recentLines = array_slice($lines, -50); // Last 50 lines
                
                echo "<div class='log-content'>";
                echo htmlspecialchars(implode("\n", $recentLines));
                echo "</div>";
                
                echo "<p><small>File size: " . formatBytes(filesize($logFile)) . "</small></p>";
            } else {
                echo "<p>Chưa có log file. Log sẽ được tạo khi có request đến API debug.</p>";
            }
            ?>
        </div>
        
        <!-- Actions -->
        <div class="card">
            <h3>🔧 Hành động</h3>
            <a href="test_form.html" class="btn">Test Form</a>
            <a href="admin.php" class="btn">Admin Panel</a>
            <a href="setup.php" class="btn">Setup</a>
            <a href="../scr/screen/home/index.html" class="btn">Trang chủ</a>
            
            <?php if (file_exists('contact_debug.log')): ?>
                <a href="?clear_log=1" class="btn" onclick="return confirm('Xóa debug log?')">Xóa Log</a>
            <?php endif; ?>
        </div>
    </div>

    <?php
    // Handle log clearing
    if (isset($_GET['clear_log']) && file_exists('contact_debug.log')) {
        unlink('contact_debug.log');
        echo "<script>alert('Log đã được xóa!'); window.location.href = 'status.php';</script>";
    }
    ?>
</body>
</html>
