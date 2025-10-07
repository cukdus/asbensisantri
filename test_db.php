<?php

$host = 'localhost';
$dbname = 'db_absensi';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connection successful!\n";

    // Test query
    $idKelas = 14;  // Kelas dengan siswa
    $tanggal = date('Y-m-d');

    $sql = 'SELECT tb_siswa.*, tb_presensi_siswa.id_presensi, tb_presensi_siswa.tanggal, 
            tb_presensi_siswa.jam_masuk, tb_presensi_siswa.jam_keluar, 
            tb_presensi_siswa.id_kehadiran, tb_presensi_siswa.keterangan, 
            tb_kehadiran.kehadiran
            FROM tb_siswa
            LEFT JOIN tb_presensi_siswa ON tb_siswa.id_siswa = tb_presensi_siswa.id_siswa 
                AND tb_presensi_siswa.tanggal = :tanggal
            LEFT JOIN tb_kehadiran ON tb_presensi_siswa.id_kehadiran = tb_kehadiran.id_kehadiran
            WHERE tb_siswa.id_kelas = :idKelas
            ORDER BY tb_siswa.nama_siswa';

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['idKelas' => $idKelas, 'tanggal' => $tanggal]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "\nQuery result:\n";
    print_r($result);

    echo "\nSQL Query:\n" . $sql . "\n";
    echo "Parameters: idKelas = $idKelas, tanggal = $tanggal\n";
} catch (PDOException $e) {
    echo 'Database connection failed: ' . $e->getMessage() . "\n";
    exit(1);
}
