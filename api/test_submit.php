<?php
// Test file to manually submit form data
header('Content-Type: application/json');

// Simulate form data
$testData = [
    'full_name' => 'Test User',
    'email' => 'test@example.com',
    'phone' => '+1234567890',
    'subject' => 'Test Subject',
    'message' => 'This is a test message'
];

// Database configuration
$host = '127.0.0.1';
$dbname = 'viegrand_admin';
$username = 'root';
$password = '';
$charset = 'utf8mb4';

try {
    // Create PDO connection
    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Prepare SQL statement
    $sql = "INSERT INTO contact_messages (full_name, email, phone, subject, message, status, created_at) 
            VALUES (:full_name, :email, :phone, :subject, :message, 'unread', NOW())";
    
    $stmt = $pdo->prepare($sql);
    
    // Bind parameters
    $stmt->bindParam(':full_name', $testData['full_name'], PDO::PARAM_STR);
    $stmt->bindParam(':email', $testData['email'], PDO::PARAM_STR);
    $stmt->bindParam(':phone', $testData['phone'], PDO::PARAM_STR);
    $stmt->bindParam(':subject', $testData['subject'], PDO::PARAM_STR);
    $stmt->bindParam(':message', $testData['message'], PDO::PARAM_STR);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the inserted ID
    $inserted_id = $pdo->lastInsertId();
    
    echo json_encode([
        'success' => true,
        'message' => 'Test message inserted successfully!',
        'id' => $inserted_id,
        'test_data' => $testData
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?> 