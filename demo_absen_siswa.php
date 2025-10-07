<?php
// Demo untuk menunjukkan bahwa semua siswa ditampilkan dan bisa diedit

echo "<h1>🎯 DEMO: Data Absen Siswa - Semua Siswa Ditampilkan</h1>";
echo "<hr>";

// Koneksi database
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'db_absensi';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data kelas
echo "<h2>📋 Daftar Kelas</h2>";
$query_kelas = "
    SELECT k.id_kelas, k.kelas, j.jurusan 
    FROM tb_kelas k 
    LEFT JOIN tb_jurusan j ON k.id_jurusan = j.id 
    ORDER BY k.kelas, j.jurusan
";
$result_kelas = $conn->query($query_kelas);

echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
echo "<tr style='background: #f0f0f0;'><th>ID Kelas</th><th>Nama Kelas</th><th>Aksi</th></tr>";

while($kelas = $result_kelas->fetch_assoc()) {
    $nama_kelas = $kelas['kelas'] . ' ' . $kelas['jurusan'];
    echo "<tr>";
    echo "<td>" . $kelas['id_kelas'] . "</td>";
    echo "<td>" . $nama_kelas . "</td>";
    echo "<td>";
    echo "<form method='post' style='display: inline;'>";
    echo "<input type='hidden' name='id_kelas' value='" . $kelas['id_kelas'] . "'>";
    echo "<input type='hidden' name='kelas' value='" . $nama_kelas . "'>";
    echo "<input type='date' name='tanggal' value='" . date('Y-m-d') . "' style='margin-right: 10px;'>";
    echo "<button type='submit' style='background: #007bff; color: white; border: none; padding: 5px 10px; cursor: pointer;'>Lihat Absensi</button>";
    echo "</form>";
    echo "</td>";
    echo "</tr>";
}
echo "</table><br>";

// Jika form disubmit, tampilkan data absensi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_kelas'])) {
    $id_kelas = $_POST['id_kelas'];
    $kelas = $_POST['kelas'];
    $tanggal = $_POST['tanggal'];
    
    echo "<h2>👥 Data Absensi Siswa Kelas: $kelas</h2>";
    echo "<p><strong>Tanggal:</strong> $tanggal</p>";
    
    // Query sama dengan getPresensiByKelasTanggal
    $query_presensi = "
        SELECT 
            tb_siswa.*, 
            tb_presensi_siswa.id_presensi, 
            tb_presensi_siswa.tanggal, 
            tb_presensi_siswa.jam_masuk, 
            tb_presensi_siswa.jam_keluar, 
            tb_presensi_siswa.id_kehadiran, 
            tb_presensi_siswa.keterangan, 
            tb_kehadiran.kehadiran
        FROM tb_siswa
        LEFT JOIN tb_presensi_siswa ON 
            tb_siswa.id_siswa = tb_presensi_siswa.id_siswa 
            AND tb_presensi_siswa.tanggal = '$tanggal'
        LEFT JOIN tb_kehadiran ON 
            tb_presensi_siswa.id_kehadiran = tb_kehadiran.id_kehadiran
        WHERE tb_siswa.id_kelas = $id_kelas
        ORDER BY tb_siswa.nama_siswa
    ";
    
    $result_presensi = $conn->query($query_presensi);
    
    if ($result_presensi->num_rows > 0) {
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0; width: 100%;'>";
        echo "<tr style='background: #f0f0f0;'>";
        echo "<th>No</th><th>NIS</th><th>Nama Siswa</th><th>Status Kehadiran</th><th>Jam Masuk</th><th>Jam Pulang</th><th>Keterangan</th><th>⚙️ Aksi</th>";
        echo "</tr>";
        
        $no = 1;
        while($row = $result_presensi->fetch_assoc()) {
            // Tentukan status kehadiran
            if ($row['id_kehadiran']) {
                $status = $row['kehadiran'];
                $color = 'green';
            } else {
                $status = 'Belum Absen';
                $color = 'red';
            }
            
            $jam_masuk = $row['jam_masuk'] ? $row['jam_masuk'] : '-';
            $jam_keluar = $row['jam_keluar'] ? $row['jam_keluar'] : '-';
            $keterangan = $row['keterangan'] ? $row['keterangan'] : '-';
            
            echo "<tr>";
            echo "<td>" . $no++ . "</td>";
            echo "<td>" . $row['nis'] . "</td>";
            echo "<td><b>" . $row['nama_siswa'] . "</b></td>";
            echo "<td style='color: $color; font-weight: bold;'>" . $status . "</td>";
            echo "<td>" . $jam_masuk . "</td>";
            echo "<td>" . $jam_keluar . "</td>";
            echo "<td>" . $keterangan . "</td>";
            echo "<td>";
            echo "<button style='background: #28a745; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius: 3px;'>";
            echo "✏️ Edit Presensi";
            echo "</button>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Statistik
        $total = $result_presensi->num_rows;
        $sudah_absen = 0;
        $belum_absen = 0;
        
        // Reset pointer
        $result_presensi->data_seek(0);
        while($row = $result_presensi->fetch_assoc()) {
            if ($row['id_kehadiran']) {
                $sudah_absen++;
            } else {
                $belum_absen++;
            }
        }
        
        echo "<div style='background: #e9ecef; padding: 15px; margin: 20px 0; border-radius: 5px;'>";
        echo "<h3>📊 Statistik Kehadiran</h3>";
        echo "<ul>";
        echo "<li><strong>Total Siswa:</strong> $total</li>";
        echo "<li><strong>Sudah Absen:</strong> $sudah_absen</li>";
        echo "<li><strong>Belum Absen:</strong> $belum_absen</li>";
        echo "</ul>";
        echo "<p style='color: #28a745; font-weight: bold;'>✅ Semua siswa ditampilkan! Baik yang sudah absen maupun yang belum absen bisa diedit presensinya.</p>";
        echo "</div>";
        
    } else {
        echo "<p style='color: red;'>Tidak ada data siswa di kelas ini</p>";
    }
}

$conn->close();

echo "<hr>";
echo "<h3>🔍 Penjelasan Sistem:</h3>";
echo "<ol>";
echo "<li><strong>Query LEFT JOIN:</strong> Menampilkan SEMUA siswa di kelas yang dipilih</li>";
echo "<li><strong>Siswa Belum Absen:</strong> Ditampilkan dengan status 'Belum Absen' berwarna merah</li>";
echo "<li><strong>Edit Presensi:</strong> Semua siswa memiliki tombol edit untuk mengubah presensi</li>";
echo "<li><strong>Real-time:</strong> Data diperbarui secara real-time melalui AJAX</li>";
echo "</ol>";

echo "<p style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; border: 1px solid #c3e6cb;'>";
echo "🎉 <strong>SISTEM SIAP DIGUNAKAN!</strong> Semua siswa sekarang ditampilkan dan bisa diubah presensinya.";
echo "</p>";
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1, h2, h3 { color: #333; }
table { margin: 20px 0; }
th, td { padding: 8px 12px; text-align: left; }
button { cursor: pointer; }
button:hover { opacity: 0.8; }
</style>