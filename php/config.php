<?php
/**
 * Database Configuration for VieGrand
 * 
 * This file contains the database connection settings for the VieGrand project.
 * Make sure to update these settings according to your local/production environment.
 */

// Database configuration
class DatabaseConfig {
    // Production VPS configuration - direct connection to viegrand.site
    public static function getHost() {
        // Always use production VPS
        return 'viegrand.site';
    }
    
    // Database host - production VPS
    public static $host = 'viegrand.site';
    
    // Database name
    public static $database = 'viegrand_admin';
    
    // Database username - update this to your actual database username
    public static $username = 'root';
    
    // Database password - update this to your actual database password
    public static $password = '';
    
    // Database charset
    public static $charset = 'utf8mb4';
    
    // PDO options for better security and error handling
    public static $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
}

/**
 * Database Connection Class
 */
class Database {
    private static $connection = null;
    
    /**
     * Get database connection
     * @return PDO
     */
    public static function connect() {
        if (self::$connection === null) {
            try {
                $dsn = "mysql:host=" . DatabaseConfig::$host . 
                       ";dbname=" . DatabaseConfig::$database . 
                       ";charset=" . DatabaseConfig::$charset;
                
                self::$connection = new PDO(
                    $dsn, 
                    DatabaseConfig::$username, 
                    DatabaseConfig::$password, 
                    DatabaseConfig::$options
                );
                
                // Set timezone
                self::$connection->exec("SET time_zone = '+00:00'");
                
            } catch (PDOException $e) {
                // Log error and throw exception
                error_log("Database connection failed: " . $e->getMessage());
                throw new Exception("Database connection failed. Please try again later.");
            }
        }
        
        return self::$connection;
    }
    
    /**
     * Close database connection
     */
    public static function disconnect() {
        self::$connection = null;
    }
    
    /**
     * Test database connection
     * @return bool
     */
    public static function testConnection() {
        try {
            $pdo = self::connect();
            $stmt = $pdo->query("SELECT 1");
            return $stmt !== false;
        } catch (Exception $e) {
            return false;
        }
    }
}

// Application configuration
class AppConfig {
    // Enable/disable debug mode
    public static $debug = true;
    
    // Timezone
    public static $timezone = 'Asia/Ho_Chi_Minh';
    
    // Email configuration (for notifications)
    public static $emailFrom = 'viegrand.contact@gmail.com';
    public static $emailFromName = 'VieGrand Contact Form';
    
    // Security settings
    public static $maxMessageLength = 5000;
    public static $allowedFileTypes = ['txt', 'pdf', 'doc', 'docx'];
    public static $maxFileSize = 5 * 1024 * 1024; // 5MB
    
    // Rate limiting (messages per IP per hour)
    public static $maxMessagesPerHour = 5;
}

// Set default timezone
date_default_timezone_set(AppConfig::$timezone);

// Error reporting for development
if (AppConfig::$debug) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
?>
