<?php
// Debug: Log that the script is being called
error_log("Contact form API called at: " . date('Y-m-d H:i:s'));

// Set headers for CORS and JSON response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
header('Access-Control-Max-Age: 86400');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Database configuration
$host = '127.0.0.1';  // Using IP instead of localhost
$dbname = 'viegrand_admin';
$username = 'root';
$password = '';      // Empty password for root
$charset = 'utf8mb4';

try {
    // Create PDO connection
    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Debug: Log the received data
    error_log("Contact form submission received: " . json_encode($input));
    
    if (!$input) {
        throw new Exception('Invalid JSON input');
    }
    
    // Validate required fields
    $required_fields = ['full_name', 'email', 'subject', 'message'];
    foreach ($required_fields as $field) {
        if (empty($input[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }
    
    // Validate email
    if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email format');
    }
    
    // Sanitize and prepare data
    $full_name = trim($input['full_name']);
    $email = trim($input['email']);
    $phone = isset($input['phone']) ? trim($input['phone']) : null;
    $subject = trim($input['subject']);
    $message = trim($input['message']);
    
    // Validate data length
    if (strlen($full_name) > 100) {
        throw new Exception('Name too long (max 100 characters)');
    }
    if (strlen($email) > 100) {
        throw new Exception('Email too long (max 100 characters)');
    }
    if ($phone && strlen($phone) > 20) {
        throw new Exception('Phone number too long (max 20 characters)');
    }
    if (strlen($subject) > 255) {
        throw new Exception('Subject too long (max 255 characters)');
    }
    
    // Prepare SQL statement
    $sql = "INSERT INTO contact_messages (full_name, email, phone, subject, message, status, created_at) 
            VALUES (:full_name, :email, :phone, :subject, :message, 'unread', NOW())";
    
    $stmt = $pdo->prepare($sql);
    
    // Bind parameters
    $stmt->bindParam(':full_name', $full_name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
    $stmt->bindParam(':message', $message, PDO::PARAM_STR);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the inserted ID
    $inserted_id = $pdo->lastInsertId();
    
    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'Message sent successfully!',
        'id' => $inserted_id
    ]);
    
} catch (PDOException $e) {
    // Database error
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database error occurred. Please try again later.'
    ]);
} catch (Exception $e) {
    // Validation or other error
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 