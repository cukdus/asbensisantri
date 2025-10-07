<?php
// Script untuk membuat database jika belum ada
try {
    $pdo = new PDO('mysql:host=localhost;port=3306', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "CREATE DATABASE IF NOT EXISTS db_absensi";
    $pdo->exec($sql);
    
    echo "Database db_absensi berhasil dibuat atau sudah ada.\n";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>