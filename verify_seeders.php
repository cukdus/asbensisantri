<?php
$db = new mysqli('localhost', 'root', '', 'db_absensi');
if ($db->connect_error) {
    die('Connection failed: ' . $db->connect_error);
}

echo "=== VERIFIKASI DATA SEEDER ===\n\n";

// Check users table (guru data)
echo "1. DATA GURU (dari tabel users):\n";
$result = $db->query("SELECT COUNT(*) as count FROM users WHERE role = 'guru'");
$row = $result->fetch_assoc();
echo "   Total guru: " . $row['count'] . "\n";

$result = $db->query("SELECT id, email, username, nama_lengkap, nuptk, jenis_kelamin, no_hp FROM users WHERE role = 'guru' LIMIT 5");
echo "   Sample data guru:\n";
while ($row = $result->fetch_assoc()) {
    echo "   - ID: {$row['id']}, Nama: {$row['nama_lengkap']}, Email: {$row['email']}, NUPTK: {$row['nuptk']}, Gender: {$row['jenis_kelamin']}, HP: {$row['no_hp']}\n";
}

echo "\n";

// Check tb_siswa table
echo "2. DATA SISWA (dari tabel tb_siswa):\n";
$result = $db->query("SELECT COUNT(*) as count FROM tb_siswa");
$row = $result->fetch_assoc();
echo "   Total siswa: " . $row['count'] . "\n";

$result = $db->query("SELECT id_siswa, nis, nama_siswa, id_kelas, jenis_kelamin, no_hp, nama_orang_tua, alamat, tahun_masuk FROM tb_siswa LIMIT 5");
echo "   Sample data siswa:\n";
while ($row = $result->fetch_assoc()) {
    echo "   - ID: {$row['id_siswa']}, NIS: {$row['nis']}, Nama: {$row['nama_siswa']}, Kelas: {$row['id_kelas']}, Gender: {$row['jenis_kelamin']}, HP: {$row['no_hp']}, Ortu: {$row['nama_orang_tua']}, Tahun: {$row['tahun_masuk']}\n";
}

echo "\n";

// Check superadmin
echo "3. DATA SUPERADMIN:\n";
$result = $db->query("SELECT COUNT(*) as count FROM users WHERE role = 'superadmin'");
$row = $result->fetch_assoc();
echo "   Total superadmin: " . $row['count'] . "\n";

$result = $db->query("SELECT id, email, username FROM users WHERE role = 'superadmin'");
while ($row = $result->fetch_assoc()) {
    echo "   - ID: {$row['id']}, Email: {$row['email']}, Username: {$row['username']}\n";
}

echo "\n";

// Check kelas data
echo "4. DATA KELAS:\n";
$result = $db->query("SELECT COUNT(*) as count FROM tb_kelas");
$row = $result->fetch_assoc();
echo "   Total kelas: " . $row['count'] . "\n";

$result = $db->query("SELECT id_kelas, kelas, id_jurusan FROM tb_kelas LIMIT 5");
echo "   Sample data kelas:\n";
while ($row = $result->fetch_assoc()) {
    echo "   - ID: {$row['id_kelas']}, Kelas: {$row['kelas']}, Jurusan ID: {$row['id_jurusan']}\n";
}

echo "\n=== VERIFIKASI SELESAI ===\n";

$db->close();
?>