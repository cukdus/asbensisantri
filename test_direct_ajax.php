<?php
// Test direct AJAX response
header('Content-Type: application/json');

// Simulasikan POST data
$_POST['kelas'] = '1 Iqro\' 1-3';
$_POST['id_kelas'] = '14';
$_POST['tanggal'] = date('Y-m-d');
$_POST['csrf_test_name'] = 'test_token';

// Koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_absensi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Query seperti di getPresensiByKelasTanggal
$sql = "SELECT s.nis, s.nama_siswa, ps.id_presensi, ps.id_kehadiran, ps.jam_masuk, ps.jam_pulang, ps.keterangan, ps.lewat 
        FROM tb_siswa s 
        LEFT JOIN tb_presensi_siswa ps ON s.nis = ps.nis AND ps.tanggal = ? 
        WHERE s.id_kelas = ? 
        ORDER BY s.nama_siswa ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $_POST['tanggal'], $_POST['id_kelas']);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$response = [
    'status' => 'success',
    'count' => count($data),
    'data' => $data,
    'query' => $sql,
    'params' => [$_POST['tanggal'], $_POST['id_kelas']]
];

echo json_encode($response, JSON_PRETTY_PRINT);

$stmt->close();
$conn->close();
?>