<?php

// Koneksi ke database
$host = 'localhost';
$dbname = 'db_absensi';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Cek Data Siswa dan Kelas</h2>";
    echo "<hr>";
    
    // Cek semua data siswa
    echo "<h3>Semua Data Siswa:</h3>";
    $stmt = $pdo->query("SELECT s.*, k.kelas, j.jurusan FROM tb_siswa s JOIN tb_kelas k ON s.id_kelas = k.id_kelas JOIN tb_jurusan j ON k.id_jurusan = j.id ORDER BY s.nama_siswa");
    $siswa = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($siswa) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>ID Siswa</th><th>NIS</th><th>Nama Siswa</th><th>ID Kelas</th><th>Kelas</th><th>Jurusan</th></tr>";
        foreach ($siswa as $row) {
            echo "<tr>";
            echo "<td>" . $row['id_siswa'] . "</td>";
            echo "<td>" . $row['nis'] . "</td>";
            echo "<td>" . $row['nama_siswa'] . "</td>";
            echo "<td>" . $row['id_kelas'] . "</td>";
            echo "<td>" . $row['kelas'] . "</td>";
            echo "<td>" . $row['jurusan'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: red;'>Tidak ada data siswa</p>";
    }
    
    // Cek semua data kelas
    echo "<h3>Semua Data Kelas:</h3>";
    $stmt = $pdo->query("SELECT k.*, j.jurusan FROM tb_kelas k JOIN tb_jurusan j ON k.id_jurusan = j.id ORDER BY k.kelas, j.jurusan");
    $kelas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($kelas) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>ID Kelas</th><th>Kelas</th><th>ID Jurusan</th><th>Jurusan</th></tr>";
        foreach ($kelas as $row) {
            echo "<tr>";
            echo "<td>" . $row['id_kelas'] . "</td>";
            echo "<td>" . $row['kelas'] . "</td>";
            echo "<td>" . $row['id_jurusan'] . "</td>";
            echo "<td>" . $row['jurusan'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // Cek data presensi untuk tanggal 2025-10-01
    echo "<h3>Data Presensi Siswa Tanggal 2025-10-01:</h3>";
    $stmt = $pdo->prepare("SELECT ps.*, s.nama_siswa, s.nis, s.id_kelas FROM tb_presensi_siswa ps JOIN tb_siswa s ON ps.id_siswa = s.id_siswa WHERE ps.tanggal = ?");
    $stmt->execute(['2025-10-01']);
    $presensi = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($presensi) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>ID Presensi</th><th>ID Siswa</th><th>NIS</th><th>Nama Siswa</th><th>ID Kelas</th><th>Tanggal</th><th>Jam Masuk</th><th>ID Kehadiran</th></tr>";
        foreach ($presensi as $row) {
            echo "<tr>";
            echo "<td>" . $row['id_presensi'] . "</td>";
            echo "<td>" . $row['id_siswa'] . "</td>";
            echo "<td>" . $row['nis'] . "</td>";
            echo "<td>" . $row['nama_siswa'] . "</td>";
            echo "<td>" . $row['id_kelas'] . "</td>";
            echo "<td>" . $row['tanggal'] . "</td>";
            echo "<td>" . $row['jam_masuk'] . "</td>";
            echo "<td>" . $row['id_kehadiran'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: red;'>Tidak ada data presensi</p>";
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>