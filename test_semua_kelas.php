<?php

// Test untuk melihat semua kelas dan jumlah siswanya
echo "<h2>Test Semua Kelas dan Jumlah Siswa</h2>";
echo "<hr>";

// Koneksi database
$host = 'localhost';
$dbname = 'db_absensi';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✓ Koneksi database berhasil</p>";
    
    // Lihat semua kelas
    echo "<h3>Daftar Kelas dan Jumlah Siswa:</h3>";
    
    $query = "SELECT k.id_kelas, k.kelas, j.jurusan, COUNT(s.id_siswa) as jumlah_siswa
              FROM tb_kelas k
              JOIN tb_jurusan j ON k.id_jurusan = j.id
              LEFT JOIN tb_siswa s ON k.id_kelas = s.id_kelas
              GROUP BY k.id_kelas, k.kelas, j.jurusan
              ORDER BY k.kelas";
    
    $stmt = $pdo->query($query);
    $kelas_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>ID Kelas</th><th>Kelas</th><th>Jurusan</th><th>Jumlah Siswa</th></tr>";
    
    foreach ($kelas_list as $kelas) {
        echo "<tr>";
        echo "<td>" . $kelas['id_kelas'] . "</td>";
        echo "<td>" . $kelas['kelas'] . "</td>";
        echo "<td>" . $kelas['jurusan'] . "</td>";
        echo "<td>" . $kelas['jumlah_siswa'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Test untuk kelas dengan banyak siswa
    echo "<h3>Test Kelas 15 (2 Iqro' 4-6):</h3>";
    
    $id_kelas = 15;
    $tanggal = '2025-10-01';
    
    // Query untuk mendapatkan semua siswa termasuk yang belum absen
    $query = "SELECT tb_siswa.*, tb_presensi_siswa.id_presensi, tb_presensi_siswa.tanggal, 
                     tb_presensi_siswa.jam_masuk, tb_presensi_siswa.jam_keluar, 
                     tb_presensi_siswa.id_kehadiran, tb_kehadiran.kehadiran
              FROM tb_siswa
              LEFT JOIN tb_presensi_siswa 
                  ON tb_siswa.id_siswa = tb_presensi_siswa.id_siswa 
                  AND tb_presensi_siswa.tanggal = ?
              LEFT JOIN tb_kehadiran 
                  ON tb_presensi_siswa.id_kehadiran = tb_kehadiran.id_kehadiran
              WHERE tb_siswa.id_kelas = ?
              ORDER BY tb_siswa.nama_siswa";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([$tanggal, $id_kelas]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<p>Total siswa di kelas 15: " . count($results) . "</p>";
    
    if ($results) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>No.</th><th>ID Siswa</th><th>NIS</th><th>Nama Siswa</th><th>ID Presensi</th><th>Jam Masuk</th><th>ID Kehadiran</th><th>Kehadiran</th><th>Status</th></tr>";
        
        $no = 1;
        foreach ($results as $row) {
            echo "<tr>";
            echo "<td>" . $no . "</td>";
            echo "<td>" . $row['id_siswa'] . "</td>";
            echo "<td>" . $row['nis'] . "</td>";
            echo "<td><b>" . $row['nama_siswa'] . "</b></td>";
            echo "<td>" . ($row['id_presensi'] ?? 'NULL') . "</td>";
            echo "<td>" . ($row['jam_masuk'] ?? '-') . "</td>";
            echo "<td>" . ($row['id_kehadiran'] ?? 'NULL') . "</td>";
            echo "<td>" . ($row['kehadiran'] ?? '-') . "</td>";
            
            // Tentukan status
            if (empty($row['id_presensi'])) {
                echo "<td style='color: red;'><b>BELUM ABSEN</b></td>";
            } else {
                echo "<td style='color: green;'><b>SUDAH ABSEN</b></td>";
            }
            
            echo "</tr>";
            $no++;
        }
        echo "</table>";
        
        // Hitung statistik
        $total_siswa = count($results);
        $sudah_absen = count(array_filter($results, function($row) {
            return !empty($row['id_presensi']);
        }));
        $belum_absen = $total_siswa - $sudah_absen;
        
        echo "<h4>Statistik Kelas 15:</h4>";
        echo "<ul>";
        echo "<li>Total siswa di kelas: $total_siswa</li>";
        echo "<li>Sudah absen: $sudah_absen</li>";
        echo "<li>Belum absen: $belum_absen</li>";
        echo "</ul>";
        
    } else {
        echo "<p style='color: red;'>Tidak ada data siswa di kelas ini</p>";
    }
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}

?>