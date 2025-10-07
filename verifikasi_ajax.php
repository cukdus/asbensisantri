<?php

// Test untuk memverifikasi fungsi AJAX dan data yang dikirim
$host = 'localhost';
$dbname = 'db_absensi';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Verifikasi Fungsi AJAX Data Absen Siswa</h2>";
    echo "<hr>";
    
    // 1. Cek data kelas yang tersedia
    echo "<h3>1. Data Kelas yang Tersedia:</h3>";
    $stmt = $pdo->query("SELECT k.*, j.jurusan FROM tb_kelas k JOIN tb_jurusan j ON k.id_jurusan = j.id ORDER BY k.id_kelas");
    $kelas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>ID Kelas</th><th>Kelas</th><th>Jurusan</th><th>Tombol ID</th></tr>";
    foreach ($kelas as $row) {
        echo "<tr>";
        echo "<td>" . $row['id_kelas'] . "</td>";
        echo "<td>" . $row['kelas'] . "</td>";
        echo "<td>" . $row['jurusan'] . "</td>";
        echo "<td>kelas-" . $row['id_kelas'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // 2. Cek apakah ada data presensi untuk setiap kelas
    echo "<h3>2. Data Presensi per Kelas (Tanggal: 2025-10-01):</h3>";
    foreach ($kelas as $kelas_item) {
        $id_kelas = $kelas_item['id_kelas'];
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM tb_presensi_siswa ps JOIN tb_siswa s ON ps.id_siswa = s.id_siswa WHERE s.id_kelas = ? AND ps.tanggal = ?");
        $stmt->execute([$id_kelas, '2025-10-01']);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<p>Kelas " . $kelas_item['kelas'] . " " . $kelas_item['jurusan'] . " (ID: " . $id_kelas . "): ";
        echo $result['total'] > 0 ? "<span style='color: green;'>" . $result['total'] . " data presensi</span>" : "<span style='color: red;'>Tidak ada data</span>";
        echo "</p>";
    }
    
    // 3. Cek data siswa per kelas
    echo "<h3>3. Jumlah Siswa per Kelas:</h3>";
    foreach ($kelas as $kelas_item) {
        $id_kelas = $kelas_item['id_kelas'];
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM tb_siswa WHERE id_kelas = ?");
        $stmt->execute([$id_kelas]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<p>Kelas " . $kelas_item['kelas'] . " " . $kelas_item['jurusan'] . " (ID: " . $id_kelas . "): ";
        echo $result['total'] > 0 ? "<span style='color: green;'>" . $result['total'] . " siswa</span>" : "<span style='color: red;'>Tidak ada siswa</span>";
        echo "</p>";
    }
    
    // 4. Test query untuk AJAX
    echo "<h3>4. Test Query AJAX untuk Kelas 1 Iqro' 1-3 (ID: 14):</h3>";
    $id_kelas = 14;
    $tanggal = '2025-10-01';
    
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
        echo "<p style='color: green;'>Query berhasil! Ditemukan " . count($presensi) . " data</p>";
    } else {
        echo "<p style='color: red;'>Query tidak mengembalikan data</p>";
    }
    
    // 5. Cek apakah ada error di log
    echo "<h3>5. Cek Error Log:</h3>";
    echo "<p>Silakan cek browser console untuk error JavaScript</p>";
    echo "<p>Dan cek terminal untuk error PHP</p>";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>