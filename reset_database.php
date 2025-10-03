<?php
// Reset database script
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_absensi';

try {
    // Connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database successfully.\n";
    
    // Get all table names
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Disable foreign key checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    
    // Drop all tables
    foreach ($tables as $table) {
        echo "Dropping table: $table\n";
        $pdo->exec("DROP TABLE IF EXISTS `$table`");
    }
    
    // Re-enable foreign key checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    
    echo "All tables dropped successfully!\n";
    echo "Now run: php spark migrate\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>