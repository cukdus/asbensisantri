<?php
// File sederhana untuk mengecek data presensi guru
echo "=== CEK DATA PRESENSI GURU ===\n\n";

// Koneksi ke database
$host = 'localhost';
$dbname = 'db_absensi';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Cek tanggal hari ini
    $today = date('Y-m-d');
    echo "Tanggal hari ini: $today\n\n";
    
    // Query SEDERHANA untuk melihat data presensi guru hari ini (tanpa JOIN)
    echo "=== DATA MENTAH DARI tb_presensi_guru ===\n";
    $sql_simple = "SELECT * FROM tb_presensi_guru WHERE tanggal = '2025-10-01'";
    $stmt_simple = $pdo->query($sql_simple);
    $results_simple = $stmt_simple->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Total data mentah: " . count($results_simple) . "\n";
    
    if (count($results_simple) > 0) {
        echo "Data mentah:\n";
        foreach ($results_simple as $row) {
            echo "- ID Presensi: {$row['id_presensi']}, ID Guru: {$row['id_guru']}, ";
            echo "ID Kehadiran: {$row['id_kehadiran']}, Jam Masuk: {$row['jam_masuk']}\n";
        }
    }
    
    // Cek apakah ID guru ada di tabel tb_guru
    echo "\n=== CEK DATA GURU ===\n";
    $sql_guru = "SELECT id_guru, nama_guru FROM tb_guru";
    $stmt_guru = $pdo->query($sql_guru);
    $results_guru = $stmt_guru->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Total guru: " . count($results_guru) . "\n";
    if (count($results_guru) > 0) {
        echo "Daftar guru (10 pertama):\n";
        $count = 0;
        foreach ($results_guru as $row) {
            echo "- ID: {$row['id_guru']}, Nama: {$row['nama_guru']}\n";
            $count++;
            if ($count >= 10) break;
        }
    }
    
    // Cek apakah ID kehadiran ada di tabel tb_kehadiran
    echo "\n=== CEK DATA KEHADIRAN ===\n";
    $sql_kehadiran = "SELECT * FROM tb_kehadiran";
    $stmt_kehadiran = $pdo->query($sql_kehadiran);
    $results_kehadiran = $stmt_kehadiran->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Total jenis kehadiran: " . count($results_kehadiran) . "\n";
    foreach ($results_kehadiran as $row) {
        echo "- ID: {$row['id_kehadiran']}, Kehadiran: {$row['kehadiran']}\n";
    }
    
    // Query dengan LEFT JOIN untuk melihat apakah ada data yang hilang
    echo "\n=== DATA DENGAN LEFT JOIN ===\n";
    $sql_left = "SELECT pg.id_presensi, pg.id_guru, pg.id_kehadiran, pg.tanggal, 
                        g.nama_guru, k.kehadiran
                 FROM tb_presensi_guru pg
                 LEFT JOIN tb_guru g ON pg.id_guru = g.id_guru
                 LEFT JOIN tb_kehadiran k ON pg.id_kehadiran = k.id_kehadiran
                 WHERE pg.tanggal = '2025-10-01'";
    
    $stmt_left = $pdo->query($sql_left);
    $results_left = $stmt_left->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Total data dengan LEFT JOIN: " . count($results_left) . "\n";
    if (count($results_left) > 0) {
        foreach ($results_left as $row) {
            echo "- ID Presensi: {$row['id_presensi']}, ID Guru: {$row['id_guru']}, ";
            echo "Nama Guru: " . ($row['nama_guru'] ?? 'NULL') . ", ";
            echo "ID Kehadiran: {$row['id_kehadiran']}, ";
            echo "Kehadiran: " . ($row['kehadiran'] ?? 'NULL') . "\n";
        }
    }
    
    // Cek data 7 hari terakhir
    echo "\n=== DATA 7 HARI TERAKHIR ===\n";
    for ($i = 0; $i < 7; $i++) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $sql3 = "SELECT COUNT(*) as total, 
                         COUNT(CASE WHEN id_kehadiran = 1 THEN 1 END) as hadir, 
                         COUNT(CASE WHEN id_kehadiran = 2 THEN 1 END) as sakit,
                         COUNT(CASE WHEN id_kehadiran = 3 THEN 1 END) as izin,
                         COUNT(CASE WHEN id_kehadiran = 4 THEN 1 END) as alfa
                  FROM tb_presensi_guru 
                  WHERE tanggal = '$date'";
        
        $stmt3 = $pdo->query($sql3);
        $result3 = $stmt3->fetch(PDO::FETCH_ASSOC);
        
        echo "$date: Total {$result3['total']} (Hadir: {$result3['hadir']}, Sakit: {$result3['sakit']}, Izin: {$result3['izin']}, Alfa: {$result3['alfa']})\n";
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
