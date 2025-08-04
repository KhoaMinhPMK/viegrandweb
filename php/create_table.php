<?php
/**
 * Create contact_messages table for VieGrand
 * Run this once to ensure the table exists
 */

require_once 'config.php';

try {
    $pdo = Database::connect();
    
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
    
    // Check if table was created successfully
    $stmt = $pdo->query("DESCRIBE contact_messages");
    $columns = $stmt->fetchAll();
    
    echo "✅ Table 'contact_messages' created/verified successfully!\n\n";
    echo "Table structure:\n";
    foreach ($columns as $column) {
        echo "- {$column['Field']}: {$column['Type']}\n";
    }
    
    // Test insert
    $testData = [
        'full_name' => 'Test User - ' . date('Y-m-d H:i:s'),
        'email' => 'test@viegrand.com',
        'phone' => '0123456789',
        'subject' => 'Test Message',
        'message' => 'This is a test message to verify the table works correctly.',
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Test Script'
    ];
    
    $insertSql = "INSERT INTO contact_messages (full_name, email, phone, subject, message, ip_address, user_agent) 
                  VALUES (:full_name, :email, :phone, :subject, :message, :ip_address, :user_agent)";
    
    $stmt = $pdo->prepare($insertSql);
    $result = $stmt->execute($testData);
    
    if ($result) {
        $lastId = $pdo->lastInsertId();
        echo "\n✅ Test message inserted successfully with ID: $lastId\n";
        
        // Count total messages
        $countStmt = $pdo->query("SELECT COUNT(*) as total FROM contact_messages");
        $count = $countStmt->fetch();
        echo "📊 Total messages in table: {$count['total']}\n";
    } else {
        echo "\n❌ Failed to insert test message\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Make sure your database credentials in config.php are correct.\n";
}
?>
