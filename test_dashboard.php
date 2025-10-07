<?php

// Bootstrap CodeIgniter
require_once FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();
require_once $paths->systemDirectory . '/bootstrap.php';

use App\Models\PresensiGuruModel;
use App\Models\PresensiSiswaModel;
use CodeIgniter\I18n\Time;

$presensiGuruModel = new PresensiGuruModel();
$presensiSiswaModel = new PresensiSiswaModel();

$today = Time::now()->toDateString();

echo "Testing Dashboard Data for date: $today\n\n";

// Test Guru Attendance
echo "=== GURU ATTENDANCE ===\n";
try {
    $hadirGuru = $presensiGuruModel->getPresensiByKehadiran('1', $today);
    echo 'Hadir: ' . count($hadirGuru) . "\n";

    $sakitGuru = $presensiGuruModel->getPresensiByKehadiran('2', $today);
    echo 'Sakit: ' . count($sakitGuru) . "\n";

    $izinGuru = $presensiGuruModel->getPresensiByKehadiran('3', $today);
    echo 'Izin: ' . count($izinGuru) . "\n";

    $alfaGuru = $presensiGuruModel->getPresensiByKehadiran('4', $today);
    echo 'Alfa: ' . count($alfaGuru) . "\n";
} catch (Exception $e) {
    echo 'Error in Guru queries: ' . $e->getMessage() . "\n";
}

echo "\n=== SISWA ATTENDANCE ===\n";
try {
    $hadirSiswa = $presensiSiswaModel->getPresensiByKehadiran('1', $today);
    echo 'Hadir: ' . count($hadirSiswa) . "\n";

    $sakitSiswa = $presensiSiswaModel->getPresensiByKehadiran('2', $today);
    echo 'Sakit: ' . count($sakitSiswa) . "\n";

    $izinSiswa = $presensiSiswaModel->getPresensiByKehadiran('3', $today);
    echo 'Izin: ' . count($izinSiswa) . "\n";

    $alfaSiswa = $presensiSiswaModel->getPresensiByKehadiran('4', $today);
    echo 'Alfa: ' . count($alfaSiswa) . "\n";
} catch (Exception $e) {
    echo 'Error in Siswa queries: ' . $e->getMessage() . "\n";
}

echo "\nTest completed.\n";
