<!DOCTYPE html>
<html>
<head>
    <title>Test Halaman Absen Siswa</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin-ext,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .btn { padding: 10px 15px; margin: 5px; border: none; cursor: pointer; border-radius: 4px; }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .card { border: 1px solid #ddd; border-radius: 4px; margin: 10px 0; padding: 15px; }
        .loading { text-align: center; padding: 20px; }
        .error { color: red; background: #ffe6e6; padding: 10px; border-radius: 4px; }
        .success { color: green; background: #e6ffe6; padding: 10px; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>
    <h1>🧪 Test Halaman Absen Siswa</h1>
    
    <div class="card">
        <h3>Pilih Kelas untuk Test</h3>
        <button class="btn btn-primary" onclick="testGetSiswa(14, '1 Iqro\' 1-3')">Test Kelas 1 Iqro' 1-3</button>
        <button class="btn btn-primary" onclick="testGetSiswa(15, '2 Iqro\' 4-6')">Test Kelas 2 Iqro' 4-6</button>
        <button class="btn btn-primary" onclick="testGetSiswa(16, '3 Al-quran')">Test Kelas 3 Al-quran</button>
    </div>
    
    <div class="card">
        <h3>Tanggal</h3>
        <input type="date" id="tanggal" value="<?= date('Y-m-d'); ?>">
        <button class="btn btn-success" onclick="testWithCurrentDate()">Test dengan Tanggal Sekarang</button>
    </div>
    
    <div id="result"></div>
    
    <script>
        function testGetSiswa(idKelas, kelas) {
            const tanggal = document.getElementById('tanggal').value;
            const resultDiv = document.getElementById('result');
            
            resultDiv.innerHTML = '<div class="loading">⏳ Sedang mengambil data...</div>';
            
            // Simulasikan AJAX request
            fetch('test_ajax_simulation.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `kelas=${encodeURIComponent(kelas)}&id_kelas=${idKelas}&tanggal=${tanggal}`
            })
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = '<div class="success">✅ Response diterima!</div>';
                resultDiv.innerHTML += '<h3>Hasil Response:</h3>';
                resultDiv.innerHTML += '<div style="border: 1px solid #ccc; padding: 10px; background: #f9f9f9; max-height: 400px; overflow: auto;">';
                resultDiv.innerHTML += data.length > 1000 ? data.substring(0, 1000) + '...' : data;
                resultDiv.innerHTML += '</div>';
            })
            .catch(error => {
                resultDiv.innerHTML = '<div class="error">❌ Error: ' + error.message + '</div>';
            });
        }
        
        function testWithCurrentDate() {
            document.getElementById('tanggal').value = new Date().toISOString().split('T')[0];
        }
    </script>
</body>
</html>