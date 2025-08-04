<?php
/**
 * Contact Form API Endpoint for VieGrand
 * 
 * This file handles AJAX requests from the contact form
 */

// Set headers for JSON response and CORS
header('Content-Type: application/json');
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
        'message' => 'Phương thức không được phép. Chỉ chấp nhận POST.'
    ]);
    exit();
}

require_once 'ContactMessage.php';

try {
    // Get JSON input or form data
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    // If JSON decode fails, try to get form data
    if (json_last_error() !== JSON_ERROR_NONE) {
        $data = $_POST;
    }
    
    // Validate that we have data
    if (empty($data)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Không có dữ liệu được gửi.'
        ]);
        exit();
    }
    
    // Create ContactMessage instance and save
    $contactMessage = new ContactMessage();
    $result = $contactMessage->saveMessage($data);
    
    // Set appropriate HTTP status code
    if ($result['success']) {
        http_response_code(200);
    } else {
        http_response_code(400);
    }
    
    echo json_encode($result);
    
} catch (Exception $e) {
    error_log("Error in contact form API: " . $e->getMessage());
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Có lỗi hệ thống xảy ra. Vui lòng thử lại sau.'
    ]);
}
?>
