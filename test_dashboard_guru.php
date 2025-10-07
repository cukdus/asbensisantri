<?php

// Koneksi langsung ke database
$host = 'localhost';
$dbname = 'db_absensi';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== TEST METHOD getPresensiByKehadiran ===\n";
    $tanggal = '2025-10-01';
    
    // Simulasi method getPresensiByKehadiran untuk kehadiran = 1
    echo "1. Testing getPresensiByKehadiran('1', '$tanggal'):\n";
    $sql = "SELECT users.id, users.nama_lengkap, users.nuptk, users.jenis_kelamin, users.alamat, users.no_hp, users.unique_code, tb_presensi_guru.* 
             FROM users 
             INNER JOIN tb_presensi_guru ON users.id = tb_presensi_guru.id_guru AND tb_presensi_guru.tanggal = ? 
             WHERE users.role = 'guru' AND tb_presensi_guru.id_kehadiran = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$tanggal, 1]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "   Jumlah hasil: " . count($result) . "\n";
    echo "   Ini adalah data yang akan ditampilkan di dashboard untuk 'Hadir'\n";
    
    // Simulasi method getPresensiByKehadiran untuk kehadiran = 4 (Alfa)
    echo "\n2. Testing getPresensiByKehadiran('4', '$tanggal'):\n";
    $sql = "SELECT users.id, users.nama_lengkap, users.nuptk, users.jenis_kelamin, users.alamat, users.no_hp, users.unique_code, tb_presensi_guru.id_kehadiran 
             FROM users 
             LEFT JOIN tb_presensi_guru ON users.id = tb_presensi_guru.id_guru AND tb_presensi_guru.tanggal = ? 
             WHERE users.role = 'guru' AND (tb_presensi_guru.id_kehadiran IS NULL OR tb_presensi_guru.id_kehadiran NOT IN (1,2,3))";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$tanggal]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "   Jumlah hasil: " . count($result) . "\n";
    echo "   Ini adalah data yang akan ditampilkan di dashboard untuk 'Alfa'\n";
    
    // Hitung total untuk dashboard
    echo "\n3. Rekap untuk Dashboard (tanggal: $tanggal):\n";
    
    // Hadir
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM users INNER JOIN tb_presensi_guru ON users.id = tb_presensi_guru.id_guru AND tb_presensi_guru.tanggal = ? WHERE users.role = 'guru' AND tb_presensi_guru.id_kehadiran = 1");
    $stmt->execute([$tanggal]);
    $hadir = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "   Hadir: " . $hadir['total'] . "\n";
    
    // Sakit
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM users INNER JOIN tb_presensi_guru ON users.id = tb_presensi_guru.id_guru AND tb_presensi_guru.tanggal = ? WHERE users.role = 'guru' AND tb_presensi_guru.id_kehadiran = 2");
    $stmt->execute([$tanggal]);
    $sakit = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "   Sakit: " . $sakit['total'] . "\n";
    
    // Izin
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM users INNER JOIN tb_presensi_guru ON users.id = tb_presensi_guru.id_guru AND tb_presensi_guru.tanggal = ? WHERE users.role = 'guru' AND tb_presensi_guru.id_kehadiran = 3");
    $stmt->execute([$tanggal]);
    $izin = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "   Izin: " . $izin['total'] . "\n";
    
    // Alfa
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM users LEFT JOIN tb_presensi_guru ON users.id = tb_presensi_guru.id_guru AND tb_presensi_guru.tanggal = ? WHERE users.role = 'guru' AND (tb_presensi_guru.id_kehadiran IS NULL OR tb_presensi_guru.id_kehadiran NOT IN (1,2,3))");
    $stmt->execute([$tanggal]);
    $alfa = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "   Alfa: " . $alfa['total'] . "\n";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== SELESAI ===\n";