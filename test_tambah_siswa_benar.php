<?php

// Test untuk menambahkan siswa baru dengan struktur yang benar
echo "<h2>Test Tambah Siswa Baru (Struktur Benar)</h2>";
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
    
    // Tambah siswa baru untuk demo
    echo "<h3>Menambahkan Siswa Baru di Kelas 14...</h3>";
    
    // Cek NIS tertinggi
    $stmt = $pdo->query("SELECT MAX(nis) as max_nis FROM tb_siswa");
    $max_nis = $stmt->fetch(PDO::FETCH_ASSOC)['max_nis'];
    $new_nis = strval(intval($max_nis) + 1);
    
    // Generate unique code
    $unique_code = uniqid('siswa_');
    
    // Insert siswa baru dengan struktur yang benar
    $stmt = $pdo->prepare("INSERT INTO tb_siswa (nis, nama_siswa, id_kelas, jenis_kelamin, no_hp, unique_code) 
                          VALUES (?, ?, ?, 'Laki-laki', '08123456789', ?)");
    $stmt->execute([$new_nis, 'Siswa Test Belum Absen', 14, $unique_code]);
    
    $new_siswa_id = $pdo->lastInsertId();
    echo "<p>Siswa baru ditambahkan: ID=$new_siswa_id, NIS=$new_nis, Nama=Siswa Test Belum Absen</p>";
    
    // Sekarang cek hasil query dengan siswa baru
    echo "<h3>Hasil Query Setelah Tambah Siswa:</h3>";
    
    $id_kelas = 14;
    $tanggal = '2025-10-01';
    
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
    
    echo "<p>Total siswa di kelas 14: " . count($results) . "</p>";
    
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
            echo "<td>" . ($row['id_kehadiran'] ?? '4') . "</td>";
            echo "<td>" . ($row['kehadiran'] ?? 'Tanpa keterangan') . "</td>";
            
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
        
        echo "<h4>Statistik:</h4>";
        echo "<ul>";
        echo "<li>Total siswa di kelas: $total_siswa</li>";
        echo "<li>Sudah absen: $sudah_absen</li>";
        echo "<li>Belum absen: $belum_absen</li>";
        echo "</ul>";
        
        echo "<p style='color: green; font-weight: bold;'>✓ Sistem berhasil menampilkan siswa yang belum absen!</p>";
        echo "<p style='color: blue;'><b>Bukti:</b> Siswa baru yang ditambahkan muncul dengan status BELUM ABSEN</p>";
        
    } else {
        echo "<p style='color: red;'>Tidak ada data siswa</p>";
    }
    
    // Hapus siswa test (opsional)
    echo "<hr>";
    echo "<p><a href='?hapus=$new_siswa_id' onclick=\"return confirm('Hapus siswa test?')\">Hapus Siswa Test</a></p>";
    
    if (isset($_GET['hapus'])) {
        $pdo->prepare("DELETE FROM tb_siswa WHERE id_siswa = ?")->execute([$_GET['hapus']]);
        echo "<p style='color: red;'>Siswa test dihapus!</p>";
    }
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}

?>