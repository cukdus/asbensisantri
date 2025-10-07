<?php
$db = new mysqli('localhost', 'root', '', 'db_absensi');
if ($db->connect_error) {
    die('Connection failed: ' . $db->connect_error);
}

echo "Struktur tabel users:\n";
$result = $db->query('DESCRIBE users');
while ($row = $result->fetch_assoc()) {
    echo $row['Field'] . ' - ' . $row['Type'] . ' - ' . $row['Null'] . ' - ' . $row['Key'] . "\n";
}

echo "\n\nData users yang ada:\n";
$result = $db->query('SELECT id, email, username, nama_lengkap, role, nuptk FROM users LIMIT 10');
while ($row = $result->fetch_assoc()) {
    echo "ID: {$row['id']}, Email: {$row['email']}, Username: {$row['username']}, Nama: {$row['nama_lengkap']}, Role: {$row['role']}, NUPTK: {$row['nuptk']}\n";
}

echo "\n\nApakah tabel tb_guru masih ada?\n";
$result = $db->query("SHOW TABLES LIKE 'tb_guru'");
if ($result->num_rows > 0) {
    echo "Ya, tb_guru masih ada\n";
    $result = $db->query('SELECT COUNT(*) as count FROM tb_guru');
    $row = $result->fetch_assoc();
    echo "Jumlah data di tb_guru: " . $row['count'] . "\n";
} else {
    echo "Tidak, tb_guru sudah tidak ada\n";
}

$db->close();
?>