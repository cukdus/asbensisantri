<?php
require_once 'vendor/autoload.php';

// Load CodeIgniter
$pathsConfig = new \Config\Paths();
$bootstrap = rtrim(realpath(ROOTPATH . $pathsConfig->systemDirectory), '\\/') . DIRECTORY_SEPARATOR . 'bootstrap.php';
$app = require $bootstrap;

// Get database connection
$db = \Config\Database::connect();

// Query data nilai with ID 7
$result = $db->query('SELECT * FROM tb_nilai WHERE id_nilai = 7')->getRow();

if ($result) {
    echo "Data nilai ID 7:\n";
    echo "ID Nilai: " . $result->id_nilai . "\n";
    echo "ID Siswa: " . $result->id_siswa . "\n";
    echo "ID Mapel: " . $result->id_mapel . "\n";
    echo "Nilai: " . $result->nilai . "\n";
    echo "Semester: " . $result->semester . "\n";
    echo "Tahun Ajaran: " . $result->tahun_ajaran . "\n";
    echo "Tipe semester: " . gettype($result->semester) . "\n";
    echo "Semester as string: '" . (string)$result->semester . "'\n";
    echo "Semester as int: " . (int)$result->semester . "\n";
} else {
    echo "Data nilai dengan ID 7 tidak ditemukan\n";
}
?>