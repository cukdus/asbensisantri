<?php
require_once 'app/Config/Paths.php';
require_once 'app/Config/Database.php';
require_once 'app/Models/PresensiSiswaModel.php';
require_once 'app/Models/KehadiranModel.php';
require_once 'app/Models/KelasModel.php';

use Config\Database;
use App\Models\PresensiSiswaModel;
use App\Models\KehadiranModel;
use App\Models\KelasModel;

echo "<h2>Test Perbaikan Absen Siswa</h2><hr>";

// Test koneksi database
try {
    $db = Database::connect();
    echo "<p style='color: green;'>✓ Koneksi database berhasil</p>";
} catch (\Exception $e) {
    echo "<p style='color: red;'>✗ Koneksi database gagal: " . $e->getMessage() . "</p>";
    exit;
}

// Test model
$presensiModel = new PresensiSiswaModel();
$kehadiranModel = new KehadiranModel();
$kelasModel = new KelasModel();

// Test get data kelas
echo "<h3>Data Kelas:</h3>";
$kelas = $kelasModel->getDataKelas();
if (!empty($kelas)) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Kelas</th><th>Jurusan</th></tr>";
    foreach ($kelas as $k) {
        echo "<tr>";
        echo "<td>" . $k['id_kelas'] . "</td>";
        echo "<td>" . $k['kelas'] . "</td>";
        echo "<td>" . $k['jurusan'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: red;'>Tidak ada data kelas</p>";
}

// Test get presensi untuk kelas 14 tanggal hari ini
echo "<h3>Test Get Presensi Kelas 14:</h3>";
$tanggal = date('Y-m-d');
$presensi = $presensiModel->getPresensiByKelasTanggal(14, $tanggal);

if (!empty($presensi)) {
    echo "<p>Total siswa: " . count($presensi) . "</p>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>No.</th><th>NIS</th><th>Nama</th><th>Kehadiran</th><th>Jam Masuk</th><th>Jam Keluar</th></tr>";
    $no = 1;
    foreach ($presensi as $p) {
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . $p['nis'] . "</td>";
        echo "<td>" . $p['nama_siswa'] . "</td>";
        echo "<td>" . ($p['id_kehadiran'] ?? 'Belum Absen') . "</td>";
        echo "<td>" . ($p['jam_masuk'] ?? '-') . "</td>";
        echo "<td>" . ($p['jam_keluar'] ?? '-') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: orange;'>Tidak ada data presensi untuk kelas 14</p>";
}

// Test get data kehadiran
echo "<h3>Data Kehadiran:</h3>";
$kehadiran = $kehadiranModel->getAllKehadiran();
if (!empty($kehadiran)) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Kehadiran</th></tr>";
    foreach ($kehadiran as $k) {
        echo "<tr>";
        echo "<td>" . $k['id_kehadiran'] . "</td>";
        echo "<td>" . $k['kehadiran'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: red;'>Tidak ada data kehadiran</p>";
}

echo "<hr>";
echo "<p style='color: blue;'><b>Catatan:</b></p>";
echo "<ul>";
echo "<li>Semua URL AJAX sudah diperbaiki (tanpa prefix /admin/)</li>";
echo "<li>Query menggunakan LEFT JOIN untuk menampilkan semua siswa</li>";
echo "<li>Siswa yang belum absen tetap muncul dengan status 'Belum Absen'</li>";
echo "</ul>";
?>