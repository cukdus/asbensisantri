<?php
// Test apakah view menerima data dengan benar

echo "<h1>🧪 TEST View Data Reception</h1>";

// Koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_absensi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query seperti di controller
$idKelas = 14;
$tanggal = date('Y-m-d');

$sql = "SELECT s.nis, s.nama_siswa, s.id_siswa, ps.id_presensi, ps.tanggal, ps.jam_masuk, ps.jam_keluar, ps.id_kehadiran, ps.keterangan, ps.lewat 
        FROM tb_siswa s 
        LEFT JOIN tb_presensi_siswa ps ON s.id_siswa = ps.id_siswa AND ps.tanggal = '$tanggal' 
        LEFT JOIN tb_kehadiran k ON ps.id_kehadiran = k.id_kehadiran 
        WHERE s.id_kelas = $idKelas 
        ORDER BY s.nama_siswa ASC";

$result = $conn->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo "<h2>📊 Data yang diterima:</h2>";
echo "Jumlah data: " . count($data) . "<br>";
echo "Query: " . htmlspecialchars($sql) . "<br>";

if (count($data) > 0) {
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>NIS</th><th>Nama</th><th>ID Presensi</th><th>ID Kehadiran</th><th>Status</th></tr>";
    
    foreach ($data as $row) {
        $idKehadiran = intval($row['id_kehadiran'] ?? ($row['lewat'] ? 5 : 4));
        $status = kehadiran($idKehadiran);
        
        echo "<tr>";
        echo "<td>" . $row['nis'] . "</td>";
        echo "<td>" . $row['nama_siswa'] . "</td>";
        echo "<td>" . ($row['id_presensi'] ?? 'NULL') . "</td>";
        echo "<td>" . ($row['id_kehadiran'] ?? 'NULL') . "</td>";
        echo "<td><span style='color: " . $status['color'] . "'>" . $status['text'] . "</span></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: red;'>Tidak ada data!</p>";
}

echo "<h2>🔍 Debug Variables:</h2>";
echo "<pre>";
echo "\$kelas: '1 Iqro\' 1-3'\n";
echo "\$lewat: " . (isset($lewat) ? 'true' : 'false') . "\n";
echo "</pre>";

$conn->close();

// Function seperti di view
function kehadiran($kehadiran): array {
    $text = '';
    $color = '';
    switch ($kehadiran) {
        case 1:
            $color = 'green';
            $text = 'Hadir';
            break;
        case 2:
            $color = 'orange';
            $text = 'Sakit';
            break;
        case 3:
            $color = 'blue';
            $text = 'Izin';
            break;
        case 4:
            $color = 'red';
            $text = 'Tanpa keterangan';
            break;
        case 5:
        default:
            $color = 'gray';
            $text = 'Belum tersedia';
            break;
    }
    return ['color' => $color, 'text' => $text];
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1, h2 { color: #333; }
table { margin: 10px 0; }
th, td { padding: 8px 12px; text-align: left; }
</style>