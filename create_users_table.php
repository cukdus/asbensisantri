<?php
// Script untuk membuat tabel users secara manual
try {
    $pdo = new PDO('mysql:host=localhost;dbname=db_absensi;port=3306', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "CREATE TABLE IF NOT EXISTS `users` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `email` varchar(255) NOT NULL,
        `username` varchar(30) DEFAULT NULL,
        `nuptk` varchar(24) DEFAULT NULL,
        `nama_lengkap` varchar(255) DEFAULT NULL,
        `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
        `alamat` text DEFAULT NULL,
        `no_hp` varchar(32) DEFAULT NULL,
        `unique_code` varchar(64) DEFAULT NULL,
        `role` enum('superadmin','guru') DEFAULT 'guru',
        `is_superadmin` tinyint(1) NOT NULL DEFAULT 0,
        `password_hash` varchar(255) NOT NULL,
        `reset_hash` varchar(255) DEFAULT NULL,
        `reset_at` datetime DEFAULT NULL,
        `reset_expires` datetime DEFAULT NULL,
        `activate_hash` varchar(255) DEFAULT NULL,
        `status` varchar(255) DEFAULT NULL,
        `status_message` varchar(255) DEFAULT NULL,
        `active` tinyint(1) NOT NULL DEFAULT 0,
        `force_pass_reset` tinyint(1) NOT NULL DEFAULT 0,
        `created_at` datetime DEFAULT NULL,
        `updated_at` datetime DEFAULT NULL,
        `deleted_at` datetime DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `email` (`email`),
        UNIQUE KEY `username` (`username`),
        UNIQUE KEY `unique_code` (`unique_code`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
    
    $pdo->exec($sql);
    
    echo "Tabel users berhasil dibuat!\n";
    
    // Tambahkan data superadmin default
    $insertSql = "INSERT IGNORE INTO `users` (`email`, `username`, `role`, `is_superadmin`, `password_hash`, `active`, `updated_at`) VALUES 
                  ('adminsuper@gmail.com', 'superadmin', 'superadmin', 1, '\$2y\$10\$T1X7H/r3KlqkHeKIxqeTmuccSUdVr.FymHdkqcxXV3f3T9ZI7gn5W', 1, NOW())";
    
    $pdo->exec($insertSql);
    
    echo "Data superadmin default berhasil ditambahkan!\n";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>