<?php
// Cek struktur tabel jurusan
echo "<h2>Cek Tabel Jurusan</h2><hr>";

$conn = new mysqli('localhost', 'root', '', 'db_absensi');
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek struktur tb_jurusan
echo "<h3>Struktur tb_jurusan:</h3>";
$result = $conn->query("DESCRIBE tb_jurusan");
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

// Cek data tb_jurusan
echo "<h3>Data tb_jurusan:</h3>";
$result = $conn->query("SELECT * FROM tb_jurusan");
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

// Test query getDataKelas seperti di model
echo "<h3>Test Query getDataKelas:</h3>";
$sql = "SELECT tb_kelas.*, tb_jurusan.jurusan 
        FROM tb_kelas 
        JOIN tb_jurusan ON tb_kelas.id_jurusan = tb_jurusan.id 
        ORDER BY tb_kelas.id_kelas";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID Kelas</th><th>Kelas</th><th>Jurusan</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id_kelas'] . "</td>";
        echo "<td>" . $row['kelas'] . "</td>";
        echo "<td>" . $row['jurusan'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Tidak ada data</p>";
}

$conn->close();
?>