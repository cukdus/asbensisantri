<?php

require_once 'app/Config/Paths.php';
require_once 'app/Config/Constants.php';
require_once 'system/bootstrap.php';

use App\Models\PresensiGuruModel;
use Config\Database;

// Inisialisasi database
$db = Database::connect();

// Buat instance model
$presensiGuruModel = new PresensiGuruModel();

$tanggal = '2025-10-01';

echo "=== TEST PRESENSI GURU MODEL ===\n";
echo "Tanggal: $tanggal\n\n";

// Test method getPresensiByKehadiran untuk kehadiran = 1 (Hadir)
echo "1. Testing getPresensiByKehadiran('1', '$tanggal'):\n";
$hadir = $presensiGuruModel->getPresensiByKehadiran('1', $tanggal);
echo "   Jumlah data hadir: " . count($hadir) . "\n";
if (count($hadir) > 0) {
    foreach ($hadir as $data) {
        echo "   - ID: {$data['id']}, Nama: {$data['nama_lengkap']}, Kehadiran: {$data['id_kehadiran']}\n";
    }
}
echo "\n";

// Test method getPresensiByKehadiran untuk kehadiran = 4 (Alfa)
echo "2. Testing getPresensiByKehadiran('4', '$tanggal'):\n";
$alfa = $presensiGuruModel->getPresensiByKehadiran('4', $tanggal);
echo "   Jumlah data alfa: " . count($alfa) . "\n";
if (count($alfa) > 0) {
    foreach ($alfa as $data) {
        echo "   - ID: {$data['id']}, Nama: {$data['nama_lengkap']}, Kehadiran: " . ($data['id_kehadiran'] ?? 'NULL') . "\n";
    }
}
echo "\n";

// Test method getPresensiByTanggal
echo "3. Testing getPresensiByTanggal('$tanggal'):\n";
$allData = $presensiGuruModel->getPresensiByTanggal($tanggal);
echo "   Jumlah total data: " . count($allData) . "\n";
if (count($allData) > 0) {
    foreach ($allData as $data) {
        echo "   - ID: {$data['id']}, Nama: {$data['nama_lengkap']}, Kehadiran: " . ($data['kehadiran'] ?? 'Belum Presensi') . "\n";
    }
}
echo "\n";

echo "=== SELESAI ===\n";