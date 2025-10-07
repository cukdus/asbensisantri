<?php
// Test dengan query yang benar sesuai struktur tabel

echo "<h1>🧪 TEST Query yang Benar</h1>";

// Koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_absensi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query yang benar sesuai struktur tabel
$idKelas = 14;
$tanggal = date('Y-m-d');

$sql = "SELECT s.nis, s.nama_siswa, s.id_siswa, ps.id_presensi, ps.tanggal, ps.jam_masuk, ps.jam_keluar, ps.id_kehadiran, ps.keterangan 
        FROM tb_siswa s 
        LEFT JOIN tb_presensi_siswa ps ON s.id_siswa = ps.id_siswa AND ps.tanggal = '$tanggal' 
        WHERE s.id_kelas = $idKelas 
        ORDER BY s.nama_siswa ASC";

$result = $conn->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo "<h2>✅ Data yang diterima:</h2>";
echo "Jumlah data: " . count($data) . "<br>";
echo "Query: " . htmlspecialchars($sql) . "<br>";

if (count($data) > 0) {
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>NIS</th><th>Nama</th><th>ID Presensi</th><th>ID Kehadiran</th><th>Jam Masuk</th><th>Jam Keluar</th><th>Status</th></tr>";
    
    foreach ($data as $row) {
        $idKehadiran = $row['id_kehadiran'] ?? null;
        $status = getStatusKehadiran($idKehadiran);
        
        echo "<tr>";
        echo "<td>" . $row['nis'] . "</td>";
        echo "<td>" . $row['nama_siswa'] . "</td>";
        echo "<td>" . ($row['id_presensi'] ?? 'NULL') . "</td>";
        echo "<td>" . ($idKehadiran ?? 'NULL') . "</td>";
        echo "<td>" . ($row['jam_masuk'] ?? '-') . "</td>";
        echo "<td>" . ($row['jam_keluar'] ?? '-') . "</td>";
        echo "<td><span style='color: " . $status['color'] . "'>" . $status['text'] . "</span></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: red;'>Tidak ada data!</p>";
}

// Cek juga data yang ada di tabel presensi untuk hari ini
echo "<h2>📅 Data Presensi Hari Ini:</h2>";
$presensi_sql = "SELECT * FROM tb_presensi_siswa WHERE tanggal = '$tanggal'";
$presensi_result = $conn->query($presensi_sql);
$presensi_data = [];
while ($row = $presensi_result->fetch_assoc()) {
    $presensi_data[] = $row;
}

echo "Jumlah presensi hari ini: " . count($presensi_data) . "<br>";
if (count($presensi_data) > 0) {
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>ID Presensi</th><th>ID Siswa</th><th>Tanggal</th><th>ID Kehadiran</th></tr>";
    foreach ($presensi_data as $row) {
        echo "<tr>";
        echo "<td>" . $row['id_presensi'] . "</td>";
        echo "<td>" . $row['id_siswa'] . "</td>";
        echo "<td>" . $row['tanggal'] . "</td>";
        echo "<td>" . $row['id_kehadiran'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

$conn->close();

function getStatusKehadiran($idKehadiran) {
    if ($idKehadiran === null) {
        return ['color' => 'orange', 'text' => 'Belum Absen'];
    }
    
    switch ($idKehadiran) {
        case 1: return ['color' => 'green', 'text' => 'Hadir'];
        case 2: return ['color' => 'orange', 'text' => 'Sakit'];
        case 3: return ['color' => 'blue', 'text' => 'Izin'];
        case 4: return ['color' => 'red', 'text' => 'Tanpa Keterangan'];
        default: return ['color' => 'gray', 'text' => 'Unknown'];
    }
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1, h2 { color: #333; }
table { margin: 10px 0; }
th, td { padding: 8px 12px; text-align: left; }
</style>