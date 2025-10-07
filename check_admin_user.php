<?php

require_once 'vendor/autoload.php';

// Database configuration
$config = [
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'db_absensi',
    'DBDriver' => 'MySQLi',
    'DBPrefix' => '',
    'pConnect' => false,
    'DBDebug'  => true,
    'charset'  => 'utf8',
    'DBCollat' => 'utf8_general_ci',
    'swapPre'  => '',
    'encrypt'  => false,
    'compress' => false,
    'strictOn' => false,
    'failover' => [],
    'port'     => 3306,
];

try {
    $db = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database'], $config['port']);
    
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
    
    echo "=== CHECKING ADMIN USER DATA ===\n\n";
    
    // Check if admin user exists
    $query = "SELECT id, username, email, password_hash, active, created_at FROM users WHERE username = 'admin' OR email = 'admin@admin.com'";
    $result = $db->query($query);
    
    if ($result && $result->num_rows > 0) {
        echo "Admin user found:\n";
        while ($row = $result->fetch_assoc()) {
            echo "ID: " . $row['id'] . "\n";
            echo "Username: " . $row['username'] . "\n";
            echo "Email: " . $row['email'] . "\n";
            echo "Password Hash: " . $row['password_hash'] . "\n";
            echo "Active: " . ($row['active'] ? 'Yes' : 'No') . "\n";
            echo "Created: " . $row['created_at'] . "\n";
            echo "---\n";
        }
    } else {
        echo "No admin user found!\n";
        
        // Check all users
        echo "\nAll users in database:\n";
        $allUsersQuery = "SELECT id, username, email, active FROM users";
        $allResult = $db->query($allUsersQuery);
        
        if ($allResult && $allResult->num_rows > 0) {
            while ($row = $allResult->fetch_assoc()) {
                echo "ID: {$row['id']}, Username: {$row['username']}, Email: {$row['email']}, Active: " . ($row['active'] ? 'Yes' : 'No') . "\n";
            }
        } else {
            echo "No users found in database!\n";
        }
    }
    
    // Test password verification
    echo "\n=== TESTING PASSWORD VERIFICATION ===\n";
    $testPassword = 'admin123';
    
    $adminQuery = "SELECT password_hash FROM users WHERE username = 'admin' LIMIT 1";
    $adminResult = $db->query($adminQuery);
    
    if ($adminResult && $adminResult->num_rows > 0) {
        $adminData = $adminResult->fetch_assoc();
        $storedHash = $adminData['password_hash'];
        
        echo "Stored hash: " . $storedHash . "\n";
        echo "Test password: " . $testPassword . "\n";
        
        // Test with password_verify
        if (password_verify($testPassword, $storedHash)) {
            echo "✅ Password verification: SUCCESS\n";
        } else {
            echo "❌ Password verification: FAILED\n";
            
            // Generate correct hash
            $correctHash = password_hash($testPassword, PASSWORD_DEFAULT);
            echo "Correct hash should be: " . $correctHash . "\n";
        }
    }
    
    $db->close();
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}