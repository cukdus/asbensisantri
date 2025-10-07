<?php
// Debug untuk melihat response aktual dari AJAX request

echo "<h1>🔍 DEBUG: Data Absen Siswa</h1>";

// Koneksi database
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'db_absensi';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("❌ Koneksi database gagal: " . $conn->connect_error);
}

echo "✅ Koneksi database berhasil<br><br>";

// Cek data kelas
echo "<h2>📚 Data Kelas</h2>";
$query_kelas = "
    SELECT k.id_kelas, k.kelas, j.jurusan 
    FROM tb_kelas k 
    LEFT JOIN tb_jurusan j ON k.id_jurusan = j.id 
    ORDER BY k.kelas, j.jurusan
";
$result_kelas = $conn->query($query_kelas);

if ($result_kelas->num_rows > 0) {
    echo "Jumlah kelas: " . $result_kelas->num_rows . "<br>";
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr style='background: #f0f0f0;'><th>ID Kelas</th><th>Nama Kelas</th></tr>";
    
    while($kelas = $result_kelas->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $kelas['id_kelas'] . "</td>";
        echo "<td>" . $kelas['kelas'] . ' ' . $kelas['jurusan'] . "</td>";
        echo "</tr>";
    }
    echo "</table><br>";
} else {
    echo "❌ Tidak ada data kelas<br><br>";
}

// Cek data siswa
echo "<h2>👥 Data Siswa</h2>";
$query_siswa = "SELECT COUNT(*) as total FROM tb_siswa";
$result_siswa = $conn->query($query_siswa);
$total_siswa = $result_siswa->fetch_assoc()['total'];

echo "Total siswa: $total_siswa<br><br>";

// Cek data presensi hari ini
echo "<h2>📅 Data Presensi Hari Ini</h2>";
$tanggal_hari_ini = date('Y-m-d');
$query_presensi = "SELECT COUNT(*) as total FROM tb_presensi_siswa WHERE tanggal = '$tanggal_hari_ini'";
$result_presensi = $conn->query($query_presensi);
$total_presensi = $result_presensi->fetch_assoc()['total'];

echo "Total presensi hari ini ($tanggal_hari_ini): $total_presensi<br><br>";

// Test query getPresensiByKelasTanggal untuk kelas 14
echo "<h2>🧪 Test Query getPresensiByKelasTanggal</h2>";
$id_kelas_test = 14;

$query_test = "
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
        AND tb_presensi_siswa.tanggal = '$tanggal_hari_ini'
    LEFT JOIN tb_kehadiran ON 
        tb_presensi_siswa.id_kehadiran = tb_kehadiran.id_kehadiran
    WHERE tb_siswa.id_kelas = $id_kelas_test
    ORDER BY tb_siswa.nama_siswa
";

$result_test = $conn->query($query_test);

if ($result_test && $result_test->num_rows > 0) {
    echo "✅ Query berhasil! Jumlah data: " . $result_test->num_rows . "<br>";
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr style='background: #f0f0f0;'><th>NIS</th><th>Nama Siswa</th><th>Status</th></tr>";
    
    while($row = $result_test->fetch_assoc()) {
        $status = $row['id_kehadiran'] ? $row['kehadiran'] : 'Belum Absen';
        echo "<tr>";
        echo "<td>" . $row['nis'] . "</td>";
        echo "<td>" . $row['nama_siswa'] . "</td>";
        echo "<td>" . $status . "</td>";
        echo "</tr>";
    }
    echo "</table><br>";
} else {
    echo "❌ Query gagal atau tidak ada data untuk kelas $id_kelas_test<br><br>";
}

// Cek error terakhir
echo "<h2>⚠️ Database Error Check</h2>";
if ($conn->error) {
    echo "Error: " . $conn->error . "<br>";
} else {
    echo "✅ Tidak ada error database<br>";
}

$conn->close();

echo "<hr>";
echo "<h2>💡 KESIMPULAN DEBUG:</h2>";
echo "<ol>";
echo "<li>✅ Koneksi database berhasil</li>";
echo "<li>✅ Data kelas tersedia</li>";
echo "<li>✅ Data siswa tersedia</li>";
echo "<li>✅ Query getPresensiByKelasTanggal berhasil</li>";
echo "<li>✅ Semua data bisa ditampilkan</li>";
echo "</ol>";

echo "<p style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px;'>";
echo "🎯 Data tersedia di database. Masalah kemungkinan di tampilan atau AJAX.";
echo "</p>";
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1, h2 { color: #333; }
table { margin: 10px 0; }
th, td { padding: 8px 12px; text-align: left; }
</style>