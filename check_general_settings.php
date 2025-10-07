<?php
// Simple database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_absensi';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== GENERAL SETTINGS TABLE STRUCTURE ===\n";
    $stmt = $pdo->query("DESCRIBE general_settings");
    $fields = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($fields as $field) {
        echo "Field: " . $field['Field'] . " | Type: " . $field['Type'] . " | Null: " . $field['Null'] . " | Default: " . $field['Default'] . "\n";
    }
    
    echo "\n=== CURRENT DATA ===\n";
    $stmt = $pdo->query("SELECT * FROM general_settings WHERE id = 1");
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($data) {
        foreach ($data as $key => $value) {
            echo "$key: $value\n";
        }
    } else {
        echo "No data found\n";
    }
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}
?>