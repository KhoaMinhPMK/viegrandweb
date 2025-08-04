<?php
/**
 * VieGrand Contact Form API - Production Version
 * Simple and reliable contact form handler
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set content type
header('Content-Type: application/json; charset=utf-8');

// Enable CORS for cross-origin requests
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Only POST method allowed'
    ]);
    exit();
}

try {
    // Include required files
    require_once 'config.php';
    require_once 'ContactMessage.php';
    
    // Get input data
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    // Log the received data for debugging
    $logData = [
        'timestamp' => date('Y-m-d H:i:s'),
        'method' => $_SERVER['REQUEST_METHOD'],
        'input' => $input,
        'parsed_data' => $data,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
    ];
    file_put_contents('contact_production.log', json_encode($logData) . "\n", FILE_APPEND);
    
    // Validate input data
    if (!$data) {
        throw new Exception('Invalid JSON data received');
    }
    
    // Required fields check
    $required = ['full_name', 'email', 'subject', 'message'];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            throw new Exception("Field '$field' is required");
        }
    }
    
    // Validate email
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email address');
    }
    
    // Clean and prepare data
    $messageData = [
        'full_name' => trim($data['full_name']),
        'email' => trim($data['email']),
        'phone' => isset($data['phone']) ? trim($data['phone']) : null,
        'subject' => trim($data['subject']),
        'message' => trim($data['message']),
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null
    ];
    
    // Save to database
    $contactMessage = new ContactMessage();
    $result = $contactMessage->saveMessage($messageData);
    
    if ($result) {
        // Success response
        echo json_encode([
            'success' => true,
            'message' => 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.',
            'data' => [
                'id' => $result,
                'timestamp' => date('Y-m-d H:i:s')
            ]
        ]);
    } else {
        throw new Exception('Failed to save message to database');
    }
    
} catch (Exception $e) {
    // Log error
    $errorLog = [
        'timestamp' => date('Y-m-d H:i:s'),
        'error' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'input' => $input ?? 'none'
    ];
    file_put_contents('contact_errors.log', json_encode($errorLog) . "\n", FILE_APPEND);
    
    // Error response
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'error_details' => [
            'timestamp' => date('Y-m-d H:i:s'),
            'error_id' => uniqid()
        ]
    ]);
}
?>
