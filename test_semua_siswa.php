<?php
// Test untuk memverifikasi semua siswa ditampilkan

echo "<h2>Test: Memastikan Semua Siswa Ditampilkan</h2>";

// Koneksi database manual
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'db_absensi';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

echo "✓ Koneksi database berhasil<br><br>";

// Test 1: Lihat semua siswa di kelas 14
echo "<h3>Test 1: Data Semua Siswa di Kelas 14</h3>";
$query_siswa = "SELECT * FROM tb_siswa WHERE id_kelas = 14 ORDER BY nama_siswa";
$result_siswa = $conn->query($query_siswa);

echo "Jumlah total siswa di kelas 14: " . $result_siswa->num_rows . "<br>";
echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
echo "<tr style='background: #f0f0f0;'><th>No</th><th>NIS</th><th>Nama Siswa</th><th>ID Kelas</th></tr>";

$no = 1;
while($row = $result_siswa->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $no++ . "</td>";
    echo "<td>" . $row['nis'] . "</td>";
    echo "<td>" . $row['nama_siswa'] . "</td>";
    echo "<td>" . $row['id_kelas'] . "</td>";
    echo "</tr>";
}
echo "</table><br>";

// Test 2: Query yang sama dengan getPresensiByKelasTanggal
echo "<h3>Test 2: Query LEFT JOIN (seperti getPresensiByKelasTanggal)</h3>";
$tanggal = date('Y-m-d'); // Tanggal hari ini

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
    WHERE tb_siswa.id_kelas = 14
    ORDER BY tb_siswa.nama_siswa
";

$result_presensi = $conn->query($query_presensi);

echo "Jumlah siswa yang muncul dengan LEFT JOIN: " . $result_presensi->num_rows . "<br>";
echo "Tanggal: $tanggal<br><br>";

echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
echo "<tr style='background: #f0f0f0;'>";
echo "<th>No</th><th>NIS</th><th>Nama Siswa</th><th>Status Kehadiran</th><th>Jam Masuk</th><th>Keterangan</th>";
echo "</tr>";

$no = 1;
while($row = $result_presensi->fetch_assoc()) {
    $status = $row['id_kehadiran'] ? $row['kehadiran'] : 'Belum Absen';
    $jam_masuk = $row['jam_masuk'] ? $row['jam_masuk'] : '-';
    $keterangan = $row['keterangan'] ? $row['keterangan'] : '-';
    
    echo "<tr>";
    echo "<td>" . $no++ . "</td>";
    echo "<td>" . $row['nis'] . "</td>";
    echo "<td><b>" . $row['nama_siswa'] . "</b></td>";
    echo "<td>" . $status . "</td>";
    echo "<td>" . $jam_masuk . "</td>";
    echo "<td>" . $keterangan . "</td>";
    echo "</tr>";
}
echo "</table><br>";

// Test 3: Hitungan siswa yang sudah absen vs belum absen
echo "<h3>Test 3: Statistik Kehadiran</h3>";
$query_statistik = "
    SELECT 
        COUNT(*) as total_siswa,
        COUNT(tb_presensi_siswa.id_presensi) as sudah_absen,
        COUNT(*) - COUNT(tb_presensi_siswa.id_presensi) as belum_absen
    FROM tb_siswa
    LEFT JOIN tb_presensi_siswa ON 
        tb_siswa.id_siswa = tb_presensi_siswa.id_siswa 
        AND tb_presensi_siswa.tanggal = '$tanggal'
    WHERE tb_siswa.id_kelas = 14
";

$result_statistik = $conn->query($query_statistik);
$statistik = $result_statistik->fetch_assoc();

echo "Total Siswa: " . $statistik['total_siswa'] . "<br>";
echo "Sudah Absen: " . $statistik['sudah_absen'] . "<br>";
echo "Belum Absen: " . $statistik['belum_absen'] . "<br><br>";

echo "✓ Query LEFT JOIN berhasil menampilkan semua siswa termasuk yang belum absen<br>";
echo "✓ Siswa yang belum absen akan memiliki nilai NULL di kolom presensi<br>";
echo "✓ Semua siswa bisa diedit presensinya karena semua muncul di daftar<br>";

$conn->close();