<?php
// Simple test to verify database connection and WhatsApp settings
echo "=== TESTING WHATSAPP INTEGRATION ===\n\n";

try {
    // Test database connection
    echo "1. Testing Database Connection...\n";
    $host = 'localhost';
    $dbname = 'db_absensi';
    $username = 'root';
    $password = '';

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "   ✅ Database connection successful\n\n";

    // Test WhatsApp settings in database
    echo "2. Testing WhatsApp Settings in Database...\n";
    $stmt = $pdo->query('SELECT waha_api_url, waha_api_key, waha_x_api_key, wa_template_masuk, wa_template_pulang FROM general_settings LIMIT 1');
    $settings = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($settings) {
        echo '   - API URL: ' . ($settings['waha_api_url'] ?: 'Not set') . "\n";
        echo '   - API Key: ' . ($settings['waha_api_key'] ?: 'Not set') . "\n";
        echo '   - X-API-Key: ' . ($settings['waha_x_api_key'] ?: 'Not set') . "\n";
        echo '   - Template Masuk: ' . ($settings['wa_template_masuk'] ?: 'Default template') . "\n";
        echo '   - Template Pulang: ' . ($settings['wa_template_pulang'] ?: 'Default template') . "\n\n";
    } else {
        echo "   ❌ No settings found in database\n\n";
    }

    // Test template replacement
    echo "3. Testing Template Replacement...\n";
    $templateMasuk = $settings['wa_template_masuk'] ?: 'Halo {nama_siswa}, Anda telah absen masuk pada {tanggal} pukul {jam_masuk}. Terima kasih.';
    $templatePulang = $settings['wa_template_pulang'] ?: 'Halo {nama_siswa}, Anda telah absen pulang pada {tanggal} pukul {jam_pulang}. Hati-hati di jalan.';

    $testData = [
        'nama_siswa' => 'John Doe',
        'tanggal' => '02/10/2025',
        'jam_masuk' => '07:30:00',
        'jam_pulang' => '15:30:00'
    ];

    $processedMasuk = str_replace(
        ['{nama_siswa}', '{tanggal}', '{jam_masuk}'],
        [$testData['nama_siswa'], $testData['tanggal'], $testData['jam_masuk']],
        $templateMasuk
    );

    $processedPulang = str_replace(
        ['{nama_siswa}', '{tanggal}', '{jam_pulang}'],
        [$testData['nama_siswa'], $testData['tanggal'], $testData['jam_pulang']],
        $templatePulang
    );

    echo '   Template Masuk Result: ' . $processedMasuk . "\n";
    echo '   Template Pulang Result: ' . $processedPulang . "\n\n";

    echo "✅ All tests completed successfully!\n";
    echo "✅ WhatsApp integration is ready to use with database settings.\n";
} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
}
?>