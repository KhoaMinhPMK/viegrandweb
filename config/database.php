<?php
/**
 * Database Configuration for VieGrand Website
 * Update these credentials with your VPS database details
 */

// Database configuration
define('DB_HOST', 'localhost'); // Your VPS database host (usually localhost)
define('DB_NAME', 'viegrand_admin'); // Your database name
define('DB_USER', 'root'); // Your database username
define('DB_PASS', ''); // Your database password
define('DB_CHARSET', 'utf8mb4');

// Security settings
// define('SECURE_KEY', 'your_secure_random_key_here'); // Change this to a random string

/**
 * Create database connection
 * @return PDO Database connection object
 * @throws Exception If connection fails
 */
function getDatabaseConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
        
    } catch (PDOException $e) {
        error_log("Database connection failed: " . $e->getMessage());
        throw new Exception("Kết nối cơ sở dữ liệu thất bại");
    }
}

/**
 * Validate and sanitize input data
 * @param string $data Input data to sanitize
 * @return string Sanitized data
 */
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Validate email format
 * @param string $email Email to validate
 * @return bool True if valid, false otherwise
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate phone number (Vietnamese format)
 * @param string $phone Phone number to validate
 * @return bool True if valid, false otherwise
 */
function validatePhone($phone) {
    // Allow empty phone (optional field)
    if (empty($phone)) {
        return true;
    }
    
    // Remove spaces and special characters for validation
    $cleanPhone = preg_replace('/[\s\-\(\)]+/', '', $phone);
    
    // Vietnamese phone number patterns
    $patterns = [
        '/^(\+84|84|0)(3|5|7|8|9)[0-9]{8}$/', // Mobile
        '/^(\+84|84|0)(2)[0-9]{9}$/',         // Landline
    ];
    
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $cleanPhone)) {
            return true;
        }
    }
    
    return false;
}
?>
