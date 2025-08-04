<?php
/**
 * Create contact_messages table for VieGrand
 * Compatible with new config structure
 */

require_once 'config.php';

echo "<!DOCTYPE html>
<html><head><title>VieGrand - Table Creation</title>
<style>
body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
.container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
.success { color: #22c55e; background: #f0fff4; padding: 15px; border-radius: 5px; margin: 10px 0; }
.error { color: #ef4444; background: #fef2f2; padding: 15px; border-radius: 5px; margin: 10px 0; }
.info { color: #3b82f6; background: #eff6ff; padding: 15px; border-radius: 5px; margin: 10px 0; }
pre { background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto; }
</style></head><body>
<div class='container'>
<h1>🔧 VieGrand - Database Table Creation</h1>";

try {
    echo "<div class='info'>🔌 <strong>Connecting to database...</strong><br>";
    echo "Host: " . DB_HOST . "<br>";
    echo "Database: " . DB_NAME . "<br>";
    echo "User: " . DB_USER . "</div>";
    
    // Use the new Database class structure
    $db = Database::getInstance();
    $pdo = $db->getConnection();
    
    echo "<div class='success'>✅ <strong>Database connection successful!</strong></div>";
    
    // Create the contact_messages table
    $sql = "CREATE TABLE IF NOT EXISTS contact_messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(20) NULL,
        subject VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        status ENUM('unread', 'read', 'replied') DEFAULT 'unread',
        ip_address VARCHAR(45) NULL,
        user_agent TEXT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_status (status),
        INDEX idx_created_at (created_at),
        INDEX idx_email (email)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    
    echo "<div class='success'>✅ <strong>Table 'contact_messages' created/verified successfully!</strong></div>";
    
    // Check table structure
    $stmt = $pdo->query("DESCRIBE contact_messages");
    $columns = $stmt->fetchAll();
    
    echo "<h3>📋 Table Structure:</h3><pre>";
    foreach ($columns as $column) {
        echo "• {$column['Field']}: {$column['Type']}\n";
    }
    echo "</pre>";
    
    // Test insert
    $testData = [
        'full_name' => 'Test User - ' . date('Y-m-d H:i:s'),
        'email' => 'test@viegrand.com',
        'phone' => '0123456789',
        'subject' => 'Table Creation Test',
        'message' => 'This is a test message to verify the table works correctly. Created at: ' . date('Y-m-d H:i:s'),
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Test Script'
    ];
    
    $insertSql = "INSERT INTO contact_messages (full_name, email, phone, subject, message, ip_address, user_agent) 
                  VALUES (:full_name, :email, :phone, :subject, :message, :ip_address, :user_agent)";
    
    $stmt = $pdo->prepare($insertSql);
    $result = $stmt->execute($testData);
    
    if ($result) {
        $lastId = $pdo->lastInsertId();
        echo "<div class='success'>✅ <strong>Test message inserted successfully!</strong><br>";
        echo "Message ID: $lastId</div>";
        
        // Count total messages
        $countStmt = $pdo->query("SELECT COUNT(*) as total FROM contact_messages");
        $count = $countStmt->fetch();
        echo "<div class='info'>📊 <strong>Total messages in table:</strong> {$count['total']}</div>";
        
        // Show recent messages
        $recentStmt = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5");
        $recentMessages = $recentStmt->fetchAll();
        
        echo "<h3>📧 Recent Messages:</h3>";
        echo "<table border='1' style='width:100%; border-collapse:collapse; margin-top:10px;'>";
        echo "<tr style='background:#f8f9fa;'><th>ID</th><th>Name</th><th>Email</th><th>Subject</th><th>Status</th><th>Created</th></tr>";
        
        foreach ($recentMessages as $msg) {
            echo "<tr>";
            echo "<td>{$msg['id']}</td>";
            echo "<td>" . htmlspecialchars($msg['full_name']) . "</td>";
            echo "<td>" . htmlspecialchars($msg['email']) . "</td>";
            echo "<td>" . htmlspecialchars(substr($msg['subject'], 0, 30)) . "...</td>";
            echo "<td>{$msg['status']}</td>";
            echo "<td>" . date('d/m H:i', strtotime($msg['created_at'])) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
    } else {
        echo "<div class='error'>❌ <strong>Failed to insert test message</strong></div>";
    }
    
    echo "<div class='success'>
    <h3>🎉 Setup Complete!</h3>
    <p><strong>Your contact form is now ready to use!</strong></p>
    <ul>
        <li>✅ Database table created</li>
        <li>✅ Test message inserted</li>
        <li>✅ Connection verified</li>
    </ul>
    <p><strong>Next steps:</strong></p>
    <ol>
        <li>Test your contact form at: <a href='../scr/screen/home/contact.html'>Contact Page</a></li>
        <li>Check messages in phpMyAdmin: <a href='https://viegrand.site/phpmyadmin/index.php?route=/sql&pos=0&db=viegrand_admin&table=contact_messages' target='_blank'>View Messages</a></li>
        <li>Manage messages via: <a href='admin.php'>Admin Panel</a></li>
    </ol>
    </div>";
    
} catch (Exception $e) {
    echo "<div class='error'>❌ <strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</div>";
    echo "<div class='info'>";
    echo "<h3>🔧 Troubleshooting:</h3>";
    echo "<ul>";
    echo "<li>Make sure your database credentials in config.php are correct</li>";
    echo "<li>Verify that the database 'viegrand_admin' exists</li>";
    echo "<li>Check if MySQL service is running on viegrand.site</li>";
    echo "<li>Ensure your user has permissions to create tables</li>";
    echo "</ul>";
    echo "</div>";
}

echo "</div></body></html>";
?>
