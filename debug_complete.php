<?php
// Debug halaman absen siswa - versi lengkap dengan error handling

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_absensi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data kelas
$kelas_result = $conn->query("SELECT * FROM tb_kelas");
$kelas_data = [];
while ($row = $kelas_result->fetch_assoc()) {
    $kelas_data[] = $row;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Data Absen Siswa</title>
    <style>
        body { 
            font-family: 'Roboto', Arial, sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: #f5f5f5;
        }
        .container { max-width: 1200px; margin: 0 auto; }
        .card { 
            background: white; 
            border-radius: 8px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
            margin: 20px 0; 
            padding: 20px; 
        }
        .btn { 
            padding: 12px 20px; 
            margin: 8px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary { background: #2196F3; color: white; }
        .btn-primary:hover { background: #1976D2; }
        .btn-success { background: #4CAF50; color: white; }
        .btn-success:hover { background: #388E3C; }
        .loading { 
            text-align: center; 
            padding: 40px; 
            color: #666;
        }
        .error { 
            background: #ffebee; 
            color: #c62828; 
            padding: 15px; 
            border-radius: 4px; 
            border-left: 4px solid #f44336;
            margin: 10px 0;
        }
        .success { 
            background: #e8f5e8; 
            color: #2e7d32; 
            padding: 15px; 
            border-radius: 4px; 
            border-left: 4px solid #4caf50;
            margin: 10px 0;
        }
        .debug-info {
            background: #e3f2fd;
            color: #1565c0;
            padding: 15px;
            border-radius: 4px;
            border-left: 4px solid #2196f3;
            margin: 10px 0;
            font-family: monospace;
            font-size: 13px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px;
            background: white;
        }
        th { 
            background: #f5f5f5; 
            padding: 12px; 
            text-align: left; 
            font-weight: 600;
            border-bottom: 2px solid #ddd;
        }
        td { 
            padding: 12px; 
            border-bottom: 1px solid #eee; 
        }
        .status-hadir { color: #4CAF50; font-weight: 500; }
        .status-sakit { color: #FF9800; font-weight: 500; }
        .status-izin { color: #2196F3; font-weight: 500; }
        .status-tanpa-ket { color: #f44336; font-weight: 500; }
        .status-belum { color: #9E9E9E; font-weight: 500; }
        .console-output {
            background: #263238;
            color: #aed581;
            padding: 15px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            max-height: 300px;
            overflow-y: auto;
            margin: 10px 0;
        }
        .material-icons {
            vertical-align: middle;
            margin-right: 8px;
        }
        input[type="date"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>🔍 Debug Data Absen Siswa</h1>
            <p>Halaman ini untuk debugging masalah data yang tidak muncul di halaman admin.</p>
        </div>

        <div class="card">
            <h3>📚 Pilih Kelas</h3>
            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                <?php foreach ($kelas_data as $value): ?>
                    <?php $namaKelas = $value['kelas'] . ' ' . $value['jurusan']; ?>
                    <button class="btn btn-primary" onclick="getSiswa(<?= $value['id_kelas']; ?>, '<?= addslashes($namaKelas); ?>')">
                        <?= htmlspecialchars($namaKelas); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="card">
            <h3>📅 Tanggal</h3>
            <div style="display: flex; align-items: center; gap: 15px;">
                <input type="date" id="tanggal" value="<?= date('Y-m-d'); ?>" onchange="onDateChange()">
                <button class="btn btn-success" onclick="getLastRequest()">🔄 Test Ulang Request Terakhir</button>
            </div>
        </div>

        <div id="debugInfo" class="card" style="display: none;">
            <h3>🔧 Debug Info</h3>
            <div id="debugContent"></div>
        </div>

        <div id="consoleOutput" class="card" style="display: none;">
            <h3>🖥️ Console Output</h3>
            <div id="consoleContent" class="console-output"></div>
        </div>

        <div id="dataSiswa" class="card">
            <h3>📋 Data Siswa</h3>
            <div id="resultContent">
                <p style="color: #666; text-align: center; padding: 40px;">
                    Klik salah satu tombol kelas di atas untuk melihat data siswa...
                </p>
            </div>
        </div>
    </div>

    <script>
        let lastIdKelas = null;
        let lastKelas = null;
        let requestCount = 0;

        function logToConsole(message, type = 'info') {
            const timestamp = new Date().toLocaleTimeString();
            const consoleDiv = document.getElementById('consoleContent');
            const consoleOutput = document.getElementById('consoleOutput');
            
            let color = '#aed581';
            if (type === 'error') color = '#ff8a80';
            if (type === 'success') color = '#69f0ae';
            if (type === 'warning') color = '#ffd54f';
            
            consoleDiv.innerHTML += `<div style="color: ${color}">[${timestamp}] ${message}</div>`;
            consoleDiv.scrollTop = consoleDiv.scrollHeight;
            consoleOutput.style.display = 'block';
        }

        function showDebugInfo(info) {
            document.getElementById('debugContent').innerHTML = info;
            document.getElementById('debugInfo').style.display = 'block';
        }

        function onDateChange() {
            if (lastIdKelas != null && lastKelas != null) {
                getSiswa(lastIdKelas, lastKelas);
            }
        }

        function getLastRequest() {
            if (lastIdKelas != null && lastKelas != null) {
                getSiswa(lastIdKelas, lastKelas);
            } else {
                alert('Belum ada request sebelumnya');
            }
        }

        function getSiswa(idKelas, kelas) {
            const tanggal = document.getElementById('tanggal').value;
            const resultDiv = document.getElementById('resultContent');
            
            requestCount++;
            logToConsole(`Request #${requestCount}: Mengambil data untuk kelas ${kelas} (${idKelas}) pada ${tanggal}`);
            
            // Tampilkan loading
            resultDiv.innerHTML = '<div class="loading">⏳ Sedang memuat data siswa...</div>';
            
            // Debug info
            showDebugInfo(`
                <strong>Request Details:</strong><br>
                ID Kelas: ${idKelas}<br>
                Nama Kelas: ${kelas}<br>
                Tanggal: ${tanggal}<br>
                URL: test_ajax_simulation.php<br>
                Method: POST
            `);

            // AJAX request
            fetch('test_ajax_simulation.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `kelas=${encodeURIComponent(kelas)}&id_kelas=${idKelas}&tanggal=${tanggal}`
            })
            .then(response => {
                logToConsole(`Response status: ${response.status} ${response.statusText}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text();
            })
            .then(data => {
                logToConsole(`Response diterima: ${data.length} karakter`, 'success');
                
                if (data.length === 0) {
                    resultDiv.innerHTML = '<div class="error">❌ Response kosong!</div>';
                    logToConsole('Response kosong!', 'error');
                } else if (data.includes('Error:') || data.includes('error')) {
                    resultDiv.innerHTML = '<div class="error">❌ ' + data + '</div>';
                    logToConsole('Error dalam response: ' + data, 'error');
                } else {
                    resultDiv.innerHTML = data;
                    logToConsole('Data berhasil dimuat!', 'success');
                    
                    // Cek apakah ada data dalam tabel
                    const tableRows = data.match(/<tr[^>]*>(.*?)<\/tr>/gi);
                    const dataRows = tableRows ? tableRows.length - 1 : 0; // Kurangi 1 untuk header row
                    logToConsole(`Jumlah baris data: ${dataRows}`);
                }
            })
            .catch(error => {
                resultDiv.innerHTML = '<div class="error">❌ Error: ' + error.message + '</div>';
                logToConsole('Fetch error: ' + error.message, 'error');
                console.error('Full error:', error);
            });

            lastIdKelas = idKelas;
            lastKelas = kelas;
        }

        // Log awal
        logToConsole('Debug halaman dimuat');
        logToConsole('Jumlah kelas tersedia: <?= count($kelas_data); ?>');
        
        // Cek apakah ada data di database
        <?php
        $test_result = $conn->query("SELECT COUNT(*) as total FROM tb_siswa WHERE id_kelas = 14");
        $test_count = $test_result->fetch_assoc()['total'];
        ?>
        logToConsole('Jumlah siswa di kelas 14: <?= $test_count; ?>');
        
        <?php
        $test_presensi = $conn->query("SELECT COUNT(*) as total FROM tb_presensi_siswa WHERE tanggal = '".date('Y-m-d')."'");
        $presensi_count = $test_presensi->fetch_assoc()['total'];
        ?>
        logToConsole('Jumlah presensi hari ini: <?= $presensi_count; ?>');
    </script>
</body>
</html>

<?php $conn->close(); ?>