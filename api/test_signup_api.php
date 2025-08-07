<?php
// Test script for signup API
header("Content-Type: application/json; charset=UTF-8");

// Database configuration
$host = '127.0.0.1';
$dbname = 'viegrand';
$username = 'root'; // Update with your actual database credentials
$password = ''; // Update with your actual database password

try {
    // Test database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo json_encode([
        'success' => true,
        'message' => 'Database connection successful',
        'database' => $dbname,
        'host' => $host,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    
    // Test table structure
    $stmt = $pdo->query("DESCRIBE advice_table");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "\n\nTable structure:\n";
    foreach ($columns as $column) {
        echo "- {$column['Field']}: {$column['Type']}\n";
    }
    
    // Test count existing records
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM advice_table");
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "\nExisting records: {$count['count']}\n";
    
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed',
        'error' => $e->getMessage()
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'General error',
        'error' => $e->getMessage()
    ]);
}
?> 