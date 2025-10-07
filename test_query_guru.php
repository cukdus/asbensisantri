<?php

// Koneksi langsung ke database
$host = 'localhost';
$dbname = 'db_absensi';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== TEST QUERY PRESENSI GURU ===\n";
    $tanggal = '2025-10-01';
    
    // Test query untuk kehadiran = 1 (Hadir)
    echo "1. Testing query untuk kehadiran = 1 (Hadir):\n";
    $sql = "SELECT users.id, users.nama_lengkap, users.nuptk, users.jenis_kelamin, users.alamat, users.no_hp, users.unique_code, tb_presensi_guru.* 
             FROM users 
             INNER JOIN tb_presensi_guru ON users.id = tb_presensi_guru.id_guru AND tb_presensi_guru.tanggal = ? 
             WHERE users.role = 'guru' AND tb_presensi_guru.id_kehadiran = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$tanggal, 1]);
    $hadir = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "   Jumlah data hadir: " . count($hadir) . "\n";
    if (count($hadir) > 0) {
        foreach ($hadir as $data) {
            echo "   - ID: {$data['id']}, Nama: {$data['nama_lengkap']}, Kehadiran: {$data['id_kehadiran']}\n";
        }
    }
    echo "\n";
    
    // Test query untuk kehadiran = 4 (Alfa)
    echo "2. Testing query untuk kehadiran = 4 (Alfa):\n";
    $sql = "SELECT users.id, users.nama_lengkap, users.nuptk, users.jenis_kelamin, users.alamat, users.no_hp, users.unique_code, tb_presensi_guru.id_kehadiran 
             FROM users 
             LEFT JOIN tb_presensi_guru ON users.id = tb_presensi_guru.id_guru AND tb_presensi_guru.tanggal = ? 
             WHERE users.role = 'guru' AND (tb_presensi_guru.id_kehadiran IS NULL OR tb_presensi_guru.id_kehadiran NOT IN (1,2,3))";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$tanggal]);
    $alfa = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "   Jumlah data alfa: " . count($alfa) . "\n";
    if (count($alfa) > 0) {
        foreach ($alfa as $data) {
            echo "   - ID: {$data['id']}, Nama: {$data['nama_lengkap']}, Kehadiran: " . ($data['id_kehadiran'] ?? 'NULL') . "\n";
        }
    }
    echo "\n";
    
    // Test query untuk semua data dengan tanggal tertentu
    echo "3. Testing query untuk semua data presensi:\n";
    $sql = "SELECT users.id, users.nama_lengkap, users.nuptk, users.jenis_kelamin, users.alamat, users.no_hp, users.unique_code, tb_presensi_guru.id_presensi, tb_presensi_guru.tanggal, tb_presensi_guru.jam_masuk, tb_presensi_guru.jam_keluar, tb_presensi_guru.id_kehadiran, tb_presensi_guru.keterangan, tb_kehadiran.kehadiran 
             FROM users 
             LEFT JOIN tb_presensi_guru ON users.id = tb_presensi_guru.id_guru AND tb_presensi_guru.tanggal = ? 
             LEFT JOIN tb_kehadiran ON tb_presensi_guru.id_kehadiran = tb_kehadiran.id_kehadiran 
             WHERE users.role = 'guru' 
             ORDER BY users.nama_lengkap";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$tanggal]);
    $allData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "   Jumlah total data: " . count($allData) . "\n";
    if (count($allData) > 0) {
        foreach ($allData as $data) {
            echo "   - ID: {$data['id']}, Nama: {$data['nama_lengkap']}, Kehadiran: " . ($data['kehadiran'] ?? 'Belum Presensi') . "\n";
        }
    }
    echo "\n";
    
    // Cek data users yang berperan sebagai guru
    echo "4. Testing data users dengan role guru:\n";
    $sql = "SELECT id, username, nama_lengkap, nuptk FROM users WHERE role = 'guru'";
    $stmt = $pdo->query($sql);
    $guruUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "   Jumlah users guru: " . count($guruUsers) . "\n";
    if (count($guruUsers) > 0) {
        foreach ($guruUsers as $user) {
            echo "   - ID: {$user['id']}, Username: {$user['username']}, Nama: {$user['nama_lengkap']}, NUPTK: {$user['nuptk']}\n";
        }
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== SELESAI ===\n";