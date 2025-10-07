<?php
$db = new mysqli('localhost', 'root', '', 'db_absensi');
if ($db->connect_error) {
    die('Connection failed: ' . $db->connect_error);
}

echo "=== STRUKTUR TABEL tb_kelas ===\n";
$result = $db->query("DESCRIBE tb_kelas");
while ($row = $result->fetch_assoc()) {
    echo "{$row['Field']} - {$row['Type']} - {$row['Null']} - {$row['Key']} - {$row['Default']}\n";
}

echo "\n=== SAMPLE DATA tb_kelas ===\n";
$result = $db->query("SELECT * FROM tb_kelas LIMIT 5");
while ($row = $result->fetch_assoc()) {
    print_r($row);
}

$db->close();
?>