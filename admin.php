<?php
/**
 * Simple Admin Panel for VieGrand Contact Messages
 * View and manage contact form submissions
 */

// Include database configuration
require_once 'config/database.php';

// Simple authentication (replace with proper authentication in production)
session_start();

// Change these credentials for security
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'viegrand2025'); // Change this password!

// Handle login
if (isset($_POST['login'])) {
    if ($_POST['username'] === ADMIN_USERNAME && $_POST['password'] === ADMIN_PASSWORD) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $loginError = 'Tên đăng nhập hoặc mật khẩu không đúng';
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'];

// Handle status updates
if ($isLoggedIn && isset($_POST['update_status'])) {
    try {
        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("UPDATE contact_messages SET status = ? WHERE id = ?");
        $stmt->execute([$_POST['status'], $_POST['message_id']]);
        $statusUpdateMessage = 'Trạng thái đã được cập nhật';
    } catch (Exception $e) {
        $statusUpdateError = 'Không thể cập nhật trạng thái: ' . $e->getMessage();
    }
}

// Handle message deletion
if ($isLoggedIn && isset($_POST['delete_message'])) {
    try {
        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("DELETE FROM contact_messages WHERE id = ?");
        $stmt->execute([$_POST['message_id']]);
        $deleteMessage = 'Tin nhắn đã được xóa';
    } catch (Exception $e) {
        $deleteError = 'Không thể xóa tin nhắn: ' . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VieGrand - Admin Panel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
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
            background: linear-gradient(135deg, #004aad 0%, #0066ff 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 1.1rem;
        }
        
        .login-form {
            max-width: 400px;
            margin: 50px auto;
            padding: 40px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #004aad;
        }
        
        .btn {
            background: linear-gradient(135deg, #004aad 0%, #0066ff 100%);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: transform 0.2s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .btn-logout {
            background: #dc3545;
            float: right;
            margin-bottom: 20px;
        }
        
        .content {
            padding: 30px;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            border-left: 4px solid #004aad;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #004aad;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #666;
            font-weight: 500;
        }
        
        .messages-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .table-header {
            background: #f8f9fa;
            padding: 20px;
            border-bottom: 2px solid #e9ecef;
        }
        
        .table-header h3 {
            color: #333;
            font-size: 1.3rem;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }
        
        th {
            background: #004aad;
            color: white;
            font-weight: 600;
        }
        
        tr:hover {
            background: #f8f9fa;
        }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-unread {
            background: #dc3545;
            color: white;
        }
        
        .status-read {
            background: #28a745;
            color: white;
        }
        
        .status-archived {
            background: #6c757d;
            color: white;
        }
        
        .actions {
            display: flex;
            gap: 10px;
        }
        
        .btn-sm {
            padding: 5px 10px;
            font-size: 0.85rem;
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
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .no-messages {
            text-align: center;
            padding: 50px;
            color: #666;
            font-style: italic;
        }
        
        @media (max-width: 768px) {
            .container {
                margin: 10px;
                border-radius: 10px;
            }
            
            .header {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .content {
                padding: 20px;
            }
            
            table {
                font-size: 0.9rem;
            }
            
            th, td {
                padding: 10px 8px;
            }
            
            .actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏥 VieGrand Admin</h1>
            <p>Quản lý tin nhắn liên hệ</p>
        </div>

        <?php if (!$isLoggedIn): ?>
            <div class="login-form">
                <h2 style="text-align: center; margin-bottom: 30px; color: #333;">Đăng nhập Admin</h2>
                
                <?php if (isset($loginError)): ?>
                    <div class="alert alert-error"><?= htmlspecialchars($loginError) ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="form-group">
                        <label for="username">Tên đăng nhập:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Mật khẩu:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <button type="submit" name="login" class="btn" style="width: 100%;">Đăng nhập</button>
                </form>
            </div>
        <?php else: ?>
            <div class="content">
                <a href="?logout=1" class="btn btn-logout">Đăng xuất</a>
                <div style="clear: both;"></div>
                
                <?php if (isset($statusUpdateMessage)): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($statusUpdateMessage) ?></div>
                <?php endif; ?>
                
                <?php if (isset($statusUpdateError)): ?>
                    <div class="alert alert-error"><?= htmlspecialchars($statusUpdateError) ?></div>
                <?php endif; ?>
                
                <?php if (isset($deleteMessage)): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($deleteMessage) ?></div>
                <?php endif; ?>
                
                <?php if (isset($deleteError)): ?>
                    <div class="alert alert-error"><?= htmlspecialchars($deleteError) ?></div>
                <?php endif; ?>

                <?php
                try {
                    $pdo = getDatabaseConnection();
                    
                    // Get statistics
                    $totalMessages = $pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();
                    $unreadMessages = $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'unread'")->fetchColumn();
                    $readMessages = $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'read'")->fetchColumn();
                    $archivedMessages = $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'archived'")->fetchColumn();
                ?>

                <div class="stats">
                    <div class="stat-card">
                        <div class="stat-number"><?= $totalMessages ?></div>
                        <div class="stat-label">Tổng tin nhắn</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?= $unreadMessages ?></div>
                        <div class="stat-label">Chưa đọc</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?= $readMessages ?></div>
                        <div class="stat-label">Đã đọc</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?= $archivedMessages ?></div>
                        <div class="stat-label">Đã lưu trữ</div>
                    </div>
                </div>

                <div class="messages-table">
                    <div class="table-header">
                        <h3>📧 Danh sách tin nhắn</h3>
                    </div>

                    <?php
                    // Get all messages
                    $stmt = $pdo->query("
                        SELECT * FROM contact_messages 
                        ORDER BY created_at DESC
                    ");
                    $messages = $stmt->fetchAll();

                    if (empty($messages)):
                    ?>
                        <div class="no-messages">
                            <h3>Chưa có tin nhắn nào</h3>
                            <p>Các tin nhắn từ form liên hệ sẽ xuất hiện ở đây.</p>
                        </div>
                    <?php else: ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Điện thoại</th>
                                    <th>Chủ đề</th>
                                    <th>Tin nhắn</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày gửi</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($messages as $message): ?>
                                    <tr>
                                        <td><?= $message['id'] ?></td>
                                        <td><?= htmlspecialchars($message['full_name']) ?></td>
                                        <td><?= htmlspecialchars($message['email']) ?></td>
                                        <td><?= htmlspecialchars($message['phone'] ?: 'N/A') ?></td>
                                        <td><?= htmlspecialchars($message['subject']) ?></td>
                                        <td class="message-preview" title="<?= htmlspecialchars($message['message']) ?>">
                                            <?= htmlspecialchars(substr($message['message'], 0, 50)) ?>...
                                        </td>
                                        <td>
                                            <span class="status-badge status-<?= $message['status'] ?>">
                                                <?= ucfirst($message['status']) ?>
                                            </span>
                                        </td>
                                        <td><?= date('d/m/Y H:i', strtotime($message['created_at'])) ?></td>
                                        <td>
                                            <div class="actions">
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="message_id" value="<?= $message['id'] ?>">
                                                    <select name="status" onchange="this.form.submit()">
                                                        <option value="unread" <?= $message['status'] === 'unread' ? 'selected' : '' ?>>Chưa đọc</option>
                                                        <option value="read" <?= $message['status'] === 'read' ? 'selected' : '' ?>>Đã đọc</option>
                                                        <option value="archived" <?= $message['status'] === 'archived' ? 'selected' : '' ?>>Lưu trữ</option>
                                                    </select>
                                                    <input type="hidden" name="update_status" value="1">
                                                </form>
                                                
                                                <form method="POST" style="display: inline;" onsubmit="return confirm('Bạn có chắc muốn xóa tin nhắn này?')">
                                                    <input type="hidden" name="message_id" value="<?= $message['id'] ?>">
                                                    <button type="submit" name="delete_message" class="btn btn-danger btn-sm">Xóa</button>
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
                    echo '<div class="alert alert-error">Lỗi kết nối cơ sở dữ liệu: ' . htmlspecialchars($e->getMessage()) . '</div>';
                }
                ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
