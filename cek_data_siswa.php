<?php

// Koneksi ke database
$host = 'localhost';
$dbname = 'db_absensi';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Cek Data Presensi Siswa</h2>";
    echo "<hr>";
    
    // Cek total data presensi siswa
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM tb_presensi_siswa");
    $total = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Total data presensi siswa: <strong>" . $total['total'] . "</strong></p>";
    
    // Cek data untuk hari ini (2025-10-01)
    $today = '2025-10-01';
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM tb_presensi_siswa WHERE tanggal = ?");
    $stmt->execute([$today]);
    $today_total = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Total presensi siswa tanggal $today: <strong>" . $today_total['total'] . "</strong></p>";
    
    // Cek data detail untuk hari ini
    echo "<h3>Detail Presensi Siswa Tanggal $today:</h3>";
    $stmt = $pdo->prepare("
        SELECT ps.*, s.nama_siswa, s.nis, k.kelas, j.jurusan, kh.kehadiran 
        FROM tb_presensi_siswa ps
        JOIN tb_siswa s ON ps.id_siswa = s.id_siswa
        JOIN tb_kelas k ON s.id_kelas = k.id_kelas
        JOIN tb_jurusan j ON k.id_jurusan = j.id
        LEFT JOIN tb_kehadiran kh ON ps.id_kehadiran = kh.id_kehadiran
        WHERE ps.tanggal = ?
        ORDER BY s.nama_siswa
    ");
    $stmt->execute([$today]);
    $details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($details) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>ID</th><th>NIS</th><th>Nama Siswa</th><th>Kelas</th><th>Kehadiran</th><th>Jam Masuk</th><th>Jam Keluar</th><th>Keterangan</th></tr>";
        foreach ($details as $row) {
            echo "<tr>";
            echo "<td>" . $row['id_presensi'] . "</td>";
            echo "<td>" . $row['nis'] . "</td>";
            echo "<td>" . $row['nama_siswa'] . "</td>";
            echo "<td>" . $row['kelas'] . " " . $row['jurusan'] . "</td>";
            echo "<td>" . ($row['kehadiran'] ?? '-') . "</td>";
            echo "<td>" . ($row['jam_masuk'] ?? '-') . "</td>";
            echo "<td>" . ($row['jam_keluar'] ?? '-') . "</td>";
            echo "<td>" . ($row['keterangan'] ?? '-') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: red;'>Tidak ada data presensi siswa untuk tanggal $today</p>";
    }
    
    // Cek data siswa yang ada
    echo "<h3>Data Siswa:</h3>";
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM tb_siswa");
    $siswa_total = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Total siswa: <strong>" . $siswa_total['total'] . "</strong></p>";
    
    // Cek data kelas yang ada
    echo "<h3>Data Kelas:</h3>";
    $stmt = $pdo->query("
        SELECT k.kelas, j.jurusan, COUNT(s.id_siswa) as jumlah_siswa
        FROM tb_kelas k
        JOIN tb_jurusan j ON k.id_jurusan = j.id
        LEFT JOIN tb_siswa s ON k.id_kelas = s.id_kelas
        GROUP BY k.id_kelas, k.kelas, j.jurusan
        ORDER BY k.kelas, j.jurusan
    ");
    $kelas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>Kelas</th><th>Jurusan</th><th>Jumlah Siswa</th></tr>";
    foreach ($kelas as $row) {
        echo "<tr>";
        echo "<td>" . $row['kelas'] . "</td>";
        echo "<td>" . $row['jurusan'] . "</td>";
        echo "<td>" . $row['jumlah_siswa'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>