<?php
/**
 * Debug Contact Form API for VieGrand
 * 
 * This file helps debug form submission issues
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log all requests to a file for debugging
$logFile = 'contact_debug.log';
$timestamp = date('Y-m-d H:i:s');

// Set headers for JSON response and CORS
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Log function
function logDebug($message) {
    global $logFile, $timestamp;
    $logEntry = "[$timestamp] $message\n";
    file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
}

logDebug("=== NEW REQUEST ===");
logDebug("Method: " . $_SERVER['REQUEST_METHOD']);
logDebug("Content-Type: " . ($_SERVER['CONTENT_TYPE'] ?? 'not set'));
logDebug("Raw input: " . file_get_contents('php://input'));
logDebug("POST data: " . print_r($_POST, true));

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    logDebug("Handling OPTIONS request");
    http_response_code(200);
    exit();
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    logDebug("Invalid method: " . $_SERVER['REQUEST_METHOD']);
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Phương thức không được phép. Chỉ chấp nhận POST.',
        'debug' => 'Method not allowed'
    ]);
    exit();
}

try {
    logDebug("Loading required files...");
    
    // Check if files exist
    if (!file_exists('config.php')) {
        throw new Exception("File config.php không tồn tại");
    }
    if (!file_exists('ContactMessage.php')) {
        throw new Exception("File ContactMessage.php không tồn tại");
    }
    
    require_once 'config.php';
    require_once 'ContactMessage.php';
    
    logDebug("Files loaded successfully");
    
    // Test database connection
    try {
        $testConnection = Database::connect();
        logDebug("Database connection: SUCCESS");
    } catch (Exception $e) {
        logDebug("Database connection: FAILED - " . $e->getMessage());
        throw new Exception("Lỗi kết nối database: " . $e->getMessage());
    }
    
    // Get JSON input or form data
    $input = file_get_contents('php://input');
    logDebug("Raw input length: " . strlen($input));
    
    $data = json_decode($input, true);
    
    // If JSON decode fails, try to get form data
    if (json_last_error() !== JSON_ERROR_NONE) {
        logDebug("JSON decode failed: " . json_last_error_msg());
        $data = $_POST;
        logDebug("Using POST data instead");
    }
    
    logDebug("Parsed data: " . print_r($data, true));
    
    // Validate that we have data
    if (empty($data)) {
        logDebug("No data received");
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Không có dữ liệu được gửi.',
            'debug' => [
                'json_error' => json_last_error_msg(),
                'post_data' => $_POST,
                'raw_input' => $input
            ]
        ]);
        exit();
    }
    
    // Check required fields
    $required = ['full_name', 'email', 'subject', 'message'];
    $missing = [];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            $missing[] = $field;
        }
    }
    
    if (!empty($missing)) {
        logDebug("Missing fields: " . implode(', ', $missing));
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Thiếu các trường bắt buộc: ' . implode(', ', $missing),
            'debug' => [
                'missing_fields' => $missing,
                'received_data' => $data
            ]
        ]);
        exit();
    }
    
    // Test table existence
    try {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SHOW TABLES LIKE 'contact_messages'");
        $stmt->execute();
        $tableExists = $stmt->fetch();
        
        if (!$tableExists) {
            throw new Exception("Bảng contact_messages không tồn tại");
        }
        logDebug("Table contact_messages exists");
    } catch (Exception $e) {
        logDebug("Table check failed: " . $e->getMessage());
        throw new Exception("Lỗi kiểm tra bảng: " . $e->getMessage());
    }
    
    // Create ContactMessage instance and save
    logDebug("Creating ContactMessage instance...");
    $contactMessage = new ContactMessage();
    
    logDebug("Attempting to save message...");
    $result = $contactMessage->saveMessage($data);
    
    logDebug("Save result: " . print_r($result, true));
    
    // Set appropriate HTTP status code
    if ($result['success']) {
        logDebug("Message saved successfully");
        http_response_code(200);
    } else {
        logDebug("Message save failed: " . $result['message']);
        http_response_code(400);
    }
    
    echo json_encode($result);
    
} catch (Exception $e) {
    $errorMsg = "Error in contact form API: " . $e->getMessage();
    logDebug($errorMsg);
    error_log($errorMsg);
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Có lỗi hệ thống xảy ra: ' . $e->getMessage(),
        'debug' => [
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]
    ]);
}

logDebug("=== REQUEST END ===\n");
?>
