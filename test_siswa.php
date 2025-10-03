<?php

$host = 'localhost';
$dbname = 'db_absensi';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connection successful!\n";

    // Get all classes
    $sql = "SELECT * FROM tb_kelas";
    $stmt = $pdo->query($sql);
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "\nAvailable classes:\n";
    print_r($classes);

    // Get students from each class
    foreach ($classes as $class) {
        $sql = "SELECT * FROM tb_siswa WHERE id_kelas = :idKelas";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['idKelas' => $class['id_kelas']]);
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "\nStudents in class {$class['kelas']} {$class['jurusan']} (ID: {$class['id_kelas']}):\n";
        print_r($students);
    }

} catch(PDOException $e) {
    echo "Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}