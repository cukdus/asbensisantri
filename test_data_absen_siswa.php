<?php

// Koneksi ke database
$host = 'localhost';
$dbname = 'db_absensi';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Testing Fungsi Data Absen Siswa</h2>";
    echo "<hr>";
    
    // Simulasi parameter yang dikirim dari AJAX
    $id_kelas = 2; // ID kelas 1 Iqro' 1-3 (yang benar)
    $tanggal = '2025-10-01';
    $kelas = '1 Iqro\' 1-3';
    
    echo "<h3>Parameter Testing:</h3>";
    echo "<p>ID Kelas: $id_kelas</p>";
    echo "<p>Kelas: $kelas</p>";
    echo "<p>Tanggal: $tanggal</p>";
    
    // Query sama seperti di PresensiSiswaModel::getPresensiByKelasTanggal
    echo "<h3>Hasil Query getPresensiByKelasTanggal:</h3>";
    
    $builder = $pdo->prepare("
        SELECT tb_siswa.*, tb_presensi_siswa.id_presensi, tb_presensi_siswa.tanggal, tb_presensi_siswa.jam_masuk, tb_presensi_siswa.jam_keluar, tb_presensi_siswa.id_kehadiran, tb_presensi_siswa.keterangan, tb_kehadiran.kehadiran 
        FROM tb_siswa
        LEFT JOIN tb_presensi_siswa
            ON tb_siswa.id_siswa = tb_presensi_siswa.id_siswa AND tb_presensi_siswa.tanggal = ?
        LEFT JOIN tb_kehadiran
            ON tb_presensi_siswa.id_kehadiran = tb_kehadiran.id_kehadiran
        WHERE tb_siswa.id_kelas = ?
        ORDER BY tb_siswa.nama_siswa
    ");
    
    $builder->execute([$tanggal, $id_kelas]);
    $result = $builder->fetchAll(PDO::FETCH_ASSOC);
    
    if ($result) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>ID Siswa</th><th>NIS</th><th>Nama Siswa</th><th>ID Presensi</th><th>Tanggal</th><th>Jam Masuk</th><th>Jam Keluar</th><th>ID Kehadiran</th><th>Kehadiran</th><th>Keterangan</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . ($row['id_siswa'] ?? '-') . "</td>";
            echo "<td>" . ($row['nis'] ?? '-') . "</td>";
            echo "<td>" . ($row['nama_siswa'] ?? '-') . "</td>";
            echo "<td>" . ($row['id_presensi'] ?? '-') . "</td>";
            echo "<td>" . ($row['tanggal'] ?? '-') . "</td>";
            echo "<td>" . ($row['jam_masuk'] ?? '-') . "</td>";
            echo "<td>" . ($row['jam_keluar'] ?? '-') . "</td>";
            echo "<td>" . ($row['id_kehadiran'] ?? '-') . "</td>";
            echo "<td>" . ($row['kehadiran'] ?? '-') . "</td>";
            echo "<td>" . ($row['keterangan'] ?? '-') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<p>Total data: " . count($result) . "</p>";
    } else {
        echo "<p style='color: red;'>Tidak ada data untuk kelas ini</p>";
    }
    
    // Cek apakah ada siswa di kelas ini
    echo "<h3>Data Siswa di Kelas $kelas:</h3>";
    $stmt = $pdo->prepare("SELECT * FROM tb_siswa WHERE id_kelas = ? ORDER BY nama_siswa");
    $stmt->execute([$id_kelas]);
    $siswa_kelas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($siswa_kelas) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>ID Siswa</th><th>NIS</th><th>Nama Siswa</th></tr>";
        foreach ($siswa_kelas as $row) {
            echo "<tr>";
            echo "<td>" . $row['id_siswa'] . "</td>";
            echo "<td>" . $row['nis'] . "</td>";
            echo "<td>" . $row['nama_siswa'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<p>Total siswa di kelas ini: " . count($siswa_kelas) . "</p>";
    } else {
        echo "<p style='color: red;'>Tidak ada siswa di kelas ini</p>";
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>