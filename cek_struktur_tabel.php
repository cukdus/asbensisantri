<?php
// Cek struktur tabel
echo "<h2>Cek Struktur Tabel</h2><hr>";

$conn = new mysqli('localhost', 'root', '', 'db_absensi');
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek struktur tb_kelas
echo "<h3>Struktur tb_kelas:</h3>";
$result = $conn->query("DESCRIBE tb_kelas");
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
while($row = $result->fetch_assoc()) {
    echo "<tr>";
    foreach($row as $val) {
        echo "<td>" . $val . "</td>";
    }
    echo "</tr>";
}
echo "</table>";

// Cek data tb_kelas
echo "<h3>Data tb_kelas:</h3>";
$result = $conn->query("SELECT * FROM tb_kelas");
echo "<table border='1' cellpadding='5'>";
echo "<tr>";
$fields = $result->fetch_fields();
foreach($fields as $field) {
    echo "<th>" . $field->name . "</th>";
}
echo "</tr>";

while($row = $result->fetch_assoc()) {
    echo "<tr>";
    foreach($row as $val) {
        echo "<td>" . $val . "</td>";
    }
    echo "</tr>";
}
echo "</table>";

$conn->close();
?>