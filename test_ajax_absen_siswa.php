<?php

// Koneksi ke database
$host = 'localhost';
$dbname = 'db_absensi';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Testing Fungsi AJAX Data Absen Siswa</h2>";
    echo "<hr>";
    
    // Simulasi parameter yang dikirim dari AJAX (dari controller DataAbsenSiswa::ambilDataSiswa)
    $id_kelas = 14; // ID kelas 1 Iqro' 1-3
    $tanggal = '2025-10-01';
    $kelas = '1 Iqro\' 1-3';
    
    echo "<h3>Parameter Testing:</h3>";
    echo "<p>ID Kelas: $id_kelas</p>";
    echo "<p>Kelas: $kelas</p>";
    echo "<p>Tanggal: $tanggal</p>";
    
    // Query yang digunakan di DataAbsenSiswa::ambilDataSiswa
    echo "<h3>Query getPresensiByKelasTanggal (seperti di controller):</h3>";
    
    $query = "SELECT ps.*, s.nama_siswa, s.nis, k.kelas, j.jurusan 
              FROM tb_presensi_siswa ps 
              JOIN tb_siswa s ON ps.id_siswa = s.id_siswa 
              JOIN tb_kelas k ON s.id_kelas = k.id_kelas 
              JOIN tb_jurusan j ON k.id_jurusan = j.id 
              WHERE s.id_kelas = ? AND ps.tanggal = ? 
              ORDER BY s.nama_siswa";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_kelas, $tanggal]);
    $presensi = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($presensi) {
        echo "<p style='color: green;'>Ditemukan " . count($presensi) . " data presensi</p>";
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>ID Presensi</th><th>NIS</th><th>Nama Siswa</th><th>Kelas</th><th>Jurusan</th><th>Tanggal</th><th>Jam Masuk</th><th>ID Kehadiran</th></tr>";
        foreach ($presensi as $row) {
            echo "<tr>";
            echo "<td>" . $row['id_presensi'] . "</td>";
            echo "<td>" . $row['nis'] . "</td>";
            echo "<td>" . $row['nama_siswa'] . "</td>";
            echo "<td>" . $row['kelas'] . "</td>";
            echo "<td>" . $row['jurusan'] . "</td>";
            echo "<td>" . $row['tanggal'] . "</td>";
            echo "<td>" . $row['jam_masuk'] . "</td>";
            echo "<td>" . $row['id_kehadiran'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: red;'>Tidak ada data untuk kelas ini</p>";
        
        // Cek apakah ada siswa di kelas ini
        echo "<h3>Data Siswa di Kelas $kelas:</h3>";
        $stmt = $pdo->prepare("SELECT s.* FROM tb_siswa s WHERE s.id_kelas = ? ORDER BY s.nama_siswa");
        $stmt->execute([$id_kelas]);
        $siswa = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($siswa) {
            echo "<p style='color: green;'>Ditemukan " . count($siswa) . " siswa di kelas ini</p>";
            echo "<table border='1' cellpadding='5' cellspacing='0'>";
            echo "<tr><th>ID Siswa</th><th>NIS</th><th>Nama Siswa</th></tr>";
            foreach ($siswa as $row) {
                echo "<tr>";
                echo "<td>" . $row['id_siswa'] . "</td>";
                echo "<td>" . $row['nis'] . "</td>";
                echo "<td>" . $row['nama_siswa'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color: red;'>Tidak ada siswa di kelas ini</p>";
        }
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>