<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_absensi';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Checking users table structure...\n\n";
    
    $result = $pdo->query("DESCRIBE users");
    $columns = $result->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        echo "Field: " . $column['Field'] . "\n";
        echo "Type: " . $column['Type'] . "\n";
        echo "Null: " . $column['Null'] . "\n";
        echo "Key: " . $column['Key'] . "\n";
        echo "Default: " . $column['Default'] . "\n";
        echo "Extra: " . $column['Extra'] . "\n";
        echo "---\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Database Error: " . $e->getMessage() . "\n";
}