<?php
/**
 * Simple Admin Panel for VieGrand Contact Messages
 * 
 * View and manage contact form submissions
 */

require_once 'config.php';
require_once 'ContactMessage.php';

// Simple authentication (you should improve this for production)
session_start();
$admin_password = 'viegrand2025'; // Change this password!

if (isset($_POST['login'])) {
    if ($_POST['password'] === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        $login_error = 'Mật khẩu không đúng!';
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit();
}

// Handle status updates
if (isset($_POST['update_status']) && isset($_SESSION['admin_logged_in'])) {
    $contactMessage = new ContactMessage();
    $result = $contactMessage->updateStatus($_POST['message_id'], $_POST['new_status']);
    $update_message = $result ? 'Cập nhật trạng thái thành công!' : 'Lỗi cập nhật trạng thái!';
}

// Handle message deletion
if (isset($_POST['delete_message']) && isset($_SESSION['admin_logged_in'])) {
    $contactMessage = new ContactMessage();
    $result = $contactMessage->deleteMessage($_POST['message_id']);
    $delete_message = $result ? 'Xóa tin nhắn thành công!' : 'Lỗi xóa tin nhắn!';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VieGrand Admin - Quản lý tin nhắn</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #333;
        }
        
        .header {
            background: linear-gradient(135deg, #004aad 0%, #0066ff 100%);
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header h1 {
            margin: 0;
            font-size: 1.8rem;
        }
        
        .header .subtitle {
            opacity: 0.9;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }
        
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .login-form {
            max-width: 400px;
            margin: 4rem auto;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .login-form h2 {
            text-align: center;
            color: #004aad;
            margin-bottom: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e1e5e9;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #004aad;
        }
        
        .btn {
            background: linear-gradient(135deg, #004aad 0%, #0066ff 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: transform 0.2s;
        }
        
        .btn:hover {
            transform: translateY(-1px);
        }
        
        .btn-full {
            width: 100%;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            text-align: center;
        }
        
        .stat-card .number {
            font-size: 2rem;
            font-weight: bold;
            color: #004aad;
            margin-bottom: 0.5rem;
        }
        
        .stat-card .label {
            color: #666;
            font-size: 0.9rem;
        }
        
        .messages-table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .table-header {
            background: #f8f9fa;
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
        }
        
        .table-header h3 {
            margin: 0;
            color: #333;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #f1f3f4;
        }
        
        th {
            background: #f8f9fa;
            font-weight: 600;
            color: #555;
        }
        
        tr:hover {
            background: #f8f9fa;
        }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status-unread {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-read {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .status-archived {
            background: #d4edda;
            color: #155724;
        }
        
        .actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }
        
        .btn-success {
            background: #28a745;
        }
        
        .btn-warning {
            background: #ffc107;
            color: #212529;
        }
        
        .btn-danger {
            background: #dc3545;
        }
        
        .message-preview {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 0.75rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            padding: 0.75rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        
        .logout-btn {
            float: right;
            background: rgba(255,255,255,0.2);
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .no-messages {
            text-align: center;
            padding: 3rem;
            color: #666;
        }
        
        .no-messages i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 0 0.5rem;
            }
            
            .header {
                padding: 1rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            table {
                font-size: 0.9rem;
            }
            
            th, td {
                padding: 0.5rem;
            }
            
            .actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-shield-alt"></i> VieGrand Admin Panel</h1>
        <div class="subtitle">Quản lý tin nhắn từ khách hàng</div>
        <?php if (isset($_SESSION['admin_logged_in'])): ?>
            <a href="?logout=1" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Đăng xuất
            </a>
        <?php endif; ?>
    </div>

    <?php if (!isset($_SESSION['admin_logged_in'])): ?>
        <!-- Login Form -->
        <div class="login-form">
            <h2><i class="fas fa-lock"></i> Đăng nhập Admin</h2>
            
            <?php if (isset($login_error)): ?>
                <div class="error">
                    <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($login_error) ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" name="login" class="btn btn-full">
                    <i class="fas fa-sign-in-alt"></i> Đăng nhập
                </button>
            </form>
            
            <div style="margin-top: 1rem; text-align: center; color: #666; font-size: 0.9rem;">
                <i class="fas fa-info-circle"></i> Mật khẩu mặc định: viegrand2025
            </div>
        </div>
    <?php else: ?>
        <!-- Admin Dashboard -->
        <div class="container">
            <?php
            if (isset($update_message)) {
                echo "<div class='success'><i class='fas fa-check'></i> $update_message</div>";
            }
            if (isset($delete_message)) {
                echo "<div class='success'><i class='fas fa-check'></i> $delete_message</div>";
            }
            
            try {
                $contactMessage = new ContactMessage();
                $counts = $contactMessage->getMessageCount();
                $messages = $contactMessage->getMessages(null, 50, 0);
            ?>
            
            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="number"><?= $counts['unread'] ?></div>
                    <div class="label"><i class="fas fa-envelope"></i> Tin nhắn mới</div>
                </div>
                <div class="stat-card">
                    <div class="number"><?= $counts['read'] ?></div>
                    <div class="label"><i class="fas fa-envelope-open"></i> Đã đọc</div>
                </div>
                <div class="stat-card">
                    <div class="number"><?= $counts['archived'] ?></div>
                    <div class="label"><i class="fas fa-archive"></i> Đã lưu trữ</div>
                </div>
                <div class="stat-card">
                    <div class="number"><?= array_sum($counts) ?></div>
                    <div class="label"><i class="fas fa-list"></i> Tổng cộng</div>
                </div>
            </div>

            <!-- Messages Table -->
            <div class="messages-table">
                <div class="table-header">
                    <h3><i class="fas fa-comments"></i> Danh sách tin nhắn</h3>
                </div>
                
                <?php if (empty($messages)): ?>
                    <div class="no-messages">
                        <i class="fas fa-inbox"></i>
                        <h3>Chưa có tin nhắn nào</h3>
                        <p>Khi khách hàng gửi tin nhắn qua form liên hệ, chúng sẽ hiển thị ở đây.</p>
                    </div>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Chủ đề</th>
                                <th>Tin nhắn</th>
                                <th>Trạng thái</th>
                                <th>Ngày gửi</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $message): ?>
                                <tr>
                                    <td><?= $message['id'] ?></td>
                                    <td><?= htmlspecialchars($message['full_name']) ?></td>
                                    <td>
                                        <a href="mailto:<?= htmlspecialchars($message['email']) ?>">
                                            <?= htmlspecialchars($message['email']) ?>
                                        </a>
                                    </td>
                                    <td><?= htmlspecialchars($message['subject']) ?></td>
                                    <td class="message-preview" title="<?= htmlspecialchars($message['message']) ?>">
                                        <?= htmlspecialchars(substr($message['message'], 0, 50)) ?>...
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?= $message['status'] ?>">
                                            <?= $message['status'] === 'unread' ? 'Chưa đọc' : 
                                                ($message['status'] === 'read' ? 'Đã đọc' : 'Lưu trữ') ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($message['created_at'])) ?></td>
                                    <td>
                                        <div class="actions">
                                            <?php if ($message['status'] === 'unread'): ?>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="message_id" value="<?= $message['id'] ?>">
                                                    <input type="hidden" name="new_status" value="read">
                                                    <button type="submit" name="update_status" class="btn btn-sm btn-success" title="Đánh dấu đã đọc">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            
                                            <?php if ($message['status'] !== 'archived'): ?>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="message_id" value="<?= $message['id'] ?>">
                                                    <input type="hidden" name="new_status" value="archived">
                                                    <button type="submit" name="update_status" class="btn btn-sm btn-warning" title="Lưu trữ">
                                                        <i class="fas fa-archive"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            
                                            <form method="POST" style="display: inline;" onsubmit="return confirm('Bạn có chắc muốn xóa tin nhắn này?')">
                                                <input type="hidden" name="message_id" value="<?= $message['id'] ?>">
                                                <button type="submit" name="delete_message" class="btn btn-sm btn-danger" title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
            
            <?php
            } catch (Exception $e) {
                echo "<div class='error'>";
                echo "<i class='fas fa-exclamation-triangle'></i> Lỗi kết nối cơ sở dữ liệu: " . htmlspecialchars($e->getMessage());
                echo "</div>";
                echo "<p>Vui lòng kiểm tra:</p>";
                echo "<ul>";
                echo "<li>XAMPP/WAMP đã chạy chưa</li>";
                echo "<li>Database 'viegrand_admin' đã tạo chưa</li>";
                echo "<li>Bảng 'contact_messages' đã import chưa</li>";
                echo "</ul>";
            }
            ?>
        </div>
    <?php endif; ?>

    <script>
        // Auto refresh every 30 seconds
        setTimeout(() => {
            location.reload();
        }, 30000);
        
        // Add some interactivity
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                row.addEventListener('click', function(e) {
                    if (e.target.tagName !== 'BUTTON' && e.target.tagName !== 'A') {
                        const messageCell = this.querySelector('.message-preview');
                        if (messageCell) {
                            alert(messageCell.getAttribute('title'));
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
