<?php
/**
 * Check which database has the contact_messages table
 */

require_once 'config.php';

echo "<!DOCTYPE html>
<html><head><title>VieGrand - Database Investigation</title>
<style>
body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
.container { max-width: 900px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
.success { color: #22c55e; background: #f0fff4; padding: 15px; border-radius: 5px; margin: 10px 0; }
.error { color: #ef4444; background: #fef2f2; padding: 15px; border-radius: 5px; margin: 10px 0; }
.info { color: #3b82f6; background: #eff6ff; padding: 15px; border-radius: 5px; margin: 10px 0; }
.warning { color: #f59e0b; background: #fffbeb; padding: 15px; border-radius: 5px; margin: 10px 0; }
table { width: 100%; border-collapse: collapse; margin: 10px 0; }
th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
th { background: #f8f9fa; }
</style></head><body>
<div class='container'>
<h1>🔍 VieGrand - Database Investigation</h1>";

echo "<div class='info'>
<h3>📋 Configuration Analysis:</h3>
<ul>
<li><strong>Admin Database:</strong> " . DB_NAME . " (where contact form tries to save)</li>
<li><strong>Main Database:</strong> " . MAIN_DB_NAME . " (your existing database)</li>
<li><strong>Host:</strong> " . DB_HOST . "</li>
</ul>
</div>";

// Check viegrand_admin database
echo "<h2>🔍 Checking 'viegrand_admin' Database</h2>";
try {
    $adminDb = Database::getInstance();
    $adminPdo = $adminDb->getConnection();
    
    echo "<div class='success'>✅ Connected to viegrand_admin database</div>";
    
    // Check if contact_messages table exists
    $stmt = $adminPdo->prepare("SHOW TABLES LIKE 'contact_messages'");
    $stmt->execute();
    $tableExists = $stmt->fetch();
    
    if ($tableExists) {
        echo "<div class='success'>✅ contact_messages table EXISTS in viegrand_admin</div>";
        
        // Get row count
        $countStmt = $adminPdo->query("SELECT COUNT(*) as count FROM contact_messages");
        $count = $countStmt->fetch();
        echo "<div class='info'>📊 Rows in viegrand_admin.contact_messages: <strong>{$count['count']}</strong></div>";
        
        // Show recent entries
        if ($count['count'] > 0) {
            $recentStmt = $adminPdo->query("SELECT id, full_name, email, subject, created_at FROM contact_messages ORDER BY created_at DESC LIMIT 5");
            $recent = $recentStmt->fetchAll();
            
            echo "<h4>Recent Messages in viegrand_admin:</h4>";
            echo "<table><tr><th>ID</th><th>Name</th><th>Email</th><th>Subject</th><th>Created</th></tr>";
            foreach ($recent as $row) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
                echo "<td>{$row['created_at']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    } else {
        echo "<div class='warning'>⚠️ contact_messages table DOES NOT EXIST in viegrand_admin</div>";
    }
    
    // Show all tables in viegrand_admin
    $tablesStmt = $adminPdo->query("SHOW TABLES");
    $tables = $tablesStmt->fetchAll();
    echo "<h4>All tables in viegrand_admin:</h4><ul>";
    foreach ($tables as $table) {
        $tableName = array_values($table)[0];
        echo "<li>$tableName</li>";
    }
    echo "</ul>";
    
} catch (Exception $e) {
    echo "<div class='error'>❌ Error connecting to viegrand_admin: " . htmlspecialchars($e->getMessage()) . "</div>";
}

// Check main viegrand database
echo "<h2>🔍 Checking 'viegrand' Database</h2>";
try {
    $mainDb = Database::getMainInstance();
    $mainPdo = $mainDb->getConnection();
    
    echo "<div class='success'>✅ Connected to viegrand database</div>";
    
    // Check if contact_messages table exists
    $stmt = $mainPdo->prepare("SHOW TABLES LIKE 'contact_messages'");
    $stmt->execute();
    $tableExists = $stmt->fetch();
    
    if ($tableExists) {
        echo "<div class='success'>✅ contact_messages table EXISTS in viegrand</div>";
        
        // Get row count
        $countStmt = $mainPdo->query("SELECT COUNT(*) as count FROM contact_messages");
        $count = $countStmt->fetch();
        echo "<div class='info'>📊 Rows in viegrand.contact_messages: <strong>{$count['count']}</strong></div>";
        
        // Show recent entries
        if ($count['count'] > 0) {
            $recentStmt = $mainPdo->query("SELECT id, full_name, email, subject, created_at FROM contact_messages ORDER BY created_at DESC LIMIT 5");
            $recent = $recentStmt->fetchAll();
            
            echo "<h4>Recent Messages in viegrand:</h4>";
            echo "<table><tr><th>ID</th><th>Name</th><th>Email</th><th>Subject</th><th>Created</th></tr>";
            foreach ($recent as $row) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
                echo "<td>{$row['created_at']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    } else {
        echo "<div class='warning'>⚠️ contact_messages table DOES NOT EXIST in viegrand</div>";
    }
    
    // Show all tables in viegrand
    $tablesStmt = $mainPdo->query("SHOW TABLES");
    $tables = $tablesStmt->fetchAll();
    echo "<h4>All tables in viegrand:</h4><ul>";
    foreach ($tables as $table) {
        $tableName = array_values($table)[0];
        echo "<li>$tableName</li>";
    }
    echo "</ul>";
    
} catch (Exception $e) {
    echo "<div class='error'>❌ Error connecting to viegrand: " . htmlspecialchars($e->getMessage()) . "</div>";
}

echo "<div class='info'>
<h3>🎯 Summary & Next Steps:</h3>
<p>Based on the results above:</p>
<ul>
<li>If contact_messages exists in <strong>viegrand</strong> but not in <strong>viegrand_admin</strong>, we need to either:</li>
<ul>
<li>Option 1: Create the table in viegrand_admin (current setup)</li>
<li>Option 2: Change config to use viegrand database instead</li>
</ul>
<li>If contact_messages exists in both, check which one has your actual data</li>
<li>If it doesn't exist in either, then we need to create it</li>
</ul>
</div>";

echo "</div></body></html>";
?>
