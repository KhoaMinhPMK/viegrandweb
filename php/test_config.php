<?php
/**
 * Test the new config structure
 */

require_once 'config.php';

echo "=== VieGrand Config Test ===\n\n";

// Test constants
echo "📋 Database Constants:\n";
echo "- DB_HOST: " . DB_HOST . "\n";
echo "- DB_NAME: " . DB_NAME . "\n";
echo "- DB_USER: " . DB_USER . "\n";
echo "- DB_CHARSET: " . DB_CHARSET . "\n\n";

echo "- MAIN_DB_HOST: " . MAIN_DB_HOST . "\n";
echo "- MAIN_DB_NAME: " . MAIN_DB_NAME . "\n";
echo "- MAIN_DB_USER: " . MAIN_DB_USER . "\n\n";

// Test new Database class methods
echo "🔌 Testing New Database Methods:\n";
try {
    $adminDb = Database::getInstance();
    echo "✅ Database::getInstance() - SUCCESS\n";
    
    $adminPdo = $adminDb->getConnection();
    echo "✅ getConnection() for admin DB - SUCCESS\n";
    
    $stmt = $adminPdo->query("SELECT 'Admin DB Connected' as message");
    $result = $stmt->fetch();
    echo "✅ Admin DB Query: " . $result['message'] . "\n";
    
} catch (Exception $e) {
    echo "❌ Admin DB Error: " . $e->getMessage() . "\n";
}

echo "\n";

try {
    $mainDb = Database::getMainInstance();
    echo "✅ Database::getMainInstance() - SUCCESS\n";
    
    $mainPdo = $mainDb->getConnection();
    echo "✅ getConnection() for main DB - SUCCESS\n";
    
    $stmt = $mainPdo->query("SELECT 'Main DB Connected' as message");
    $result = $stmt->fetch();
    echo "✅ Main DB Query: " . $result['message'] . "\n";
    
} catch (Exception $e) {
    echo "❌ Main DB Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test backward compatibility
echo "🔄 Testing Backward Compatibility:\n";
try {
    $legacyPdo = Database::connect();
    echo "✅ Database::connect() (legacy method) - SUCCESS\n";
    
    $stmt = $legacyPdo->query("SELECT 'Legacy method works' as message");
    $result = $stmt->fetch();
    echo "✅ Legacy Query: " . $result['message'] . "\n";
    
} catch (Exception $e) {
    echo "❌ Legacy Method Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test DatabaseConfig compatibility
echo "📊 Testing DatabaseConfig Compatibility:\n";
echo "- DatabaseConfig::\$host: " . DatabaseConfig::$host . "\n";
echo "- DatabaseConfig::\$database: " . DatabaseConfig::$database . "\n";
echo "- DatabaseConfig::\$username: " . DatabaseConfig::$username . "\n";
echo "- DatabaseConfig::\$charset: " . DatabaseConfig::$charset . "\n";

echo "\n";

// Test AppConfig
echo "⚙️ Testing AppConfig:\n";
echo "- AppConfig::\$debug: " . (AppConfig::$debug ? 'true' : 'false') . "\n";
echo "- AppConfig::\$timezone: " . AppConfig::$timezone . "\n";
echo "- AppConfig::\$emailFrom: " . AppConfig::$emailFrom . "\n";

echo "\n=== Test Complete ===\n";
?>
