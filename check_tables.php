<?php
// Script untuk memeriksa tabel yang ada di database
try {
    $pdo = new PDO('mysql:host=localhost;dbname=db_absensi;port=3306', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SHOW TABLES";
    $stmt = $pdo->query($sql);
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Tabel yang ada di database db_absensi:\n";
    foreach($tables as $table) {
        echo "- $table\n";
    }
    
    if(in_array('users', $tables)) {
        echo "\nTabel 'users' ditemukan!\n";
        
        // Periksa struktur tabel users
        $sql = "DESCRIBE users";
        $stmt = $pdo->query($sql);
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "\nStruktur tabel users:\n";
        foreach($columns as $column) {
            echo "- {$column['Field']} ({$column['Type']})\n";
        }
    } else {
        echo "\nTabel 'users' TIDAK ditemukan!\n";
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>