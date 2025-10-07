<?php
// Simulasi response AJAX untuk test
echo "<h2>Test Response AJAX - Simulasi</h2><hr>";

// Simulasikan data yang dikirim oleh AJAX
$_POST['kelas'] = '1 Iqro\' 1-3';
$_POST['id_kelas'] = '14';
$_POST['tanggal'] = date('Y-m-d');
$_POST[csrf_token()] = csrf_hash();

// Include file yang dipanggil oleh AJAX
ob_start();
include 'app/Views/admin/absen/list-absen-siswa.php';
$response = ob_get_clean();

echo "<h3>Response yang akan dikirim ke AJAX:</h3>";
echo "<textarea style='width: 100%; height: 300px;'>" . htmlspecialchars($response) . "</textarea>";

echo "<h3>Preview Response:</h3>";
echo "<div style='border: 1px solid #ccc; padding: 10px; background: #f5f5f5;'>";
echo $response;
echo "</div>";

echo "<hr>";
echo "<p style='color: green;'><b>✓ Response AJAX berhasil dibuat</b></p>";
echo "<p style='color: blue;'><b>Catatan:</b> Response ini akan ditampilkan di div #dataSiswa</p>";

// Fungsi csrf_token dummy
function csrf_token() {
    return 'csrf_test_name';
}

function csrf_hash() {
    return 'test_hash_12345';
}
?>