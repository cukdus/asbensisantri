<?php

// Test untuk melihat struktur tabel siswa
echo "<h2>Test Struktur Tabel Siswa</h2>";
echo "<hr>";

// Koneksi database
$host = 'localhost';
$dbname = 'db_absensi';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✓ Koneksi database berhasil</p>";
    
    // Lihat struktur tabel
    echo "<h3>Struktur Tabel tb_siswa:</h3>";
    
    $query = "SHOW COLUMNS FROM tb_siswa";
    $stmt = $pdo->query($query);
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    
    foreach ($columns as $col) {
        echo "<tr>";
        echo "<td>" . $col['Field'] . "</td>";
        echo "<td>" . $col['Type'] . "</td>";
        echo "<td>" . $col['Null'] . "</td>";
        echo "<td>" . $col['Key'] . "</td>";
        echo "<td>" . ($col['Default'] ?? 'NULL') . "</td>";
        echo "<td>" . $col['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Lihat data siswa yang ada
    echo "<h3>Data Siswa yang Ada:</h3>";
    
    $query = "SELECT id_siswa, nis, nama_siswa, id_kelas FROM tb_siswa ORDER BY id_kelas, nama_siswa";
    $stmt = $pdo->query($query);
    $siswa = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>ID Siswa</th><th>NIS</th><th>Nama Siswa</th><th>ID Kelas</th></tr>";
    
    foreach ($siswa as $s) {
        echo "<tr>";
        echo "<td>" . $s['id_siswa'] . "</td>";
        echo "<td>" . $s['nis'] . "</td>";
        echo "<td>" . $s['nama_siswa'] . "</td>";
        echo "<td>" . $s['id_kelas'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}

?>