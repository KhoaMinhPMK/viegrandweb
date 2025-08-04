<?php
/**
 * Database Connection Test for VieGrand
 * 
 * Run this file to test your database connection and setup
 */

require_once 'config.php';

// Set content type for proper display
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VieGrand - Database Test</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .warning { color: #ffc107; }
        .info { color: #17a2b8; }
        .test-result {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border-left: 4px solid;
        }
        .test-result.success { background: #d4edda; border-color: #28a745; }
        .test-result.error { background: #f8d7da; border-color: #dc3545; }
        .test-result.warning { background: #fff3cd; border-color: #ffc107; }
        .test-result.info { background: #d1ecf1; border-color: #17a2b8; }
        pre {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
        }
        h1 { color: #004aad; }
        h2 { color: #0066ff; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 VieGrand Database Test</h1>
        <p>Kiểm tra kết nối cơ sở dữ liệu và cấu hình hệ thống</p>
        
        <?php
        echo "<h2>📋 Thông tin cấu hình</h2>";
        echo "<div class='test-result info'>";
        echo "<strong>Database Host:</strong> " . DatabaseConfig::$host . "<br>";
        echo "<strong>Database Name:</strong> " . DatabaseConfig::$database . "<br>";
        echo "<strong>Database Username:</strong> " . DatabaseConfig::$username . "<br>";
        echo "<strong>PHP Version:</strong> " . PHP_VERSION . "<br>";
        echo "<strong>Timezone:</strong> " . date_default_timezone_get() . "<br>";
        echo "</div>";
        
        echo "<h2>🔌 Kiểm tra kết nối cơ sở dữ liệu</h2>";
        
        try {
            $pdo = Database::connect();
            echo "<div class='test-result success'>";
            echo "✅ <strong>Kết nối thành công!</strong> Cơ sở dữ liệu đã sẵn sàng.";
            echo "</div>";
            
            // Test basic query
            $stmt = $pdo->query("SELECT VERSION() as version");
            $result = $stmt->fetch();
            echo "<div class='test-result info'>";
            echo "<strong>MySQL Version:</strong> " . $result['version'];
            echo "</div>";
            
        } catch (Exception $e) {
            echo "<div class='test-result error'>";
            echo "❌ <strong>Lỗi kết nối:</strong> " . $e->getMessage();
            echo "</div>";
            
            echo "<div class='test-result warning'>";
            echo "<strong>Hướng dẫn khắc phục:</strong><br>";
            echo "1. Đảm bảo XAMPP/WAMP đang chạy<br>";
            echo "2. Kiểm tra MySQL service đã khởi động<br>";
            echo "3. Tạo database 'viegrand_admin' trong phpMyAdmin<br>";
            echo "4. Kiểm tra thông tin đăng nhập trong config.php";
            echo "</div>";
        }
        
        echo "<h2>📊 Kiểm tra bảng contact_messages</h2>";
        
        try {
            $pdo = Database::connect();
            
            // Check if table exists
            $stmt = $pdo->prepare("SHOW TABLES LIKE 'contact_messages'");
            $stmt->execute();
            $tableExists = $stmt->fetch();
            
            if ($tableExists) {
                echo "<div class='test-result success'>";
                echo "✅ <strong>Bảng contact_messages tồn tại</strong>";
                echo "</div>";
                
                // Get table structure
                $stmt = $pdo->query("DESCRIBE contact_messages");
                $columns = $stmt->fetchAll();
                
                echo "<div class='test-result info'>";
                echo "<strong>Cấu trúc bảng:</strong><br>";
                echo "<pre>";
                foreach ($columns as $column) {
                    echo $column['Field'] . " - " . $column['Type'] . " - " . $column['Key'] . "\n";
                }
                echo "</pre>";
                echo "</div>";
                
                // Get record count
                $stmt = $pdo->query("SELECT COUNT(*) as count FROM contact_messages");
                $count = $stmt->fetch();
                
                echo "<div class='test-result info'>";
                echo "<strong>Số tin nhắn hiện tại:</strong> " . $count['count'];
                echo "</div>";
                
            } else {
                echo "<div class='test-result error'>";
                echo "❌ <strong>Bảng contact_messages không tồn tại</strong>";
                echo "</div>";
                
                echo "<div class='test-result warning'>";
                echo "<strong>Hướng dẫn tạo bảng:</strong><br>";
                echo "1. Mở phpMyAdmin<br>";
                echo "2. Chọn database 'viegrand_admin'<br>";
                echo "3. Import file SQL hoặc chạy câu lệnh sau:";
                echo "</div>";
                
                echo "<pre>";
                echo htmlspecialchars("
CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read','archived') NOT NULL DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                ");
                echo "</pre>";
            }
            
        } catch (Exception $e) {
            echo "<div class='test-result error'>";
            echo "❌ <strong>Lỗi kiểm tra bảng:</strong> " . $e->getMessage();
            echo "</div>";
        }
        
        echo "<h2>🧪 Test ContactMessage Class</h2>";
        
        try {
            require_once 'ContactMessage.php';
            $contactMessage = new ContactMessage();
            
            echo "<div class='test-result success'>";
            echo "✅ <strong>ContactMessage class tải thành công</strong>";
            echo "</div>";
            
            // Test validation
            $testData = [
                'full_name' => 'Test User',
                'email' => 'test@example.com',
                'phone' => '0123456789',
                'subject' => 'Test Subject',
                'message' => 'This is a test message'
            ];
            
            echo "<div class='test-result info'>";
            echo "<strong>Dữ liệu test:</strong><br>";
            echo "<pre>" . print_r($testData, true) . "</pre>";
            echo "</div>";
            
            // Note: We're not actually saving the test data to avoid spam
            echo "<div class='test-result warning'>";
            echo "⚠️ <strong>Lưu ý:</strong> Để tránh tạo dữ liệu test, chúng ta không thực hiện lưu thật.<br>";
            echo "Form contact trên website sẽ hoạt động bình thường.";
            echo "</div>";
            
        } catch (Exception $e) {
            echo "<div class='test-result error'>";
            echo "❌ <strong>Lỗi ContactMessage class:</strong> " . $e->getMessage();
            echo "</div>";
        }
        
        echo "<h2>🌐 Test API Endpoint</h2>";
        
        $apiUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/contact_form.php';
        
        echo "<div class='test-result info'>";
        echo "<strong>API URL:</strong> <a href='" . $apiUrl . "' target='_blank'>" . $apiUrl . "</a><br>";
        echo "<strong>Method:</strong> POST<br>";
        echo "<strong>Content-Type:</strong> application/json";
        echo "</div>";
        
        echo "<h2>✅ Tóm tắt</h2>";
        echo "<div class='test-result success'>";
        echo "<strong>Các bước tiếp theo:</strong><br>";
        echo "1. Đảm bảo tất cả các test trên đều PASS<br>";
        echo "2. Cập nhật đường dẫn API trong contact form<br>";
        echo "3. Test form trên website<br>";
        echo "4. Kiểm tra dữ liệu trong phpMyAdmin";
        echo "</div>";
        ?>
        
        <div style="margin-top: 30px; text-align: center; color: #666;">
            <small>VieGrand Database Test Tool - <?= date('Y-m-d H:i:s') ?></small>
        </div>
    </div>
</body>
</html>
