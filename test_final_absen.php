<?php
// Test final untuk absen siswaecho "<h2>Final Test - Absen Siswa</h2><hr>";

// Koneksi database
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'db_absensi';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

echo "<p style='color: green;'>✓ Koneksi database berhasil</p>";

// Test 1: Cek apakah ada data kelas
echo "<h3>Test 1: Data Kelas</h3>";
$sql_kelas = "SELECT * FROM tb_kelas ORDER BY id_kelas";
$result_kelas = $conn->query($sql_kelas);
if ($result_kelas->num_rows > 0) {
    echo "<p>Total kelas: " . $result_kelas->num_rows . "</p>";
    while($row = $result_kelas->fetch_assoc()) {
        echo "<button style='margin: 5px; padding: 10px; background: #007bff; color: white; border: none; border-radius: 5px;'>";
        echo $row['kelas'] . " " . $row['jurusan'];
        echo "</button> ";
    }
    echo "<br><br>";
} else {
    echo "<p style='color: red;'>Tidak ada data kelas!</p>";
}

// Test 2: Cek apakah ada data siswa
echo "<h3>Test 2: Data Siswa per Kelas</h3>";
$sql_siswa_per_kelas = "
    SELECT k.id_kelas, k.kelas, k.jurusan, COUNT(s.id_siswa) as jumlah_siswa
    FROM tb_kelas k
    LEFT JOIN tb_siswa s ON k.id_kelas = s.id_kelas
    GROUP BY k.id_kelas
    ORDER BY k.id_kelas
";
$result_siswa = $conn->query($sql_siswa_per_kelas);
if ($result_siswa->num_rows > 0) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Kelas</th><th>Jumlah Siswa</th></tr>";
    while($row = $result_siswa->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['kelas'] . " " . $row['jurusan'] . "</td>";
        echo "<td>" . $row['jumlah_siswa'] . " siswa</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: red;'>Tidak ada data siswa!</p>";
}

// Test 3: Simulasi AJAX request
echo "<h3>Test 3: Simulasi Data Absen Siswa (Kelas 14, Tanggal " . date('Y-m-d') . ")</h3>";
$tanggal = date('Y-m-d');
$id_kelas = 14;

$sql_presensi = "
    SELECT 
        s.id_siswa, 
        s.nis, 
        s.nama_siswa, 
        ps.id_presensi,
        ps.id_kehadiran,
        ps.jam_masuk,
        ps.jam_keluar,
        ps.keterangan,
        ps.tanggal
    FROM tb_siswa s
    LEFT JOIN tb_presensi_siswa ps ON s.id_siswa = ps.id_siswa 
        AND ps.tanggal = ?
    WHERE s.id_kelas = ?
    ORDER BY s.nama_siswa ASC
";

$stmt = $conn->prepare($sql_presensi);
$stmt->bind_param("si", $tanggal, $id_kelas);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<p>Total siswa di kelas 14: " . $result->num_rows . "</p>";
    echo "<table border='1' cellpadding='5' style='background: white;'>";
    echo "<tr><th>No.</th><th>NIS</th><th>Nama Siswa</th><th>Status</th><th>Jam Masuk</th><th>Jam Keluar</th></tr>";
    $no = 1;
    while ($row = $result->fetch_assoc()) {
        $status = $row['id_presensi'] ? 'Sudah Absen' : 'Belum Absen';
        $warna = $row['id_presensi'] ? 'green' : 'red';
        
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . $row['nis'] . "</td>";
        echo "<td><b>" . $row['nama_siswa'] . "</b></td>";
        echo "<td style='color: $warna;'><b>" . $status . "</b></td>";
        echo "<td>" . ($row['jam_masuk'] ?? '-') . "</td>";
        echo "<td>" . ($row['jam_keluar'] ?? '-') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: orange;'>Tidak ada data siswa untuk kelas 14</p>";
}

// Test 4: Cek apakah URL AJAX sudah benar
echo "<h3>Test 4: URL AJAX yang Digunakan</h3>";
echo "<ul>";
echo "<li><b>Get Data Siswa:</b> absen-siswa</li>";
echo "<li><b>Get Kehadiran:</b> absen-siswa/kehadiran</li>";
echo "<li><b>Edit Kehadiran:</b> absen-siswa/edit</li>";
echo "</ul>";

$conn->close();
?>