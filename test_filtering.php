<?php
$host = 'localhost';
$dbname = 'db_absensi';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== Test Filtering untuk Siswa ID 6 (Kelas 21) ===\n";
    
    // Simulate the new filtering logic
    $stmt = $pdo->query("
        SELECT m.id_mapel, m.nama_mapel, m.id_kelas, k.kelas, j.jurusan 
        FROM tb_mapel m 
        LEFT JOIN tb_kelas k ON m.id_kelas = k.id_kelas 
        LEFT JOIN tb_jurusan j ON k.id_jurusan = j.id 
        WHERE (m.id_kelas = 21 OR m.id_kelas IS NULL)
        ORDER BY m.nama_mapel
    ");

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) {
        echo "Tidak ada mata pelajaran ditemukan.\n";
    } else {
        echo "Mata pelajaran yang akan ditampilkan:\n";
        foreach ($results as $row) {
            echo "- {$row['nama_mapel']}";
            if ($row['id_kelas']) {
                echo " (Kelas: {$row['kelas']} - {$row['jurusan']})";
            } else {
                echo " (Untuk semua kelas)";
            }
            echo "\n";
        }
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>