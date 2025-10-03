<?php
require_once 'vendor/autoload.php';

$config = [
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'db_absensi',
    'charset'  => 'utf8mb4',
    'collation' => 'utf8mb4_general_ci'
];

try {
    $pdo = new PDO(
        "mysql:host={$config['hostname']};dbname={$config['database']};charset={$config['charset']}", 
        $config['username'], 
        $config['password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Checking users table data:\n\n";
    
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Total users: " . count($users) . "\n\n";
    
    foreach ($users as $user) {
        echo "User ID: {$user['id']}\n";
        echo "Email: {$user['email']}\n";
        echo "Username: {$user['username']}\n";
        echo "Active: " . ($user['active'] ? 'Yes' : 'No') . "\n";
        echo "Role: " . ($user['role'] ?? 'Not set') . "\n";
        echo "---\n";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>