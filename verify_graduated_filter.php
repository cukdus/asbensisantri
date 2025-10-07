<?php
// Verify that graduated students are excluded from Data Nilai Siswa page

// Database connection
$host = 'localhost';
$dbname = 'db_absensi';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== VERIFIKASI FILTER SISWA LULUS ===\n\n";
    
    // Check all students in class 20
    echo "1. SEMUA SISWA DI KELAS 20:\n";
    $stmt = $pdo->prepare("
        SELECT s.id_siswa, s.nama_siswa, s.is_graduated, k.kelas, j.jurusan
        FROM tb_siswa s
        LEFT JOIN tb_kelas k ON k.id_kelas = s.id_kelas
        LEFT JOIN tb_jurusan j ON j.id = k.id_jurusan
        WHERE s.id_kelas = 20
        ORDER BY s.nama_siswa
    ");
    $stmt->execute();
    $allStudents = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($allStudents as $student) {
        $status = $student['is_graduated'] == 1 ? 'LULUS' : 'AKTIF';
        echo "   - {$student['nama_siswa']} (ID: {$student['id_siswa']}) - Status: $status\n";
    }
    
    echo "\n2. SISWA YANG AKAN DITAMPILKAN DI HALAMAN DATA NILAI (is_graduated = 0):\n";
    $stmt = $pdo->prepare("
        SELECT s.id_siswa, s.nama_siswa, s.is_graduated, k.kelas, j.jurusan
        FROM tb_siswa s
        LEFT JOIN tb_kelas k ON k.id_kelas = s.id_kelas
        LEFT JOIN tb_jurusan j ON j.id = k.id_jurusan
        WHERE s.id_kelas = 20 AND s.is_graduated = 0
        ORDER BY s.nama_siswa
    ");
    $stmt->execute();
    $activeStudents = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($activeStudents)) {
        echo "   Tidak ada siswa aktif di kelas ini.\n";
    } else {
        foreach ($activeStudents as $student) {
            echo "   - {$student['nama_siswa']} (ID: {$student['id_siswa']})\n";
        }
    }
    
    echo "\n3. SISWA YANG SUDAH LULUS (is_graduated = 1) - TIDAK AKAN DITAMPILKAN:\n";
    $stmt = $pdo->prepare("
        SELECT s.id_siswa, s.nama_siswa, s.is_graduated, k.kelas, j.jurusan
        FROM tb_siswa s
        LEFT JOIN tb_kelas k ON k.id_kelas = s.id_kelas
        LEFT JOIN tb_jurusan j ON j.id = k.id_jurusan
        WHERE s.id_kelas = 20 AND s.is_graduated = 1
        ORDER BY s.nama_siswa
    ");
    $stmt->execute();
    $graduatedStudents = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($graduatedStudents)) {
        echo "   Tidak ada siswa yang sudah lulus di kelas ini.\n";
    } else {
        foreach ($graduatedStudents as $student) {
            echo "   - {$student['nama_siswa']} (ID: {$student['id_siswa']})\n";
        }
    }
    
    echo "\n=== RINGKASAN ===\n";
    echo "Total siswa di kelas 20: " . count($allStudents) . "\n";
    echo "Siswa aktif (akan ditampilkan): " . count($activeStudents) . "\n";
    echo "Siswa lulus (tidak ditampilkan): " . count($graduatedStudents) . "\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>