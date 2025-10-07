<?php
$db = new mysqli('localhost', 'root', '', 'db_absensi');
if ($db->connect_error) {
    die('Connection failed: ' . $db->connect_error);
}

$result = $db->query('DESCRIBE tb_guru');
echo "Struktur tabel tb_guru:\n";
while ($row = $result->fetch_assoc()) {
    echo $row['Field'] . ' - ' . $row['Type'] . ' - ' . $row['Null'] . ' - ' . $row['Key'] . "\n";
}

$db->close();
?>