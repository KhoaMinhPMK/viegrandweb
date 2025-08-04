<?php
/**
 * Contact Form Handler for VieGrand Website
 * Processes contact form submissions and saves to database
 */

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 0); // Set to 0 in production
ini_set('log_errors', 1);

// Set content type to JSON
header('Content-Type: application/json; charset=utf-8');

// Allow CORS for your domain (update with your domain)
header('Access-Control-Allow-Origin: https://viegrand.site');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Include database configuration
require_once 'config/database.php';

/**
 * Send JSON response
 * @param bool $success Success status
 * @param string $message Response message
 * @param array $data Additional data (optional)
 */
function sendResponse($success, $message, $data = []) {
    $response = [
        'success' => $success,
        'message' => $message,
        'data' => $data,
        'timestamp' => date('Y-m-d H:i:s')
    ];
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}

/**
 * Log security violations
 * @param string $violation Description of violation
 * @param array $data Additional data about the violation
 */
function logSecurityViolation($violation, $data = []) {
    $logData = [
        'timestamp' => date('Y-m-d H:i:s'),
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
        'violation' => $violation,
        'data' => $data
    ];
    
    error_log("Security Violation: " . json_encode($logData));
}

try {
    // Only allow POST requests
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        logSecurityViolation('Invalid request method', ['method' => $_SERVER['REQUEST_METHOD']]);
        sendResponse(false, 'Phương thức yêu cầu không hợp lệ');
    }

    // Check if request comes from your domain (basic referrer check)
    $allowedDomains = ['viegrand.site', 'www.viegrand.site'];
    $referrer = $_SERVER['HTTP_REFERER'] ?? '';
    $validReferrer = false;
    
    foreach ($allowedDomains as $domain) {
        if (strpos($referrer, $domain) !== false) {
            $validReferrer = true;
            break;
        }
    }
    
    // Allow local testing and direct access for now
    if (!$validReferrer && !empty($referrer)) {
        logSecurityViolation('Invalid referrer', ['referrer' => $referrer]);
        // Uncomment the next line to enforce referrer checking in production
        // sendResponse(false, 'Yêu cầu không hợp lệ');
    }

    // Get and validate input data
    $input = file_get_contents('php://input');
    $isJson = false;
    
    // Try to parse as JSON first (for AJAX requests)
    if (!empty($input)) {
        $jsonData = json_decode($input, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $_POST = $jsonData;
            $isJson = true;
        }
    }

    // Validate required fields
    $requiredFields = ['name', 'email', 'subject', 'message'];
    $missingFields = [];
    
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $missingFields[] = $field;
        }
    }
    
    if (!empty($missingFields)) {
        sendResponse(false, 'Vui lòng điền đầy đủ thông tin bắt buộc: ' . implode(', ', $missingFields));
    }

    // Sanitize and validate input data
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone'] ?? '');
    $subject = sanitizeInput($_POST['subject']);
    $message = sanitizeInput($_POST['message']);

    // Validation
    $errors = [];

    // Validate name
    if (strlen($name) < 2 || strlen($name) > 100) {
        $errors[] = 'Tên phải có từ 2-100 ký tự';
    }

    // Validate email
    if (!validateEmail($email)) {
        $errors[] = 'Địa chỉ email không hợp lệ';
    }

    // Validate phone (optional)
    if (!validatePhone($phone)) {
        $errors[] = 'Số điện thoại không hợp lệ';
    }

    // Validate subject
    if (strlen($subject) < 3 || strlen($subject) > 255) {
        $errors[] = 'Chủ đề phải có từ 3-255 ký tự';
    }

    // Validate message
    if (strlen($message) < 10 || strlen($message) > 2000) {
        $errors[] = 'Nội dung tin nhắn phải có từ 10-2000 ký tự';
    }

    // Check for spam patterns (basic)
    $spamKeywords = ['viagra', 'casino', 'loan', 'money', 'prize', 'winner', 'click here'];
    $messageForSpamCheck = strtolower($message . ' ' . $subject);
    
    foreach ($spamKeywords as $keyword) {
        if (strpos($messageForSpamCheck, $keyword) !== false) {
            logSecurityViolation('Spam detected', ['keyword' => $keyword, 'message' => substr($message, 0, 100)]);
            sendResponse(false, 'Tin nhắn có thể chứa nội dung spam');
        }
    }

    if (!empty($errors)) {
        sendResponse(false, implode('. ', $errors));
    }

    // Rate limiting (simple implementation)
    $clientIp = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $rateLimitFile = sys_get_temp_dir() . '/viegrand_rate_limit_' . md5($clientIp);
    
    if (file_exists($rateLimitFile)) {
        $lastSubmission = filemtime($rateLimitFile);
        $timeDiff = time() - $lastSubmission;
        
        // Allow one submission per 5 minutes per IP
        if ($timeDiff < 300) {
            logSecurityViolation('Rate limit exceeded', ['ip' => $clientIp, 'time_diff' => $timeDiff]);
            sendResponse(false, 'Vui lòng chờ ' . (300 - $timeDiff) . ' giây trước khi gửi tin nhắn tiếp theo');
        }
    }

    // Connect to database
    $pdo = getDatabaseConnection();
    
    // Check for duplicate submissions (same email + subject in last 24 hours)
    $stmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM contact_messages 
        WHERE email = ? 
        AND subject = ? 
        AND created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)
    ");
    $stmt->execute([$email, $subject]);
    $duplicateCount = $stmt->fetchColumn();
    
    if ($duplicateCount > 0) {
        logSecurityViolation('Duplicate submission', ['email' => $email, 'subject' => $subject]);
        sendResponse(false, 'Bạn đã gửi tin nhắn tương tự trong 24 giờ qua');
    }

    // Insert data into database
    $stmt = $pdo->prepare("
        INSERT INTO contact_messages (full_name, email, phone, subject, message, status, created_at) 
        VALUES (?, ?, ?, ?, ?, 'unread', NOW())
    ");
    
    $result = $stmt->execute([$name, $email, $phone, $subject, $message]);
    
    if ($result) {
        $messageId = $pdo->lastInsertId();
        
        // Update rate limiting
        touch($rateLimitFile);
        
        // Log successful submission
        error_log("Contact form submission successful - ID: $messageId, Email: $email");
        
        // Send success response
        sendResponse(true, 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.', [
            'message_id' => $messageId
        ]);
        
    } else {
        throw new Exception('Không thể lưu tin nhắn vào cơ sở dữ liệu');
    }

} catch (Exception $e) {
    // Log the error
    error_log("Contact form error: " . $e->getMessage());
    
    // Send error response
    sendResponse(false, 'Đã xảy ra lỗi khi gửi tin nhắn. Vui lòng thử lại sau.');
}
?>
