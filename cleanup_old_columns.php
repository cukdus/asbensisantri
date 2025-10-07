<?php

$pdo = new PDO('mysql:host=localhost;dbname=db_absensi', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "=== Cleaning up old id_guru columns ===\n\n";

try {
    // Drop id_guru column from tb_presensi_guru
    echo "Dropping id_guru column from tb_presensi_guru...\n";
    $pdo->exec("ALTER TABLE tb_presensi_guru DROP COLUMN id_guru");
    echo "✓ Successfully dropped id_guru from tb_presensi_guru\n\n";
    
    // Drop id_guru column from tb_mapel
    echo "Dropping id_guru column from tb_mapel...\n";
    $pdo->exec("ALTER TABLE tb_mapel DROP COLUMN id_guru");
    echo "✓ Successfully dropped id_guru from tb_mapel\n\n";
    
    echo "=== Cleanup Complete ===\n";
    echo "All old id_guru columns have been removed.\n";
    echo "Tables now use user_id to reference the users table.\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}