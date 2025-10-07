<?php
// Database verification script
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_absensi';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== DATABASE VERIFICATION ===\n\n";
    
    // Get all tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Tables in database:\n";
    foreach ($tables as $table) {
        echo "- $table\n";
    }
    
    echo "\n=== KEY TABLES STRUCTURE ===\n\n";
    
    // Check users table structure
    echo "USERS TABLE:\n";
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $column) {
        echo "  {$column['Field']} - {$column['Type']} - {$column['Null']} - {$column['Key']}\n";
    }
    
    // Check users count
    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    $userCount = $stmt->fetchColumn();
    echo "  Total users: $userCount\n\n";
    
    // Check tb_siswa table structure
    echo "TB_SISWA TABLE:\n";
    $stmt = $pdo->query("DESCRIBE tb_siswa");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $column) {
        echo "  {$column['Field']} - {$column['Type']} - {$column['Null']} - {$column['Key']}\n";
    }
    
    // Check tb_guru table structure
    echo "\nTB_GURU TABLE:\n";
    $stmt = $pdo->query("DESCRIBE tb_guru");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $column) {
        echo "  {$column['Field']} - {$column['Type']} - {$column['Null']} - {$column['Key']}\n";
    }
    
    // Check migrations table
    echo "\nMIGRATIONS STATUS:\n";
    $stmt = $pdo->query("SELECT * FROM migrations ORDER BY batch DESC, id DESC LIMIT 10");
    $migrations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($migrations as $migration) {
        echo "  {$migration['version']} - {$migration['class']} - Batch: {$migration['batch']}\n";
    }
    
    echo "\n=== VERIFICATION COMPLETE ===\n";
    echo "Database setup appears to be successful!\n";
    
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage() . "\n";
}
?>