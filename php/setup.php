<?php
/**
 * VieGrand Contact Form Setup Script
 * 
 * Run this script to set up your database and test the contact form system
 */

require_once 'config.php';

header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VieGrand Setup - Cài đặt hệ thống liên hệ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #004aad 0%, #0066ff 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 300;
        }
        
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 1.1rem;
        }
        
        .content {
            padding: 30px;
        }
        
        .step {
            background: #f8f9fa;
            border-left: 4px solid #004aad;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 10px 10px 0;
        }
        
        .step h3 {
            color: #004aad;
            margin: 0 0 15px 0;
            font-size: 1.3rem;
        }
        
        .step-number {
            background: #004aad;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }
        
        .success {
            background: #d4edda;
            border-color: #28a745;
            color: #155724;
        }
        
        .error {
            background: #f8d7da;
            border-color: #dc3545;
            color: #721c24;
        }
        
        .warning {
            background: #fff3cd;
            border-color: #ffc107;
            color: #856404;
        }
        
        .code-block {
            background: #2d3748;
            color: #e2e8f0;
            padding: 20px;
            border-radius: 8px;
            margin: 15px 0;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            line-height: 1.5;
        }
        
        .btn {
            background: linear-gradient(135deg, #004aad 0%, #0066ff 100%);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin: 10px 10px 10px 0;
            cursor: pointer;
            font-size: 1rem;
            transition: transform 0.2s;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            color: #212529;
        }
        
        .test-results {
            margin: 20px 0;
        }
        
        .test-item {
            display: flex;
            align-items: center;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            background: #f8f9fa;
        }
        
        .test-item.pass {
            background: #d4edda;
            color: #155724;
        }
        
        .test-item.fail {
            background: #f8d7da;
            color: #721c24;
        }
        
        .test-item i {
            margin-right: 10px;
            width: 20px;
        }
        
        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            color: #666;
            border-top: 1px solid #e9ecef;
        }
        
        .links {
            margin: 20px 0;
        }
        
        .links a {
            margin: 0 10px;
            color: #004aad;
            text-decoration: none;
            font-weight: 500;
        }
        
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-cogs"></i> VieGrand Setup</h1>
            <p>Hướng dẫn cài đặt hệ thống liên hệ</p>
        </div>
        
        <div class="content">
            <div class="step">
                <h3><span class="step-number">1</span> Kiểm tra môi trường</h3>
                <div class="test-results">
                    <?php
                    $tests = [
                        'PHP Version >= 7.4' => version_compare(PHP_VERSION, '7.4.0', '>='),
                        'PDO Extension' => extension_loaded('pdo'),
                        'PDO MySQL Extension' => extension_loaded('pdo_mysql'),
                        'JSON Extension' => extension_loaded('json'),
                        'Session Support' => function_exists('session_start'),
                    ];
                    
                    foreach ($tests as $test => $result) {
                        $class = $result ? 'pass' : 'fail';
                        $icon = $result ? 'fa-check' : 'fa-times';
                        echo "<div class='test-item $class'>";
                        echo "<i class='fas $icon'></i>";
                        echo "$test: " . ($result ? 'OK' : 'FAIL');
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
            
            <div class="step">
                <h3><span class="step-number">2</span> Kiểm tra kết nối database</h3>
                <?php
                try {
                    $pdo = Database::connect();
                    echo "<div class='test-item pass'>";
                    echo "<i class='fas fa-check'></i>";
                    echo "Kết nối database thành công!";
                    echo "</div>";
                    
                    // Check if table exists
                    $stmt = $pdo->prepare("SHOW TABLES LIKE 'contact_messages'");
                    $stmt->execute();
                    $tableExists = $stmt->fetch();
                    
                    if ($tableExists) {
                        echo "<div class='test-item pass'>";
                        echo "<i class='fas fa-check'></i>";
                        echo "Bảng contact_messages đã tồn tại";
                        echo "</div>";
                    } else {
                        echo "<div class='test-item fail'>";
                        echo "<i class='fas fa-times'></i>";
                        echo "Bảng contact_messages chưa tồn tại";
                        echo "</div>";
                        
                        echo "<div class='warning step'>";
                        echo "<h4>Cần tạo bảng contact_messages:</h4>";
                        echo "<p>1. Mở phpMyAdmin</p>";
                        echo "<p>2. Chọn database 'viegrand_admin'</p>";
                        echo "<p>3. Chạy SQL sau:</p>";
                        echo "<div class='code-block'>";
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
                        echo "</div>";
                        echo "</div>";
                    }
                    
                } catch (Exception $e) {
                    echo "<div class='test-item fail'>";
                    echo "<i class='fas fa-times'></i>";
                    echo "Lỗi kết nối: " . htmlspecialchars($e->getMessage());
                    echo "</div>";
                    
                    echo "<div class='error step'>";
                    echo "<h4>Cách khắc phục:</h4>";
                    echo "<ul>";
                    echo "<li>Khởi động XAMPP/WAMP</li>";
                    echo "<li>Tạo database tên 'viegrand_admin'</li>";
                    echo "<li>Kiểm tra username/password trong config.php</li>";
                    echo "</ul>";
                    echo "</div>";
                }
                ?>
            </div>
            
            <div class="step">
                <h3><span class="step-number">3</span> Test API Endpoint</h3>
                <?php
                $apiUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/contact_form.php';
                echo "<p><strong>API URL:</strong> <a href='$apiUrl' target='_blank'>$apiUrl</a></p>";
                
                // Test if file exists
                $apiFile = dirname(__FILE__) . '/contact_form.php';
                if (file_exists($apiFile)) {
                    echo "<div class='test-item pass'>";
                    echo "<i class='fas fa-check'></i>";
                    echo "File contact_form.php tồn tại";
                    echo "</div>";
                } else {
                    echo "<div class='test-item fail'>";
                    echo "<i class='fas fa-times'></i>";
                    echo "File contact_form.php không tồn tại";
                    echo "</div>";
                }
                ?>
            </div>
            
            <div class="step">
                <h3><span class="step-number">4</span> Cấu hình form</h3>
                <p>Đảm bảo form contact trong website trỏ đúng đến API:</p>
                <div class="code-block">
fetch('../../../php/contact_form.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify(data)
});
                </div>
            </div>
            
            <div class="step success">
                <h3><span class="step-number">5</span> Hoàn thành!</h3>
                <p>Nếu tất cả các bước trên đều OK, hệ thống đã sẵn sàng hoạt động.</p>
                
                <div class="links">
                    <a href="test_db.php" class="btn">
                        <i class="fas fa-flask"></i> Test chi tiết
                    </a>
                    <a href="admin.php" class="btn btn-success">
                        <i class="fas fa-shield-alt"></i> Admin Panel
                    </a>
                    <a href="../scr/screen/home/index.html" class="btn btn-warning">
                        <i class="fas fa-home"></i> Về trang chủ
                    </a>
                </div>
            </div>
            
            <div class="step">
                <h3><i class="fas fa-lightbulb"></i> Lưu ý quan trọng</h3>
                <ul>
                    <li><strong>Bảo mật:</strong> Đổi mật khẩu admin mặc định trong admin.php</li>
                    <li><strong>Production:</strong> Tắt debug mode trong config.php khi deploy</li>
                    <li><strong>Email:</strong> Cấu hình SMTP để gửi email tự động (tùy chọn)</li>
                    <li><strong>Backup:</strong> Thường xuyên backup database</li>
                </ul>
            </div>
        </div>
        
        <div class="footer">
            <p><strong>VieGrand Contact System</strong> - Phát triển bởi nhóm học sinh THPT Nguyễn Hữu Huân</p>
            <p><i class="fas fa-envelope"></i> viegrand.contact@gmail.com</p>
        </div>
    </div>
</body>
</html>
