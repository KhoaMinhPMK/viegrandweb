<?php
/**
 * Database Connection Tester for VieGrand Setup
 */

header('Content-Type: application/json');

if ($_POST && isset($_POST['action']) && $_POST['action'] === 'test_connection') {
    try {
        // Get the submitted values
        $local_host = $_POST['local_host'] ?? 'localhost';
        $live_host = $_POST['live_host'] ?? 'viegrand.site';
        $database = $_POST['database'] ?? 'viegrand_admin';
        $username = $_POST['username'] ?? 'root';
        $password = $_POST['password'] ?? '';
        
        // Determine which host to use
        $currentHost = (in_array($_SERVER['SERVER_NAME'] ?? 'localhost', ['localhost', '127.0.0.1', '::1'])) ? $local_host : $live_host;
        
        // Try to connect
        $dsn = "mysql:host=$currentHost;dbname=$database;charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        
        // Test a simple query
        $stmt = $pdo->query("SELECT VERSION() as version, NOW() as current_time");
        $result = $stmt->fetch();
        
        // Check if contact_messages table exists
        $stmt = $pdo->prepare("SHOW TABLES LIKE 'contact_messages'");
        $stmt->execute();
        $tableExists = $stmt->fetch();
        
        $response = [
            'success' => true,
            'message' => "Kết nối thành công với database '$database' trên host '$currentHost'",
            'details' => [
                'host' => $currentHost,
                'database' => $database,
                'mysql_version' => $result['version'],
                'server_time' => $result['current_time'],
                'contact_table_exists' => $tableExists !== false,
                'environment' => (in_array($_SERVER['SERVER_NAME'] ?? 'localhost', ['localhost', '127.0.0.1', '::1'])) ? 'LOCAL' : 'LIVE'
            ]
        ];
        
        // If table doesn't exist, offer to create it
        if (!$tableExists) {
            $response['message'] .= " (Chưa có bảng contact_messages)";
            $response['details']['needs_table_creation'] = true;
        }
        
    } catch (PDOException $e) {
        $response = [
            'success' => false,
            'message' => "Lỗi kết nối database: " . $e->getMessage(),
            'details' => [
                'error_code' => $e->getCode(),
                'attempted_host' => $currentHost ?? 'unknown',
                'attempted_database' => $database,
                'attempted_username' => $username
            ]
        ];
    } catch (Exception $e) {
        $response = [
            'success' => false,
            'message' => "Lỗi: " . $e->getMessage()
        ];
    }
    
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request'
    ]);
}
?>
