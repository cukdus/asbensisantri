<?php
// Test gender gradient functionality

// Database connection
$host = 'localhost';
$dbname = 'db_absensi';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== TEST GRADASI WARNA BERDASARKAN JENIS KELAMIN ===\n\n";
    
    // Get sample students with different genders
    echo "1. CONTOH SISWA BERDASARKAN JENIS KELAMIN:\n";
    $stmt = $pdo->prepare("
        SELECT s.id_siswa, s.nama_siswa, s.jenis_kelamin, k.kelas, j.jurusan
        FROM tb_siswa s
        LEFT JOIN tb_kelas k ON k.id_kelas = s.id_kelas
        LEFT JOIN tb_jurusan j ON j.id = k.id_jurusan
        WHERE s.is_graduated = 0
        ORDER BY s.jenis_kelamin, s.nama_siswa
        LIMIT 10
    ");
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $maleStudents = [];
    $femaleStudents = [];
    
    foreach ($students as $student) {
        if ($student['jenis_kelamin'] == 'Laki-laki') {
            $maleStudents[] = $student;
        } else {
            $femaleStudents[] = $student;
        }
        
        $gradient = $student['jenis_kelamin'] == 'Perempuan' 
            ? 'PINK (linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%))' 
            : 'BIRU (linear-gradient(135deg, #4facfe 0%, #00f2fe 100%))';
            
        echo "   - {$student['nama_siswa']} (ID: {$student['id_siswa']}) - {$student['jenis_kelamin']} - Gradasi: $gradient\n";
    }
    
    echo "\n2. RINGKASAN GRADASI WARNA:\n";
    echo "   - Siswa Laki-laki: Gradasi BIRU (#4facfe → #00f2fe)\n";
    echo "   - Siswa Perempuan: Gradasi PINK (#ff9a9e → #fecfef)\n";
    
    echo "\n3. URL UNTUK TESTING:\n";
    if (!empty($maleStudents)) {
        $maleStudent = $maleStudents[0];
        echo "   - Siswa Laki-laki: http://localhost/absensi/admin/nilai/tambah-nilai-siswa/{$maleStudent['id_siswa']} ({$maleStudent['nama_siswa']})\n";
    }
    if (!empty($femaleStudents)) {
        $femaleStudent = $femaleStudents[0];
        echo "   - Siswa Perempuan: http://localhost/absensi/admin/nilai/tambah-nilai-siswa/{$femaleStudent['id_siswa']} ({$femaleStudent['nama_siswa']})\n";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>