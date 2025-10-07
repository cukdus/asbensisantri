<?php
// Test response langsung dari controller tanpa framework

// Set POST data
$_POST['kelas'] = '1 Iqro\' 1-3';
$_POST['id_kelas'] = '14';
$_POST['tanggal'] = date('Y-m-d');

echo "<h1>🧪 Test Controller Response</h1>";
echo "<h2>POST Data:</h2>";
echo "<pre>";
print_r($_POST);
echo "</pre>";

// Koneksi database seperti di CodeIgniter
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_absensi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>✅ Database Connection:</h2>";
echo "<p>Connected successfully</p>";

// Validasi input (seperti di controller)
$kelas = $_POST['kelas'] ?? '';
$idKelas = $_POST['id_kelas'] ?? '';
$tanggal = $_POST['tanggal'] ?? '';

if (empty($kelas) || empty($idKelas) || empty($tanggal)) {
    echo "<div class='error'>❌ Error: Data kelas, id_kelas, dan tanggal wajib diisi</div>";
    exit;
}

echo "<h2>✅ Input Validation:</h2>";
echo "<p>All inputs valid</p>";

// Cek tanggal lewat (seperti di controller)
$tanggalObj = new DateTime($tanggal);
$todayObj = new DateTime();
$lewat = $tanggalObj > $todayObj;

echo "<h2>📅 Date Check:</h2>";
echo "<p>Tanggal: $tanggal</p>";
echo "<p>Hari ini: " . $todayObj->format('Y-m-d') . "</p>";
echo "<p>Lewat: " . ($lewat ? 'Ya' : 'Tidak') . "</p>";

// Query seperti di model
$sql = "SELECT s.nis, s.nama_siswa, s.id_siswa, ps.id_presensi, ps.tanggal, ps.jam_masuk, ps.jam_keluar, ps.id_kehadiran, ps.keterangan 
        FROM tb_siswa s 
        LEFT JOIN tb_presensi_siswa ps ON s.id_siswa = ps.id_siswa AND ps.tanggal = '$tanggal' 
        WHERE s.id_kelas = $idKelas 
        ORDER BY s.nama_siswa ASC";

$result = $conn->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo "<h2>📊 Query Result:</h2>";
echo "<p>Jumlah data: " . count($data) . "</p>";
echo "<p>Query: <code>" . htmlspecialchars($sql) . "</code></p>";

// Cek kehadiran
$kehadiran_result = $conn->query("SELECT * FROM tb_kehadiran");
$kehadiran_data = [];
while ($row = $kehadiran_result->fetch_assoc()) {
    $kehadiran_data[] = $row;
}

echo "<h2>📋 Kehadiran Data:</h2>";
echo "<p>Jumlah data kehadiran: " . count($kehadiran_data) . "</p>";

// Generate view seperti di CodeIgniter
echo "<h2>🎯 Generated View:</h2>";

if (count($data) > 0) {
    ?>
    <div style="border: 1px solid #ccc; padding: 15px; margin: 10px 0;">
        <h4>Data untuk Kelas: <?= htmlspecialchars($kelas) ?></h4>
        <table border="1" style="border-collapse: collapse; width: 100%;">
            <thead>
                <tr style="background: #f5f5f5;">
                    <th>No.</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Kehadiran</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($data as $value): ?>
                    <?php
                    $idKehadiran = intval($value['id_kehadiran'] ?? 4);
                    $kehadiran = getKehadiranInfo($idKehadiran);
                    ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= htmlspecialchars($value['nis']); ?></td>
                        <td><b><?= htmlspecialchars($value['nama_siswa']); ?></b></td>
                        <td>
                            <span style="background: <?= $kehadiran['bg_color'] ?>; color: white; padding: 5px 10px; border-radius: 3px;">
                                <?= $kehadiran['text']; ?>
                            </span>
                        </td>
                        <td><?= $value['jam_masuk'] ?? '-'; ?></td>
                        <td><?= $value['jam_keluar'] ?? '-'; ?></td>
                        <td><?= $value['keterangan'] ?? '-'; ?></td>
                        <td>
                            <?php if (!$lewat): ?>
                                <button style="background: #17a2b8; color: white; border: none; padding: 5px 10px; border-radius: 3px;">
                                    Edit
                                </button>
                            <?php else: ?>
                                <button disabled style="background: #ccc; color: #666; border: none; padding: 5px 10px; border-radius: 3px;">
                                    No Action
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php $no++; endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
} else {
    echo "<div style='background: #ffe6e6; color: #c62828; padding: 15px; border-radius: 4px;'>❌ Tidak ada data siswa untuk kelas ini</div>";
}

$conn->close();

function getKehadiranInfo($kehadiran) {
    $text = '';
    $bg_color = '';
    switch ($kehadiran) {
        case 1:
            $bg_color = '#4CAF50';
            $text = 'Hadir';
            break;
        case 2:
            $bg_color = '#FF9800';
            $text = 'Sakit';
            break;
        case 3:
            $bg_color = '#2196F3';
            $text = 'Izin';
            break;
        case 4:
            $bg_color = '#f44336';
            $text = 'Tanpa keterangan';
            break;
        default:
            $bg_color = '#9E9E9E';
            $text = 'Belum absen';
            break;
    }
    return ['bg_color' => $bg_color, 'text' => $text];
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1, h2 { color: #333; }
table { margin: 10px 0; }
th, td { padding: 8px 12px; text-align: left; }
.error { background: #ffe6e6; color: #c62828; padding: 15px; border-radius: 4px; }
.success { background: #e6ffe6; color: #2e7d32; padding: 15px; border-radius: 4px; }
</style>