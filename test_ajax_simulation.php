<?php
// Simulasi response AJAX seperti di controller

$kelas = $_POST['kelas'] ?? '';
$idKelas = $_POST['id_kelas'] ?? '';
$tanggal = $_POST['tanggal'] ?? '';

if (empty($kelas) || empty($idKelas) || empty($tanggal)) {
    echo "<div class='alert alert-danger'>Error: Data tidak lengkap</div>";
    exit;
}

// Koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_absensi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "<div class='alert alert-danger'>Error: Koneksi database gagal</div>";
    exit;
}

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

// Cek apakah ada data
if (count($data) == 0) {
    echo "<div class='alert alert-warning'>Tidak ada data siswa untuk kelas ini</div>";
    $conn->close();
    exit;
}

// Generate HTML seperti view
?>
<div class="card-body">
    <div class="row">
        <div class="col-auto me-auto">
            <div class="pt-3 pl-3">
                <h4><b>Absen Siswa</b></h4>
                <p>Daftar siswa muncul disini</p>
            </div>
        </div>
        <div class="col">
            <a href="#" class="btn btn-primary pl-3 mr-3 mt-3" onclick="kelas = onDateChange()" data-toggle="tab">
                <i class="material-icons mr-2">refresh</i> Refresh
            </a>
        </div>
        <div class="col-auto">
            <div class="px-4">
                <h3 class="text-end">
                    <b class="text-primary"><?= htmlspecialchars($kelas); ?></b>
                </h3>
            </div>
        </div>
    </div>

    <div id="dataSiswa" class="card-body table-responsive pb-5">
        <table class="table table-hover">
            <thead class="text-primary">
                <th><b>No.</b></th>
                <th><b>NIS</b></th>
                <th><b>Nama Siswa</b></th>
                <th><b>Kehadiran</b></th>
                <th><b>Jam masuk</b></th>
                <th><b>Jam pulang</b></th>
                <th><b>Keterangan</b></th>
                <th><b>Aksi</b></th>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($data as $value): ?>
                    <?php
                    $idKehadiran = intval($value['id_kehadiran'] ?? 4);
                    $kehadiran = getKehadiran($idKehadiran);
                    ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= htmlspecialchars($value['nis']); ?></td>
                        <td><b><?= htmlspecialchars($value['nama_siswa']); ?></b></td>
                        <td>
                            <p class="p-2 w-100 btn btn-<?= $kehadiran['color']; ?> text-center">
                                <b><?= $kehadiran['text']; ?></b>
                            </p>
                        </td>
                        <td><b><?= $value['jam_masuk'] ?? '-'; ?></b></td>
                        <td><b><?= $value['jam_keluar'] ?? '-'; ?></b></td>
                        <td><?= $value['keterangan'] ?? '-'; ?></td>
                        <td>
                            <button data-toggle="modal" data-target="#ubahModal" onclick="getDataKehadiran(<?= $value['id_presensi'] ?? '-1'; ?>, <?= $value['id_siswa']; ?>)" class="btn btn-info p-2" id="<?= $value['nis']; ?>">
                                <i class="material-icons">edit</i>
                                Edit
                            </button>
                        </td>
                    </tr>
                <?php $no++; endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$conn->close();

function getKehadiran($kehadiran) {
    $text = '';
    $color = '';
    switch ($kehadiran) {
        case 1:
            $color = 'success';
            $text = 'Hadir';
            break;
        case 2:
            $color = 'warning';
            $text = 'Sakit';
            break;
        case 3:
            $color = 'info';
            $text = 'Izin';
            break;
        case 4:
            $color = 'danger';
            $text = 'Tanpa keterangan';
            break;
        default:
            $color = 'secondary';
            $text = 'Belum absen';
            break;
    }
    return ['color' => $color, 'text' => $text];
}
?>