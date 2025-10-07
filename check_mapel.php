<?php
$host = 'localhost';
$dbname = 'db_absensi';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== Data Mata Pelajaran ===\n";
    $stmt = $pdo->query("
        SELECT m.id_mapel, m.nama_mapel, m.id_kelas, k.kelas, j.jurusan 
        FROM tb_mapel m 
        LEFT JOIN tb_kelas k ON m.id_kelas = k.id_kelas 
        LEFT JOIN tb_jurusan j ON k.id_jurusan = j.id 
        ORDER BY m.id_mapel
    ");

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) {
        echo "Tidak ada data mata pelajaran.\n";
    } else {
        foreach ($results as $row) {
            echo "ID: {$row['id_mapel']}, Nama: {$row['nama_mapel']}, ID Kelas: {$row['id_kelas']}, ";
            if ($row['id_kelas']) {
                echo "Kelas: {$row['kelas']} - {$row['jurusan']}\n";
            } else {
                echo "Kelas: Semua Kelas\n";
            }
        }
    }

    echo "\n=== Semua Data Kelas ===\n";
    $stmt3 = $pdo->query("
        SELECT k.id_kelas, k.kelas, j.jurusan 
        FROM tb_kelas k 
        LEFT JOIN tb_jurusan j ON k.id_jurusan = j.id 
        ORDER BY k.id_kelas
    ");

    $kelas_results = $stmt3->fetchAll(PDO::FETCH_ASSOC);
    foreach ($kelas_results as $kelas) {
        echo "ID Kelas: {$kelas['id_kelas']}, Kelas: {$kelas['kelas']} - {$kelas['jurusan']}\n";
    }

    echo "\n=== Data Siswa ID 6 ===\n";
    $stmt2 = $pdo->query("
        SELECT s.id_siswa, s.nama_siswa, s.id_kelas, k.kelas, j.jurusan 
        FROM tb_siswa s 
        LEFT JOIN tb_kelas k ON s.id_kelas = k.id_kelas 
        LEFT JOIN tb_jurusan j ON k.id_jurusan = j.id 
        WHERE s.id_siswa = 6
    ");

    $siswa = $stmt2->fetch(PDO::FETCH_ASSOC);
    if ($siswa) {
        echo "Siswa: {$siswa['nama_siswa']}, Kelas: {$siswa['kelas']} - {$siswa['jurusan']} (ID Kelas: {$siswa['id_kelas']})\n";
    } else {
        echo "Siswa dengan ID 6 tidak ditemukan.\n";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>