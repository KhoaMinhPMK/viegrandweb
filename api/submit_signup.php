<?php
// Enable CORS for cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

// Database configuration
$host = '127.0.0.1';
$dbname = 'viegrand';
$username = 'root'; // Update with your actual database credentials
$password = ''; // Update with your actual database password

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        throw new Exception('Invalid JSON input');
    }
    
    // Validate required fields
    $required_fields = [
        'firstName' => 'Họ và tên đệm',
        'lastName' => 'Tên',
        'email' => 'Email',
        'phone' => 'Số điện thoại',
        'age' => 'Tuổi',
        'relationship' => 'Mối quan hệ',
        'address' => 'Địa chỉ',
        'needs' => 'Nhu cầu'
    ];
    
    $errors = [];
    foreach ($required_fields as $field => $label) {
        if (empty($input[$field])) {
            $errors[] = "Trường '$label' là bắt buộc";
        }
    }
    
    // Validate email format
    if (!empty($input['email']) && !filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email không hợp lệ";
    }
    
    // Validate phone number (basic validation)
    if (!empty($input['phone'])) {
        $phone = preg_replace('/[^0-9+\-\s()]/', '', $input['phone']);
        if (strlen($phone) < 10) {
            $errors[] = "Số điện thoại không hợp lệ";
        }
    }
    
    // Check terms agreement
    if (empty($input['terms']) || $input['terms'] !== 'on') {
        $errors[] = "Bạn phải đồng ý với điều khoản sử dụng";
    }
    
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $errors
        ]);
        exit();
    }
    
    // Prepare data for database insertion
    $data = [
        'last_and_middle_name' => trim($input['firstName']),
        'first_name' => trim($input['lastName']),
        'email' => trim($input['email']),
        'phone_number' => trim($input['phone']),
        'age' => trim($input['age']),
        'status' => trim($input['relationship']),
        'address' => trim($input['address']),
        'demand' => trim($input['needs'])
    ];
    
    // Insert data into database
    $sql = "INSERT INTO advice_table (last_and_middle_name, first_name, email, phone_number, age, status, address, demand) 
            VALUES (:last_and_middle_name, :first_name, :email, :phone_number, :age, :status, :address, :demand)";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute($data);
    
    if ($result) {
        // Success response
        echo json_encode([
            'success' => true,
            'message' => 'Đăng ký thành công! Chúng tôi sẽ liên hệ với bạn trong vòng 24 giờ tới.',
            'data' => [
                'id' => $pdo->lastInsertId(),
                'timestamp' => date('Y-m-d H:i:s')
            ]
        ]);
    } else {
        throw new Exception('Failed to insert data into database');
    }
    
} catch (PDOException $e) {
    // Database connection or query error
    error_log("Database Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi kết nối cơ sở dữ liệu. Vui lòng thử lại sau.',
        'debug' => $e->getMessage() // Remove this in production
    ]);
    
} catch (Exception $e) {
    // General error
    error_log("General Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Đã xảy ra lỗi. Vui lòng thử lại sau.',
        'debug' => $e->getMessage() // Remove this in production
    ]);
}
?> 