<?php
// Script untuk memeriksa struktur tabel tb_siswa
try {
    $pdo = new PDO('mysql:host=localhost;dbname=db_absensi;port=3306', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "DESCRIBE tb_siswa";
    $stmt = $pdo->query($sql);
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Struktur tabel tb_siswa:\n";
    foreach($columns as $column) {
        echo "- {$column['Field']} ({$column['Type']})\n";
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>